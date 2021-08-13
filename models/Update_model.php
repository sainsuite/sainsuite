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
class Update_Model extends CI_Model
{
    private static $api_releases = 'https://api.github.com/repos/saintekno/sainsuite/releases';

    private static $api_zip = 'https://codeload.github.com/saintekno/sainsuite/legacy.zip/';
    
    public function __construct()
    {
        $this->load->library('curl');
        $this->load->library('Filer');

        $this->core_version = $this->config->item('version');

        // $this->auto_update();
    }

    /**
     * Check Update
     * @return bool/array
    **/

    public function check()
    {
        // Get Repo Check Version Releases
        $json_api = $this->curl->security(false)->get(self::$api_releases);

        $Do_update = array();

        if ($json_api != '') 
        {
            $latest_release = array();

            // Fetching the latest stable release;
            // Current Branch Release
            $array_api = json_decode($json_api, true);
            foreach ($array_api as $_rel) 
            {
                if (riake('prerelease', $_rel) === false && riake('draft', $_rel) === false) {
                    $latest_release = $_rel;
                    break;
                }
            }

            if (is_array($latest_release) && ! empty($latest_release)) 
            {
                // retreiving informations
                $release_version  = riake('tag_name', $latest_release);
                $latest_release = array(
                    'version'     => $release_version,
                    'name'        => riake('name', $latest_release),
                    'description' => riake('body', $latest_release),
                    'beta'        => riake('prerelease', $latest_release),
                    'published'   => riake('published_at', $latest_release),
                    'link'        => riake('zipball_url', $latest_release),
                );
                $Do_update[ 'core' ] = $latest_release;

                // Set to DB
                $this->options_model->set('latest_release', $Do_update);
            }
        }

        // Setting Core Warning
        $array = array();
        if ($release = riake('core', $Do_update)) 
        {
            $release_int = str_replace('.', '', $release[ 'version' ]);
            $current_int = str_replace('.', '', $this->core_version);
            if ($release_int > $current_int) 
            { 
                $array[] = array(
                    'link'    => $release[ 'link' ],
                    'content' => $release[ 'description' ],
                    'title'   => $release[ 'name' ],
                    'date'    => $release[ 'published' ],
                    'version' => $release[ 'version' ]
                );
            }
        }

        return $array;
    }

    /**
     * Get Release
     *
     * @param string release id
     * @return string error code
    **/

    public function get($release_version)
    {
        $json_api = $this->curl->security(false)->get(self::$api_releases);
        if ($json_api != '') 
        {
            $array_api = json_decode($json_api, true);
            
            $release = array();
            
            foreach ($array_api as $_rel) 
            {
                if (riake('tag_name', $_rel) == $release_version) 
                {
                    $release = $_rel;
                    break;
                }
            }

            if ($release) 
            {
                $release_int = intval(str_replace('.', '', riake('tag_name', $release)));
                $current_int = intval(str_replace('.', '', $this->core_version));

                if ($release_int > $current_int) 
                {
                    return riake('tag_name', $_rel); // get release tag_name
                }
                return 'old-release';
            }
        }
        return 'unknow-release';
    }

    /**
     * Install a release
     *
     * @param string version
     * @param string zipball name
     * @return array
    **/

    public function install($stage, $zipball = null)
    {
        $Do_zip = APPPATH . 'temp/sainsuite.zip';
        $dircore = APPPATH . 'temp/core';

        if ($stage === 1 && $zipball != null) 
        { 
            // for downloading
            $Do_zip_core = $this->curl->security(false)->get(self::$api_zip . $zipball);
            if (! empty($Do_zip_core)) 
            {
                file_put_contents($Do_zip, $Do_zip_core);
                return array(
                    'code' => 'archive-downloaded'
                );
            }
        } 
        elseif ($stage === 2) 
        { 
            if ( is_file($Do_zip) ) 
            {
                // for uncompressing
                $zip = new ZipArchive;
                if ($zip->open($Do_zip)) 
                {
                    if (is_dir($dircore)) 
                    {
                        Filer::drop($dircore); // if any update failed, we drop temp/core before
                    }
                    mkdir($dircore);
                    $zip->extractTo($dircore);
                    $zip->close();
                }
                unlink($Do_zip); // removing zip file
                return array(
                    'code' => 'archive-uncompressed'
                );
            }
        } 
        elseif ($stage === 3) 
        { 
            // updating itself
            if (is_dir($dircore)) 
            { 
                // looping internal dir
                $dirs = '';
                if ($dir = opendir($dircore)) {
                    while (false !== ($file = readdir($dir))) 
                    {
                        if (!in_array($file, array( '.', '..' ))) 
                        { 
                            $dirs = $file;
                            break;
                        }
                    }
                }
                
                if ($diroot = opendir($dircore . '/' . $dirs)) 
                {
                    while (false !== ($files = readdir($diroot))) 
                    {
                        if (! in_array($files, array( '.', '..' ))) 
                        { 
                            if ($files == basename(BASEPATH)) 
                            { 
                                Filer::extractor(APPPATH . 'temp/core/' . $dirs .'/'. $files, BASEPATH);
                            }
                            elseif ($files == basename(APPPATH)) 
                            { 
                                Filer::extractor(APPPATH . 'temp/core/' . $dirs .'/'. $files, APPPATH);
                            }
                            elseif ($files == basename(FCPATH) || $files == 'public') 
                            { 
                                if ($dipublic = opendir($dircore . '/' . $dirs .'/'. $files)) 
                                {
                                    while (false !== ($filesx = readdir($dipublic))) 
                                    {
                                        if (! in_array($filesx, array( '.', '..', 'index.php' ))) 
                                        { 
                                            Filer::extractor(APPPATH . 'temp/core/' . $dirs .'/'. $files .'/'. $filesx, FCPATH . $filesx);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return array(
                'code' => 'instaling'
            );
        }
        elseif ($stage === 4) 
        { 
            // updating itself
            if (is_dir($dircore)) 
            { 
                Filer::drop($dircore); // if any update failed, we drop temp/core before
                return array(
                    'code' => 'update-done'
                );
            }
        }

        return array(
            'code' => 'error-occured'
        );
    }
}
