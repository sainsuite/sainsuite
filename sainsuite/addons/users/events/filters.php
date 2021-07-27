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
class Users_Filters extends MY_Addon
{
    public function __construct()
    {
        parent::__construct();
        $this->events->add_filter('fill_ref_user_profile', array( $this, 'load_user_profile' ));
        $this->events->add_filter('fill_ref_user_pass', array( $this, 'load_user_pass' ));

        $this->events->add_filter('fill_apps_logo', array( $this, 'apps_logo' ), 1, 1);
        $this->events->add_filter('fill_apps_contact', array( $this, 'fill_apps_contact' ), 5, 1);
        $this->events->add_filter('fill_user_avatar', function () {
            return User::get_user_image_url(User::id());
        });
        
        $this->events->add_filter('fill_form_register', array( $this, 'fill_form_register' ), 1, 1);
        $this->events->add_filter('fill_registration_rules', array( $this, 'fill_registration_rules' ), 1);
    }
    
    public function load_user_profile($config)
    {        
        $filed[] = array(
            'type'        => 'input-image',
            'wrapper'     => 'user',
            'accept'      => '.png, .jpg, .jpeg',
            'label'       => __('User Image'),
            'name'        => 'user_image',
            'id'          => 'user_image',
            'value'       => (isset($config['user'])) ? $config['user']->id : '',
            'description' => 'Allowed file types: png, jpg, jpeg.'
        );

        $filed[] = array(
            [
                'label'    => __('User Name' ),
                'class'    => 'col-12 col-lg-6 col-md-6',
                'type'     => 'text',
                'name'     => 'username',
                'readonly' => (isset($config['user'])) ? true : '',
                'required' => (empty($config['user'])) ? true : '',
                'value'    => set_value('username', (isset($config['user']) ? $config['user']->username : ''))
            ],
            [
                'label'    => __('User Email' ),
                'class'    => 'col-12 col-lg-6 col-md-6',
                'type'     => 'text',
                'name'     => 'user_email',
                'readonly' => (isset($config['user'])) ? true : '',
                'required' => (empty($config['user'])) ? true : '',
                'value'    => set_value('user_email', (isset($config['user']) ? $config['user']->email : ''))
            ]
        );
        
        if (isset($config['page']) && $config['page'] != 'profile' && isset($config['groups'])) :
            $groups_array = array();
            foreach ( force_array($config['groups']) as $group) {
                $groups_array[ $group->id ] = $group->definition != null ? $group->definition : $group->name;
            }
            $filed[] = array(
                [
                    'type'    => 'select',
                    'class'   => 'col-12 col-lg-6 col-md-6',
                    'name'    => 'user_status',
                    'label'   => __('User Status' ),
                    'options' => array(
                        ''  => __( 'Default' ),
                        '0' => __( 'Active'  ),
                        '1' => __( 'Unactive'  )
                    ),
                    'active' => (isset($config['user'])) ? $config['user']->banned : ''
                ],
                [
                    'type'     => 'select',
                    'class'    => 'col-12 col-lg-6 col-md-6',
                    'label'    => __('Add to a group' ),
                    'name'     => 'group',
                    'readonly' => ($groups_array) ? false : true,
                    'required' => ($groups_array) ? true : false,
                    'options'  => $groups_array,
                    'active'   => (isset($config['user_group'])) ? $config['user_group']->group_id : ''
                ]
            );
        endif;

        $filed = $this->events->apply_filters_ref_array('fill_ref_field_user_profile', array( 
            array_merge(
                $filed,
                ['user'=> $config['user']],
                ['page'=> $config['page']],
                ['groups'=> $config['groups']],
                ['user_group'=> $config['user_group']]
            )
        ));

        return $filed;
    }
    
    public function load_user_pass($config)
    {
        $cek_id = (! empty($config['user'])) ? $config['user']->id : false;
        if ( $this->events->apply_filters('fill_old_password', $cek_id ) ) {
            $filed[] = array(
                'type'  => 'password',
                'class' => 'col-12 col-lg-6 col-md-6',
                'label' => __('Old Password' ),
                'name'  => 'old_pass',
            );
        }
        $filed[] = array(
            [
                'type'  => 'password',
                'class' => 'col-12 col-lg-6 col-md-6',
                'required'  => (empty($config['user'])) ? true : '',
                'label' => __('New Password' ),
                'name'  => 'password'
            ],
            [
                'type'  => 'password',
                'class' => 'col-12 col-lg-6 col-md-6',
                'required'  => (empty($config['user'])) ? true : '',
                'label' => __('Confirm New' ),
                'name'  => 'confirm'
            ]
        );

        return $filed;
    }

    public function apps_logo($config_logo = null)
    {
        $App_Options = options(APPNAME);

        $media = 'media/medium/';
        if ($config_logo == 'light') {
            $logo = ( $logo_new = riake('logo_light', $App_Options)) ? upload_url($media.$logo_new) : upload_url('system/logo-light.png', base_url());
        } 
        else {
            $logo = ( $logo_new = riake('logo', $App_Options)) ? upload_url($media.$logo_new) : upload_url('system/logo-dark.png', base_url());
        }

        if ($config_logo == 'sm') {
            $logo = ( $logo_new = riake('favicon', $App_Options)) ? upload_url($media.$logo_new) : upload_url('system/logo-sm.png', base_url());
        }

        return $logo;
    }

    public function fill_apps_contact()
    {
        return $this->load->admin_view( 'about/contact', [], true );
    }

    /**========================================================================
     *                           REgister
     *========================================================================**/
    public function fill_form_register( $data )
    {
        return $this->addon_view( 'users', 'auth/register', $data, true );
    }
    
    public function fill_registration_rules( $rules )
    {
        $rules[] = ['field' => 'username', 'label' => __('User Name' ), 'rules' => 'required|min_length[5]|is_unique[aauth_users.username]'];
        $rules[] = ['field' => 'email', 'label' => __('Email' ), 'rules' => 'valid_email|required|is_unique[aauth_users.email]'];
        $rules[] = ['field' => 'password', 'label' => __('Password' ), 'rules' => 'required|min_length[6]'];
        $rules[] = ['field' => 'confirm', 'label' => __('Confirm' ), 'rules' => 'matches[password]'];

        return $rules;
    }
}
new Users_Filters;