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
class Users_Action extends MY_Addon
{
    public function __construct()
    {
        parent::__construct();
                
        $this->events->add_action( 'do_usercard_nav', array( $this, 'do_usercard_nav' ), 1);
        $this->events->add_action( 'do_app_init', array($this, 'check_login'));
        $this->events->add_action( 'do_auth_footer', function() {
            $this->addon_view( 'users', 'auth/script' );
        });
    }
    
    public function do_usercard_nav()
    {
        echo'
        <div id="user" class="dropdown-menu dropdown-menu-anim-up dropdown-menu-lg p-0">
            <!--begin::Nav-->
            <ul class="navi">
                <li class="navi-section py-0">
                    <div class="d-flex align-items-center">
                        <i class="flaticon-user icon-5x mr-5"></i>
                        <div class="d-flex flex-column">
                            <div class="font-weight-bold font-size-h3 text-dark-75">'.User::get()->username.'</div>
                            <div class="text-muted">'.User::get()->email.'</div>
                        </div>
                    </div>
                </li>
                <li class="navi-separator"></li>

                '.$this->menus_model->usercard_nav().'
            </ul>
            <div class="navi-footer py-3 mx-5 d-flex">
                <a href="'.xss_clean( site_url('logout' ) . '?redirect=' . urlencode(current_url()) ).'" 
                    class="btn btn-light-danger btn-sm font-weight-bold">
                    <i class="fas fa-sign-out-alt"></i>'. __('Sign Out').'
                </a>
                <a href="'.site_url([ 'admin', 'profile' ]).'" 
                    class="btn btn-sm btn-primary font-weight-bold ml-auto">
                    <i class="fas fa-user-circle"></i> '.__('View Profile').'
                </a>
            </div>
            <!--end::Nav-->
        </div>';
    }

    /**
     * go login
     *
     * @return redirect route login
     */
    public function check_login()
    {
        if (in_array(strtolower($this->uri->segment(1)), $this->config->item('admin_route'))) 
        {
            if (! User::is_loggedin() || ! User::get()) {
                redirect($this->config->item('login_route') . '?notice=login-required&redirect=' . urlencode(current_url()) );
            }
        }
    }
}
new Users_Action;