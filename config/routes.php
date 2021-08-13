<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
*/
$route['404_override']         = 'welcome/error_404';
$route['default_controller']   = 'welcome';
$route['translate_uri_dashes'] = FALSE;

$route['page404'] = 'welcome/error_404';
$route['lang/(:any)'] = 'welcome/language/$1';

$route['login' ]    = 'auth';
$route['logout' ]   = 'auth/logout';
$route['register' ] = 'auth/register';
$route['recovery' ] = 'auth/recovery';

// Site
$addons_path = APPPATH.'addons/';     
$addons = scandir($addons_path);

foreach($addons as $addon)
{
    if($addon === '.' || $addon === '..') continue;
    if(is_dir($addons_path) . '/' . $addon)
    {
        $routes_path = $addons_path . $addon . '/controllers.php';
        if(file_exists($routes_path))
        {
            require_once($routes_path);
        }
        else
        {
            continue;
        }
    }
}