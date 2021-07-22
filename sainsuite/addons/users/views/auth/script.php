<script>
    "use strict";

// Class Definition
var SITRegister = function() {
	var _buttonSpinnerClasses = 'spinner spinner-right spinner-white pr-15';

    var _handleSignUpForm = function(e) {
        var form = SITUtil.getById('sit_signup_form');
		var formSubmitButton = SITUtil.getById('sit_singup_form_submit');
		
		if (!form) {
			return;
		}
		
       	FormValidation
			.formValidation(
				form,
				{
					fields: {
						username: {
							validators: {
								notEmpty: {
									message: 'Username is required'
								}
							}
						},
						email: {
							validators: {
								notEmpty: {
									message: 'Email address is required'
								},
								emailAddress: {
									message: 'The value is not a valid email address'
								}
							}
						},
						password: {
							validators: {
								notEmpty: {
									message: 'The password is required'
								}
							}
						},
						confirm: {
							validators: {
								notEmpty: {
									message: 'The password confirmation is required'
								},
								identical: {
									compare: function() {
										return form.querySelector('[name="password"]').value;
									},
									message: 'The password and its confirm are not the same'
								}
							}
						},
						agree: {
							validators: {
								notEmpty: {
									message: 'You must accept the terms and conditions'
								}
							}
						},
					},
					plugins: {
						trigger: new FormValidation.plugins.Trigger(),
						submitButton: new FormValidation.plugins.SubmitButton(),
						bootstrap: new FormValidation.plugins.Bootstrap()
					}
				}
			)
		    .on('core.form.valid', function() {
				swal.fire({
					text: "All is cool! Now you submit this form",
					icon: "success",
					buttonsStyling: false,
					showCancelButton: true,
					confirmButtonText: "Ok, got it!",
					cancelButtonText: "No, cancel",
					customClass: {
						confirmButton: "btn font-weight-bold btn-primary",
						cancelButton: "btn font-weight-bold btn-default"
					}
				}).then(function (result) {
					if (result.value) {
						// Show loading state on button
						SITUtil.btnWait(formSubmitButton, _buttonSpinnerClasses, "Please wait");
						// Simulate Ajax request
						setTimeout(function() {
							SITUtil.btnRelease(formSubmitButton);
							form.submit(); // Submit form
						}, 1000);
					} else if (result.dismiss === 'cancel') {
						SITUtil.scrollTop();
					}
				});
		    });
    }

    // Public Functions
    return {
        init: function() {
			_handleSignUpForm();
			
			<?php if ($this->notice->output_notice(true)):?>
			toastr.error("<?php echo $this->notice->output_notice(true);?>");
			<?php endif;?>

			<?php if (notice_from_url() != ""):?>
			toastr.success("<?php echo notice_from_url();?>");
			<?php endif;?>
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    SITRegister.init();
});

</script>