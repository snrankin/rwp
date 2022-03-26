/** ============================================================================
 * utils
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

import { isEmpty as empty, get, fromPairs, replace, map, isNil, chain, escape, assign } from 'lodash';
export { isArray, isString, isObject, isArrayLike, assign, filter, map, find, merge, reduce, reject, omit, get, has, defaultsDeep, forEach, each, replace, chain, escape } from 'lodash';
import { actual } from 'actual';
export { actual, as, is } from 'actual';
import { rectangle, mq } from 'verge';
export { viewportW, viewportH, viewport, inViewport, inX, inY, scrollX, scrollY, mq, rectangle, aspect } from 'verge';

/**
 * Check if a variable is empty
 *
 * @param {*} el The variable to check
 * @return {boolean} True if empty, false if not
 */
export function isEmpty(el) {
	if (isNil(el)) {
		return true;
	} else if (el === '') {
		return true;
	} else if (el === null) {
		return true;
	} else if (el === false) {
		return true;
	} else if (empty(el)) {
		return true;
	}

	return false;
}

/**
 * Gets the `toStringTag` of `value`.
 *
 * @private
 * @param {*} value The value to query.
 * @returns {string} Returns the `toStringTag`.
 */
export function getTag(value) {
	if (value == null) {
		return value === undefined ? '[object Undefined]' : '[object Null]';
	}
	return Object.prototype.toString.call(value);
}

/**
 * Function for making strings camelCase
 *
 * @param {string} str The string to convert
 * @return {string} The converted string
 */
export function camelCase(str) {
	return `${str.charAt(0).toLowerCase()}${str
		.replace(/[\W_]/g, '|')
		.split('|')
		.map((part) => `${part.charAt(0).toUpperCase()}${part.slice(1)}`)
		.join('')
		.slice(1)}`;
}

/**
 * Convert a string to slug or kebab case
 *
 * @param {*} str
 * @return {*}
 */

export function slugCase(str) {
	let pattern = new RegExp('((s+&s+)|(s+&amp;s+))');
	str = replace(str, pattern, ' and ');
	return chain(str).deburr().trim().kebabCase().value();
}

/**
 * Convert a string to title case with ampersands
 *
 * @param {*} str
 * @param {boolean} [useAmp=false] Whether to automatically change the word and
 *                                 to an ampersand
 * @return {*}
 */
export function titleCase(str, useAmp = false) {
	let pattern = new RegExp(/(\/|-|_)/gm);
	str = replace(str, pattern, ' ');
	str = chain(str)
		.trim()
		.startCase()
		.tap(function (str) {
			if (useAmp) {
				let andPattern = new RegExp(/and/gim);
				var amp = escape('&');
				return replace(str, andPattern, amp);
			}

			return str;
		})
		.value();
	return str;
}

/**
 *	Change the tag of a node element
 *
 * @param  {Element}  original  The element to change
 * @param  {string}   tag        The new tag
 *
 * @return {Element} The updated element
 */
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

const domParserSupport = (function () {
	if (!window.DOMParser) return false;
	var parser = new DOMParser();
	try {
		parser.parseFromString('x', 'text/html');
	} catch (err) {
		return false;
	}
	return true;
})();

/**
 * Convert a template string into HTML DOM nodes
 * @param  {String} str The template string
 * @return {Node}       The template HTML
 */
export function stringToHtml(str) {
	// If DOMParser is supported, use it
	if (domParserSupport) {
		var parser = new DOMParser();
		var doc = parser.parseFromString(str, 'text/html');
		return doc.body.firstElementChild;
	}

	// Otherwise, fallback to old-school method
	var dom = document.createElement('div');
	dom.innerHTML = str;
	return dom;
}

/**
 * Adds focus class for better accessibility
 *
 * @export
 * @param {*} event
 * @param {string} [parentClass='nav']
 */
export function toggleFocus(event, parentClass = 'nav') {
	if (event.type === 'focus' || event.type === 'blur') {
		let self = event.target;

		if (!isEmpty(self)) {
			const elementClasses = self.classList;

			if (!isEmpty(elementClasses)) {
				// Move up through the ancestors of the current link until we hit .nav-menu.
				while (!elementClasses.contains(parentClass)) {
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
		const menuItem = self.parentNode;
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
export function screenSize(prop) {
	const size = {
		width: actual.actual('width', 'px'),
		height: actual.actual('height', 'px'),
	};

	window.addEventListener('resize', function () {
		assign(
			{
				width: actual.actual('width', 'px'),
				height: actual.actual('height', 'px'),
			},
			size
		);
	});

	if (!isEmpty(prop)) {
		return size[prop];
	}

	return size;
}

// URL updates and the element focus is maintained
// originally found via in Update 3 on http://www.learningjquery.com/2007/10/improved-animated-scrolling-script-for-same-page-links

// filter handling for a /dir/ OR /indexordefault.page
export function filterPath(string) {
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
export function getHash(string) {
	var index = string.indexOf('#');
	if (index !== -1) {
		return string.substring(index + 1);
	}
	return false;
}

export function toggleNav(buttonId) {
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
export function getTallest(el) {
	const matches = document.querySelectorAll(el);
	if (matches.length > 1) {
		const heights = map(matches, function (elem) {
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
export function matchHeights(elem = '', breakpoint = null) {
	var matches = document.querySelectorAll(elem);
	var bp = null;
	if (!isEmpty(breakpoint)) {
		breakpoint = getBootstrapBP(breakpoint);
		if (false !== breakpoint && 0 != breakpoint) {
			bp = `(min-width: ${breakpoint})`;
		}
	}
	if (matches.length > 1) {
		if ((!isEmpty(bp) && mq(bp)) || isEmpty(bp)) {
			var minHeight = getTallest(elem);

			if (false !== minHeight) {
				minHeight += 'px';
				matches.forEach(function (el) {
					el.style.minHeight = minHeight;
				});
			}
		} else {
			matches.forEach(function (el) {
				el.style.removeProperty('minHeight');
			});
		}

		window.addEventListener('resize', function () {
			matchHeights(elem);
		});
	}
}

/**
 * Get widest element
 *
 * @param {string} el
 * @return {number}
 */
export function getWidest(el) {
	const matches = document.querySelectorAll(el);
	if (matches.length > 1) {
		const widths = map(matches, function (elem) {
			return elem.offsetWidth;
		});

		return Math.max.apply(null, widths);
	}
	return false;
}

/**
 * Make all elements match the tallest element
 *
 * @param {string} [elem='']
 */
export function matchWidths(elem = '', breakpoint = null) {
	var matches = document.querySelectorAll(elem);
	var bp = null;
	if (!isEmpty(breakpoint)) {
		breakpoint = getBootstrapBP(breakpoint);
		if (false !== breakpoint && 0 != breakpoint) {
			bp = `(min-width: ${breakpoint})`;
		}
	}
	if (matches.length > 1) {
		if ((!isEmpty(bp) && mq(bp)) || isEmpty(bp)) {
			var minWidth = getWidest(elem);

			if (false !== minWidth) {
				minWidth += 'px';
				matches.forEach(function (el) {
					el.style.minWidth = minWidth;
				});
			}
		} else {
			matches.forEach(function (el) {
				el.style.removeProperty('minWidth');
			});
		}

		window.addEventListener('resize', function () {
			matchWidths(elem);
		});
	}
}

const isSameDomain = (styleSheet) => {
	if (!styleSheet.href) {
		return true;
	}

	return styleSheet.href.indexOf(window.location.origin) === 0;
};

const isStyleRule = (rule) => rule.type === 1;

const getCSSCustomPropIndex = (index = '--') =>
	[...document.styleSheets].filter(isSameDomain).reduce(
		(finalArr, sheet) =>
			finalArr.concat(
				[...sheet.cssRules].filter(isStyleRule).reduce((propValArr, rule) => {
					const props = [...rule.style].map((propName) => [propName.trim(), rule.style.getPropertyValue(propName).trim()]).filter(([propName]) => propName.indexOf(index) === 0);
					return [...propValArr, ...props];
				}, [])
			),
		[]
	);

export function bsAtts() {
	let props = getCSSCustomPropIndex('--bs-');

	props = fromPairs(props);

	props = sortObjectByKeys(props);

	return props;
}

export function getBootstrapVar(v = '') {
	let props = bsAtts();
	return get(props, v, false);
}

export function getBootstrapBP(breakpoint) {
	breakpoint = `--bs-bp-${breakpoint}`;
	return getBootstrapVar(breakpoint);
}

export function sortObjectByKeys(o) {
	return Object.keys(o)
		.sort()
		.reduce((r, k) => ((r[k] = o[k]), r), {});
}

/**
 * Log all custom css properties to the console.
 *
 * @link https://css-tricks.com/how-to-get-all-custom-properties-on-a-page-in-javascript/
 *
 * @export
 */
export function logCustomProperties() {
	// eslint-disable-next-line
	let props = getCSSCustomPropIndex();

	props = fromPairs(props);

	props = sortObjectByKeys(props);

	console.groupCollapsed('Custom CSS Properties');
	console.table(props);
	console.groupEnd();
}

export function setScrollbarVariable() {
	const getScrollbarWidth = () => {
		// Create a temporary div container and append it into the body
		const container = document.createElement('div');
		// Append the container in the body
		document.body.appendChild(container);
		// Force scrollbar on the container
		container.style.overflow = 'scroll';

		// Add ad fake div inside the container
		const inner = document.createElement('div');
		container.appendChild(inner);

		// Calculate the width based on the container width minus its child width
		const width = container.offsetWidth - inner.offsetWidth;
		// Remove the container from the body
		document.body.removeChild(container);

		return width;
	};

	// Get the scrollbar dimension
	const scrollbarWidth = getScrollbarWidth();
	// Set a custom property with the value we calculated
	document.documentElement.style.setProperty('--bs-scrollbar', `${scrollbarWidth}px`);
}
