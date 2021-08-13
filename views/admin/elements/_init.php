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

// If Using namespace is enabled
if ( riake('gui_saver', $meta) && riake('use_namespace', $meta)) {
    $form_option = $this->options_model->get(riake('namespace', $meta));
}

foreach (force_array(riake('items', $meta)) as $_item) 
{
    if ( ! is_array($_item) ) {
        continue;
    }
    
    if ( @$_item[ 'permission' ] != null && ! User::is_allowed( $_item[ 'permission' ] ) ) {
        continue;
    }
    
    if ( riake('gui_saver', $meta) && riake('use_namespace', $meta)) {
        $value = strip_tags( xss_clean( ($db_value = riake(@$_item[ 'name' ], $form_option)) ? $db_value : @$_item[ 'name' ] ) );
    }

    $type = @$_item[ 'type' ];
    
    if ( $type == 'input-image') 
    {
        include( dirname( __FILE__ ) . '/input-image.php' );               
    }
    elseif ($type == 'table-datatable') 
    {
        include( dirname( __FILE__ ) . '/table-datatable.php' );                            
    }
    elseif ($type == 'table-lists') 
    {
        include( dirname( __FILE__ ) . '/table-lists.php' );                            
    }
    elseif ($type == 'accordions') 
    {
        include( dirname( __FILE__ ) . '/accordions.php' );               
    }
    elseif ($type == 'dom') 
    {
        echo riake('content', $_item);
    }
    else {
        include( dirname( __FILE__ ) . '/input-default.php' );
    }
}