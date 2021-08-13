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
    $Routes->get( '/{page_id?}', 'UsersHomeController@index' )->where([ 'page_id' => '[0-9]+' ]);
    $Routes->match([ 'get', 'post' ], 'add', 'UsersHomeController@add' );
    $Routes->match([ 'get', 'post' ], 'edit/{id}/{pages?}', 'UsersHomeController@edit' );
    $Routes->match([ 'get', 'post' ], 'delete/{id?}/{redirect?}', 'UsersHomeController@delete' );
});

$Routes->group(['prefix' => '/profile'], function () use ( $Routes ) {
    $Routes->match([ 'get', 'post' ], '/{page?}', 'UsersProfileController@index' );
});

$Routes->group(['prefix' => '/group'], function () use ( $Routes ) {
    $Routes->match([ 'get', 'post' ], '/', 'GroupsHomeController@index' );
    $Routes->match([ 'get', 'post' ], 'add', 'GroupsHomeController@add' );
    $Routes->match([ 'get', 'post' ], 'edit/{id}', 'GroupsHomeController@edit' );
    $Routes->match([ 'get', 'post' ], 'delete/{id?}', 'GroupsHomeController@delete' );
});
