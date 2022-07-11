<?php



if (\version_compare(\PHP_VERSION, '5.3.0', '>=')) {
	require __DIR__ . '/Modern.php';
	function puc_parsedown(){
		return \RWP\Vendor\PUC\Parsedown\Modern::instance();
	}
} else {
	require __DIR__ . '/Legacy.php';

	function puc_parsedown(){
		return \RWP\Vendor\PUC\Parsedown\Legacy::instance();
	}
}
