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
class Menus_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('multimenu');
    }

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
     **/
    public function usercard_nav()
    {
        get_instance()->multimenu->set_items(
            $this->events->apply_filters('fill_user_card', [])
        );

        $config["nav_tag_open"]   = '';
        $config["nav_tag_close"]  = '';
        $config["item_tag_open"]  = '<li class="navi-item">';
        $config["item_tag_close"] = '</li>';
        $config["item_anchor"]    = '<a class="navi-link" href="%s">%s</a>';
        $config["item_icon"]      = '<span class="navi-icon"><i class="%s"></i></span>';
        $config["item_label"]     = '<span class="navi-text">%s</span>';

        // call render in view
        return get_instance()->multimenu->render($config);
    }

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
     **/
    public function aside_nav()
    {
        get_instance()->multimenu->set_items(
            $this->events->apply_filters('fill_aside_nav', [])
        );

        $config["item_tag_open"]  = '<li class="nav-item mb-2" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="%s">';
        $config["item_tag_close"] = '</li>';
        $config["item_anchor"]    = '<a class="nav-link btn btn-icon btn-clean btn-lg" href="%s">%s</a>';
        $config["item_icon"]      = '<i class="%s"></i>';
        $config["item_label"]     = '<span class="d-none">%s</span>';

        // call render in view
        return get_instance()->multimenu->render($config);
    }

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
     **/
    public function aside_footer_nav()
    {
        $aside_footer_nav[] = array(
            'id'         => 3, 'parent' => null, 'order' => 1,
            'name'   => __('Appearance'),
            'icon'   => 'icon-lg fas fa-palette',
            'slug'   => site_url('admin/appearance'),
            'permission' => 'read.themes'
        );
        $aside_footer_nav[] = array(
            'id'         => 4, 'parent' => null, 'order' => 1,
            'name'   => __('Addons'),
            'icon'   => 'icon-lg flaticon2-layers-1',
            'slug'   => site_url('admin/addons'),
            'permission' => 'read.addons'
        );
        $aside_footer_nav[] = array(
            'id'         => 5, 'parent' => null, 'order' => 1,
            'name'   => __('Setting'),
            'icon'   => 'icon-lg flaticon2-settings',
            'slug'   => site_url('admin/settings'),
            'permission' => 'read.options'
        );
        $aside_footer_nav[] = array(
            'id'         => 6, 'parent' => null, 'order' => 1,
            'name'       => __('Reset'),
            'icon'       => 'icon-lg flaticon2-refresh-button',
            'slug'       => '#',
            'attr_anchor' => 'class="btn btn-icon btn-clean btn-lg mb-2" id="button_reset"',
            'permission' => 'manage.core'
        );
        get_instance()->multimenu->set_items(
            $this->events->apply_filters('fill_aside_footer_nav', $aside_footer_nav)
        );

        $config["item_tag_open"]  = '<div data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="%s" aria-expanded="false">';
        $config["item_tag_close"] = '</div>';
        $config["item_anchor"]    = '<a class="btn btn-icon btn-clean btn-lg mb-2" href="%s">%s</a>';
        $config["item_icon"]      = '<i class="%s"></i>';
        $config["item_label"]     = '<span class="d-none">%s</span>';
        get_instance()->multimenu->initialize($config);

        // call render in view
        return get_instance()->multimenu->render();
    }

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
     **/
    public function infocenter_nav()
    {
        $infocenter_nav[] = array(
            'id'     => 4, 'parent' => null, 'order'  => 1,
            'name'   => __('API'),
            'slug'   => site_url('admin/api')
        );
        $infocenter_nav[] = array(
            'id'     => 5, 'parent' => null, 'order'  => 1,
            'name'   => __('Terms'),
            'slug'   => site_url('admin/term')
        );
        $infocenter_nav[] = array(
            'id'     => 6, 'parent' => null, 'order'  => 1,
            'name'   => __('Privacy'),
            'slug'   => site_url('admin/privacy')
        );
        $infocenter_nav[] = array(
            'id'     => 7, 'parent' => null, 'order'  => 1,
            'name'   => sprintf( __( 'Copyright © %s %s' ), date('Y'), riake('site_name', options(APPNAME)) ),
            'slug'   => site_url('admin/about')
        );
        get_instance()->multimenu->set_items(
            $this->events->apply_filters('fill_infocenter_nav', $infocenter_nav)
        );

        $config["nav_tag_open"]   = '<div class="nav justify-content-center">';
        $config["nav_tag_close"]  = '</div>';
        $config["item_tag_open"]  = '<li class="nav-item" data-toggle="tooltip" title="%s">';
        $config["item_tag_close"] = '</li>';
        $config["item_anchor"]    = '<a class="navi-link px-2" href="%s">%s</a>';
        $config["item_label"]     = '<span class="navi-text">%s</span>';

        // call render in view
        return get_instance()->multimenu->render($config, []);
    }

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
     **/
    public function header_nav()
    {
        get_instance()->multimenu->set_items(
            $this->events->apply_filters('fill_header_nav', [])
        );

        $config["nav_tag_open"]   = '<div class="navheader-nav nav flex-grow-1">';
        $config["nav_tag_close"]  = '</div>';
        $config["item_tag_open"]  = '';
        $config["item_tag_close"] = '';
        $config["item_anchor"]    = '<a class="nav-item" href="%s">%s</a>';
        $config["item_label"]     = '<span class="nav-label px-10"><span class="nav-title font-weight-bold font-size-h5">%s</span></span>';
        $config["item_divider"] = '';
        get_instance()->multimenu->initialize($config);

        // call render in view
        return get_instance()->multimenu->render();
    }

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
     **/
    public function create_nav()
    {
        get_instance()->multimenu->set_items(
            $this->events->apply_filters('fill_create_nav', [])
        );

        $config["nav_tag_open"]   = '<div class="px-3 pt-2 pb-5 border-bottom">';
        $config["nav_tag_close"]  = '</div>';
        $config["item_tag_open"]  = '';
        $config["item_tag_close"] = '';
        $config["item_icon"]      = '<i class="%s"></i>';
        $config["item_label"]     = '';
        $config["item_anchor"]    = '<a class="btn btn-block btn-primary font-weight-bold text-uppercase text-center py-4" href="%s">%s</a>';
        $config["item_divider"] = '';
        get_instance()->multimenu->initialize($config);

        if (empty($this->events->apply_filters('fill_create_nav', []))) : return;
        endif;

        // call render in view
        if (User::is_allowed( $this->events->apply_filters('fill_create_nav', [])[0]['permission'] )) :
        return get_instance()->multimenu->render();
        endif;
    }

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
     **/
    public function toolbar_nav()
    {
        get_instance()->multimenu->set_items(
            $this->events->apply_filters('fill_toolbar_nav', [])
        );

        $config["nav_tag_open"]   = '';
        $config["nav_tag_close"]  = '';
        $config["item_tag_open"]  = '';
        $config["item_tag_close"] = '';
        $config["item_icon"]      = '<i class="%s"></i>';
        $config["item_label"]     = '<span>%s</span>';
        $config["item_anchor"]    = '<a href="%s">%s</a>';
        $config["item_divider"] = '';
        get_instance()->multimenu->initialize($config);

        // call render in view
        return get_instance()->multimenu->render();
    }

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
     **/
    public function breadcrumb_nav($item = null)
    {
        if ($item == null) {
            return false;
        }

        get_instance()->multimenu->set_items($item);

        $config["nav_tag_open"]  = '<ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 mr-4">';
        $config["nav_tag_close"]  = '</ul>';
        $config["item_tag_open"] = '<li class="breadcrumb-item">';
        $config["item_tag_close"] = '</li>';
        $config["item_label"]    = '<span class="text-muted">%s</span>';
        $config["item_divider"] = '';

        // call render in view
        return get_instance()->multimenu->render($config);
    }

    /**
     * Load Dashboard Menu
     * [New Permission Ready]
     **/
    public function menu_nav()
    {
        get_instance()->multimenu->set_items(
            $this->events->apply_filters('fill_menu_nav', [])
        );

        $config["nav_tag_open"]       = '<ul class="menu-nav list list-hover">';
        $config["nav_tag_close"]      = '</ul>';
        $config["parent_tag_open"]    = '<li class="menu-item menu-item-submenu mb-1">';
        $config["parent_anchor"]      = '<a class="menu-link d-flex align-items-center mb-1 border menu-toggle" href="%s">%s</a>';
        $config["children_tag_open"]  = '<div class="menu-submenu"><ul class="menu-subnav">';
        $config["children_tag_close"] = '</ul></div>';
        $config["item_tag_open"]      = '<li class="menu-item list-item hoverable mb-1 %s">';
        $config["item_tag_close"]     = '</li>';
        $config["item_anchor"]        = '<a class="menu-link d-flex align-items-center border" href="%s">%s</a>';
        $config["item_icon"]          = '<div class="symbol symbol-25 symbol-white ml-1 mr-4 border"><span class="symbol-label font-size-h5">%s</span></div>';
        $config["item_label"]         = '<div class="d-flex flex-column flex-grow-1 mr-2"><span class="text-dark-75 font-size-h6 mb-0">%s</span></div>';
        $config["item_arrow"]         = '<i class="menu-arrow"></i>';
        $config["item_divider"]       = '<li class="menu-section"><h4 class="menu-text">%s</h4></li>';

        // call render in view
        return get_instance()->multimenu->render($config, $this->events->apply_filters('fill_menu_nav_divider', ['']));
    }
}