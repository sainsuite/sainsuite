<!--begin::Aside-->
<div class="aside d-flex" id="ss_aside">
	<!--begin::Primary-->
	<div class="aside-primary d-flex flex-column align-items-center flex-row-auto">
		<!--begin::Brand-->
		<div class="aside-brand flex-column align-items-center flex-column-auto py-3">
			<!--begin::Logo-->
            <a href="<?php echo site_url(); ?>" class="aside-logo">
				<div id="sain-spinner" class="position-absolute"></div>
                <img alt="<?php echo get('app_name');?>" src="<?php echo upload_url('system/logo-sm.png', base_url()); ?>" class="max-h-40px" />
			</a>
			<!--end::Logo-->

			<!--begin::Aside Toggle-->
			<span class="aside-toggle btn btn-icon btn-white border d-none" id="aside_toggle">
				<i class="icon-sm flaticon2-back"></i>
			</span>
			<!--end::Aside Toggle-->
		</div>
		<!--end::Brand-->

		<!--begin::Nav Wrapper-->
		<div class="aside-nav d-flex flex-column align-items-center flex-column-fluid scroll scroll-pull">

			<!--begin::Nav-->
			<ul class="nav flex-column" role="tablist">

				<!--begin::Item-->
				<li class="nav-item mb-2" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="Application">
					<a href="app" class="nav-link btn btn-icon btn-clean btn-lg d-none mt-4" data-toggle="tab" data-target="#ss_aside_tab_1" role="tab">
						<i class="icon-lg flaticon-squares-4"></i>
					</a>
				</li>

				<?php echo $this->menus_model->aside_nav(); ?>
				<!--end::Item-->
			</ul>

			<!--end::Nav-->
		</div>

		<!--end::Nav Wrapper-->

		<!--begin::Footer-->
		<div class="aside-footer d-flex flex-column align-items-center flex-column-auto">
			
			<?php $this->events->do_action('do_aside_footer', ''); ?>
			<?php echo $this->menus_model->aside_footer_nav(); ?>
			
			<div class="aside-users d-none d-lg-flex">
				<div class="dropdown dropup">
					<a class="symbol symbol-users" data-toggle="dropdown" data-target="user" data-offset="0px,0px" aria-expanded="false">
						<img src="<?php echo $this->events->apply_filters('fill_user_avatar', '');?>" alt="<?php echo $this->events->apply_filters('fill_user_avatar_alt', '');?>">
					</a>
					<!--begin::Dropdown-->
					<?php $this->events->do_action('do_usercard_nav'); ?>
					<!--end::Dropdown-->
				</div>
			</div>
		</div>
		<!--end::Footer-->
	</div>
	<!--end::Primary-->

	<!--begin::Secondary-->
	<div class="aside-secondary d-flex flex-column">
		<div class="aside-title mb-3">
			<div class="aside-brand border-bottom border-bottom-secondary d-flex align-items-center justify-content-between">
				<!--begin::Logo-->
				<a href="<?php echo site_url('admin'); ?>" class="d-flex mr-5">
					<img alt="Logo" src="<?php echo $this->events->apply_filters( 'fill_apps_logo', ''); ?>" class="max-h-40px" />
				</a>
				<!--end::Logo-->
				<div class="d-flex d-sm-none" id="ss_aside_close_btn">
					<i class="la la-arrow-left icon-2x text-dark"></i>
				</div>
			</div>
		</div>

		<?php echo $this->menus_model->create_nav(); ?>

		<!--begin::Workspace-->
		<div class="aside-workspace scroll scroll-push">
			<!--begin::Tab Content-->
			<div class="tab-content">
				<div class="tab-pane px-3 fade show active" id="ss_aside_tab_1">
					<!--begin::Aside Menu-->
					<div id="ss_aside_menu" class="aside-menu" data-menu-vertical="1" data-menu-scroll="1">
						<!--begin::Menu Nav-->
						<?php echo $this->menus_model->menu_nav(); ?>
						<!--end::Menu Nav-->
					</div>
					<!--end::Aside Menu-->
				</div>
			</div>
		</div>
		<!--end::Tab Content-->
		
		<?php $this->events->do_action('do_aside_workspace_footer', ''); ?>
	</div>
	<!--end::Secondary-->
</div>

<!--end::Aside-->