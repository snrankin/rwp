/**
 * ============================================================================
 * bootstrap
 *
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */
import domready from 'domready';
import { /* webpackMode: "eager" */ /* webpackExports: ["Dropdown"] */ initDropDown } from './bootstrap/dropdown';

import(/* webpackMode: "eager" */ /* webpackExports: ["Button, Collapse, Offcanvas, Popover, ScrollSpy, Tab, Tooltip"] */ 'bootstrap');
domready(initDropDown);
// Init Tooltips
domready(function () {
	const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
	tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl);
	});
});
