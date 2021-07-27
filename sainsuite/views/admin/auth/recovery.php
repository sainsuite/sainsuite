<div class="login-form">   

    <form method="post" id="ss_login_forgot_form" autocomplete="off" class="form required-form">
        <!--begin::Title-->
        <div class="pb-5 pb-lg-15">
            <h3 class="font-weight-bolder font-size-h2 font-size-h1-lg">Forgotten Password ?</h3>
            <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
        </div>
        <!--end::Title-->

        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <!--begin::Form group-->
        <div class="form-group">
            <input class="form-control h-auto font-size-h5 border-0 p-4" type="email" placeholder="Email" name="user_email" required>
        </div>
        <!--end::Form group-->

        <!--begin::Form group-->
        <div class="row form-group d-flex flex-wrap">
            <div class="btn-group col">
                <a href="<?php echo site_url(array( 'login' ));?>" id="ss_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</a>
                <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">
                    <span class="position-relative" id="ss_login_forgot_form_submit_button"><?php _e('Submit' ) ?></span>
                </button>
            </div>
        </div>
        <!--end::Form group-->
    </form>

</div>
