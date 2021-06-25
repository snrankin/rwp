<?php

// location should be one of (public|admin) otherwise is will default to global and be registered everywhere
$assets = [
	'scripts' => rwp_collection([
		'modernizr' => [
			'handle'   => 'modernizr',
			'deps'     => [],
			'footer'   => false,
			'location' => 'global',
		],
		'select2' => [
			'handle'   => 'select2',
			'location' => 'select2',
			'footer'   => true,
		],
		'tiny-slider' => [
			'handle'   => 'tiny-slider',
			'location' => 'tiny-slider',
			'footer'   => true,
		],
		'fancybox' => [
			'handle'   => 'fancybox',
			'location' => 'fancybox',
			'deps'     => ['jquery'],
			'footer'   => true,
		],
		'lazysizes' => [
			'handle'   => 'lazysizes',
			'location' => 'lazysizes',
			'footer'   => true,
		],
		'bootstrap' => [
			'handle'   => 'bootstrap',
			'location' => 'bootstrap',
			'footer'   => true,
		],
	]),

	'styles' => rwp_collection([
		'admin' => [
			'handle'   => 'admin',
			'location' => 'admin',
		],
		'editor' => [
			'handle'   => 'editor',
			'location' => 'editor',
		],
		'acf' => [
			'handle'   => 'acf',
			'location' => 'acf',
		],
		'gravity-forms' => [
			'handle'   => 'gravity-forms',
			'location' => 'gravity-forms',
		],
		'select2' => [
			'handle'   => 'select2',
			'location' => 'select2',
		],
		'tiny-slider' => [
			'handle'   => 'tiny-slider',
			'location' => 'tiny-slider',
		],
		'fancybox' => [
			'handle'   => 'fancybox',
			'location' => 'fancybox',
		],
		'lazysizes' => [
			'handle'   => 'lazysizes',
			'location' => 'lazysizes',
		],
		'font-awesome' => [
			'handle'   => 'font-awesome',
			'location' => 'font-awesome',
		],
		'bootstrap-icons' => [
			'handle'   => 'bootstrap-icons',
			'location' => 'bootstrap-icons',
		],
	]),
];


return rwp_collection($assets);
