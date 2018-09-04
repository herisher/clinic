<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * logout controller
 */
class Logout extends MY_Controller {

    /**
     * default action for /system/logout
     */
    public function index_action()
    {
        $this->session->sess_destroy();
        redirect('/system/login');
        exit;
    }
}
