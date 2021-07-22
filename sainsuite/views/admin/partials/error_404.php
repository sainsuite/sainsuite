<div class="d-flex flex-column-fluid flex-center" id="sit_home">
    <div class="d-flex flex-column justify-content-center align-items-center px-5 text-center">
        <img class="w-150px" src="<?=img_url();?>svg/error-illustration.svg"/>
        <h3 class="display-4 font-weight-bold mt-7 mb-2"><?php _e('Oops! Why you’re here?');?></h3>
        <p class="opacity-80">
        <?php $this->aauth->print_errors();?>
        </p>
    </div>
</div>