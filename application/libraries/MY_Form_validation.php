<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * extend validation class
 */
class MY_Form_validation extends CI_Form_validation {

	/**
	 * constructor
	 */
	public function __construct($rules = array())
	{
		parent::__construct($rules);
	}

	/**
	 * check string is not equal
	 */
	public function not_equal($str, $val)
	{
		if ($str == '') {
			return TRUE;
		}
		if ($str == $val) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	/**
	 * check string is date format
	 */
	public function date($str, $val)
	{
		if ($str == '') {
			return FALSE;
		}

		$dates = explode(',', $val);
		if (count($dates) != 3) {
			return FALSE;
		}

		$day   = (int) $_POST[$dates[2]];
		$month = (int) $_POST[$dates[1]];
		$year  = (int) $_POST[$dates[0]];

		return checkdate($month, $day, $year);
	}

	/**
	 * check phone is valid
	 */
	public function phone($phone)
	{
		$pattern = '/^(\+|\d+|-|\(|\))*$/';
		$valid = preg_match($pattern, $phone);

		if ($valid) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
