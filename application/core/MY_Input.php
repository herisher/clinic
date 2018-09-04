<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * extend input class
 */
class MY_Input extends CI_Input {

	/**
	 * default constructor
	 */
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * check request method is DELETE
	 */
	function is_delete()
	{
		$method = $this->server('REQUEST_METHOD');
		return (isset($method) && $method == 'DELETE') ? TRUE : FALSE;
	}

	/**
	 * check request method is GET
	 */
	function is_get()
	{
		$method = $this->server('REQUEST_METHOD');
		return (isset($method) && $method == 'GET') ? TRUE : FALSE;
	}

	/**
	 * check request method is POST
	 */
	function is_post()
	{
		$method = $this->server('REQUEST_METHOD');
		return (isset($method) && $method == 'POST') ? TRUE : FALSE;
	}

	/**
	 * check request method is PUT
	 */
	function is_put()
	{
		$method = $this->server('REQUEST_METHOD');
		return (isset($method) && $method == 'PUT') ? TRUE : FALSE;
	}
}
