<?php

namespace RWP\Modules\Nav;

use RWP\Vendor\Illuminate\Support\Collection;
use RWP\Components\{NavWalker, Nav, PageWalker, CategoryWalker, Html};

if (!defined('ABSPATH')) {
	die();
}

if (is_admin()) {
	return;
}

if (!get_theme_support('rwp-nav-walker')) {
	return;
}
$options = get_theme_support('rwp-nav-walker')[0];


if (in_array('nav', $options)) {
	add_filter('wp_nav_menu_args', 'rwp_menu_args', 10, 1);
}

if (in_array('page', $options)) {
	add_filter('wp_page_menu_args', 'rwp_page_menu_args', 10, 1);
}
