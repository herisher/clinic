<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Report extends MY_Controller {
    
    public function transaction_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(1,1);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        //default by year
        $datas = $this->db->query("SELECT transaction_id, YEAR(transaction_date) as transaction_date, YEAR(transaction_date) as transaction_date_disp, COUNT(patient_id) as qty, SUM( total_biaya ) as total_idr FROM dtb_transaction WHERE is_cashier = 1 GROUP BY YEAR(transaction_date);")->result_array();
        $filter = "";
        
        if ($this->input->is_get()) {
            if ( $this->input->get("filter_by") == "daily" ) {
                $datas = $this->db->query("SELECT transaction_id, transaction_date as transaction_date_disp, transaction_date as transaction_date, COUNT(patient_id) as qty, SUM( total_biaya ) as total_idr FROM `dtb_transaction` WHERE is_cashier = 1 GROUP BY transaction_date")->result_array();
            } elseif ( $this->input->get("filter_by") == "weekly" ) {
                $datas = $this->db->query("SELECT transaction_id, YEARWEEK(transaction_date)+1 as transaction_date, YEARWEEK(transaction_date)+1 as transaction_date_disp, COUNT(patient_id) as qty, SUM( total_biaya ) as total_idr FROM `dtb_transaction` WHERE is_cashier = 1 GROUP BY YEARWEEK(transaction_date)+1;")->result_array();
                
                foreach($datas as &$data){
                    $year = substr($data['transaction_date'],0,4);
                    $week = substr($data['transaction_date'],4,2);
                    $dto = new DateTime();
                    $dto->setISODate($year, $week);
                    $date1 = $dto->format('Y-m-d');
                    $dto->modify('+6 days');
                    $date2 = $dto->format('Y-m-d');
                    $data["transaction_date_disp"] = $date1 . ' ~ ' . $date2;
                }
            } elseif ( $this->input->get("filter_by") == "monthly" ) {
                $datas = $this->db->query("SELECT transaction_id, CONCAT(YEAR(transaction_date),'-',MONTH(transaction_date)) as transaction_date_disp, CONCAT(YEAR(transaction_date),'-',MONTH(transaction_date)) as transaction_date, COUNT( patient_id ) as qty, SUM( total_biaya ) as total_idr FROM dtb_transaction WHERE is_cashier = 1 GROUP BY YEAR(transaction_date),MONTH(transaction_date);")->result_array();
            } elseif ( $this->input->get("filter_by") == "yearly" ) {
                $datas = $this->db->query("SELECT transaction_id, YEAR(transaction_date) as transaction_date_disp, YEAR(transaction_date) as transaction_date, COUNT( patient_id ) as qty, SUM( total_biaya ) as total_idr FROM dtb_transaction WHERE is_cashier = 1 GROUP BY YEAR(transaction_date);")->result_array();
            }
            
            if( $this->input->get("filter_by") != null) {
                $filter = ucfirst($this->input->get("filter_by"));
            } else {
                $filter = "Yearly";
            }
            
            if( $this->input->get("csv") == 1 ) {
                ini_set('memory_limit','-1');
                
                header('Content-type: application/octet-stream');
                if (preg_match("/MSIE 8\.0/", $_SERVER['HTTP_USER_AGENT'])) {
                    header('Content-Disposition: filename=transaction-' . time() . '.csv');
                } else {
                    header('Content-Disposition: attachment; filename=transaction-' . time() . '.csv');
                }
                header('Pragma: public');
                header('Cache-control: public');

                echo '"No","Tanggal Periksa","Jumlah Pasien","Total (Rp)"'."\n";
                $col = array("transaction_id", "transaction_date", "qty", "total_idr");

                $no = 0;
                $total = 0;
                foreach ($datas as $item => $val ) {
                    $cols = array();
                    $no++;
                    
                    foreach( $col as $col_name ) {
                        if( $val[$col_name] ) {
                            if($col_name == 'transaction_id') {
                                array_push($cols, '"'.$no.'"');
                            }
                            else {
                                array_push($cols, '"'.$val[$col_name].'"');
                            }
                        }
                    }
                    $total += $val["total_idr"];
                    echo mb_convert_encoding(join(",", $cols), 'SJIS-win', 'UTF-8') . "\r\n";
                }
                echo '"","","Total (Rp)","' . $total . '"'."\n";
                exit;
            }
        }
        
        $this->load->vars("filter", $filter);
        $this->load->vars("datas",$datas);
        $this->load->view("system/report/transaction");
    }
	
    public function transactiondetail_action()
    {
		$this->load->model('Logic_admin');
		$this->Logic_admin->check_permission(1,1);
		
        $type = strtolower($this->uri->segment(4));
        $transaction_date = $this->uri->segment(5);
        $this->load->vars('transaction_date', $transaction_date);

		if( $type == "daily" ){
			$transaction_detail = $this->db->query("SELECT transaction_id, transaction_no, transaction_date, total_biaya, 
            CASE WHEN payment_status = 0 THEN 'Belum Dibayar' 
            WHEN payment_status = 1 THEN 'Lunas' END AS 'disp_status' 
            FROM dtb_transaction WHERE is_cashier = 1 AND transaction_date = ?", $transaction_date)->result_array();
		} elseif( $type == "weekly" ) {
			$transaction_detail = $this->db->query("SELECT transaction_id, transaction_no, transaction_date, total_biaya, 
            CASE WHEN payment_status = 0 THEN 'Belum Dibayar' 
            WHEN payment_status = 1 THEN 'Lunas' END AS 'disp_status' 
            FROM dtb_transaction sd where is_cashier = 1 AND YEARWEEK(transaction_date)+1 = ?", $transaction_date)->result_array();
            $year = substr($transaction_date,0,4);
            $week = substr($transaction_date,4,2);
            $dto = new DateTime();
            $dto->setISODate($year, $week);
            $date1 = $dto->format('Y-m-d');
            $dto->modify('+6 days');
            $date2 = $dto->format('Y-m-d');
            $data["transaction_date_disp"] = $date1 . ' ~ ' . $date2;
            $transaction_date = $date1 . ' ~ ' . $date2;
		} elseif( $type == "monthly" ) {
			$transaction_detail = $this->db->query("SELECT transaction_id, transaction_no, transaction_date, total_biaya, 
            CASE WHEN payment_status = 0 THEN 'Belum Dibayar' 
            WHEN payment_status = 1 THEN 'Lunas' END AS 'disp_status' 
            FROM dtb_transaction sd where is_cashier = 1 AND CONCAT(YEAR(transaction_date),'-',MONTH(transaction_date)) = ?", $transaction_date)->result_array();
		} elseif( $type == "yearly" ) {
			$transaction_detail = $this->db->query("SELECT transaction_id, transaction_no, transaction_date, total_biaya, 
            CASE WHEN payment_status = 0 THEN 'Belum Dibayar' 
            WHEN payment_status = 1 THEN 'Lunas' END AS 'disp_status' 
            FROM dtb_transaction sd where is_cashier = 1 AND YEAR(transaction_date) = ?", $transaction_date)->result_array();
		}
		
        if ($this->input->is_post()) {
            if( $this->input->post("csv") == 1 ) {
                ini_set('memory_limit','-1');
                
                header('Content-type: application/octet-stream');
                if (preg_match("/MSIE 8\.0/", $_SERVER['HTTP_USER_AGENT'])) {
                    header('Content-Disposition: filename=transaction-' . time() . '.csv');
                } else {
                    header('Content-Disposition: attachment; filename=transaction-' . time() . '.csv');
                }
                header('Pragma: public');
                header('Cache-control: public');

                echo '"No","No. Transaksi","Tanggal Periksa","Status Pembayaran","Total (Rp)"'."\n";
                $col = array("transaction_id", "transaction_no", "transaction_date", "disp_status", "total_biaya");

                $no = 0;
                $total = 0;
                foreach ($transaction_detail as $item => $val ) {
                    $cols = array();
                    $no++;
                    
                    foreach( $col as $col_name ) {
                        if( $val[$col_name] ) {
                            if($col_name == 'transaction_id') {
                                array_push($cols, '"'.$no.'"');
                            }
                            else {
                                array_push($cols, '"'.$val[$col_name].'"');
                            }
                        }
                    }
                    $total += $val["total_biaya"];
                    echo mb_convert_encoding(join(",", $cols), 'SJIS-win', 'UTF-8') . "\r\n";
                }
                echo '"","","","Total (Rp)","' . $total . '"'."\n";
                exit;
            }
        }
        
        $filter = $this->uri->segment(4) . '   ' . $transaction_date;
        
		$this->load->vars("type", $type);
		$this->load->vars("transaction_date", $this->uri->segment(5));
		$this->load->vars("filter", $filter);
        $this->load->vars('transaction_detail', $transaction_detail);
        $this->load->view('system/report/transaction2.php');
    }
    
    public function income_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(1,2);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->load->model('Logic_doctor');
        $this->load->vars('doctor_option', $this->Logic_doctor->get_all_by_id());

        $query = "SELECT dt.*, dd.doctor_name FROM dtb_transaction dt JOIN dtb_doctor dd ON dt.doctor_id = dd.doctor_id WHERE is_cashier = 1";
        
        $filter = "";
        
        if ($this->input->is_post()) {
            if( $this->input->post("reset") == 1 ) {
                redirect(current_url());
            } else {
                if( $this->input->post("doctor_id") ){
                    $query .= " AND dt.doctor_id = " . $this->input->post("doctor_id");
                }
                if( $this->input->post("transaction_date_from") && $this->input->post("transaction_date_to") ){
                    $query .= " AND transaction_date between '" . $this->input->post("transaction_date_from") . "' AND '" . $this->input->post("transaction_date_to") . "'";
                } elseif( $this->input->post("transaction_date_from") && !$this->input->post("transaction_date_to") ) {
                    $query .= " AND transaction_date between '" . $this->input->post("transaction_date_from") . "' AND '" . date("Y-m-d") . "'";
                } elseif( !$this->input->post("transaction_date_from") && $this->input->post("transaction_date_to") ) {
                    $query .= " AND transaction_date < '" . $this->input->post("transaction_date_to") . "'";
                }
            }
            
            if( $this->input->post("csv") == 1 ) {
                ini_set('memory_limit','-1');
                
                header('Content-type: application/octet-stream');
                if (preg_match("/MSIE 8\.0/", $_SERVER['HTTP_USER_AGENT'])) {
                    header('Content-Disposition: filename=income-' . time() . '.csv');
                } else {
                    header('Content-Disposition: attachment; filename=income-' . time() . '.csv');
                }
                header('Pragma: no-cache');
                header('Cache-control: public');

                echo '"No","Tanggal Periksa","Nama Dokter","Total (Rp)"'."\n";
                $col = array("transaction_id", "transaction_date", "doctor_name", "biaya_medis");

                $models = $this->db->query($query)->result_array();
        
                $no = 0;
                $total = 0;
                foreach ($models as $item => $val ) {
                    $cols = array();
                    $no++;
                    
                    foreach( $col as $col_name ) {
                        if( $val[$col_name] ) {
                            if($col_name == 'transaction_id') {
                                array_push($cols, '"'.$no.'"');
                            }
                            else {
                                array_push($cols, '"'.$val[$col_name].'"');
                            }
                        }
                    }
                    $total += $val["biaya_medis"];
                    echo mb_convert_encoding(join(",", $cols), 'SJIS-win', 'UTF-8') . "\r\n";
                }
                echo '"","","Total (Rp)","' . $total . '"'."\n";
                exit;
            }
        }

        $datas = $this->db->query($query)->result_array();
        
        $this->load->vars("filter", $filter);
        $this->load->vars("datas",$datas);
        $this->load->view("system/report/income");
    }
    
    public function anamnesis_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(1,2);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $this->load->model('Logic_doctor');
        $this->load->vars('doctor_option', $this->Logic_doctor->get_all_by_id());

        $this->load->model('Logic_patient');
        $this->load->vars('patient_option', $this->Logic_patient->get_all_by_id());

        $query = "SELECT dt.*, dd.doctor_name, dp.patient_name FROM dtb_transaction dt JOIN dtb_doctor dd ON dt.doctor_id = dd.doctor_id JOIN dtb_patient dp ON dt.patient_id = dp.patient_id WHERE is_cashier = 1";
        
        $filter = "";
        
        if ($this->input->is_post()) {
            if( $this->input->post("reset") == 1 ) {
                redirect(current_url());
            } else {
                if( $this->input->post("doctor_id") ){
                    $query .= " AND dt.doctor_id = " . $this->input->post("doctor_id");
                }
                if( $this->input->post("patient_id") ){
                    $query .= " AND dt.patient_id = " . $this->input->post("patient_id");
                }
                if( $this->input->post("diagnosa") ){
                    $query .= " AND diagnosa LIKE '%" . $this->input->post("diagnosa") . "%'";
                }
            }
            
            if( $this->input->post("csv") == 1 ) {
                ini_set('memory_limit','-1');
                
                header('Content-type: application/octet-stream');
                if (preg_match("/MSIE 8\.0/", $_SERVER['HTTP_USER_AGENT'])) {
                    header('Content-Disposition: filename=anamnesis-' . time() . '.csv');
                } else {
                    header('Content-Disposition: attachment; filename=anamnesis-' . time() . '.csv');
                }
                header('Pragma: public');
                header('Cache-control: public');

                echo '"No","Nama Pasien","Nama Dokter","Diagnosa"'."\n";
                $col = array("transaction_id", "patient_name", "doctor_name", "diagnosa");

                $models = $this->db->query($query)->result_array();
        
                $no = 0;
                foreach ($models as $item => $val ) {
                    $cols = array();
                    $no++;
                    
                    foreach( $col as $col_name ) {
                        if( $val[$col_name] ) {
                            if($col_name == 'transaction_id') {
                                array_push($cols, '"'.$no.'"');
                            }
                            else {
                                array_push($cols, '"'.$val[$col_name].'"');
                            }
                        }
                    }
                    
                    echo mb_convert_encoding(join(",", $cols), 'SJIS-win', 'UTF-8') . "\r\n";
                }
                exit;
            }
        }

        $datas = $this->db->query($query)->result_array();
        
        $this->load->vars("filter", $filter);
        $this->load->vars("datas",$datas);
        $this->load->view("system/report/anamnesis");
    }
}