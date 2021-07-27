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
class Admin_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();   
          
        $this->events->add_filter( 'fill_dev_mode', array( $this, 'fill_dev_mode' ) );
        $this->events->add_filter( 'fill_skin_class', array( $this, 'fill_skin_class' ), 5, 1);

        // Load CSS and JS
        $this->events->add_action( 'do_dashboard_header', array( $this, '_dashboard_header' ), 1 );
        $this->events->add_action( 'do_dashboard_footer', array( $this, '_dashboard_footer' ), 1 );
    }

    /**
     *  Dashboard header
     *  @param void
     *  @return void
    **/

    public function _dashboard_header()
    {
        $this->enqueue->css_namespace( 'dashboard_header' );
        $this->enqueue->css('plugins.bundle');
        $this->enqueue->css('style.bundle');
        $this->enqueue->css('datatables.bundle');
        $this->enqueue->css('skin.bundle');
        $this->enqueue->load_css( 'dashboard_header' );

        $this->load->admin_view('settings.js.php');
        $this->enqueue->js_namespace( 'dashboard_header' );
        $this->enqueue->js('plugins.bundle');
        $this->enqueue->js('scripts.bundle');
        $this->enqueue->load_js( 'dashboard_header' );
    }

    /**
     *  Dashboard Footer
     *  @param void
     *  @return void
    **/

    public function _dashboard_footer()
    {
        $this->enqueue->js_namespace( 'dashboard_footer' );
        $this->enqueue->js('angular.min');
		$this->enqueue->js('underscore-min');
		$this->enqueue->js('canvasloader-min');
        $this->enqueue->js('datatables.bundle');
        $this->enqueue->load_js( 'dashboard_footer' );
        $this->load->admin_view('scripts.js.php');
    }

    /**
     * Get dashboard skin for current user
     *
     * @access : public
     * @param : string
     * @return : string
    **/
    public function fill_skin_class($class)
    {
        global $User_Options;
        // skin is defined by default
        $skin = ($db_skin = riake('theme-skin', $User_Options)) ? $db_skin : $class;
        return $skin;
    }

    /**
     * Get dashboard skin for current user
     *
     * @access : public
     * @param : string
     * @return : string
    **/
    public function fill_dev_mode($class)
    {
        // skin is defined by default
        $class = (riake('webdev_mode', options(APPNAME))) ? 'checked="checked"' : '';
        return $class;
    }
}
