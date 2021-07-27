<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * SainSuite
 *
 * Engine Management System
 * 
 * Sekati CodeIgniter Asset Helper
 *
 * @package		Sekati
 * @author		Jason M Horwitz edited by Buddy Winangun
 * @copyright	Copyright (c) 2013, Sekati LLC.
 * @license		http://www.opensource.org/licenses/mit-license.php
 * @link		http://sekati.com
 * @version		v1.2.7
 * @filesource
 */

// ------------------------------------------------------------------------
// URL HELPERS

/**
 * Get asset URL
 *
 * @access  public
 * @return  string
 */
if (! function_exists('asset_url')) {
    function asset_url($uri = null)
    {
        $CI =& get_instance();
        $root_url = $CI->events->apply_filters('fill_root_url', base_url());
        if ($uri === null) { 
            // if addon namespace is not specified
            //return the full asset path
            return $root_url . $CI->config->item('asset_path') . $CI->config->item('admin_path') . admin_theme();
        } 

        return $root_url . $CI->config->item('asset_path') . $CI->config->item('admin_path') . admin_theme() . $uri ;
    }
}
if (! function_exists('fasset_url')) {
    function fasset_url($uri = null)
    {
        $CI =& get_instance();
        $root_url = $CI->events->apply_filters('fill_root_url', base_url());
        if ($uri === null) { 
            return $root_url . $CI->config->item('asset_path') . site_theme();
        } 

        return $root_url . $CI->config->item('asset_path') . site_theme() . $uri ;
    }
}

/**
 * Get base URL
 *
 * @access  public
 * @return  string
 */
if (! function_exists('addon_url')) {
    function addon_url($addon_namespace = null)
    {
        $CI =& get_instance();
        $root_url = $CI->events->apply_filters('fill_root_url', base_url());
        return $root_url . $CI->config->item('asset_path') . $CI->config->item('addon_path') . $addon_namespace . '/';
    }
}

/**
 * Get image URL
 *
 * @access  public
 * @return  string
 */
if (! function_exists('img_url')) {
    function img_url($addon_namespace = null)
    {
        $CI =& get_instance();
        $root_url = $CI->events->apply_filters('fill_root_url', base_url());
        if ($addon_namespace === null) {
            return $root_url . $CI->config->item('asset_path') . $CI->config->item('admin_path') . admin_theme() . $CI->config->item('img_path');
        } 

        return $root_url . $CI->config->item('asset_path') . $CI->config->item('addon_path') . $addon_namespace . '/' . $CI->config->item('img_path');
    }
}
if (! function_exists('fimg_url')) {
    function fimg_url()
    {
        $CI =& get_instance();
        $root_url = $CI->events->apply_filters('fill_root_url', base_url());
        return $root_url. $CI->config->item('asset_path') . site_theme() . $CI->config->item('img_path');
    }
}

/**
 * Get Upload URL
 *
 * @access  public
 * @return  string
 */
if (! function_exists('upload_url')) {
    function upload_url( $uri = null, $path = false )
    {
        $CI =& get_instance();

        $root_url = base_url();
        if ($path) {
            $root_url = $CI->events->apply_filters('fill_root_url', $path);
        }

        if ($uri === null) {
            return $root_url . $CI->config->item('upload_path');
        } 

        return $root_url . $CI->config->item('upload_path') . $uri;
    }
}

/**
 * Get Download URL
 *
 * @access  public
 * @return  string
 */
if (! function_exists('download_url')) {
    function download_url()
    {
        $CI =& get_instance();
        return base_url() . $CI->config->item('download_path');
    }
}

// ------------------------------------------------------------------------
// PATH HELPERS

/**
 * Get the Absolute asset Path
 *
 * @access  public
 * @return  string
 */
if (! function_exists('asset_path')) {
    function asset_path()
    {
        $CI =& get_instance();
        return FCPATH . $CI->config->item('asset_path') . $CI->config->item('admin_path') . admin_theme();
    }
}

/**
 * Get the Absolute Upload Path
 *
 * @access  public
 * @return  string
 */
if (! function_exists('upload_path')) {
    function upload_path(  )
    {
        $CI =& get_instance();
        return FCPATH . $CI->config->item('upload_path');
    }
}

/**
 * Get the Absolute Download Path
 *
 * @access  public
 * @return  string
 */
if (! function_exists('download_path')) {
    function download_path(  )
    {
        $CI =& get_instance();
        return FCPATH . $CI->config->item('download_path');
    }
}

// ------------------------------------------------------------------------
// EMBED HELPERS

/**
 * Load Image
 * Creates an <img> tag with src and optional attributes
 * @access  public
 * @param   string
 * @param 	array 	$atts Optional, additional key/value attributes to include in the IMG tag
 * @return  string
 */
if (! function_exists('img')) {
    function img($file,  $atts = array())
    {
        $url = '<img src="' . img_url() . $file . '"';
        foreach ($atts as $key => $val) {
            $url .= ' ' . $key . '="' . $val . '"';
        }
        $url .= " />\n";
        return $url;
    }
}

/**
 * Load Google Analytics
 * Creates the <script> tag that links all requested js file
 * @access  public
 * @param   string
 * @return  string
 */
if (! function_exists('google_analytics')) {
    function google_analytics($ua='')
    {
        // Change UA-XXXXX-X to be your site's ID
        $out = "<!-- Google Webmaster Tools & Analytics -->\n";
        $out .='<script type="text/javascript">';
        $out .='	var _gaq = _gaq || [];';
        $out .="    _gaq.push(['_setAccount', '$ua']);";
        $out .="    _gaq.push(['_trackPageview']);";
        $out .='    (function() {';
        $out .="      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;";
        $out .="      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
        $out .="      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);";
        $out .="    })();";
        $out .="</script>";
        return $out;
    }
}
