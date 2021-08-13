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

$this->polatan->add_meta(array(
    'col_id' => 1,
    'class'     => 'col-12',
    'namespace' => 'migrate'
));

$this->polatan->add_item(array(
    'type'    => 'dom',
    'content' => $this->load->admin_view('addons/migrate_dom', array(), true )
), 'migrate', 1);

$this->polatan->output();