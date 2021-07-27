<!--begin::Header Mobile-->
<div id="ss_header_mobile" class="header-mobile header-mobile-fixed ">

	<!--begin::Logo-->
	<a href="<?php echo site_url('admin'); ?>" class="header-logo d-flex">
		<img alt="Logo" src="<?php echo $this->events->apply_filters( 'fill_apps_logo', 'light'); ?>" class="max-h-35px" />
	</a>

	<!--end::Logo-->

	<!--begin::Toolbar-->
	<div class="d-flex align-items-center">
		<!--begin::User-->
		<div class="dropdown">
			<!--begin::Toggle-->
			<a class="symbol symbol-30 symbol-white" data-toggle="dropdown" data-target="user" data-offset="0px,0px">
				<span class="symbol-label font-size-h5 font-weight-bold"><?php echo strtoupper(substr(User::get()->username, 0, 2));?></span>
			</a>
			<!--end::Toggle-->

			<!--begin::Dropdown-->
			<?php $this->events->do_action('do_usercard_nav'); ?>
			<!--end::Dropdown-->
		</div>
		<!--end::User-->

		<button class="btn btn-icon btn-clean ml-2" id="ss_aside_mobile_toggle">
			<i class="icon-lg ss ss-bold-more-ver"></i>
		</button>
	</div>

	<!--end::Toolbar-->
</div>

<!--end::Header Mobile-->