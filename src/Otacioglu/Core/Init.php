<?php
/**
 * This is the Init file which will be loaded in all files.
 */

/**
 * Starts the session.
 */
session_start();

/**
 * Global configuration settings.
 */
$GLOBALS['config'] = array(
	'mysql'    => array(
		'host'     => '127.0.0.1',
		'username' => 'root',
		'password' => '',
		'db'       => 'oop'
	),
	'remember' => array(
		'cookie_name'   => 'hash',
		'cookie_expiry' => 604800
	),
	'session'  => array(
		'session_name' => 'user',
		'token_name' => 'token'
	)
);

/**
 * Autoload classes.
 */
spl_autoload_register(function($class) {
	require_once 'class/' . $class . '.php';
});

/**
 * Load functions.
 */
require_once 'Functions/Sanitize.php';

if(Cookie::exist(Config::get('remember/cookie_name')) && !Session::exist(Config::get('session/session_name'))) {
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->get('users_session', array('hash', '=', $hash));

	if($hashCheck->count()) {
		$user = new User($hashCheck->find(1)->user_id);
		$user->login();
	}
}