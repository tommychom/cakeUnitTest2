<?php
$config = array(
	'leftMenu' => array(
		array(
			'title' => 'Global Content Management', 
			'url' => array(
				'controller' =>'books', 
				'action' => 'index', 
				'admin' => true
			), 
			'allow' => false, 
			'icon' => 'fa-globe'
		),
		array(
			'title' => 'Local Content Management',
			'allow' => true,
			'icon' => 'fa-flag',
			'callback' => 'createLocalMenu'
		),
		array(
			'title' => 'Version Management',
			'allow' => true,
			'icon' => 'fa-code-fork',
			'callback' => 'createVersionMenu'
		),
		array(
			'title' => 'User Management', 
			'url' => array(
				'controller' =>'users', 
				'action' => 'index', 
				'admin' => true
			), 
			'allow' => false, 
			'icon' => 'fa-users'
		),
		array(
			'title' => 'Log out', 
			'url' => array(
				'controller' => 'users', 
				'action' => 'logout', 
				'admin' => false
			), 
			'allow' => true, 
			'icon' => 'fa-sign-out'
		)
	)
);