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
class Filer
{
    /**
     * Drop file from source
     * 
     * @param string path to file
     * @return bool/void
    **/
    
    public static function drop($source)
    {
        if (is_dir($source)) {
            if ($open = opendir($source)) {
                
                while (($content = readdir($open)) !== false) {
                    if (is_file($source. '/' . $content) && !in_array($content, array('..', '.'))) {
                        unlink($source . '/' . $content);
                    }
                    if (is_dir($source . '/' . $content) && !in_array($content, array('..', '.'))) {
                        self::drop($source . '/' . $content);
                    }
                }
                closedir($open);
            }
            rmdir($source);
        }
        return true;
    }
    
    /**
     * Move file to a destination path
     * 
     * @param string source path
     * @param string destination path
     * @return void
    **/
    
    public static function extractor($source, $destination, $dir_limit = 10)
    {
        if (is_file($source)) {
            copy($source, $destination);
            unlink($source);
        }
        if (is_dir($source)) {
            if (!is_dir($destination)) {
                mkdir($destination);
            }
            if ($open = opendir($source)) {
                while (($content    =    readdir($open)) !== false) {
                    if (is_file($source . '/' . $content)) {
                        copy($source . '/' . $content, $destination . '/' . $content);
                        unlink($source . '/' . $content);
                    }
                    if (is_dir($source . '/' . $content) && !in_array($content, array('..', '.'))) {
                        if ($dir_limit > 0) {
                            if (!is_dir($destination . '/' . $content)) {
                                mkdir($destination . '/' . $content);
                            }
                            self::extractor($source . '/' . $content, $destination . '/' . $content, $dir_limit-1);
                        } else {
                            self::drop($source . '/' . $content);
                        }
                    }
                }
                closedir($open);
            }
            if (!rmdir($source)) {
                self::drop($source);
            }
        }
    }
    
    /**
     * Copy a file from a source to a destination
     * 
     * @param string Source path
     * @param string Destiantion path
     * @return bool/void
    **/
    
    public static function file_copy($source, $destination)
    {
        if (is_file($source)) {
            $file_content = file_get_contents($source);
            
            // Checks if all directory exists
            $path_explode = explode('/', $destination);
            $path_progressive = '';
            foreach ($path_explode as $index => $file) {
                // last index is not handled
                if ($index < count($path_explode) - 1) {
                    $path_progressive    .= $file . '/';
                    if (! is_dir($path_progressive)) {
                        mkdir($path_progressive);
                    }
                }
            }
            file_put_contents($destination, $file_content);
        }
        return false;
    }
    
    /**
     * Copy directory from a source to a destination path
     * 
     * @param string Source path
     * @param string Destination Path
     * @return void
    **/
    
    public static function copy($source, $destination, $dir_limit = 10)
    {
        if (is_dir($source)) 
        {
            if (!is_dir($destination)) 
            {
                mkdir($destination);
            }

            if ($open = opendir($source)) 
            {
                while (($content = readdir($open)) !== false) 
                {
                    if (is_file($source . '/' . $content)) 
                    {
                        copy($source . '/' . $content, $destination . '/' . $content);
                    }
                    if (is_dir($source . '/' . $content) && !in_array($content, array('..', '.'))) 
                    {
                        if ($dir_limit > 0) 
                        {
                            if (!is_dir($destination . '/' . $content)) 
                            {
                                mkdir($destination . '/' . $content);
                            }
                            self::copy($source . '/' . $content, $destination . '/' . $content, $dir_limit-1);
                        }
                    }
                }
                closedir($open);
            }
        }
    }

    /**
     * Copy Content
     * @param string source
     * @param string destination
     * @return void
     */
    public static function copyContent( $src, $dst )
    {
        /* Returns false if src doesn't exist */
        $dir = @opendir($src);
           
        /* Make destination directory. False on failure */
        if (!file_exists($dst)) @mkdir($dst);
       
        /* Recursively copy */
        while (false !== ($file = readdir($dir))) {
       
            if (( $file != '.' ) && ( $file != '..' )) {
               if ( is_dir($src . '/' . $file) ) self::copyContent($src . '/' . $file, $dst . '/' . $file); 
               else copy($src . '/' . $file, $dst . '/' . $file);
            }
       
        }
       closedir($dir); 
    }
}
