<?php

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

// load field for user_profile
$this->polatan->add_col(array(
    'class' => 'p-10 p-lg-0 flex-row-auto offcanvas-mobile w-200px',
    'id'=> 'aside_panel',
), 1);

$this->polatan->add_meta(array(
    'col_id'    => 1,
    'class'     => 'col-12',
    'namespace' => 'profile',
    'type' => 'card'
));

$this->polatan->add_item( array(
    'type'    => 'dom',
    'content' => $this->addon_view( 'users', 'profile/avatar', array(), true )
), 'profile',  1 );

// =============================================================================== 

// load field for user_profile
$this->polatan->add_col(array(
    'class' => 'flex-row-fluid ml-lg-5',
), 2);

// load field for user_profile
$this->polatan->add_meta(array(
    'col_id' => 2,
    'class'     => 'col-12',
    'namespace' => 'user_profile',
    'gui_saver' => true,
    'type' => 'card',
    'form' => array(
        'action' => site_url('admin/profile')
    ),
));
$user_profile[] = array(
    'id' => 1,
    'class' => 'card-header-light',
    'heading'=> __('Personal Information'),
    'description' => 'Update your personal informaiton',
    'body' => array(
        'items' => $this->events->apply_filters_ref_array('fill_ref_user_profile', array( [
            'user'=> User::get(),
            'groups'=> null,
            'user_group'=> null,
            'page'=> 'profile'
        ] ))
    )
);
$this->polatan->add_item(array(
    'type'  => 'accordions',
    'accordion' => $user_profile
), 'user_profile', 2);

// =============================================================================== 

// load field for user_pass
$this->polatan->add_meta(array(
    'col_id' => 2,
    'class'     => 'col-12',
    'namespace' => 'user_pass',
    'gui_saver' => true,
    'type' => 'card',
    'form' => array(
        'action' => site_url('admin/profile/change_password')
    ),
));
$user_pass[] = array(
    'id' => 2,
    'class' => 'card-header-light',
    'heading'=> __('Change Password'),
    'description' => 'Change your account password',
    'body' => array(
        'items' => $this->events->apply_filters_ref_array('fill_ref_user_pass', array( 
            ['user'=> User::get(), 'page'=> 'profile']
        ))
    )
);
$this->polatan->add_item(array(
    'type'  => 'accordions',
    'accordion' => $user_pass
), 'user_pass', 2);

// =============================================================================== 

echo $this->events->do_action('do_profile_content', '');

$this->polatan->output();