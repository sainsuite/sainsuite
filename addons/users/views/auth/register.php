<div class="login-form">   
    <form method="post" autocomplete="off" id="ss_signup_form" class="form required-form">
        <!--begin::Title-->
        <div class="pb-5">
            <h3 class="font-weight-bolder font-size-h2 font-size-h1-lg"><?php echo __('Sign Up');?></h3>
            
            <div class="text-muted font-weight-bold font-size-h4">
                <?php _e('I Already Have An Account');?>
                <a href="<?php echo site_url('login'); ?>" class="text-primary font-weight-bolder"><?php _e('Sign In'); ?></a>
            </div>
        </div>
        <!--begin::Title-->
        
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <!--begin::Form group-->
        <div class="form-group">
            <input class="form-control h-auto font-size-h5 border-0 p-4"
                type="text" 
                placeholder="<?php _e('User Name' ); ?>" 
                name="username" 
                value="<?php echo set_value('username'); ?>">
        </div>
        <!--end::Form group-->

        <!--begin::Form group-->
        <div class="form-group">
            <input class="form-control h-auto font-size-h5 border-0 p-4"
                type="email" 
                placeholder="<?php _e('Email' ); ?>" 
                name="email" 
                value="<?php echo set_value('email'); ?>">
        </div>
        <!--end::Form group-->

        <div class="row">
            <!--begin::Form group-->
            <div class="form-group col-lg-6">
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
        
            <!--begin::Form group-->
            <div class="form-group col-lg-6">
                <div class="input-icon input-icon-right">
                    <input class="form-control h-auto font-size-h5 border-0 p-4"
                        type="password" 
                        id="form-confirm"
                        placeholder="<?php _e('Confirm' ); ?>"
                        name="confirm" />
                    <span>
                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="form-confirm">
                            <em class="passcode-icon icon-show icon fas fa-fingerprint"></em>
                            <em class="passcode-icon icon-hide icon far fa-eye-slash"></em>
                        </a>
                    </span>
                </div>
            </div>
            <!--end::Form group-->
        </div>
            
        <div class="form-group mt-10">
            <div class="checkbox-inline">
                <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-success mr-auto">
                    <input type="checkbox" name="agree"/>
                    <span></span>
                    I Agree the <a href="#" class="text-primary">terms and conditions</a>.
                </label>
            </div>
        </div> 

        <!--begin::Form group-->
        <div class="pb-lg-0 pb-5">
            <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 btn-block">
                <span class="position-relative" id="ss_singup_form_submit"><?php _e('Sign Up' ) ?></span>
            </button>
        </div>
        <!--end::Form group-->
    </form>
</div>