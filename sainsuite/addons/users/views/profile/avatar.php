<?php global $User_Options;?>

<!--begin::User-->
<div class="d-flex">
    <div class="symbol symbol-60 mr-5 align-self-start align-self-xxl-center">
        <div class="symbol-label"
            style="background-image:url('<?php echo User::get_user_image_url(User::get()->id);?>')">
        </div>
    </div>
    <div>
        <div class="font-weight-bolder font-size-h5  text-hover-primary">
            <?php echo User::get()->username;?>
        </div>
        <div class="text-muted">
            <?php echo User::get_user_group()->definition;?>
        </div>
    </div>
    <div class="d-flex ml-auto d-lg-none" id="aside_close">
        <i class="la la-arrow-left icon-2x text-dark"></i>
    </div>
</div>
<!--end::User-->
<hr>
<!--begin::Contact-->
<div>
    <?php echo $this->events->apply_filters('fill_member_from', '');?>
    
    <div class="d-flex align-items-center justify-content-between ml-n2">
        <div class="radio-inline">
            <label class="radio radio-accent radio-dark mr-0">
                <input type="radio" class="radio" name="color-mode" id="skin-dark" />
                <span class="mr-1"></span>
            </label>
            <label class="radio radio-accent radio-secondary mr-0">
                <input type="radio" class="radio" name="color-mode" id="skin-light" />
                <span class="mr-1"></span>
            </label>
            <label class="radio radio-accent radio-system mr-0">
                <input type="radio" class="radio" name="color-mode" id="skin-system" />
                <span class="mr-1"></span>
            </label>

            <?php echo $this->events->do_action('do_skin_users');?>
        </div>
    </div>
</div>
<!--end::Contact-->

<?php echo $this->events->do_action('do_profile_menu', '');?>