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

$options = options(APPNAME);

$this->polatan->add_meta(array(
    'col_id' => 1,
    'class'     => 'col-12',
    'namespace' => 'settings',
    'gui_saver' => true,
    'form'      => array(
        'action' => site_url(array( 'admin', 'options', 'save', APPNAME )),
    ),
    'type' => 'card'
));

/**
 * Heading 1
 */
$filed_heading1[] = array(
    [
        'permission' => 'read.options',
        'type'  => 'text',
        'class'  => 'col-12 col-lg-6',
        'required'  => true,
        'label' => __('Site Name'),
        'name'  => 'site_name',
        'value' => set_value('site_name', riake('site_name', $options )),
        'description' => 'Enter your site name'
    ],
    [
        'permission' => 'read.options',
        'type'  => 'text',
        'class'  => 'col-12 col-lg-6',
        'label' => __('Site Title'),
        'name'  => 'site_title',
        'value' => set_value('site_title', riake('site_title', $options )),
        'description' => 'Enter your site title'
    ]
);
$filed_heading1[] = array(
    [
        'permission' => 'read.options',
        'type'  => 'textarea',
        'class'  => 'col-12 col-lg-6',
        'label' => __('Site Description'),
        'name'  => 'site_description',
        'value' => set_value('site_description', riake('site_description', $options )),
        'description' => 'Enter your site description'
    ],
    [
        'permission' => 'read.options',
        'type'  => 'textarea',
        'class'  => 'col-12 col-lg-6',
        'label' => __('Site Keywords'),
        'name'  => 'site_keywords',
        'value' => set_value('site_keywords', riake('site_keywords', $options )),
        'description' => 'Enter your site keywords'
    ]
);
$filed_heading1[] = array(
    [
        'permission'  => 'read.options',
        'type'    => 'select',
        'name'    => 'site_timezone',
        'class'  => 'col-12 col-lg-6',
        'label'   => __('Timezone'),
        'options' => $this->config->item('site_timezone'),
        'active'  => riake('site_timezone', $options)
    ],
    [
        'permission'  => 'read.options',
        'type'    => 'select',
        'name'    => 'site_language',
        'class'  => 'col-12 col-lg-6',
        'label'   => __('Language'),
        'options' => $this->config->item('supported_languages'),
        'active'  => riake('site_language', $options)
    ]
);
$filed_heading1[] = array(
    'permission' => 'manage.core',
    'type'  => 'text',
    'class'  => 'col-12',
    'label' => __('Copyright'),
    'name'  => 'copyright',
    'value' => set_value('copyright', riake('copyright', $options )),
);
$items_heading1 = $this->events->apply_filters('fill_setting_general', $filed_heading1);

/**
 * Heading 2
 */
$filed_heading2[] = array(
    [
        'permission'  => 'read.options',
        'type'    => 'select',
        'class'  => 'col-12 col-lg-6',
        'name'    => 'demo_mode',
        'label'   => __('Enable Demo ?'),
        'active'  => riake('demo_mode', $options),
        'options' => array(
            0 => __('No'),
            1 => __('Yes')
        ),
    ],
    [
        'permission'  => 'read.options',
        'type'    => 'select',
        'class'  => 'col-12 col-lg-6',
        'name'    => 'enable_site',
        'label'   => __('Enable Site ?'),
        'active'  => riake('enable_site', $options),
        'options' => array(
            0 => __('No'),
            1 => __('Yes')
        ),
    ]
);
$items_heading2 = $this->events->apply_filters('fill_setting_advance', $filed_heading2);

/**
 * Items
 */
$item[] = array(
    'id' => 1,
    'class' => 'card-header-light',
    'heading'=> __('General Settings'),
    'description' => 'Update your site name, description, language, and visibility..',
    'body' => array(
        'items' => $items_heading1
    )
);
$item[] = array(
    'id' => 2,
    'permission'  => 'read.options',
    'class' => 'card-header-light',
    'heading'=> __('Advanced Settings'),
    'description' => 'Advanced settings, open register user',
    'body' => array(
        'items' => $items_heading2
    )
);
$items = $this->events->apply_filters('fill_setting_items', $item);

/**
 * Item
 */
$this->polatan->add_item(array(
    'type'  => 'accordions',
    'accordion' => $items
), 'settings', 1);

$this->polatan->output();