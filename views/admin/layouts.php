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
    
global $User_Options;
?>
<!doctype html>
<HTML>
<!-- begin::Head -->
<HEAD>
    <!-- begin::Meta -->
    <?php $this->load->admin_view( 'partials/metas.php' );?>
    <!-- end::Meta -->
    <!-- begin::Layout Themes -->
    <?php $this->events->do_action( 'do_dashboard_header' );?>
    <!--end::Layout Themes-->
</HEAD>
<!-- end::Head -->
<!-- begin::Body -->
<BODY id="ss_body" 
    class="header-mobile-fixed footer-fixed aside-enabled aside-fixed subheader-enabled subheader-transparent 
    <?php echo ($aside = riake('aside', $User_Options)) ? $aside : 'aside-minimize';?>
    <?php echo xss_clean($this->events->apply_filters('fill_skin_class', 'skin-system'));?>" 
    <?php echo xss_clean($this->events->apply_filters('fill_body_attrs', 'ng-app="suiteApp"'));?>>
    <!-- begin::Main -->
    <!-- beign::Header Mobile -->
    <?php include('partials/header-mobile.php'); ?>
    <!-- end::Header Mobile -->
    <div class="d-flex flex-column flex-root">
        <!-- begin::Page -->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Aside-->
            <?php include('partials/aside.php');?>
            <!--end::Aside-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid min-vh-100 wrapper" id="ss_wrapper">
                <!--begin::Header-->
                <?php include('partials/header.php'); ?>
                <!--end::Header-->
                <!--begin::Content-->
                <div class="content d-flex flex-column flex-column-fluid" id="ss_content">
                    <!--begin::Subheader-->
                    <?php include('partials/subheader.php'); ?>
                    <!--end::Subheader-->
                    <!--begin::Entry-->
                    <?php echo $this->events->apply_filters(
                        'fill_content', 
                        $this->load->admin_view('partials/content', [], TRUE) ); ?>
                    <!--end::Entry-->
                </div>
                <!--end::Content-->
                <!--begin::Footer-->
                <?php include('partials/footer.php'); ?>
                <!--end::Footer-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!-- end::Page -->
    </div>
    <!-- end::Main -->
    <!-- begin::Modal -->
    <?php include('partials/modal.php'); ?>
    <!-- end::Modal -->
    <!-- begin::offcanvas -->
    <?php include('partials/offcanvas.php'); ?>
    <!-- end::offcanvas -->
    <!--begin::Scrolltop-->
    <?php include('partials/scrolltop.php'); ?>
    <!--end::Scrolltop-->
    <!-- begin::Layout Themes -->
    <?php $this->events->do_action( 'do_dashboard_footer' );?>
    <!--end::Layout Themes-->
</BODY>
<!--end::Body-->
</HTML>