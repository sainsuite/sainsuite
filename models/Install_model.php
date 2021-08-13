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
class Install_Model extends CI_Model
{
    /**
     * Is installed
     * @return bool
    **/

    public function is_installed()
    {
        global $IsInstalled;

        if ($IsInstalled != null) {
            return $IsInstalled;
        }

        if (file_exists(APPPATH . 'config/database.php')) 
        {
            $this->load->database();
            if ($this->db->table_exists('options')) 
            {
                $this->db->close();
                $IsInstalled = true;
                return $IsInstalled;
            }
            $this->db->close();
        }

        $IsInstalled = false;
        return $IsInstalled;
    }

    /**
     * Undocumented function
     *
     * @param [type] $host_name
     * @param [type] $user_name
     * @param [type] $user_password
     * @param [type] $database_name
     * @param [type] $database_driver
     * @param [type] $database_prefix
     * @return void
     */
    public function installation($host_name, $user_name, $user_password, $database_name, $database_driver, $database_prefix)
    {
        $config['hostname'] = $host_name;
        $config['username'] = $user_name;
        $config['password'] = $user_password;
        $config['dbdriver'] = $database_driver;
        $config['dbprefix'] = ($database_prefix == '') ? 'Do_' : $database_prefix;
        $config['pconnect'] = false;
        $config['db_debug'] = false;
        $config['cache_on'] = false;
        $config['cachedir'] = '';
        $config['char_set'] = 'utf8';
        $config['dbcollat'] = 'utf8_general_ci';

        if ($database_driver == 'mysqli') 
        {
            if (! $link = @mysqli_connect($host_name, $user_name, $user_password)) 
            {
                return get_instance()->lang->line('unable-to-connect');
            }
            mysqli_close($link); // Closing connexion
        }

        $this->load->database($config);
        $this->load->dbutil();
        $db_exists = $this->dbutil->database_exists($database_name);
        if (! $db_exists) 
        {
            $this->load->dbforge();
            $this->dbforge->create_database($database_name);
        }

        $this->db->close();

        // Setting database name
        $config['database'] = $database_name;

        // Reconnect
        $this->load->database($config);

        $this->load->model('options_model');

        // Before settings tables
        // Used internaly to load addon only when database connection is established.
        $this->events->do_action('do_before_db_setup', array(
            'database_prefix' => $database_prefix,
            'install_model'   => $this
        ));

        // Creating option table
        $this->db->query("DROP TABLE IF EXISTS `{$database_prefix}options`;");
        $this->db->query("CREATE TABLE `{$database_prefix}options` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `key` VARCHAR(200) NOT NULL,
            `value` TEXT NULL,
            `app` VARCHAR(100) NOT NULL,
            PRIMARY KEY (`id`)
        ) COLLATE='utf8_general_ci' ENGINE=InnoDB ;");

        $this->events->do_action('do_settings_tables', array(
            'database_prefix' => $database_prefix,
            'install_model'   => $this
        ));

        // Creating Database File
        $this->create_config_file($config);

        // After settings tables
        $this->events->do_action('do_after_db_setup');

        return 'database-installed';
    }

    /**
     * Final Configuration
     *
     * @param string Site Name
     * @return mixed
    **/

    public function final_configuration()
    {
        // Saving Site name
        $this->options_model->set('site_name', $this->input->post('site_name'));
        $this->options_model->set('site_language', $this->input->post('lang'));
        $this->options_model->set('site_timezone', 'Asia/Jakarta');
        $this->options_model->set('site_theme', 'default');

        // Do actions
        $this->events->do_action('do_settings_final_config');

        // user can change this behaviors
        return $this->events->apply_filters('fill_validating_setup', 'system-installed');
    }

    /**
     * Create a config file
     *
     * @param Array config data
     * @return Void
    **/

    public function create_config_file($config)
    {
        /* CREATE CONFIG FILE */
        $string_config =
        "<?php
/**
 * Database configuration for SainSuite
 * -------------------------------------
 * SainSuite Version : " . get('version') . "
**/

defined('BASEPATH') OR exit('No direct script access allowed');

\$active_group = 'default';
\$query_builder = TRUE;

\$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '".$config['hostname']."',
	'username' => '".$config['username']."',
	'password' => '".$config['password']."',
	'database' => '".$config['database']."',
	'dbdriver' => '".$config['dbdriver']."',
	'dbprefix' => '".$config['dbprefix']."',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => 'apps/cache/database/',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);";
        $file = fopen(APPPATH . 'config/database.php', 'w+');
        fwrite($file, $string_config);
        fclose($file);
    }
}
