<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * login controller
 */
class Login extends MY_Controller {

    /**
     * default action for /system/login
     */
    public function index_action()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        if ($this->input->is_post()) {
            $dump = $this->input->post(NULL, TRUE);

            if ($this->form_validation->run('/system/login')) {
                $this->load->model('Logic_admin');
            
                $admintype = $this->Logic_admin->process_login();
            
                $userdata = $this->session->userdata('login_admin');
                if (!empty($userdata)){
                    //load permission config
                    $this->load->config("config_permissions");
                    $redirpage = $this->config->item("$admintype", 'user_main_page');

                    redirect('/system/dashboard');
                    exit;
                } else {
                    redirect('/system/login');
                    exit;
                }
                
            }
        }
        $this->load->view('system/login/index');
    }
}
