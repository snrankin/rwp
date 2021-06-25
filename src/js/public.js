/**
 * ============================================================================
 * plugin
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

// import local dependencies
import Router from './util/Router';
import common from './routes/common';

/** Populate Router instance with DOM routes */
const routes = new Router({
	common,
});

const rwp = window.rwp || {}; //eslint-ignore-line

// Load Events
jQuery(document).ready(() => routes.loadEvents());
