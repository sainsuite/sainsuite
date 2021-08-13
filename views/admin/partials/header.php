<!--begin::Header-->
<div id="ss_header" class="header header-fixed d-none transition">
    <div class="container-fluid flex-wrap flex-sm-nowrap">
        <?php echo $this->menus_model->header_nav(); ?>

        <?php echo $this->events->do_action('do_header_tool'); ?>
    </div>
</div>
<!--end::Header-->