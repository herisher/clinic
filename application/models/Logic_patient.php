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
        $columns = array('patient_id', 'anamnesis', 'patient_name', 'patient_dob');
        $dbcolumns = $columns;

        $retval = $this->Logic_data_tables->ajax_data_tables($query, $countquery, $columns, $dbcolumns, 'patient_index');
        return $retval;
    }
    
    public function get_patient_by_id($pid, $json = 1)
    {
        $models = $this->db->query("SELECT * FROM dtb_patient WHERE patient_id = ?", $pid)->row_array();
        //$models["patient_ages"] = date("Y-m-d") - $models["patient_dob"] . " Tahun";
        $models["patient_ages"] = date_diff(date_create($models["patient_dob"]), date_create('today'))->y . " Tahun";
        if( $json ) {
            return json_encode($models);
        } else {
            return $models;
        }
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
	
    public function getCodeGenerated(){
		$model = $this->db->query("SELECT anamnesis FROM dtb_patient ORDER BY patient_id DESC LIMIT 1")->row_array();
		$value = "NRM0001";
		if( $model ) {
			$value = $model["anamnesis"] + 1;
			$sub = substr($model["anamnesis"], 1, 4); //.0000
			$subs = $sub+'1';
			if( $subs>0 && $subs<=9 ) {
				$nmr = "000".$subs;
			} elseif( $subs>9 && $subs<=99 ) {
				$nmr = "00".$subs;
			} elseif( $subs>99 && $subs<=999 ) {
				$nmr = "0".$subs;
			} elseif( $subs>999 && $subs<=9999 ) {
				$nmr = $subs;
			}
			$value = "NRM" . $nmr;
		}
		
		return $value;
    }
}
