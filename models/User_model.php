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
class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        if ($this->aauth->is_loggedin() && $this->install_model->is_installed()) {
            $this->refresh_user_meta();
        } 
    }

    /**
     * Refresh User Meta
     * @return void
    **/

    public function refresh_user_meta()
    {
        global $User_Options;
        $User_Options = $this->get();
    }

    public function get()
    {
        // fetch data
        $user_option = $this->aauth->get_user_vars();

        $key_value = array();
        foreach (force_array($user_option) as $_option) 
        {
            $value = riake('value', $_option);
            $value = is_array($array = json_decode($value, true)) ? $array : $value; // converting array to JSON
            $value = in_array($value, array( 'true', 'false' )) ? $value === 'true' ? true : false : $value;  // Converting Bool to string

            $key_value[ riake('data_key', $_option) ] = $value;
        }
        return $key_value;
    }

    /**
     * Login
     * @param string
     * @return string
    **/

    public function login()
    {
        $this->aauth->login(
            $this->input->post( 'username_or_email' ),
            $this->input->post( 'password'),
            $this->input->post( 'keep_connected' ) != null ? true : false
        );

        if ( $this->aauth->is_loggedin()) {
            return 'user-logged-in';
        }

        return false;
    }

    /**
     * 	Create user with default privilege
     *
     * @access: public
     * @param : string email
     * @param : string password
     * @param : string name
     * @return: bool
    **/

    public function create($email, $password, $username, $group_par, $require_validation = 1)
    {
        // bind user to a speciifc group
        $user_id = $this->aauth->create_user($email, $password, $username, $group_par);

        $return = 'create-email-send';

        // User Status
        if ($require_validation == 0) {
            $user = User::get($user_id);
            if( $user ) {
                $this->aauth->verify_user($user_id, $user->verification_code);
            }
            
            $return = 'created';
        }

        $value_user_vars = $this->events->apply_filters('fill_user_vars', []);
        $this->aauth->set_user_var('meta', json_encode($value_user_vars), $user_id);

        User::upload_user_image($user_id);

        if ($user_id) {
            return $return;
        }
    }

    /***
     * Edit user
     *
     * @access: public
     * @param
    **/

    public function edit($mode = 'edit', $user_id = '', $email = null, $group_id = null, $user_status = '0')
    {
        $return = 'updated';

        if ($mode == 'profile') 
        {
            // Change user password and email
            $this->aauth->update_user($user_id, ['email'=>$email]);
        }

        // This prevent editing privilege on profile dash
        if ($mode == 'edit') {
            // remove member
            $this->aauth->remove_member($user_id, $group_id);

            // refresh group
            $this->aauth->add_member($user_id, $group_id);

            // Change user password and email
            $this->aauth->update_user($user_id, ['email'=>$email]);

            // User Status
            $user = User::get($user_id);
            if ($user_status == '0') {
                $this->aauth->verify_user($user_id, $user->verification_code);
            } 
            else if( $user_status == '1' ){
                $this->aauth->ban_user($user_id);
            }
        }

        $value_user_vars = $this->events->apply_filters('fill_user_vars', []);
        $this->aauth->set_user_var('meta', json_encode($value_user_vars), $user_id);

        User::upload_user_image($user_id);

        return $return;
    }

    public function change_password($user_id, $password, $old_password)
    {
        $return = 'password_updated';
        
        // old password has been defined
        if ($this->events->apply_filters('fill_old_password', $user_id)) 
        {
            // get user using old password
            $query = User::get($user_id);
            $_password = ($this->aauth->config_vars['use_password_hash'] ? $old_password : $this->aauth->hash_password($old_password, $user_id));
            // if password is correct
            if ($this->aauth->verify_password($_password, $query->pass)) {
                $this->aauth->update_user($user_id, ['pass'=>$password]);
                return $return;
            } 
            else {
                return 'old-pass-incorrect';
            }
        }
        else {
            $this->aauth->update_user($user_id, ['pass'=>$password]);
            return $return;
        }
    }

    /**
     * Creae Master User
     * @param string Email
     * @param string password
     * @param string user name
     * @return string
    **/

    public function create_master($email, $password, $username)
    {
        // Create user
        if ($this->aauth->create_user($email, $password, $username, 'master')) 
        {
            // Add user to a group
            // We assume 1 is the index of the first user
            $master_id = $this->aauth->get_user_id($email);
            
            // Send Verification
            $this->aauth->send_verification($master_id);
            
            return 'created';
        }
        return 'unexpected-error';
    }
}
