<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * SainSuite
 *
 * Engine Management System
 *
 * @package     SainSuite
 * @author	    Buddy Winangun
 * @license	    MIT License. For full terms see the file LICENSE.
 * @link        https://github.com/saintekno/sainsuite
 * @filesource
 */
class Modal extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		/*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}

	function popup($page_name = '' , $param2 = '' , $param3 = '', $param4 = '', $param5 = '', $param6 = '', $param7 = '')
	{
		$logged_in_user_role = strtolower($this->session->userdata('role'));
		$page_data['param2'] = $param2;
		$page_data['param3'] = $param3;
		$page_data['param4'] = $param4;
		$page_data['param5'] = $param5;
		$page_data['param6'] = $param6;
		$page_data['param7'] = $param7;
		$this->load->addon_view( $page_name , $param2 ,$page_data);
	}
}
