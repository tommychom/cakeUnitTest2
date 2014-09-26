<?php

/** 
 * Config for local
 * 
 */

$docRoot = realpath(ROOT . DS . '..' . DS . '..') . DS;
$shared = $docRoot . 'shared' . DS;
$configShared = $shared . 'config' . DS;


$config = array(
	'debug' => 3,
	'login' => array(
		'max_attemp' => 3
	),
	'Auth' => array(
		'loginRedirect' => array(
			'controller' => 'users',
			'action' => 'dashboard',
			'admin' => true,
			'prefix' => 'admin'
		),
		'logoutRedirect' => array(
			'controller' => 'users',
			'action' => 'login',
			'admin' => false
		),
		'loginAction' => array(
			'controller' => 'users',
			'action' => 'login',
			'admin' => false
		),
		'flash' => array(
			'element' => 'alert',
			'key' => 'auth',
			'params' => array(
				'plugin' => 'BoostCake',
				'class' => 'alert-error'
			)
		)
	),
	'smtp' => array(
		'from' => array('noreply@pmi-gap.aws.awareidc.com' => 'GAP Content Management System'),
		'host' => '202.8.79.130',
		'port' => 25,
		'timeout' => 30
	)
);

/**
 * Include from shared directory
 */
if (is_dir($configShared)) {
	if ($handle = opendir($configShared)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != '.' && $entry != '..' && strpos($entry, '.php') !== false) {
				$file = basename($entry, '.php');
				include $configShared . $entry;
				$config = array_merge($config, ${$file});
			}
		}
	}
}
