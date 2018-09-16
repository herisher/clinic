<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * transaction logic
 */
class Logic_transaction extends CI_Model {

    var $tabel = 'dtb_transaction';   //variabel tabelnya
 
    public function __construct() {
        parent::__construct();
    }
	
    public function static_status($status = "") {
        $type = array(
            '0'  => 'Belum Dibayar',
            '1'  => 'Lunas',
        );
        
        if( $status != "" && isset($type[$status]) ){
            return $type[$status];
        }
        
        return $type;
    }

    public function get_transaction_list()
    {
        $this->load->model("Logic_data_tables");
        $query = "SELECT dt.*, dp.anamnesis, dp.patient_name, dp.patient_dob FROM dtb_transaction dt JOIN dtb_patient dp ON dt.patient_id = dp.patient_id WHERE 1"; 
        $countquery = "SELECT count(*) as total FROM dtb_transaction dt JOIN dtb_patient dp ON dt.patient_id = dp.patient_id WHERE 1"; 
        $columns = array('transaction_id', 'transaction_date', 'anamnesis', 'patient_name', 'patient_dob');
        $dbcolumns = $columns;

        $retval = $this->Logic_data_tables->ajax_data_tables($query, $countquery, $columns, $dbcolumns, 'transaction_index');
        return $retval;
    }
    
    public function get_cashier_list()
    {
        $this->load->model("Logic_data_tables");
        $query = "SELECT dt.*, dp.anamnesis, dp.patient_name, dp.patient_dob FROM dtb_transaction dt JOIN dtb_patient dp ON dt.patient_id = dp.patient_id WHERE is_cashier = 1"; 
        $countquery = "SELECT count(*) as total FROM dtb_transaction dt JOIN dtb_patient dp ON dt.patient_id = dp.patient_id WHERE is_cashier = 1";
        $columns = array('transaction_id', 'transaction_date', 'transaction_no', 'anamnesis', 'patient_name', 'patient_dob', 'total_biaya', 'payment_status');
        $dbcolumns = $columns;

        $retval = $this->Logic_data_tables->ajax_data_tables($query, $countquery, $columns, $dbcolumns, 'cashier_index');
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
        
        $this->load->model('Logic_transaction');
        $transaction_no = $this->Logic_transaction->getCodeGenerated();
        
        $data = array(
            'transaction_no'    => $transaction_no,
            'patient_id'        => $patient_id,
            'doctor_id'         => $this->input->get_post('doctor_id'),
            'transaction_date'  => $this->input->get_post('transaction_date'),
            'keluhan'           => $this->input->get_post('keluhan'),
            'diagnosa'          => $this->input->get_post('diagnosa'),
            'tindakan'          => $this->input->get_post('tindakan'),
            'layanan_tambahan'  => $this->input->get_post('layanan_tambahan'),
            'keterangan'        => $this->input->get_post('keterangan'),
            'alergi_obat'       => $this->input->get_post('alergi_obat'),
            'resep'             => $this->input->get_post('resep'),
            'biaya_medis'       => str_replace(".", "", $this->input->get_post('biaya_medis')),
            'total_biaya'       => str_replace(".", "", $this->input->get_post('biaya_medis')),
            'document_fileid'    => $this->input->get_post('orig_name'),
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

    public function processRegisterCashier(){
        $datas = array(
            'transaction_date'  => $this->input->get_post('transaction_date'),
            'transaction_no'    => $this->input->get_post('transaction_no'),
            'biaya_admin'       => str_replace(".", "", $this->input->get_post('biaya_admin')),
            'biaya_medis'       => str_replace(".", "", $this->input->get_post('biaya_medis')),
            'biaya_obat'        => str_replace(".", "", $this->input->get_post('biaya_obat')),
            'total_biaya'       => str_replace(".", "", $this->input->get_post('total_biaya')),
            'jumlah_uang'       => str_replace(".", "", $this->input->get_post('jumlah_uang')),
            'kembalian'         => str_replace(".", "", $this->input->get_post('kembalian')),
            'payment_status'    => $this->input->get_post('payment_status'),
            'is_cashier'        => 1,
            'update_date'       => date("Y-m-d H:i:s"),
        );
        $this->db->update("dtb_transaction",$datas,"transaction_id = ".$this->input->get_post('transaction_id'));
    }
    
    public function processUpdateCashier(){
        $datas = array(
            'jumlah_uang'       => str_replace(".", "", $this->input->get_post('jumlah_uang')),
            'kembalian'         => str_replace(".", "", $this->input->get_post('kembalian')),
            'payment_status'    => $this->input->get_post('payment_status'),
            'update_date'       => date("Y-m-d H:i:s"),
        );
        $this->db->update("dtb_transaction",$datas,"transaction_id = ".$this->input->get_post('transaction_id'));
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
	
    public function getCodeGenerated(){
		$model = $this->db->query("SELECT transaction_no FROM dtb_transaction WHERE is_cashier = 1 ORDER BY transaction_id DESC LIMIT 1")->row_array();
		$value = "TRX0001";
		if( $model ) {
			$sub = intval(substr($model["transaction_no"], 3, 4)); //.0000
			$subs = $sub+1;
			if( $subs>0 && $subs<=9 ) {
				$nmr = "000".$subs;
			} elseif( $subs>9 && $subs<=99 ) {
				$nmr = "00".$subs;
			} elseif( $subs>99 && $subs<=999 ) {
				$nmr = "0".$subs;
			} elseif( $subs>999 && $subs<=9999 ) {
				$nmr = $subs;
			}
			$value = "TRX" . $nmr;
		}
		
		return $value;
    }
    
    public function get_transaction_by_patient($pid)
    {
        $this->load->model("Logic_patient");
        $patient = $this->Logic_patient->get_patient_by_id($pid, 0);
        
        $models = $this->db->query("
        SELECT transaction_id, transaction_date, doctor_id, biaya_medis 
        FROM dtb_transaction 
        WHERE patient_id = ? AND is_cashier = 0 ORDER BY transaction_id DESC LIMIT 1", $pid)->row_array();
        
        if( $models ) {
            foreach( $models as $key => $val) {
                $patient[$key] = $val;
            }
            
            return json_encode($patient);
        } else {
            return;
        }
    }
}
