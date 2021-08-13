<!--begin::Signin-->
<div class="login-form login-form-signup">
    <!--begin: Wizard Step 1-->
    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
        <!--begin::Title-->
        <div class="pb-10 pb-lg-15">
            <h3 class="font-weight-bolder display5 text-dark text-right">
            <?php _e("Thank for having chosen SainSuite to host your project.");?>
            </h3>
        </div>
    </div>
    <!--end: Wizard Step 1-->
    <!--begin: Wizard Step 2-->
    <div class="pb-5" data-wizard-type="step-content">
        <!--begin::Title-->
        <div class="pt-lg-0 pt-5 pb-15">
            <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">
            <?php _e("Database.");?>
            </h3>
            <div class="text-muted font-weight-bold font-size-h4">
            <?php _e("Configuration.");?>
            </div>
        </div>
        <?php $this->load->admin_view( 'install/content/database' );?>
    </div>
    <!--end: Wizard Step 2-->
    <!--begin: Wizard Step 3-->
    <div class="pb-5" data-wizard-type="step-content">
        <!--begin::Title-->
        <div class="pt-lg-0 pt-5 pb-15">
            <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">
            <?php _e("WebSite.");?>
            </h3>
            <div class="text-muted font-weight-bold font-size-h4">
            <?php _e("Configuration.");?>
            </div>
        </div>
        <!--end::Title-->
        <?php $this->load->admin_view( 'install/content/site' );?>
    </div>
    <!--end: Wizard Step 3-->
    <!--begin: Wizard Actions-->
    <div class="d-flex justify-content-between pt-3">
        <div class="mr-2">
            <button type="button" class="btn btn-light-primary font-weight-bolder font-size-h6 pl-6 pr-8 py-4 my-3 mr-3" data-wizard-type="action-prev">
            <span class="svg-icon svg-icon-md mr-1">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Left-2.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <rect fill="#000000" opacity="0.3" transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000)" x="14" y="7" width="2" height="10" rx="1" />
                        <path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>Previous</button>
        </div>
        <div>
            <button class="btn btn-primary font-weight-bolder font-size-h6 pl-5 pr-8 py-4 my-3" data-wizard-type="action-submit" type="submit" id="ss_install_submit_button">Submit
            <span class="svg-icon svg-icon-md ml-2">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                        <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span></button>
            <button type="button" class="btn btn-primary font-weight-bolder font-size-h6 pl-8 pr-4 py-4 my-3" data-wizard-type="action-next">Next Step
            <span class="svg-icon svg-icon-md ml-1">
                <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Right-2.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24" />
                        <rect fill="#000000" opacity="0.3" transform="translate(8.500000, 12.000000) rotate(-90.000000) translate(-8.500000, -12.000000)" x="7.5" y="7.5" width="2" height="9" rx="1" />
                        <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span></button>
        </div>
    </div>
    <!--end: Wizard Actions-->
</div>