<?php

namespace RWP\Vendor\PUC;

require \dirname(__FILE__) . '/Puc/v4p11/Factory.php';
require \dirname(__FILE__) . '/Puc/v4/Factory.php';

//Register classes defined in this version with the factory.
foreach (array(
	'PluginUpdateChecker'     => __NAMESPACE__ . '\\v4p11\\Plugin\\UpdateChecker',
	'ThemeUpdateChecker'      => __NAMESPACE__ . '\\v4p11\\Theme\\UpdateChecker',
	'Vcs_PluginUpdateChecker' => __NAMESPACE__ . '\\v4p11\\Vcs\\PluginUpdateChecker',
	'Vcs_ThemeUpdateChecker'  => __NAMESPACE__ . '\\v4p11\\Vcs\\ThemeUpdateChecker',
	'GitHub'                  => __NAMESPACE__ . '\\v4p11\\Vcs\\GitHub',
	'BitBucket'               => __NAMESPACE__ . '\\v4p11\\Vcs\\BitBucket',
	'GitLab'                  => __NAMESPACE__ . '\\v4p11\\Vcs\\GitLab'
) as $pucGeneralClass => $pucVersionedClass) {
    v4\Factory::addVersion($pucGeneralClass, $pucVersionedClass, '4.11');
    //Also add it to the minor-version factory in case the major-version factory
    //was already defined by another, older version of the update checker.
    v4p11\Factory::addVersion($pucGeneralClass, $pucVersionedClass, '4.11');
}
