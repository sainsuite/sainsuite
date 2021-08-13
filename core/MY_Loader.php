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
class MY_Loader extends CI_Loader
{
    public function __construct()
    {
        parent::__construct();
        $this->library('polatan');
        $this->helper('polatan');
    }

	// --------------------------------------------------------------------

    /**
     * Addon View
     *
     * @param string addon namespace
     * @param string path
     * @param array var
     * @param bool return of no
     * @return string/object
    **/

    public function addon_view($addon_namespace, $view, $vars = array(), $return = false)
    {
        $view = str_replace( '.', '/', $view );
        return $this->_ci_load(array( 
            '_ci_view' => '../addons/' . $addon_namespace . '/views/' . $view, 
            '_ci_vars' => $this->_ci_prepare_view_vars($vars), 
            '_ci_return' => $return));
    }

	// --------------------------------------------------------------------

    /**
     * Admin View
     *
     * @param string path
     * @param array var
     * @param bool return of no
     * @return string/object
    **/

    public function admin_view( $view, $vars = array(), $return = false)
    {
        return $this->_ci_load(array( 
            '_ci_view' => get_instance()->config->item('admin_path') . admin_theme() . $view, 
            '_ci_vars' => $this->_ci_prepare_view_vars($vars), 
            '_ci_return' => $return));
    }

	// --------------------------------------------------------------------

    /**
     * Site View
     *
     * @param string path
     * @param array var
     * @param bool return of no
     * @return string/object
    **/

    public function site_view($view, $vars = array(), $return = false)
    {
        return $this->_ci_load(array( 
            '_ci_view' => get_instance()->config->item('site_path') . site_theme() . $view, 
            '_ci_vars' => $this->_ci_prepare_view_vars($vars), 
            '_ci_return' => $return));
    }
}
