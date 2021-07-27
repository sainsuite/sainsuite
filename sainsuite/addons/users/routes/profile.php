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
class UsersProfileController extends MY_Addon
{
    private $breadcrumbs = array();

    public function __construct()
    {
        parent::__construct();
    }

    private function breadcrumb($array)
    {
        $this->breadcrumbs = array_merge(
            array( 'name' => __('Home', 'addkit'), 'slug' => site_url('admin') ),
            array( 'name' => User::get()->username, 'slug' => '#' ), 
            $array
        );
       return $this->breadcrumbs;
    }
    
    public function index($param1 = '')
    {		
        User::control('edit.profile');

        $this->load->library('form_validation');
        
        if ($param1 == 'change_password') 
        {
            if ( $this->events->apply_filters('fill_old_password', User::id()) ) {
                $this->form_validation->set_rules('old_pass', __('Old Pass' ), 'required|min_length[6]');
            }
            $this->form_validation->set_rules('password', __('Password' ), 'required|min_length[6]');
            $this->form_validation->set_rules('confirm', __('Confirm' ), 'required|matches[password]');
    
            if ($this->form_validation->run()) 
            {
                $exec = $this->user_model->change_password(
                    User::id(),
                    $this->input->post('password'),
                    $this->input->post('old_pass')
                );   
    
                if ($exec == 'password_updated') {
                    $this->session->set_flashdata('flash_message', __('password updated'));
                }
                else {
                    $this->session->set_flashdata('error_message', $this->lang->line($exec));
                }
                
                $this->user_model->refresh_user_meta();
                redirect(current_url(), 'refresh');
            }
        }
        else {
            // load custom rules
            $this->form_validation->set_rules('user_email', __('User Email' ), 'valid_email');

            if ($this->form_validation->run()) {
                $exec = $this->user_model->edit(
                    'profile',
                    User::id(),
                    $this->input->post('user_email')
                );   
                
                $this->user_model->refresh_user_meta();
                $this->session->set_flashdata('flash_message', $this->lang->line($exec));
                redirect(current_url(), 'refresh');
            }
        }

        $this->events->add_filter('fill_mobile_toggle', function () { return true; });
        $this->events->add_filter('fill_mobile_toggle_row', function () { 
            return 'd-flex flex-row';
        });
        
        Polatan::set_title(__( 'My Profile' ));

        $data[ 'apps' ] = '';
        $this->addon_view( 'users', 'profile/read', $data );
    }
}
