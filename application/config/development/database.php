<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	   => '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '123',
	'database' => 'racik',
	'dbdriver' => 'mysqli',
	'dbprefix' => 'rp_',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => TRUE,
	'failover' => array(),
	'save_queries' => TRUE
);