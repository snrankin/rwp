/** ============================================================================
 * utils
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

import { /* webpackMode: "eager" */ actual } from 'actual';

import { /* webpackMode: "eager" */ mq } from 'verge';

export * from 'verge';

export const isReduced = window.matchMedia('(prefers-reduced-motion: reduce)') === true || window.matchMedia('(prefers-reduced-motion: reduce)').matches === true;

export function has(obj, path) {
	// Regex explained: https://regexr.com/58j0k
	const pathArray = Array.isArray(path) ? path : path.match(/([^[.\]])+/g);

	return !!pathArray.reduce((prevObj, key) => prevObj && prevObj[key], obj);
}

export function eventFire(el, etype) {
	if (el.fireEvent) {
		el.fireEvent('on' + etype);
	} else {
		var evObj = document.createEvent('Events');
		evObj.initEvent(etype, true, false);
		el.dispatchEvent(evObj);
	}
}

export function listen(el, etype, fn, nobubble, stopdefault) {
	nobubble = nobubble || false;
	stopdefault = stopdefault || false;

	var fnwrap = function (e) {
		e = e || event;
		if (nobubble) {
			noBubbles(e);
		}
		if (stopdefault) {
			noDefault(e);
		}
		return fn.apply(el, Array.prototype.slice.call(arguments));
	};
	if (el.attachEvent) {
		el.attachEvent('on' + etype, fnwrap);
	} else {
		el.addEventListener(etype, fnwrap, false);
	}
}

export function noDefault(e) {
	if (e.preventDefault) {
		e.preventDefault();
	} else {
		e.returnValue = false;
	}
}

export function noBubbles(e) {
	if (e.stopPropagation) {
		e.stopPropagation();
	} else {
		e.cancelBubble = true;
	}
}

export function extend() {
	var obj,
		name,
		copy,
		target = arguments[0] || {},
		i = 1,
		length = arguments.length;

	for (; i < length; i++) {
		if ((obj = arguments[i]) !== null) {
			for (name in obj) {
				copy = obj[name];

				if (target === copy) {
					continue;
				} else if (copy !== undefined) {
					target[name] = copy;
				}
			}
		}
	}

	return target;
}

export function get(obj, path, defValue) {
	// If path is not defined or it has false value
	if (!path) return undefined;
	// Check if path is string or array. Regex : ensure that we do not have '.' and brackets.
	// Regex explained: https://regexr.com/58j0k
	const pathArray = Array.isArray(path) ? path : path.match(/([^[.\]])+/g);
	// Find value
	const result = pathArray.reduce((prevObj, key) => prevObj && prevObj[key], obj);
	// If found value is undefined return default value; otherwise return the value
	return result === undefined ? defValue : result;
}
/**
 * Check if a variable is empty
 *
 * @export
 * @param {*} el The variable to check
 * @return {boolean} True if empty, false if not
 */
export function isEmpty(el) {
	if (el === undefined || el == null) {
		return true;
	}
	if (typeof el === 'string' && el.length > 0) {
		return false;
	} else if (el === true) {
		return false;
	} else if (el instanceof Object) {
		if (Array.isArray(el) && el.length > 0) {
			return false;
		} else {
			if (Object.keys(el).length > 0) {
				return false;
			}
		}
	}
	return false;
}

export function omit(obj, props) {
	// eslint-disable-next-line
	obj = { ...obj };
	props.forEach((prop) => delete obj[prop]);
	return obj;
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

function isElement($obj) {
	try {
		return $obj.constructor.__proto__.prototype.constructor.name ? true : false;
	} catch (e) {
		return false;
	}
}

/**
 * IE safe way of testing if an object is a NodeList
 *
 * @link https://stackoverflow.com/questions/151348/how-to-check-if-an-object-is-an-instance-of-a-nodelist-in-ie
 * @param {*} el
 * @return {boolean}
 */
function isNodeList(el) {
	if (typeof el.length === 'number' && typeof el.item !== 'undefined' && typeof el.entries === 'function' && typeof el.forEach === 'function' && typeof el.keys === 'function' && typeof el.values === 'function') {
		if (isElement(el[0])) {
			return true;
		} else {
			return false;
		}
	}
	return false;
}

export function wrapElement(toWrap, wrapper) {
	wrapper = stringToHtml(wrapper);

	var parent;

	//toWrap.parentNode.appendChild(wrapper);

	if (isNodeList(toWrap) && toWrap.length > 0) {
		parent = toWrap[0].parentNode;
		parent.insertBefore(wrapper, toWrap[0]);
		toWrap.forEach((item) => {
			wrapper.appendChild(item);
		});
	} else {
		parent = toWrap.parentNode;
		parent.insertBefore(wrapper, toWrap);
		wrapper.appendChild(toWrap);
	}

	// return wrapper;
}

export function unwrapElement(el) {
	// get the element's parent node
	var parent = el.parentNode;

	// move all children out of the element
	while (el.firstChild) parent.insertBefore(el.firstChild, el);

	// remove the empty element
	parent.removeChild(el);
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
		size.width = actual.actual('width', 'px');
		size.hieght = actual.actual('height', 'px');
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

/**
 * Get tallest element
 *
 * @param {string} el
 * @return {number}
 */
export function getTallest(el) {
	const elements = document.querySelectorAll(el);
	const matches = Array.from(elements);
	if (matches.length > 1) {
		const heights = matches.map(function (elem) {
			return elem.offsetHeight;
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

	if (matches.length > 1) {
		if ((!isEmpty(breakpoint) && isBootstrapBP(breakpoint)) || isEmpty(breakpoint)) {
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
	const elements = document.querySelectorAll(el);
	const matches = Array.from(elements);
	if (matches.length > 1) {
		const widths = matches.map(function (elem) {
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
	if (matches.length > 1) {
		if ((!isEmpty(breakpoint) && isBootstrapBP(breakpoint)) || isEmpty(breakpoint)) {
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

	props = Object.fromEntries(props);

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

export function isBootstrapBP(breakpoint, type = 'min-width') {
	breakpoint = getBootstrapBP(breakpoint);
	return mq(`(${type}: ${breakpoint})`);
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

	props = Object.fromEntries(props);

	props = sortObjectByKeys(props);

	console.groupCollapsed('Custom CSS Properties');
	console.table(props);
	console.groupEnd();
}
