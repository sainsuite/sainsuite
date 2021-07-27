<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
class Users_Addons extends MY_Addon
{
    public function __construct()
    {
        parent::__construct();
        
        $this->lang->load_lines(dirname(__FILE__) . '/language/*.php');

        $this->load->library('aauth');
        $this->load->library('user');
        
        $this->load->model('user_model');
    }
}
new Users_Addons;