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
class UsersHomeController extends MY_Addon
{
    private $breadcrumbs = array();

    public function __construct()
    {
        parent::__construct();

        $this->events->add_filter( 'fill_header_nav', array( new Users_Menu, '_header_nav' ));
    }

    private function breadcrumb($array = array())
    {
        $this->breadcrumbs[] = array(
            'id'     => 1,
            'name' => __('Home'), 
            'slug' => site_url('admin')
        );
        $this->breadcrumbs[] = array(
            'id'     => 2,
            'name' => __('Users'), 
            'slug' => site_url('admin/users')
        );
        ($array) ? $this->breadcrumbs[] = $array : '';
        return $this->breadcrumbs;
    }

    /**
     * read users
     *
     * @param integer $index
     * @return void
     */
    public function index( $index = 1 )
    {
        User::control('read.users');

        // Title
		Polatan::set_title(sprintf(__('Users &mdash; %s'), get('signature')));
        
        // BreadCrumb
        $data['breadcrumbs'] = $this->breadcrumb();

        // Data
        $this->addon_view( 'users', 'users/read', $data );
    }

    /**
     * Add user
     *
     * @return void
     */
    public function add()
    {
        User::control('create.users');
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', __('User Name'), 'required|min_length[5]');
        $this->form_validation->set_rules('user_email', __('User Email'), 'required|valid_email');
        $this->form_validation->set_rules('password', __('Password'), 'required|min_length[6]');
        $this->form_validation->set_rules('confirm', __('Confirm' ), 'required|matches[password]');
        $this->form_validation->set_rules('group', __('Group' ), 'required');

        // load custom rules
        $this->events->do_action('do_user_rules');

        if ($this->form_validation->run()) 
        {
            $exec = $this->user_model->create(
                $this->input->post('user_email'),
                $this->input->post('password'),
                $this->input->post('username'),
                $this->input->post('group'),
                $this->input->post('user_status' )
            );
            
            if ($exec == 'created') 
            {
                redirect(array( 'admin', 'users?notice=' . $exec ));
                exit;
            }

            $this->notice->push_notice_array($this->aauth->get_errors_array());
        }
        
        // Title
		Polatan::set_title(sprintf(__('Users &mdash; %s'), get('signature')));
        
        // BreadCrumb
        $data['breadcrumbs'] = $this->breadcrumb(array(
            'id' => 2,
            'name' => __('Add New'), 
            'slug' => site_url('admin/users/add')
        ));

        // Data
        $data['groups'] = $this->aauth->list_groups();
        $this->addon_view( 'users', 'users/form', $data );
    }

    /**
     * Edit user
     * @param int user id
     * @return void
     */
    public function edit($index, $param1 = '' )
    {
        // if current user matches user id
        if (User::id() == $index) {
            redirect(array( 'admin', 'profile' ));
        }

        User::control('edit.users');
        
        // User Goup
        $user = User::get($index);
        if (! $user) {
            $this->session->set_flashdata('info_message', __( 'Unknow user. The use you attempted to edit has not been found.' ));
            redirect(site_url('admin/page404'));
        }

        // validation rules
        $this->load->library('form_validation');
        
        if ($param1 == 'change_password') 
        {
            if ( $this->events->apply_filters('fill_old_password', User::get($index)->id) ) {
                $this->form_validation->set_rules('old_pass', __('Old Pass' ), 'required|min_length[6]');
            }
            $this->form_validation->set_rules('password', __('Password' ), 'required|min_length[6]');
            $this->form_validation->set_rules('confirm', __('Confirm' ), 'required|matches[password]');
    
            if ($this->form_validation->run()) 
            {
                $exec = $this->user_model->change_password(
                    $index,
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
                $exec =  $this->user_model->edit(
                    'edit',
                    $index,
                    $this->input->post('user_email'),
                    $this->input->post('group'),
                    $this->input->post('user_status' )
                );
    
                $this->session->set_flashdata('flash_message', $this->lang->line('updated'));
                redirect(current_url(), 'refresh');
            }
        }

        // Title
		Polatan::set_title(sprintf(__('Users &mdash; %s'), get('signature')));
        
        // BreadCrumb
        $data['breadcrumbs'] = $this->breadcrumb( array( 
            'id' => 3,
            'name' => __('Edit'), 
            'slug' => site_url('admin') )
        );

        // Data
		$data['user'] = $user;
		$data['groups'] = $this->aauth->list_groups();
		$data['user_group'] = User::get_user_group($user->id);
        $this->addon_view( 'users', 'users/form_edit', $data );
    }

    /**
     * Delete user
     * @return redirect
     */

    public function delete( $index = null, $redirect = 'users' )
    {
        User::control('delete.users');

        if ( $index == null ) 
        {
            $ids = $this->input->post('ids');
            foreach($ids as $id){
                $this->aauth->delete_user($id);
            }
        }
        else {
            $user = User::get($index);
    
            if ( empty($user) ) :
                redirect(array( 'admin', $redirect.'?notice=unknow-user' ));
            endif;
    
            if( User::id() == $user->id ) : 
                redirect( array( 'admin', 'users?notice=cant-delete-yourself' ) );
            endif;
    
            $exec = $this->aauth->ban_user($index);

            if ($exec) {
                $this->session->set_flashdata('flash_message', __('deleted'));
            } else {
                $this->session->set_flashdata('flash_message', __('unexpected-error'));
            };
        }
    }
}
