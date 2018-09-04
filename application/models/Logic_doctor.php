<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * doctor logic
 */
class Logic_doctor extends CI_Model {

    var $tabel = 'dtb_doctor';   //variabel tabelnya
 
    public function __construct() {
        parent::__construct();
    }
	
    public function get_doctor_list()
    {
        $this->load->model("Logic_data_tables");
        $query = "SELECT * FROM dtb_doctor WHERE is_deleted = 0"; 
        $countquery = "SELECT count(*) as total FROM dtb_doctor WHERE is_deleted = 0"; 
        $columns = array('doctor_id', 'doctor_name', 'mobile_number');
        $dbcolumns = $columns;

        $retval = $this->Logic_data_tables->ajax_data_tables($query, $countquery, $columns, $dbcolumns, 'doctor_index');
        return $retval;
    }
    
    public function do_process_registration()
    {
        $data = array(
            'doctor_name'   => $this->input->get_post('doctor_name'),
            'mobile_number' => $this->input->get_post('mobile_number'),
            'create_date'   => date("Y-m-d H:i:s"),
            'update_date'   => date("Y-m-d H:i:s"),
        );

        $this->db->insert("dtb_doctor", $data);
    }

    public function processUpdate(){
        $id= $this->uri->segment(4);

        $datas = array(
            'doctor_name'   => $this->input->get_post('doctor_name'),
            'mobile_number' => $this->input->get_post('mobile_number'),
            'update_date'   => date("Y-m-d H:i:s"),
        );
        $this->db->update("dtb_doctor",$datas,"doctor_id = '$id'".$this->input->get_post('doctor_id'));
    }
    
    public function get_all_by_id( $id = "", $flag = 0 ) {
        $models = $this->db->query("SELECT doctor_id, doctor_name FROM dtb_doctor WHERE is_deleted = ?", $flag)->result_array();
        
        $datas = array();
        foreach( $models as $value ) {
            $datas[$value["doctor_id"]] = $value["doctor_name"];
        }
        
        if( $id != "" && isset($datas[$id]) ){
            return $datas[$id];
        }
        
        return $datas;
    }
}
