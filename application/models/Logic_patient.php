<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * patient logic
 */
class Logic_patient extends CI_Model {

    var $tabel = 'dtb_patient';   //variabel tabelnya
 
    public function __construct() {
        parent::__construct();
    }

    public function static_sex($sex = "") {
        $type = array(
            '1'  => 'Laki-laki',
            '2'  => 'Perempuan',
        );
        
        if( $sex != "" && isset($type[$sex]) ){
            return $type[$sex];
        }
        
        return $type;
    }
	
    public function get_patient_list()
    {
        $this->load->model("Logic_data_tables");
        $query = "SELECT * FROM dtb_patient WHERE is_deleted = 0"; 
        $countquery = "SELECT count(*) as total FROM dtb_patient WHERE is_deleted = 0"; 
        $columns = array('patient_id', 'anamnesis', 'patient_name', 'address');
        $dbcolumns = $columns;

        $retval = $this->Logic_data_tables->ajax_data_tables($query, $countquery, $columns, $dbcolumns, 'patient_index');
        return $retval;
    }
    
    public function get_patient_by_id($pid)
    {
        $models = $this->db->query("SELECT * FROM dtb_patient WHERE patient_id = ?", $pid)->row_array();
        $models["patient_ages"] = date("Y-m-d") - $models["patient_dob"] . " Tahun";
        return json_encode($models);
    }
    
    public function do_process_registration()
    {
        $data = array(
            'anamnesis'      => $this->input->get_post('anamnesis'),
            'patient_name'   => $this->input->get_post('patient_name'),
            'patient_sex'    => $this->input->get_post('patient_sex'),
            'patient_dob'    => $this->input->get_post('patient_dob'),
            'address'        => $this->input->get_post('address'),
            'phone_number'   => $this->input->get_post('phone_number'),
            'mobile_number'  => $this->input->get_post('mobile_number'),
            'create_date'    => date("Y-m-d H:i:s"),
            'update_date'    => date("Y-m-d H:i:s"),
        );

        $this->db->insert("dtb_patient", $data);
		$moving_id = $this->db->insert_id();
        return $moving_id;
    }

    public function processUpdate(){
        $id= $this->uri->segment(4);

        $datas = array(
            'anamnesis'      => $this->input->get_post('anamnesis'),
            'patient_name'   => $this->input->get_post('patient_name'),
            'patient_sex'    => $this->input->get_post('patient_sex'),
            'patient_dob'    => $this->input->get_post('patient_dob'),
            'address'        => $this->input->get_post('address'),
            'phone_number'   => $this->input->get_post('phone_number'),
            'mobile_number'  => $this->input->get_post('mobile_number'),
            'update_date'    => date("Y-m-d H:i:s"),
        );
        $this->db->update("dtb_patient",$datas,"patient_id = '$id'".$this->input->get_post('patient_id'));
    }
    
    public function get_all_by_id( $id = "", $flag = 0 ) {
        $models = $this->db->query("SELECT patient_id, patient_name FROM dtb_patient WHERE is_deleted = ?", $flag)->result_array();
        
        $datas = array();
        foreach( $models as $value ) {
            $datas[$value["patient_id"]] = $value["patient_name"];
        }
        
        if( $id != "" && isset($datas[$id]) ){
            return $datas[$id];
        }
        
        return $datas;
    }
}
