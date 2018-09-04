<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * extend input class
 */
class MY_Router extends CI_Router {

	/**
	 * default constructor
	 */
	 
	public $method =	'index_action';
	
	function __construct()
	{
		parent::__construct();
	}

	/**
	 *  Fetch the current method
	 *
	 * @access	public
	 * @return	string
	 */
	function fetch_method()
	{
		if ($this->method == $this->fetch_class())
		{
			echo "masuk ==";
			return 'index_action';
		}

			echo "ga masuk ==";
		return $this->method;
	}
	

	/**
	 * Set the class name
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function set_class($class)
	{
		$this->class = str_replace('-', '_', str_replace(array('/', '.'), '', $class));
	}

	/**
	 *  Set the method name
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function set_method($method)
	{
		$this->method = str_replace('-', '_', $method . '_action');
	}

	/**
	 * Validates the supplied segments.  Attempts to determine the path to
	 * the controller.
	 *
	 * @access	private
	 * @param	array
	 * @return	array
	 */
	function _validate_request($segments)
	{
		if (count($segments) == 0)
		{
			return $segments;
		}
		
		$segments = str_replace('-', '_', $segments);
		
		return parent::_validate_request($segments);
	}
}
