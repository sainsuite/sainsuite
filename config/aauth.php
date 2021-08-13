<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * SainSuite
 *
 * Engine Management System
 * 
 * Aauth is a User Authorization Library for CodeIgniter 2.x, which aims to make
 * easy some essential jobs such as login, permissions and access operations.
 * Despite ease of use, it has also very advanced features like private messages,
 * groupping, access management, public access etc..
 *
 * @author		Emre Akay <emreakayfb@hotmail.com>
 * @contributor Jacob Tomlinson
 * @contributor Tim Swagger (Renowne, LLC) <tim@renowne.com>
 * @contributor Raphael Jackstadt <info@rejack.de>
 * @edited by Buddy Winangun
 *
 * @copyright 2014-2018 Emre Akay
 * @version 2.5.15
 * @license MIT License
 *
 * The latest version of Aauth can be obtained from:
 * https://github.com/emreakay/CodeIgniter-Aauth
 *
 */

/*
| -------------------------------------------------------------------
| Aauth Config
| -------------------------------------------------------------------
*/
$config_aauth = array();

$config_aauth["default"] = array(
 'no_permission'                  => site_url('admin/page404'),

 'master_group'                   => 'master',
 'admin_group'                    => 'admin',
 'user_group'                     => 'user',

 'db_profile'                     => 'default',

 'users'                          => 'aauth_users',
 'groups'                         => 'aauth_groups',
 'group_to_group'                 => 'aauth_group_to_group',
 'user_to_group'                  => 'aauth_user_to_group',
 'perms'                          => 'aauth_perms',
 'perm_to_group'                  => 'aauth_perm_to_group',
 'perm_to_user'                   => 'aauth_perm_to_user',
 'pms'                            => 'aauth_pms',
 'user_variables'                 => 'aauth_user_variables',
 'login_attempts'                 => 'aauth_login_attempts',

 'remember'                       => ' +3 days',

 'max'                            => 30,
 'min'                            => 3,

 'additional_valid_chars'         => array(),

 'ddos_protection'                => true,

 'recaptcha_active'               => false,
 'recaptcha_login_attempts'       => 4,
 'recaptcha_siteKey'              => '',
 'recaptcha_secret'               => '',

 'totp_active'                    => false,
 'totp_only_on_ip_change'         => false,
 'totp_reset_over_reset_password' => false,
 'totp_two_step_login_active'     => false,
 'totp_two_step_login_redirect'   => 'auth/twofactor_verification/',

 'max_login_attempt'              => 5,
 'max_login_attempt_time_period'  => "1 minutes",
 'remove_successful_attempts'     => true,

 'login_with_name'                => true,

 'email'                          => 'sainteknoid@gmail.com',
 'name'                           => 'SAINTEKNO',
 'email_config'                   => false,

 'verification'                   => true,
 'verification_link'              => 'auth/verification/',
 'reset_password_link'            => 'auth/reset_password/',

 'hash'                           => 'sha256',
 'use_password_hash'              => true,
 'password_hash_algo'             => PASSWORD_DEFAULT,
 'password_hash_options'          => array(),

 'pm_encryption'                  => false,
 'pm_cleanup_max_age'             => "3 months",
);

$config['aauth'] = $config_aauth['default'];

/* End of file aauth.php */
/* Location: ./application/config/aauth.php */