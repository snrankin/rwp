/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("jQuery"), require("lodash"));
	else if(typeof define === 'function' && define.amd)
		define(["jQuery", "lodash"], factory);
	else if(typeof exports === 'object')
		exports["rwp"] = factory(require("jQuery"), require("lodash"));
	else
		root["rwp"] = factory(root["jQuery"], root["_"]);
})(self, function(__WEBPACK_EXTERNAL_MODULE_jquery__, __WEBPACK_EXTERNAL_MODULE_lodash__) {
return /******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./js/app.js":
/*!*******************!*\
  !*** ./js/app.js ***!
  \*******************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"camelCase\": function() { return /* binding */ camelCase; },\n/* harmony export */   \"changeTag\": function() { return /* binding */ changeTag; },\n/* harmony export */   \"toggleFocus\": function() { return /* binding */ toggleFocus; },\n/* harmony export */   \"screenSize\": function() { return /* binding */ screenSize; },\n/* harmony export */   \"skipLink\": function() { return /* binding */ skipLink; },\n/* harmony export */   \"isEmpty\": function() { return /* binding */ isEmpty; },\n/* harmony export */   \"toggleNav\": function() { return /* binding */ toggleNav; },\n/* harmony export */   \"getTallest\": function() { return /* binding */ getTallest; },\n/* harmony export */   \"matchHeights\": function() { return /* binding */ matchHeights; },\n/* harmony export */   \"bsAtts\": function() { return /* binding */ bsAtts; },\n/* harmony export */   \"logCustomProperties\": function() { return /* binding */ logCustomProperties; },\n/* harmony export */   \"actual\": function() { return /* reexport safe */ actual__WEBPACK_IMPORTED_MODULE_2__.actual; },\n/* harmony export */   \"verge\": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.verge; }\n/* harmony export */ });\n/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/toConsumableArray */ \"../../node_modules/@babel/runtime/helpers/esm/toConsumableArray.js\");\n/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ \"../../node_modules/@babel/runtime/helpers/esm/slicedToArray.js\");\n/* harmony import */ var actual__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! actual */ \"../../node_modules/actual/actual.js\");\n/* harmony import */ var actual__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(actual__WEBPACK_IMPORTED_MODULE_2__);\n/* harmony import */ var verge__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! verge */ \"../../node_modules/verge/verge.js\");\n/* harmony import */ var verge__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(verge__WEBPACK_IMPORTED_MODULE_3__);\n/* provided dependency */ var $ = __webpack_require__(/*! jquery */ \"jquery\");\n\n\n\nfunction _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== \"undefined\" && o[Symbol.iterator] || o[\"@@iterator\"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === \"number\") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError(\"Invalid attempt to iterate non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }\n\nfunction _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === \"string\") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === \"Object\" && o.constructor) n = o.constructor.name; if (n === \"Map\" || n === \"Set\") return Array.from(o); if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }\n\nfunction _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }\n\n/**\n * ============================================================================\n * helpers\n *\n * @package\n * @since     0.1.0\n * @version   0.1.0\n * @author    RIESTER <wordpress@riester.com>\n * @copyright 2021 RIESTER\n * ==========================================================================\n */\nvar _ = __webpack_require__(/*! lodash */ \"lodash\");\n\n\n // eslint-disable-line\n\n/**\n * Function for making strings camelCase\n *\n * @param {string} str The string to convert\n * @return {string} The converted string\n */\n\nfunction camelCase(str) {\n  return \"\".concat(str.charAt(0).toLowerCase()).concat(str.replace(/[\\W_]/g, '|').split('|').map(function (part) {\n    return \"\".concat(part.charAt(0).toUpperCase()).concat(part.slice(1));\n  }).join('').slice(1));\n}\n/**\n *\tChange the tag of a node element\n *\n * @param  {Element}  original  The element to change\n * @param  {string}   tag        The new tag\n *\n * @return {Element} The updated element\n */\n\n\nfunction changeTag(original, tag) {\n  var replacement = document.createElement(tag); // Grab all of the original's attributes, and pass them to the replacement\n\n  for (var i = 0, l = original.attributes.length; i < l; ++i) {\n    var nodeName = original.attributes.item(i).nodeName;\n    var nodeValue = original.attributes.item(i).nodeValue;\n    replacement.setAttribute(nodeName, nodeValue);\n  } // Persist contents\n\n\n  replacement.innerHTML = original.innerHTML; // Switch!\n\n  original.parentNode.replaceChild(replacement, original);\n  return original;\n}\n/**\n * Adds focus class for better accessibility\n *\n */\n\n\nfunction toggleFocus() {\n  if (event.type === 'focus' || event.type === 'blur') {\n    var self = this;\n\n    if (!_.isUndefined(self)) {\n      var elementClasses = self.classList;\n\n      if (!_.isNil(elementClasses)) {\n        // Move up through the ancestors of the current link until we hit .nav-menu.\n        while (!elementClasses.contains('nav-menu')) {\n          // On li elements toggle the class .focus.\n          if ('li' === self.tagName.toLowerCase()) {\n            self.classList.toggle('focus');\n          }\n\n          self = self.parentNode;\n        }\n      }\n    }\n  }\n\n  if (event.type === 'touchstart') {\n    var menuItem = this.parentNode;\n    event.preventDefault();\n\n    var _iterator = _createForOfIteratorHelper(menuItem.parentNode.children),\n        _step;\n\n    try {\n      for (_iterator.s(); !(_step = _iterator.n()).done;) {\n        var link = _step.value;\n\n        if (menuItem !== link) {\n          link.classList.remove('focus');\n        }\n      }\n    } catch (err) {\n      _iterator.e(err);\n    } finally {\n      _iterator.f();\n    }\n\n    menuItem.classList.toggle('focus');\n  }\n}\n/**\n * Get the screen size\n *\n * @param {string} prop\n * @return {Object|Number} The object containing the size infor or the requested property\n */\n\n\nfunction screenSize(prop) {\n  var size = {\n    width: actual__WEBPACK_IMPORTED_MODULE_2__.actual.actual('width', 'px'),\n    height: actual__WEBPACK_IMPORTED_MODULE_2__.actual.actual('height', 'px')\n  };\n\n  window.resize = function () {\n    _.assign({\n      width: actual__WEBPACK_IMPORTED_MODULE_2__.actual.actual('width', 'px'),\n      height: actual__WEBPACK_IMPORTED_MODULE_2__.actual.actual('height', 'px')\n    }, size);\n  };\n\n  if (!_.isNil(prop)) {\n    return size[prop];\n  }\n\n  _.assign({\n    width: actual__WEBPACK_IMPORTED_MODULE_2__.actual.actual('width', 'px'),\n    height: actual__WEBPACK_IMPORTED_MODULE_2__.actual.actual('height', 'px')\n  }, rwp.screen);\n\n  return size;\n}\n/**\n * Better Skip link\n *\n */\n\n\nfunction skipLink() {\n  var isIe = /(trident|msie)/i.test(navigator.userAgent);\n\n  if (isIe && document.getElementById && window.addEventListener) {\n    window.addEventListener('hashchange', function () {\n      var id = location.hash.substring(1);\n\n      if (!/^[A-z0-9_-]+$/.test(id)) {\n        return;\n      }\n\n      var element = document.getElementById(id);\n\n      if (element) {\n        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {\n          element.tabIndex = -1;\n        }\n\n        element.scrollIntoView({\n          behavior: 'smooth'\n        });\n        element.focus();\n      }\n    }, false);\n  }\n}\n/**\n * Check if a variable is empty\n *\n * @param {*} el The variable to check\n * @return {boolean} True if empty, false if not\n */\n\n\nfunction isEmpty(el) {\n  if (typeof el === 'undefined') {\n    return true;\n  } else if (el === '') {\n    return true;\n  } else if (el === null) {\n    return true;\n  } else if (el === false) {\n    return true;\n  }\n\n  return false;\n}\n\nfunction toggleNav(buttonId) {\n  var button = document.querySelector(buttonId); // Return early if the button don't exist.\n\n  if ('undefined' === typeof button) {\n    return;\n  }\n\n  var buttonTarget = button.getAttribute('data-target');\n  buttonTarget = buttonTarget.replace('#', '');\n  var siteNavigation = document.getElementById(buttonTarget); // Return early if the navigation don't exist.\n\n  if (!siteNavigation) {\n    return;\n  }\n\n  var menu = siteNavigation.getElementsByTagName('ul')[0]; // Toggle the .toggled class and the aria-expanded value each time the button is clicked.\n  // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.\n\n  document.addEventListener('click', function (event) {\n    var isClickInside = siteNavigation.contains(event.target);\n\n    if (!isClickInside) {\n      siteNavigation.classList.remove('toggled');\n      $('#' + buttonTarget).collapse('hide');\n    }\n  }); // Get all the link elements within the menu.\n\n  var links = menu.getElementsByTagName('a'); // Get all the link elements with children within the menu.\n  // eslint-disable-next-line\n\n  var linksWithChildren = menu.querySelectorAll('.has-children > a'); // Toggle focus each time a menu link is focused or blurred.\n\n  var _iterator2 = _createForOfIteratorHelper(links),\n      _step2;\n\n  try {\n    for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {\n      var link = _step2.value;\n      link.addEventListener('focus', toggleFocus, true);\n      link.addEventListener('blur', toggleFocus, true);\n    } // Toggle focus each time a menu link with children receive a touch event.\n\n  } catch (err) {\n    _iterator2.e(err);\n  } finally {\n    _iterator2.f();\n  }\n\n  var _iterator3 = _createForOfIteratorHelper(linksWithChildren),\n      _step3;\n\n  try {\n    for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {\n      var _link = _step3.value;\n\n      _link.addEventListener('touchstart', toggleFocus, false);\n    }\n  } catch (err) {\n    _iterator3.e(err);\n  } finally {\n    _iterator3.f();\n  }\n}\n\nfunction getTallest(el) {\n  var matches = document.querySelectorAll(el);\n\n  if (matches.length > 1) {\n    var heights = _.map(matches, function (elem) {\n      return this.rectangle(elem).height;\n    });\n\n    return Math.max.apply(null, heights);\n  }\n\n  return false;\n}\n\nfunction matchHeights(el) {\n  var _this = this;\n\n  var matches = document.querySelectorAll(el);\n\n  if (matches.length > 1) {\n    var minHeight = this.getTallest(el);\n\n    if (false !== minHeight) {\n      _.map(matches, function (elem) {\n        elem.style.minHeight = minHeight;\n      });\n    }\n\n    window.resize = function () {\n      _this.matchHeights(el);\n    };\n  }\n}\n\nfunction bsAtts() {\n  var bsColors = {\n    primary: '',\n    secondary: '',\n    tertiary: '',\n    info: '',\n    success: '',\n    warning: '',\n    danger: '',\n    light: '',\n    dark: '',\n    blue: '',\n    indigo: '',\n    purple: '',\n    pink: '',\n    red: '',\n    orange: '',\n    yellow: '',\n    green: '',\n    teal: '',\n    cyan: '',\n    white: '',\n    black: '',\n    'gray-100': '',\n    'gray-200': '',\n    'gray-300': '',\n    'gray-400': '',\n    'gray-500': '',\n    'gray-600': '',\n    'gray-700': '',\n    'gray-800': '',\n    'gray-900': ''\n  };\n  var computedColors = {};\n\n  for (var _i = 0, _Object$entries = Object.entries(bsColors); _i < _Object$entries.length; _i++) {\n    var _Object$entries$_i = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__[\"default\"])(_Object$entries[_i], 2),\n        key = _Object$entries$_i[0],\n        value = _Object$entries$_i[1];\n\n    var r = document.querySelector(':root'); // Get the styles (properties and values) for the root\n\n    var rs = getComputedStyle(r); // Alert the value of the --blue variable\n\n    value = rs.getPropertyValue(\"--bs-\".concat(key));\n    value = value.trim();\n\n    if ('' !== value) {\n      computedColors[key] = value;\n    }\n  }\n\n  return {\n    colors: computedColors\n  };\n}\n\nfunction logCustomProperties() {\n  var isSameDomain = function isSameDomain(styleSheet) {\n    // Internal style blocks won't have an href value\n    if (!styleSheet.href) {\n      return true;\n    }\n\n    return styleSheet.href.indexOf(window.location.origin) === 0;\n  };\n\n  var isStyleRule = function isStyleRule(rule) {\n    return rule.type === 1;\n  };\n\n  var getCSSCustomPropIndex = function getCSSCustomPropIndex() {\n    return (// styleSheets is array-like, so we convert it to an array.\n      // Filter out any stylesheets not on this domain\n      (0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(document.styleSheets).filter(isSameDomain).reduce(function (finalArr, sheet) {\n        return finalArr.concat( // cssRules is array-like, so we convert it to an array\n        (0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(sheet.cssRules).filter(isStyleRule).reduce(function (propValArr, rule) {\n          var props = (0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(rule.style).map(function (propName) {\n            return [propName.trim(), rule.style.getPropertyValue(propName).trim()];\n          }) // Discard any props that don't start with \"--\". Custom props are required to.\n          .filter(function (_ref) {\n            var _ref2 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__[\"default\"])(_ref, 1),\n                propName = _ref2[0];\n\n            return propName.indexOf('--') === 0;\n          });\n\n          return [].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(propValArr), (0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(props));\n        }, []));\n      }, [])\n    );\n  };\n\n  var cssCustomPropIndex = getCSSCustomPropIndex();\n  return cssCustomPropIndex;\n}\n\n\n\n//# sourceURL=webpack://rwp/./js/app.js?");

/***/ }),

/***/ "../../node_modules/actual/actual.js":
/*!*******************************************!*\
  !*** ../../node_modules/actual/actual.js ***!
  \*******************************************/
/***/ (function(module) {

eval("!function(root, name, make) {\r\n  if ( true && module.exports) module.exports = make();\r\n  else root[name] = make();\r\n}(this, 'actual', function() {\r\n\r\n  /**\r\n   * @param {string} feature range feature name e.g. \"width\"\r\n   * @param {string=} unit CSS unit for feature e.g. \"em\"\r\n   * @param {number=} init initial guess\r\n   * @param {number=} step size for iterations\r\n   * @return {number} breakpoint (0 if invalid unit or feature)\r\n   */\r\n  function actual(feature, unit, init, step) {\r\n    var up, gte, lte, curr, mq = actual['mq'];\r\n    unit = typeof unit == 'string' ? unit : '';\r\n    init = 0 < init ? (unit ? +init : init>>0) : 1;\r\n    // Step starts positive. Minimize iterations, unless feat may be \"integer\" type.\r\n    step = 0 < step ? +step : 0 > step ? -step : 'px' == unit ? 256 : unit ? 32 : 1;\r\n    for (feature += ':', unit += ')', curr = init; step && 0 <= curr; curr+=step) {\r\n      lte = mq('(min-' + feature + curr + unit);\r\n      gte = mq('(max-' + feature + curr + unit);\r\n      // Found: Use the floored value if it makes an exact match. Else return as is.\r\n      if (lte && gte) return mq('(' + feature + (curr>>0) + unit) ? curr>>0 : curr;\r\n      // 1st iteration: Save direction. Flip if down. Break if neither b/c unknown.\r\n      if (null == up) step = (up = !gte) ? lte && step : -step;\r\n      // Later iterations: If skipped, reverse direction and raise precision.\r\n      else if (gte ? up : !up) up = !up, step = -step/2;\r\n    }\r\n    return 0;\r\n  }\r\n\r\n  /**\r\n   * @param {string} unit\r\n   * @return {Function}\r\n   */\r\n  function as(unit) {\r\n    return function(feature) {\r\n      return actual(feature, unit);\r\n    };\r\n  }\r\n\r\n  var media = 'matchMedia', win = typeof window != 'undefined' && window;\r\n  actual['actual'] = actual;\r\n  actual['as'] = as;\r\n  actual['is'] = actual['mq'] = win[media] || win[media = 'msMatchMedia'] ? function(q) {\r\n    return !!win[media](q).matches;\r\n  } : function() {\r\n    return false;\r\n  };\r\n\r\n  return actual;\r\n});\r\n\n\n//# sourceURL=webpack://rwp/../../node_modules/actual/actual.js?");

/***/ }),

/***/ "../../node_modules/verge/verge.js":
/*!*****************************************!*\
  !*** ../../node_modules/verge/verge.js ***!
  \*****************************************/
/***/ (function(module) {

eval("/*!\r\n * verge 1.10.2+201705300050\r\n * http://npm.im/verge\r\n * MIT Ryan Van Etten\r\n */\r\n\r\n!function(root, name, make) {\n  if ( true && module['exports']) module['exports'] = make();\r\n  else root[name] = make();\r\n}(this, 'verge', function() {\r\n\r\n  var xports = {}\r\n    , win = typeof window != 'undefined' && window\r\n    , doc = typeof document != 'undefined' && document\r\n    , docElem = doc && doc.documentElement\r\n    , matchMedia = win['matchMedia'] || win['msMatchMedia']\r\n    , mq = matchMedia ? function(q) {\r\n        return !!matchMedia.call(win, q).matches;\r\n      } : function() {\r\n        return false;\r\n      }\r\n    , viewportW = xports['viewportW'] = function() {\r\n        var a = docElem['clientWidth'], b = win['innerWidth'];\r\n        return a < b ? b : a;\r\n      }\r\n    , viewportH = xports['viewportH'] = function() {\r\n        var a = docElem['clientHeight'], b = win['innerHeight'];\r\n        return a < b ? b : a;\r\n      };\r\n\n  /**\n   * Test if a media query is active. Like Modernizr.mq\r\n   * @since 1.6.0\r\n   * @return {boolean}\r\n   */\n  xports['mq'] = mq;\r\n\r\n  /**\n   * Normalized matchMedia\r\n   * @since 1.6.0\r\n   * @return {MediaQueryList|Object}\r\n   */\n  xports['matchMedia'] = matchMedia ? function() {\r\n    // matchMedia must be binded to window\r\n    return matchMedia.apply(win, arguments);\r\n  } : function() {\r\n    // Gracefully degrade to plain object\r\n    return {};\r\n  };\r\n\r\n  /**\r\n   * @since 1.8.0\r\n   * @return {{width:number, height:number}}\r\n   */\r\n  function viewport() {\r\n    return {'width':viewportW(), 'height':viewportH()};\r\n  }\r\n  xports['viewport'] = viewport;\r\n\n  /**\n   * Cross-browser window.scrollX\r\n   * @since 1.0.0\r\n   * @return {number}\r\n   */\r\n  xports['scrollX'] = function() {\r\n    return win.pageXOffset || docElem.scrollLeft;\n  };\r\n\r\n  /**\n   * Cross-browser window.scrollY\r\n   * @since 1.0.0\r\n   * @return {number}\r\n   */\r\n  xports['scrollY'] = function() {\r\n    return win.pageYOffset || docElem.scrollTop;\n  };\r\n\r\n  /**\r\n   * @param {{top:number, right:number, bottom:number, left:number}} coords\r\n   * @param {number=} cushion adjustment\r\n   * @return {Object}\r\n   */\r\n  function calibrate(coords, cushion) {\r\n    var o = {};\r\n    cushion = +cushion || 0;\r\n    o['width'] = (o['right'] = coords['right'] + cushion) - (o['left'] = coords['left'] - cushion);\r\n    o['height'] = (o['bottom'] = coords['bottom'] + cushion) - (o['top'] = coords['top'] - cushion);\r\n    return o;\r\n  }\r\n\r\n  /**\r\n   * Cross-browser element.getBoundingClientRect plus optional cushion.\r\n   * Coords are relative to the top-left corner of the viewport.\r\n   * @since 1.0.0\r\n   * @param {Element|Object} el element or stack (uses first item)\r\n   * @param {number=} cushion +/- pixel adjustment amount\r\n   * @return {Object|boolean}\r\n   */\r\n  function rectangle(el, cushion) {\r\n    el = el && !el.nodeType ? el[0] : el;\r\n    if (!el || 1 !== el.nodeType) return false;\r\n    return calibrate(el.getBoundingClientRect(), cushion);\r\n  }\r\n  xports['rectangle'] = rectangle;\r\n\r\n  /**\r\n   * Get the viewport aspect ratio (or the aspect ratio of an object or element)\r\n   * @since 1.7.0\r\n   * @param {(Element|Object)=} o optional object with width/height props or methods\r\n   * @return {number}\r\n   * @link http://w3.org/TR/css3-mediaqueries/#orientation\r\n   */\r\n  function aspect(o) {\r\n    o = null == o ? viewport() : 1 === o.nodeType ? rectangle(o) : o;\r\n    var h = o['height'], w = o['width'];\r\n    h = typeof h == 'function' ? h.call(o) : h;\r\n    w = typeof w == 'function' ? w.call(o) : w;\r\n    return w/h;\r\n  }\r\n  xports['aspect'] = aspect;\r\n\r\n  /**\r\n   * Test if an element is in the same x-axis section as the viewport.\r\n   * @since 1.0.0\r\n   * @param {Element|Object} el\r\n   * @param {number=} cushion\r\n   * @return {boolean}\r\n   */\r\n  xports['inX'] = function(el, cushion) {\r\n    var r = rectangle(el, cushion);\r\n    return !!r && r.right >= 0 && r.left <= viewportW();\r\n  };\r\n\r\n  /**\r\n   * Test if an element is in the same y-axis section as the viewport.\r\n   * @since 1.0.0\r\n   * @param {Element|Object} el\r\n   * @param {number=} cushion\r\n   * @return {boolean}\r\n   */\r\n  xports['inY'] = function(el, cushion) {\r\n    var r = rectangle(el, cushion);\r\n    return !!r && r.bottom >= 0 && r.top <= viewportH();\r\n  };\r\n\r\n  /**\r\n   * Test if an element is in the viewport.\r\n   * @since 1.0.0\r\n   * @param {Element|Object} el\r\n   * @param {number=} cushion\r\n   * @return {boolean}\r\n   */\r\n  xports['inViewport'] = function(el, cushion) {\r\n    // Equiv to `inX(el, cushion) && inY(el, cushion)` but just manually do both\n    // to avoid calling rectangle() twice. It gzips just as small like this.\r\n    var r = rectangle(el, cushion);\r\n    return !!r && r.bottom >= 0 && r.right >= 0 && r.top <= viewportH() && r.left <= viewportW();\r\n  };\r\n\r\n  return xports;\r\n});\n\n\n//# sourceURL=webpack://rwp/../../node_modules/verge/verge.js?");

/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ (function(module) {

"use strict";
module.exports = __WEBPACK_EXTERNAL_MODULE_jquery__;

/***/ }),

/***/ "lodash":
/*!*************************************************************************************!*\
  !*** external {"commonjs":"lodash","commonjs2":"lodash","amd":"lodash","root":"_"} ***!
  \*************************************************************************************/
/***/ (function(module) {

"use strict";
module.exports = __WEBPACK_EXTERNAL_MODULE_lodash__;

/***/ }),

/***/ "../../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js":
/*!*************************************************************************!*\
  !*** ../../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js ***!
  \*************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ _arrayLikeToArray; }\n/* harmony export */ });\nfunction _arrayLikeToArray(arr, len) {\n  if (len == null || len > arr.length) len = arr.length;\n\n  for (var i = 0, arr2 = new Array(len); i < len; i++) {\n    arr2[i] = arr[i];\n  }\n\n  return arr2;\n}\n\n//# sourceURL=webpack://rwp/../../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js?");

/***/ }),

/***/ "../../node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js":
/*!***********************************************************************!*\
  !*** ../../node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ _arrayWithHoles; }\n/* harmony export */ });\nfunction _arrayWithHoles(arr) {\n  if (Array.isArray(arr)) return arr;\n}\n\n//# sourceURL=webpack://rwp/../../node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js?");

/***/ }),

/***/ "../../node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js":
/*!**************************************************************************!*\
  !*** ../../node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js ***!
  \**************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ _arrayWithoutHoles; }\n/* harmony export */ });\n/* harmony import */ var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayLikeToArray.js */ \"../../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js\");\n\nfunction _arrayWithoutHoles(arr) {\n  if (Array.isArray(arr)) return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(arr);\n}\n\n//# sourceURL=webpack://rwp/../../node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js?");

/***/ }),

/***/ "../../node_modules/@babel/runtime/helpers/esm/iterableToArray.js":
/*!************************************************************************!*\
  !*** ../../node_modules/@babel/runtime/helpers/esm/iterableToArray.js ***!
  \************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ _iterableToArray; }\n/* harmony export */ });\nfunction _iterableToArray(iter) {\n  if (typeof Symbol !== \"undefined\" && iter[Symbol.iterator] != null || iter[\"@@iterator\"] != null) return Array.from(iter);\n}\n\n//# sourceURL=webpack://rwp/../../node_modules/@babel/runtime/helpers/esm/iterableToArray.js?");

/***/ }),

/***/ "../../node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js":
/*!*****************************************************************************!*\
  !*** ../../node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js ***!
  \*****************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ _iterableToArrayLimit; }\n/* harmony export */ });\nfunction _iterableToArrayLimit(arr, i) {\n  var _i = arr == null ? null : typeof Symbol !== \"undefined\" && arr[Symbol.iterator] || arr[\"@@iterator\"];\n\n  if (_i == null) return;\n  var _arr = [];\n  var _n = true;\n  var _d = false;\n\n  var _s, _e;\n\n  try {\n    for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {\n      _arr.push(_s.value);\n\n      if (i && _arr.length === i) break;\n    }\n  } catch (err) {\n    _d = true;\n    _e = err;\n  } finally {\n    try {\n      if (!_n && _i[\"return\"] != null) _i[\"return\"]();\n    } finally {\n      if (_d) throw _e;\n    }\n  }\n\n  return _arr;\n}\n\n//# sourceURL=webpack://rwp/../../node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js?");

/***/ }),

/***/ "../../node_modules/@babel/runtime/helpers/esm/nonIterableRest.js":
/*!************************************************************************!*\
  !*** ../../node_modules/@babel/runtime/helpers/esm/nonIterableRest.js ***!
  \************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ _nonIterableRest; }\n/* harmony export */ });\nfunction _nonIterableRest() {\n  throw new TypeError(\"Invalid attempt to destructure non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\");\n}\n\n//# sourceURL=webpack://rwp/../../node_modules/@babel/runtime/helpers/esm/nonIterableRest.js?");

/***/ }),

/***/ "../../node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js":
/*!**************************************************************************!*\
  !*** ../../node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js ***!
  \**************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ _nonIterableSpread; }\n/* harmony export */ });\nfunction _nonIterableSpread() {\n  throw new TypeError(\"Invalid attempt to spread non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\");\n}\n\n//# sourceURL=webpack://rwp/../../node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js?");

/***/ }),

/***/ "../../node_modules/@babel/runtime/helpers/esm/slicedToArray.js":
/*!**********************************************************************!*\
  !*** ../../node_modules/@babel/runtime/helpers/esm/slicedToArray.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ _slicedToArray; }\n/* harmony export */ });\n/* harmony import */ var _arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayWithHoles.js */ \"../../node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js\");\n/* harmony import */ var _iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./iterableToArrayLimit.js */ \"../../node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js\");\n/* harmony import */ var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./unsupportedIterableToArray.js */ \"../../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js\");\n/* harmony import */ var _nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./nonIterableRest.js */ \"../../node_modules/@babel/runtime/helpers/esm/nonIterableRest.js\");\n\n\n\n\nfunction _slicedToArray(arr, i) {\n  return (0,_arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(arr) || (0,_iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__[\"default\"])(arr, i) || (0,_unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(arr, i) || (0,_nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__[\"default\"])();\n}\n\n//# sourceURL=webpack://rwp/../../node_modules/@babel/runtime/helpers/esm/slicedToArray.js?");

/***/ }),

/***/ "../../node_modules/@babel/runtime/helpers/esm/toConsumableArray.js":
/*!**************************************************************************!*\
  !*** ../../node_modules/@babel/runtime/helpers/esm/toConsumableArray.js ***!
  \**************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ _toConsumableArray; }\n/* harmony export */ });\n/* harmony import */ var _arrayWithoutHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayWithoutHoles.js */ \"../../node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js\");\n/* harmony import */ var _iterableToArray_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./iterableToArray.js */ \"../../node_modules/@babel/runtime/helpers/esm/iterableToArray.js\");\n/* harmony import */ var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./unsupportedIterableToArray.js */ \"../../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js\");\n/* harmony import */ var _nonIterableSpread_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./nonIterableSpread.js */ \"../../node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js\");\n\n\n\n\nfunction _toConsumableArray(arr) {\n  return (0,_arrayWithoutHoles_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(arr) || (0,_iterableToArray_js__WEBPACK_IMPORTED_MODULE_1__[\"default\"])(arr) || (0,_unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__[\"default\"])(arr) || (0,_nonIterableSpread_js__WEBPACK_IMPORTED_MODULE_3__[\"default\"])();\n}\n\n//# sourceURL=webpack://rwp/../../node_modules/@babel/runtime/helpers/esm/toConsumableArray.js?");

/***/ }),

/***/ "../../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js":
/*!***********************************************************************************!*\
  !*** ../../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js ***!
  \***********************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export */ __webpack_require__.d(__webpack_exports__, {\n/* harmony export */   \"default\": function() { return /* binding */ _unsupportedIterableToArray; }\n/* harmony export */ });\n/* harmony import */ var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayLikeToArray.js */ \"../../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js\");\n\nfunction _unsupportedIterableToArray(o, minLen) {\n  if (!o) return;\n  if (typeof o === \"string\") return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(o, minLen);\n  var n = Object.prototype.toString.call(o).slice(8, -1);\n  if (n === \"Object\" && o.constructor) n = o.constructor.name;\n  if (n === \"Map\" || n === \"Set\") return Array.from(o);\n  if (n === \"Arguments\" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(o, minLen);\n}\n\n//# sourceURL=webpack://rwp/../../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./js/app.js");
/******/ 	
/******/ 	return __webpack_exports__;
/******/ })()
;
});