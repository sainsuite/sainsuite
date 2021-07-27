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

/**
 * Output array details
 * @access public
 * @param Array
 * @param Bool
 * @return String
**/

function dd($array, $return = false)
{
    ob_start();
    echo '<pre>';
    var_dump($array);
    echo '</pre>';
    die;
    // return $return ? ob_get_clean() : null;
}

// --------------------------------------------------------------------

/**
 * Output message from URL
 *
 * @param String (error code)
 * @return String (Html result)
**/
if (!function_exists('notice_from_url')) 
{
    function notice_from_url()
    {
        $notice = '';
        if (isset($_GET['notice'])) {
            $notice = get_instance()->lang->line($_GET['notice']);
        }
        return $notice;
    }
}

/**
 * Output message with error tag
 *
 * @param String (error code)
 * @return String (Html result)
 * @package 3.0
**/

if (!function_exists('notice_error')) {
    function notice_error($text)
    {
        return '<div class="alert alert-custom alert-primary fade show" role="alert">
            <div class="alert-icon"><i class="fa fa-warning"></i></div>
            <div class="alert-text">'.$text.'</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ss ss-close"></i></span>
                </button>
            </div>
        </div>';
    }
}

/**
 * Output message with success tag
 *
 * @param String (error code)
 * @return String (Html result)
**/

if (!function_exists('notice_success')) {
    function notice_success($text)
    {
        return '<div class="alert alert-custom alert-primary fade show" role="alert">
            <div class="alert-icon"><i class="fa fa-thumbs-o-up"></i></div>
            <div class="alert-text">'.$text.'</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ss ss-close"></i></span>
                </button>
            </div>
        </div>';
    }
}

/**
 * Output message with warning tag
 *
 * @param String (error code)
 * @return String (Html result)
**/

if (!function_exists('notice_warning')) {
    function notice_warning($text)
    {
        return '<div class="alert alert-custom alert-warning fade show" role="alert">
            <div class="alert-icon"><i class="fa fa-warning"></i></div>
            <div class="alert-text">'.$text.'</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ss ss-close"></i></span>
                </button>
            </div>
        </div>';
    }
}

/**
 * Output message with Info tag
 *
 * @param String (error code)
 * @return String (Html result)
**/

if (!function_exists('notice_info')) {
    function notice_info($text)
    {
        return '<div class="alert alert-custom alert-info fade show" role="alert">
            <div class="alert-icon"><i class="fa fa-info"></i></div>
            <div class="alert-text">'.$text.'</div>
            <div class="alert-close">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="ss ss-close"></i></span>
                </button>
            </div>
        </div>';
    }
}


/**------------------------------------------------------------------------
 *                           Pagination
 *------------------------------------------------------------------------**/
// this function will be called to get configuration of pagination
function pagination_config($base_url,$total_rows,$per_page){
    // Pagination Configuration
    $config['base_url']         = $base_url;
    $config['use_page_numbers'] = TRUE;
    $config['total_rows']       = $total_rows;
    $config['per_page']         = $per_page;
    $config['full_tag_open']    = '<div class="d-flex flex-wrap py-2 mr-3">';
    $config['full_tag_close']   = '</div>';
    $config['first_link']       = '<i class="ss ss-bold-double-arrow-back icon-xs"></i>';
    $config['prev_link']        = '<i class="ss ss-bold-arrow-back icon-xs"></i>';
    $config['cur_tag_open']     = '<a href="#" class="btn btn-icon btn-sm border-0 btn-hover-primary mr-2 my-1 active">';
    $config['cur_tag_close']    = '</a>';
    $config['next_link']        = '<i class="ss ss-bold-arrow-next icon-xs"></i>';
    $config['last_link']        = '<i class="ss ss-bold-double-arrow-next icon-xs"></i>';
    $config['attributes']       = array('class' => 'btn btn-icon btn-sm btn-light-primary mr-2 my-1');
    return $config;
}

// --------------------------------------------------------------------

/**
 * Returns if array key exists. If not, return false if $default is not set or return $default instead
 */
if (! function_exists('riake')) 
{
    function riake($key, $subject, $default = false)
    {
        if (is_array($subject)) {
            return array_key_exists($key, $subject) ? $subject[ $key ] : $default;
        }
        return $default;
    }
}

// --------------------------------------------------------------------
 
function farray($array)
{
    return riake(0, $array, false);
}

// --------------------------------------------------------------------
 
/**
 * Force a var to be an array.
 *
 * @param Var
 * @return Array
**/
function force_array($array)
{
    if (is_array($array)) {
        return $array;
    }
    return array();
}

/**
 * Pluck an array of values from an array. (Only for PHP 5.3+)
 *
 * @param  $array - data
 * @param  $key - value you want to pluck from array
 *
 * @return plucked array only with key data
 */
function array_pluck($array, $key) {
    return array_map(function($v) use ($key)	{
        return is_object($v) ? $v->$key : $v[$key];
    }, $array);
}

/*
 * Inserts a new key/value before the key in the array.
 *
 * @param $key
 * The key to insert before.
 * @param $array
 * An array to insert in to.
 * @param $new_key
 * The key to insert.
 * @param $new_value
 * An value to insert.
 *
 * @return
 * The new array if the key exists, FALSE otherwise.
 *
 * @see array_insert_after()
 */
function array_insert_before($key, $array, $new_key, $new_value)
{
    if (array_key_exists($key, $array)) {
        $new = array();
        foreach ($array as $k => $value) {
            if ($k === $key) {
                $new[$new_key] = $new_value;
            }
            $new[$k] = $value;
        }
        return $new;
    }
    return $array;
}

// --------------------------------------------------------------------

/**
 * get recupère des informations sur le système.
 */
if (! function_exists('get')) 
{
    function get($key) // add to doc
    {
        $vers = explode('-', get_instance()->config->item('version'));
        switch ($key) {
            case "str_version" :
                return $vers[0].' '.$vers[1];
            break;
            case "version" :
                return $vers[0];
            break;
            case "signature" :
                return get_instance()->config->item('signature');
            break;
            case 'app_name':
                return get_instance()->config->item('app_name');
            break;
        }
    }
}

//multiple image upload with resize option
function do_upload($photo, $app = null) 
{
    $CI	=&	get_instance();
    $config['allowed_types'] = 'gif|jpg|png|jpeg|svg';
    $config['upload_path']   = upload_path($app);
    $config['max_size']      = '20000';
    $config['max_width']     = '20000';
    $config['max_height']    = '20000';

    $CI->load->library('upload', $config);                
    if ($CI->upload->do_upload($photo)) 
    {
        $data = $CI->upload->data(); 
        /* PATH */
        $source             = upload_path($app).$data['file_name'] ;
        $new_name           = bin2hex(random_bytes(10));
        $destination_media  = upload_path($app)."media/" ;
        $destination_thumb  = $destination_media."thumb/" ;
        $destination_medium = $destination_media."medium/" ;
        if (!is_dir($destination_media)) {
            mkdir($destination_media);
            mkdir($destination_medium);
            mkdir($destination_thumb);
        }

        // Permission Configuration
        chmod($source, 0777) ;

        /* Resizing Processing */
        // Configuration Of Image Manipulation :: Static
        $CI->load->library('image_lib') ;
        $img['image_library'] = 'GD2';
        $img['create_thumb']  = TRUE;
        $img['maintain_ratio']= TRUE;

        /// Limit Width Resize
        $limit_media = 2000 ;
        $limit_thumb = 100 ;
        $limit_medium = 400 ;

        // Size Image Limit was using (LIMIT TOP)
        $limit_use  = $data['image_width'] > $data['image_height'] ? $data['image_width'] : $data['image_height'] ;

        // Percentase Resize
        if ($limit_use > $limit_media || $limit_use > $limit_thumb || $limit_use > $limit_medium) {
            $percent_big = $limit_media/$limit_use ;
            $percent_thumb  = $limit_thumb/$limit_use ;
            $percent_medium  = $limit_medium/$limit_use ;
        }

        //// Making THUMBNAIL ///////
        $img['width']  = $limit_use > $limit_thumb ?  $data['image_width'] * $percent_thumb : $data['image_width'] ;
        $img['height'] = $limit_use > $limit_thumb ?  $data['image_height'] * $percent_thumb : $data['image_height'] ;

        // Configuration Of Image Manipulation :: Dynamic
        $img['thumb_marker'] = '' ;
        $img['quality']      = '99%' ;
        $img['source_image'] = $source ;
        $img['new_image']    = $destination_thumb.$new_name.$data['file_ext'] ;

        // Do Resizing
        $CI->image_lib->initialize($img);
        $CI->image_lib->resize();
        $CI->image_lib->clear() ;                 

        //// Making MEDIUM ///////
        $img['width']  = $limit_use > $limit_medium ?  $data['image_width'] * $percent_medium : $data['image_width'] ;
        $img['height'] = $limit_use > $limit_medium ?  $data['image_height'] * $percent_medium : $data['image_height'] ;

        // Configuration Of Image Manipulation :: Dynamic
        $img['thumb_marker'] = '' ;
        $img['quality']      = '99%' ;
        $img['source_image'] = $source ;
        $img['new_image']    = $destination_medium.$new_name.$data['file_ext'] ;

        // Do Resizing
        $CI->image_lib->initialize($img);
        $CI->image_lib->resize();
        $CI->image_lib->clear() ;               

        ////// Making BIG /////////////
        $img['width']   = $limit_use > $limit_media ?  $data['image_width'] * $percent_big : $data['image_width'] ;
        $img['height']  = $limit_use > $limit_media ?  $data['image_height'] * $percent_big : $data['image_height'] ;

        // Configuration Of Image Manipulation :: Dynamic
        $img['thumb_marker'] = '' ;
        $img['quality']      = '99%' ;
        $img['source_image'] = $source ;
        $img['new_image']    = $destination_media.$new_name.$data['file_ext'] ;

        // Do Resizing
        $CI->image_lib->initialize($img);
        $CI->image_lib->resize();
        $CI->image_lib->clear() ;

        $picture = $new_name.$data['file_ext'];

        ////// Making SVG /////////////
        if ($data['file_ext'] == '.svg')
        {
            $picture = $data['file_name'];
            Filer::file_copy($source, $destination_media.$picture);
        }

        $data_image = array('picture' => $picture );

        unlink($source) ;   
        return $data_image;   

    }
    else {
        return FALSE ;
    }
   
}

function options($app = 'system')
{
    if (! get_instance()->install_model->is_installed()) : return;
    endif;

    global $AppOptions;
    get_instance()->load->model('options_model');

    if ( ! empty( @$AppOptions[ $app ] )) {
        return $AppOptions[ $app ];
    } 

    $options = get_instance()->options_model->get(null, $app);
    
    $AppOptions[ $app ] = $options;
    return $options;
}

/**
 *  Get Options
 *  @param string option key
 *  @return string/int/array
**/

function get_option( $key = null, $default = null, $app = APPNAME ) {
    if( $key != null ) {
        return riake( $key, options($app), $default);
    }

    return options($app);
}