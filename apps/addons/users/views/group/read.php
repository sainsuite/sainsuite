<?php

/**
 * SainSuite
 *
 * Engine Management System
 *
 * @package     SainSuite
 * @copyright   Copyright (c) 2019-2020 Buddy Winangun, Eracik.
 * @copyright   Copyright (c) 2020 SainTekno, SainSuite.
 * @link        https://github.com/saintekno/sainsuite
 * @filesource
 */

$complete_group = array();
$edit_group     = '';
$hapus_group    = '';
// adding group to complete_group array
foreach ($groups as $row) {
    if ( User::control('edit.group')) {
        $edit_group = '<a href="' . site_url(array( 'admin', 'group', 'edit', $row->id )) . '" 
                class="btn btn-icon btn-light btn-hover-primary btn-sm"><i class="fas fa-pen"></i></a>';
    }
    if ( User::control('delete.group')) {
        $hapus_group = '<button class="btn btn-icon btn-light btn-hover-danger btn-sm"
                data-head=\'' . _s( 'Would you like to delete data?', 'aauth' ) . '\'
                data-url=\'' . site_url(array( 'admin', 'group', 'delete', $row->id )) . '\'
                onclick="deleteConfirmation(this)"><i class="fas fa-trash-alt"></i></button>';
    }
    $complete_group[] = array(
        $row->id,
        '<div class="d-flex align-items-center">
            <div class="symbol symbol-40 symbol-light-primary flex-shrink-0">
                <span class="symbol-label font-size-h4 font-weight-bold">' . strtoupper(substr($row->name, 0, 1)) . '</span>
            </div>
            <div class="ml-4 d-none d-md-block">
                <div class="">' . $row->name . '</div>
            </div>
        </div>',
        $row->definition,
        $edit_group.' '.$hapus_group
    );
}

/**
 * Col Width
 */
$this->polatan->col_width(1, 4);

/**
 * Meta
 */
$this->polatan->add_meta(array(
    'namespace'  => 'group',
    'col_id' => 1,
    'type' => 'card'
));

/**
 * Item
 */
$this->polatan->add_item(array(
    'type'  => 'table-default',
    'thead' => array(
        __('Checkall'), 
        'Name',
        'Definition',
        __('Actions') 
    ),
    'tbody' => $complete_group
), 'group', 1);

/**
 * Script
 */
if (count($complete_group) > 0) :
$this->events->add_action( 'dashboard_footer', function() {
    $this->load->addon_view( 'users', 'group/script');
});
endif;

$this->polatan->output();