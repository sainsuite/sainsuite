<script>
    "use strict";

// Class Definition
var SITLogin = function() {
	var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

	var _handleFormSignin = function() {
		var form = SITUtil.getById('sit_login_singin_form');
		var formSubmitButton = SITUtil.getById('sit_login_singin_form_submit_button');

		if (!form) {
			return;
		}

		FormValidation
		    .formValidation(
		        form,
		        {
		            fields: {
						username_or_email: {
							validators: {
								notEmpty: { message: 'Username is required' }
							}
						},
						password: {
							validators: {
								notEmpty: { message: 'Password is required' }
							}
						}
		            },
		            plugins: {
						trigger: new FormValidation.plugins.Trigger(),
						submitButton: new FormValidation.plugins.SubmitButton(),
						bootstrap: new FormValidation.plugins.Bootstrap()
		            }
		        }
		    )
		    .on('core.form.valid', function() {
				// Show loading state on button
				SITUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

				// Simulate Ajax request
				setTimeout(function() {
					SITUtil.btnRelease(formSubmitButton);
					form.submit(); // Submit form
				}, 1000);
		    });
    }

	var _handleFormForgot = function() {
		var form = SITUtil.getById('sit_login_forgot_form');
		var formSubmitButton = SITUtil.getById('sit_login_forgot_form_submit_button');

		if (!form) {
			return;
		}

		FormValidation
		    .formValidation(
		        form,
		        {
		            fields: {
						user_email: {
							validators: {
								notEmpty: {
									message: 'Email is required'
								},
								emailAddress: {
									message: 'The value is not a valid email address'
								}
							}
						}
		            },
		            plugins: {
						trigger: new FormValidation.plugins.Trigger(),
						submitButton: new FormValidation.plugins.SubmitButton(),
						bootstrap: new FormValidation.plugins.Bootstrap()
		            }
		        }
		    )
		    .on('core.form.valid', function() {
				// Show loading state on button
				SITUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");

				// Simulate Ajax request
				setTimeout(function() {
					SITUtil.btnRelease(formSubmitButton);
					form.submit(); // Submit form
				}, 1000);
		    });
    }

    // Public Functions
    return {
        init: function() {
            _handleFormSignin();
			_handleFormForgot();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    SITLogin.init();
});

</script>