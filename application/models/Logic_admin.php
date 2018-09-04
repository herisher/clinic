<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * admin logic
 */
class Logic_admin extends CI_Model {

    public function get_type_static($id = "") {
        $type = array(
            '1'  => 'Admin',
            '2'  => 'Doctor',   //value will become 0
            '3'  => 'Cashier',  //value will become 0
        );
        
        if( $id != "" && isset($type[$id]) ){
            return $type[$id];
        }
        
        return $type;
    }

	/**
	 * admin login
	 * @params $login_id admin username (GET/POST)
	 * @params $login_pw admin password (GET/POST)
	 */
    public function process_login()
	{
        $admintype = false;
		$username     = $this->input->get_post('username');
		$password_before = $this->input->get_post('password');
        $password = hash('sha256', $username . $password_before);

		$query = $this->db->query("SELECT * FROM dtb_admin WHERE username = ? AND password = ? LIMIT 1", array($username, $password));
		if ($query->num_rows() > 0) {
			$login_admin = $query->row_array();
            $admintype = $query->row()->type;
            $adminid = $query->row()->id;
			
			// type system
			$types = array();
			$newtypes = $this->db->query('SELECT * FROM dtb_admin_type WHERE admin_id = ?', $login_admin['id'])->result_array();
			foreach($newtypes as $nt) {
				$types[$nt['category_id']] = $nt['bit'];
			}
			
			// store data to session and stash
			$this->session->set_userdata(   'login_admin', 
                                            array(  'id'                    => $login_admin['id'],
                                                    'login_admin_username'  => $login_admin["username"],
                                                    'login_admin_type'      => $admintype,
                                                    'login_admin_type_new'  => $types));
			$this->load->vars('login_admin', $login_admin);

		}
        return $admintype;
	}
	
	//Check for permission
	public function check_permission($type, $bit){
		$admin = $this->session->userdata('login_admin');
		if(!$admin) {
			redirect('/system/login');
		}
		
		if($admin['login_admin_type'] || ($admin['login_admin_type_new'][$type] & $bit)) {
			
		}
		else {
			redirect('/system/dashboard');
		}
	}
	
	public function check_permission_multi($arrays){
		$admin = $this->session->userdata('login_admin');
		if(!$admin) {
			redirect('/system/login');
		}
		
		$check = 0;
		
		foreach($arrays as $arr) {
			if($admin['login_admin_type'] || ($admin['login_admin_type_new'][$arr['type']] & $arr['bit'])) {
				$check = 1;
			}
			else {
				
			}
		}
		
		if(!$check) {
			redirect('/system/dashboard');
		}
	}
}
