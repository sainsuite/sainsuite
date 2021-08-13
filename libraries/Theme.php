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

class Theme
{

	/**
	 * The CodeIgniter object variable
	 * @access public
	 * @var object
	 */
    public $CI;
    
    private static $themes;
    
    private static $config_theme = 'theme.json';

    private static $manifest_theme = 'manifest.json';

    private static $allowed_app_folders = array( 'controllers', 'models' );

    public function __construct()
    {
		// get main CI object
		$this->CI = & get_instance();
        //Codeigniter : Write Less Do More
    }

	// --------------------------------------------------------------------

    /**
     * Load themes
     */
    public static function load($theme_path, $deepness = 0 )
    {
        if ($deepness < 2) 
        { 
            // avoid multi-folder parsing
            $dir = opendir($theme_path);
            $config = array();

            // Looping currend folder
            while (false !== ($file = readdir($dir))) 
            {
                if (substr($file, -11) === self::$config_theme) {
                    $config = json_decode(file_get_contents($theme_path . '/' . $file), true);
                } 
                elseif (is_dir($theme_path . '/' . $file) && ! in_array($file, array( '.', '..' ))) {
                    self::load($theme_path . '/' . $file, $deepness + 1); // Only top folder are parsed
                }
            }

            // Adding Valid init file to theme array
            // only namespace is required for a theme to be valid
            if (isset($config[ 'theme' ][ 'namespace' ])) 
            {
                $namespace = strtolower($config[ 'theme' ][ 'namespace' ]);
                
                // Saving details
                self::$themes[ $namespace ] = $config;
                
                self::$themes[ $namespace ][ 'theme' ][ 'namespace' ] = strtolower(self::$themes[ $namespace ][ 'theme' ][ 'namespace' ]);
            }
        }
    }

	// --------------------------------------------------------------------

    /**
     * Get
     *
     * Get a theme using namespace provided as unique parameter
     */
    public static function get($namespace = null )
    {
        if ($namespace == null) {
            return self::$themes;
        }
        
        return isset(self::$themes[ $namespace ]) 
            ? self::$themes[ $namespace ] 
            : false; // if theme exists
    }

	// --------------------------------------------------------------------

    /**
     * Is Active
     *
     * Checks whether a theme is active
     */
    public static function is_active($theme_namespace)
    {
        global $Options;

        $activated_themes = get_instance()->events->apply_filters('fill_theme_active', @$Options[ 'site_theme' ]);
        if ( $theme_namespace == $activated_themes ) {
            return true;
        }
        return false;
    }

	// --------------------------------------------------------------------

    /**
     * Enable
     *
     * Enable a theme using namespace provided
     */
    public static function enable($theme_namespace)
    {
        global $Options;

        $activated_themes = get_instance()->events->apply_filters('fill_theme_active', @$Options[ 'site_theme' ]);
        if ( $theme_namespace != $activated_themes ) 
        {
            get_instance()->options_model->set(
                get_instance()->events->apply_filters('fill_theme_option', 'site_theme'), 
                $theme_namespace
            );
        }
    }

    // --------------------------------------------------------------------

    public static function remove($theme_namespace)
    {
        global $Options;

        $activated_themes = get_instance()->events->apply_filters('fill_theme_active', @$Options[ 'site_theme' ]);
        if ( $theme_namespace == $activated_themes ) : 
            get_instance()->events->do_action('do_theme_uninstall');
        endif;

        $themepath = get_instance()->events->apply_filters('fill_theme_path', SITEPATH) . $theme_namespace;
        $manifest_file = $themepath . '/' . self::$manifest_theme;

        if (is_file($manifest_file)) 
        {
            $manifest_array = json_decode(file_get_contents($manifest_file), true);
            // removing file
            foreach ($manifest_array as $file) {
                if (is_file($file)):
                    unlink($file);
                endif;
            }
        }

        // moving manifest file to temp folder
        foreach (self::$allowed_app_folders as $reserved_folder) 
        {
            $folder = APPPATH . $reserved_folder .'/'. $theme_namespace;
            if (is_dir($folder)):
                Filer::drop($folder);
            endif;
        }

        // Drop theme Folder
        Filer::drop($themepath);

        // Drop Assets Folder
        if (is_dir($theme_themes_folder = FCPATH . get_instance()->config->item('asset_path') . get_instance()->events->apply_filters('fill_theme_folder', '') . '/' . $theme_namespace)) {
            Filer::drop($theme_themes_folder);
        }
    }

    // --------------------------------------------------------------------

    public static function extract($theme_namespace)
    {
        if ( ! riake('webdev_mode', options(APPNAME)) ) : return;
        endif;

        $theme = self::get($theme_namespace);
        if ($theme) 
        {
            get_instance()->load->library('zip');

            $theme_temp_folder_name = do_hash($theme_namespace);
            $theme_installed_dir = get_instance()->events->apply_filters('fill_theme_path', SITEPATH)  . $theme_namespace . '/';
            
            // creating temp folder
            $temp_folder = APPPATH . 'temp' . '/' . $theme_temp_folder_name;
            if (!is_dir($temp_folder)) {
                mkdir($temp_folder);
            }

            // check manifest
            $manifest = $theme_installed_dir . self::$manifest_theme;
            if (is_file($manifest)) 
            {
                $manifest_array = json_decode(file_get_contents($manifest));
                // manifest is valid
                if (is_array($manifest_array)) 
                {
                    // moving manifest file to temp folder
                    foreach (self::$allowed_app_folders as $reserved_folder) 
                    {
                        foreach ($manifest_array as $file) 
                        {
                            //var_dump( $path_id_separator = APPPATH . $reserved_folder );
                            if (strstr($file, $path_id_separator = APPPATH . $reserved_folder)) 
                            {
                                // we found a a file
                                $path_splited = explode($path_id_separator, $file);
                                Filer::file_copy(
                                    APPPATH . $reserved_folder . $path_splited[1],
                                    $temp_folder . '/' . $reserved_folder . $path_splited[1]
                                );
                            }
                        }
                    }
                }
            }

            // Copy Themes to
            if (is_dir($themes_folder = VIEWPATH . get_instance()->events->apply_filters('fill_theme_folder', 'site') . '/' . $theme_namespace)) 
            {
                // create themes folder
                $_temp_folder_themes = $temp_folder;
                if (!is_dir($_temp_folder_themes)) {
                    mkdir($_temp_folder_themes);
                }
                Filer::copy($themes_folder, $_temp_folder_themes);
            }

            // Copy Themes to
            if (is_dir($theme_themes_folder = FCPATH . get_instance()->config->item('asset_path') . get_instance()->events->apply_filters('fill_theme_folder', '') . '/' . $theme_namespace)) 
            {
                // create themes folder
                $_temp_folder_themes_assets = $temp_folder . '/' . 'assets';
                if (!is_dir($_temp_folder_themes_assets)) {
                    mkdir($_temp_folder_themes_assets);
                }
                Filer::copy($theme_themes_folder, $_temp_folder_themes_assets);
            }

            // move theme file to temp folder
            Filer::copy($theme_installed_dir, $temp_folder);

            // delete manifest file
            unlink($temp_folder . '/' . self::$manifest_theme);

            // read temp folder and download it
            get_instance()->zip->read_dir( $temp_folder . '/', false );
            
            // delete temp folder
            Filer:: drop($temp_folder);

            get_instance()->zip->download($theme[ 'theme' ][ 'name' ] . '_' . $theme[ 'theme' ][ 'version' ] . '_(' . get('version') .')');
        }
    }

    // --------------------------------------------------------------------

    public static function install( $file_name, $asFile = true )
    {
        $config[ 'allowed_types' ] = 'zip';
        $config[ 'upload_path' ]   = APPPATH . '/' . 'temp' . '/';
        $config[ 'max_size' ]      = 50000;

        get_instance()->load->library('upload', $config);

        if (! get_instance()->upload->do_upload($file_name)) {
            return get_instance()->lang->line('fetch-from-upload');
        } 
        else {
            $data = array( 'upload_data' => get_instance()->upload->data() );
            return self::__treatZipFile( $data );
        }
    }

    // --------------------------------------------------------------------

    /**
     * Treat Zip File
     * @return void
     */
    public static function __treatZipFile( $data )
    {
        // Look for manifest.json file to read manifest
        $extraction_temp_path = self::__unzip( $data );
        if (file_exists($extraction_temp_path . '/' . self::$config_theme)) 
        {
            // If manifest xml file has at least a namespace parameter
            $theme_array = json_decode(file_get_contents($extraction_temp_path . '/' . self::$config_theme), true);
            if (isset($theme_array[ 'theme' ][ 'namespace' ])) 
            {
                $theme_namespace = $theme_array[ 'theme' ][ 'namespace' ];
                $old_theme = self::get($theme_namespace);
                // if theme with a same namespace already exists
                if ($old_theme) {
                    if (isset($old_theme[ 'theme' ][ 'version' ])) 
                    {
                        $old_version = $old_theme[ 'theme' ][ 'version' ];
                        $new_version = $theme_array[ 'theme' ][ 'version' ];

                        if (version_compare($new_version, $old_version, '>')) 
                        {
                            $theme_global_manifest = self::__parse_path($extraction_temp_path);

                            if (is_array($theme_global_manifest)) 
                            {
                                // Remove the old theme. No SQL uninstall queries will be triggered.
                                self::remove( $theme_array[ 'theme' ][ 'namespace' ] );

                                // Install the new version
                                $response = self::__move_to_theme_dir($theme_array, $theme_global_manifest[0], $theme_global_manifest[1], $data);
                                
                                // Delete temp file
                                Filer::drop($extraction_temp_path);

                                if ($response !== true) {
                                    return $response;
                                } 
                                else {
                                    // Enable back the theme
                                    self::enable($theme_array[ 'theme' ][ 'namespace' ]);

                                    // Return details
                                    return array(
                                        'namespace' => $theme_array[ 'theme' ][ 'namespace' ],
                                        'from' => $theme_array[ 'theme' ][ 'version' ],
                                        'msg' => 'theme-updated'
                                    );
                                }
                            }
                            // If it's not an array, return the error code.
                            return $theme_global_manifest;
                        }
                        // Delete temp file
                        Filer::drop($extraction_temp_path);
                        return get_instance()->lang->line('old-version');
                    }

                    /**
                     * Update is done only when theme has valid version number
                     * Update is done only when new theme version is higher than the old version
                    **/

                    // Delete temp file
                    Filer::drop($extraction_temp_path);
                    return get_instance()->lang->line('unable-to-update');
                }
                // if theme does'nt exists
                else 
                {
                    $theme_global_manifest = self::__parse_path($extraction_temp_path);

                    if (is_array($theme_global_manifest)) 
                    {
                        $response = self::__move_to_theme_dir($theme_array, $theme_global_manifest[0], $theme_global_manifest[1], $data);

                        // Delete temp file
                        Filer::drop($extraction_temp_path);

                        if ($response !== true) {
                            return $response;
                        } 
                        else {
                            return array(
                                'namespace' => $theme_array[ 'theme' ][ 'namespace' ],
                                'from' => $theme_array[ 'theme' ][ 'version' ],
                                'msg' => 'theme-installed'
                            );
                        }
                    }
                    // If it's not an array, return the error code.
                    return $theme_global_manifest;
                }
            }
            // Delete temp file
            Filer::drop($extraction_temp_path);
            return get_instance()->lang->line('manifest-file-incorrect');
        }
        // Delete temp file
        Filer::drop($extraction_temp_path);
        return get_instance()->lang->line('config-file-not-found');
    }

    // --------------------------------------------------------------------
    
    /**
     * Unzip
     *
     * Unzip an Uploaded theme
     */
    public static function __unzip($upload_details)
    {
        $extraction_path = $upload_details[ 'upload_data' ][ 'file_path' ] . $upload_details[ 'upload_data' ][ 'raw_name' ] ;
        
        // If temp path does'nt exists
        if (! is_dir($extraction_path)): mkdir($extraction_path);
        endif;

        get_instance()->load->library('unzip');

        get_instance()->unzip->extract(
            $upload_details[ 'upload_data' ][ 'full_path' ],
            $extraction_path
        );

        get_instance()->unzip->close();

        // delete zip file
        if (is_file($upload_details[ 'upload_data' ][ 'full_path' ])): unlink($upload_details[ 'upload_data' ][ 'full_path' ]);
        endif;

        // Fix theme installed from Github
        if (! file_exists($extraction_path . '/' . self::$config_theme)) 
        {
            $temp_dir = opendir($extraction_path);

            while (false !== ($file = readdir($temp_dir))) 
            {
                if (! in_array($file, array( '.', '..' ))) 
                {
                    // if within this folder a config file exists
                    if (file_exists($extraction_path . '/' . $file . '/' . self::$config_theme)) 
                    {
                        Filer::copy($extraction_path . '/' . $file, $extraction_path); // moving folder to the top parent folder
                        Filer::drop($extraction_path . '/' . $file);
                    }
                }
            }
        }

        return $extraction_path;
    }

	// --------------------------------------------------------------------

    /**
     * Parse Path
     *
     * Parse Path to register manifest files [for intenal use]
     */

    public static function __parse_path($path)
    {
        $manifest = array();
        $addon_manifest = array();
        if ($dir = opendir($path)) {
            while (false !== ($file = readdir($dir))) 
            {
                if (! in_array($file, array( '.', '..' ), true)) 
                {
                    // Set sub dir path
                    $sub_dir_path = $path;
                    // If a correct folder is found
                    if (in_array($file, self::$allowed_app_folders) && is_dir($path . '/' . $file)) 
                    {
                        // var_dump( $sub_dir_path . '/' . $file . '/' );
                        $manifest = array_merge($manifest, self::__scan($sub_dir_path . '/' . $file));
                    }
                    else {
                        // for other file and folder, they are included in addon dir
                        $addon_manifest[] = $sub_dir_path . '/' . $file;
                    }
                }
            }
            closedir($dir);

            // When everything seems to be alright
            return array( $addon_manifest , $manifest );
        }
        return 'extraction-path-not-found';
    }

	// --------------------------------------------------------------------

    /**
     * Scan
     *
     * Scan folder and returns content as array
     */
    public static function __scan($folder)
    {
        $files_array = array();
        if (is_dir($folder)) 
        {
            $folder_res = opendir($folder);
            while (false !== ($file = readdir($folder_res))) 
            {
                if (! in_array($file, array( '.', '..' ))) 
                {
                    if (is_dir($folder . '/' . $file)) {
                        $files_array = array_merge($files_array, self::__scan($folder . '/' . $file));
                    } 
                    else {
                        $files_array[] = $folder . '/' . $file;
                    }
                }
            }
            closedir($folder_res);
            return $files_array;
        }
        return false;
    }

	// --------------------------------------------------------------------

    /**
     * Mode To theme Dir
     *
     * Move theme temp fil to valid theme folder [for internal use only]
     */

    public static function __move_to_theme_dir($theme_array, $global_manifest, $manifest, $extraction_data)
    {
        $theme_namespace = $theme_array[ 'theme' ][ 'namespace' ]; // theme namespace

        get_instance()->load->helper('file');
        $folder_to_lower = strtolower($theme_namespace);
        $theme_dir_path = get_instance()->events->apply_filters('fill_theme_path', SITEPATH) . $folder_to_lower;

        // Creating theme folder within
        if (! is_dir($theme_dir_path)) {
            mkdir($theme_dir_path, 0777, true);
        }

        // moving global manifest
        foreach ($global_manifest as $_manifest) 
        {
            // creating folder if it does'nt exists
            if (! is_file($_manifest)) {
                $dir_name = basename($_manifest);
                Filer::copy($_manifest, $theme_dir_path . '/' . $dir_name);
            } 
            else {
                $file_name = basename($_manifest);
                write_file($theme_dir_path . '/' . $file_name, file_get_contents($_manifest));
            }
        }

        // moving manifest to system folder
        $relative_json_manifest = array();
        foreach ($manifest as $_manifest) 
        {
            // removing raw_name from old manifest to ease copy
            $relative_path_to_file = explode($extraction_data[ 'upload_data' ][ 'raw_name' ] . '/', $_manifest);
            
            if (! is_file($_manifest)) {
                $dir_name = basename($_manifest);
                Filer::copy($_manifest, $relative_path_to_file[1]);
            } 
            else {
                // write file on the new folder
                Filer::file_copy($_manifest,  APPPATH . $relative_path_to_file[1]);
                // relative json manifest
                $relative_json_manifest[] = APPPATH . $relative_path_to_file[1];
            }
        }

        // Creating Manifest
        file_put_contents($theme_dir_path . '/' . self::$manifest_theme, json_encode($relative_json_manifest, JSON_PRETTY_PRINT));

        /**
         * New Feature Assets management
         * Description : move addon assets to public directory within a folder with namespace as name
        **/
        if (is_dir($theme_dir_path . '/' . get_instance()->config->item('asset_path'))) 
        {
            $addon_assets_folder = FCPATH . get_instance()->config->item('asset_path') . get_instance()->events->apply_filters('fill_theme_folder', '') . '/' . $folder_to_lower;
            if (is_dir($addon_assets_folder)) { // checks if addon folder exists on public folder
                Filer::drop($addon_assets_folder);
            }

            mkdir($addon_assets_folder); // creating addon folder within
            Filer::extractor($theme_dir_path . '/' . 'assets', $addon_assets_folder);
        }

        return true;
    }
}