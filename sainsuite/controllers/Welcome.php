<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
class Welcome extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();
        
        if (! riake('enable_site', options(APPNAME))) {
            redirect($this->config->item('login_route') . '?redirect=' . urlencode(current_url()) );
        }
	}

	public function index()
	{
        $data['pages'] = 'home';
        $this->load->site_view( 'layouts', $this->events->apply_filters('fill_site_index', $data) );
	}

    // not found page
    public function error_404()
    {
        $data['pages'] = '404';
        $this->load->site_view( 'layouts', $this->events->apply_filters('fill_site_404', $data) );
    }
}
