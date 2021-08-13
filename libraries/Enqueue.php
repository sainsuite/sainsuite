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
class Enqueue
{
    public $CI;

    public $scripts = array();

    public $styles = array();

    private $_namespace = 'default';

    public function __construct()
    {
		// get main CI object
		$this->CI = & get_instance();
    }

    /**
     *  CSS Namespace
    **/
    public function css_namespace( $namespace )
    {
        if( @$this->css[ $namespace ] == null ) 
        {
            $this->css[ $namespace ] = array();
        }
        $this->_namespace = $namespace;
    }

    /**
     * Enqueue CSS
     *
     * Enqueue CSS to global queue
     */
    public function css($style, $path = null)
    {
		$root_url = $this->CI->events->apply_filters('fill_root_url', base_url());
        $this->styles[ $this->_namespace ][ basename( $style ) ] = ($path === null)
            ? $root_url . $this->CI->config->item('asset_path') . $this->CI->config->item('admin_path') . admin_theme() . $this->CI->config->item('css_path') . $style
            : $path . $style;
    }

    /**
     * Output CSS
     *
     * output css
     */
    public function load_css( $namespace = 'default' )
    {
        if( @$this->styles[ $namespace ] ) 
        {
            foreach ( $this->styles[ $namespace ] as $style) 
            {
                echo '<link rel="stylesheet" href="' . $style . '.css" />'."\n";
            }
        }
    }

    /**
     *  JS Namespace
    **/
    public function js_namespace( $namespace )
    {
        if( @$this->js[ $namespace ] == null ) {
            $this->js[ $namespace ] = array();
        }
        $this->_namespace = $namespace;
    }

    /**
     * Enqueue JS
     *
     * Enqueue js to global queue
     */
    public function js( $script, $path = null)
    {
		$root_url = $this->CI->events->apply_filters('fill_root_url', base_url());
        $this->scripts[ $this->_namespace ][ basename( $script ) ] = ($path === null)
            ? $root_url . $this->CI->config->item('asset_path') . $this->CI->config->item('admin_path') . admin_theme() . $this->CI->config->item('js_path') . $script
            : $path . $script;
    }

    /**
     * Output JS
     *
     * output js
     */
    public function load_js( $namespace = 'default' )
    {
        if( @$this->scripts[ $namespace ] ) 
        {
            foreach ( $this->scripts[ $namespace ] as $script) 
            {
                echo '<script src="' . $script . '.js"></script>'."\n";
            }
        }
    }

    /**
     * addon CSS
    **/
    public function addon_css( $addon_namespace, $style ) 
    {
        return $this->css( $style, addon_url( $addon_namespace ) );
    }

    /**
     * addon JS
    **/
    public function addon_js( $addon_namespace, $script )
    {
        return $this->js( $script, addon_url( $addon_namespace ) );
    }
}
