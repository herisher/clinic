<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * base controller for all actions
 */
class MY_Controller extends CI_Controller {

	/**
	 * default constructor
	 */
	function __construct()
	{
		parent::__construct();

		// default content type
		$this->output->set_header('Content-Type: text/html; charset=UTF-8');

		// load libraries and helpers
		$this->load->database();
		$this->load->library('session');
		$this->load->library('email');
		$this->load->helper('url');

		// get router values
		$module = $this->router->directory;
		$c_name = $this->router->class;
		$c_func = $this->router->method;

		// set router values for view
		$this->load->vars('c_name', $c_name);
		$this->load->vars('c_func', $c_func);

		//echo "cont .. module = " . $module . " .. class = " . $c_name . " . . method = " . $this->router->method;
		//
		// case system
		//
		if ($module == 'system/')
		{
			$this->load->vars('module', 'system');
            
			if ($this->session->userdata('login_admin')) {
				$admin = $this->session->userdata('login_admin');
				$query = $this->db->query("SELECT * FROM dtb_admin WHERE id = ?", $admin['id']);
				if ($query->num_rows() > 0) {
                    $tb_admin = $query->row_array();
					$this->load->vars('login_admin', $tb_admin);
                    
                    //cannot access edit and delete pages if not super admin
                    if( ($c_func == "edit_action" || $c_func == "delete_action") && !$tb_admin['type']) {
                        show_error('You don\'t have permission to access this page.', 404);
                    }
				} else {
					redirect('/system/login/');
					exit;
				}
			} elseif($c_name != 'login') {
				redirect('/system/login/');
				exit;
			}
            
            $this->load->model('Logic_pages');
            $_categories = $this->Logic_pages->getCategories();
            $_pages = $this->Logic_pages->getAllPages();
            $this->load->vars('_categories', $_categories);
            $this->load->vars('_pages', $_pages);
            
		}
		//
		// case default
		//
		else
		{
			$this->load->vars('module', 'default');
		}
	}

	/**
	 * check login or not. if not login, regirect to login page
	 */
	function check_login()
	{
		$module = $this->load->get_var('module');
		if ($module == 'system' && !$this->load->get_var('system')) {
			redirect('/system/login/');
			exit;
		}
	}
}
