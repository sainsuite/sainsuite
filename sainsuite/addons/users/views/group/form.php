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
        'id'          => 1,
        'name'        => __('Back to the list'),
        'icon'        => 'ss ss-long-arrow-back',
        'attr_anchor' => 'class="btn btn-light btn-sm font-weight-bolder"',
        'slug'        => site_url([ 'admin', 'group' ])
    );
    return $final;
});

/**
 * Meta
 */
$this->polatan->add_meta(array(
    'col_id'    => 1,
    'class'     => 'col-12',
    'namespace' => 'group',
    'gui_saver' => false,
    'form'      => array(
        'action' => null,
    ),
    'footer' => (isset($group)) ? 'edit' : 'add',
    'type' => 'card',
));


/**
 * Item
 */
$this->polatan->add_item(array(
    [
        'type'  => 'text',
        'class' => 'col-6',
        'label' => __('Name'),
        'name'  => 'name',
        'required'  => true,
        'value' => (isset($group))
            ? set_value('name', $group->name) 
            : set_value('name'),
    ],
    [
        'type'  => 'text',
        'class' => 'col-6',
        'label' => __('Definition'),
        'name'  => 'definition',
        'required'  => true,
        'value' => (isset($group))
            ? set_value('definition', $group->definition) 
            : set_value('definition'),
    ]
), 'group');

$this->polatan->output();