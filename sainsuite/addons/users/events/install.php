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
class Users_Install extends MY_Addon
{
    public function __construct()
    {
        parent::__construct();

        // Installation
        $this->events->add_action('do_after_db_setup', [ $this, 'enable_addon' ] );
        $this->events->add_action('do_settings_tables', array( $this, 'do_settings_tables' ), 1);
        $this->events->add_action('do_settings_final_config', array( $this, 'permissions' ));
        $this->events->add_action('do_settings_final_config', array( $this, 'final_config' ));
        
        $this->events->add_filter('fill_site_setup', array( new Users_Filters, 'fill_registration_rules' ));
    }

    public function enable_addon()
    {
        MY_Addon::enable('users');
    }
    
    public function do_settings_tables($config)
    {
        extract($config);

        // Creatin Auth Group
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$database_prefix}aauth_groups` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(100),
            `definition` text,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Auth Group to Group
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$database_prefix}aauth_group_to_group` (
            `group_id` int(11) unsigned NOT NULL,
            `subgroup_id` int(11) unsigned NOT NULL,
            PRIMARY KEY (`group_id`,`subgroup_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Creating Auth Permission
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$database_prefix}aauth_perms` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(100),
            `definition` text,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Creating Permission to Group
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$database_prefix}aauth_perm_to_group` (
            `perm_id` int(11) unsigned NOT NULL,
            `group_id` int(11) unsigned NOT NULL,
            PRIMARY KEY (`perm_id`,`group_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Auth Permission to User
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$database_prefix}aauth_perm_to_user` (
            `perm_id` int(11) unsigned NOT NULL,
            `user_id` VARCHAR(100) NOT NULL,
            PRIMARY KEY (`perm_id`,`user_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Auth PMS
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$database_prefix}aauth_pms` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `sender_id` VARCHAR(100) NOT NULL,
            `receiver_id` VARCHAR(100) NOT NULL,
            `title` varchar(255) NOT NULL,
            `message` text,
            `date_sent` datetime DEFAULT NULL,
            `date_read` datetime DEFAULT NULL,
            `pm_deleted_sender` int(1) DEFAULT NULL,
            `pm_deleted_receiver` int(1) DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `full_index` (`id`,`sender_id`,`receiver_id`,`date_read`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Auth User Table
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$database_prefix}aauth_users` (
            `id` VARCHAR(100) NOT NULL,
            `email` VARCHAR(100) NOT NULL,
            `pass` VARCHAR(64) NOT NULL,
            `username` VARCHAR(100) NULL DEFAULT NULL,
            `picture` VARCHAR(255) NULL DEFAULT NULL,
            `banned` TINYINT(1) NULL DEFAULT '0',
            `last_login` DATETIME NULL DEFAULT NULL,
            `last_activity` DATETIME NULL DEFAULT NULL,
            `date_created` DATETIME NULL DEFAULT NULL,
            `forgot_exp` TEXT NULL,
            `remember_time` DATETIME NULL DEFAULT NULL,
            `remember_exp` TEXT NULL,
            `verification_code` TEXT NULL,
            `totp_secret` VARCHAR(16) NULL DEFAULT NULL,
            `ip_address` TEXT NULL,
            PRIMARY KEY (`id`)
          ) COLLATE='utf8_general_ci' ENGINE=InnoDB ; ");
        
        // User Auth Group
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$database_prefix}aauth_user_to_group` (
            `user_id` VARCHAR(100) NOT NULL,
            `group_id` int(11) unsigned NOT NULL,
            PRIMARY KEY (`user_id`,`group_id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        
        // Auth User Variable
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$database_prefix}aauth_user_variables` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` VARCHAR(100) NOT NULL,
            `data_key` VARCHAR(100) NOT NULL,
            `value` TEXT NULL,
            PRIMARY KEY (`id`),
            INDEX `user_id_index` (`user_id`)
          ) COLLATE='utf8_general_ci' ENGINE=InnoDB ;");
        
        // Auth Attempts
        $this->db->query("CREATE TABLE IF NOT EXISTS `{$database_prefix}aauth_login_attempts` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `ip_address` varchar(39) DEFAULT '0',
            `timestamp` datetime DEFAULT NULL,
            `login_attempts` tinyint(2) DEFAULT '0',
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
    }
    
    /**
     * Set groupes
     *
     * @return void
    **/
    public function permissions()
    {
        // Only create if group does'nt exists (it's optional)
        $this->aauth->create_group('master', 'Master');
        $this->aauth->create_group('admin', 'Administrator');
        $this->aauth->create_group('user', 'User');

        /**
         * Creating default permissions
        **/
        $permissions =	[];
        // Core Permission
        $permissions[ 'manage.core' ] = __( 'Manage Core' );

        // Options Permissions
        $permissions[ 'create.options' ] = __( 'Create Options' );
        $permissions[ 'edit.options' ]   = __( 'Edit Options' );
        $permissions[ 'read.options' ]   = __( 'Read Options' );

        // Addons Permissions
        $permissions[ 'read.addons' ]    = __( 'Read Addons' );
        $permissions[ 'install.addons' ] = __( 'Install Addons' );
        $permissions[ 'update.addons' ]  = __( 'Update Addons' );
        $permissions[ 'delete.addons' ]  = __( 'Delete Addons' );
        $permissions[ 'toggle.addons' ]  = __( 'Enable/Disable Addons' );
        $permissions[ 'extract.addons' ] = __( 'Extract Addons' );

        // Themes Permissions
        $permissions[ 'read.themes' ]    = __( 'Read themes' );
        $permissions[ 'install.themes' ] = __( 'Install themes' );
        $permissions[ 'delete.themes' ]  = __( 'Delete themes' );
        $permissions[ 'toggle.themes' ]  = __( 'Enable/Disable themes' );
        $permissions[ 'extract.themes' ] = __( 'Extract themes' );

        // Users Permissions
        $permissions[ 'read.users' ]   = __( 'Read Users' );
        $permissions[ 'create.users' ] = __( 'Create Users' );
        $permissions[ 'edit.users' ]   = __( 'Edit Users' );
        $permissions[ 'delete.users' ] = __( 'Delete Users' );

        // Group Permissions
        $permissions[ 'read.group' ]   = __( 'Read Group' );
        $permissions[ 'create.group' ] = __( 'Create Group' );
        $permissions[ 'edit.group' ]   = __( 'Edit Group' );
        $permissions[ 'delete.group' ] = __( 'Delete Group' );

        // Profile Permission
        $permissions[ 'edit.profile' ] = __( 'Edit Profile' );

        foreach( $permissions as $namespace => $perm ) {
          $this->aauth->create_perm( 
            $namespace,
            $perm
          );
        }

        /**
         * Assign Permission to Groups
        **/
        // Member
        $permissions_keys =	array_keys( $permissions );
        foreach([ 
          'options',
          'addons',
          'themes',
          'users',
          'group',
          'profile',
        ] as $component ) {
          foreach([ 'create.', 'edit.', 'delete.', 'read.', 'toggle.', 'extract.', 'install.', 'update.', 'manage.' ] as $action ) 
          {
            $permission = $action . $component;
            if ( in_array( $permission, $permissions_keys ) ) {
              $this->aauth->allow_group( 'admin', $permission );
            }
          }
        }

        // Users
        foreach([
          'edit.profile'
        ] as $permission ) {
          	$this->aauth->allow_group( 'user', $permission );
        }
    }

    /**
     * Final Config
     *
     * @return void
    **/
    public function final_config()
    {
        // Creating Master & Groups
        $create_user = $this->user_model->create_master(
            $this->input->post('email'),
            $this->input->post('password'),
            $this->input->post('username')
        );
        
        if ($create_user != 'created') {
            $this->events->add_filter('fill_validating_setup', 'unexpected-error');
        }
    }
}
new Users_Install;