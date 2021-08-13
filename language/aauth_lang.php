<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * SainSuite
 *
 * Engine Management System
 *
 * @package     SainSuite
 * @author	    Buddy Winangun
 * @license	    MIT License. For full terms see the file LICENSE.
 * @link        https://github.com/saintekno/sainsuite
 * @filesource
 */
/* E-mail Messages */

// Account verification
$lang['aauth_email_verification_subject']       = __('Account Verification');
$lang['aauth_email_verification_code']          = __('Your verification code is: ');
$lang['aauth_email_verification_text']          = __("Thank you for registering on our site, your account details are as follows:\n\n");

// Password reset
$lang['aauth_email_reset_subject']              = __('Reset Password');
$lang['aauth_email_reset_text']                 = __("To reset your password click on (or copy and paste in your browser address bar) the link below:\n\n");

// Password reset success
$lang['aauth_email_reset_success_subject']      = __('Successful Pasword Reset');
$lang['aauth_email_reset_new_password']         = __('Your password has successfully been reset.');
$lang['aauth_email_reset_success_new_password'] = __('Your password has successfully been reset. Your new password is : ');

// Account creation errors
$lang['aauth_error_email_exists']               = __('Email address already exists on the system.').'</br>';
$lang['aauth_error_username_exists']            = __('Account already exists on the system with that username. Please enter a different username.').'</br>';
$lang['aauth_error_email_invalid']              = __('Invalid email address').'</br>';
$lang['aauth_error_password_invalid']           = __('Invalid password').'</br>';
$lang['aauth_error_username_invalid']           = __('Invalid Username').'</br>';
$lang['aauth_error_username_required']          = __('Username required').'</br>';
$lang['aauth_error_totp_code_required']         = __('Authentication Code required').'</br>';
$lang['aauth_error_totp_code_invalid']          = __('Invalid Authentication Code').'</br>';

// Account update errors
$lang['aauth_error_update_email_exists']        = __('Email address already exists on the system.  Please enter a different email address.').'</br>';
$lang['aauth_error_update_username_exists']     = __('Username already exists on the system.  Please enter a different username.').'</br>';

// Access errors
$lang['aauth_error_no_access']                  = __('Sorry, you do not have access to the resource you requested.').'</br>';
$lang['aauth_error_login_failed_email']         = __('Email Address and Password do not match.').'</br>';
$lang['aauth_error_login_failed_name']          = __('Username and Password do not match.').'</br>';
$lang['aauth_error_login_failed_all']           = __('Email, Username or Password do not match.').'</br>';
$lang['aauth_error_login_attempts_exceeded']    = __('You have exceeded your login attempts, your account has now been locked.').'</br>';
$lang['aauth_error_recaptcha_not_correct']      = __('Sorry, the reCAPTCHA text entered was incorrect.').'</br>';

// Misc. errors
$lang['aauth_error_no_user']                    = __('User does not exist').'</br>';
$lang['aauth_error_vercode_invalid']            = __('Invalid Verification Code').'</br>';
$lang['aauth_error_account_not_verified']       = __('Your account has not been verified. Please check your email and verify your account.').'</br>';
$lang['aauth_error_no_group']                   = __('Group does not exist').'</br>';
$lang['aauth_error_no_subgroup']                = __('Subgroup does not exist').'</br>';
$lang['aauth_error_self_pm']                    = __('It is not possible to send a Message to yourself.').'</br>';
$lang['aauth_error_no_pm']                      = __('Private Message not found').'</br>';

/* Info messages */
$lang['aauth_info_already_member']              = __('User is already member of group');
$lang['aauth_info_already_subgroup']            = __('Subgroup is already member of group');
$lang['aauth_info_group_exists']                = __('Group name already exists');
$lang['aauth_info_perm_exists']                 = __('Permission name already exists');