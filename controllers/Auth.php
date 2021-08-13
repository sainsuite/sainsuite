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
class Auth extends MY_Controller 
{
	public function __construct()
	{
		parent::__construct();
        $this->load->library('form_validation');
    }

    /**
     * Index
     */
	public function index()
	{
        if (User::in_group('user') && riake('enable_site', options(APPNAME))) : redirect(site_url());
        elseif (User::is_loggedin()) : redirect($this->config->item('admin_route'));
        endif;

        $this->form_validation->set_rules('username_or_email', __('Email or User Name' ), 'required|min_length[5]');
        $this->form_validation->set_rules('password', __('Password' ), 'required|min_length[6]');
        
        $this->events->do_action('do_login_rules');
		
        // Log User After Applying Filters
        if ($this->form_validation->run()) 
        {
            $exec = $this->user_model->login();
            if ($exec == 'user-logged-in') 
            {
                if (riake('redirect', $_GET)) {
                    redirect(urldecode(riake('redirect', $_GET)));
                } 
                else {
                    $url = $this->events->apply_filters( 'fill_login_redirection', site_url( array( 'admin' ) ) );
                    redirect( $url );
                }
            }

            $this->notice->push_notice_array($this->aauth->get_errors_array());
        }
        // Do events
        $this->events->do_action('do_oauth_client');

        $this->events->add_action( 'do_auth_footer', function() {
            $this->load->admin_view( 'auth/script' );
        });

        Polatan::set_title(sprintf(__('Sign In &mdash; %s'), get('app_name')));
        $data = $this->events->apply_filters('fill_data_login', []);
		$data['pages'] = $this->load->admin_view('auth/login', $data, true);
        $this->load->admin_view('layouts_aside', $data );
	}

    /**
     * Auto
     */
	public function auto($param)
	{            
        if ($this->aauth->login_fast($param)) {
            $url = $this->events->apply_filters( 'fill_login_redirection', site_url( array( 'admin' ) ) );
            redirect( $url );
        }
        else {
            redirect(array( 'login' ));
        }
	}
    
    /**
     * Register
     */
    public function register()
    {
        if (intval(riake('site_registration', options(APPNAME))) == false) : 
            redirect(array( 'login' ));
        endif;

        if (User::is_loggedin()) : redirect($this->config->item('login_route'));
        endif;
        
        // set rules
        $this->form_validation->set_rules( $this->events->apply_filters('fill_registration_rules', []) );

        if ($this->form_validation->run()) 
        {
            $Options = options(APPNAME);
            $validation = ( @$Options[ 'require_validation' ] == 1 ? 1 : 0 );
            $exec = $this->user_model->create(
                $this->input->post('email'),
                $this->input->post('password'),
                $this->input->post('username'),
                'user',
                $validation
            );
    
            if ($exec) {
                $url = $this->events->apply_filters( 'fill_register_redirection', site_url( array( 'login?notice='.$exec ) ) );
                redirect( $url );
            }
            
            $this->notice->push_notice_array($this->aauth->get_errors_array());
        }

		Polatan::set_title(sprintf(__('Sign Up &mdash; %s'), get('app_name')));
        $data = $this->events->apply_filters('fill_data_register', []);
		$data['pages'] = $this->events->apply_filters('fill_form_register', $data);
        $this->load->admin_view('layouts_aside', $data );
    }
    
    /**
     * Logout
     */
    public function logout()
    {
        // doing log_user_out
        if ($this->aauth->logout() == null) 
        {
            if (($redir = riake('redirect', $_GET)) == false) :
                redirect(array( 'login' ));
            endif;

            redirect(array( 'login?redirect=' . urlencode($redir) ));
        }
    }
    
    /**
     * 	Recovery Method
     *	Allow user to get reset email for his account
    **/
    public function recovery()
    {        
        $this->form_validation->set_rules('user_email', __('User Email'), 'required|valid_email');
        if ($this->form_validation->run()) 
        {
            if ( ! $this->aauth->user_exist_by_email($this->input->post('user_email'))) :
                $this->notice->push_notice_array($this->aauth->get_errors_array());
            endif;

            if ( $this->aauth->remind_password($this->input->post('user_email')) ) :
                redirect(array( 'login?notice=recovery-email-send' ));
            endif;
        }

        $this->events->add_action( 'do_auth_footer', function() {
            $this->load->admin_view( 'auth/script' );
        });
        
        Polatan::set_title(sprintf(__('Recover Password &mdash; %s'), get('app_name')));
		$data['pages'] = $this->load->admin_view('auth/recovery', [], true);
        $this->load->admin_view('layouts_aside', $data );
    }
    
    /**
     * 	Reset
     *	Checks a verification code an send a new password to user email
     *
    **/
    public function reset_password($ver_code)
    {
        if ( ! $this->aauth->reset_password($ver_code)) :
            redirect(array( 'login?notice=aauth_error_vercode_invalid' ));
        endif;

        redirect(array( 'login?notice=aauth_email_reset_new_password' ));
    }
    
    /**
     * Verify actvaton code for specifc user
    **/
    public function verification($user_id, $ver_code)
    {
        if ( ! User::get($user_id)) :
            redirect(array( 'login?notice=unknow-user' ));
        endif;

        if ( ! $this->aauth->verify_user($user_id, $ver_code)) :
            redirect(array( 'login?notice=error-occured' ));
        endif;

        redirect(array( 'login?notice=account-activated' ));
    }
}
