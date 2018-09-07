<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Patient extends MY_Controller {

    public function index_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(101,1);
        
        $datas = $this->db->query("SELECT * FROM dtb_patient")->result_array();
        $this->load->vars("datas",$datas);
        $this->load->view("system/patient/index");
    }
    
    public function ajax_get_patient_list_action(){
        $this->load->model("Logic_patient");
        $ret = $this->Logic_patient->get_patient_list();
        echo $ret;
    }

    public function new_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(101,1);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->vars('next', 0);
        $this->load->model('Logic_patient');
        $this->load->vars('sex_option', $this->Logic_patient->static_sex());
        $this->load->vars('anamnesis', $this->Logic_patient->getCodeGenerated());

        if ($this->input->is_post()) {
            if ($this->form_validation->run('/system/patient/new')) {
                $this->Logic_patient->do_process_registration();
                $this->load->vars('next', 1);
            } else {
                $this->load->vars('next', 0);
            }
        } else {
            $this->form_validation->run('/system/patient/new');
        }

        $this->load->view('system/patient/new.php');
    }

    public function detail_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(101,1);
        
        $id = $this->uri->segment(4);
        $this->load->vars('patient_id', $id);

        $this->load->model('Logic_patient');
        $patient = $this->db->query("SELECT * FROM dtb_patient where patient_id = ".$this->db->escape_str($id))->row_array();
        $patient["disp_sex"] = $this->Logic_patient->static_sex($patient["patient_sex"]);
        $patient["ages"] = date("Y-m-d") - $patient["patient_dob"];
        $this->load->vars('patient', $patient);
        
        $this->load->view('system/patient/detail.php');
    }

    public function edit_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(101,1);
        
        $id = $this->uri->segment(4);
        $this->load->vars('patient_id', $id);
        
        $this->load->model('Logic_patient');
        $this->load->vars('sex_option', $this->Logic_patient->static_sex());
        
        $model = $this->db->query("SELECT * from dtb_patient where dtb_patient.patient_id = ? ", $id)->row_array();
        if (!$model) {
            show_error('This data is deleted or not exists.');
            exit;
        }
        $patient = $this->db->query("SELECT * FROM dtb_patient where patient_id = ".$this->db->escape_str($id))->row_array();
        $this->load->vars('patient', $patient);

        $this->load->helper('form');
        $this->load->library('form_validation');
        if ($this->input->is_post()) {
            if ($this->form_validation->run('/system/patient/patient_edit')) {
                $this->Logic_patient->processUpdate();
                $this->load->vars('next', 1);
            } else {
                $this->load->vars('next', 0);
            }
        } else {
            $this->form_validation->run('/system/patient/patient_edit');
        }
        $this->load->view('system/patient/edit.php');
    }

    public function delete_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(101,1);
        
        $this->load->vars('patient_id', $this->uri->segment(4));

        //Menampilkan data sebelumnya
        $page = $this->uri->segment(4);
        $datas = $this->db->query("SELECT * FROM dtb_patient WHERE patient_id = ?", $page)->row_array();
        
         if($this->input->post("submit") == "YES" ){
            $data = array(
                'is_deleted'    => 1,
                'update_date'   => date("Y-m-d H:i:s"),
            );
            $this->db->update("dtb_patient",$data,"patient_id = ".$datas['patient_id']);
            $this->load->vars('next', 1);
        }

        $this->load->vars("datas",$datas);
        $this->load->view('system/patient/delete');
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

        $models = $this->db->query("SELECT patient_id, name, phone, payment_period FROM dtb_patient" . $where)->result_array();

        // ヘッダ出力
        header('Content-type: application/octet-stream');
        if (preg_match("/MSIE 8\.0/", $_SERVER['HTTP_USER_AGENT'])) {
            header('Content-Disposition: filename=patient-' . time() . '.csv');
        } else {
            header('Content-Disposition: attachment; filename=patient-' . time() . '.csv');
        }
        header('Pragma: public');
        header('Cache-control: public');

        echo '"No","Name","Phone","Payment Period (Month)"'."\n";

        $no = 0;
        $this->load->model('Logic_patient');
        // CSV出力
        foreach ($models as $item) {
            $cols = array();
            
            $no++;
            
            foreach($item as $key => $i) {
                if($key == 'patient_id') {
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