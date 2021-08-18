<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

$config[ 'controllers_requiring_installation' ] = array( 'admin' , 'login' , 'recovery' , 'register' );
$config[ 'reserved_controllers' ] = array( 'admin' , 'login', 'recovery' , 'register' , 'install' );
$config[ 'admin_route' ] = array('admin');
$config[ 'login_route' ] = 'login';

/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
*/
$config[ 'site_language' ] = 'en_US';
$config[ 'text_domain' ] = array(
    'core' => APPPATH . 'language'
);
$config[ 'supported_languages' ] = array(
    'en_US' => 'English',
    'id_ID' => 'Indonesia',
);

/*
|--------------------------------------------------------------------------
| Core ID
|--------------------------------------------------------------------------
*/
$config[ 'app_name' ] = 'sainsuite';
$config[ 'version' ] = '3.20.2';
$config[ 'signature' ] = $config[ 'app_name' ] . ' v' . $config[ 'version' ];

/*
|--------------------------------------------------------------------------
| Custom Asset Paths
|--------------------------------------------------------------------------
*/
$config['asset_path']  = 'assets/';
$config['addon_path']  = 'addons/';
$config['upload_path'] = 'uploads/';
$config['admin_path']  = 'admin/';
$config['site_path']   = 'site/';
$config['js_path']     = 'js/';
$config['css_path']    = 'css/';
$config['img_path']    = 'img/';

/*
|--------------------------------------------------------------------------
| Site Time Zone
|--------------------------------------------------------------------------
*/
$config[ 'site_timezone' ] = [
    'Asia/Jakarta' => '(UTC+07:00) Asia &mdash; Jakarta',
];