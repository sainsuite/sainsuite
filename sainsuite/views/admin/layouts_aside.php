<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
<!doctype html>
<HTML>

<HEAD>
    <?php $this->load->admin_view('partials/metas.php'); ?>

    <?php
    // Enqueueing header
    $this->enqueue->css_namespace('header');
    $this->enqueue->css('plugins.bundle');
    $this->enqueue->css('style.bundle');
    $this->enqueue->css('skin.bundle');
    $this->enqueue->load_css('header');
    $this->events->do_action( 'do_auth_header' );
    ?>
</HEAD>

<BODY class="skin-<?php echo APPNAME; ?>" >
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-3 wizard d-flex flex-column flex-lg-row flex-column-fluid" id="ss_login">
            <!--begin::Aside-->
            <div class="login-aside d-flex flex-row-auto p-10 p-lg-10">
                <!--begin: Aside Container-->
                <div class="d-flex flex-row-fluid flex-column justify-content-between">
                    <a href="<?php echo site_url(); ?>" class="flex-column-auto pb-lg-0 pb-10">
                        <img alt="<?php echo get('app_name'); ?>" src="<?php echo $this->events->apply_filters('fill_apps_logo', ''); ?>" class="max-h-50px" />
                    </a>
                    <!--begin::Aside Top-->
                    <div class="flex-column-fluid d-flex flex-column justify-content-center">
                        <?php echo $this->events->apply_filters('fill_apps_contact', ''); ?>
                    </div>
                    <!--begin: Aside footer for desktop-->
                    <div class="d-none flex-column d-lg-flex mt-10">
                        <div class="d-flex">
                            <?php echo $this->events->apply_filters( 'fill_dash_footer_copyright', 
                                ( $copyright = riake('site_name', $Options)) ? sprintf( __( 'Copyright © %s %s.' ), date('Y'), $copyright ).__(' All rights reserved') : '' );
                            ?>
                        </div>
                        <div class="opacity-70 font-weight-bold ">
                            <?php echo 'Powered by '.get('signature') ;?>
                        </div>
                    </div>
                    <!--end: Aside footer for desktop-->
                </div>
            </div>
            <!--end::Aside-->

            <!--begin::Content-->
            <div class="login-content flex-column-fluid d-flex flex-column p-10">
                <!--begin::Top-->
                <div class="text-right d-flex justify-content-center">
                    <div class="top-signup text-right d-flex justify-content-end pt-5 pb-lg-0 pb-10">
                        <span class="font-weight-bold text-muted font-size-h4">Having issues?</span>
                        <a href="javascript:;" class="font-weight-bolder text-primary font-size-h4 ml-2" id="ss_login_signup">Get Help</a>
                    </div>
                </div>
                <!--end::Top-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-row-fluid flex-center">
                    <?php echo $pages; ?>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--begin::Content-->
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->

    <?php
    // Enqueueing footer
    $this->load->admin_view('settings.js.php');
    $this->enqueue->js_namespace('footer');
    $this->enqueue->js('plugins.bundle');
    $this->enqueue->js('scripts.bundle');
    $this->enqueue->load_js('footer');
    $this->events->do_action( 'do_auth_footer' );
    ?>
</BODY>

</HTML>