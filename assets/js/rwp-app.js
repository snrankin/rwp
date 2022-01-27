/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "../node_modules/actual/actual.js":
/*!****************************************!*\
  !*** ../node_modules/actual/actual.js ***!
  \****************************************/
/***/ (function(module) {

!function(root, name, make) {
  if ( true && module.exports) module.exports = make();
  else root[name] = make();
}(this, 'actual', function() {

  /**
   * @param {string} feature range feature name e.g. "width"
   * @param {string=} unit CSS unit for feature e.g. "em"
   * @param {number=} init initial guess
   * @param {number=} step size for iterations
   * @return {number} breakpoint (0 if invalid unit or feature)
   */
  function actual(feature, unit, init, step) {
    var up, gte, lte, curr, mq = actual['mq'];
    unit = typeof unit == 'string' ? unit : '';
    init = 0 < init ? (unit ? +init : init>>0) : 1;
    // Step starts positive. Minimize iterations, unless feat may be "integer" type.
    step = 0 < step ? +step : 0 > step ? -step : 'px' == unit ? 256 : unit ? 32 : 1;
    for (feature += ':', unit += ')', curr = init; step && 0 <= curr; curr+=step) {
      lte = mq('(min-' + feature + curr + unit);
      gte = mq('(max-' + feature + curr + unit);
      // Found: Use the floored value if it makes an exact match. Else return as is.
      if (lte && gte) return mq('(' + feature + (curr>>0) + unit) ? curr>>0 : curr;
      // 1st iteration: Save direction. Flip if down. Break if neither b/c unknown.
      if (null == up) step = (up = !gte) ? lte && step : -step;
      // Later iterations: If skipped, reverse direction and raise precision.
      else if (gte ? up : !up) up = !up, step = -step/2;
    }
    return 0;
  }

  /**
   * @param {string} unit
   * @return {Function}
   */
  function as(unit) {
    return function(feature) {
      return actual(feature, unit);
    };
  }

  var media = 'matchMedia', win = typeof window != 'undefined' && window;
  actual['actual'] = actual;
  actual['as'] = as;
  actual['is'] = actual['mq'] = win[media] || win[media = 'msMatchMedia'] ? function(q) {
    return !!win[media](q).matches;
  } : function() {
    return false;
  };

  return actual;
});


/***/ }),

/***/ "../node_modules/verge/verge.js":
/*!**************************************!*\
  !*** ../node_modules/verge/verge.js ***!
  \**************************************/
/***/ (function(module) {

/*!
 * verge 1.10.2+201705300050
 * http://npm.im/verge
 * MIT Ryan Van Etten
 */

!function(root, name, make) {
  if ( true && module['exports']) module['exports'] = make();
  else root[name] = make();
}(this, 'verge', function() {

  var xports = {}
    , win = typeof window != 'undefined' && window
    , doc = typeof document != 'undefined' && document
    , docElem = doc && doc.documentElement
    , matchMedia = win['matchMedia'] || win['msMatchMedia']
    , mq = matchMedia ? function(q) {
        return !!matchMedia.call(win, q).matches;
      } : function() {
        return false;
      }
    , viewportW = xports['viewportW'] = function() {
        var a = docElem['clientWidth'], b = win['innerWidth'];
        return a < b ? b : a;
      }
    , viewportH = xports['viewportH'] = function() {
        var a = docElem['clientHeight'], b = win['innerHeight'];
        return a < b ? b : a;
      };

  /**
   * Test if a media query is active. Like Modernizr.mq
   * @since 1.6.0
   * @return {boolean}
   */
  xports['mq'] = mq;

  /**
   * Normalized matchMedia
   * @since 1.6.0
   * @return {MediaQueryList|Object}
   */
  xports['matchMedia'] = matchMedia ? function() {
    // matchMedia must be binded to window
    return matchMedia.apply(win, arguments);
  } : function() {
    // Gracefully degrade to plain object
    return {};
  };

  /**
   * @since 1.8.0
   * @return {{width:number, height:number}}
   */
  function viewport() {
    return {'width':viewportW(), 'height':viewportH()};
  }
  xports['viewport'] = viewport;

  /**
   * Cross-browser window.scrollX
   * @since 1.0.0
   * @return {number}
   */
  xports['scrollX'] = function() {
    return win.pageXOffset || docElem.scrollLeft;
  };

  /**
   * Cross-browser window.scrollY
   * @since 1.0.0
   * @return {number}
   */
  xports['scrollY'] = function() {
    return win.pageYOffset || docElem.scrollTop;
  };

  /**
   * @param {{top:number, right:number, bottom:number, left:number}} coords
   * @param {number=} cushion adjustment
   * @return {Object}
   */
  function calibrate(coords, cushion) {
    var o = {};
    cushion = +cushion || 0;
    o['width'] = (o['right'] = coords['right'] + cushion) - (o['left'] = coords['left'] - cushion);
    o['height'] = (o['bottom'] = coords['bottom'] + cushion) - (o['top'] = coords['top'] - cushion);
    return o;
  }

  /**
   * Cross-browser element.getBoundingClientRect plus optional cushion.
   * Coords are relative to the top-left corner of the viewport.
   * @since 1.0.0
   * @param {Element|Object} el element or stack (uses first item)
   * @param {number=} cushion +/- pixel adjustment amount
   * @return {Object|boolean}
   */
  function rectangle(el, cushion) {
    el = el && !el.nodeType ? el[0] : el;
    if (!el || 1 !== el.nodeType) return false;
    return calibrate(el.getBoundingClientRect(), cushion);
  }
  xports['rectangle'] = rectangle;

  /**
   * Get the viewport aspect ratio (or the aspect ratio of an object or element)
   * @since 1.7.0
   * @param {(Element|Object)=} o optional object with width/height props or methods
   * @return {number}
   * @link http://w3.org/TR/css3-mediaqueries/#orientation
   */
  function aspect(o) {
    o = null == o ? viewport() : 1 === o.nodeType ? rectangle(o) : o;
    var h = o['height'], w = o['width'];
    h = typeof h == 'function' ? h.call(o) : h;
    w = typeof w == 'function' ? w.call(o) : w;
    return w/h;
  }
  xports['aspect'] = aspect;

  /**
   * Test if an element is in the same x-axis section as the viewport.
   * @since 1.0.0
   * @param {Element|Object} el
   * @param {number=} cushion
   * @return {boolean}
   */
  xports['inX'] = function(el, cushion) {
    var r = rectangle(el, cushion);
    return !!r && r.right >= 0 && r.left <= viewportW();
  };

  /**
   * Test if an element is in the same y-axis section as the viewport.
   * @since 1.0.0
   * @param {Element|Object} el
   * @param {number=} cushion
   * @return {boolean}
   */
  xports['inY'] = function(el, cushion) {
    var r = rectangle(el, cushion);
    return !!r && r.bottom >= 0 && r.top <= viewportH();
  };

  /**
   * Test if an element is in the viewport.
   * @since 1.0.0
   * @param {Element|Object} el
   * @param {number=} cushion
   * @return {boolean}
   */
  xports['inViewport'] = function(el, cushion) {
    // Equiv to `inX(el, cushion) && inY(el, cushion)` but just manually do both
    // to avoid calling rectangle() twice. It gzips just as small like this.
    var r = rectangle(el, cushion);
    return !!r && r.bottom >= 0 && r.right >= 0 && r.top <= viewportH() && r.left <= viewportW();
  };

  return xports;
});


/***/ }),

/***/ "lodash":
/*!*************************************************************************************!*\
  !*** external {"commonjs":"lodash","commonjs2":"lodash","amd":"lodash","root":"_"} ***!
  \*************************************************************************************/
/***/ (function(module) {

"use strict";
module.exports = undefined;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js":
/*!**********************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _arrayLikeToArray; }
/* harmony export */ });
function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js":
/*!********************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js ***!
  \********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _arrayWithHoles; }
/* harmony export */ });
function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _arrayWithoutHoles; }
/* harmony export */ });
/* harmony import */ var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayLikeToArray.js */ "../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js");

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(arr);
}

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/esm/iterableToArray.js":
/*!*********************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/esm/iterableToArray.js ***!
  \*********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _iterableToArray; }
/* harmony export */ });
function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
}

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js":
/*!**************************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js ***!
  \**************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _iterableToArrayLimit; }
/* harmony export */ });
function _iterableToArrayLimit(arr, i) {
  var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"];

  if (_i == null) return;
  var _arr = [];
  var _n = true;
  var _d = false;

  var _s, _e;

  try {
    for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/esm/nonIterableRest.js":
/*!*********************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/esm/nonIterableRest.js ***!
  \*********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _nonIterableRest; }
/* harmony export */ });
function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _nonIterableSpread; }
/* harmony export */ });
function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/esm/slicedToArray.js":
/*!*******************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/esm/slicedToArray.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _slicedToArray; }
/* harmony export */ });
/* harmony import */ var _arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayWithHoles.js */ "../node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js");
/* harmony import */ var _iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./iterableToArrayLimit.js */ "../node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js");
/* harmony import */ var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js");
/* harmony import */ var _nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./nonIterableRest.js */ "../node_modules/@babel/runtime/helpers/esm/nonIterableRest.js");




function _slicedToArray(arr, i) {
  return (0,_arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__["default"])(arr) || (0,_iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__["default"])(arr, i) || (0,_unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__["default"])(arr, i) || (0,_nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
}

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/esm/toConsumableArray.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/esm/toConsumableArray.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _toConsumableArray; }
/* harmony export */ });
/* harmony import */ var _arrayWithoutHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayWithoutHoles.js */ "../node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js");
/* harmony import */ var _iterableToArray_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./iterableToArray.js */ "../node_modules/@babel/runtime/helpers/esm/iterableToArray.js");
/* harmony import */ var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js");
/* harmony import */ var _nonIterableSpread_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./nonIterableSpread.js */ "../node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js");




function _toConsumableArray(arr) {
  return (0,_arrayWithoutHoles_js__WEBPACK_IMPORTED_MODULE_0__["default"])(arr) || (0,_iterableToArray_js__WEBPACK_IMPORTED_MODULE_1__["default"])(arr) || (0,_unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__["default"])(arr) || (0,_nonIterableSpread_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
}

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js":
/*!********************************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js ***!
  \********************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _unsupportedIterableToArray; }
/* harmony export */ });
/* harmony import */ var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayLikeToArray.js */ "../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js");

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(o, minLen);
}

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
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!*******************!*\
  !*** ./js/app.js ***!
  \*******************/
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "camelCase": function() { return /* binding */ camelCase; },
/* harmony export */   "changeTag": function() { return /* binding */ changeTag; },
/* harmony export */   "getHash": function() { return /* binding */ getHash; },
/* harmony export */   "toggleFocus": function() { return /* binding */ toggleFocus; },
/* harmony export */   "screenSize": function() { return /* binding */ screenSize; },
/* harmony export */   "isEmpty": function() { return /* binding */ isEmpty; },
/* harmony export */   "toggleNav": function() { return /* binding */ toggleNav; },
/* harmony export */   "getTallest": function() { return /* binding */ getTallest; },
/* harmony export */   "matchHeights": function() { return /* binding */ matchHeights; },
/* harmony export */   "bsAtts": function() { return /* binding */ bsAtts; },
/* harmony export */   "logCustomProperties": function() { return /* binding */ logCustomProperties; },
/* harmony export */   "actual": function() { return /* reexport safe */ actual__WEBPACK_IMPORTED_MODULE_2__.actual; },
/* harmony export */   "viewportW": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.viewportW; },
/* harmony export */   "viewportH": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.viewportH; },
/* harmony export */   "viewport": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.viewport; },
/* harmony export */   "inViewport": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.inViewport; },
/* harmony export */   "inX": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.inX; },
/* harmony export */   "inY": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.inY; },
/* harmony export */   "scrollX": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.scrollX; },
/* harmony export */   "scrollY": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.scrollY; },
/* harmony export */   "mq": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.mq; },
/* harmony export */   "rectangle": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.rectangle; },
/* harmony export */   "aspect": function() { return /* reexport safe */ verge__WEBPACK_IMPORTED_MODULE_3__.aspect; }
/* harmony export */ });
/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/toConsumableArray */ "../node_modules/@babel/runtime/helpers/esm/toConsumableArray.js");
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "../node_modules/@babel/runtime/helpers/esm/slicedToArray.js");
/* harmony import */ var actual__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! actual */ "../node_modules/actual/actual.js");
/* harmony import */ var actual__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(actual__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var verge__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! verge */ "../node_modules/verge/verge.js");
/* harmony import */ var verge__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(verge__WEBPACK_IMPORTED_MODULE_3__);



function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

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
var _ = __webpack_require__(/*! lodash */ "lodash");


 // eslint-disable-line

/**
 * Function for making strings camelCase
 *
 * @param {string} str The string to convert
 * @return {string} The converted string
 */

function camelCase(str) {
  return "".concat(str.charAt(0).toLowerCase()).concat(str.replace(/[\W_]/g, '|').split('|').map(function (part) {
    return "".concat(part.charAt(0).toUpperCase()).concat(part.slice(1));
  }).join('').slice(1));
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
  var replacement = document.createElement(tag); // Grab all of the original's attributes, and pass them to the replacement

  for (var i = 0, l = original.attributes.length; i < l; ++i) {
    var nodeName = original.attributes.item(i).nodeName;
    var nodeValue = original.attributes.item(i).nodeValue;
    replacement.setAttribute(nodeName, nodeValue);
  } // Persist contents


  replacement.innerHTML = original.innerHTML; // Switch!

  original.parentNode.replaceChild(replacement, original);
  return original;
}
/**
 * Adds focus class for better accessibility
 *
 */


function toggleFocus(el) {
  if (event.type === 'focus' || event.type === 'blur') {
    var self = this;

    if (!_.isUndefined(self)) {
      var elementClasses = self.classList;

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
    var menuItem = this.parentNode;
    event.preventDefault();

    var _iterator = _createForOfIteratorHelper(menuItem.parentNode.children),
        _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var link = _step.value;

        if (menuItem !== link) {
          link.classList.remove('focus');
        }
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
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
  var size = {
    width: actual__WEBPACK_IMPORTED_MODULE_2__.actual.actual('width', 'px'),
    height: actual__WEBPACK_IMPORTED_MODULE_2__.actual.actual('height', 'px')
  };
  window.addEventListener('resize', function () {
    _.assign({
      width: actual__WEBPACK_IMPORTED_MODULE_2__.actual.actual('width', 'px'),
      height: actual__WEBPACK_IMPORTED_MODULE_2__.actual.actual('height', 'px')
    }, size);
  });

  if (!_.isNil(prop)) {
    return size[prop];
  }

  return size;
} // URL updates and the element focus is maintained
// originally found via in Update 3 on http://www.learningjquery.com/2007/10/improved-animated-scrolling-script-for-same-page-links
// filter handling for a /dir/ OR /indexordefault.page


function filterPath(string) {
  return string.replace(/^\//, '').replace(/(index|default).[a-zA-Z]{3,4}$/, '').replace(/\/$/, '');
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
  var button = document.querySelector(buttonId); // Return early if the button don't exist.

  if (isEmpty(button)) {
    return;
  }

  var buttonTarget = button.getAttribute('data-target');

  if (isEmpty(buttonTarget)) {
    buttonTarget = button.getAttribute('href');
  }

  if (isEmpty(buttonTarget)) {
    return;
  }

  buttonTarget = getHash(buttonTarget);
  var siteNavigation = document.getElementById(buttonTarget); // Return early if the navigation don't exist.

  if (isEmpty(siteNavigation)) {
    return;
  }

  var menu = siteNavigation.getElementsByTagName('ul')[0]; // Get all the link elements within the menu.

  var links = menu.getElementsByTagName('a'); // Get all the link elements with children within the menu.
  // eslint-disable-next-line

  var linksWithChildren = menu.querySelectorAll('.has-children > a'); // Toggle focus each time a menu link is focused or blurred.

  var _iterator2 = _createForOfIteratorHelper(links),
      _step2;

  try {
    for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
      var link = _step2.value;
      link.addEventListener('focus', toggleFocus, true);
      link.addEventListener('blur', toggleFocus, true);
    } // Toggle focus each time a menu link with children receive a touch event.

  } catch (err) {
    _iterator2.e(err);
  } finally {
    _iterator2.f();
  }

  var _iterator3 = _createForOfIteratorHelper(linksWithChildren),
      _step3;

  try {
    for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
      var _link = _step3.value;

      _link.addEventListener('touchstart', toggleFocus, false);
    }
  } catch (err) {
    _iterator3.e(err);
  } finally {
    _iterator3.f();
  }
}
/**
 * Get tallest element
 *
 * @param {string} el
 * @return {number}
 */


function getTallest(el) {
  var matches = document.querySelectorAll(el);

  if (matches.length > 1) {
    var heights = _.map(matches, function (elem) {
      return (0,verge__WEBPACK_IMPORTED_MODULE_3__.rectangle)(elem).height;
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


function matchHeights() {
  var elem = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
  var container = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : Document;
  var matches = container.querySelectorAll(elem);

  if (matches.length > 1) {
    var minHeight = getTallest(elem);

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
  var bsColors = {
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
    'gray-900': ''
  };
  var computedColors = {};

  for (var _i = 0, _Object$entries = Object.entries(bsColors); _i < _Object$entries.length; _i++) {
    var _Object$entries$_i = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__["default"])(_Object$entries[_i], 2),
        key = _Object$entries$_i[0],
        value = _Object$entries$_i[1];

    var r = document.querySelector(':root'); // Get the styles (properties and values) for the root

    var rs = getComputedStyle(r); // Alert the value of the --blue variable

    value = rs.getPropertyValue("--bs-".concat(key));
    value = value.trim();

    if ('' !== value) {
      computedColors[key] = value;
    }
  }

  return {
    colors: computedColors
  };
}

function logCustomProperties() {
  var isSameDomain = function isSameDomain(styleSheet) {
    // Internal style blocks won't have an href value
    if (!styleSheet.href) {
      return true;
    }

    return styleSheet.href.indexOf(window.location.origin) === 0;
  };

  var isStyleRule = function isStyleRule(rule) {
    return rule.type === 1;
  };

  var getCSSCustomPropIndex = function getCSSCustomPropIndex() {
    return (// styleSheets is array-like, so we convert it to an array.
      // Filter out any stylesheets not on this domain
      (0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__["default"])(document.styleSheets).filter(isSameDomain).reduce(function (finalArr, sheet) {
        return finalArr.concat( // cssRules is array-like, so we convert it to an array
        (0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__["default"])(sheet.cssRules).filter(isStyleRule).reduce(function (propValArr, rule) {
          var props = (0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__["default"])(rule.style).map(function (propName) {
            return [propName.trim(), rule.style.getPropertyValue(propName).trim()];
          }) // Discard any props that don't start with "--". Custom props are required to.
          .filter(function (_ref) {
            var _ref2 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_1__["default"])(_ref, 1),
                propName = _ref2[0];

            return propName.indexOf('--') === 0;
          });

          return [].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__["default"])(propValArr), (0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__["default"])(props));
        }, []));
      }, [])
    );
  };

  var cssCustomPropIndex = getCSSCustomPropIndex();
  return cssCustomPropIndex;
}


}();
var __webpack_export_target__ = (rwp = typeof rwp === "undefined" ? {} : rwp);
for(var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
if(__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", { value: true });
/******/ })()
;
//# sourceMappingURL=rwp-app.js.map