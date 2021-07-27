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
class User
{
    /**
     * Checks whether a user is connected
     * @access public
     * @return bool
    **/

    public static function is_loggedin()
    {
        return get_instance()->aauth->is_loggedin();
    }

	/**
	 * Get user id
	 * Get user id from email address, if par. not given, return current user's id
	 * @param string|bool $email Email address for user
	 * @return int User id
	 */
    public static function id($user_par = false)
    {
        $user = get_instance()->aauth->get_user_id($user_par);
        return $user ? $user : 0;
    }

	/**
	 * Get user
	 * Get user information
	 * @param int|bool $user_id User id to get or FALSE for current user
	 * @return object User information
	 */
    public static function get($user_par = false)
    {
        return get_instance()->aauth->get_user($user_par);
    }

	/**
	 * Get user groups
	 * Get groups a user is in
	 * @param int|bool $user_id User id to get or FALSE for current user
	 * @return array Groups
	 */
    public static function get_user_group($user_par = false)
    {
        return get_instance()->aauth->get_user_group($user_par);
    }

	/**
	 * Is member
	 * Check if current user is a member of a group
	 * @return bool
	 */
    public static function in_group($group_name)
    {
        return get_instance()->aauth->is_member($group_name);
    }

	/**
	 * Controls if a logged or public user has permission	 *
	 * @param bool $perm_par If not given just control user logged in or not
	 */
    public static function control( $perm_par = false )
    {
        return get_instance()->aauth->control($perm_par);
    }

	/**
	 * Is user allowed
	 * Check if user allowed to do specified action, admin always allowed
	 * first checks user permissions then check group permissions
	 * @param int $perm_par Permission id or name to check
	 * @param int|bool $user_id User id to check, or if FALSE checks current user
	 * @return bool
	 */
    public static function is_allowed($perm_par, $user_id=false)
    {
        return get_instance()->aauth->is_allowed($perm_par, $user_id);
    }

    /**
     * Get user avatar SRC
     * @return string
    **/

    public static function get_user_image_url($user_id = 0)
    {
        if ($picture = riake('picture', (array) get_instance()->aauth->get_user($user_id)))
            return $picture;
        elseif (file_exists(upload_path().'user_image/'.$user_id.'.jpg'))
            return upload_url().'user_image/'.$user_id.'.jpg';
        else 
            $current_user = get_instance()->aauth->get_user($user_id);
            return self::get_gravatar($current_user->email, 90);
    }

    /**
     * Get use avatar
     * @param string email
     * @param int width
     * @param string
     * @param string
     * @param bool
     * @param array atts
     * @return string avatar src/image tag
    **/

    public static function get_gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array())
    {
        $url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ?  "https" : "http") . '://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";

        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
        }

		// Open the socket
		if ( $fp = @fsockopen('www.saintekno.id', 80)) {
            return $url;
		}

        return img_url().'user.jpg';
    }

    public static function upload_user_image($user_id) 
    {
        if (isset($_FILES['user_image']) && $_FILES['user_image']['name'] != "") 
        {
            $destination_user = upload_path()."user_image/" ;
            if (!is_dir($destination_user)) {
                mkdir($destination_user);
            }
            Filer::file_copy($_FILES['user_image']['tmp_name'], $destination_user.$user_id.'.jpg');
        }
    }
}
