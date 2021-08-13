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

//------------------------------------------------------------------------------
// Model
//------------------------------------------------------------------------------
$lang['model_db_error']            = __('DB Error: %s');
$lang['model_no_data']             = __('No data available.');
$lang['model_invalid_id']          = __('Invalid ID passed to model.');
$lang['model_no_table']            = __('Model has unspecified database table.');
$lang['model_fetch_error']         = __('Not enough information to fetch field.');
$lang['model_count_error']         = __('Not enough information to count results.');
$lang['model_unique_error']        = __('Not enough information to check uniqueness.');
$lang['model_find_error']          = __('Not enough information to find by.');

 // System
$lang[ 'database-installed' ]      = __('Database has been installed');
$lang[ 'system-installed' ]        = __('System has been installed');
$lang[ 'unable-to-connect' ]       = __('SainSuite cannot connect to your database host.');
$lang[ 'error-occured' ]           = __('Some problems occured, please try again');
$lang[ 'unexpected-error' ]        = __('An unexpected error occured.');
$lang[ 'file-conflict' ]           = __('File Conflict.');
$lang[ 'option-saved' ]            = __('Option was successfully saved.');

// Login page
$lang[ 'signin-notice-message' ]   = __('Sign in to start your account');
$lang[ 'recovery-notice-message' ] = __('Please enter your email addresse. A recovery email will be send to you.');
$lang[ 'user-logged-in' ]          = __('You logged in successfully.');
$lang[ 'login-required' ]          = __('Login is required.');
$lang[ 'old-pass-incorrect' ]      = __('Your old password is not correct.');
$lang[ 'password-updated' ]        = __('Update password.');
$lang[ 'old-pass-empty' ]          = __('Your old password is empty.');

// Registration
$lang[ 'username-used' ]           = __('Username is already used by another user.');
$lang[ 'email-used' ]              = __('This email is already used.');
$lang[ 'email-already-taken' ]     = __('This email seems to be already taken.');
$lang[ 'username-already-taken' ]  = __('This username seems to be already taken.');
$lang[ 'user-created' ]            = __('The user has been successfully created.');
$lang[ 'account-activated' ]       = __('Your Account has been activated.');

// Recovery
$lang[ 'unknow-user' ]             = __('Unknow user');
$lang[ 'unknow-email' ]            = __('Unknow email address');
$lang[ 'recovery-email-send' ]     = __('The recovery email has been send. Please check your email, open the recovery email and follow the instructions.');
$lang[ 'create-email-send' ]       = __('The email has been send. Please check your email, open the email and follow the instructions.');

// Logout
$lang[ 'logout-required' ]         = __('You must logout first to access that page.');

// General
$lang[ 'addon-enabled' ]           = __('The addon has been enabled.');
$lang[ 'addon-disabled' ]          = __('The addon has been disabled.');
$lang[ 'addon-removed' ]           = __('The addon has been removed.');
$lang[ 'addon-extracted' ]         = __('The addon has been extracted.');
$lang[ 'addon-updated' ]           = __('The addon has been updated.');
$lang[ 'addon-installed' ]         = __('The addon has been installed.');
$lang[ 'theme-enabled' ]           = __('The theme has been enabled.');
$lang[ 'theme-disabled' ]          = __('The theme has been disabled.');
$lang[ 'theme-removed' ]           = __('The theme has been removed.');
$lang[ 'theme-extracted' ]         = __('The theme has been extracted.');
$lang[ 'theme-updated' ]           = __('The theme has been updated.');
$lang[ 'theme-installed' ]         = __('The theme has been installed.');
$lang[ 'old-version' ]             = __('The version installed is already up to date.');
$lang[ 'unable-to-update' ]        = __('An error occured during update.');
$lang[ 'config-file-not-found' ]   = __('config file hasn\'t been found. This file is not a valid theme. Installation aborded !!!');
$lang[ 'manifest-file-not-found' ] = __('manifest file hasn\'t been found. This file is not a valid addon. Installation aborded !!!');
$lang[ 'manifest-file-incorrect' ] = __('manifest file incorrect. This file is not a valid addon. Installation aborded !!!');
$lang[ 'migration-not-required' ]  = __('A migration is not required or has already been done.');
$lang[ 'created' ]                 = __('The Data has been successfully.');
$lang[ 'updated' ]                 = __('The Data has been updated.');
$lang[ 'deleted' ]                 = __('The Data has been deleted.');
$lang[ 'cant-delete-yourself' ]    = __('You cant delete your own  account.' );

// Migration
$lang[ 'migration-not-required' ]  = __('A migration is not required or has already been done.');

// Extension
$lang[ 'fetch-from-upload' ] = function () {
    $error = array('error' =>get_instance()->upload->display_errors());
    foreach ($error as $type => $_error) {
        if ($type == 'error') {
            echo strip_tags($_error);
        } else {
            echo strip_tags($_error);
        }
    }
};