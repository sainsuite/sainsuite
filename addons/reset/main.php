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
class Resets_Addons extends MY_Addon
{
    public function __construct()
    {
        parent::__construct();
        
        $this->lang->load_lines(dirname(__FILE__) . '/language/*.php');

        $this->events->add_action('do_after_db_setup', [ $this, 'enable_addon' ] );

		$this->events->add_action( 'do_dashboard_footer', function () {
			$this->addon_view( 'reset', 'script' );
		});
    }

    public function enable_addon()
    {
        MY_Addon::enable('reset');
    }
}
new Resets_Addons;