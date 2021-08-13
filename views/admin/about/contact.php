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

global $Options;
$App_Options = options(APPNAME);
?>

<div class="flex-column justify-content-lg-start d-none d-lg-flex">
    <h2 class="m-0 font-weight-boldest display5 display1-lg">
        <?php echo ($name = riake('site_name', $App_Options)) ? $name : __('We Got A<br> Surprise');?>.
    </h2>
    <h4 class="m-0 font-weight-boldest display5">
        <?php echo ($name = riake('site_title', $App_Options)) ? $name : __('sainsuite');?>.
    </h4>
    <small class="lead mb-20"><?php echo ($desc = riake('site_description', $App_Options)) ? $desc : __('To Grow Your Business');?></small>

    <p class="flex-column justify-content-end d-flex">
        <span class="opacity-50 font-weight-bold font-size-sm">
        <?php _e('If you need help with the SainSuite, please Contact Us ');?>
        </span>
        <span class="font-size-md">
        Telp. - HP. <?php echo riake('admin_contact', $App_Options, '(+62) 822 2069 4668'); ?> <br>
        <?php echo riake('site_email', $App_Options, 'sainteknoid@gmail.com'); ?>
        </span>
    </p>
</div>