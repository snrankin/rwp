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
export * from '@popperjs/core';
import { Dropdown } from 'bootstrap';
export * from 'bootstrap';

(function () {
	const CLASS_NAME = 'has-child-dropdown-show';
	Dropdown.prototype.toggle = (function (_orginal) {
		return function () {
			document.querySelectorAll('.' + CLASS_NAME).forEach(function (e) {
				e.classList.remove(CLASS_NAME);
			});
			let dd = this._element.closest('.dropdown').parentNode.closest('.dropdown');
			for (; dd && dd !== document; dd = dd.parentNode.closest('.dropdown')) {
				dd.classList.add(CLASS_NAME);
			}
			return _orginal.call(this);
		};
	})(Dropdown.prototype.toggle);

	document.querySelectorAll('.dropdown').forEach(function (dd) {
		dd.addEventListener('hide.bs.dropdown', function (e) {
			if (this.classList.contains(CLASS_NAME)) {
				this.classList.remove(CLASS_NAME);
				e.preventDefault();
			}
			e.stopPropagation(); // do not need pop in multi level mode
		});
	});

	// for hover
	document.querySelectorAll('.dropdown-hover, .dropdown-hover-all .dropdown').forEach(function (dd) {
		dd.addEventListener('mouseenter', function (e) {
			let toggle = e.target.querySelector(':scope>[data-bs-toggle="dropdown"]');
			if (!toggle.classList.contains('show')) {
				Dropdown.getOrCreateInstance(toggle).toggle();
				dd.classList.add(CLASS_NAME);
				Dropdown.clearMenus();
			}
		});
		dd.addEventListener('mouseleave', function (e) {
			let toggle = e.target.querySelector(':scope>[data-bs-toggle="dropdown"]');
			if (toggle.classList.contains('show')) {
				Dropdown.getOrCreateInstance(toggle).toggle();
			}
		});
	});
});
