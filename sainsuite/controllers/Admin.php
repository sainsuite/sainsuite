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

use Pecee\SimpleRouter\SimpleRouter as Route;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class Admin extends MY_Controller 
{
	public function __construct()
	{
        parent::__construct();

        $this->load->model( admin_theme().'menus_model' );
        $this->load->model( admin_theme().'admin_model' );
        $this->load->model( 'update_model' );

        // Loading Admin Menu
        $this->events->do_action( 'do_dashboard_init' );
    }

	// --------------------------------------------------------------------

    /**
     * Rmap Controller
     *
     * @param [type] $page
     * @param array $params
     * @return void
     */
    public function _remap($page, $params = array())
    {
        global $Routes;

        if (method_exists($this, $page)) {
            return call_user_func_array(array( $this, $page ), $params);
        } 
        else {
            // Init Routes
            $Routes = new Route();

            // prefixed route
            $Routes->group([ 
                'prefix' => substr( request()->getHeader( 'script-name' ), 0, -10 ) . '/admin' 
            ], function() use ( $page, $Routes ) {

                $addons = MY_Addon::get();
                
                foreach( force_array($addons) as $namespace => $addon ) 
                {
					if( MY_Addon::is_active( $namespace ) ) 
					{
                        if( is_dir( $dir = ADDONSPATH . $namespace . '/routes/' ) ) {
                            foreach( glob( $dir . "*.php") as $filename) {
                                include_once( $filename );
                            }
                        }
            
                        if( is_file( ADDONSPATH . $namespace . '/routes.php' ) ) {
                            include_once( ADDONSPATH . $namespace . '/routes.php' );
                        }
                    }
                }
            });

            $Routes->error(function($request, \Exception $exception) {
                if($exception instanceof NotFoundHttpException && $exception->getCode() == 404) {
                    $this->aauth->error($this->lang->line('aauth_error_no_access'), true);
                    $url = $this->events->apply_filters( 'fill_demo_mode', site_url('admin/page404') );
                    redirect( $url );
                }
            });
            
            // Start Route
            $Routes->start();
        }
    }

	// --------------------------------------------------------------------

    /**
     * Index
     *
     * @return void
     */
	public function index()
	{                
        Polatan::set_title(sprintf(__('Dashboard &mdash; %s'), get('signature')));
        if ($this->events->has_action('do_dashboard_home')) :
            $this->events->do_action('do_dashboard_home');
        else :
            $this->events->add_filter( 'fill_content', function() {
                return $this->load->admin_view( 'partials/home', null, true );
            });
        endif;
        
        $this->polatan->output();
	}

    // --------------------------------------------------------------------

    /**
     * page404 controller
     * [New Permission Ready]
     *
     * @access public
     */
    public function page404()
    {        
        Polatan::set_title(sprintf(__('404 &mdash; %s'), get('signature')));
        
        $this->events->add_filter( 'fill_content', function() {
            return $this->load->admin_view( 'partials/error_404', null, true );
        });
        $this->polatan->output();
    }

    // --------------------------------------------------------------------

    /**
     * Options Management ocntroller
     * [New Permission Ready]
     *
     * @access public
     */
    public function options($mode = 'list', $app = 'system')
    {
        if (in_array($mode, array( 'save', 'merge' ))) 
        {
            // Can user edit options ?
            User::control('edit.options');

            if ($this->input->post('gui_saver_expiration_time') > gmt_to_local(time(), 'UTC')) 
            {
                $this->events->do_action('do_save_options', $app);

                // loping post value
                foreach ($_POST as $key => $value) {
                    if (! in_array($key, array( 'gui_saver_ref', 'gui_saver_expiration_time' ))) {
                        $this->options_model->set(
                            $key, 
                            $this->input->post($key),
                            $app
                        );
                    }
                };

                $ref = @$_SERVER[ 'HTTP_REFERER' ] === null ? $this->input->post('gui_saver_ref') : $_SERVER[ 'HTTP_REFERER' ];
                $hasQuery = strpos( $ref, '?' );
                redirect( $ref . ( $hasQuery === false ? '?' : '&' ) . 'notice=option-saved');
            }
        } 
        elseif (in_array($mode, array( 'save_user_meta', 'merge_user_meta' ))) 
        {
            User::control('edit.profile');

            if ($this->input->post('gui_saver_expiration_time') >  gmt_to_local(time(), 'UTC')) 
            {
                $content = array();
                // loping post value
                foreach ($_POST as $key => $value) 
                {
                    if (! in_array($key, array( 'gui_saver_option_namespace', 'gui_saver_ref', 'gui_saver_expiration_time', 'gui_saver_use_namespace', 'user_id' ))) 
                    {
                        if ($mode == 'merge_user_meta' && is_array($value)) 
                        {
                            $options = $this->aauth->get_user_var($key);
                            $options = array_merge(force_array($options), $value);
                        }

                        // save only when it's not an array
                        if (! is_array($_POST[ $key ])) {
                            if ($this->input->post('gui_saver_use_namespace') === 'true') {
                                $content[ $key ] = ($mode == 'merge') ? $options : $this->input->post($key);
                            } 
                            else {
                                if ($mode == 'merge_user_meta' && is_array($value)) {
                                    $this->aauth->set_user_var($key, $options, $this->input->post('user_id'));
                                } else {
                                    $this->aauth->set_user_var($key, $this->input->post($key), $this->input->post('user_id'));
                                }
                            }
                        } 
                        else {
                            if ($this->input->post('gui_saver_use_namespace') === 'true') {
                                $content[ $key ] = ($mode == 'merge') ? $options : xss_clean($_POST[ $key ]);
                            } 
                            else {
                                if ($mode == 'merge_user_meta' && is_array($value)) {
                                    $this->aauth->set_user_var($key, $options, $this->input->post('user_id'));
                                } else {
                                    $this->aauth->set_user_var($key, xss_clean($_POST[ $key ]), $this->input->post('user_id'));
                                }
                            }
                        }
                    }
                }
            }
        }
        elseif (in_array($mode, array('ajax'))) {
            // loping post value
            foreach ($_POST as $key => $value) {
                $this->options_model->set(
                    $key, 
                    $this->input->post($key)
                );
            };
        }
        else {
            redirect(site_url('admin/page404'));
        }
    }

    // --------------------------------------------------------------------
    
    /**
     * Addons
     *
     * @param string $page
     * @param [type] $arg2
     * @param [type] $arg3
     * @param [type] $arg4
     * @param [type] $arg5
     * @return void
     */
    public function addons($page = 'list', $arg2 = null, $arg3 = null, $arg4 = null, $arg5 = null)
    {        
        switch ($page) {
            case "install_zip":
                // Can user access.addons ?
                User::control('install.addons');
    
                if (isset($_FILES[ 'extension_zip' ])) 
                {
                    $notice = MY_Addon::install('extension_zip');

                    // it means that addon has been installed
                    if (is_array($notice)) 
                    {
                        // Introducing Migrate
                        if (@$notice[ 'msg' ] == 'addon-updated-migrate-required') 
                        {
                            redirect(array( 'admin', 'addons', 'migrate', @$notice[ 'namespace' ], @$notice[ 'from' ] ));
                        } 
                        else {
                            if (! isset($notice[ 'extra' ])) { 
                                $this->options_model->set(
                                    'migration_' . @$notice[ 'namespace' ], 
                                    @$notice[ 'from' ], 
                                    @$notice[ 'namespace' ]);
                            };
                            redirect(array( 'admin', 'addons', 'list?highlight=' . @$notice[ 'namespace' ] . '&notice=' . $notice[ 'msg' ] . (isset($notice[ 'extra' ]) ? '&extra=' . $notice[ 'extra' ] : '') . '#addon-' . $notice[ 'namespace' ] ));
                        }
                    } 
    
                    $this->notice->push_notice_array($notice);
                }
    
                Polatan::set_title(sprintf(__('Addons List &mdash; %s'), get('signature')));
                $this->load->admin_view( 'addons/list' );
                break;

            case "enable":
                // Can user access.addons ?
                User::control('toggle.addons');
    
                MY_Addon::enable($arg2);
                MY_Addon::init('unique', $arg2);
                $this->events->do_action('do_enable_addon', $arg2, $arg3);
                
                redirect(array( 'admin', 'addons?notice=addon-enabled' ));
                break;

            case "disable":
                // Can user access.addons ?
                User::control('toggle.addons');
    
                MY_Addon::disable($arg2);
                $this->events->do_action('do_disable_addon', $arg2);
    
                redirect(array( 'admin', 'addons?notice=addon-disabled' ));
                break;

            case "remove":
                // Can user access.addons ?
                User::control('delete.addons');
    
                MY_Addon::init('unique', $arg2);
                $this->events->do_action('do_remove_addon', $arg2, $arg3);
                MY_Addon::remove($arg2);
    
                redirect(array( 'admin', 'addons?notice=addon-removed' ));
                break;
                
            case "extract":
                // Can user access.addons ?
                User::control('extract.addons');
    
                MY_Addon::extract($arg2);
                $this->events->do_action('do_extract_addon', $arg2);
                break;

            case "migrate":
                // Can user access.addons ?
                User::control('update.addons');

                global $Options;
                if ( $arg3 === null ) {
                    $arg3 = riake('migration_' . $arg2, $Options, '1.0');
                }
    
                $addon = MY_Addon::get($arg2);
                $migrate_file = ADDONSPATH . $addon[ 'application' ][ 'namespace' ] . '/migrate.php';
    
                if (! $addon) {
                    redirect(array( 'admin', 'addon-not-found' ));
                }
    
                $data['migrate_file'] = $migrate_file;
                $data['migrate_data'] = json_encode( array_keys( MY_Addon::migration_files( 
                    $addon[ 'application'][ 'namespace' ], 
                    $arg3, 
                    $addon[ 'application'][ 'version' ] 
                ) ) );
                $data['addon'] = $addon;
    
                Polatan::set_title(sprintf(__('Migration &mdash; %s'), get('signature')));
                $this->load->admin_view( 'addons/migrate', $data);
                break;

            case "exec":
                // Can user access.addons ?
                User::control('install.addons');
    
                $addon = MY_Addon::get($arg2);
                
                ob_start();
                $migration_array = include_once(ADDONSPATH . $addon[ 'application' ][ 'namespace' ] . '/migrate.php');
    
                // If currrent migration version exists
                if (@ $migration_array[ $arg4 ]) 
                {
                    // if is file path, it's included
                    if (is_string($migration_array[ $arg4 ]) && is_file($migration_array[ $arg4 ])) 
                    {
                        // we asume this file exists
                        $result = @include_once($migration_array[ $arg4 ]);
                        if ( $result === false ) {
                            return;
                        }
                    } 
                    // if it's callable, it's called
                    elseif (is_callable($migration_array[ $arg4 ])) {
                        $function = $migration_array[ $arg4 ];
                        $function($addon);
                    } 
                    else {
                        $content = false;
                    }
    
                    // When migrate is done the last version key is saved as previous migration version
                    // Next migration will start from here
                    $this->options_model->set( 
                        'migration_' . $addon[ 'application' ][ 'namespace' ], 
                        $arg4,
                        $addon[ 'application' ][ 'namespace' ]);
                }
    
                // Handling error
                $content = ob_get_clean();
    
                // If not error occured
                if (empty($content)) 
                {
                    echo json_encode(array(
                        'status'  => 'success',
                        'message' => __('Migration done.')
                    ));
                } 
                else { 
                    if ($content === false) 
                    {
                        echo json_encode(array(
                            'status'  => 'failed',
                            'message' => sprintf(__('File not found or incorrect executable provided.'))
                        ));
                    } 
                    else {
                        echo json_encode(array(
                            'status'  => 'failed',
                            'message' => sprintf(__('An error occured'))
                        ));
                    }
                }
                break;

            default:
                // Can user access.addons ?
                User::control('read.addons');

                Polatan::set_title(sprintf(__('Addons List &mdash; %s'), get('signature')));
                $this->load->admin_view( 'addons/list' );
                break;

        }
    }

    // --------------------------------------------------------------------
    
    /**
     * Appearance
     *
     * @param string $page
     * @param [type] $arg2
     * @param [type] $arg3
     * @param [type] $arg4
     * @param [type] $arg5
     * @return void
     */
    public function appearance($page = 'list', $arg2 = null, $arg3 = null, $arg4 = null, $arg5 = null)
    {   
        Theme::load( SITEPATH );  

        switch ($page) {
            case 'install_zip':
                // Can user access.themes ?
                User::control('install.themes');
    
                if (isset($_FILES[ 'extension_zip' ])) 
                {
                    $notice = Theme::install('extension_zip');
                    // it means that addon has been installed
                    if (is_array($notice)) 
                    {
                        redirect(array( 'admin', 'appearance', 'list?highlight=' . @$notice[ 'namespace' ] . '&notice=' . $notice[ 'msg' ] . '#theme-' . $notice[ 'namespace' ] ));
                    } 
    
                    $this->notice->push_notice_array($notice);
                }
                
                Polatan::set_title(sprintf(__('Theme List &mdash; %s'), get('signature')));
    
                $this->load->admin_view( 'appearance/list' );
                break;
            
            case 'enable':
                // Can user access.themes ?
                User::control('toggle.themes');
    
                Theme::enable($arg2);
    
                redirect(array( 'admin', 'appearance?notice=theme-enabled') );
                break;

            case 'remove':
                // Can user access.themes ?
                User::control('delete.themes');
    
                Theme::remove($arg2);
    
                redirect(array( 'admin', 'appearance?notice=theme-removed' ));
                break;

            case 'extract':
                // Can user access.themes ?
                User::control('extract.themes');
    
                Theme::extract($arg2);
                break;
            
            default:
                // Can user access.themes ?
                User::control('read.themes');
                
                Polatan::set_title(sprintf(__('Theme List &mdash; %s'), get('signature')));
                
                $this->load->admin_view( 'appearance/list');
                break;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Load Setting Page
     * [New Permission Ready]
     * @return void
    **/
    public function settings($page = 'home')
    {
        // Can user access settings ?
        User::control('create.options');
        User::control('read.options');

        switch ($page) {
            case 'preferences':
                Polatan::set_title(sprintf(__('Preferences &mdash; %s'), get('signature')));
                $this->load->admin_view( 'settings/preferences');
                break;
            
            default:
                Polatan::set_title(sprintf(__('Settings &mdash; %s'), get('signature')));
                $this->load->admin_view( 'settings/index' );
                break;
        }
    }

    // --------------------------------------------------------------------

    /**
     * About controller
     * [New Permission Ready]
     *
     * @access public
     */
    public function about($page = 'home',  $version = null)
    {
        switch ($page) {
            case 'core':
                Polatan::set_title(sprintf(__('Updating... &mdash; %s'), get('signature')));
                $data['release'] = $version;
                $data['update'] = $this->update_model->get($version);
                $this->load->admin_view( 'about/update', $data );
                break;

            case 'download':
                echo json_encode($this->update_model->install(1, $version));
                break;

            case 'extract':
                echo json_encode($this->update_model->install(2));
                break;

            case 'install':
                echo json_encode($this->update_model->install(3));
                break;

            case 'updated':
                echo json_encode($this->update_model->install(4));
                break;
            
            default:
                $this->load->library('markdown');
                Polatan::set_title(sprintf(__('About &mdash; %s'), get('signature')));

                // Can user access addons ?
                $data['check'] = (! User::is_allowed('manage.core') ) ? false : $this->update_model->check();
                $this->load->admin_view( 'about/index', $data );
                break;
        }
    }
}
