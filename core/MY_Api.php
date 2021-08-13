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
use Pecee\Handlers\IExceptionHandler;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;

class MY_Api extends CI_Model
{
    public function __construct()
    {
        $this->load->helper( 'request_helper' );
    }

    /**
     * Get Parameter
     * @param string
     * @param string/null default value
     * @return string/null/object
     */
    public function get( $param, $default = null) 
    {
        return input( $param, $default, 'get' );
    }

    /**
     * Post Value
     * @param string
     * @param string default value
     * @return POST value
     */
    public function post( $param, $default = null ) 
    {
        $request_body = file_get_contents('php://input');
        $data = json_decode( $request_body, true );

        if ( @$data[ $param ] ) {
            return $data[ $param ];
        } else {
            return $this->input->post( $param ) ? $this->input->post( $param ) : $default;
        }
    }

    /**
     * Put value
     * @param string
     * @param string default value
     * @return string/object PUT value
     */
    public function put( $param, $default = null )
    {
        $request_body = file_get_contents('php://input');
        $data = json_decode( $request_body, true );
        return @$data[ $param ] ? @$data[ $param ] : $default;
    }

    /**
     * Failed
     * @return json failed response
     */
    public function __failed()
    {
        return response()->httpCode( 403 )->json([
            'status'    =>  'failed',
            'message'   =>  'the request has failed'
        ]);
    }

    /**
     * Success
     * @return json success response
     */
    public function __success()
    {
        return response()->httpCode( 200 )->json([
            'status'    =>  'success',
            'message'   =>  'the request has succeeded'
        ]);
    }

    /**
     * Empty
     * @return json empty response
     */
    public function __empty()
    {
        return response()->httpCode( 200 )->json([]);
    }

    /**
     * Empty
     * @return json empty response
     */
    public function __404()
    {
        return response()->httpCode( 404 )->json([
            'status'    =>  '404',
            'message'   =>  'not found'
        ]);
    }

    /**
     * Backward compatibility
     * Response
     * @return response
     */
    public function response( $data, $code = 200 )
    {
        return response()->httpCode( $code )->json( $data );
    }
}