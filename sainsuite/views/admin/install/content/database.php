<!--begin::Form-->
<form method="post" action="<?php echo site_url(array( 'install', 'database' ));?>" class="form" autocomplete="off" id="ss_install_db_form" >
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

	<!--begin::Row-->
	<div class="row">
		<div class="col-xl-6">
			<!--begin::Input-->
			<div class="form-group">
				<input class="form-control h-auto font-size-h5 border-0 p-4"
					type="text"
					name="_ht_name" 
					placeholder="<?php echo __( 'Host Name' );?>" 
					value="<?php echo set_value('_ht_name', 'localhost'); ?>" />
			</div>
			<!--end::Input-->
		</div>
		<div class="col-xl-6">
			<!--begin::Select-->
			<div class="form-group">
				<select class="form-control h-auto font-size-h5 border-0 p-4"
					name="_db_driv" 
					placeholder="<?php _e('Database Driver');?>" >
					<option value=""><?php _e('Select database driver');?></option>
					<option <?php echo set_select('_db_driv', 'mysqli', true);?> value="mysqli"><?php _e('MySQLi');?></option> 
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
					name="_db_name" 
					placeholder="<?php echo __( 'Database Name' );?>" 
					value="<?php echo set_value('_db_name'); ?>" />
			</div>
			<!--end::Input-->
		</div>
		<div class="col-xl-6">
			<!--begin::Input-->
			<div class="form-group">
				<input class="form-control h-auto font-size-h5 border-0 p-4"
					type="text"
					name="_db_pref" 
					placeholder="<?php echo __( 'Database Prefix' );?>" 
					value="<?php echo set_value('_db_pref', 'sain_'); ?>" />
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
				<input class="form-control h-auto font-size-h5 border-0 p-4"
					type="text"
					name="_uz_name" 
					placeholder="<?php echo __( 'User Name' );?>" 
					value="<?php echo set_value('_uz_name', 'root'); ?>" />
			</div>
			<!--end::Input-->
		</div>
		<div class="col-xl-6">
			<!--begin::Input-->
			<div class="form-group">
				<input class="form-control h-auto font-size-h5 border-0 p-4"
					type="text"
					name="_uz_pwd" 
					placeholder="<?php _e('User Password');?>" 
					value="<?php echo set_value('_uz_pwd'); ?>" />
			</div>
			<!--end::Input-->
		</div>
	</div>
	<!--end::Row-->
</form>
<!--end::Form-->