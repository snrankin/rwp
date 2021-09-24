/* eslint-disable @wordpress/no-global-event-listener */
/**
 * ============================================================================
 * helpers
 *
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */

const _ = require('lodash');

import { actual } from 'actual';
import { verge } from 'verge';

export function camelCase(str) {
	return `${str.charAt(0).toLowerCase()}${str
		.replace(/[\W_]/g, '|')
		.split('|')
		.map((part) => `${part.charAt(0).toUpperCase()}${part.slice(1)}`)
		.join('')
		.slice(1)}`;
}
export function changeTag(original, tag) {
	const replacement = document.createElement(tag);

	// Grab all of the original's attributes, and pass them to the replacement
	for (let i = 0, l = original.attributes.length; i < l; ++i) {
		const nodeName = original.attributes.item(i).nodeName;
		const nodeValue = original.attributes.item(i).nodeValue;

		replacement.setAttribute(nodeName, nodeValue);
	}

	// Persist contents
	replacement.innerHTML = original.innerHTML;

	// Switch!
	original.parentNode.replaceChild(replacement, original);

	return original;
}
export function toggleFocus() {
	if (event.type === 'focus' || event.type === 'blur') {
		let self = this;

		if (!_.isUndefined(self)) {
			const elementClasses = self.classList;

			if (!_.isNil(elementClasses)) {
				// Move up through the ancestors of the current link until we hit .nav-menu.
				while (!elementClasses.contains('nav-menu')) {
					// On li elements toggle the class .focus.
					if ('li' === self.tagName.toLowerCase()) {
						self.classList.toggle('focus');
					}
					self = self.parentNode;
				}
			}
		}
	}

	if (event.type === 'touchstart') {
		const menuItem = this.parentNode;
		event.preventDefault();
		for (const link of menuItem.parentNode.children) {
			if (menuItem !== link) {
				link.classList.remove('focus');
			}
		}
		menuItem.classList.toggle('focus');
	}
}

export function screenSize(prop) {
	const size = {
		width: actual.actual('width', 'px'),
		height: actual.actual('height', 'px'),
	};

	window.resize = () => {
		_.assign(
			{
				width: actual.actual('width', 'px'),
				height: actual.actual('height', 'px'),
			},
			size
		);
	};

	if (!_.isNil(prop)) {
		return size[prop];
	}

	_.assign(
		{
			width: actual.actual('width', 'px'),
			height: actual.actual('height', 'px'),
		},
		rwp.screen
	);

	return size;
}
export function skipLink() {
	const isIe = /(trident|msie)/i.test(navigator.userAgent);
	if (isIe && document.getElementById && window.addEventListener) {
		window.addEventListener(
			'hashchange',
			function () {
				const id = location.hash.substring(1);

				if (!/^[A-z0-9_-]+$/.test(id)) {
					return;
				}

				const element = document.getElementById(id);

				if (element) {
					if (
						!/^(?:a|select|input|button|textarea)$/i.test(
							element.tagName
						)
					) {
						element.tabIndex = -1;
					}

					element.scrollIntoView({
						behavior: 'smooth',
					});

					element.focus();
				}
			},
			false
		);
	}
}
export function toggleNav(buttonId) {
	const button = document.querySelector(buttonId);

	// Return early if the button don't exist.
	if ('undefined' === typeof button) {
		return;
	}
	let buttonTarget = button.getAttribute('data-target');

	buttonTarget = buttonTarget.replace('#', '');

	const siteNavigation = document.getElementById(buttonTarget);

	// Return early if the navigation don't exist.
	if (!siteNavigation) {
		return;
	}

	const menu = siteNavigation.getElementsByTagName('ul')[0];

	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.

	// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
	document.addEventListener('click', function (event) {
		const isClickInside = siteNavigation.contains(event.target);

		if (!isClickInside) {
			siteNavigation.classList.remove('toggled');
			$('#' + buttonTarget).collapse('hide');
		}
	});

	// Get all the link elements within the menu.
	const links = menu.getElementsByTagName('a');

	// Get all the link elements with children within the menu.
	// eslint-disable-next-line
	const linksWithChildren = menu.querySelectorAll('.has-children > a');

	// Toggle focus each time a menu link is focused or blurred.
	for (const link of links) {
		link.addEventListener('focus', this.toggleFocus, true);
		link.addEventListener('blur', this.toggleFocus, true);
	}

	// Toggle focus each time a menu link with children receive a touch event.
	for (const link of linksWithChildren) {
		link.addEventListener('touchstart', this.toggleFocus, false);
	}
}
export function getTallest(el) {
	const matches = document.querySelectorAll(el);
	if (matches.length > 1) {
		const heights = _.map(matches, function (elem) {
			return this.rectangle(elem).height;
		});

		return Math.max.apply(null, heights);
	}
	return false;
}
export function matchHeights(el) {
	const matches = document.querySelectorAll(el);
	if (matches.length > 1) {
		const minHeight = this.getTallest(el);

		if (false !== minHeight) {
			_.map(matches, function (elem) {
				elem.style.minHeight = minHeight;
			});
		}

		window.resize = () => {
			this.matchHeights(el);
		};
	}
}
export function bsAtts() {
	const bsColors = {
		primary: '',
		secondary: '',
		tertiary: '',
		info: '',
		success: '',
		warning: '',
		danger: '',
		light: '',
		dark: '',
		blue: '',
		indigo: '',
		purple: '',
		pink: '',
		red: '',
		orange: '',
		yellow: '',
		green: '',
		teal: '',
		cyan: '',
		white: '',
		black: '',
		'gray-100': '',
		'gray-200': '',
		'gray-300': '',
		'gray-400': '',
		'gray-500': '',
		'gray-600': '',
		'gray-700': '',
		'gray-800': '',
		'gray-900': '',
	};

	const computedColors = {};

	for (let [key, value] of Object.entries(bsColors)) {
		const r = document.querySelector(':root');

		// Get the styles (properties and values) for the root
		const rs = getComputedStyle(r);
		// Alert the value of the --blue variable
		value = rs.getPropertyValue(`--bs-${key}`);
		value = value.trim();
		if ('' !== value) {
			computedColors[key] = value;
		}
	}

	return {
		colors: computedColors,
	};
}
export function logCustomProperties() {
	const isSameDomain = (styleSheet) => {
		// Internal style blocks won't have an href value
		if (!styleSheet.href) {
			return true;
		}

		return styleSheet.href.indexOf(window.location.origin) === 0;
	};

	const isStyleRule = (rule) => rule.type === 1;

	const getCSSCustomPropIndex = () =>
		// styleSheets is array-like, so we convert it to an array.
		// Filter out any stylesheets not on this domain
		[...document.styleSheets].filter(isSameDomain).reduce(
			(finalArr, sheet) =>
				finalArr.concat(
					// cssRules is array-like, so we convert it to an array
					[...sheet.cssRules]
						.filter(isStyleRule)
						.reduce((propValArr, rule) => {
							const props = [...rule.style]
								.map((propName) => [
									propName.trim(),
									rule.style
										.getPropertyValue(propName)
										.trim(),
								])
								// Discard any props that don't start with "--". Custom props are required to.
								.filter(
									([propName]) => propName.indexOf('--') === 0
								);

							return [...propValArr, ...props];
						}, [])
				),
			[]
		);

	const cssCustomPropIndex = getCSSCustomPropIndex();

	return cssCustomPropIndex;
}
