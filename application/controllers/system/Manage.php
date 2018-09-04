<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Manage extends MY_Controller
{

    public function index_action()
    {
		//Only Super Admin may access
		$admin = $this->session->userdata('login_admin');
		if(!$admin) {
			redirect('/system/login');
		}
		if($admin['login_admin_type']) {
			
		}
		else {
			redirect('/system/dashboard');
		}
		
        $this->load->model('Logic_admin');
        $this->load->vars("type_option", $this->Logic_admin->get_type_static());
        
        $this->load->model('Logic_doctor');
        $this->load->vars("doctor_option", $this->Logic_doctor->get_all_by_id());
        
		$this->load->helper('form');
        $this->load->library('form_validation');
		$formvalid = $this->form_validation->run('/system/manage');
		
		if($this->input->post()) {
			if ($formvalid) {
                $user_type = 1;
                if( $this->input->post('user_type') > 1) {
                    $user_type = 0;
                }
				$datas = array(
					'username'      => $this->input->post('username'),
					'type'          => $user_type,
					'password'      => hash('sha256', $this->input->post('username') . $this->input->post('password')),
					'unique_id'     => uniqid("", true),
					'doctor_id'     => $this->input->post('doctor_id'),
					'status'        => 1,
					'create_date'   => date("Y-m-d h:i:s"),
				);
				$this->db->insert('dtb_admin', $datas);
				$new_id = $this->db->insert_id();
				
				$this->load->model('Logic_pages');
				$categories = $this->Logic_pages->getCategories();
                foreach( $categories as $c => $p) {
                    if($this->input->post('type'.$c)) {
						$newtype = array(
							'admin_id' => $new_id,
							'category_id' => $c,
							'bit' => array_sum($this->input->post('type'.$c))
						);
						$this->db->insert('dtb_admin_type', $newtype);
					}
				}
				
				redirect('/system/manage');
			}
		}
		
		$datas = $this->db->query("SELECT * FROM dtb_admin")->result_array();
        $this->load->vars("datas",$datas);
        $this->load->view('system/manage/admin.php');
    }
	
	public function detail_action()
    {
		$id = $this->uri->segment(4);
		if(!$id) { redirect('/system/manage'); }
		
		$this->load->helper('form');
        $this->load->library('form_validation');
		$formvalid = $this->form_validation->run('/system/detail');
		
        $this->load->model('Logic_admin');
        $this->load->vars("type_option", $this->Logic_admin->get_type_static());
        
        $this->load->model('Logic_doctor');
        $this->load->vars("doctor_option", $this->Logic_doctor->get_all_by_id());
        
		$next = 0;
		
		$admin = $this->db->query("SELECT * FROM dtb_admin WHERE id = ?", $id)->row_array();
		if(!$admin) { redirect('/system/manage'); }
        if($admin["type"]) {
            $admin["user_type"] = 1;
        }elseif( !$admin["type"] && $admin["doctor_id"] ) { //doctor
            $admin["user_type"] = 2;
        } elseif( !$admin["type"] && !$admin["doctor_id"] ) { //cashier
            $admin["user_type"] = 3;
        }
		$types = $this->db->query("SELECT * FROM dtb_admin_type WHERE admin_id = ?", $id)->result_array();
		$type = array();
		foreach($types as $t) {
			$type[$t['category_id']] = $t['bit'];
		}
		
		if($this->input->post()) {
            if($this->input->post('submit') != 'delete') {
                if ($formvalid) {
                    $user_type = 1;
                    if( $this->input->post('user_type') > 1) {
                        $user_type = 0;
                    }
                    $datas = array(
                        'username'      => $this->input->post('username'),
                        'type'          => $user_type,
                        'doctor_id'     => $this->input->post('doctor_id'),
                        'update_date'   => date("Y-m-d h:i:s"),
                    );
                    if($this->input->post('password')) {
                        $datas['password'] = hash('sha256', $this->input->post('username') . $this->input->post('password'));
                    }
                    $this->db->where('id', $id);
                    $this->db->update('dtb_admin', $datas);
                    
                    $this->db->delete('dtb_admin_type', array('admin_id' => $id));
                    $this->load->model('Logic_pages');
                    $categories = $this->Logic_pages->getCategories();
                    foreach( $categories as $c => $p) {
                        if($this->input->post('type'.$c)) {
                            $newtype = array(
                                'admin_id'      => $id,
                                'category_id'   => $c,
                                'bit'           => array_sum($this->input->post('type'.$c))
                            );
                            $this->db->insert('dtb_admin_type', $newtype);
                        }
                    }
                }
            }
            else { //DELETE
                $this->db->delete('dtb_admin_type', array('admin_id' => $id));
                $this->db->delete('dtb_admin', array('id' => $id));
                $this->db->query('ALTER TABLE dtb_admin AUTO_INCREMENT = 1');
            }
            $next = 1;
		}
		
		
		$this->load->vars("id",$id);
		$this->load->vars("adm",$admin);
		$this->load->vars("typ",$type);
        $this->load->vars('next',$next);
		
		$this->load->view('system/manage/detail.php');
    }
	
	public function password_action()
    {
        $admin = $this->session->userdata('login_admin');
		$this->load->helper('form');
        $this->load->library('form_validation');
		$formvalid = $this->form_validation->run('/system/password');
		
		$next = 0;
		
		if($this->input->post()) {
            if ($formvalid) {
                if($this->input->post('password')) {
                    $datas['password'] = hash('sha256', $admin['login_admin_username'] . $this->input->post('password'));
                }
                
                $this->db->where('id', $admin['id']);
                $this->db->update('dtb_admin', $datas);
                $next = 1;
            }
		}
        
        $this->load->vars('next',$next);
		$this->load->view('system/manage/password.php');
    }
	
	//(Form Validation) Check if admin roles selected
	public function _admin_roles_checked($val) {
		if($val) {return TRUE;}
        if($this->input->post('user_type') == 1) {return TRUE;} //super admin
		
		$role = FALSE;
		$categories = $this->Logic_pages->getCategories();
        foreach( $categories as $c => $p) {
			if($this->input->post('type'.$c)) {
				$role = TRUE;
			}
        }
        
		if(!$role) {
			$this->form_validation->set_message('_admin_roles_checked', "Please select any pages.");
		}
		return $role;
	}
    
	//(Form Validation) Check if confirm password is same with password
	public function _conf_pass_checked($val) {
        if( $this->input->post('password') == $val ) {
            return true;
		}
        elseif( $this->input->post('password') != $val ) {
			$this->form_validation->set_message('_conf_pass_checked', "Confirmation Password must be same with Password");
            return false;
		}
	}
    
	//(Form Validation) Check if confirm password is same with password
	public function _old_pass_checked($val) {
        if( $val ) {
            $admin = $this->session->userdata('login_admin');
            $query = $this->db->query("SELECT * FROM dtb_admin WHERE id = ?", $admin['id'])->row_array();
            
            $old_pass = hash('sha256', $admin['login_admin_username'] . $val);
            if( $old_pass != $query['password'] ) {
                $this->form_validation->set_message('_old_pass_checked', "Wrong Old Password");
                return false;
            } else return true;
        }
	}
    
	//(Form Validation) Check if confirm password is same with password
	public function _duplicate_checked($val) {
        if( $val ) {
            $admin = $this->session->userdata('login_admin');
            $query = $this->db->query("SELECT * FROM dtb_admin WHERE username = ?", $val)->row_array();
            
            if( $query ) {
                $this->form_validation->set_message('_duplicate_checked', "Username already registered");
                return false;
            } else {
                return true;
            }
        }
	}
    
	//(Form Validation) Check if confirm password is same with password
	public function _duplicate_edit_checked($val) {
        if( $val ) {
            $id = $this->uri->segment(4);
            $admin = $this->db->query("SELECT username FROM dtb_admin WHERE id = ?", $id)->row_array();
            
            if( $val != $admin["username"] ) {
                $query = $this->db->query("SELECT * FROM dtb_admin WHERE username = ?", $val)->row_array();
                
                if( $query ) {
                    $this->form_validation->set_message('_duplicate_edit_checked', "Username already registered");
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }
	}
}
