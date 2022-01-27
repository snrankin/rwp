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
import { viewportW, viewportH, viewport, inViewport, inX, inY, scrollX, scrollY, mq, rectangle, aspect } from 'verge'; // eslint-disable-line

/**
 * Function for making strings camelCase
 *
 * @param {string} str The string to convert
 * @return {string} The converted string
 */
function camelCase(str) {
	return `${str.charAt(0).toLowerCase()}${str
		.replace(/[\W_]/g, '|')
		.split('|')
		.map((part) => `${part.charAt(0).toUpperCase()}${part.slice(1)}`)
		.join('')
		.slice(1)}`;
}

/**
 *	Change the tag of a node element
 *
 * @param  {Element}  original  The element to change
 * @param  {string}   tag        The new tag
 *
 * @return {Element} The updated element
 */
function changeTag(original, tag) {
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

/**
 * Adds focus class for better accessibility
 *
 */
function toggleFocus(el) {
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

/**
 * Get the screen size
 *
 * @param {string} prop
 * @return {Object|Number} The object containing the size infor or the requested property
 */
function screenSize(prop) {
	const size = {
		width: actual.actual('width', 'px'),
		height: actual.actual('height', 'px'),
	};

	window.addEventListener('resize', function () {
		_.assign(
			{
				width: actual.actual('width', 'px'),
				height: actual.actual('height', 'px'),
			},
			size
		);
	});

	if (!_.isNil(prop)) {
		return size[prop];
	}

	return size;
}

// URL updates and the element focus is maintained
// originally found via in Update 3 on http://www.learningjquery.com/2007/10/improved-animated-scrolling-script-for-same-page-links

// filter handling for a /dir/ OR /indexordefault.page
function filterPath(string) {
	return string
		.replace(/^\//, '')
		.replace(/(index|default).[a-zA-Z]{3,4}$/, '')
		.replace(/\/$/, '');
}

/**
 * Get hash value for any string
 *
 * @param {*} string the string to extract from
 * @return {*} the hash or false
 */
function getHash(string) {
	var index = string.indexOf('#');
	if (index !== -1) {
		return string.substring(index + 1);
	}
	return false;
}

/**
 * Check if a variable is empty
 *
 * @param {*} el The variable to check
 * @return {boolean} True if empty, false if not
 */
function isEmpty(el) {
	if (_.isNil(el)) {
		return true;
	} else if (el === '') {
		return true;
	} else if (el === null) {
		return true;
	} else if (el === false) {
		return true;
	} else if (_.isEmpty(el)) {
		return true;
	}
	return false;
}

function toggleNav(buttonId) {
	const button = document.querySelector(buttonId);

	// Return early if the button don't exist.
	if (isEmpty(button)) {
		return;
	}
	let buttonTarget = button.getAttribute('data-target');

	if (isEmpty(buttonTarget)) {
		buttonTarget = button.getAttribute('href');
	}

	if (isEmpty(buttonTarget)) {
		return;
	}

	buttonTarget = getHash(buttonTarget);

	const siteNavigation = document.getElementById(buttonTarget);

	// Return early if the navigation don't exist.
	if (isEmpty(siteNavigation)) {
		return;
	}

	const menu = siteNavigation.getElementsByTagName('ul')[0];

	// Get all the link elements within the menu.
	const links = menu.getElementsByTagName('a');

	// Get all the link elements with children within the menu.
	// eslint-disable-next-line
	const linksWithChildren = menu.querySelectorAll('.has-children > a');

	// Toggle focus each time a menu link is focused or blurred.
	for (const link of links) {
		link.addEventListener('focus', toggleFocus, true);
		link.addEventListener('blur', toggleFocus, true);
	}

	// Toggle focus each time a menu link with children receive a touch event.
	for (const link of linksWithChildren) {
		link.addEventListener('touchstart', toggleFocus, false);
	}
}

/**
 * Get tallest element
 *
 * @param {string} el
 * @return {number}
 */
function getTallest(el) {
	const matches = document.querySelectorAll(el);
	if (matches.length > 1) {
		const heights = _.map(matches, function (elem) {
			return rectangle(elem).height;
		});

		return Math.max.apply(null, heights);
	}
	return false;
}

/**
 * Make all elements match the tallest element
 *
 * @param {string} [elem='']
 * @param {*} [container=Document]
 */
function matchHeights(elem = '', container = Document) {
	const matches = container.querySelectorAll(elem);
	if (matches.length > 1) {
		const minHeight = getTallest(elem);

		if (false !== minHeight) {
			_.map(matches, function (elem) {
				elem.style.minHeight = minHeight;
			});
		}

		window.addEventListener('resize', function () {
			matchHeights(elem, container);
		});
	}
}

function bsAtts() {
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
function logCustomProperties() {
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
					[...sheet.cssRules].filter(isStyleRule).reduce((propValArr, rule) => {
						const props = [...rule.style]
							.map((propName) => [propName.trim(), rule.style.getPropertyValue(propName).trim()])
							// Discard any props that don't start with "--". Custom props are required to.
							.filter(([propName]) => propName.indexOf('--') === 0);

						return [...propValArr, ...props];
					}, [])
				),
			[]
		);

	const cssCustomPropIndex = getCSSCustomPropIndex();

	return cssCustomPropIndex;
}

export { camelCase, changeTag, getHash, toggleFocus, screenSize, isEmpty, toggleNav, getTallest, matchHeights, bsAtts, logCustomProperties, actual, viewportW, viewportH, viewport, inViewport, inX, inY, scrollX, scrollY, mq, rectangle, aspect };
