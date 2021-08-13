<!--begin::Footer-->
<div class="footer py-4 d-flex flex-lg-column" id="ss_footer">

	<!--begin::Container-->
	<div class="container d-flex flex-column flex-md-row align-items-center">

		<!--begin::Copyright-->
		<div class="text-muted mr-lg-auto">
			<a href="http://saintekno.id/" target="_blank" class="text-hover-primary">
				<?php echo $this->events->apply_filters('fill_dash_footer_text', sprintf( __( '%s %s' ), __( 'Thank you for using' ), get( 'app_name' ) ) );?>
			</a>
		</div>

		<!--begin::Nav-->
		<?php echo $this->menus_model->infocenter_nav(); ?>
	</div>

</div>
