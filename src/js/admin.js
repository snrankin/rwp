/**
 * ============================================================================
 * admin
 *
 * @package
 * @since     1.0.0
 * @version   1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */

// import local dependencies
import Router from './util/Router';
import common from './public/common';

/** Populate Router instance with DOM routes */
const routes = new Router({
	// All pages
	common,
});

// Load Events
routes.loadEvents();
