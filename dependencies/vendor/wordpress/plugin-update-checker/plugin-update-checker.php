<?php

use \RWP\Vendor\PUC\v4p11\Vcs\PluginUpdateChecker;
use \RWP\Vendor\PUC\v4p11\Vcs\ThemeUpdateChecker;
use \RWP\Vendor\PUC\v4p11\Vcs\BaseChecker;

/**
 * Plugin Update Checker Library 4.11
 * http://w-shadow.com/
 *
 * Copyright 2021 Janis Elsts
 * Released under the MIT license. See license.txt for details.
 */
require \dirname(__FILE__) . '/load-v4p11.php';



/**
 * Create a new instance of the update checker.
 *
 * This method automatically detects if you're using it for a plugin or a theme and chooses
 * the appropriate implementation for your update source (JSON file, GitHub, BitBucket, etc).
 *
 * @see Puc_v4p11_UpdateChecker::__construct
 *
 * @param string $metadataUrl  The URL of the metadata file, a GitHub repository, or another supported update source.
 * @param string $fullPath     Full path to the main plugin file or to the theme directory.
 * @param string $slug         Custom slug. Defaults to the name of the main plugin file or the theme directory.
 * @param int    $checkPeriod  How often to check for updates (in hours).
 * @param string $optionName   Where to store book-keeping info about update checks.
 * @param string $muPluginFile The plugin filename relative to the mu-plugins directory.
 *
 * @return PluginUpdateChecker|ThemeUpdateChecker|BaseChecker
 */

function build_updater($metadataUrl, $fullPath, $slug = '', $checkPeriod = 12, $optionName = '', $muPluginFile = ''){
	return \RWP\Vendor\PUC\v4\Factory::buildUpdateChecker($metadataUrl, $fullPath, $slug, $checkPeriod, $optionName, $muPluginFile);
}
