<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Doctor extends MY_Controller {

    public function index_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(102,1);
        
        $datas = $this->db->query("SELECT * FROM dtb_doctor")->result_array();
        $this->load->vars("datas",$datas);
        $this->load->view("system/doctor/index");
    }
    
    public function ajax_get_doctor_list_action(){
        $this->load->model("Logic_doctor");
        $ret = $this->Logic_doctor->get_doctor_list();
        echo $ret;
    }

    public function new_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(102,1);
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->vars('next', 0);
        $this->load->model('Logic_doctor');

        if ($this->input->is_post()) {
            if ($this->form_validation->run('/system/doctor/new')) {
                $this->Logic_doctor->do_process_registration();
                $this->load->vars('next', 1);
            } else {
                $this->load->vars('next', 0);
            }
        } else {
            $this->form_validation->run('/system/doctor/new');
        }

        $this->load->view('system/doctor/new.php');
    }

    public function detail_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(102,1);
        
        $id = $this->uri->segment(4);
        $this->load->vars('doctor_id', $id);

        $this->load->model('Logic_doctor');
        $doctor = $this->db->query("SELECT * FROM dtb_doctor where doctor_id = ".$this->db->escape_str($id))->row_array();
        $this->load->vars('doctor', $doctor);
        
        $this->load->view('system/doctor/detail.php');
    }

    public function edit_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(102,1);
        
        $id = $this->uri->segment(4);
        $this->load->vars('doctor_id', $id);
        
        $model = $this->db->query("SELECT * from dtb_doctor where dtb_doctor.doctor_id = ? ", $id)->row_array();
        if (!$model) {
            show_error('This data is deleted or not exists.');
            exit;
        }
        $doctor = $this->db->query("SELECT * FROM dtb_doctor where doctor_id = ".$this->db->escape_str($id))->row_array();
        $this->load->vars('doctor', $doctor);

        $this->load->helper('form');
        $this->load->library('form_validation');
        if ($this->input->is_post()) {
            if ($this->form_validation->run('/system/doctor/doctor_edit')) {
                $this->load->model('Logic_doctor');
                $this->Logic_doctor->processUpdate();
                $this->load->vars('next', 1);
            } else {
                $this->load->vars('next', 0);
            }
        } else {
            $this->form_validation->run('/system/doctor/doctor_edit');
        }
        $this->load->view('system/doctor/edit.php');
    }

    public function delete_action()
    {
        $this->load->model('Logic_admin');
        $this->Logic_admin->check_permission(102,1);
        
        $this->load->vars('doctor_id', $this->uri->segment(4));

        //Menampilkan data sebelumnya
        $page = $this->uri->segment(4);
        $datas = $this->db->query("SELECT * FROM dtb_doctor WHERE doctor_id = ?", $page)->row_array();
        
         if($this->input->post("submit") == "YES" ){
            $data = array(
                'is_deleted'    => 1,
                'update_date'   => date("Y-m-d H:i:s"),
            );
            $this->db->update("dtb_doctor",$data,"doctor_id = ".$datas['doctor_id']);
            $this->load->vars('next', 1);
        }

        $this->load->vars("datas",$datas);
        $this->load->view('system/doctor/delete');
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

        $models = $this->db->query("SELECT doctor_id, name, phone, payment_period FROM dtb_doctor" . $where)->result_array();

        // ヘッダ出力
        header('Content-type: application/octet-stream');
        if (preg_match("/MSIE 8\.0/", $_SERVER['HTTP_USER_AGENT'])) {
            header('Content-Disposition: filename=doctor-' . time() . '.csv');
        } else {
            header('Content-Disposition: attachment; filename=doctor-' . time() . '.csv');
        }
        header('Pragma: public');
        header('Cache-control: public');

        echo '"No","Name","Phone","Payment Period (Month)"'."\n";

        $no = 0;
        $this->load->model('Logic_doctor');
        // CSV出力
        foreach ($models as $item) {
            $cols = array();
            
            $no++;
            
            foreach($item as $key => $i) {
                if($key == 'doctor_id') {
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