<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Checkup extends MY_Controller {

    public function index_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(103,1);
        
        $datas = $this->db->query("SELECT * FROM dtb_transaction")->result_array();
        $this->load->vars("datas",$datas);
        $this->load->view("system/checkup/index");
    }
    
    public function ajax_get_checkup_list_action(){
        $this->load->model("Logic_transaction");
        $ret = $this->Logic_transaction->get_transaction_list();
        echo $ret;
    }

    public function ajax_get_patient_action(){
		$pid = $_POST["patient_id"];
        $this->load->model("Logic_patient");
        $ret = $this->Logic_patient->get_patient_by_id($pid);
        echo $ret;
    }

    public function new_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(103,1);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->vars('next', 0);
        $this->load->model('Logic_transaction');
        $this->load->model('Logic_upload');
        
        $this->load->model('Logic_doctor');
        $this->load->vars('doctor_option', $this->Logic_doctor->get_all_by_id());
        $this->load->vars('doctor_id', $this->session->login_admin["login_doctor_id"]);
        
        $this->load->model('Logic_patient');
        $this->load->vars('patient_option', $this->Logic_patient->get_all_by_id());
        $this->load->vars('sex_option', $this->Logic_patient->static_sex());

        if ($this->input->is_post()) {
            if ($this->form_validation->run('/system/checkup/new')) {
                if($_FILES["document_fileid"]["size"]) {
                    $upload = $this->Logic_upload->upload_image("document_fileid", "docs");
                    if( $upload["result"] == TRUE ) {
                        $_POST["file_path"] = $upload["datas"]["file_path"];
                        $_POST["orig_name"] = $upload["datas"]["orig_name"];
                    } 
                }
                $this->Logic_transaction->do_process_registration();
                $this->load->vars('next', 1);
            } else {
                $this->load->vars('next', 0);
            }
        } else {
            $this->form_validation->run('/system/checkup/new');
        }

        $this->load->view('system/checkup/new.php');
    }

    public function detail_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(103,1);
        
        $id = $this->uri->segment(4);
        $this->load->vars('transaction_id', $id);

        $this->load->model('Logic_transaction');
        $checkup = $this->db->query("SELECT * FROM dtb_transaction where transaction_id = ".$this->db->escape_str($id))->row_array();
        $this->load->vars('checkup', $checkup);
        
        $this->load->model('Logic_patient');
        $patient = $this->db->query("SELECT * FROM dtb_patient where patient_id = ?", $this->db->escape_str($checkup['patient_id']))->row_array();
        $patient["disp_sex"] = $this->Logic_patient->static_sex($patient["patient_sex"]);
        $patient["ages"] = date_diff(date_create($patient["patient_dob"]), date_create('today'))->y . " Tahun";
        $this->load->vars('patient', $patient);
        
        $doctor = $this->db->query("SELECT * FROM dtb_doctor where doctor_id = ?", $this->db->escape_str($checkup['doctor_id']))->row_array();
        $this->load->vars('doctor', $doctor);
        
        $this->load->view('system/checkup/detail.php');
    }

    public function edit_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(103,1);
        
        $id = $this->uri->segment(4);
        $this->load->vars('checkup_id', $id);
        
        $model = $this->db->query("SELECT * from dtb_transaction where dtb_transaction.checkup_id = ? ", $id)->row_array();
        if (!$model) {
            show_error('This data is deleted or not exists.');
            exit;
        }
        $checkup = $this->db->query("SELECT * FROM dtb_transaction where checkup_id = ".$this->db->escape_str($id))->row_array();
        $this->load->vars('checkup', $checkup);

        $this->load->helper('form');
        $this->load->library('form_validation');
        if ($this->input->is_post()) {
            if ($this->form_validation->run('/system/checkup/checkup_edit')) {
                $this->load->model('Logic_transaction');
                $this->Logic_transaction->processUpdate();
                $this->load->vars('next', 1);
            } else {
                $this->load->vars('next', 0);
            }
        } else {
            $this->form_validation->run('/system/checkup/checkup_edit');
        }
        $this->load->view('system/checkup/edit.php');
    }

    public function delete_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(103,1);
        
        $this->load->vars('checkup_id', $this->uri->segment(4));

        //Menampilkan data sebelumnya
        $page = $this->uri->segment(4);
        $datas = $this->db->query("SELECT * FROM dtb_transaction WHERE checkup_id = ?", $page)->row_array();
        
         if($this->input->post("submit") == "YES" ){
            $data = array(
                'is_deleted'    => 1,
                'update_date'   => date("Y-m-d H:i:s"),
            );
            $this->db->update("dtb_transaction",$data,"checkup_id = ".$datas['checkup_id']);
            $this->load->vars('next', 1);
        }

        $this->load->vars("datas",$datas);
        $this->load->view('system/checkup/delete');
    }
    
    public function csv_action() {
        // リミッター解除
        ini_set('memory_limit','-1');
        
        $post = array (
            'name' => $this->input->post("name"),
            'phone' => $this->input->post("phone"),
        );
        
        //Where array
        $where_array = array();
        foreach($post as $key => $p) {
            if($p) {
                $where_array[] = $key .' LIKE "%'. $p . '%"';
            }
        }
        
        if($where_array) {
            $where = " WHERE " . implode(" AND ", $where_array);
        }
        else {
            $where = "";
        }

        $models = $this->db->query("SELECT checkup_id, name, phone, payment_period FROM dtb_transaction" . $where)->result_array();

        // ヘッダ出力
        header('Content-type: application/octet-stream');
        if (preg_match("/MSIE 8\.0/", $_SERVER['HTTP_USER_AGENT'])) {
            header('Content-Disposition: filename=checkup-' . time() . '.csv');
        } else {
            header('Content-Disposition: attachment; filename=checkup-' . time() . '.csv');
        }
        header('Pragma: public');
        header('Cache-control: public');

        echo '"No","Name","Phone","Payment Period (Month)"'."\n";

        $no = 0;
        $this->load->model('Logic_transaction');
        // CSV出力
        foreach ($models as $item) {
            $cols = array();
            
            $no++;
            
            foreach($item as $key => $i) {
                if($key == 'checkup_id') {
                    array_push($cols, '"'.$no.'"');
                }
                else {
                    array_push($cols, '"'.$i.'"');
                }
            }

            echo mb_convert_encoding(join(",", $cols), 'SJIS-win', 'UTF-8') . "\r\n";
        }
    }
}