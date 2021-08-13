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
class GroupsHomeController extends MY_Addon
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
            'name' => __('Group'), 
            'slug' => site_url('admin/group')
        );
        ($array) ? $this->breadcrumbs[] = $array : '';
        return $this->breadcrumbs;
    }

    /**
     * Index group
     * @return void
     */
    public function index()
    {
        User::control('read.group');
        
        // Title
		Polatan::set_title(sprintf(__('Group &mdash; %s', 'group'), get('signature')));
        
        // BreadCrumb
        $data['breadcrumbs'] = $this->breadcrumb();
        
        $this->addon_view( 'users', 'group/read', $data );
    }

    /**
     * Add group
     * @return void
     */
    public function add()
    {
        User::control('create.group');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Group Name', 'required');
        $this->form_validation->set_rules('definition', 'Group Definition', 'required');

        if ($this->form_validation->run()) 
        { 
            $exec = $this->aauth->create_group(
                $this->input->post('name'),
                $this->input->post('definition')
            );

            if ($exec) {
                redirect(array( 'admin', 'group?notice=created'));
            } 
            
            $this->notice->push_notice_array($this->aauth->get_infos_array());
        }
        
        // Title
		Polatan::set_title(sprintf(__('Group &mdash; %s', 'group'), get('signature')));
        
        // BreadCrumb
        $data['breadcrumbs'] = $this->breadcrumb(array(
            'id' => 2,
            'name' => __('Add New'), 
            'slug' => site_url('admin/group/add')
        ));

        $this->addon_view( 'users', 'group/form', $data );
    }

    /**
     * Edit group
     * @param int group id
     * @return void
     */
    public function edit( $index = "" )
    {
        User::control('edit.group');

        // Submit
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Group Name', 'required');
        $this->form_validation->set_rules('definition', 'Group Definition', 'required');
        
        if ($this->form_validation->run()) 
        { 
            $exec = $this->aauth->update_group(
                $index,
                $this->input->post('name'),
                $this->input->post('definition')
            );

            if ($exec) {
                $this->session->set_flashdata('flash_message', $this->lang->line('updated'));
                redirect(current_url(), 'refresh');
            } 
            
            $this->notice->push_notice_array($this->aauth->get_errors_array());
        }

        // Title
		Polatan::set_title(sprintf(__('Group &mdash; %s', 'group'), get('signature')));
        
        // BreadCrumb
        $data['breadcrumbs'] = $this->breadcrumb( array( 
            'id' => 3,
            'name' => __('Edit'), 
            'slug' => site_url('admin/group/edit') )
        );

        // Data
        $data['group'] = $this->aauth->get_group($index);
        
        $this->addon_view( 'users', 'group/form', $data );
    }

    /**
     * Delete group
     * @param int group id
     * @return redirect
     */
    public function delete( $index = null )
    {
        User::control('delete.group');

        // Multi delete
        if ( $index == null ) 
        {
            $ids = $this->input->post('ids');
            foreach($ids as $id){
                $this->aauth->delete_group($id);
            }
        }
        else {
            $exec = $this->aauth->delete_group($index);

            if ($exec) {
                $this->session->set_flashdata('flash_message', __('deleted'));
            } else {
                $this->session->set_flashdata('flash_message', __('unexpected-error'));
            };
        }
    }
}