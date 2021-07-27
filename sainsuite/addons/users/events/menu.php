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
class Users_Menu extends MY_Addon
{
    public function __construct()
    {
		parent::__construct();
		
        $this->events->add_filter( 'fill_aside_nav', array( $this, 'fill_aside_nav' ));
    }

	public function _header_nav($menu) {
        $menu[] = array(
            'id' => 3,
            'name' => __('Users'),
            'slug' => site_url([ 'admin', 'users' ]),
            'order' => 3,
            'permission' => 'read.users'
        );
        $menu[] = array(
            'id' => 4,
            'name' => __('Group'),
            'slug' => site_url([ 'admin', 'group' ]),
            'order' => 4,
            'permission' => 'read.group'
        );

        $header_nav = $this->events->apply_filters('fill_header_nav_users', $menu);
        
        return $header_nav;
	}

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
    **/
    public function fill_aside_nav($menus)
    {
        $menus[] = array(
            'id' => 4,
            'parent'  => NULL,
            'name' => __('Users' ),
            'icon' => 'icon-lg flaticon2-user-1',
            'slug'  => site_url('admin/users'),
            'permission' => 'read.users',
            'order' => 4
        );
        // $menus[] = array(
        //     'id' => 5,
        //     'parent'  => NULL,
        //     'name' => __('Inbox' ),
        //     'icon' => 'icon-lg flaticon2-chat-1',
        //     'slug'  => site_url('admin/chat'),
        //     'permission' => 'read.users',
        //     'order' => 5
        // );

        return $menus;
    }
}
new Users_Menu;