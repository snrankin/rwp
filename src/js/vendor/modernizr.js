/*! modernizr 3.6.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-audio-hairline-history-hovermq-objectfit-picture-video-willchange-setclasses !*/
!(function (e, n, t) {
	function r(e) {
		var n = _.className,
			t = Modernizr._config.classPrefix || '';
		if ((x && (n = n.baseVal), Modernizr._config.enableJSClass)) {
			var r = new RegExp('(^|\\s)' + t + 'no-js(\\s|$)');
			n = n.replace(r, '$1' + t + 'js$2');
		}
		Modernizr._config.enableClasses && ((n += ' ' + t + e.join(' ' + t)), x ? (_.className.baseVal = n) : (_.className = n));
	}
	function o(e, n) {
		return typeof e === n;
	}
	function i() {
		var e, n, t, r, i, a, s;
		for (var l in C)
			if (C.hasOwnProperty(l)) {
				if (((e = []), (n = C[l]), n.name && (e.push(n.name.toLowerCase()), n.options && n.options.aliases && n.options.aliases.length))) for (t = 0; t < n.options.aliases.length; t++) e.push(n.options.aliases[t].toLowerCase());
				for (r = o(n.fn, 'function') ? n.fn() : n.fn, i = 0; i < e.length; i++) (a = e[i]), (s = a.split('.')), 1 === s.length ? (Modernizr[s[0]] = r) : (!Modernizr[s[0]] || Modernizr[s[0]] instanceof Boolean || (Modernizr[s[0]] = new Boolean(Modernizr[s[0]])), (Modernizr[s[0]][s[1]] = r)), w.push((r ? '' : 'no-') + s.join('-'));
			}
	}
	function a() {
		return 'function' != typeof n.createElement ? n.createElement(arguments[0]) : x ? n.createElementNS.call(n, 'http://www.w3.org/2000/svg', arguments[0]) : n.createElement.apply(n, arguments);
	}
	function s(e, n) {
		if ('object' == typeof e) for (var t in e) P(e, t) && s(t, e[t]);
		else {
			e = e.toLowerCase();
			var o = e.split('.'),
				i = Modernizr[o[0]];
			if ((2 == o.length && (i = i[o[1]]), 'undefined' != typeof i)) return Modernizr;
			(n = 'function' == typeof n ? n() : n), 1 == o.length ? (Modernizr[o[0]] = n) : (!Modernizr[o[0]] || Modernizr[o[0]] instanceof Boolean || (Modernizr[o[0]] = new Boolean(Modernizr[o[0]])), (Modernizr[o[0]][o[1]] = n)), r([(n && 0 != n ? '' : 'no-') + o.join('-')]), Modernizr._trigger(e, n);
		}
		return Modernizr;
	}
	function l(e) {
		return e
			.replace(/([a-z])-([a-z])/g, function (e, n, t) {
				return n + t.toUpperCase();
			})
			.replace(/^-/, '');
	}
	function u() {
		var e = n.body;
		return e || ((e = a(x ? 'svg' : 'body')), (e.fake = !0)), e;
	}
	function c(e, t, r, o) {
		var i,
			s,
			l,
			c,
			f = 'modernizr',
			d = a('div'),
			p = u();
		if (parseInt(r, 10)) for (; r--; ) (l = a('div')), (l.id = o ? o[r] : f + (r + 1)), d.appendChild(l);
		return (i = a('style')), (i.type = 'text/css'), (i.id = 's' + f), (p.fake ? p : d).appendChild(i), p.appendChild(d), i.styleSheet ? (i.styleSheet.cssText = e) : i.appendChild(n.createTextNode(e)), (d.id = f), p.fake && ((p.style.background = ''), (p.style.overflow = 'hidden'), (c = _.style.overflow), (_.style.overflow = 'hidden'), _.appendChild(p)), (s = t(d, e)), p.fake ? (p.parentNode.removeChild(p), (_.style.overflow = c), _.offsetHeight) : d.parentNode.removeChild(d), !!s;
	}
	function f(e, n) {
		return !!~('' + e).indexOf(n);
	}
	function d(e, n) {
		return function () {
			return e.apply(n, arguments);
		};
	}
	function p(e, n, t) {
		var r;
		for (var i in e) if (e[i] in n) return t === !1 ? e[i] : ((r = n[e[i]]), o(r, 'function') ? d(r, t || n) : r);
		return !1;
	}
	function y(e) {
		return e
			.replace(/([A-Z])/g, function (e, n) {
				return '-' + n.toLowerCase();
			})
			.replace(/^ms-/, '-ms-');
	}
	function v(n, t, r) {
		var o;
		if ('getComputedStyle' in e) {
			o = getComputedStyle.call(e, n, t);
			var i = e.console;
			if (null !== o) r && (o = o.getPropertyValue(r));
			else if (i) {
				var a = i.error ? 'error' : 'log';
				i[a].call(i, 'getComputedStyle returning null, its possible modernizr test results are inaccurate');
			}
		} else o = !t && n.currentStyle && n.currentStyle[r];
		return o;
	}
	function m(n, r) {
		var o = n.length;
		if ('CSS' in e && 'supports' in e.CSS) {
			for (; o--; ) if (e.CSS.supports(y(n[o]), r)) return !0;
			return !1;
		}
		if ('CSSSupportsRule' in e) {
			for (var i = []; o--; ) i.push('(' + y(n[o]) + ':' + r + ')');
			return (
				(i = i.join(' or ')),
				c('@supports (' + i + ') { #modernizr { position: absolute; } }', function (e) {
					return 'absolute' == v(e, null, 'position');
				})
			);
		}
		return t;
	}
	function h(e, n, r, i) {
		function s() {
			c && (delete L.style, delete L.modElem);
		}
		if (((i = o(i, 'undefined') ? !1 : i), !o(r, 'undefined'))) {
			var u = m(e, r);
			if (!o(u, 'undefined')) return u;
		}
		for (var c, d, p, y, v, h = ['modernizr', 'tspan', 'samp']; !L.style && h.length; ) (c = !0), (L.modElem = a(h.shift())), (L.style = L.modElem.style);
		for (p = e.length, d = 0; p > d; d++)
			if (((y = e[d]), (v = L.style[y]), f(y, '-') && (y = l(y)), L.style[y] !== t)) {
				if (i || o(r, 'undefined')) return s(), 'pfx' == n ? y : !0;
				try {
					L.style[y] = r;
				} catch (g) {}
				if (L.style[y] != v) return s(), 'pfx' == n ? y : !0;
			}
		return s(), !1;
	}
	function g(e, n, t, r, i) {
		var a = e.charAt(0).toUpperCase() + e.slice(1),
			s = (e + ' ' + O.join(a + ' ') + a).split(' ');
		return o(n, 'string') || o(n, 'undefined') ? h(s, n, r, i) : ((s = (e + ' ' + j.join(a + ' ') + a).split(' ')), p(s, n, t));
	}
	var w = [],
		C = [],
		T = {
			_version: '3.6.0',
			_config: { classPrefix: '', enableClasses: !0, enableJSClass: !0, usePrefixes: !0 },
			_q: [],
			on: function (e, n) {
				var t = this;
				setTimeout(function () {
					n(t[e]);
				}, 0);
			},
			addTest: function (e, n, t) {
				C.push({ name: e, fn: n, options: t });
			},
			addAsyncTest: function (e) {
				C.push({ name: null, fn: e });
			},
		},
		Modernizr = function () {};
	(Modernizr.prototype = T),
		(Modernizr = new Modernizr()),
		Modernizr.addTest('history', function () {
			var n = navigator.userAgent;
			return (-1 === n.indexOf('Android 2.') && -1 === n.indexOf('Android 4.0')) || -1 === n.indexOf('Mobile Safari') || -1 !== n.indexOf('Chrome') || -1 !== n.indexOf('Windows Phone') || 'file:' === location.protocol ? e.history && 'pushState' in e.history : !1;
		}),
		Modernizr.addTest('picture', 'HTMLPictureElement' in e);
	var _ = n.documentElement;
	Modernizr.addTest('willchange', 'willChange' in _.style);
	var x = 'svg' === _.nodeName.toLowerCase();
	Modernizr.addTest('video', function () {
		var e = a('video'),
			n = !1;
		try {
			(n = !!e.canPlayType), n && ((n = new Boolean(n)), (n.ogg = e.canPlayType('video/ogg; codecs="theora"').replace(/^no$/, '')), (n.h264 = e.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/, '')), (n.webm = e.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/, '')), (n.vp9 = e.canPlayType('video/webm; codecs="vp9"').replace(/^no$/, '')), (n.hls = e.canPlayType('application/x-mpegURL; codecs="avc1.42E01E"').replace(/^no$/, '')));
		} catch (t) {}
		return n;
	});
	var P;
	!(function () {
		var e = {}.hasOwnProperty;
		P =
			o(e, 'undefined') || o(e.call, 'undefined')
				? function (e, n) {
						return n in e && o(e.constructor.prototype[n], 'undefined');
				  }
				: function (n, t) {
						return e.call(n, t);
				  };
	})(),
		(T._l = {}),
		(T.on = function (e, n) {
			this._l[e] || (this._l[e] = []),
				this._l[e].push(n),
				Modernizr.hasOwnProperty(e) &&
					setTimeout(function () {
						Modernizr._trigger(e, Modernizr[e]);
					}, 0);
		}),
		(T._trigger = function (e, n) {
			if (this._l[e]) {
				var t = this._l[e];
				setTimeout(function () {
					var e, r;
					for (e = 0; e < t.length; e++) (r = t[e])(n);
				}, 0),
					delete this._l[e];
			}
		}),
		Modernizr._q.push(function () {
			T.addTest = s;
		});
	var S = (T.testStyles = c);
	Modernizr.addTest('hairline', function () {
		return S('#modernizr {border:.5px solid transparent}', function (e) {
			return 1 === e.offsetHeight;
		});
	});
	var b = (function () {
		var n = e.matchMedia || e.msMatchMedia;
		return n
			? function (e) {
					var t = n(e);
					return (t && t.matches) || !1;
			  }
			: function (n) {
					var t = !1;
					return (
						c('@media ' + n + ' { #modernizr { position: absolute; } }', function (n) {
							t = 'absolute' == (e.getComputedStyle ? e.getComputedStyle(n, null) : n.currentStyle).position;
						}),
						t
					);
			  };
	})();
	(T.mq = b), Modernizr.addTest('hovermq', b('(hover)'));
	var E = 'Moz O ms Webkit',
		O = T._config.usePrefixes ? E.split(' ') : [];
	T._cssomPrefixes = O;
	var $ = function (n) {
		var r,
			o = prefixes.length,
			i = e.CSSRule;
		if ('undefined' == typeof i) return t;
		if (!n) return !1;
		if (((n = n.replace(/^@/, '')), (r = n.replace(/-/g, '_').toUpperCase() + '_RULE'), r in i)) return '@' + n;
		for (var a = 0; o > a; a++) {
			var s = prefixes[a],
				l = s.toUpperCase() + '_' + r;
			if (l in i) return '@-' + s.toLowerCase() + '-' + n;
		}
		return !1;
	};
	T.atRule = $;
	var j = T._config.usePrefixes ? E.toLowerCase().split(' ') : [];
	T._domPrefixes = j;
	var z = { elem: a('modernizr') };
	Modernizr._q.push(function () {
		delete z.elem;
	});
	var L = { style: z.elem.style };
	Modernizr._q.unshift(function () {
		delete L.style;
	}),
		(T.testAllProps = g);
	var N = (T.prefixed = function (e, n, t) {
		return 0 === e.indexOf('@') ? $(e) : (-1 != e.indexOf('-') && (e = l(e)), n ? g(e, n, t) : g(e, 'pfx'));
	});
	Modernizr.addTest('objectfit', !!N('objectFit'), { aliases: ['object-fit'] }),
		Modernizr.addTest('audio', function () {
			var e = a('audio'),
				n = !1;
			try {
				(n = !!e.canPlayType), n && ((n = new Boolean(n)), (n.ogg = e.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/, '')), (n.mp3 = e.canPlayType('audio/mpeg; codecs="mp3"').replace(/^no$/, '')), (n.opus = e.canPlayType('audio/ogg; codecs="opus"') || e.canPlayType('audio/webm; codecs="opus"').replace(/^no$/, '')), (n.wav = e.canPlayType('audio/wav; codecs="1"').replace(/^no$/, '')), (n.m4a = (e.canPlayType('audio/x-m4a;') || e.canPlayType('audio/aac;')).replace(/^no$/, '')));
			} catch (t) {}
			return n;
		}),
		i(),
		r(w),
		delete T.addTest,
		delete T.addAsyncTest;
	for (var q = 0; q < Modernizr._q.length; q++) Modernizr._q[q]();
	e.Modernizr = Modernizr;
})(window, document);
