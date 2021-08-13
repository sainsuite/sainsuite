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

use Pecee\SimpleRouter\SimpleRouter as Route;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class Api extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		// check if api key is correct
		// $api = $this->db->where( 'key', $this->input->server( 'HTTP_X_API_KEY' ) )
		// 	->get( 'restapi_keys' )
		// 	->result_array();

		// if( ! $api ) {
		// 	return response()->httpCode( 403 )->json([
		// 		'status' => 'failed',
		// 		'message' => __( 'Unable to authenticate the request. It seems like the API key provided is not valid.' )
		// 	]);
		// } 
		// else {
		// 	// check whether the user is connected or not
		// 	if( User::id() === 0 ) {
		// 		// if user is not connected, we're using the API user id if it's provider
		// 		if( $api[0][ 'user' ] != '0' ) {
		// 			// login using using provide API
		// 			$this->auth->login_fast( $api[0][ 'user' ] );
		// 		} 
		// 		else { 
		// 			// the API is being accessed from external app, and the user is using system API
		// 			return response()->httpCode( 403 )->json([
		// 				'status' =>	'failed',
		// 				'message' => 'core_keys_access_denied'
		// 			]);
		// 		}
		// 	}
		// }
	}

	public function login()
	{
		if ($_POST) {
			# code...
    		$response = array();
			$this->aauth->login(
				$this->input->post( 'email' ),
				$this->input->post( 'pass'),
				$this->input->post( 'keep_connected' ) != null ? true : false
			);
		
			if (User::is_loggedin()) {

				$result = (array) User::get();
				$array['value'] = 1;
				$array['message'] = "Login Berhasil";
				$array['picture'] = User::get_user_image_url($result['id']);
				$key = User::get_user_group($result['id']);
				$array['group'] = $key->name;

				$response = array_merge($array, $result);
				return response()->json($response);
			} 
			else {
				# code...
				$response['value']   = 0;
				$response['message'] = "Login Gagal";
				return response()->json($response);
			}   
		}
	}
	
	/**
	* Index for API
	* @return void
	*/
    public function _remap($page, $params = array())
	{
		global $Routes;
		
        if (method_exists($this, $page)) {
            return call_user_func_array(array( $this, $page ), $params);
        } 
        else {
			$Routes = new Route();
			
			$Routes->group([ 
				'prefix' => substr( request()->getHeader( 'script-name' ), 0, -10 ) . '/api' 
			], function() use ( $page, $Routes ) 
			{
				$addons = MY_Addon::get();
					
				foreach( force_array($addons) as $namespace => $addon )  
				{
					if( ! MY_Addon::is_active( $namespace ) ) {
						continue;
					}

					if( is_dir( $dir = ADDONSPATH . $namespace . '/api/' ) ) {
						foreach( glob( $dir . "*.php") as $filename) {
							include_once( $filename );
						}
					}

					if( is_file( ADDONSPATH . $namespace . '/api.php' ) ) {
						include_once( ADDONSPATH . $namespace . '/api.php' );
					}
				}
			});

			$Routes->error(function($request, \Exception $exception) {
				if($exception instanceof NotFoundHttpException && $exception->getCode() == 404) {
					return response()->httpCode( 404 )->json([
						'status'  	=>   'failed',
						'message' 	=>   $exception->getMessage()
					], 404 );
				}
			});
			
			$Routes->start();    
		}
	}
}