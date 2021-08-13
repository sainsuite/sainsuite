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

function site_theme()
{
    $site_theme = get_instance()->events->apply_filters('fill_site_theme', riake( 'site_theme', options() ));
    return $site_theme . '/';
}

// --------------------------------------------------------------------

function admin_theme()
{
    $admin_theme = get_instance()->events->apply_filters('fill_admin_theme', riake( 'admin_theme', options() ));
    return ($admin_theme) ? $admin_theme . '/' : '';
}

// --------------------------------------------------------------------

// This function helps us to decode the theme configuration json file and return that array to us
function config_theme($key = "")
{
    $themeConfigs = [];
    if (file_exists(SITEPATH.site_theme().'theme.json')) {
        $themeConfigs = file_get_contents(SITEPATH.site_theme().'theme.json');
        $themeConfigs = json_decode($themeConfigs, true);
        if ($key != "") {
            if (array_key_exists($key, $themeConfigs['theme'])) {
                return $themeConfigs['theme'][$key];
            } else {
                return false;
            }
        }else {
            return $themeConfigs['theme'];
        }
    } else {
        return false;
    }
}