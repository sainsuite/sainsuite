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

global $Routes;

$Routes->group(['prefix' => '/users'], function () use ( $Routes ) {
    $Routes->match([ 'get', 'post' ], '{group?}', 'usersApiController@index' );
    $Routes->match([ 'get', 'post' ], 'get/{id?}', 'usersApiController@get_user' );
});

$Routes->group(['prefix' => '/groups'], function () use ( $Routes ) {
    $Routes->match([ 'get', 'post' ], '/', 'groupsApiController@index' );
});