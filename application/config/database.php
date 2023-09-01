<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$username = "root";
$password = "password";
$table = 'db_penggajian';

// $username = "ngoding1_penjualan";
// $password = "Wxa%94Try&p,";
// $table = 'ngoding1_penjualan';

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => $username,
	'password' => $password,
	'database' => $table,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => TRUE,
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
