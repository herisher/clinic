<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * transaction logic
 */
class Logic_transaction extends CI_Model {

    var $tabel = 'dtb_transaction';   //variabel tabelnya
 
    public function __construct() {
        parent::__construct();
    }
	
    public function get_transaction_list()
    {
        $this->load->model("Logic_data_tables");
        $query = "SELECT dt.*, dp.anamnesis, dp.patient_name, dp.address FROM dtb_transaction dt JOIN dtb_patient dp ON dt.patient_id = dp.patient_id WHERE 1"; 
        $countquery = "SELECT count(*) as total FROM dtb_transaction dt JOIN dtb_patient dp ON dt.patient_id = dp.patient_id WHERE 1"; 
        $columns = array('transaction_id', 'transaction_date', 'anamnesis', 'patient_name', 'address');
        $dbcolumns = $columns;

        $retval = $this->Logic_data_tables->ajax_data_tables($query, $countquery, $columns, $dbcolumns, 'transaction_index');
        return $retval;
    }
    
    public function do_process_registration()
    {
        $patient_id = $this->input->get_post('patient_id');
        if( !$patient_id ) {
            $this->load->model("Logic_patient");
            $patient_id = $this->Logic_patient->do_process_registration();
        }
        
        $patient = $this->db->query("SELECT * FROM dtb_patient WHERE patient_id = ?", $patient_id)->row_array();
        
        $data = array(
            'patient_id'        => $patient_id,
            'doctor_id'         => $this->input->get_post('doctor_id'),
            'transaction_date'  => $this->input->get_post('transaction_date'),
            'keluhan'           => $this->input->get_post('keluhan'),
            'diagnosa'          => $this->input->get_post('diagnosa'),
            'tindakan'          => $this->input->get_post('tindakan'),
            'layanan_tambahan'  => $this->input->get_post('layanan_tambahan'),
            'keterangan'        => $this->input->get_post('keterangan'),
            'alergi_obat'       => $this->input->get_post('alergi_obat'),
            'biaya_medis'       => $this->input->get_post('biaya_medis'),
            'dokumen_fileid'    => $this->input->get_post('orig_name'),
            'create_date'       => date("Y-m-d H:i:s"),
            'update_date'       => date("Y-m-d H:i:s"),
        );

        $this->db->insert("dtb_transaction", $data);
    }

    public function processUpdate(){
        $id= $this->uri->segment(4);

        $datas = array(
            'transaction_name'   => $this->input->get_post('transaction_name'),
            'mobile_number' => $this->input->get_post('mobile_number'),
            'update_date'   => date("Y-m-d H:i:s"),
        );
        $this->db->update("dtb_transaction",$datas,"transaction_id = '$id'".$this->input->get_post('transaction_id'));
    }
    
    public function get_all_by_id( $id = "" ) {
        $models = $this->db->query("SELECT transaction_id, anamnesis FROM dtb_transaction dt JOIN dtb_patient dp ON dt.patient_id = dp.patient_id")->result_array();
        
        $datas = array();
        foreach( $models as $value ) {
            $datas[$value["transaction_id"]] = $value["anamnesis"];
        }
        
        if( $id != "" && isset($datas[$id]) ){
            return $datas[$id];
        }
        
        return $datas;
    }
}
