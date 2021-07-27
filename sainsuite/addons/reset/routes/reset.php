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
class Reset extends MY_Addon
{

    public function __construct()
    {
        parent::__construct();
    }
	
	/**
	 * Reset table
	 * @return void
	**/
	
	function index()
	{
		User::control('manage.core');

		if ( isset( $_GET[ 'reset-process' ] ) ) {
			unlink( APPPATH . '/config/database.php' );
			$this->load->dbforge();
			
			$this->dbforge->drop_database( $this->db->database );
			
			// doing log_user_out
			if ($this->aauth->logout() == null) {
				redirect( array( 'install' ) );
			}
		}
	}

}