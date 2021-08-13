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

/**========================================================================
 *                           Toolbar
 *========================================================================**/
if ( User::is_allowed('manage.core') ) : 
$this->events->add_filter('fill_toolbar_filter', function ($filter) { 
    $filter[] = '<div class="row d-flex align-items-center">';
    if (User::in_group('master')):
    $filter[] = '
    <div class="col-auto col-sm-auto mb-1 mb-sm-0">
        <span class="switch switch-outline switch-icon switch-success">
            <label data-toggle="tooltip" title="Developer mode">
                <input type="checkbox" '.$this->events->apply_filters('fill_dev_mode', '').' id="dev_mode">
                <span></span>
            </label>
        </span>
    </div>';
    $filter[] = '
    <div class="col-auto col-sm-auto mb-1 mb-sm-0">
        <button class="btn btn-primary font-weight-bolder ml-2" 
            onclick="composeModal(\''.site_url(['admin', 'appearance', 'install_zip']).'\', \''.__('Choose the themes zip file').'\')" >
            '.__('Add themes').'
        </button>
    </div>';
    endif;
    $filter[] = '</div>';

    return $filter;
});
endif;

/**========================================================================
 *                           Assets
 *========================================================================**/
$this->events->add_action( 'do_dashboard_footer', function() {
    $this->load->admin_view('appearance/scripts' );
});

/**========================================================================
 *                           Polatan
 *========================================================================**/

$this->polatan->add_meta(array(
    'col_id' => 1,
    'class'     => 'col-12',
    'namespace' => 'theme'
));

$this->polatan->add_item(array(
    'type'    => 'dom',
    'content' => $this->load->admin_view('appearance/list_dom', array(), true )
), 'theme', 1);

$this->polatan->output();