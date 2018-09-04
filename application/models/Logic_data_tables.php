<?php
class Logic_data_tables extends CI_Model{

    public function ajax_data_tables($sqlQuery, $sqlCountQuery, $arrColumns, $dbcolumns, $type, $custom_filter = ''){
        $aColumns = $arrColumns;
        $input = $this->input->post();

        /**
         * Paging
         */
        $sLimit = "";
        if ( isset( $input['iDisplayStart'] ) && $input['iDisplayLength'] != '-1' ) {
            $sLimit = " LIMIT ".intval( $input['iDisplayStart'] ).", ".intval( $input['iDisplayLength'] );
        }

        /**
         * Ordering
         */
        $aOrderingRules = array();
        if ( isset( $input['iSortCol_0'] ) ) {
            $iSortingCols = intval( $input['iSortingCols'] );
            for ( $i=0 ; $i<$iSortingCols ; $i++ ) {
                if ( $input[ 'bSortable_'.intval($input['iSortCol_'.$i]) ] == 'true' ) {
                    $aOrderingRules[] = "`".$aColumns[ intval( $input['iSortCol_'.$i] ) ]."` ".($input['sSortDir_'.$i]==='asc' ? 'asc' : 'desc');
                    //$aOrderingRules[] = $aColumns[ intval( $input['iSortCol_'.$i] ) ].($input['sSortDir_'.$i]===' asc ' ? ' asc ' : ' desc ');
                }
            }
        }

        if (!empty($aOrderingRules)) {
            $sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
        } else {
            $sOrder = "";
        }

        /**
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        //$iColumnCount = count($aColumns);
        $iColumnCount = count($dbcolumns);

        if( !$custom_filter ) {
            if ( isset($input['sSearch']) && $input['sSearch'] != "" ) {
                $aFilteringRules = array();
                for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                    if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' ) {
                        //$aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%". $input['sSearch'] ."%'";
                        //$aFilteringRules[] = $aColumns[$i]." LIKE '%". $input['sSearch'] ."%'";
                        $aFilteringRules[] = $dbcolumns[$i]." LIKE '%". $input['sSearch'] ."%'";
                    }
                }
                if (!empty($aFilteringRules)) {
                    $aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
                }
            }

            // Individual column filtering
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if ( isset($input['bSearchable_'.$i]) && $input['bSearchable_'.$i] == 'true' && $input['sSearch_'.$i] != '' ) {
                    //$aFilteringRules[] = "`".$aColumns[$i]."` LIKE '%". $input['sSearch_'.$i] ."%'";
                    $aFilteringRules[] = $dbcolumns[$i]." LIKE '%". $input['sSearch_'.$i] ."%'";
                }
            }
        } else {
            $aFilteringRules = $custom_filter;
        }

        if (!empty($aFilteringRules)) {
            //$sWhere = " WHERE ".implode(" AND ", $aFilteringRules);
            $sWhere = " AND " . implode(" AND ", $aFilteringRules);
        } else {
            $sWhere = "";
        }

        /**
         * SQL queries
         * Get data to display
         */
        $aQueryColumns = array();
        foreach ($aColumns as $col) {
            if ($col != ' ') {
                $aQueryColumns[] = $col;
            }
        }

        //$sQuery = "SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", $aQueryColumns)."` FROM `".$sTable."`".$sWhere.$sOrder.$sLimit;
        $sQuery = str_replace("SELECT", "SELECT SQL_CALC_FOUND_ROWS", $sqlQuery);  //inject sql_calc_found_rows
        $sQuery = $sQuery . " $sWhere $sOrder $sLimit";

        $rResult = $this->db->query( $sQuery );

        // Data set length after filtering
        $sQuery = "SELECT FOUND_ROWS() as total";
        $rResultFilterTotal = $this->db->query( $sQuery );
        //list($iFilteredTotal) = $rResultFilterTotal->result_array();
        $iFilteredTotal = $rResultFilterTotal->row()->total;

        // Total data set length
        //$sQuery = "SELECT COUNT(`".$sIndexColumn."`) FROM `".$sTable."`";
        $sQuery = $sqlCountQuery;
        $rResultTotal = $this->db->query( $sQuery );
        //list($iTotal) = $rResultTotal->result_array();
        $iTotal = $rResultTotal->row()->total;

        /**
         * Output
         */
        $output = array(
            "sEcho"                => intval($input['sEcho']),
            "iTotalRecords"        => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData"               => array(),
        );

        //Generate table based on type
        $output = $this->$type($output, $rResult, $iColumnCount, $aColumns);

        return json_encode( $output );
    }
    
    /**
      * /patient_index
      */
    private function patient_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_patient');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'patient_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'anamnesis') {
                    $row[] = "<a href=\"".base_url()."system/patient/detail/".$aRow['patient_id']."\" onclick=\"window.open('".base_url()."system/patient/detail/".$aRow['patient_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."system/patient/edit/".$aRow['patient_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."system/patient/edit/".$aRow['patient_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['patient_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."system/patient/delete/".$aRow['patient_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."system/patient/delete/".$aRow['patient_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['patient_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
        
    /**
      * /doctor_index
      */
    private function doctor_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_doctor');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'doctor_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'doctor_name') {
                    $row[] = "<a href=\"".base_url()."system/doctor/detail/".$aRow['doctor_id']."\" onclick=\"window.open('".base_url()."system/doctor/detail/".$aRow['doctor_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."system/doctor/edit/".$aRow['doctor_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."system/doctor/edit/".$aRow['doctor_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['doctor_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."system/doctor/delete/".$aRow['doctor_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."system/doctor/delete/".$aRow['doctor_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['doctor_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /transaction_index
      */
    private function transaction_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_transaction');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'transaction_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'anamnesis') {
                    $row[] = "<a href=\"".base_url()."system/checkup/detail/".$aRow['transaction_id']."\" onclick=\"window.open('".base_url()."system/checkup/detail/".$aRow['transaction_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."system/transaction/edit/".$aRow['transaction_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."system/checkup/edit/".$aRow['transaction_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['transaction_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."system/checkup/delete/".$aRow['transaction_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."system/checkup/delete/".$aRow['transaction_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['transaction_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    
    
    
    /**
      * /material_index
      */
    private function material_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_material');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'material_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'material_fileid' && ($aRow[ $aColumns[$i] ] !== null)) {
                    $row[] = "<img src=\"". base_url() . "upload/material/" . $aRow[ $aColumns[$i] ] . "\" alt=\"Material image\" height=\"50px\" width=\"50px\">";
                }
                elseif($aColumns[$i] == 'material_name' ) {
                    $row[] = "<a href=\"".base_url()."admin/material/detail/".$aRow['material_id']."\" onclick=\"window.open('".base_url()."admin/material/detail/".$aRow['material_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/material/edit/".$aRow['material_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/material/edit/".$aRow['material_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['material_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/material/delete/".$aRow['material_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/material/delete/".$aRow['material_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['material_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /acc_index
      */
    private function acc_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_acc');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'acc_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'acc_fileid' && ($aRow[ $aColumns[$i] ] !== null)) {
                    $row[] = "<img src=\"". base_url() . "upload/acc/" . $aRow[ $aColumns[$i] ] . "\" alt=\"Accessories image\" height=\"50px\" width=\"50px\">";
                }
                elseif($aColumns[$i] == 'acc_name') {
                    $row[] = "<a href=\"".base_url()."admin/acc/detail/".$aRow['acc_id']."\" onclick=\"window.open('".base_url()."admin/acc/detail/".$aRow['acc_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/acc/edit/".$aRow['acc_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/acc/edit/".$aRow['acc_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['acc_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/acc/delete/".$aRow['acc_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/acc/delete/".$aRow['acc_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['acc_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /pattern_index
      */
    private function pattern_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_pattern');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'pattern_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'pattern_fileid' && ($aRow[ $aColumns[$i] ] !== null)) {
                    $row[] = "<img src=\"". base_url() . "upload/pattern/" . $aRow[ $aColumns[$i] ] . "\" alt=\"Pattern image\" height=\"50px\" width=\"50px\">";
                }
                elseif($aColumns[$i] == 'pattern_code') {
                    $row[] = "<a href=\"".base_url()."admin/pattern/detail/".$aRow['pattern_id']."\" onclick=\"window.open('".base_url()."admin/pattern/detail/".$aRow['pattern_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/pattern/edit/".$aRow['pattern_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/pattern/edit/".$aRow['pattern_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['pattern_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/pattern/delete/".$aRow['pattern_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/pattern/delete/".$aRow['pattern_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['pattern_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /material_supplier_index
      */
    private function material_supplier_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_material_supplier');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'material_supplier_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'material_supplier_name') {
                    $row[] = "<a href=\"".base_url()."admin/material-supplier/detail/".$aRow['material_supplier_id']."\" onclick=\"window.open('".base_url()."admin/material-supplier/detail/".$aRow['material_supplier_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/material-supplier/edit/".$aRow['material_supplier_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/material-supplier/edit/".$aRow['material_supplier_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['material_supplier_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/material-supplier/delete/".$aRow['material_supplier_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/material-supplier/delete/".$aRow['material_supplier_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['material_supplier_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /acc_supplier_index
      */
    private function acc_supplier_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_acc_supplier');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'acc_supplier_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'acc_supplier_name') {
                    $row[] = "<a href=\"".base_url()."admin/acc-supplier/detail/".$aRow['acc_supplier_id']."\" onclick=\"window.open('".base_url()."admin/acc-supplier/detail/".$aRow['acc_supplier_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/acc-supplier/edit/".$aRow['acc_supplier_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/acc-supplier/edit/".$aRow['acc_supplier_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['acc_supplier_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/acc-supplier/delete/".$aRow['acc_supplier_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/acc-supplier/delete/".$aRow['acc_supplier_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['acc_supplier_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /cmt_index
      */
    private function cmt_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_cmt');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'cmt_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'cmt_name') {
                    $row[] = "<a href=\"".base_url()."admin/cmt/detail/".$aRow['cmt_id']."\" onclick=\"window.open('".base_url()."admin/cmt/detail/".$aRow['cmt_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/cmt/edit/".$aRow['cmt_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/cmt/edit/".$aRow['cmt_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['cmt_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/cmt/delete/".$aRow['cmt_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/cmt/delete/".$aRow['cmt_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['cmt_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /expedition_index
      */
    private function expedition_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_expedition');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'expedition_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'expedition_name') {
                    $row[] = "<a href=\"".base_url()."admin/expedition/detail/".$aRow['expedition_id']."\" onclick=\"window.open('".base_url()."admin/expedition/detail/".$aRow['expedition_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/expedition/edit/".$aRow['expedition_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/expedition/edit/".$aRow['expedition_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['expedition_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/expedition/delete/".$aRow['expedition_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/expedition/delete/".$aRow['expedition_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['expedition_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /place_index
      */
    private function place_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_place');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'place_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'place_name') {
                    $row[] = "<a href=\"".base_url()."admin/place/detail/".$aRow['place_id']."\" onclick=\"window.open('".base_url()."admin/place/detail/".$aRow['place_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                elseif($aColumns[$i] == 'place_type') {
                    $row[] = $this->Logic_place->get_type($aRow[ $aColumns[$i] ]);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/place/edit/".$aRow['place_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/place/edit/".$aRow['place_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['place_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/place/delete/".$aRow['place_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/place/delete/".$aRow['place_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['place_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /material_purchase_index
      */
    private function material_purchase_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_material_purchase');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'material_purchase_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'material_purchase_no') {
                    $row[] = "<a href=\"".base_url()."admin/material-purchase/detail/".$aRow['material_purchase_id']."\" onclick=\"window.open('".base_url()."admin/material-purchase/detail/".$aRow['material_purchase_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                elseif($aColumns[$i] == 'total_weight' || $aColumns[$i] == 'total_roll') {
                    $row[] = number_format($aRow[ $aColumns[$i] ],2);
                }
                elseif($aColumns[$i] == 'total') {
                    $row[] = number_format($aRow[ $aColumns[$i] ]);
                }
                elseif($aColumns[$i] == 'payment_status') {
                    $row[] = $this->Logic_material_purchase->get_status($aRow[ $aColumns[$i] ]);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            
            //edit button
            if( $aRow['payment_status'] == 1) { //unpaid
                $row[] = "<a href=\"".base_url()."admin/material-purchase/edit/".$aRow['material_purchase_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/material-purchase/edit/".$aRow['material_purchase_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['material_purchase_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            } else {
                $row[] = "";
            }
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /acc_purchase_index
      */
    private function acc_purchase_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_acc_purchase');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'acc_purchase_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'acc_purchase_no') {
                    $row[] = "<a href=\"".base_url()."admin/acc-purchase/detail/".$aRow['acc_purchase_id']."\" onclick=\"window.open('".base_url()."admin/acc-purchase/detail/".$aRow['acc_purchase_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                elseif($aColumns[$i] == 'qty') {
                    $row[] = number_format($aRow[ $aColumns[$i] ],2);
                }
                elseif($aColumns[$i] == 'total') {
                    $row[] = number_format($aRow[ $aColumns[$i] ]);
                }
                elseif($aColumns[$i] == 'payment_status') {
                    $row[] = $this->Logic_acc_purchase->get_status($aRow[ $aColumns[$i] ]);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            
            //edit button
            if( $aRow['payment_status'] == 1) { //unpaid
                $row[] = "<a href=\"".base_url()."admin/acc-purchase/edit/".$aRow['acc_purchase_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/acc-purchase/edit/".$aRow['acc_purchase_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['acc_purchase_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            } else {
                $row[] = "";
            }
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /material_reduction_index
      */
    private function material_reduction_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_material_reduction');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'material_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'material_weight') {
                    $row[] = number_format($aRow[ $aColumns[$i] ],2);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }

    /**
      * /acc_reduction_index
      */
    private function acc_reduction_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_acc_reduction');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'acc_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'qty') {
                    $row[] = number_format($aRow[ $aColumns[$i] ],2);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /serial_index
      */
    private function serial_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_pattern');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'serial_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'serial_code') {
                    $row[] = "<a href=\"".base_url()."admin/serial/detail/".$aRow['serial_id']."\" onclick=\"window.open('".base_url()."admin/serial/detail/".$aRow['serial_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                elseif($aColumns[$i] == 'pattern_id') {
                    $row[] = $this->Logic_pattern->get_all_by_id($aRow[ $aColumns[$i] ]);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/serial/edit/".$aRow['serial_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/serial/edit/".$aRow['serial_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['serial_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/serial/delete/".$aRow['serial_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/serial/delete/".$aRow['serial_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['serial_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /product_index
      */
    private function product_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_pattern');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'product_id') {
                    $row[] = $n;
                }
                elseif($aColumns[$i] == 'product_fileid' && ($aRow[ $aColumns[$i] ] !== null)) {
                    $row[] = "<img src=\"". base_url() . "upload/product/" . $aRow[ $aColumns[$i] ] . "\" alt=\"Product image\" height=\"50px\" width=\"50px\">";
                }
                elseif($aColumns[$i] == 'product_code') {
                    $row[] = "<a href=\"".base_url()."admin/product/detail/".$aRow['product_id']."\" onclick=\"window.open('".base_url()."admin/product/detail/".$aRow['product_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/product/edit/".$aRow['product_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/product/edit/".$aRow['product_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['product_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/product/delete/".$aRow['product_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/product/delete/".$aRow['product_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['product_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /product_type_index
      */
    private function product_type_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_product_type');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'product_type_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'product_type_name') {
                    $row[] = "<a href=\"".base_url()."admin/product-type/detail/".$aRow['product_type_id']."\" onclick=\"window.open('".base_url()."admin/product-type/detail/".$aRow['product_type_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/product-type/edit/".$aRow['product_type_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/product-type/edit/".$aRow['product_type_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['product_type_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/product-type/delete/".$aRow['product_type_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/product-type/delete/".$aRow['product_type_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['product_type_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /product_unit_index
      */
    private function product_unit_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_product_unit');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'product_unit_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'product_unit_name') {
                    $row[] = "<a href=\"".base_url()."admin/product-unit/detail/".$aRow['product_unit_id']."\" onclick=\"window.open('".base_url()."admin/product-unit/detail/".$aRow['product_unit_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/product-unit/edit/".$aRow['product_unit_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/product-unit/edit/".$aRow['product_unit_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['product_unit_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/product-unit/delete/".$aRow['product_unit_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/product-unit/delete/".$aRow['product_unit_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['product_unit_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /stock_index
      */
    private function stock_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_stock');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            $stock = $this->db->query("SELECT serial_id FROM dtb_stock WHERE stock_id = ? LIMIT 1", $aRow['stock_id'])->row_array();
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'stock_id') {
                    $row[] = $n;
                }
                elseif($aColumns[$i] == 'product_fileid' && ($aRow[ $aColumns[$i] ] !== null)) {
                    $row[] = "<img src=\"". base_url() . "upload/product/" . $aRow[ $aColumns[$i] ] . "\" alt=\"Product image\" height=\"50px\" width=\"50px\">";
                }
                elseif($aColumns[$i] == 'sku') {
                    $row[] = "<a href=\"".base_url()."admin/stock/detail/".$aRow['stock_id']."\" onclick=\"window.open('".base_url()."admin/stock/detail/".$aRow['stock_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                elseif($aColumns[$i] == 'serial_code') {
                    $row[] = "<a href=\"".base_url()."admin/serial/edit/".$stock['serial_id']."\" onclick=\"window.open('".base_url()."admin/serial/edit/".$stock['serial_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            //edit button
            $row[] = "<a href=\"".base_url()."admin/stock/edit/".$aRow['stock_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/stock/edit/".$aRow['stock_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['stock_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/stock/delete/".$aRow['stock_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/stock/delete/".$aRow['stock_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['stock_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /moving_index
      */
    private function moving_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_moving');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'moving_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'from_place_name') {
                    $row[] = "<a href=\"".base_url()."admin/moving/detail/".$aRow['moving_id']."\" onclick=\"window.open('".base_url()."admin/moving/detail/".$aRow['moving_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            /*

            //edit button
            $row[] = "<a href=\"".base_url()."admin/moving/edit/".$aRow['moving_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/moving/edit/".$aRow['moving_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['moving_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."admin/moving/delete/".$aRow['moving_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."admin/moving/delete/".$aRow['moving_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['moving_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            */
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /sales_index
      */
    private function sales_index($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_sales');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'sales_id') {
                    $row[] = $n;
                    //$row[] = $aRow[ $aColumns[$i] ];
                }
                elseif($aColumns[$i] == 'sales_no') {
                    $row[] = "<a href=\"".base_url()."admin/sales/detail/".$aRow['sales_id']."\" onclick=\"window.open('".base_url()."admin/sales/detail/".$aRow['sales_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                elseif($aColumns[$i] == 'payment_status') {
                    $row[] = $this->Logic_sales->get_status($aRow[ $aColumns[$i] ]);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            
            //edit button
            if( $aRow['payment_status'] == 1) { //unpaid
                $row[] = "<a href=\"".base_url()."admin/sales/edit/".$aRow['sales_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."admin/sales/edit/".$aRow['sales_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['sales_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            } else {
                $row[] = "";
            }
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /sales_detail
      */
    private function sales_detail($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_sales');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'sales_detail_id') {
                    $row[] = $n;
                }
                elseif($aColumns[$i] == 'qty') {
                    $row[] = number_format($aRow[ $aColumns[$i] ], 2);
                }
                elseif($aColumns[$i] == 'selling_price' || $aColumns[$i] == 'discount' || $aColumns[$i] == 'total') {
                    $row[] = number_format($aRow[ $aColumns[$i] ]);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /material_purchase_detail
      */
    private function material_purchase_detail($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_material_purchase');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'material_purchase_detail_id') {
                    $row[] = $n;
                }
                elseif($aColumns[$i] == 'roll_amount' || $aColumns[$i] == 'material_width' || $aColumns[$i] == 'material_weight') {
                    $row[] = number_format($aRow[ $aColumns[$i] ], 2);
                }
                elseif($aColumns[$i] == 'price' || $aColumns[$i] == 'discount' || $aColumns[$i] == 'total') {
                    $row[] = number_format($aRow[ $aColumns[$i] ]);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /acc_purchase_detail
      */
    private function acc_purchase_detail($output, $rResult, $iColumnCount, $aColumns) {
        $this->load->model('Logic_acc_purchase');
        
        //Incremental number for index
        $n = 0;
        
        foreach ($rResult->result_array() as $aRow){
            $row = array();
            $n++;
            
            for ( $i=0 ; $i<$iColumnCount ; $i++ ) {
                if($aColumns[$i] == 'acc_purchase_detail_id') {
                    $row[] = $n;
                }
                elseif($aColumns[$i] == 'qty') {
                    $row[] = number_format($aRow[ $aColumns[$i] ], 2);
                }
                elseif($aColumns[$i] == 'price' || $aColumns[$i] == 'discount' || $aColumns[$i] == 'total') {
                    $row[] = number_format($aRow[ $aColumns[$i] ]);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }
            
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
}