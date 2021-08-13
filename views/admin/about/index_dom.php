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

$App_Options = options(APPNAME);
?>

<!--begin::Section-->
<div class="row">
    <div class="col-lg-8">
        
        <h3 class="font-weight-bold mb-10 text-dark">
            <img alt="<?php echo get('app_name');?>" src="<?php echo $this->events->apply_filters( 'fill_apps_logo', '' ); ?>" class="max-h-40px" />
        </h3>
        <div class="font-weight-nromal font-size-lg mb-6">
            <p class="lead">
            <?php echo get( 'app_name' ) .' '. __("is up to date"); ?> <br>
            <?php echo sprintf( __( 'Version <b>%s</b> (Official build)' ), get('version') );?>
            </p>
            
            <?php if (riake('site_title', $App_Options)) : ?>
            <p class="flex-column justify-content-end d-flex">
                <span class="opacity-50 font-weight-bold font-size-sm"><?php echo get('app_name');?> for</span>
                <span class="font-size-md"><?php echo riake('site_title', $App_Options);?></span>
            </p>
            <?php endif; ?>
            
            <!-- Cek Update -->
            <?php if ($check) : ?>
            <h6 class="font-weight-bold mb-0 text-dark"><?php echo sprintf(__('%s : %s is available'), get('app_name'), riake('title', $check[0])); ?></h6>
            <p><?php echo $this->markdown->parse(riake('content', $check[0])); ?></p>
            
            <a class="btn btn-primary" href="<?php echo site_url(array( 'admin', 'about', 'core', riake('version', $check[0]) )); ?>">
            <i class="fas fa-circle-notch"></i> <?php _e('Click Here to Update'); ?>
            </a>
            <?php endif; ?>

            <p class="flex-column justify-content-end d-flex mt-10">
                <span class="opacity-50 font-weight-bold font-size-sm">
                <?php _e('If you need help with the SainSuite, please Contact Us ');?>
                </span>
                <span class="font-size-md">
                Telp. - HP. <?php echo riake('admin_contact', $App_Options, '(+62) 822 2069 4668'); ?> <br>
                <?php echo riake('site_email', $App_Options, 'sainteknoid@gmail.com'); ?>
                </span>
            </p>

            <p class="mt-10">
                <?php echo sprintf( __( 'Copyright © %s Developed by %s. All rights reserved.' ), date('Y'), $this->aauth->config_vars['name'] );?>
            </p>
        </div>
    </div>
</div>
<!--end::Section-->