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
class Install extends MY_Controller 
{
    /**
     * 
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

        $this->events->add_filter('fill_apps_contact', function() {
            $this->load->admin_view( 'install/wizard' );
        });
        $this->events->add_action( 'do_auth_footer', function() {
            $this->load->admin_view( 'install/script' );
        });
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function index()
    {
        // checks if SainSuite is not installed
        if ($this->install_model->is_installed()):
            redirect('welcome?notice=database-installed' );
        endif;

		Polatan::set_title(sprintf(__('Welcome Page &mdash; %s'), get('app_name')));
        $data['pages'] = $this->load->admin_view('install/index', [], true);;
        $this->load->admin_view('layouts_aside', $data );
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function database()
    {
        // checks if SainSuite is not installed
        if ($this->install_model->is_installed()):
            redirect('welcome');
        endif;

        $this->form_validation->set_rules('_ht_name', __('Host Name'), 'required');
        $this->form_validation->set_rules('_uz_name', __('User Name'), 'required');
        $this->form_validation->set_rules('_db_name', __('Database Name'), 'required');
        $this->form_validation->set_rules('_db_driv', __('Database Driver'), 'required');
        $this->form_validation->set_rules('_db_pref', __('Database Prefix'), 'required');

        if ($this->form_validation->run() == FALSE) {
            $success = FALSE;
            $message = validation_errors();
        }
        else{
            $exec = $this->install_model->installation(
                $this->input->post('_ht_name'),
                $this->input->post('_uz_name'),
                $this->input->post('_uz_pwd'),
                $this->input->post('_db_name'),
                $this->input->post('_db_driv'),
                $this->input->post('_db_pref')
            );

            if ($exec == 'database-installed') 
            {
                $success = TRUE;
                $message = $this->lang->line($exec);
            }
            else {
                $success = FALSE;
                $message = $exec;
            }
        }
        
        $json_array = array('success' => $success, 'message' => $message);
        echo json_encode($json_array);
        exit();
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function site()
    {
        // checks if SainSuite is not installed
        if (! $this->install_model->is_installed()):
            redirect('install');
        endif;

        $rules[] = ['field' => 'site_name', 'label' => __('User Name' ), 'rules' => 'required'];
        $this->form_validation->set_rules( $this->events->apply_filters('fill_site_setup', $rules) );
        
        if ($this->form_validation->run() == FALSE) {
            $success = FALSE;
            $message = validation_errors();
        }
        else{
            $exec = $this->install_model->final_configuration();

            if ($exec == 'system-installed') 
            {                      
                $success = TRUE;
                $message = $this->lang->line($exec);
            }
            else {
                $success = FALSE;
                $message = $this->aauth->get_errors_array();
            }
        }
        
        $json_array = array('success' => $success, 'message' => $message);
        echo json_encode($json_array);
        exit();
    }
}
