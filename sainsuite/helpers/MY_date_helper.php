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

function get_academic_year($datestr)
{
    $year = substr($datestr, 0, 4);
    if(intval(substr($datestr,4,2)) < 8)
        $ayear = ($year - 1).'/'.$year;
    else
        $ayear = ($year).'/'.($year + 1);

    return $ayear;
}

function get_semester($datestr)
{
    if(intval(substr($datestr,5,2)) < 6)
        $semester = 1;
    else
        $semester = 2;

    return $semester;
}

function get_year($datestr)
{
    return intval(substr($datestr,0,4));
}

function get_range_date($start_date = '', $end_date = '')
{
    $tgl1 = new DateTime($start_date);
    $tgl2 = new DateTime($end_date);
    $d = $tgl2->diff($tgl1)->days + 1;
    $selisi = $d." hari";

    return $selisi;
}

function get_range_time($start_date = '', $end_date = '')
{
    $datetime1 = new DateTime($start_date);
    $datetime2 = new DateTime($end_date);
    $d = $datetime1->diff($datetime2);
    $elapsed = $d->format('%H : %I : %S');

    return $elapsed;
}

// current date time function
if(!function_exists('my_date_now')){
    function my_date_now(){       
        $dt = new DateTime('now', new DateTimezone(get_time_zone()));
        $date_time = $dt->format('Y-m-d H:i:s');      
        return $date_time;
    }
}

if(!function_exists('get_time_ago')){
    function get_time_ago($time_ago){      
        $dt = new DateTime('now', new DateTimezone(get_time_zone()));
        $date_time = strtotime($dt->format('Y-m-d H:i:s')); 

        $time_ago = strtotime($time_ago);
        $cur_time   = $date_time;
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed ;
        $minutes    = round($time_elapsed / 60 );
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400 );
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640 );
        $years      = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60){
            return "just now";
        }
        //Minutes
        else if($minutes <=60){
            if($minutes==1){
                return "one minute ago";
            }
            else{
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "an hour ago";
            }else{
                return "$hours hrs ago";
            }
        }
        //Days
        else if($days <= 7){
            if($days==1){
                return "yesterday";
            }else{
                return "$days days ago";
            }
        }
        //Weeks
        else if($weeks <= 4.3){
            if($weeks==1){
                return "a week ago";
            }else{
                return "$weeks weeks ago";
            }
        }
        //Months
        else if($months <=12){
            if($months==1){
                return "a month ago";
            }else{
                return "$months months ago";
            }
        }
        //Years
        else{
            if($years==1){
                return "one year ago";
            }else{
                return "$years years ago";
            }
        }
    }
}

if(!function_exists('get_time_zone')){
    function get_time_zone(){        
        global $Options;
        return ($timezone = riake('site_timezone', options(APPNAME))) ? $timezone : $Options['site_timezone'];
    }
}

/**
 * date_now()
 * Returns current date considering settings
**/

function date_now( $format = DATE_W3C )
{
    return date( $format, date_timestamp());
}

// --------------------------------------------------------------------

/**
 * Date Timestamp
 * Returns a UNIX Timestamp based on Current site settings
**/

function date_timestamp()
{ 
    $Options = options(APPNAME);
    return now( @$Options[ 'site_timezone' ] );
}
    
if(!function_exists('date_dif')){
    function date_dif($date1, $date2){ 
        $date1 = date_create($date1);
        $date2 = date_create($date2);
        //difference between two dates
        $diff = date_diff($date1,$date2);
        //count days
        return $diff->format("%a")-1;
    }
}

if(!function_exists('date_count')){
    function date_count($date, $day){ 
        $result = date('Y-m-d', strtotime($date. ' +'.$day.' days'));
        if (empty($date) || empty($day)) {
            return FALSE;
        } else {
            return $result;
        }
    }
}

// show current date with custom format
if(!function_exists('month_show')){
    function month_show($date){       
        
        if($date != ''){
            $date2 = date_create($date);
            $date_new = date_format($date2,"M Y");
            return $date_new;
        }else{
            return '';
        }
    }
}

// show current date with custom format
if(!function_exists('my_date_show')){
    function my_date_show($date){       
        
        if($date != ''){
            $date2 = date_create($date);
            $date_new = date_format($date2,"d M Y");
            return $date_new;
        }else{
            return '';
        }
    }
}

// show current date with custom format
if(!function_exists('show_year')){
    function show_year($date){       
        
        if($date != ''){
            $date2 = date_create($date);
            $date_new = date_format($date2,"Y");
            return $date_new;
        }else{
            return '';
        }
    }
}