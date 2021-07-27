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
    'namespace' => 'users',
    'class' => 'col-12',
    'col_id' => 1,
    'gui_saver' => false,
    'type' => 'card',
    'form' => array(
        'action' => null,
    ),
    'footer' => 'add',
));

$item[] = array(
    'id' => 1,
    'heading'=> __('Personal Information'),
    'class' => 'card-header-light',
    'description' => 'Update your personal informaiton',
    'show' => true,
    'hide_footer' => true,
    'body' => array(
        'items' => $this->events->apply_filters_ref_array('fill_ref_user_profile', array( [
            'user'=> null,
            'groups'=> $groups,
            'user_group'=> null,
            'page'=> 'users'
        ] ))
    )
);
$item[] = array(
    'id' => 2,
    'heading'=> __('Change Password'),
    'class' => 'card-header-light',
    'description' => 'Change your account password',
    'show' => true,
    'hide_footer' => true,
    'body' => array(
        'items' => $this->events->apply_filters_ref_array('fill_ref_user_pass', array( 
            ['user'=> null, 'page'=> 'users']
        ))
    )
);

$this->polatan->add_item(array(
    'type'  => 'accordions',
    'accordion' => $item
), 'users');

$this->polatan->output();