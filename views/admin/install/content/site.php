<!--begin::Form-->
<form method="post" action="<?php echo site_url(array( 'install', 'site' ));?>" class="form" autocomplete="off" id="ss_install_site_form" >
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

	<!--begin::Row-->
	<div class="row">
		<div class="col-xl-6">
			<!--begin::Input-->
			<div class="form-group">
				<input class="form-control h-auto font-size-h5 border-0 p-4"
					type="text"
					name="site_name" 
					placeholder="<?php _e( 'Site Name' );?>" 
					value="<?php echo set_value('site_name'); ?>" />
			</div>
			<!--end::Input-->
		</div>
		<div class="col-xl-6">
			<!--begin::Select-->
			<div class="form-group">
				<select class="form-control h-auto font-size-h5 border-0 p-4"
					name="lang" 
					placeholder="<?php _e('supported languages');?>" ><?php
					foreach (get_instance()->config->item('supported_languages') as $key => $value)  : ?>
						<option <?php echo $key == riake('lang', $_GET) ? 'selected="selected"': ''; ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<!--end::Input-->
		</div>
	</div>
	<!--end::Row-->
	
	<div class="row">
		<div class="col-xl-6">
			<!--begin::Input-->
			<div class="form-group">
				<input class="form-control h-auto font-size-h5 border-0 p-4" 
					type="text"
					name="username" 
					placeholder="<?php _e( 'User Name' );?>" 
					value="<?php echo set_value('username'); ?>" />
			</div>
			<!--end::Input-->
		</div>
		<div class="col-xl-6">
			<!--begin::Input-->
			<div class="form-group">
				<input class="form-control h-auto font-size-h5 border-0 p-4"
					type="text"
					name="email" 
					placeholder="<?php _e( 'Email' );?>" 
					value="<?php echo set_value('email'); ?>" />
			</div>
			<!--end::Input-->
		</div>
	</div>
	<!--end::Row-->
	
	<!--begin::Row-->
	<div class="row">
		<div class="col-xl-6">
			<!--begin::Input-->
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
			<!--end::Input-->
		</div>
		<div class="col-xl-6">
			<!--begin::Input-->
			<div class="form-group">
				<div class="input-icon input-icon-right">
					<input class="form-control h-auto font-size-h5 border-0 p-4"
						type="password" 
						id="form-confirm"
						placeholder="<?php _e('Password Confirm' ); ?>"
						name="confirm" 
						value="<?php echo set_value('confirm'); ?>" />
					<span>
						<a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="form-confirm">
							<em class="passcode-icon icon-show icon fas fa-fingerprint"></em>
							<em class="passcode-icon icon-hide icon far fa-eye-slash"></em>
						</a>
					</span>
				</div>
			</div>
			<!--end::Input-->
		</div>
	</div>
	<!--end::Row-->
</form>
<!--end::Form-->