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

// Toolbar
$this->events->add_filter( 'fill_toolbar_nav', function( $final ) {
    $final[] = array(
        'id' => 1,
        'name'   => __('Back to the list'),
        'icon'    => 'ss ss-long-arrow-back',
        'attr_anchor'  => 'class="btn btn-light btn-sm font-weight-bolder"',
        'slug'    => site_url([ 'admin', 'users' ]),
        'permission' => 'create.users'
    );
    return $final;
});

$this->polatan->add_meta(array(
    'class' => 'col-12',
    'col_id' => 1,
    'namespace' => 'users',
    'gui_saver' => true,
    'type' => 'card',
    'form' => array(
        'action' => site_url('admin/users/edit/'.$user->id)
    ),
));
$this->polatan->add_item(array(
    'type'  => 'accordions',
    'accordion' => array(
        [
            'id' => 1,
            'class' => 'card-header-light',
            'heading'=> __('Personal Information'),
            'description' => 'Update your personal informaiton',
            'show' => true,
            'body' => array(
                'items' => $this->events->apply_filters_ref_array('fill_ref_user_profile', array( [
                    'user'=> $user, 
                    'groups'=> $groups,
                    'user_group'=> $user_group,
                    'page'=> 'users'
                ] ))
            )
        ]
    )
), 'users');

// =============================================================================== 

// load field for user_pass
$this->polatan->add_meta(array(
    'class' => 'col-12',
    'col_id' => 1,
    'namespace' => 'user_pass',
    'gui_saver' => true,
    'type' => 'card',
    'form' => array(
        'action' => site_url('admin/users/edit/'.$user->id.'/change_password')
    ),
));
$this->polatan->add_item(array(
    'type'  => 'accordions',
    'accordion' => array(
        [
            'id' => 2,
            'class' => 'card-header-light',
            'heading'=> __('Change Password'),
            'description' => 'Change your account password',
            'body' => array(
                'items' => $this->events->apply_filters_ref_array('fill_ref_user_pass', array( 
                    ['user'=>$user, 'page'=> 'users']
                ))
            )
        ]
    )
), 'user_pass');

// =============================================================================== 

$this->polatan->output();