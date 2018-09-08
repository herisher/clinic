<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Report extends MY_Controller {
    
    public function transaction_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(1,1);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        //default by year
        $datas = $this->db->query("SELECT YEAR(transaction_date) as transaction_date, COUNT(patient_id) as qty, SUM( total_biaya ) as total_idr FROM dtb_transaction GROUP BY YEAR(transaction_date);")->result_array();
        $filter = "";
        
        if ($this->input->is_get()) {
            if ( $this->input->get("filter_by") == "daily" ) {
                $datas = $this->db->query("SELECT transaction_date as transaction_date, COUNT(patient_id) as qty, SUM( total_biaya ) as total_idr FROM `dtb_transaction` GROUP BY transaction_date")->result_array();
            } elseif ( $this->input->get("filter_by") == "weekly" ) {
                $datas = $this->db->query("SELECT YEARWEEK(transaction_date) as transaction_date, COUNT(patient_id) as qty, SUM( total_biaya ) as total_idr FROM `dtb_transaction` GROUP BY YEARWEEK(transaction_date);")->result_array();
                
                foreach($datas as &$data){
                    $date1 = date( "Y-m-d", strtotime(substr($data["transaction_date"],0,4)."W".substr($data["transaction_date"],4,2)."0") );
                    $date2 = date( "Y-m-d", strtotime(substr($data["transaction_date"],0,4)."W".substr($data["transaction_date"],4,2)."6") );
                    $data["transaction_date"] = $date1 . ' ~ ' . $date2;
                }
            } elseif ( $this->input->get("filter_by") == "monthly" ) {
                $datas = $this->db->query("SELECT CONCAT(YEAR(transaction_date),'-',MONTH(transaction_date)) as transaction_date, COUNT( patient_id ) as qty, SUM( total_biaya ) as total_idr FROM dtb_transaction GROUP BY YEAR(transaction_date),MONTH(transaction_date);")->result_array();
            } elseif ( $this->input->get("filter_by") == "yearly" ) {
                $datas = $this->db->query("SELECT YEAR(transaction_date) as transaction_date, COUNT( patient_id ) as qty, SUM( total_biaya ) as total_idr FROM dtb_transaction GROUP BY YEAR(transaction_date);")->result_array();
            }
            
            if( $this->input->get("filter_by") != null) {
                $filter = ucfirst($this->input->get("filter_by"));
            } else {
                $filter = "Yearly";
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
		
        $filter = $this->uri->segment(4) . '   ' . $this->uri->segment(5);
        $type = strtolower($this->uri->segment(4));
        $transaction_date = $this->uri->segment(5);
        $this->load->vars('transaction_date', $transaction_date);

		if( $type == "daily" ){
			$transaction_detail = $this->db->query("SELECT transaction_no, transaction_date, total_biaya, 
            CASE WHEN payment_status = 0 THEN 'Belum Dibayar' 
            WHEN payment_status = 1 THEN 'Lunas' END AS 'disp_status' 
            FROM dtb_transaction where transaction_date = ?", $transaction_date)->result_array();
		} elseif( $type == "weekly" ) {
			$transaction_detail = $this->db->query("SELECT transaction_no, transaction_date, total_biaya, 
            CASE WHEN payment_status = 0 THEN 'Belum Dibayar' 
            WHEN payment_status = 1 THEN 'Lunas' END AS 'disp_status' 
            FROM dtb_transaction sd where YEARWEEK(transaction_date) = ?", $transaction_date)->result_array();
		} elseif( $type == "monthly" ) {
			$transaction_detail = $this->db->query("SELECT transaction_no, transaction_date, total_biaya, 
            CASE WHEN payment_status = 0 THEN 'Belum Dibayar' 
            WHEN payment_status = 1 THEN 'Lunas' END AS 'disp_status' 
            FROM dtb_transaction sd where CONCAT(YEAR(transaction_date),'-',MONTH(transaction_date)) = ?", $transaction_date)->result_array();
		} elseif( $type == "yearly" ) {
			$transaction_detail = $this->db->query("SELECT transaction_no, transaction_date, total_biaya, 
            CASE WHEN payment_status = 0 THEN 'Belum Dibayar' 
            WHEN payment_status = 1 THEN 'Lunas' END AS 'disp_status' 
            FROM dtb_transaction sd where YEAR(transaction_date) = ?", $transaction_date)->result_array();
		}
		
		$this->load->vars("filter", $filter);
        $this->load->vars('transaction_detail', $transaction_detail);
        $this->load->view('system/report/transaction2.php');
    }
}