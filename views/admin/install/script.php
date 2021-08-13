<script>
"use strict";

// Class Definition
var SSLogin = function() {
	var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

	var _install = function() {
		// Base elements
		var wizardEl = SSUtil.getById('ss_login');
		var database = SSUtil.getById('ss_install_db_form');
		var site = SSUtil.getById('ss_install_site_form');
		var wizardObj;
		var validations = [];
        
		// Step 1
		validations.push(FormValidation.formValidation());

		// Step 2
		validations.push(FormValidation.formValidation(
			database,
			{
				fields: {
					_ht_name: {
						validators: {
							notEmpty: { message: 'Host Name is required' }
						}
					},
					_db_driv: {
						validators: {
							notEmpty: { message: 'Database Driver is required' }
						}
					},
					_db_name: {
						validators: {
							notEmpty: { message: 'Database Name is required' }
						}
					},
					_db_pref: {
						validators: {
							notEmpty: { message: 'Database Prefix is required' }
						}
					},
					_uz_name: {
						validators: {
							notEmpty: { message: 'User Name is required' }
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Step 3
		validations.push(FormValidation.formValidation(
			site,
			{
				fields: {
					site_name: {
						validators: {
							notEmpty: { message: 'Site Name is required' }
						}
					},
					lang: {
						validators: {
							notEmpty: { message: 'languages is required' }
						}
					},
					username: {
						validators: {
							notEmpty: { message: 'User Name is required' }
						}
					},
					email: {
						validators: {
							notEmpty: { message: 'Email is required' }
						}
					},
					password: {
						validators: {
							notEmpty: { message: 'Password is required' }
						}
					},
					confirm: {
						validators: {
							notEmpty: { message: 'Password Confirm is required' }
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		));

		// Initialize form wizard
		wizardObj = new SSWizard(wizardEl, {
			startStep: 1, // initial active step number
			clickableSteps: false  // allow step clicking
		});

		// Validation before going to next page
		wizardObj.on('change', function (wizard) {
			if (wizard.getStep() > wizard.getNewStep()) {
				return; // Skip if stepped back
			}

			// Validate form before change wizard step
			var validator = validations[wizard.getStep() - 1]; // get validator for currnt step

			if (validator) {
				validator.validate().then(function (status) {
                    if (wizard.getStep() == 2) {
                        var action = $('#ss_install_db_form').attr('action');
                        //ajax submit
                        $.ajax({
                            type: "POST",
                            url: action,
                            data: $('#ss_install_db_form').serialize(),
                            dataType: 'json',
                            async: false,
                            success: function (data) {
                                if (data.success) {
                                    toastr.success(data.message);
                                    wizard.goTo(wizard.getNewStep());
                                    SSUtil.scrollTop();
                                } else {
                                    toastr.error(data.message);
                                }
                            },
                            error: function () {
                                toastr.error('<?php _e('Something Went Wrong!');?>');
                            }
                        });
                    }
                    else {
                        wizard.goTo(wizard.getNewStep());
                        SSUtil.scrollTop();
                    }
				});
			}

			return false;  // Do not change wizard step, further action will be handled by he validator
		});

		// Change event
		wizardObj.on('changed', function (wizard) {
			SSUtil.scrollTop();
		});

		// Submit event
		wizardObj.on('submit', function (wizard) {
            var formSubmitButton = SSUtil.getById('ss_install_submit_button');
            var action = $('#ss_install_site_form').attr('action');

			// Validate form before change wizard step
			var validator = validations[wizard.getStep() - 1]; // get validator for currnt step

            if (validator) {
                validator.validate().then(function (status) {
					if (status == 'Valid') {
                        //ajax submit
                        $.ajax({
                            type: "POST",
                            url: action,
                            data: $('#ss_install_site_form').serialize(),
                            dataType: 'json',
                            async: false,
                            success: function (data) {

                                if (data.success) {
                                    Swal.fire({
                                        text: "All is good! Please confirm the form submission.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Yes, submit!",
                                        customClass: {
                                            confirmButton: "btn font-weight-bold btn-primary",
                                        }
                                    }).then(function (result) {
                                        location.href = "<?=site_url();?>";
                                    });
                                } else {
                                    toastr.error(data.message);
                                }
                            },
                            error: function () {
                                toastr.error('<?php _e('Something Went Wrong!');?>');
                            }
                        });
					} else {
                        SSUtil.scrollTop();
					}
				});
			}
		});
    }

    // Public Functions
    return {
        init: function() {
			_install();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    SSLogin.init();
});
</script>