<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * default controller for /
 */
class Welcome extends MY_Controller {

	/**
	 * default action for /
	 */
	public function index_action()
	{
        redirect("/system/dashboard");
		echo "Welcome to user page";
	}
}
