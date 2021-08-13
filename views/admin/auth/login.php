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
    
<div class="login-form">
    <!--begin::Title-->
    <div class="pb-5">
        <h3 class="font-weight-bolder font-size-h2 font-size-h1-lg"><?php _e('Sign In');?></h3>
        
        <!-- Should checks whether a registration is enabled -->
        <?php if (intval(riake('site_registration', $App_Options)) == true) : ?>
            <div class="text-muted font-weight-bold font-size-h4">
                <?php _e('New Here?');?>
                <a href="<?php echo site_url('register'); ?>" class="text-primary font-weight-bolder"><?php _e('Create Account'); ?></a>
            </div>
        <?php endif; ?>
    </div>
    <!--begin::Title-->

    <form class="form" id="ss_login_singin_form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <!--begin::Form group-->
        <div class="form-group">
            <input class="form-control h-auto font-size-h5 border-0 p-4"
                type="text" 
                id="form-username"
                placeholder="<?php _e('Email or User Name' ); ?>"
                name="username_or_email" />
        </div>
        <!--end::Form group-->

        <!--begin::Form group-->
        <div class="form-group">
            <div class="input-icon input-icon-right">
                <input class="form-control h-auto font-size-h5 border-0 p-4"
                    type="password" 
                    id="form-password"
                    placeholder="<?php _e('Password' ); ?>"
                    name="password" />
                <span>
                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="form-password">
                        <em class="passcode-icon icon-show icon fas fa-fingerprint"></em>
                        <em class="passcode-icon icon-hide icon far fa-eye-slash"></em>
                    </a>
                </span>
            </div>
        </div>
        <!--end::Form group-->

        <?php $this->events->do_action( 'do_form_login'); ?>
        
        <div class="form-group mt-10">
            <div class="checkbox-inline">
                <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-success mr-auto">
                    <input type="checkbox" name="keep_connected"/>
                    <span></span>
                    <?php _e('Remember me' ) ?>
                </label>
                
                <?php if (intval(riake('site_registration', $App_Options)) == true) : ?>
                <a href="<?php echo site_url(['recovery']) ; ?>"
                    class="text-primary font-size-h6 font-weight-bolder text-hover-primary">
                    <?php _e('I Lost My Password !'); ?>
                </a>
                <?php endif; ?>
            </div>
        </div> 

        <!--begin::Action-->
        <div class="pb-lg-0 pb-5">
            <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 btn-block">
                <span class="position-relative" id="ss_login_singin_form_submit_button"><?php _e('Sign In' ) ?></span>
            </button>
            <?php $this->events->do_action( 'do_oauth_button'); ?>
        </div>
        <!--end::Action-->
    </form>

    <?php
    // Should checks whether a demo is enabled
    if (intval(riake('demo_mode', $App_Options)) == true) : 
    $this->events->do_action('do_demo_account', '');
    endif; ?>
</div>