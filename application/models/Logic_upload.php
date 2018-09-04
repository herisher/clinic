<?php
class Logic_upload extends CI_Model{
    public function upload_pattern($file_name){
        //return values
        $result['result'] = FALSE;
        $result['message'] = "";

        $this->load->library('upload');

        //upload an image options
        $config = array();
        $config['upload_path'] = APPPATH . "../public/upload/pattern/";
        $config['allowed_types'] = 'gif|jpg|png|pdf|xls|xls|doc|docx';
        $config['max_size']      = '512000';
        $config['overwrite']     = FALSE;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload($file_name)) {
            $errors = $this->upload->display_errors();
            $result['result'] = FALSE;
            $result['message'] = $errors;
            $result['datas'] = array();
        } else {
            $file_info = $this->upload->data();
            $file_path =  $file_info["full_path"];
            $orig_name =  $file_info["orig_name"];

            //insert datas
            $datas = array(
                "file_path"      => $file_path,
                "orig_name"      => $orig_name,
            );
            
            $result['result'] = TRUE;
            $result['message'] = 'Upload Succesfully';
            $result['datas'] = $datas;
        }
        return $result;
		exit;
    }
	
    public function upload_image($file_name, $folder){
        //return values
        $result['result'] = FALSE;
        $result['message'] = "";

        $this->load->library('upload');

        //upload an image options
        $config = array();
        $config['upload_path'] = APPPATH . "../public/upload/" . $folder . "/";
        $config['allowed_types'] = 'gif|jpg|png|pdf|xls|xls|doc|docx';
        $config['max_size']      = '512000';
        $config['overwrite']     = FALSE;

        $this->upload->initialize($config);
        if (!$this->upload->do_upload($file_name)) {
            $errors = $this->upload->display_errors();
            $result['result'] = FALSE;
            $result['message'] = $errors;
            $result['datas'] = array();
        } else {
            $file_info = $this->upload->data();
            $file_path =  $file_info["full_path"];
            $orig_name =  $file_info["orig_name"];

            //insert datas
            $datas = array(
                "file_path"      => $file_path,
                "orig_name"      => $orig_name,
            );
            
            $result['result'] = TRUE;
            $result['message'] = 'Upload Succesfully';
            $result['datas'] = $datas;
        }
        return $result;
		exit;
    }
}