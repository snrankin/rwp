var rwp;
/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!********************************!*\
  !*** ./js/vendor/modernizr.js ***!
  \********************************/
/*! modernizr 3.6.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-adownload-apng-appearance-arrow-atobbtoa-audio-audiopreload-backdropfilter-backgroundblendmode-backgroundcliptext-backgroundsize-bgpositionshorthand-bgpositionxy-bgrepeatspace_bgrepeatround-bgsizecover-borderimage-borderradius-boxshadow-boxsizing-canvas-canvasblending-canvastext-capture-checked-classlist-contains-cookies-cors-cssall-cssanimations-csscalc-csschunit-csscolumns-cssescape-cssexunit-cssfilters-cssgradients-cssgrid_cssgridlegacy-cssinvalid-cssmask-csspointerevents-csspositionsticky-csspseudotransitions-cssreflections-cssremunit-cssresize-cssscrollbar-csstransforms-cssvalid-cssvhunit-cssvmaxunit-cssvminunit-cssvwunit-cubicbezierrange-datalistelem-datauri-details-directory-display_runin-displaytable-ellipsis-emoji-es5-es5array-es5date-es5function-es5object-es5string-es5syntax-es6array-es6collections-es6math-es6number-es6object-es6string-eventlistener-fileinput-filesystem-flexbox-flexboxtweener-flexwrap-focuswithin-fontface-formattribute-formvalidation-fullscreen-generatedcontent-generators-hairline-hidden-hiddenscroll-history-hovermq-hsla-inlinesvg-inputtypes-jpeg2000-json-lastchild-ligatures-localizednumber-mediaqueries-multiplebgs-notification-nthchild-objectfit-olreversed-opacity-overflowscrolling-pagevisibility-picture-placeholder-pointerevents-preserve3d-progressbar_meter-promises-queryselector-regions-rgba-sandbox-scriptasync-scriptdefer-scrollsnappoints-search-shapes-siblinggeneral-sizes-srcdoc-srcset-stylescoped-subpixelfont-supports-svg-svgasimg-svgclippaths-svgfilters-target-textalignlast-textshadow-time-touchevents-urlparser-variablefonts-video-videoautoplay-videocrossorigin-videopreload-webp-webpalpha-webplossless_webp_lossless-wrapflow-setclasses !*/
!(function (window, document, undefined) {
	function is(A, e) {
		return typeof A === e;
	}
	function testRunner() {
		let A, e, t, r, n, o, i;
		for (const d in tests)
			if (tests.hasOwnProperty(d)) {
				if (
					((A = []),
					(e = tests[d]),
					e.name &&
						(A.push(e.name.toLowerCase()),
						e.options &&
							e.options.aliases &&
							e.options.aliases.length))
				)
					for (t = 0; t < e.options.aliases.length; t++)
						A.push(e.options.aliases[t].toLowerCase());
				for (
					r = is(e.fn, 'function') ? e.fn() : e.fn, n = 0;
					n < A.length;
					n++
				)
					(o = A[n]),
						(i = o.split('.')),
						1 === i.length
							? (Modernizr[i[0]] = r)
							: (!Modernizr[i[0]] ||
									Modernizr[i[0]] instanceof Boolean ||
									(Modernizr[i[0]] = new Boolean(
										Modernizr[i[0]]
									)),
							  (Modernizr[i[0]][i[1]] = r)),
						classes.push((r ? '' : 'no-') + i.join('-'));
			}
	}
	function setClasses(A) {
		let e = docElement.className,
			t = Modernizr._config.classPrefix || '';
		if ((isSVG && (e = e.baseVal), Modernizr._config.enableJSClass)) {
			const r = new RegExp('(^|\\s)' + t + 'no-js(\\s|$)');
			e = e.replace(r, '$1' + t + 'js$2');
		}
		Modernizr._config.enableClasses &&
			((e += ' ' + t + A.join(' ' + t)),
			isSVG
				? (docElement.className.baseVal = e)
				: (docElement.className = e));
	}
	function createElement() {
		return 'function' !== typeof document.createElement
			? document.createElement(arguments[0])
			: isSVG
			? document.createElementNS.call(
					document,
					'http://www.w3.org/2000/svg',
					arguments[0]
			  )
			: document.createElement.apply(document, arguments);
	}
	function contains(A, e) {
		return !!~('' + A).indexOf(e);
	}
	function getBody() {
		let A = document.body;
		return (
			A || ((A = createElement(isSVG ? 'svg' : 'body')), (A.fake = !0)), A
		);
	}
	function computedStyle(A, e, t) {
		let r;
		if ('getComputedStyle' in window) {
			r = getComputedStyle.call(window, A, e);
			const n = window.console;
			if (null !== r) t && (r = r.getPropertyValue(t));
			else if (n) {
				const o = n.error ? 'error' : 'log';
				n[o].call(
					n,
					'getComputedStyle returning null, its possible modernizr test results are inaccurate'
				);
			}
		} else r = !e && A.currentStyle && A.currentStyle[t];
		return r;
	}
	function roundedEquals(A, e) {
		return A - 1 === e || A === e || A + 1 === e;
	}
	function cssToDOM(A) {
		return A.replace(/([a-z])-([a-z])/g, function (A, e, t) {
			return e + t.toUpperCase();
		}).replace(/^-/, '');
	}
	function injectElementWithStyles(A, e, t, r) {
		let n,
			o,
			i,
			d,
			a = 'modernizr',
			s = createElement('div'),
			l = getBody();
		if (parseInt(t, 10))
			for (; t--; )
				(i = createElement('div')),
					(i.id = r ? r[t] : a + (t + 1)),
					s.appendChild(i);
		return (
			(n = createElement('style')),
			(n.type = 'text/css'),
			(n.id = 's' + a),
			(l.fake ? l : s).appendChild(n),
			l.appendChild(s),
			n.styleSheet
				? (n.styleSheet.cssText = A)
				: n.appendChild(document.createTextNode(A)),
			(s.id = a),
			l.fake &&
				((l.style.background = ''),
				(l.style.overflow = 'hidden'),
				(d = docElement.style.overflow),
				(docElement.style.overflow = 'hidden'),
				docElement.appendChild(l)),
			(o = e(s, A)),
			l.fake
				? (l.parentNode.removeChild(l),
				  (docElement.style.overflow = d),
				  docElement.offsetHeight)
				: s.parentNode.removeChild(s),
			!!o
		);
	}
	function addTest(A, e) {
		if ('object' === typeof A)
			for (const t in A) hasOwnProp(A, t) && addTest(t, A[t]);
		else {
			A = A.toLowerCase();
			let r = A.split('.'),
				n = Modernizr[r[0]];
			if ((2 == r.length && (n = n[r[1]]), 'undefined' !== typeof n))
				return Modernizr;
			(e = 'function' === typeof e ? e() : e),
				1 == r.length
					? (Modernizr[r[0]] = e)
					: (!Modernizr[r[0]] ||
							Modernizr[r[0]] instanceof Boolean ||
							(Modernizr[r[0]] = new Boolean(Modernizr[r[0]])),
					  (Modernizr[r[0]][r[1]] = e)),
				setClasses([(e && 0 != e ? '' : 'no-') + r.join('-')]),
				Modernizr._trigger(A, e);
		}
		return Modernizr;
	}
	function fnBind(A, e) {
		return function () {
			return A.apply(e, arguments);
		};
	}
	function testDOMProps(A, e, t) {
		let r;
		for (const n in A)
			if (A[n] in e)
				return t === !1
					? A[n]
					: ((r = e[A[n]]),
					  is(r, 'function') ? fnBind(r, t || e) : r);
		return !1;
	}
	function domToCSS(A) {
		return A.replace(/([A-Z])/g, function (A, e) {
			return '-' + e.toLowerCase();
		}).replace(/^ms-/, '-ms-');
	}
	function nativeTestProps(A, e) {
		let t = A.length;
		if ('CSS' in window && 'supports' in window.CSS) {
			for (; t--; ) if (window.CSS.supports(domToCSS(A[t]), e)) return !0;
			return !1;
		}
		if ('CSSSupportsRule' in window) {
			for (var r = []; t--; )
				r.push('(' + domToCSS(A[t]) + ':' + e + ')');
			return (
				(r = r.join(' or ')),
				injectElementWithStyles(
					'@supports (' +
						r +
						') { #modernizr { position: absolute; } }',
					function (A) {
						return 'absolute' == computedStyle(A, null, 'position');
					}
				)
			);
		}
		return undefined;
	}
	function testProps(A, e, t, r) {
		function n() {
			i && (delete mStyle.style, delete mStyle.modElem);
		}
		if (((r = is(r, 'undefined') ? !1 : r), !is(t, 'undefined'))) {
			const o = nativeTestProps(A, t);
			if (!is(o, 'undefined')) return o;
		}
		for (
			var i, d, a, s, l, c = ['modernizr', 'tspan', 'samp'];
			!mStyle.style && c.length;

		)
			(i = !0),
				(mStyle.modElem = createElement(c.shift())),
				(mStyle.style = mStyle.modElem.style);
		for (a = A.length, d = 0; a > d; d++)
			if (
				((s = A[d]),
				(l = mStyle.style[s]),
				contains(s, '-') && (s = cssToDOM(s)),
				mStyle.style[s] !== undefined)
			) {
				if (r || is(t, 'undefined')) return n(), 'pfx' == e ? s : !0;
				try {
					mStyle.style[s] = t;
				} catch (w) {}
				if (mStyle.style[s] != l) return n(), 'pfx' == e ? s : !0;
			}
		return n(), !1;
	}
	function testPropsAll(A, e, t, r, n) {
		let o = A.charAt(0).toUpperCase() + A.slice(1),
			i = (A + ' ' + cssomPrefixes.join(o + ' ') + o).split(' ');
		return is(e, 'string') || is(e, 'undefined')
			? testProps(i, e, r, n)
			: ((i = (A + ' ' + domPrefixes.join(o + ' ') + o).split(' ')),
			  testDOMProps(i, e, t));
	}
	function testAllProps(A, e, t) {
		return testPropsAll(A, undefined, undefined, e, t);
	}
	var classes = [],
		tests = [],
		ModernizrProto = {
			_version: '3.6.0',
			_config: {
				classPrefix: '',
				enableClasses: !0,
				enableJSClass: !0,
				usePrefixes: !0,
			},
			_q: [],
			on(A, e) {
				const t = this;
				setTimeout(function () {
					e(t[A]);
				}, 0);
			},
			addTest(A, e, t) {
				tests.push({ name: A, fn: e, options: t });
			},
			addAsyncTest(A) {
				tests.push({ name: null, fn: A });
			},
		},
		Modernizr = function () {};
	(Modernizr.prototype = ModernizrProto),
		(Modernizr = new Modernizr()),
		Modernizr.addTest('cookies', function () {
			try {
				document.cookie = 'cookietest=1';
				const A = -1 != document.cookie.indexOf('cookietest=');
				return (
					(document.cookie =
						'cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT'),
					A
				);
			} catch (e) {
				return !1;
			}
		}),
		Modernizr.addTest(
			'cors',
			'XMLHttpRequest' in window &&
				'withCredentials' in new XMLHttpRequest()
		),
		Modernizr.addTest('history', function () {
			const A = navigator.userAgent;
			return (-1 === A.indexOf('Android 2.') &&
				-1 === A.indexOf('Android 4.0')) ||
				-1 === A.indexOf('Mobile Safari') ||
				-1 !== A.indexOf('Chrome') ||
				-1 !== A.indexOf('Windows Phone') ||
				'file:' === location.protocol
				? window.history && 'pushState' in window.history
				: !1;
		}),
		Modernizr.addTest(
			'json',
			'JSON' in window && 'parse' in JSON && 'stringify' in JSON
		),
		Modernizr.addTest('notification', function () {
			if (!window.Notification || !window.Notification.requestPermission)
				return !1;
			if ('granted' === window.Notification.permission) return !0;
			try {
				new window.Notification('');
			} catch (A) {
				if ('TypeError' === A.name) return !1;
			}
			return !0;
		}),
		Modernizr.addTest(
			'queryselector',
			'querySelector' in document && 'querySelectorAll' in document
		),
		Modernizr.addTest(
			'svg',
			!!document.createElementNS &&
				!!document.createElementNS('http://www.w3.org/2000/svg', 'svg')
					.createSVGRect
		),
		Modernizr.addTest('eventlistener', 'addEventListener' in window);
	const CSS = window.CSS;
	Modernizr.addTest('cssescape', CSS ? 'function' === typeof CSS.escape : !1),
		Modernizr.addTest('focuswithin', function () {
			try {
				document.querySelector(':focus-within');
			} catch (A) {
				return !1;
			}
			return !0;
		}),
		Modernizr.addTest('es5array', function () {
			return !!(
				Array.prototype &&
				Array.prototype.every &&
				Array.prototype.filter &&
				Array.prototype.forEach &&
				Array.prototype.indexOf &&
				Array.prototype.lastIndexOf &&
				Array.prototype.map &&
				Array.prototype.some &&
				Array.prototype.reduce &&
				Array.prototype.reduceRight &&
				Array.isArray
			);
		}),
		Modernizr.addTest('es5date', function () {
			let A = '2013-04-12T06:06:37.307Z',
				e = !1;
			try {
				e = !!Date.parse(A);
			} catch (t) {}
			return !!(
				Date.now &&
				Date.prototype &&
				Date.prototype.toISOString &&
				Date.prototype.toJSON &&
				e
			);
		}),
		Modernizr.addTest('es5function', function () {
			return !(!Function.prototype || !Function.prototype.bind);
		}),
		Modernizr.addTest('es5object', function () {
			return !!(
				Object.keys &&
				Object.create &&
				Object.getPrototypeOf &&
				Object.getOwnPropertyNames &&
				Object.isSealed &&
				Object.isFrozen &&
				Object.isExtensible &&
				Object.getOwnPropertyDescriptor &&
				Object.defineProperty &&
				Object.defineProperties &&
				Object.seal &&
				Object.freeze &&
				Object.preventExtensions
			);
		}),
		Modernizr.addTest('es5string', function () {
			return !(!String.prototype || !String.prototype.trim);
		}),
		Modernizr.addTest('es5syntax', function () {
			let value,
				obj,
				stringAccess,
				getter,
				setter,
				reservedWords,
				zeroWidthChars;
			try {
				return (
					(stringAccess = eval('"foobar"[3] === "b"')),
					(getter = eval('({ get x(){ return 1 } }).x === 1')),
					eval('({ set x(v){ value = v; } }).x = 1'),
					(setter = 1 === value),
					eval('obj = ({ if: 1 })'),
					(reservedWords = 1 === obj.if),
					(zeroWidthChars = eval('_‌‍ = true')),
					stringAccess &&
						getter &&
						setter &&
						reservedWords &&
						zeroWidthChars
				);
			} catch (ignore) {
				return !1;
			}
		}),
		Modernizr.addTest(
			'es6array',
			!!(
				Array.prototype &&
				Array.prototype.copyWithin &&
				Array.prototype.fill &&
				Array.prototype.find &&
				Array.prototype.findIndex &&
				Array.prototype.keys &&
				Array.prototype.entries &&
				Array.prototype.values &&
				Array.from &&
				Array.of
			)
		),
		Modernizr.addTest('arrow', function () {
			try {
				eval('()=>{}');
			} catch (e) {
				return !1;
			}
			return !0;
		}),
		Modernizr.addTest(
			'es6collections',
			!!(window.Map && window.Set && window.WeakMap && window.WeakSet)
		),
		Modernizr.addTest('generators', function () {
			try {
				new Function('function* test() {}')();
			} catch (A) {
				return !1;
			}
			return !0;
		}),
		Modernizr.addTest(
			'es6math',
			!!(
				Math &&
				Math.clz32 &&
				Math.cbrt &&
				Math.imul &&
				Math.sign &&
				Math.log10 &&
				Math.log2 &&
				Math.log1p &&
				Math.expm1 &&
				Math.cosh &&
				Math.sinh &&
				Math.tanh &&
				Math.acosh &&
				Math.asinh &&
				Math.atanh &&
				Math.hypot &&
				Math.trunc &&
				Math.fround
			)
		);
	const newSyntax = 'CSS' in window && 'supports' in window.CSS,
		oldSyntax = 'supportsCSS' in window;
	Modernizr.addTest('supports', newSyntax || oldSyntax),
		Modernizr.addTest(
			'es6number',
			!!(
				Number.isFinite &&
				Number.isInteger &&
				Number.isSafeInteger &&
				Number.isNaN &&
				Number.parseInt &&
				Number.parseFloat &&
				Number.isInteger(Number.MAX_SAFE_INTEGER) &&
				Number.isInteger(Number.MIN_SAFE_INTEGER) &&
				Number.isFinite(Number.EPSILON)
			)
		),
		Modernizr.addTest(
			'es6object',
			!!(Object.assign && Object.is && Object.setPrototypeOf)
		),
		Modernizr.addTest('target', function () {
			const A = window.document;
			if (!('querySelectorAll' in A)) return !1;
			try {
				return A.querySelectorAll(':target'), !0;
			} catch (e) {
				return !1;
			}
		}),
		Modernizr.addTest('promises', function () {
			return (
				'Promise' in window &&
				'resolve' in window.Promise &&
				'reject' in window.Promise &&
				'all' in window.Promise &&
				'race' in window.Promise &&
				(function () {
					let A;
					return (
						new window.Promise(function (e) {
							A = e;
						}),
						'function' === typeof A
					);
				})()
			);
		}),
		Modernizr.addTest(
			'es6string',
			!!(
				String.fromCodePoint &&
				String.raw &&
				String.prototype.codePointAt &&
				String.prototype.repeat &&
				String.prototype.startsWith &&
				String.prototype.endsWith &&
				String.prototype.includes
			)
		),
		Modernizr.addTest('picture', 'HTMLPictureElement' in window),
		Modernizr.addTest('svgfilters', function () {
			let A = !1;
			try {
				A =
					'SVGFEColorMatrixElement' in window &&
					2 ==
						SVGFEColorMatrixElement.SVG_FECOLORMATRIX_TYPE_SATURATE;
			} catch (e) {}
			return A;
		}),
		Modernizr.addTest('urlparser', function () {
			let A;
			try {
				return (
					(A = new URL('http://modernizr.com/')),
					'http://modernizr.com/' === A.href
				);
			} catch (e) {
				return !1;
			}
		}),
		Modernizr.addTest('atobbtoa', 'atob' in window && 'btoa' in window, {
			aliases: ['atob-btoa'],
		}),
		Modernizr.addTest(
			'contains',
			is(String.prototype.contains, 'function')
		);
	var docElement = document.documentElement;
	Modernizr.addTest('cssall', 'all' in docElement.style),
		Modernizr.addTest('classlist', 'classList' in docElement);
	var isSVG = 'svg' === docElement.nodeName.toLowerCase();
	Modernizr.addTest('audio', function () {
		let A = createElement('audio'),
			e = !1;
		try {
			(e = !!A.canPlayType),
				e &&
					((e = new Boolean(e)),
					(e.ogg = A.canPlayType(
						'audio/ogg; codecs="vorbis"'
					).replace(/^no$/, '')),
					(e.mp3 = A.canPlayType('audio/mpeg; codecs="mp3"').replace(
						/^no$/,
						''
					)),
					(e.opus =
						A.canPlayType('audio/ogg; codecs="opus"') ||
						A.canPlayType('audio/webm; codecs="opus"').replace(
							/^no$/,
							''
						)),
					(e.wav = A.canPlayType('audio/wav; codecs="1"').replace(
						/^no$/,
						''
					)),
					(e.m4a = (
						A.canPlayType('audio/x-m4a;') ||
						A.canPlayType('audio/aac;')
					).replace(/^no$/, '')));
		} catch (t) {}
		return e;
	}),
		Modernizr.addTest('canvas', function () {
			const A = createElement('canvas');
			return !(!A.getContext || !A.getContext('2d'));
		}),
		Modernizr.addTest('canvastext', function () {
			return Modernizr.canvas === !1
				? !1
				: 'function' ===
						typeof createElement('canvas').getContext('2d')
							.fillText;
		}),
		Modernizr.addTest('emoji', function () {
			if (!Modernizr.canvastext) return !1;
			const A = window.devicePixelRatio || 1,
				e = 12 * A,
				t = createElement('canvas'),
				r = t.getContext('2d');
			return (
				(r.fillStyle = '#f00'),
				(r.textBaseline = 'top'),
				(r.font = '32px Arial'),
				r.fillText('🐨', 0, 0),
				0 !== r.getImageData(e, e, 1, 1).data[0]
			);
		}),
		Modernizr.addTest('olreversed', 'reversed' in createElement('ol')),
		Modernizr.addTest('video', function () {
			let A = createElement('video'),
				e = !1;
			try {
				(e = !!A.canPlayType),
					e &&
						((e = new Boolean(e)),
						(e.ogg = A.canPlayType(
							'video/ogg; codecs="theora"'
						).replace(/^no$/, '')),
						(e.h264 = A.canPlayType(
							'video/mp4; codecs="avc1.42E01E"'
						).replace(/^no$/, '')),
						(e.webm = A.canPlayType(
							'video/webm; codecs="vp8, vorbis"'
						).replace(/^no$/, '')),
						(e.vp9 = A.canPlayType(
							'video/webm; codecs="vp9"'
						).replace(/^no$/, '')),
						(e.hls = A.canPlayType(
							'application/x-mpegURL; codecs="avc1.42E01E"'
						).replace(/^no$/, '')));
			} catch (t) {}
			return e;
		}),
		Modernizr.addTest(
			'adownload',
			!window.externalHost && 'download' in createElement('a')
		),
		Modernizr.addTest('canvasblending', function () {
			if (Modernizr.canvas === !1) return !1;
			const A = createElement('canvas').getContext('2d');
			try {
				A.globalCompositeOperation = 'screen';
			} catch (e) {}
			return 'screen' === A.globalCompositeOperation;
		}),
		Modernizr.addTest('bgpositionshorthand', function () {
			const A = createElement('a'),
				e = A.style,
				t = 'right 10px bottom 10px';
			return (
				(e.cssText = 'background-position: ' + t + ';'),
				e.backgroundPosition === t
			);
		}),
		Modernizr.addTest('rgba', function () {
			const A = createElement('a').style;
			return (
				(A.cssText = 'background-color:rgba(150,255,150,.5)'),
				('' + A.backgroundColor).indexOf('rgba') > -1
			);
		}),
		Modernizr.addTest('time', 'valueAsDate' in createElement('time')),
		Modernizr.addTest('multiplebgs', function () {
			const A = createElement('a').style;
			return (
				(A.cssText =
					'background:url(https://),url(https://),red url(https://)'),
				/(url\s*\(.*?){3}/.test(A.background)
			);
		}),
		Modernizr.addTest('csspointerevents', function () {
			const A = createElement('a').style;
			return (
				(A.cssText = 'pointer-events:auto'), 'auto' === A.pointerEvents
			);
		}),
		Modernizr.addTest('capture', 'capture' in createElement('input')),
		Modernizr.addTest('fileinput', function () {
			if (
				navigator.userAgent.match(
					/(Android (1.0|1.1|1.5|1.6|2.0|2.1))|(Windows Phone (OS 7|8.0))|(XBLWP)|(ZuneWP)|(w(eb)?OSBrowser)|(webOS)|(Kindle\/(1.0|2.0|2.5|3.0))/
				)
			)
				return !1;
			const A = createElement('input');
			return (A.type = 'file'), !A.disabled;
		}),
		Modernizr.addTest('cssremunit', function () {
			const A = createElement('a').style;
			try {
				A.fontSize = '3rem';
			} catch (e) {}
			return /rem/.test(A.fontSize);
		}),
		Modernizr.addTest('formattribute', function () {
			let A,
				e = createElement('form'),
				t = createElement('input'),
				r = createElement('div'),
				n = 'formtest' + new Date().getTime(),
				o = !1;
			e.id = n;
			try {
				t.setAttribute('form', n);
			} catch (i) {
				document.createAttribute &&
					((A = document.createAttribute('form')),
					(A.nodeValue = n),
					t.setAttributeNode(A));
			}
			return (
				r.appendChild(e),
				r.appendChild(t),
				docElement.appendChild(r),
				(o = e.elements && 1 === e.elements.length && t.form == e),
				r.parentNode.removeChild(r),
				o
			);
		}),
		Modernizr.addTest(
			'placeholder',
			'placeholder' in createElement('input') &&
				'placeholder' in createElement('textarea')
		),
		Modernizr.addTest('preserve3d', function () {
			let A,
				e,
				t = window.CSS,
				r = !1;
			return t &&
				t.supports &&
				t.supports('(transform-style: preserve-3d)')
				? !0
				: ((A = createElement('a')),
				  (e = createElement('a')),
				  (A.style.cssText =
						'display: block; transform-style: preserve-3d; transform-origin: right; transform: rotateY(40deg);'),
				  (e.style.cssText =
						'display: block; width: 9px; height: 1px; background: #000; transform-origin: right; transform: rotateY(40deg);'),
				  A.appendChild(e),
				  docElement.appendChild(A),
				  (r = e.getBoundingClientRect()),
				  docElement.removeChild(A),
				  (r = r.width && r.width < 4));
		}),
		Modernizr.addTest('hidden', 'hidden' in createElement('a')),
		Modernizr.addTest(
			'progressbar',
			createElement('progress').max !== undefined
		),
		Modernizr.addTest('meter', createElement('meter').max !== undefined),
		Modernizr.addTest('sandbox', 'sandbox' in createElement('iframe')),
		Modernizr.addTest('srcdoc', 'srcdoc' in createElement('iframe')),
		Modernizr.addTest('srcset', 'srcset' in createElement('img')),
		Modernizr.addTest('scriptasync', 'async' in createElement('script')),
		Modernizr.addTest('scriptdefer', 'defer' in createElement('script')),
		Modernizr.addTest('stylescoped', 'scoped' in createElement('style')),
		Modernizr.addTest('inlinesvg', function () {
			const A = createElement('div');
			return (
				(A.innerHTML = '<svg/>'),
				'http://www.w3.org/2000/svg' ==
					('undefined' !== typeof SVGRect &&
						A.firstChild &&
						A.firstChild.namespaceURI)
			);
		}),
		Modernizr.addTest(
			'videocrossorigin',
			'crossOrigin' in createElement('video')
		),
		Modernizr.addTest('videopreload', 'preload' in createElement('video'));
	const hasEvent = (function () {
		function A(A, t) {
			let r;
			return A
				? ((t && 'string' !== typeof t) ||
						(t = createElement(t || 'div')),
				  (A = 'on' + A),
				  (r = A in t),
				  !r &&
						e &&
						(t.setAttribute || (t = createElement('div')),
						t.setAttribute(A, ''),
						(r = 'function' === typeof t[A]),
						t[A] !== undefined && (t[A] = undefined),
						t.removeAttribute(A)),
				  r)
				: !1;
		}
		var e = !('onblur' in document.documentElement);
		return A;
	})();
	(ModernizrProto.hasEvent = hasEvent),
		Modernizr.addTest('inputsearchevent', hasEvent('search'));
	const inputElem = createElement('input'),
		inputtypes =
			'search tel url email datetime date month week time datetime-local number range color'.split(
				' '
			),
		inputs = {};
	Modernizr.inputtypes = (function (A) {
		for (var e, t, r, n = A.length, o = '1)', i = 0; n > i; i++)
			inputElem.setAttribute('type', (e = A[i])),
				(r = 'text' !== inputElem.type && 'style' in inputElem),
				r &&
					((inputElem.value = o),
					(inputElem.style.cssText =
						'position:absolute;visibility:hidden;'),
					/^range$/.test(e) &&
					inputElem.style.WebkitAppearance !== undefined
						? (docElement.appendChild(inputElem),
						  (t = document.defaultView),
						  (r =
								t.getComputedStyle &&
								'textfield' !==
									t.getComputedStyle(inputElem, null)
										.WebkitAppearance &&
								0 !== inputElem.offsetHeight),
						  docElement.removeChild(inputElem))
						: /^(search|tel)$/.test(e) ||
						  (r = /^(url|email)$/.test(e)
								? inputElem.checkValidity &&
								  inputElem.checkValidity() === !1
								: inputElem.value != o)),
				(inputs[A[i]] = !!r);
		return inputs;
	})(inputtypes);
	const prefixes = ModernizrProto._config.usePrefixes
		? ' -webkit- -moz- -o- -ms- '.split(' ')
		: ['', ''];
	(ModernizrProto._prefixes = prefixes),
		Modernizr.addTest('csscalc', function () {
			const A = 'width:',
				e = 'calc(10px);',
				t = createElement('a');
			return (
				(t.style.cssText = A + prefixes.join(e + A)), !!t.style.length
			);
		}),
		Modernizr.addTest('cubicbezierrange', function () {
			const A = createElement('a');
			return (
				(A.style.cssText = prefixes.join(
					'transition-timing-function:cubic-bezier(1,0,0,1.1); '
				)),
				!!A.style.length
			);
		}),
		Modernizr.addTest('cssgradients', function () {
			for (
				var A,
					e = 'background-image:',
					t =
						'gradient(linear,left top,right bottom,from(#9f9),to(white));',
					r = '',
					n = 0,
					o = prefixes.length - 1;
				o > n;
				n++
			)
				(A = 0 === n ? 'to ' : ''),
					(r +=
						e +
						prefixes[n] +
						'linear-gradient(' +
						A +
						'left top, #9f9, white);');
			Modernizr._config.usePrefixes && (r += e + '-webkit-' + t);
			const i = createElement('a'),
				d = i.style;
			return (
				(d.cssText = r),
				('' + d.backgroundImage).indexOf('gradient') > -1
			);
		}),
		Modernizr.addTest('opacity', function () {
			const A = createElement('a').style;
			return (
				(A.cssText = prefixes.join('opacity:.55;')),
				/^0.55$/.test(A.opacity)
			);
		}),
		Modernizr.addTest('csspositionsticky', function () {
			const A = 'position:',
				e = 'sticky',
				t = createElement('a'),
				r = t.style;
			return (
				(r.cssText =
					A + prefixes.join(e + ';' + A).slice(0, -A.length)),
				-1 !== r.position.indexOf(e)
			);
		});
	const modElem = { elem: createElement('modernizr') };
	Modernizr._q.push(function () {
		delete modElem.elem;
	}),
		Modernizr.addTest('csschunit', function () {
			let A,
				e = modElem.elem.style;
			try {
				(e.fontSize = '3ch'), (A = -1 !== e.fontSize.indexOf('ch'));
			} catch (t) {
				A = !1;
			}
			return A;
		}),
		Modernizr.addTest('cssexunit', function () {
			let A,
				e = modElem.elem.style;
			try {
				(e.fontSize = '3ex'), (A = -1 !== e.fontSize.indexOf('ex'));
			} catch (t) {
				A = !1;
			}
			return A;
		}),
		Modernizr.addTest('hsla', function () {
			const A = createElement('a').style;
			return (
				(A.cssText = 'background-color:hsla(120,40%,100%,.5)'),
				contains(A.backgroundColor, 'rgba') ||
					contains(A.backgroundColor, 'hsla')
			);
		}),
		Modernizr.addTest(
			'strictmode',
			(function () {
				'use strict';
				return !this;
			})()
		),
		Modernizr.addTest('es5undefined', function () {
			let A, e;
			try {
				(e = window.undefined),
					(window.undefined = 12345),
					(A = 'undefined' === typeof window.undefined),
					(window.undefined = e);
			} catch (t) {
				return !1;
			}
			return A;
		}),
		Modernizr.addTest('es5', function () {
			return !!(
				Modernizr.es5array &&
				Modernizr.es5date &&
				Modernizr.es5function &&
				Modernizr.es5object &&
				Modernizr.strictmode &&
				Modernizr.es5string &&
				Modernizr.json &&
				Modernizr.es5syntax &&
				Modernizr.es5undefined
			);
		});
	const inputattrs =
			'autocomplete autofocus list placeholder max min multiple pattern required step'.split(
				' '
			),
		attrs = {};
	(Modernizr.input = (function (A) {
		for (let e = 0, t = A.length; t > e; e++)
			attrs[A[e]] = !!(A[e] in inputElem);
		return (
			attrs.list &&
				(attrs.list = !(
					!createElement('datalist') || !window.HTMLDataListElement
				)),
			attrs
		);
	})(inputattrs)),
		Modernizr.addTest('datalistelem', Modernizr.input.list);
	const toStringFn = {}.toString;
	Modernizr.addTest('svgclippaths', function () {
		return (
			!!document.createElementNS &&
			/SVGClipPath/.test(
				toStringFn.call(
					document.createElementNS(
						'http://www.w3.org/2000/svg',
						'clipPath'
					)
				)
			)
		);
	});
	const testStyles = (ModernizrProto.testStyles = injectElementWithStyles);
	Modernizr.addTest('hiddenscroll', function () {
		return testStyles(
			'#modernizr {width:100px;height:100px;overflow:scroll}',
			function (A) {
				return A.offsetWidth === A.clientWidth;
			}
		);
	}),
		Modernizr.addTest('touchevents', function () {
			let A;
			if (
				'ontouchstart' in window ||
				(window.DocumentTouch && document instanceof DocumentTouch)
			)
				A = !0;
			else {
				const e = [
					'@media (',
					prefixes.join('touch-enabled),('),
					'heartz',
					')',
					'{#modernizr{top:9px;position:absolute}}',
				].join('');
				testStyles(e, function (e) {
					A = 9 === e.offsetTop;
				});
			}
			return A;
		}),
		Modernizr.addTest('checked', function () {
			return testStyles(
				'#modernizr {position:absolute} #modernizr input {margin-left:10px} #modernizr :checked {margin-left:20px;display:block}',
				function (A) {
					const e = createElement('input');
					return (
						e.setAttribute('type', 'checkbox'),
						e.setAttribute('checked', 'checked'),
						A.appendChild(e),
						20 === e.offsetLeft
					);
				}
			);
		}),
		testStyles(
			'#modernizr{display: table; direction: ltr}#modernizr div{display: table-cell; padding: 10px}',
			function (A) {
				let e,
					t = A.childNodes;
				(e = t[0].offsetLeft < t[1].offsetLeft),
					Modernizr.addTest('displaytable', e, {
						aliases: ['display-table'],
					});
			},
			2
		);
	const blacklist = (function () {
		const A = navigator.userAgent,
			e = A.match(/w(eb)?osbrowser/gi),
			t =
				A.match(/windows phone/gi) &&
				A.match(/iemobile\/([0-9])+/gi) &&
				parseFloat(RegExp.$1) >= 9;
		return e || t;
	})();
	blacklist
		? Modernizr.addTest('fontface', !1)
		: testStyles(
				'@font-face {font-family:"font";src:url("https://")}',
				function (A, e) {
					const t = document.getElementById('smodernizr'),
						r = t.sheet || t.styleSheet,
						n = r
							? r.cssRules && r.cssRules[0]
								? r.cssRules[0].cssText
								: r.cssText || ''
							: '',
						o = /src/i.test(n) && 0 === n.indexOf(e.split(' ')[0]);
					Modernizr.addTest('fontface', o);
				}
		  ),
		testStyles(
			'#modernizr{font:0/0 a}#modernizr:after{content:":)";visibility:hidden;font:7px/1 a}',
			function (A) {
				Modernizr.addTest('generatedcontent', A.offsetHeight >= 6);
			}
		),
		Modernizr.addTest('hairline', function () {
			return testStyles(
				'#modernizr {border:.5px solid transparent}',
				function (A) {
					return 1 === A.offsetHeight;
				}
			);
		}),
		Modernizr.addTest('cssinvalid', function () {
			return testStyles(
				'#modernizr input{height:0;border:0;padding:0;margin:0;width:10px} #modernizr input:invalid{width:50px}',
				function (A) {
					const e = createElement('input');
					return (
						(e.required = !0), A.appendChild(e), e.clientWidth > 10
					);
				}
			);
		}),
		testStyles(
			'#modernizr div {width:100px} #modernizr :last-child{width:200px;display:block}',
			function (A) {
				Modernizr.addTest(
					'lastchild',
					A.lastChild.offsetWidth > A.firstChild.offsetWidth
				);
			},
			2
		),
		testStyles(
			'#modernizr div {width:1px} #modernizr div:nth-child(2n) {width:2px;}',
			function (A) {
				for (
					var e = A.getElementsByTagName('div'), t = !0, r = 0;
					5 > r;
					r++
				)
					t = t && e[r].offsetWidth === (r % 2) + 1;
				Modernizr.addTest('nthchild', t);
			},
			5
		),
		testStyles(
			'#modernizr{overflow: scroll; width: 40px; height: 40px; }#' +
				prefixes
					.join('scrollbar{width:10px} #modernizr::')
					.split('#')
					.slice(1)
					.join('#') +
				'scrollbar{width:10px}',
			function (A) {
				Modernizr.addTest(
					'cssscrollbar',
					'scrollWidth' in A && 30 == A.scrollWidth
				);
			}
		),
		Modernizr.addTest('siblinggeneral', function () {
			return testStyles(
				'#modernizr div {width:100px} #modernizr div ~ div {width:200px;display:block}',
				function (A) {
					return 200 == A.lastChild.offsetWidth;
				},
				2
			);
		}),
		testStyles(
			'#modernizr{position: absolute; top: -10em; visibility:hidden; font: normal 10px arial;}#subpixel{float: left; font-size: 33.3333%;}',
			function (A) {
				const e = A.firstChild;
				(e.innerHTML = 'This is a text written in Arial'),
					Modernizr.addTest(
						'subpixelfont',
						window.getComputedStyle
							? '44px' !==
									window
										.getComputedStyle(e, null)
										.getPropertyValue('width')
							: !1
					);
			},
			1,
			['subpixel']
		),
		Modernizr.addTest('cssvalid', function () {
			return testStyles(
				'#modernizr input{height:0;border:0;padding:0;margin:0;width:10px} #modernizr input:valid{width:50px}',
				function (A) {
					const e = createElement('input');
					return A.appendChild(e), e.clientWidth > 10;
				}
			);
		}),
		testStyles('#modernizr { height: 50vh; }', function (A) {
			const e = parseInt(window.innerHeight / 2, 10),
				t = parseInt(computedStyle(A, null, 'height'), 10);
			Modernizr.addTest('cssvhunit', roundedEquals(t, e));
		}),
		testStyles(
			'#modernizr1{width: 50vmax}#modernizr2{width:50px;height:50px;overflow:scroll}#modernizr3{position:fixed;top:0;left:0;bottom:0;right:0}',
			function (A) {
				const e = A.childNodes[2],
					t = A.childNodes[1],
					r = A.childNodes[0],
					n = parseInt((t.offsetWidth - t.clientWidth) / 2, 10),
					o = r.clientWidth / 100,
					i = r.clientHeight / 100,
					d = parseInt(50 * Math.max(o, i), 10),
					a = parseInt(computedStyle(e, null, 'width'), 10);
				Modernizr.addTest(
					'cssvmaxunit',
					roundedEquals(d, a) || roundedEquals(d, a - n)
				);
			},
			3
		),
		testStyles(
			'#modernizr1{width: 50vm;width:50vmin}#modernizr2{width:50px;height:50px;overflow:scroll}#modernizr3{position:fixed;top:0;left:0;bottom:0;right:0}',
			function (A) {
				const e = A.childNodes[2],
					t = A.childNodes[1],
					r = A.childNodes[0],
					n = parseInt((t.offsetWidth - t.clientWidth) / 2, 10),
					o = r.clientWidth / 100,
					i = r.clientHeight / 100,
					d = parseInt(50 * Math.min(o, i), 10),
					a = parseInt(computedStyle(e, null, 'width'), 10);
				Modernizr.addTest(
					'cssvminunit',
					roundedEquals(d, a) || roundedEquals(d, a - n)
				);
			},
			3
		),
		testStyles('#modernizr { width: 50vw; }', function (A) {
			const e = parseInt(window.innerWidth / 2, 10),
				t = parseInt(computedStyle(A, null, 'width'), 10);
			Modernizr.addTest('cssvwunit', roundedEquals(t, e));
		}),
		Modernizr.addTest('details', function () {
			let A,
				e = createElement('details');
			return 'open' in e
				? (testStyles(
						'#modernizr details{display:block}',
						function (t) {
							t.appendChild(e),
								(e.innerHTML = '<summary>a</summary>b'),
								(A = e.offsetHeight),
								(e.open = !0),
								(A = A != e.offsetHeight);
						}
				  ),
				  A)
				: !1;
		}),
		Modernizr.addTest('formvalidation', function () {
			const A = createElement('form');
			if (!('checkValidity' in A && 'addEventListener' in A)) return !1;
			if ('reportValidity' in A) return !0;
			let e,
				t = !1;
			return (
				(Modernizr.formvalidationapi = !0),
				A.addEventListener(
					'submit',
					function (A) {
						(!window.opera || window.operamini) &&
							A.preventDefault(),
							A.stopPropagation();
					},
					!1
				),
				(A.innerHTML =
					'<input name="modTest" required="required" /><button></button>'),
				testStyles(
					'#modernizr form{position:absolute;top:-99999em}',
					function (r) {
						r.appendChild(A),
							(e = A.getElementsByTagName('input')[0]),
							e.addEventListener(
								'invalid',
								function (A) {
									(t = !0),
										A.preventDefault(),
										A.stopPropagation();
								},
								!1
							),
							(Modernizr.formvalidationmessage =
								!!e.validationMessage),
							A.getElementsByTagName('button')[0].click();
					}
				),
				t
			);
		}),
		Modernizr.addTest('localizednumber', function () {
			if (!Modernizr.inputtypes.number) return !1;
			if (!Modernizr.formvalidation) return !1;
			let A,
				e = createElement('div'),
				t = getBody(),
				r = (function () {
					return docElement.insertBefore(
						t,
						docElement.firstElementChild || docElement.firstChild
					);
				})();
			e.innerHTML = '<input type="number" value="1.0" step="0.1"/>';
			const n = e.childNodes[0];
			r.appendChild(e), n.focus();
			try {
				document.execCommand('SelectAll', !1),
					document.execCommand('InsertText', !1, '1,1');
			} catch (o) {}
			return (
				(A =
					'number' === n.type &&
					1.1 === n.valueAsNumber &&
					n.checkValidity()),
				r.removeChild(e),
				t.fake && r.parentNode.removeChild(r),
				A
			);
		});
	const mq = (function () {
		const A = window.matchMedia || window.msMatchMedia;
		return A
			? function (e) {
					const t = A(e);
					return (t && t.matches) || !1;
			  }
			: function (A) {
					let e = !1;
					return (
						injectElementWithStyles(
							'@media ' +
								A +
								' { #modernizr { position: absolute; } }',
							function (A) {
								e =
									'absolute' ==
									(window.getComputedStyle
										? window.getComputedStyle(A, null)
										: A.currentStyle
									).position;
							}
						),
						e
					);
			  };
	})();
	(ModernizrProto.mq = mq), Modernizr.addTest('mediaqueries', mq('only all'));
	var omPrefixes = 'Moz O ms Webkit',
		domPrefixes = ModernizrProto._config.usePrefixes
			? omPrefixes.toLowerCase().split(' ')
			: [];
	(ModernizrProto._domPrefixes = domPrefixes),
		Modernizr.addTest('pointerevents', function () {
			let A = !1,
				e = domPrefixes.length;
			for (A = Modernizr.hasEvent('pointerdown'); e-- && !A; )
				hasEvent(domPrefixes[e] + 'pointerdown') && (A = !0);
			return A;
		}),
		Modernizr.addTest('fileinputdirectory', function () {
			const A = createElement('input'),
				e = 'directory';
			if (((A.type = 'file'), e in A)) return !0;
			for (let t = 0, r = domPrefixes.length; r > t; t++)
				if (domPrefixes[t] + e in A) return !0;
			return !1;
		});
	let hasOwnProp;
	!(function () {
		const A = {}.hasOwnProperty;
		hasOwnProp =
			is(A, 'undefined') || is(A.call, 'undefined')
				? function (A, e) {
						return (
							e in A &&
							is(A.constructor.prototype[e], 'undefined')
						);
				  }
				: function (e, t) {
						return A.call(e, t);
				  };
	})(),
		(ModernizrProto._l = {}),
		(ModernizrProto.on = function (A, e) {
			this._l[A] || (this._l[A] = []),
				this._l[A].push(e),
				Modernizr.hasOwnProperty(A) &&
					setTimeout(function () {
						Modernizr._trigger(A, Modernizr[A]);
					}, 0);
		}),
		(ModernizrProto._trigger = function (A, e) {
			if (this._l[A]) {
				const t = this._l[A];
				setTimeout(function () {
					let A, r;
					for (A = 0; A < t.length; A++) (r = t[A])(e);
				}, 0),
					delete this._l[A];
			}
		}),
		Modernizr._q.push(function () {
			ModernizrProto.addTest = addTest;
		}),
		Modernizr.addAsyncTest(function () {
			function A(t) {
				clearTimeout(e);
				const n = t !== undefined && 'loadeddata' === t.type ? !0 : !1;
				r.removeEventListener('loadeddata', A, !1),
					addTest('audiopreload', n),
					r.parentNode && r.parentNode.removeChild(r);
			}
			var e,
				t = 300,
				r = createElement('audio'),
				n = r.style;
			if (!(Modernizr.audio && 'preload' in r))
				return void addTest('audiopreload', !1);
			(n.position = 'absolute'), (n.height = 0), (n.width = 0);
			try {
				if (Modernizr.audio.mp3)
					r.src =
						'data:audio/mpeg;base64,//MUxAAB6AXgAAAAAPP+c6nf//yi/6f3//MUxAMAAAIAAAjEcH//0fTX6C9Lf//0//MUxA4BeAIAAAAAAKX2/6zv//+IlR4f//MUxBMCMAH8AAAAABYWalVMQU1FMy45//MUxBUB0AH0AAAAADkuM1VVVVVVVVVV//MUxBgBUATowAAAAFVVVVVVVVVVVVVV';
				else if (Modernizr.audio.m4a)
					r.src =
						'data:audio/x-m4a;base64,AAAAGGZ0eXBNNEEgAAACAGlzb21pc28yAAAACGZyZWUAAAAfbWRhdN4EAABsaWJmYWFjIDEuMjgAAAFoAQBHAAACiG1vb3YAAABsbXZoZAAAAAB8JbCAfCWwgAAAA+gAAAAYAAEAAAEAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIAAAG0dHJhawAAAFx0a2hkAAAAD3wlsIB8JbCAAAAAAQAAAAAAAAAYAAAAAAAAAAAAAAAAAQAAAAABAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAABUG1kaWEAAAAgbWRoZAAAAAB8JbCAfCWwgAAArEQAAAQAVcQAAAAAAC1oZGxyAAAAAAAAAABzb3VuAAAAAAAAAAAAAAAAU291bmRIYW5kbGVyAAAAAPttaW5mAAAAEHNtaGQAAAAAAAAAAAAAACRkaW5mAAAAHGRyZWYAAAAAAAAAAQAAAAx1cmwgAAAAAQAAAL9zdGJsAAAAW3N0c2QAAAAAAAAAAQAAAEttcDRhAAAAAAAAAAEAAAAAAAAAAAACABAAAAAArEQAAAAAACdlc2RzAAAAAAMZAAEABBFAFQAAAAABftAAAAAABQISCAYBAgAAABhzdHRzAAAAAAAAAAEAAAABAAAEAAAAABxzdHNjAAAAAAAAAAEAAAABAAAAAQAAAAEAAAAUc3RzegAAAAAAAAAXAAAAAQAAABRzdGNvAAAAAAAAAAEAAAAoAAAAYHVkdGEAAABYbWV0YQAAAAAAAAAhaGRscgAAAAAAAAAAbWRpcmFwcGwAAAAAAAAAAAAAAAAraWxzdAAAACOpdG9vAAAAG2RhdGEAAAABAAAAAExhdmY1Mi42NC4y';
				else if (Modernizr.audio.ogg)
					r.src =
						'data:audio/ogg;base64,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lFJKKaWUUkoppZRSSimllFJKKaWUUkqppJRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoplVJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSCgCQinAAkHowoQwUGrISAEgFAACMUUopxpyDEDHmGGPQSSgpYsw5xhyUklLlHIQQUmktt8o5CCGk1FJtmXNSWosx5hgz56SkFFvNOYdSUoux5ppr7qS0VmuuNedaWqs115xzzbm0FmuuOdecc8sx15xzzjnnGHPOOeecc84FAOA0OACAHtiwOsJJ0VhgoSErAYBUAAACGaUYc8456BBSjDnnHIQQIoUYc845CCFUjDnnHHQQQqgYc8w5CCGEkDnnHIQQQgghcw466CCEEEIHHYQQQgihlM5BCCGEEEooIYQQQgghhBA6CCGEEEIIIYQQQgghhFJKCCGEEEIJoZRQAABggQMAQIANqyOcFI0FFhqyEgAAAgCAHJagUs6EQY5Bjw1BylEzDUJMOdGZYk5qMxVTkDkQnXQSGWpB2V4yCwAAgCAAIMAEEBggKPhCCIgxAABBiMwQCYVVsMCgDBoc5gHAA0SERACQmKBIu7iALgNc0MVdB0IIQhCCWBxAAQk4OOGGJ97whBucoFNU6iAAAAAAAAwA4AEA4KAAIiKaq7C4wMjQ2ODo8AgAAAAAABYA+AAAOD6AiIjmKiwuMDI0Njg6PAIAAAAAAAAAAICAgAAAAAAAQAAAAICAT2dnUwAE7AwAAAAAAAD/QwAAAgAAADuydfsFAQEBAQEACg4ODg==';
				else {
					if (!Modernizr.audio.wav)
						return void addTest('audiopreload', !1);
					r.src =
						'data:audio/wav;base64,UklGRvwZAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YdgZAAAAAAEA/v8CAP//AAABAP////8DAPz/BAD9/wEAAAAAAAAAAAABAP7/AgD//wAAAQD//wAAAQD//wAAAQD+/wIA//8AAAAAAAD//wIA/v8BAAAA//8BAAAA//8BAP//AQAAAP//AQD//wEAAAD//wEA//8BAP//AQD//wEA//8BAP//AQD+/wMA/f8DAP3/AgD+/wIA/////wMA/f8CAP7/AgD+/wMA/f8CAP7/AgD//wAAAAAAAAAAAQD+/wIA/v8CAP7/AwD9/wIA/v8BAAEA/v8CAP7/AQAAAAAAAAD//wEAAAD//wIA/f8DAP7/AQD//wEAAAD//wEA//8CAP7/AQD//wIA/v8CAP7/AQAAAAAAAAD//wEAAAAAAAAA//8BAP//AgD9/wQA+/8FAPz/AgAAAP//AgD+/wEAAAD//wIA/v8CAP3/BAD8/wQA/P8DAP7/AwD8/wQA/P8DAP7/AQAAAAAA//8BAP//AgD+/wEAAAD//wIA/v8BAP//AQD//wEAAAD//wEA//8BAAAAAAAAAP//AgD+/wEAAAAAAAAAAAD//wEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//AgD+/wIA/v8BAP//AQABAP7/AQD//wIA/v8CAP3/AwD/////AgD9/wMA/v8BAP//AQAAAP//AQD//wEA//8BAP//AAABAP//AAABAP//AQD//wAAAAACAP3/AwD9/wIA//8BAP//AQD//wEA//8BAP//AgD9/wMA/v8AAAIA/f8CAAAA/v8EAPv/BAD9/wIAAAD+/wQA+v8HAPr/BAD+/wEAAAD//wIA/f8EAPz/BAD7/wUA/P8EAPz/AwD+/wEAAAD//wEAAAAAAP//AgD8/wUA+/8FAPz/AwD9/wIA//8AAAEA/v8CAP//AQD//wAAAAABAP//AgD9/wMA/f8EAPz/AwD+/wAAAwD7/wUA/P8DAP7/AQAAAP//AgD+/wEAAQD+/wIA/v8BAAEA/v8CAP7/AQAAAP//AgD9/wMA/f8DAP7/AgD+/wEAAAAAAAEA//8AAAEA/v8DAP3/AgD//wEA//8BAP7/AwD9/wMA/v8BAP//AQAAAP//AgD9/wMA/v8BAP//AQAAAP//AgD+/wEAAQD+/wIA/////wIA//8AAAEA/f8DAP//AAABAP////8DAP3/AwD+/wEA//8BAP//AQAAAAAA//8BAP//AQD//wEA//8BAP//AAAAAAEA//8BAP7/AgD//wEA//8AAAAAAAAAAAAAAAD//wIA/v8BAAAA//8BAAEA/v8BAAAA//8DAPz/AwD+/wIA/v8CAP3/AwD+/wEAAAD//wEA//8BAAAA//8BAAAA/v8EAPv/BAD+/wAAAAABAP7/AgD//wAAAAABAP7/AgD//wAAAAAAAAAAAAABAP3/BAD8/wQA/f8BAAAAAAABAP7/AgD+/wIA/v8CAP7/AgD+/wIA/v8BAAAAAAD//wIA/f8DAP7/AAABAP//AAACAPz/BAD9/wIA//8AAP//AwD9/wMA/P8EAP3/AwD9/wIA//8BAP//AQD+/wMA/f8DAP7/AAABAP//AQAAAP//AQD//wIA/f8DAP7/AQAAAP//AQAAAAAA//8CAP7/AQABAP7/AgD+/wEAAQD+/wIA/v8CAP////8CAP7/AgD//wAAAAABAP7/AwD9/wIAAAD+/wMA/f8CAP//AQD+/wMA/f8CAP//AAACAPz/BQD6/wUA/v///wIA/v8CAP3/BAD7/wYA+v8FAPz/AwD/////AgD+/wEAAAD//wEAAAD//wIA/f8DAP7/AQAAAP//AgD//wAA//8BAAAAAAAAAP//AQD//wEA//8AAAIA/f8DAP3/AgAAAP//AQD//wEA//8AAAEA//8BAP////8CAP//AAABAP3/BAD9/wIA/v8BAAEA//8BAP7/AgD//wEA//8AAAEA//8BAP//AAAAAAEA//8BAP7/AgD//wEA//8AAAAAAQD+/wIA/v8BAAAAAAD//wIA/v8BAAAAAAAAAAAAAQD+/wMA/f8CAP//AQD//wIA/f8DAP7/AQD//wEA//8CAP7/AAABAP7/AwD9/wMA/v8AAAEA//8BAAAAAAD//wIA/v8BAAAA//8CAP7/AgD+/wEA//8CAP7/AgD//wAAAAAAAAAAAQD//wEA/v8DAPz/BQD8/wIA//8AAAEAAAD//wEA//8BAP//AQAAAAAA//8BAP//AgD+/wEAAAAAAP//AQD+/wMA/////wEA/v8CAP//AQD//wEA//8AAAEA//8BAAAA/v8EAPz/AwD+/wEAAAAAAAAA//8CAP7/AQD//wEA//8BAP//AAABAP7/AwD9/wIA//8BAP//AQD//wEA//8AAAEA/v8EAPv/BAD9/wIA//8BAP7/AwD9/wIA//8AAAEA//8BAP//AQD//wAAAQD//wEAAAD+/wMA/v8AAAIA/f8DAP7/AQD//wAAAQD+/wMA/f8CAP//AAABAP7/AgD+/wMA/f8CAP7/AQABAP7/AgD+/wIA/v8CAP7/AwD8/wMA//8AAAEA//8AAAAAAAABAP//AQD//wAAAQD//wIA/f8DAP3/AwD+/wAAAgD9/wIA//8AAAEAAAD+/wMA/P8FAPv/BAD9/wIA//8AAP//AgD+/wIA/v8BAAAAAAD//wEAAAAAAP//AQD//wEA//8BAP//AAABAP7/AwD9/wIA//8BAP//AAABAP//AQD//wAAAQD//wEA//8BAP//AAABAAAA//8BAP7/AwD9/wMA/f8DAP3/AgD//wEA//8BAP7/AgD//wAAAgD8/wQA/f8CAP//AQD+/wMA/f8CAP7/AgD//wAAAAAAAAAAAAABAP7/AwD9/wIA/v8DAP3/AwD9/wIA/v8DAPz/BQD7/wQA/f8CAP7/AwD9/wMA/f8CAP//AQAAAP7/AwD+/wEA//8AAAEAAAAAAP//AAABAP//AQAAAP7/AwD9/wMA/f8CAP//AQD//wEA//8AAAIA/f8CAAAA//8BAAAA//8BAAAA/v8EAPv/BAD9/wIA//8AAAEA/v8CAP//AAABAP//AAABAP//AAABAP7/AwD8/wQA/f8CAAAA/v8DAP3/AwD9/wMA/v8BAAAA//8BAAAA//8CAP7/AQAAAAAAAAAAAAAA//8CAP7/AgD+/wIA/v8CAP7/AgD//wAAAQD//wAAAQD//wAAAQD//wAAAQD+/wIA//8AAAAAAQD+/wMA/f8CAP//AQD//wEA//8AAAEA/v8DAP3/AgD//wAAAAABAP7/AwD9/wIA//8AAAEA/v8DAP3/AgD//wAAAAABAP7/AwD8/wMA/v8CAP//AAD//wIA/v8CAP7/AQABAP7/AQAAAP//AgD/////AQD//wEAAAD//wEA/v8EAPv/BAD9/wMA/v8BAAAA//8BAAEA/P8GAPr/BQD8/wMA/v8BAAAA//8CAP7/AQABAP3/BAD7/wYA+/8EAPz/AwD//wEA//8BAP7/BAD8/wMA/v8AAAIA/v8BAAAA//8BAAAA//8BAAAA//8CAP3/AwD+/wAAAgD8/wUA/P8DAP7/AAABAAAAAAD//wEAAAD//wIA/f8DAP7/AQAAAAAAAAAAAAAAAAAAAAAAAAAAAAEA/f8EAPz/AwD/////AgD+/wIA/f8DAP7/AgD+/wEA//8CAP7/AQD//wEAAAAAAP//AQAAAP//AgD9/wMA/v8BAAAA//8BAP//AQAAAP//AAACAP3/BAD7/wQA/v8BAAAA//8BAP//AQAAAP//AQAAAP7/BAD7/wUA+/8EAP3/AgD//wAAAQD+/wIA//8AAAEA/v8CAP//AQD+/wEAAAAAAAAAAAD//wEA//8CAP3/AwD9/wIA//8AAAAAAAAAAAAA//8BAP//AgD+/wEA//8CAP7/AQAAAP//AgD/////AgD/////AgD+/wIA//8AAP//AQABAP7/AgD9/wMA/v8CAP////8BAAAAAAAAAAAA//8CAP////8DAPz/AwD+/wEAAAAAAP//AQD//wEAAAD//wEAAAD+/wQA+/8FAPz/AgAAAP//AgD9/wMA/v8BAAAAAAD//wEAAAD//wIA/v8BAAAAAAD//wIA/v8BAAAA//8BAAAA//8CAP7/AQD//wEA//8BAAAA//8BAP//AAABAP//AQAAAP7/AgD//wEA//8AAAAAAQD+/wMA/P8EAP7///8DAPz/BQD8/wEAAQD+/wMA/v8AAAEA//8BAP//AQD//wEA/v8CAP//AQD//wAAAAABAAAA//8BAP//AQAAAAAA//8BAP//AgD+/wAAAQD//wIA/f8CAP//AQAAAP7/AwD9/wMA/v8BAP//AAABAP//AgD9/wIA//8BAAAA//8BAAAA//8CAP3/AwD+/wEAAAD+/wQA/P8DAP7/AAACAP7/AQAAAP//AQAAAP//AQAAAP//AgD9/wIAAAD//wIA/f8DAP7/AQD//wEA//8CAP7/AQD//wAAAQD//wEA//8AAAAAAQD//wEAAAD9/wUA+/8FAPz/AgD//wAAAQD//wAAAQD+/wMA/f8BAAEA/v8CAP7/AgD+/wIA/v8BAAAAAAAAAAAAAAD//wIA/v8CAP////8CAP7/AgD+/wIA/v8CAP7/AQAAAP//AQAAAP//AQD//wAAAQD//wAAAQD+/wMA/f8CAAAA/v8DAP3/AgAAAP//AQAAAP7/AwD9/wMA/v8BAP//AQD//wEAAAD+/wMA/f8CAAAA/v8CAP//AAAAAAEA//8AAAEA/v8DAP3/AwD9/wIA//8BAP//AgD8/wQA/v8BAAAA/v8CAP//AQD//wAAAAAAAAEA/f8EAPz/BAD9/wIA//8AAAAAAAABAP//AAAAAAAAAAABAP3/BAD9/wIA/v8BAAEA//8AAAAA//8CAP7/AgD9/wQA+/8FAPv/BQD8/wMA/f8DAP3/AwD+/wAAAgD9/wMA/f8CAAAA/v8EAPv/BQD7/wUA/P8DAP///v8DAP3/BAD8/wMA/f8DAP7/AQD//wEAAAD//wEA/v8CAAAA/v8CAP7/AgD//wAAAAAAAAAAAQD+/wIA//8AAAEA/v8DAPz/BAD9/wIA//8AAP//AgD//wEA/v8BAAAAAQD//wAAAAAAAAEA//8AAAEA//8BAP//AAABAP//AQD+/wIA/v8DAPz/BAD8/wQA/f8BAAAAAQD+/wMA/P8DAP//AAAAAAAAAAD//wMA+/8FAP3/AQABAP3/BAD8/wMA/v8BAAAA//8CAP3/AwD+/wEAAQD9/wMA/f8EAPz/BAD7/wQA/v8BAAEA/f8DAP7/AQAAAP//AgD+/wEAAAD//wIA/v8CAP7/AgD+/wEAAQD//wEA/v8CAP7/BAD7/wQA/f8CAAAA//8AAAAAAAABAP//AQD+/wEAAQD+/wMA/f8BAAEA/v8DAPz/AwD/////AwD8/wQA/P8DAP7/AgD//wAA//8BAAAAAAAAAP//AgD+/wEAAAD//wIA/v8BAAAA//8CAP3/AgD//wAAAQD+/wIA/v8BAAAA//8CAP7/AgD+/wEA//8CAP3/BAD7/wQA/v8BAAAA//8AAAEAAAD//wIA/f8DAP7/AgD+/wIA/v8CAP7/AgD+/wEAAAAAAP//AgD9/wMA/v8BAP//AgD9/wMA/v8AAAEA//8BAP//AQD//wEA//8AAAEA/v8EAPz/AgD//wAAAQAAAP//AAABAP//AQD//wEAAAD//wEA//8BAAEA/f8DAP7/AQABAP3/AwD+/wIA/////wEAAAAAAAAAAAD//wIA/v8CAP////8CAP7/AgD//wAA//8CAP3/BAD9/wAAAgD9/wMA/v8BAP//AQAAAP//AQAAAP//AgD9/wMA/f8EAPz/AwD+/wEAAAAAAAAAAAD//wIA/f8EAP3/AAABAAAA//8CAP7/AQAAAP//AQAAAAAA//8BAP//AQAAAP//AQAAAP//AQAAAP//AgD9/wMA/v8BAP//AQAAAP//AQD//wIA/v8CAP3/BAD9/wEAAAD//wEAAQD9/wMA/f8CAAAA/v8DAP3/AgD//wAAAQD+/wIA/v8CAP7/AQAAAP//AgD+/wEAAAAAAP//AwD7/wUA/f8BAAEA/v8BAAEA/v8DAP3/AgD//wEA//8BAP//AQD//wEA//8CAP3/BAD7/wQA/////wIA/v8AAAIA/v8CAP3/BAD7/wUA/P8DAP3/AwD9/wMA/v8AAAIA/v8CAP7/AgD+/wIA//8AAAEA/v8CAP7/AgD//wAAAAD//wEAAAAAAAAA//8BAP7/BAD7/wUA/P8CAAAA//8BAP//AQAAAP//AgD9/wMA/v8BAAAA//8BAAAA//8CAP3/AwD+/wEA//8CAP3/AwD+/wAAAwD8/wIAAAD//wIA/////wIA/v8CAP7/AgD+/wEAAAAAAAAAAAAAAP//AgD+/wIA//8AAAAA//8CAP7/AgD+/wEA//8CAP3/AwD9/wMA/v8BAP7/AwD9/wMA/f8CAP//AQD+/wIA//8BAP//AQD+/wMA/v8BAAAA//8BAAAA//8CAP7/AQAAAP//AgD+/wIA/v8CAP//AAAAAAEA//8BAP//AAABAAAA//8BAP//AQD//wEA//8BAP//AQAAAP//AQD//wEAAAD//wIA/f8CAAAA//8BAAAA//8BAP//AAABAP//AQD//wAAAAAAAAEA/v8CAP//AQD//wAAAAABAP7/AwD9/wIAAAD+/wIA//8BAP//AgD9/wMA/f8DAP7/AgD+/wEAAAAAAAEA/v8CAP7/AgD//wAAAAAAAAAAAAAAAP//AgD/////AgD9/wQA/f8BAAAAAAAAAAEA/f8DAP////8DAP3/AQABAP7/AgD//wAAAQD+/wMA/f8CAP7/AQABAP7/AwD7/wYA+v8FAP3/AQABAP7/AgD+/wMA/f8CAP7/AwD+/wEA//8BAP//AQAAAP7/BQD5/wcA+v8FAPz/AwD+/wIA/v8BAAAA//8DAPv/BQD8/wMA/////wEAAAAAAAAAAAD//wIA/f8DAP7/AQAAAP//AQAAAP//AgD+/wIA/v8BAAEA/f8EAPz/AwD+/wEA//8CAP7/AQD//wEA//8CAP7/AQAAAP//AgD+/wEAAAAAAAAAAAAAAAAAAAD//wIA/f8EAPz/AwD+/wEA//8CAP7/AgD+/wEAAQD+/wEAAQD+/wIA/////wIA//8AAAAAAAAAAAAAAAD//wEAAAAAAP//AgD9/wMA/v8BAP//AQAAAP//AQD//wEA//8BAP//AQD//wEA//8BAP//AQAAAP7/AwD9/wMA/v8BAP7/AwD9/wMA/v8BAP//AAABAP//AQD//wAAAAABAP//AAAAAAAAAQD//wEA/v8CAAAA/v8EAPv/BAD9/wIAAAD+/wMA/P8DAP//AAAAAP//AQD//wIA/f8DAP3/AwD9/wMA/v8BAAAA//8BAAAA//8CAP3/AwD9/wQA+/8FAPv/BQD8/wMA/v8BAAAA//8BAP//AgD+/wEAAAD//wIA/v8BAAEA/f8DAP3/AgAAAP//AQD//wAAAQD//wEA//8BAP//AQD//wEA/v8DAP3/AgAAAP7/AwD9/wIAAAD//wEAAAD//wIA/f8DAP7/AgD9/wQA+/8FAPz/AgAAAP//AgD9/wIA//8BAP//AQD//wEA//8BAP//AQD//wIA/f8DAP3/AgD//wAAAQD+/wIA/v8BAAEA/v8CAP7/AgD+/wMA/P8DAP//AAABAP7/AQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEA/v8CAP3/BAD8/wMA/v8BAAAAAAD//wEAAAAAAAAAAAD//wEAAAAAAAAA//8BAP//AgD+/wEA//8CAP3/AwD9/wMA/f8EAPv/BAD+/wAAAQD//wEA//8BAP//AAABAP//AQD//wEAAAD//wEA//8BAP//AgD9/wMA/v8AAAIA/f8DAP7/AAACAP3/AwD+/wEA//8BAP//AQAAAP//AQAAAP7/AwD9/wMA/v8AAAEA//8BAP//AAAAAAEA//8AAAEA/v8CAP//AAAAAAEA/v8DAPz/BAD9/wEAAQD+/wEAAQD9/wQA/P8DAP7/AQAAAAAAAAAAAAAAAAAAAAAAAQD+/wIA/////wIA/v8BAAAA//8BAP//AQD//wEA//8BAAAA/v8EAPz/AwD///7/BAD8/wMA/////wIA/v8CAP////8CAP7/AgD+/wIA/v8CAP////8CAP7/AwD9/wIA/v8CAP//AAABAP7/AwD9/wEAAQD+/wMA/f8CAP//AAAAAAEA/v8DAPz/BAD9/wIA/v8CAP7/AgD//wAAAAD//wIA/v8CAP7/AQAAAAAA//8CAP7/AgD+/wIA/v8CAP7/AwD8/wUA+v8GAPv/AwD//wAAAAAAAAAA//8DAPv/BQD9/wAAAgD9/wMA/v8BAP//AQAAAP//AgD9/wMA/v8BAAAA//8BAAAAAAAAAP//AQAAAAAAAAD//wEA//8CAP3/AwD+/wAAAgD+/wEAAAD//wIA/v8CAP7/AgD/////AwD8/wUA/P8CAP//AQD//wIA/f8DAP3/AwD+/wAAAQD+/wMA/f8DAP3/AgD//wAAAQD//wEA//8BAP7/AwD+/wEA//8AAAEA//8CAPz/BAD9/wIA//8AAAEA/v8DAPz/BAD9/wIA//8AAAEA/v8CAP7/AgD//wEA/f8EAPz/BAD+////AgD//wAAAQD//wAAAQD//wEA//8BAP7/AwD+/wEA';
				}
			} catch (o) {
				return void addTest('audiopreload', !1);
			}
			r.setAttribute('preload', 'auto'),
				(r.style.cssText = 'display:none'),
				docElement.appendChild(r),
				setTimeout(function () {
					r.addEventListener('loadeddata', A, !1),
						(e = setTimeout(A, t));
				}, 0);
		}),
		Modernizr.addAsyncTest(function () {
			if (!Modernizr.canvas) return !1;
			const A = new Image(),
				e = createElement('canvas'),
				t = e.getContext('2d');
			(A.onload = function () {
				addTest('apng', function () {
					return 'undefined' === typeof e.getContext
						? !1
						: (t.drawImage(A, 0, 0),
						  0 === t.getImageData(0, 0, 1, 1).data[3]);
				});
			}),
				(A.src =
					'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAACGFjVEwAAAABAAAAAcMq2TYAAAANSURBVAiZY2BgYPgPAAEEAQB9ssjfAAAAGmZjVEwAAAAAAAAAAQAAAAEAAAAAAAAAAAD6A+gBAbNU+2sAAAARZmRBVAAAAAEImWNgYGBgAAAABQAB6MzFdgAAAABJRU5ErkJggg==');
		}),
		Modernizr.addAsyncTest(function () {
			const A = new Image();
			(A.onload = A.onerror =
				function () {
					addTest('jpeg2000', 1 == A.width);
				}),
				(A.src =
					'data:image/jp2;base64,/0//UQAyAAAAAAABAAAAAgAAAAAAAAAAAAAABAAAAAQAAAAAAAAAAAAEBwEBBwEBBwEBBwEB/1IADAAAAAEAAAQEAAH/XAAEQED/ZAAlAAFDcmVhdGVkIGJ5IE9wZW5KUEVHIHZlcnNpb24gMi4wLjD/kAAKAAAAAABYAAH/UwAJAQAABAQAAf9dAAUBQED/UwAJAgAABAQAAf9dAAUCQED/UwAJAwAABAQAAf9dAAUDQED/k8+kEAGvz6QQAa/PpBABr994EAk//9k=');
		}),
		Modernizr.addAsyncTest(function () {
			let A,
				e,
				t,
				r = createElement('img'),
				n = 'sizes' in r;
			!n && 'srcset' in r
				? ((e =
						'data:image/gif;base64,R0lGODlhAgABAPAAAP///wAAACH5BAAAAAAALAAAAAACAAEAAAICBAoAOw=='),
				  (A =
						'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=='),
				  (t = function () {
						addTest('sizes', 2 == r.width);
				  }),
				  (r.onload = t),
				  (r.onerror = t),
				  r.setAttribute('sizes', '9px'),
				  (r.srcset = A + ' 1w,' + e + ' 8w'),
				  (r.src = A))
				: addTest('sizes', n);
		}),
		Modernizr.addAsyncTest(function () {
			const A = new Image();
			(A.onerror = function () {
				addTest('webpalpha', !1, { aliases: ['webp-alpha'] });
			}),
				(A.onload = function () {
					addTest('webpalpha', 1 == A.width, {
						aliases: ['webp-alpha'],
					});
				}),
				(A.src =
					'data:image/webp;base64,UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAABBxAR/Q9ERP8DAABWUDggGAAAADABAJ0BKgEAAQADADQlpAADcAD++/1QAA==');
		}),
		Modernizr.addAsyncTest(function () {
			const A = new Image();
			(A.onerror = function () {
				addTest('webplossless', !1, { aliases: ['webp-lossless'] });
			}),
				(A.onload = function () {
					addTest('webplossless', 1 == A.width, {
						aliases: ['webp-lossless'],
					});
				}),
				(A.src =
					'data:image/webp;base64,UklGRh4AAABXRUJQVlA4TBEAAAAvAAAAAAfQ//73v/+BiOh/AAA=');
		}),
		Modernizr.addAsyncTest(function () {
			function A(A, e, t) {
				function r(e) {
					const r = e && 'load' === e.type ? 1 == n.width : !1,
						o = 'webp' === A;
					addTest(A, o && r ? new Boolean(r) : r), t && t(e);
				}
				var n = new Image();
				(n.onerror = r), (n.onload = r), (n.src = e);
			}
			const e = [
					{
						uri: 'data:image/webp;base64,UklGRiQAAABXRUJQVlA4IBgAAAAwAQCdASoBAAEAAwA0JaQAA3AA/vuUAAA=',
						name: 'webp',
					},
					{
						uri: 'data:image/webp;base64,UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAABBxAR/Q9ERP8DAABWUDggGAAAADABAJ0BKgEAAQADADQlpAADcAD++/1QAA==',
						name: 'webp.alpha',
					},
					{
						uri: 'data:image/webp;base64,UklGRlIAAABXRUJQVlA4WAoAAAASAAAAAAAAAAAAQU5JTQYAAAD/////AABBTk1GJgAAAAAAAAAAAAAAAAAAAGQAAABWUDhMDQAAAC8AAAAQBxAREYiI/gcA',
						name: 'webp.animation',
					},
					{
						uri: 'data:image/webp;base64,UklGRh4AAABXRUJQVlA4TBEAAAAvAAAAAAfQ//73v/+BiOh/AAA=',
						name: 'webp.lossless',
					},
				],
				t = e.shift();
			A(t.name, t.uri, function (t) {
				if (t && 'load' === t.type)
					for (let r = 0; r < e.length; r++) A(e[r].name, e[r].uri);
			});
		}),
		Modernizr.addTest('hovermq', mq('(hover)')),
		Modernizr.addTest(
			'svgasimg',
			document.implementation.hasFeature(
				'http://www.w3.org/TR/SVG11/feature#Image',
				'1.1'
			)
		),
		Modernizr.addAsyncTest(function () {
			function A() {
				const A = new Image();
				(A.onerror = function () {
					addTest('datauri', !0),
						(Modernizr.datauri = new Boolean(!0)),
						(Modernizr.datauri.over32kb = !1);
				}),
					(A.onload = function () {
						addTest('datauri', !0),
							(Modernizr.datauri = new Boolean(!0)),
							(Modernizr.datauri.over32kb =
								1 == A.width && 1 == A.height);
					});
				for (
					var e = 'R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==';
					e.length < 33e3;

				)
					e = '\r\n' + e;
				A.src = 'data:image/gif;base64,' + e;
			}
			-1 !== navigator.userAgent.indexOf('MSIE 7.') &&
				setTimeout(function () {
					addTest('datauri', !1);
				}, 10);
			const e = new Image();
			(e.onerror = function () {
				addTest('datauri', !1);
			}),
				(e.onload = function () {
					1 == e.width && 1 == e.height
						? A()
						: addTest('datauri', !1);
				}),
				(e.src =
					'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');
		}),
		Modernizr.addAsyncTest(function () {
			function A(i) {
				n++, clearTimeout(e);
				const d = (i && 'playing' === i.type) || 0 !== o.currentTime;
				return !d && r > n
					? void (e = setTimeout(A, t))
					: (o.removeEventListener('playing', A, !1),
					  addTest('videoautoplay', d),
					  void (o.parentNode && o.parentNode.removeChild(o)));
			}
			var e,
				t = 200,
				r = 5,
				n = 0,
				o = createElement('video'),
				i = o.style;
			if (!(Modernizr.video && 'autoplay' in o))
				return void addTest('videoautoplay', !1);
			(i.position = 'absolute'), (i.height = 0), (i.width = 0);
			try {
				if (Modernizr.video.ogg)
					o.src =
						'data:video/ogg;base64,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';
				else {
					if (!Modernizr.video.h264)
						return void addTest('videoautoplay', !1);
					o.src =
						'data:video/mp4;base64,AAAAIGZ0eXBpc29tAAACAGlzb21pc28yYXZjMW1wNDEAAAAIZnJlZQAAAs1tZGF0AAACrgYF//+q3EXpvebZSLeWLNgg2SPu73gyNjQgLSBjb3JlIDE0OCByMjYwMSBhMGNkN2QzIC0gSC4yNjQvTVBFRy00IEFWQyBjb2RlYyAtIENvcHlsZWZ0IDIwMDMtMjAxNSAtIGh0dHA6Ly93d3cudmlkZW9sYW4ub3JnL3gyNjQuaHRtbCAtIG9wdGlvbnM6IGNhYmFjPTEgcmVmPTMgZGVibG9jaz0xOjA6MCBhbmFseXNlPTB4MzoweDExMyBtZT1oZXggc3VibWU9NyBwc3k9MSBwc3lfcmQ9MS4wMDowLjAwIG1peGVkX3JlZj0xIG1lX3JhbmdlPTE2IGNocm9tYV9tZT0xIHRyZWxsaXM9MSA4eDhkY3Q9MSBjcW09MCBkZWFkem9uZT0yMSwxMSBmYXN0X3Bza2lwPTEgY2hyb21hX3FwX29mZnNldD0tMiB0aHJlYWRzPTEgbG9va2FoZWFkX3RocmVhZHM9MSBzbGljZWRfdGhyZWFkcz0wIG5yPTAgZGVjaW1hdGU9MSBpbnRlcmxhY2VkPTAgYmx1cmF5X2NvbXBhdD0wIGNvbnN0cmFpbmVkX2ludHJhPTAgYmZyYW1lcz0zIGJfcHlyYW1pZD0yIGJfYWRhcHQ9MSBiX2JpYXM9MCBkaXJlY3Q9MSB3ZWlnaHRiPTEgb3Blbl9nb3A9MCB3ZWlnaHRwPTIga2V5aW50PTI1MCBrZXlpbnRfbWluPTEwIHNjZW5lY3V0PTQwIGludHJhX3JlZnJlc2g9MCByY19sb29rYWhlYWQ9NDAgcmM9Y3JmIG1idHJlZT0xIGNyZj0yMy4wIHFjb21wPTAuNjAgcXBtaW49MCBxcG1heD02OSBxcHN0ZXA9NCBpcF9yYXRpbz0xLjQwIGFxPTE6MS4wMACAAAAAD2WIhAA3//728P4FNjuZQQAAAu5tb292AAAAbG12aGQAAAAAAAAAAAAAAAAAAAPoAAAAZAABAAABAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACAAACGHRyYWsAAABcdGtoZAAAAAMAAAAAAAAAAAAAAAEAAAAAAAAAZAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAEAAAAAAAgAAAAIAAAAAACRlZHRzAAAAHGVsc3QAAAAAAAAAAQAAAGQAAAAAAAEAAAAAAZBtZGlhAAAAIG1kaGQAAAAAAAAAAAAAAAAAACgAAAAEAFXEAAAAAAAtaGRscgAAAAAAAAAAdmlkZQAAAAAAAAAAAAAAAFZpZGVvSGFuZGxlcgAAAAE7bWluZgAAABR2bWhkAAAAAQAAAAAAAAAAAAAAJGRpbmYAAAAcZHJlZgAAAAAAAAABAAAADHVybCAAAAABAAAA+3N0YmwAAACXc3RzZAAAAAAAAAABAAAAh2F2YzEAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAgACAEgAAABIAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAY//8AAAAxYXZjQwFkAAr/4QAYZ2QACqzZX4iIhAAAAwAEAAADAFA8SJZYAQAGaOvjyyLAAAAAGHN0dHMAAAAAAAAAAQAAAAEAAAQAAAAAHHN0c2MAAAAAAAAAAQAAAAEAAAABAAAAAQAAABRzdHN6AAAAAAAAAsUAAAABAAAAFHN0Y28AAAAAAAAAAQAAADAAAABidWR0YQAAAFptZXRhAAAAAAAAACFoZGxyAAAAAAAAAABtZGlyYXBwbAAAAAAAAAAAAAAAAC1pbHN0AAAAJal0b28AAAAdZGF0YQAAAAEAAAAATGF2ZjU2LjQwLjEwMQ==';
				}
			} catch (d) {
				return void addTest('videoautoplay', !1);
			}
			o.setAttribute('autoplay', ''),
				(i.cssText = 'display:none'),
				docElement.appendChild(o),
				setTimeout(function () {
					o.addEventListener('playing', A, !1),
						(e = setTimeout(A, t));
				}, 0);
		});
	var cssomPrefixes = ModernizrProto._config.usePrefixes
		? omPrefixes.split(' ')
		: [];
	ModernizrProto._cssomPrefixes = cssomPrefixes;
	const atRule = function (A) {
		let e,
			t = prefixes.length,
			r = window.CSSRule;
		if ('undefined' === typeof r) return undefined;
		if (!A) return !1;
		if (
			((A = A.replace(/^@/, '')),
			(e = A.replace(/-/g, '_').toUpperCase() + '_RULE'),
			e in r)
		)
			return '@' + A;
		for (let n = 0; t > n; n++) {
			const o = prefixes[n],
				i = o.toUpperCase() + '_' + e;
			if (i in r) return '@-' + o.toLowerCase() + '-' + A;
		}
		return !1;
	};
	ModernizrProto.atRule = atRule;
	var mStyle = { style: modElem.elem.style };
	Modernizr._q.unshift(function () {
		delete mStyle.style;
	});
	const testProp = (ModernizrProto.testProp = function (A, e, t) {
		return testProps([A], undefined, e, t);
	});
	Modernizr.addTest('textshadow', testProp('textShadow', '1px 1px')),
		(ModernizrProto.testAllProps = testPropsAll);
	const prefixed = (ModernizrProto.prefixed = function (A, e, t) {
		return 0 === A.indexOf('@')
			? atRule(A)
			: (-1 != A.indexOf('-') && (A = cssToDOM(A)),
			  e ? testPropsAll(A, e, t) : testPropsAll(A, 'pfx'));
	});
	Modernizr.addTest(
		'fullscreen',
		!(
			!prefixed('exitFullscreen', document, !1) &&
			!prefixed('cancelFullScreen', document, !1)
		)
	),
		Modernizr.addTest('pagevisibility', !!prefixed('hidden', document, !1)),
		Modernizr.addTest(
			'backgroundblendmode',
			prefixed('backgroundBlendMode', 'text')
		),
		Modernizr.addTest('objectfit', !!prefixed('objectFit'), {
			aliases: ['object-fit'],
		}),
		Modernizr.addTest(
			'filesystem',
			!!prefixed('requestFileSystem', window)
		),
		Modernizr.addTest('regions', function () {
			if (isSVG) return !1;
			let A = prefixed('flowFrom'),
				e = prefixed('flowInto'),
				t = !1;
			if (!A || !e) return t;
			let r = createElement('iframe'),
				n = createElement('div'),
				o = createElement('div'),
				i = createElement('div'),
				d = 'modernizr_flow_for_regions_check';
			(o.innerText = 'M'),
				(n.style.cssText = 'top: 150px; left: 150px; padding: 0px;'),
				(i.style.cssText = 'width: 50px; height: 50px; padding: 42px;'),
				(i.style[A] = d),
				n.appendChild(o),
				n.appendChild(i),
				docElement.appendChild(n);
			let a,
				s,
				l = o.getBoundingClientRect();
			return (
				(o.style[e] = d),
				(a = o.getBoundingClientRect()),
				(s = parseInt(a.left - l.left, 10)),
				docElement.removeChild(n),
				42 == s
					? (t = !0)
					: (docElement.appendChild(r),
					  (l = r.getBoundingClientRect()),
					  (r.style[e] = d),
					  (a = r.getBoundingClientRect()),
					  l.height > 0 &&
							l.height !== a.height &&
							0 === a.height &&
							(t = !0)),
				(o = i = n = r = undefined),
				t
			);
		}),
		Modernizr.addTest('wrapflow', function () {
			const A = prefixed('wrapFlow');
			if (!A || isSVG) return !1;
			let e = A.replace(/([A-Z])/g, function (A, e) {
					return '-' + e.toLowerCase();
				}).replace(/^ms-/, '-ms-'),
				t = createElement('div'),
				r = createElement('div'),
				n = createElement('span');
			(r.style.cssText =
				'position: absolute; left: 50px; width: 100px; height: 20px;' +
				e +
				':end;'),
				(n.innerText = 'X'),
				t.appendChild(r),
				t.appendChild(n),
				docElement.appendChild(t);
			const o = n.offsetLeft;
			return docElement.removeChild(t), (r = n = t = undefined), 150 == o;
		}),
		(ModernizrProto.testAllProps = testAllProps),
		Modernizr.addTest(
			'ligatures',
			testAllProps('fontFeatureSettings', '"liga" 1')
		),
		Modernizr.addTest(
			'cssanimations',
			testAllProps('animationName', 'a', !0)
		),
		Modernizr.addTest('appearance', testAllProps('appearance')),
		Modernizr.addTest('backdropfilter', testAllProps('backdropFilter')),
		Modernizr.addTest('backgroundcliptext', function () {
			return testAllProps('backgroundClip', 'text');
		}),
		Modernizr.addTest('bgpositionxy', function () {
			return (
				testAllProps('backgroundPositionX', '3px', !0) &&
				testAllProps('backgroundPositionY', '5px', !0)
			);
		}),
		Modernizr.addTest(
			'bgrepeatround',
			testAllProps('backgroundRepeat', 'round')
		),
		Modernizr.addTest(
			'bgrepeatspace',
			testAllProps('backgroundRepeat', 'space')
		),
		Modernizr.addTest(
			'backgroundsize',
			testAllProps('backgroundSize', '100%', !0)
		),
		Modernizr.addTest(
			'bgsizecover',
			testAllProps('backgroundSize', 'cover')
		),
		Modernizr.addTest(
			'borderimage',
			testAllProps('borderImage', 'url() 1', !0)
		),
		Modernizr.addTest(
			'borderradius',
			testAllProps('borderRadius', '0px', !0)
		),
		Modernizr.addTest(
			'boxshadow',
			testAllProps('boxShadow', '1px 1px', !0)
		),
		Modernizr.addTest(
			'boxsizing',
			testAllProps('boxSizing', 'border-box', !0) &&
				(document.documentMode === undefined ||
					document.documentMode > 7)
		),
		(function () {
			Modernizr.addTest('csscolumns', function () {
				let A = !1,
					e = testAllProps('columnCount');
				try {
					(A = !!e), A && (A = new Boolean(A));
				} catch (t) {}
				return A;
			});
			for (
				var A,
					e,
					t = [
						'Width',
						'Span',
						'Fill',
						'Gap',
						'Rule',
						'RuleColor',
						'RuleStyle',
						'RuleWidth',
						'BreakBefore',
						'BreakAfter',
						'BreakInside',
					],
					r = 0;
				r < t.length;
				r++
			)
				(A = t[r].toLowerCase()),
					(e = testAllProps('column' + t[r])),
					('breakbefore' === A ||
						'breakafter' === A ||
						'breakinside' == A) &&
						(e = e || testAllProps(t[r])),
					Modernizr.addTest('csscolumns.' + A, e);
		})(),
		Modernizr.addTest(
			'cssgridlegacy',
			testAllProps('grid-columns', '10px', !0)
		),
		Modernizr.addTest(
			'cssgrid',
			testAllProps('grid-template-rows', 'none', !0)
		),
		Modernizr.addTest('displayrunin', testAllProps('display', 'run-in'), {
			aliases: ['display-runin'],
		}),
		Modernizr.addTest('ellipsis', testAllProps('textOverflow', 'ellipsis')),
		Modernizr.addTest('cssfilters', function () {
			if (Modernizr.supports) return testAllProps('filter', 'blur(2px)');
			const A = createElement('a');
			return (
				(A.style.cssText = prefixes.join('filter:blur(2px); ')),
				!!A.style.length &&
					(document.documentMode === undefined ||
						document.documentMode > 9)
			);
		}),
		Modernizr.addTest('flexbox', testAllProps('flexBasis', '1px', !0)),
		Modernizr.addTest(
			'flexboxtweener',
			testAllProps('flexAlign', 'end', !0)
		),
		Modernizr.addTest('flexwrap', testAllProps('flexWrap', 'wrap', !0)),
		Modernizr.addTest(
			'cssmask',
			testAllProps('maskRepeat', 'repeat-x', !0)
		),
		Modernizr.addTest(
			'overflowscrolling',
			testAllProps('overflowScrolling', 'touch', !0)
		),
		Modernizr.addTest('scrollsnappoints', testAllProps('scrollSnapType')),
		Modernizr.addTest(
			'shapes',
			testAllProps('shapeOutside', 'content-box', !0)
		),
		Modernizr.addTest('textalignlast', testAllProps('textAlignLast')),
		Modernizr.addTest(
			'cssreflections',
			testAllProps('boxReflect', 'above', !0)
		),
		Modernizr.addTest('cssresize', testAllProps('resize', 'both', !0)),
		Modernizr.addTest('csstransforms', function () {
			return (
				-1 === navigator.userAgent.indexOf('Android 2.') &&
				testAllProps('transform', 'scale(1)', !0)
			);
		}),
		Modernizr.addTest(
			'variablefonts',
			testAllProps('fontVariationSettings')
		),
		Modernizr.addTest(
			'csstransitions',
			testAllProps('transition', 'all', !0)
		),
		Modernizr.addTest('csspseudotransitions', function () {
			let A = !1;
			if (!Modernizr.csstransitions || !window.getComputedStyle) return A;
			const e =
				'#modernizr:before { content:" "; font-size:5px;' +
				Modernizr._prefixes.join('transition:0s 100s;') +
				'}#modernizr.trigger:before { font-size:10px; }';
			return (
				Modernizr.testStyles(e, function (e) {
					window
						.getComputedStyle(e, ':before')
						.getPropertyValue('font-size'),
						(e.className += 'trigger'),
						(A =
							'5px' ===
							window
								.getComputedStyle(e, ':before')
								.getPropertyValue('font-size'));
				}),
				A
			);
		}),
		testRunner(),
		setClasses(classes),
		delete ModernizrProto.addTest,
		delete ModernizrProto.addAsyncTest;
	for (let i = 0; i < Modernizr._q.length; i++) Modernizr._q[i]();
	window.Modernizr = Modernizr;
})(window, document);

rwp = __webpack_exports__;
/******/ })()
;
//# sourceMappingURL=rwp-modernizr.js.map