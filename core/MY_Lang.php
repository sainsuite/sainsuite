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
class MY_Lang extends CI_Lang
{
    public function __construct()
    {
        parent::__construct();
    }

	// --------------------------------------------------------------------

    /**
     * Load Language Line
     * 
     * @return void
    **/
    public function load_lines($path = null, $is_file = false)
    {
        $lang = array();
        
        if ($is_file) 
        {
            if (is_file($path)) 
                include $path;
            else 
                show_error(__('Unable to load the requested lang file'));
        } 
        else 
        {
            $fileArray = glob( $path );
            if ( is_array( $fileArray ) ) 
            {
                foreach ( $fileArray as $filename) 
                {
                    if (is_file($filename)) 
						include $filename;
                    else 
						show_error(__('Unable to load the requested lang file'));
				}
			}
        }
        
        $this->language = array_merge($this->language, $lang);
    }
}
