<?php

/**
 * Plugin Update Checker Library 4.11
 * http://w-shadow.com/
 *
 * Copyright 2021 Janis Elsts
 * Released under the MIT license. See license.txt for details.
 */


if ( ! \defined( 'ABSPATH' ) ) {
    die( 'FU!' );
}

require \dirname(__FILE__) . '/includes/Autoloader.php';
new RWP\Vendor\PUC\Autoloader();
require \dirname(__FILE__) . '/includes/Factory.php';
//Register classes defined in this version with the factory.
$factory_classes = array(
	'Plugin_UpdateChecker'    => 'RWP\\Vendor\\PUC\\Plugin\\UpdateChecker',
	'Theme_UpdateChecker'     => 'RWP\\Vendor\\PUC\\Theme\\UpdateChecker',
	'Vcs_PluginUpdateChecker' => 'RWP\\Vendor\\PUC\\VCS\\PluginUpdateChecker',
	'Vcs_ThemeUpdateChecker'  => 'RWP\\Vendor\\PUC\\VCS\\ThemeUpdateChecker',
	'GitHubApi'               => 'RWP\\Vendor\\PUC\\VCS\\GitHubApi',
	'BitBucketApi'            => 'RWP\\Vendor\\PUC\\VCS\\BitBucketApi',
	'GitLabApi'               => 'RWP\\Vendor\\PUC\\VCS\\GitLabApi'
);
foreach ($factory_classes as $pucGeneralClass => $pucVersionedClass) {
    RWP\Vendor\PUC\Factory::addVersion($pucGeneralClass, $pucVersionedClass, '4.11');
}
