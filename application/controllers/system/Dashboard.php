<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Dashboard extends MY_Controller {

    public function index_action()
    {
        $this->load->view('system/dashboard/index');
    }
}
