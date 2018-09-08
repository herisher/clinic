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

            /*
            //edit button
            $row[] = "<a href=\"".base_url()."system/transaction/edit/".$aRow['transaction_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."system/checkup/edit/".$aRow['transaction_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['transaction_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."system/checkup/delete/".$aRow['transaction_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."system/checkup/delete/".$aRow['transaction_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['transaction_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            */
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
    
    /**
      * /cashier_index
      */
    private function cashier_index($output, $rResult, $iColumnCount, $aColumns) {
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
                elseif($aColumns[$i] == 'transaction_no') {
                    $row[] = "<a href=\"".base_url()."system/cashier/detail/".$aRow['transaction_id']."\" onclick=\"window.open('".base_url()."system/cashier/detail/".$aRow['transaction_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\">".$aRow[ $aColumns[$i] ]."</a>";
                }
                elseif($aColumns[$i] == 'total_biaya') {
                    $row[] = number_format($aRow[ $aColumns[$i] ]);
                }
                elseif($aColumns[$i] == 'payment_status') {
                    $row[] = $this->Logic_transaction->static_status($aRow[ $aColumns[$i] ]);
                }
                else {
                    $row[] = $aRow[ $aColumns[$i] ];
                }
            }

            /*
            //edit button
            $row[] = "<a href=\"".base_url()."system/transaction/edit/".$aRow['transaction_id']."\" class=\"btn btn-primary btn-xs\" onclick=\"window.open('".base_url()."system/checkup/edit/".$aRow['transaction_id']."', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;\" id=\"".$aRow['transaction_id']."\" ><span class=\"glyphicon glyphicon-pencil\"></span></a>";
            
            //delete button
            $row[] = "<a href=\"".base_url()."system/checkup/delete/".$aRow['transaction_id']."\" class=\"btn btn-danger btn-xs\" onclick=\"window.open('".base_url()."system/checkup/delete/".$aRow['transaction_id']."', 'newwindow', 'width=900,height=350,left=400,top=250 ,scrollbars=yes'); return false;\" id=\"".$aRow['transaction_id']."\"><span class=\"glyphicon glyphicon-remove\"></span></a>";
            */
            $output['aaData'][] = $row;
        }
        
        return $output;
    }
}