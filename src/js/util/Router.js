/** ============================================================================
 * Router
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

import domready from 'domready';

function camelCase(str) {
	return `${str.charAt(0).toLowerCase()}${str
		.replace(/[\W_]/g, '|')
		.split('|')
		.map((part) => `${part.charAt(0).toUpperCase()}${part.slice(1)}`)
		.join('')
		.slice(1)}`;
}
/**
 * DOM-based Routing
 *
 * Based on {@link http://goo.gl/EUTi53|Markup-based Unobtrusive Comprehensive DOM-ready Execution} by Paul Irish
 *
 * The routing fires all common scripts, followed by the page specific scripts.
 * Add additional events for more control over timing e.g. a finalize event
 */
class Router {
	constructor(routes) {
		this.routes = routes;
	}

	promisedEvent(route = {}, eventType = '', timeout = 0, ...args) {
		const event = route[eventType];
		var listener = () => {
			setTimeout(() => {
				event.apply(route, args);
			}, timeout);
		};
		return new Promise((resolve) => {
			if ('resize' === eventType) {
				window.addEventListener('resize', listener);
			} else if ('init' == eventType) {
				domready(listener);
			} else if ('finalize' == eventType) {
				window.addEventListener('load', listener, false);
			}
			resolve();
		});
	}

	async asyncEvent(route, eventType, ...args) {
		let timeout = 1;
		if ('finalize' == eventType) {
			timeout = 2000;
		}
		await this.promisedEvent(route, eventType, timeout, ...args);
	}

	/**
	 * Fire Router events
	 *
	 * @param {string} route   DOM-based route derived from body classes (`<body class="...">`)
	 * @param {string} [event] Events on the route. By default, `init` and `finalize` events are called.
	 * @param {string} [arg]   Any custom argument to be passed to the event.
	 */
	fire(routeName, eventType = 'init', ...args) {
		console.log('🚀 ~ file: Router.js ~ line 67 ~ Router ~ fire ~ eventType', eventType);
		console.log('🚀 ~ file: Router.js ~ line 67 ~ Router ~ fire ~ routeName', routeName);
		document.dispatchEvent(
			new CustomEvent('routed', {
				bubbles: true,
				detail: {
					routeName,
					fn: eventType,
				},
			})
		);

		const route = this.routes[routeName],
			event = route[eventType];

		const fire = routeName !== '' && route && typeof event === 'function';

		try {
			if (fire) {
				this.asyncEvent(route, eventType, ...args);
			} else if (typeof event !== 'function') {
				throw new TypeError(`callback for ${route.name}.${eventType} must be a function`);
			} else {
				throw new Error(`cannot run ${route.name}.${eventType}`);
			}
		} catch (e) {
			// statements to handle any exceptions
			console.error('Router Error:', e.message);
		}
	}

	/**
	 * Automatically load and fire Router events
	 *
	 * Events are fired in the following order:
	 *  common init
	 *  page-specific init
	 *  page-specific finalize
	 *  common finalize
	 */
	loadEvents() {
		const pageClasses = document.body.className.toLowerCase().replace(/-/g, '_').split(/\s+/).map(camelCase);
		console.log('🚀 ~ file: Router.js ~ line 109 ~ Router ~ loadEvents ~ pageClasses', pageClasses);

		// Fire common init JS
		this.fire('common');

		// Fire page-specific init JS, and then finalize JS
		Object.keys(this.routes).forEach((route) => {
			if (pageClasses.includes(route) && route !== 'common') {
				this.fire(route);
			}
		});
		Object.keys(this.routes).forEach((route) => {
			if (pageClasses.includes(route) && route !== 'common') {
				this.fire(route, 'finalize');
			}
		});
		Object.keys(this.routes).forEach((route) => {
			if (pageClasses.includes(route) && route !== 'common') {
				this.fire(route, 'resize');
			}
		});

		// Fire common finalize JS
		this.fire('common', 'finalize');
		this.fire('common', 'resize');
	}
}

export default Router;
