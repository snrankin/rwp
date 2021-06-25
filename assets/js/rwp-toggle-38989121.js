/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/wp-content/plugins/rwp/assets/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "../node_modules/@babel/runtime/helpers/arrayLikeToArray.js":
/*!******************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/arrayLikeToArray.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

module.exports = _arrayLikeToArray;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/arrayWithHoles.js":
/*!****************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/arrayWithHoles.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

module.exports = _arrayWithHoles;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/defineProperty.js":
/*!****************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/defineProperty.js ***!
  \****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

module.exports = _defineProperty;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/iterableToArrayLimit.js":
/*!**********************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/iterableToArrayLimit.js ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _iterableToArrayLimit(arr, i) {
  var _i = arr && (typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"]);

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

module.exports = _iterableToArrayLimit;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/nonIterableRest.js":
/*!*****************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/nonIterableRest.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

module.exports = _nonIterableRest;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/slicedToArray.js":
/*!***************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/slicedToArray.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayWithHoles = __webpack_require__(/*! ./arrayWithHoles.js */ "../node_modules/@babel/runtime/helpers/arrayWithHoles.js");

var iterableToArrayLimit = __webpack_require__(/*! ./iterableToArrayLimit.js */ "../node_modules/@babel/runtime/helpers/iterableToArrayLimit.js");

var unsupportedIterableToArray = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "../node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js");

var nonIterableRest = __webpack_require__(/*! ./nonIterableRest.js */ "../node_modules/@babel/runtime/helpers/nonIterableRest.js");

function _slicedToArray(arr, i) {
  return arrayWithHoles(arr) || iterableToArrayLimit(arr, i) || unsupportedIterableToArray(arr, i) || nonIterableRest();
}

module.exports = _slicedToArray;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/typeof.js":
/*!********************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/typeof.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    module.exports = _typeof = function _typeof(obj) {
      return typeof obj;
    };

    module.exports["default"] = module.exports, module.exports.__esModule = true;
  } else {
    module.exports = _typeof = function _typeof(obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };

    module.exports["default"] = module.exports, module.exports.__esModule = true;
  }

  return _typeof(obj);
}

module.exports = _typeof;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "../node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js":
/*!****************************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/unsupportedIterableToArray.js ***!
  \****************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var arrayLikeToArray = __webpack_require__(/*! ./arrayLikeToArray.js */ "../node_modules/@babel/runtime/helpers/arrayLikeToArray.js");

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return arrayLikeToArray(o, minLen);
}

module.exports = _unsupportedIterableToArray;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "../node_modules/classnames/dedupe.js":
/*!********************************************!*\
  !*** ../node_modules/classnames/dedupe.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  Copyright (c) 2018 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var classNames = (function () {
		// don't inherit from Object so we can skip hasOwnProperty check later
		// http://stackoverflow.com/questions/15518328/creating-js-object-with-object-createnull#answer-21079232
		function StorageObject() {}
		StorageObject.prototype = Object.create(null);

		function _parseArray (resultSet, array) {
			var length = array.length;

			for (var i = 0; i < length; ++i) {
				_parse(resultSet, array[i]);
			}
		}

		var hasOwn = {}.hasOwnProperty;

		function _parseNumber (resultSet, num) {
			resultSet[num] = true;
		}

		function _parseObject (resultSet, object) {
			if (object.toString === Object.prototype.toString) {
				for (var k in object) {
					if (hasOwn.call(object, k)) {
						// set value to false instead of deleting it to avoid changing object structure
						// https://www.smashingmagazine.com/2012/11/writing-fast-memory-efficient-javascript/#de-referencing-misconceptions
						resultSet[k] = !!object[k];
					}
				}
			} else {
				resultSet[object.toString()] = true;
			}
		}

		var SPACE = /\s+/;
		function _parseString (resultSet, str) {
			var array = str.split(SPACE);
			var length = array.length;

			for (var i = 0; i < length; ++i) {
				resultSet[array[i]] = true;
			}
		}

		function _parse (resultSet, arg) {
			if (!arg) return;
			var argType = typeof arg;

			// 'foo bar'
			if (argType === 'string') {
				_parseString(resultSet, arg);

			// ['foo', 'bar', ...]
			} else if (Array.isArray(arg)) {
				_parseArray(resultSet, arg);

			// { 'foo': true, ... }
			} else if (argType === 'object') {
				_parseObject(resultSet, arg);

			// '130'
			} else if (argType === 'number') {
				_parseNumber(resultSet, arg);
			}
		}

		function _classNames () {
			// don't leak arguments
			// https://github.com/petkaantonov/bluebird/wiki/Optimization-killers#32-leaking-arguments
			var len = arguments.length;
			var args = Array(len);
			for (var i = 0; i < len; i++) {
				args[i] = arguments[i];
			}

			var classSet = new StorageObject();
			_parseArray(classSet, args);

			var list = [];

			for (var k in classSet) {
				if (classSet[k]) {
					list.push(k)
				}
			}

			return list.join(' ');
		}

		return _classNames;
	})();

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),

/***/ "../node_modules/memize/index.js":
/*!***************************************!*\
  !*** ../node_modules/memize/index.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/**
 * Memize options object.
 *
 * @typedef MemizeOptions
 *
 * @property {number} [maxSize] Maximum size of the cache.
 */

/**
 * Internal cache entry.
 *
 * @typedef MemizeCacheNode
 *
 * @property {?MemizeCacheNode|undefined} [prev] Previous node.
 * @property {?MemizeCacheNode|undefined} [next] Next node.
 * @property {Array<*>}                   args   Function arguments for cache
 *                                               entry.
 * @property {*}                          val    Function result.
 */

/**
 * Properties of the enhanced function for controlling cache.
 *
 * @typedef MemizeMemoizedFunction
 *
 * @property {()=>void} clear Clear the cache.
 */

/**
 * Accepts a function to be memoized, and returns a new memoized function, with
 * optional options.
 *
 * @template {Function} F
 *
 * @param {F}             fn        Function to memoize.
 * @param {MemizeOptions} [options] Options object.
 *
 * @return {F & MemizeMemoizedFunction} Memoized function.
 */
function memize( fn, options ) {
	var size = 0;

	/** @type {?MemizeCacheNode|undefined} */
	var head;

	/** @type {?MemizeCacheNode|undefined} */
	var tail;

	options = options || {};

	function memoized( /* ...args */ ) {
		var node = head,
			len = arguments.length,
			args, i;

		searchCache: while ( node ) {
			// Perform a shallow equality test to confirm that whether the node
			// under test is a candidate for the arguments passed. Two arrays
			// are shallowly equal if their length matches and each entry is
			// strictly equal between the two sets. Avoid abstracting to a
			// function which could incur an arguments leaking deoptimization.

			// Check whether node arguments match arguments length
			if ( node.args.length !== arguments.length ) {
				node = node.next;
				continue;
			}

			// Check whether node arguments match arguments values
			for ( i = 0; i < len; i++ ) {
				if ( node.args[ i ] !== arguments[ i ] ) {
					node = node.next;
					continue searchCache;
				}
			}

			// At this point we can assume we've found a match

			// Surface matched node to head if not already
			if ( node !== head ) {
				// As tail, shift to previous. Must only shift if not also
				// head, since if both head and tail, there is no previous.
				if ( node === tail ) {
					tail = node.prev;
				}

				// Adjust siblings to point to each other. If node was tail,
				// this also handles new tail's empty `next` assignment.
				/** @type {MemizeCacheNode} */ ( node.prev ).next = node.next;
				if ( node.next ) {
					node.next.prev = node.prev;
				}

				node.next = head;
				node.prev = null;
				/** @type {MemizeCacheNode} */ ( head ).prev = node;
				head = node;
			}

			// Return immediately
			return node.val;
		}

		// No cached value found. Continue to insertion phase:

		// Create a copy of arguments (avoid leaking deoptimization)
		args = new Array( len );
		for ( i = 0; i < len; i++ ) {
			args[ i ] = arguments[ i ];
		}

		node = {
			args: args,

			// Generate the result from original function
			val: fn.apply( null, args ),
		};

		// Don't need to check whether node is already head, since it would
		// have been returned above already if it was

		// Shift existing head down list
		if ( head ) {
			head.prev = node;
			node.next = head;
		} else {
			// If no head, follows that there's no tail (at initial or reset)
			tail = node;
		}

		// Trim tail if we're reached max size and are pending cache insertion
		if ( size === /** @type {MemizeOptions} */ ( options ).maxSize ) {
			tail = /** @type {MemizeCacheNode} */ ( tail ).prev;
			/** @type {MemizeCacheNode} */ ( tail ).next = null;
		} else {
			size++;
		}

		head = node;

		return node.val;
	}

	memoized.clear = function() {
		head = null;
		tail = null;
		size = 0;
	};

	if ( false ) {}

	// Ignore reason: There's not a clear solution to create an intersection of
	// the function with additional properties, where the goal is to retain the
	// function signature of the incoming argument and add control properties
	// on the return value.

	// @ts-ignore
	return memoized;
}

module.exports = memize;


/***/ }),

/***/ "./blocks/global/helpers.js":
/*!**********************************!*\
  !*** ./blocks/global/helpers.js ***!
  \**********************************/
/*! exports provided: classNames, hasValue, bsColumns, bsVariations, hasBackgroundClass, selfAlignClass, closest, arraySearch, onlyUnique, ALLOWED_MEDIA_TYPES, blockHasParent, parentAtts, updateClassesFromStyles, updateClassesFromAtts, parentType, alignControls, toggleIcon, toggleButton, editToggleButton, getActiveStyle, getStyleClasses, uniqueClasses, generateClasses, contentClasses, displayBGImage, buttonVariations, buttonOptions */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "classNames", function() { return classNames; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hasValue", function() { return hasValue; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "bsColumns", function() { return bsColumns; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "bsVariations", function() { return bsVariations; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hasBackgroundClass", function() { return hasBackgroundClass; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "selfAlignClass", function() { return selfAlignClass; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "closest", function() { return closest; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "arraySearch", function() { return arraySearch; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "onlyUnique", function() { return onlyUnique; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ALLOWED_MEDIA_TYPES", function() { return ALLOWED_MEDIA_TYPES; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "blockHasParent", function() { return blockHasParent; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parentAtts", function() { return parentAtts; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "updateClassesFromStyles", function() { return updateClassesFromStyles; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "updateClassesFromAtts", function() { return updateClassesFromAtts; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parentType", function() { return parentType; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "alignControls", function() { return alignControls; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "toggleIcon", function() { return toggleIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "toggleButton", function() { return toggleButton; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "editToggleButton", function() { return editToggleButton; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getActiveStyle", function() { return getActiveStyle; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "getStyleClasses", function() { return getStyleClasses; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "uniqueClasses", function() { return uniqueClasses; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "generateClasses", function() { return generateClasses; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "contentClasses", function() { return contentClasses; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "displayBGImage", function() { return displayBGImage; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "buttonVariations", function() { return buttonVariations; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "buttonOptions", function() { return buttonOptions; });
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "../node_modules/@babel/runtime/helpers/slicedToArray.js");
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/typeof */ "../node_modules/@babel/runtime/helpers/typeof.js");
/* harmony import */ var _babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "../node_modules/@babel/runtime/helpers/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var memize__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! memize */ "../node_modules/memize/index.js");
/* harmony import */ var memize__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(memize__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! lodash */ "lodash");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./icons */ "./blocks/global/icons.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @wordpress/editor */ "@wordpress/editor");
/* harmony import */ var _wordpress_editor__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_wordpress_editor__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var _wordpress_token_list__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! @wordpress/token-list */ "@wordpress/token-list");
/* harmony import */ var _wordpress_token_list__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(_wordpress_token_list__WEBPACK_IMPORTED_MODULE_13__);





function _createForOfIteratorHelper(o, allowArrayLike) { var it = typeof Symbol !== "undefined" && o[Symbol.iterator] || o["@@iterator"]; if (!it) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = it.call(o); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

/** ============================================================================
 * helpers
 *
 * @file
 *
 * @package   RIESTERWP Plugin
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ========================================================================== */



/**
 * WordPress dependencies
 */










var _ref = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_11__ || _wordpress_editor__WEBPACK_IMPORTED_MODULE_12__,
    InnerBlocks = _ref.InnerBlocks,
    InspectorControls = _ref.InspectorControls,
    BlockControls = _ref.BlockControls,
    AlignmentToolbar = _ref.AlignmentToolbar,
    MediaPlaceholder = _ref.MediaPlaceholder,
    MediaUpload = _ref.MediaUpload,
    MediaUploadCheck = _ref.MediaUploadCheck,
    getColorClassName = _ref.getColorClassName;

var classNames = __webpack_require__(/*! classnames/dedupe */ "../node_modules/classnames/dedupe.js");
function hasValue(variable) {
  if (typeof variable !== 'undefined' && variable != undefined && variable != null && variable != '' && variable != [] && variable != {}) {
    return true;
  } else {
    return false;
  }
}
var breakpoints = {
  Sm: {
    name: 'Phone Portrait',
    class: 'sm',
    width: 360
  },
  Ms: {
    name: 'Phone Landscape',
    class: 'ms',
    width: 576
  },
  Md: {
    name: 'Tablet Portrait',
    class: 'md',
    width: 768
  },
  Ml: {
    name: 'Tablet Landscape',
    class: 'Ml',
    width: 1024
  },
  Lg: {
    name: 'Small Desktop',
    class: 'Lg',
    width: 1280
  },
  Xl: {
    name: 'Large Desktop',
    class: 'Xl',
    width: 1440
  }
};
var columns = [];

for (var i = 0; i < 13; i++) {
  if (i !== 0) {
    var colPercent = i / 12;
    columns[i] = colPercent;
  }
}

var bsColumns = columns;
function bsVariations() {
  var title = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
  var attr = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
  return [{
    name: "".concat(attr, "-primary"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Primary ".concat(title), 'rwp')
  }, {
    name: "".concat(attr, "-secondary"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Secondary ".concat(title), 'rwp')
  }, {
    name: "".concat(attr, "-tertiary"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Tertiary ".concat(title), 'rwp')
  }, {
    name: "".concat(attr, "-info"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Info ".concat(title), 'rwp')
  }, {
    name: "".concat(attr, "-success"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Success ".concat(title), 'rwp')
  }, {
    name: "".concat(attr, "-warning"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Warning ".concat(title), 'rwp')
  }, {
    name: "".concat(attr, "-danger"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Danger ".concat(title), 'rwp')
  }, {
    name: "".concat(attr, "-light"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Light ".concat(title), 'rwp')
  }, {
    name: "".concat(attr, "-dark"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Dark ".concat(title), 'rwp')
  }, {
    name: "".concat(attr, "-white"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("White ".concat(title), 'rwp')
  }, {
    name: "".concat(attr, "-black"),
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Black ".concat(title), 'rwp')
  }];
}
function hasBackgroundClass() {
  var bgImageId = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 0;
  var backgroundColor = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
  var className = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '';
  var styles = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : [];
  var activeStyle = getActiveStyle(styles, className);
  var hasbgId = bgImageId != 0;
  var hasbgColor = false;
  var hasStyle = activeStyle != false && activeStyle !== 'default';

  if (backgroundColor != null) {
    if (backgroundColor.color !== undefined) {
      hasbgColor = true;
    }
  }

  var hasBG = hasbgId || hasbgColor || hasStyle;

  if (hasBG) {
    className = uniqueClasses(classNames(className, 'has-background'));
  } else {
    if (className.match(/has-background/)) {
      className = updateClassesFromAtts('', className, /has-background/);
    }
  }

  return className;
}
function selfAlignClass() {
  var align = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';
  var $type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'flex';

  if (align == undefined) {
    return;
  }

  var alignClass = '';

  if ($type === 'flex') {
    switch (align) {
      case 'left':
        alignClass = 'align-self-start';
        break;

      case 'center':
        alignClass = 'align-self-center';
        break;

      case 'right':
        alignClass = 'align-self-end';
        break;

      case 'wide':
        alignClass = 'align-self-stretch';
        break;

      case 'full':
        alignClass = 'w-100';
        break;
    }
  }

  return alignClass;
}
function closest(needle, haystack) {
  if (Array.isArray(haystack)) {
    return haystack.reduce(function (a, b) {
      var aDiff = Math.abs(a - needle);
      var bDiff = Math.abs(b - needle);

      if (aDiff === bDiff) {
        return a > b ? a : b;
      } else {
        return bDiff < aDiff ? b : a;
      }
    });
  } else {
    return false;
  }
}
function arraySearch(arr, val) {
  for (var _i = 0; _i < arr.length; _i++) {
    if (arr[_i] === val) return _i;
  }

  return false;
}
var onlyUnique = function onlyUnique(value, index, self) {
  return self.indexOf(value) === index;
};
var ALLOWED_MEDIA_TYPES = ['image'];
var blockHasParent = function blockHasParent(clientId) {
  var rootID = wp.data.select('core/block-editor').getBlockHierarchyRootClientId(clientId);
  return clientId !== rootID;
};
function parentAtts(childBlock) {
  if (blockHasParent(childBlock.clientId)) {
    var parents = wp.data.select('core/block-editor').getBlocksByClientId(childBlock.rootClientId);
    return parents[0];
  }
}
function updateClassesFromStyles(attr, className, classReg) {
  if (typeof attr !== 'undefined' && attr != undefined && attr !== '') {
    if (typeof className === 'string') {
      if (className.match(classReg)) {
        className = className.replace(classReg, attr);
      } else {
        className = classNames(attr, className);
      }
    } else if (typeof className === 'undefined') {
      className = attr;
    }
  }

  return className;
}
function updateClassesFromAtts(attr, className, classReg) {
  if (typeof attr !== 'undefined' && attr != undefined) {
    if (typeof className === 'string') {
      if (className.match(classReg)) {
        className = className.replace(classReg, attr);
      } else {
        className = classNames(attr, className);
      }
    } else if (typeof className === 'undefined') {
      className = attr;
    }
  }

  return className;
}
function parentType(childBlock) {
  if (blockHasParent(childBlock.clientId)) {
    var parentAttrs = parentAtts(childBlock);
    return parentAttrs.name;
  }
}

function justifyControls(controls) {
  var direction = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'horizontal';
  var prop = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'justify-content';
  return [{
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hAlignStart"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vAlignStart"],
    title: direction === 'horizontal' ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align ".concat(controls, " left"), 'rwp') : Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align ".concat(controls, " top"), 'rwp'),
    align: "".concat(prop, "-start")
  }, {
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hAlignCenter"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vAlignCenter"],
    title: direction === 'horizontal' ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align horizontally ".concat(controls, " center"), 'rwp') : Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align vertically ".concat(controls, " center"), 'rwp'),
    align: "".concat(prop, "-center")
  }, {
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hAlignEnd"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vAlignEnd"],
    title: direction === 'horizontal' ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align ".concat(controls, " right"), 'rwp') : Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align ".concat(controls, " end"), 'rwp'),
    align: "".concat(prop, "-end")
  }, {
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hDist"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vDist"],
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Space out ".concat(controls), 'rwp'),
    align: "".concat(prop, "-between")
  }, {
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hDist"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vDist"],
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Space around ".concat(controls), 'rwp'),
    align: "".concat(prop, "-around")
  }, {
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hAlignStart"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vAlignStart"],
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])('Default Alignment', 'rwp'),
    align: ''
  }];
}

function alignItemsControls(controls) {
  var direction = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'horizontal';
  var prop = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'align-items';
  return [{
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hAlignStart"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vAlignStart"],
    title: direction === 'horizontal' ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align ".concat(controls, " left"), 'rwp') : Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align ".concat(controls, " top"), 'rwp'),
    align: "".concat(prop, "-start")
  }, {
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hAlignCenter"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vAlignCenter"],
    title: direction === 'horizontal' ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align horizontally ".concat(controls, " center"), 'rwp') : Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align vertically ".concat(controls, " center"), 'rwp'),
    align: "".concat(prop, "-center")
  }, {
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hAlignEnd"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vAlignEnd"],
    title: direction === 'horizontal' ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align ".concat(controls, " right"), 'rwp') : Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Align ".concat(controls, " end"), 'rwp'),
    align: "".concat(prop, "-end")
  }, {
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hStretch"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vStretch"],
    title: direction === 'horizontal' ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Full width ".concat(controls), 'rwp') : Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])("Full Height ".concat(controls), 'rwp'),
    align: "".concat(prop, "-stretch")
  }, {
    icon: direction === 'horizontal' ? _icons__WEBPACK_IMPORTED_MODULE_8__["hAlignStart"] : _icons__WEBPACK_IMPORTED_MODULE_8__["vAlignStart"],
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])('Default Alignment', 'rwp'),
    align: ''
  }];
}

function alignControls(controls) {
  var direction = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'horizontal';
  var prop = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'justify-content';
  var hAlignControls = prop === 'justify-content' ? justifyControls(controls, direction) : alignItemsControls(controls, direction);
  var vAlignControls = prop === 'justify-content' ? justifyControls(controls, direction) : alignItemsControls(controls, direction);

  if (direction === 'vertical') {
    return vAlignControls;
  } else {
    return hAlignControls;
  }
}
function toggleIcon(attributes) {
  var iconPosition = attributes.iconPosition,
      closedIcon = attributes.closedIcon,
      openedIcon = attributes.openedIcon;

  if (iconPosition == null || iconPosition == '') {
    iconPosition = 'left';
  }

  iconPosition = 'icon-' + iconPosition;
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])("span", {
    className: classNames('btn-icon', iconPosition)
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])("i", {
    className: classNames('btn-icon-closed', closedIcon),
    ariaHidden: "true",
    role: "presentation"
  }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])("i", {
    className: classNames('btn-icon-opened', openedIcon),
    "aria-hidden": "true",
    role: "presentation"
  }));
}
function toggleButton(attributes) {
  var className = attributes.className,
      id = attributes.id,
      btnClasses = attributes.btnClasses,
      iconPosition = attributes.iconPosition,
      closedIcon = attributes.closedIcon,
      openedIcon = attributes.openedIcon,
      opened = attributes.opened,
      content = attributes.content;
  className = classNames(['btn', className]);
  var icon = toggleIcon(attributes);
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])("div", {
    className: classNames(['toggle-block d-flex align-items-center', "toggle-icon-".concat(iconPosition)])
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__["Button"], {
    id: id + '-header',
    className: className,
    type: "button",
    "data-toggle": "collapse",
    "data-target": '#' + id + '-body',
    "aria-expanded": opened,
    "aria-controls": id + '-body'
  }, icon), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])(RichText.Content, {
    tagName: "span",
    value: content,
    className: "toggle-text"
  }));
}
function editToggleButton(attributes, setAttributes) {
  var className = attributes.className,
      id = attributes.id,
      btnClasses = attributes.btnClasses,
      iconPosition = attributes.iconPosition,
      closedIcon = attributes.closedIcon,
      openedIcon = attributes.openedIcon,
      opened = attributes.opened,
      content = attributes.content;
  className = classNames(['btn', className]);
  var icon = toggleIcon(openedIcon, closedIcon, iconPosition);
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])("div", {
    className: classNames(['toggle-block d-flex align-items-center', "toggle-icon-".concat(iconPosition)])
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_9__["Button"], {
    id: id + '-header',
    className: className,
    type: "button",
    "data-toggle": "collapse",
    "data-target": '#' + id + '-body',
    "aria-expanded": opened,
    "aria-controls": id + '-body'
  }, icon), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])(RichText, {
    tagName: "span",
    value: content,
    onChange: function onChange(content) {
      return setAttributes({
        content: content
      });
    },
    placeholder: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])('Button Toggle Text...'),
    className: "toggle-text"
  }));
}

/**
 * Returns the active style from the given className.
 *
 * @param {Array} styles Block style variations.
 * @param {string} className  Class name
 *
 * @return {Object?} The active style.
 */

function getActiveStyle(styles, className) {
  var classes = new _wordpress_token_list__WEBPACK_IMPORTED_MODULE_13___default.a(className).values();

  var _iterator = _createForOfIteratorHelper(classes),
      _step;

  try {
    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      var style = _step.value;

      if (style.indexOf('is-style-') === -1) {
        continue;
      }

      var styleName = style.substring(9);

      if (styleName) {
        return styleName;
      }
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  return find(styles, {
    isDefault: true
  });
}
function getStyleClasses(props) {
  var attributes = props.attributes;
  var textColor = attributes.textColor,
      bgColor = attributes.bgColor,
      bgImage = attributes.bgImage,
      textAlignment = attributes.textAlignment,
      hAlign = attributes.hAlign,
      vAlign = attributes.vAlign,
      className = attributes.className,
      alignType = attributes.alignType;
  var classes = classNames(className, _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()({}, className, className != undefined));

  if (textColor != undefined) {
    textColor = "has-".concat(textColor, "-color");
    classes = updateClassesFromStyles(textColor, classes, /has-[\w-]*-color/);
  }

  if (bgColor != undefined) {
    bgColor = "has-".concat(bgColor, "-background-color");
    classes = updateClassesFromStyles(bgColor, classes, /has-[\w-]*-background-color/);
  }

  if (textAlignment != undefined && textAlignment != 'none' && textAlignment != 'default' && textAlignment != '') {
    textAlignment = "has-text-align-".concat(textAlignment);
    classes = updateClassesFromStyles(textAlignment, classes, /has-text-align-\w+/);
  }

  var hasBG = false;

  if (className != undefined) {
    if (className.match(/is-style[\w-]*/)) {
      if (className.match(/is-style-default/)) {
        hasBG = false;
      } else {
        hasBG = true;
      }
    }
  } else if (bgImage != undefined) {
    hasBG = true;
  } else if (bgColor != undefined) {
    hasBG = true;
  }

  classes = classNames(classes, className, _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()({}, 'has-background', hasBG));
  classes = uniqueClasses(classes);
  return classes;
}
function uniqueClasses() {
  var classes = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : [];

  if (Array.isArray(classes)) {
    classes = classes.split(' ');
    classes = classes.filter(onlyUnique);
    classes = classes.join(' ');
  }

  return classes;
}
/**
 * Generates classes from the attributes based on block type
 * @date 24/11/2020
 * @export
 * @param string blockName The name of the block
 * @param object attributes
 * @return string The classes
 */

function generateClasses(blockName, attributes) {
  var _classNames3, _classNames4;

  var classes = '';
  var type = '';

  if ('className' in attributes) {
    classes = classNames(classes, attributes.className);
  }

  if ('textColor' in attributes) {
    classes = updateClassesFromStyles(attributes.textColor, classes, /has-[\w-]*-color/);
  }

  if ('bgColor' in attributes) {
    classes = updateClassesFromStyles(attributes.bgColor, classes, /has-[\w-]*-background-color/);
  }

  if ('textAlignment' in attributes) {
    var textAlign = attributes.textAlignment != null ? 'has-text-align-' + attributes.textAlignment : '';
    classes = updateClassesFromStyles(textAlign, classes, /has-text-align-\w+/);
  }

  if (typeof blockName === 'string' && blockName.match('rwp/')) {
    type = blockName.replace('rwp/', '');
    blockName = blockName.replace('/', '-');
    classes = classNames('rwp', blockName);

    switch (type) {
      case 'section':
        classes = classNames(classes, 'section-wrapper', {
          'has-background': _babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_1___default()(attributes.bgImage) !== undefined && attributes.bgImage != null
        });
        break;

      case 'container':
        classes = classNames(classes, {
          'container-fluid': attributes.fluid,
          container: !attributes.fluid,
          'container-sm': attributes.fluidSm,
          'container-ms': attributes.fluidMs,
          'container-md': attributes.fluidMd,
          'container-ml': attributes.fluidMl,
          'container-lg': attributes.fluidLg,
          'container-xl': attributes.fluidXl
        });
        break;

      case 'card':
        classes = classNames(classes, attributes.textColorClass, attributes.bgColorClass, {
          'flex-column': attributes.layout == 'vertical',
          'flex-row': attributes.layout == 'horizontal'
        });
        break;

      case 'row':
        classes = classNames(classes, (_classNames3 = {}, _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames3, "row-cols-sm-".concat(attributes.rowColsSm), attributes.rowColsSm > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames3, "row-cols-ms-".concat(attributes.rowColsMs), attributes.rowColsMs > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames3, "row-cols-md-".concat(attributes.rowColsMd), attributes.rowColsMd > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames3, "row-cols-ml-".concat(attributes.rowColsMl), attributes.rowColsMl > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames3, "row-cols-lg-".concat(attributes.rowColsLg), attributes.rowColsLg > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames3, "row-cols-xl-".concat(attributes.rowColsXl), attributes.rowColsXl > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames3, "justify-content-".concat(attributes.hAlign), attributes.hAlign !== 'none'), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames3, "align-items-".concat(attributes.vAlign), attributes.vAlign !== 'none'), _classNames3));
        break;

      case 'column':
        classes = classNames(classes, 'col', (_classNames4 = {
          'col-sm-auto': attributes.autoSm,
          'col-ms-auto': attributes.autoMs,
          'col-md-auto': attributes.autoMd,
          'col-ml-auto': attributes.autoMl,
          'col-lg-auto': attributes.autoLg,
          'col-xl-auto': attributes.autoXl
        }, _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-sm-".concat(attributes.sizeSm), !attributes.autoSm && attributes.sizeSm > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-ms-".concat(attributes.sizeMs), !attributes.autoMs && attributes.sizeMs > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-md-".concat(attributes.sizeMd), !attributes.autoMd && attributes.sizeMd > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-ml-".concat(attributes.sizeMl), !attributes.autoMl && attributes.sizeMl > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-lg-".concat(attributes.sizeLg), !attributes.autoLg && attributes.sizeLg > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-xl-".concat(attributes.sizeXl), !attributes.autoXl && attributes.sizeXl > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-sm-".concat(attributes.offsetSm), attributes.offsetSm > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-ms-".concat(attributes.offsetMs), attributes.offsetMs > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-md-".concat(attributes.offsetMd), attributes.offsetMd > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-ml-".concat(attributes.offsetMl), attributes.offsetMl > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-lg-".concat(attributes.offsetLg), attributes.offsetLg > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames4, "col-xl-".concat(attributes.offsetXl), attributes.offsetXl > 0), _classNames4));
        break;

      case 'toggle-body':
        classes = classNames(classes, 'collapse', {
          show: attributes.isOpenBody
        });
        break;

      case 'toggle-button':
        classes = classNames(classes, 'btn');
        break;

      default:
        break;
    }
  } else if (blockName === 'core/image') {
    var _classNames5;

    var url = attributes.url,
        alt = attributes.alt,
        caption = attributes.caption,
        align = attributes.align,
        href = attributes.href,
        rel = attributes.rel,
        linkClass = attributes.linkClass,
        width = attributes.width,
        height = attributes.height,
        id = attributes.id,
        linkTarget = attributes.linkTarget,
        sizeSlug = attributes.sizeSlug,
        title = attributes.title;
    classes = classNames('media-wrapper', 'image-wrapper', (_classNames5 = {}, _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames5, "align".concat(align), align), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames5, "size-".concat(sizeSlug), sizeSlug), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames5, 'is-resized', width || height), _classNames5));
  } else if (blockName === 'core/column') {
    var _classNames6;

    classes = classNames(classes, 'col', (_classNames6 = {
      'col-sm-auto': attributes.autoSm,
      'col-ms-auto': attributes.autoMs,
      'col-md-auto': attributes.autoMd,
      'col-ml-auto': attributes.autoMl,
      'col-lg-auto': attributes.autoLg,
      'col-xl-auto': attributes.autoXl
    }, _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-sm-".concat(attributes.sizeSm), !attributes.autoSm && attributes.sizeSm > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-ms-".concat(attributes.sizeMs), !attributes.autoMs && attributes.sizeMs > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-md-".concat(attributes.sizeMd), !attributes.autoMd && attributes.sizeMd > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-ml-".concat(attributes.sizeMl), !attributes.autoMl && attributes.sizeMl > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-lg-".concat(attributes.sizeLg), !attributes.autoLg && attributes.sizeLg > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-xl-".concat(attributes.sizeXl), !attributes.autoXl && attributes.sizeXl > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-sm-".concat(attributes.offsetSm), attributes.offsetSm > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-ms-".concat(attributes.offsetMs), attributes.offsetMs > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-md-".concat(attributes.offsetMd), attributes.offsetMd > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-ml-".concat(attributes.offsetMl), attributes.offsetMl > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-lg-".concat(attributes.offsetLg), attributes.offsetLg > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames6, "col-xl-".concat(attributes.offsetXl), attributes.offsetXl > 0), _classNames6));
  } else if (blockName === 'core/columns') {
    var _classNames7;

    classes = classNames(classes, 'row', (_classNames7 = {}, _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames7, "row-cols-ms-".concat(attributes.rowColsMs), attributes.rowColsMs > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames7, "row-cols-md-".concat(attributes.rowColsMd), attributes.rowColsMd > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames7, "row-cols-ml-".concat(attributes.rowColsMl), attributes.rowColsMl > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames7, "row-cols-lg-".concat(attributes.rowColsLg), attributes.rowColsLg > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames7, "row-cols-xl-".concat(attributes.rowColsXl), attributes.rowColsXl > 0), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames7, "justify-content-".concat(attributes.hAlign), attributes.hAlign !== 'none'), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames7, "align-items-".concat(attributes.vAlign), attributes.vAlign !== 'none'), _classNames7));
  }

  classes = classes.split(' ');
  classes = classes.filter(onlyUnique);
  classes = classes.join(' ');
  return classes;
}
function contentClasses() {
  var _classNames8;

  var contentClass = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 'content-wrapper';
  var attributes = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {
    hAlign: 'none',
    vAlign: 'none'
  };
  var type = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 'flex';
  var hAlign = attributes.hAlign,
      vAlign = attributes.vAlign;
  return classNames(contentClass, (_classNames8 = {}, _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames8, "align-items-".concat(hAlign), hAlign !== 'none' && type === 'flex'), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames8, "justify-content-".concat(vAlign), vAlign !== 'none' && type === 'flex'), _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2___default()(_classNames8, "text-".concat(hAlign), hAlign !== 'none' && type === 'type'), _classNames8));
}

function imageSizes(image) {
  if (_babel_runtime_helpers_typeof__WEBPACK_IMPORTED_MODULE_1___default()(image) === 'object') {
    var sizes = [];

    if (image.sizes && image.mime_type !== 'image/svg+xml') {
      for (var _i2 = 0, _Object$entries = Object.entries(image.sizes); _i2 < _Object$entries.length; _i2++) {
        var _Object$entries$_i = _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0___default()(_Object$entries[_i2], 2),
            name = _Object$entries$_i[0],
            size = _Object$entries$_i[1];

        var url = new URL(size.url);
        url = url.pathname;
        sizes.push("".concat(url, " ").concat(size.width, "w ").concat(size.height, "h"));
      }
    }

    if (sizes.length > 1) {
      return sizes.join(', ');
    }
  }
}

function displayBGImage() {
  var srcset = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : '';

  if (srcset !== '') {
    return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__["createElement"])("div", {
      className: "section-bg is-bg lazyload",
      "data-sizes": "auto",
      "data-bgset": srcset
    });
  }
}
var solidVariations = bsVariations('Button', 'btn');
var outlineVariations = bsVariations('Button Outline', 'btn-outline');
var variations = solidVariations.concat(outlineVariations);
variations.push({
  name: 'btn-link',
  label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])('Plain link style', 'rwp')
});
var buttonOpts = [{
  label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])('Select an option', 'rwp'),
  value: ''
}];
variations.forEach(function (element) {
  buttonOpts.push({
    value: element.name,
    label: element.label
  });
});
var buttonVariations = variations;
var buttonOptions = buttonOpts;

/***/ }),

/***/ "./blocks/global/icons.js":
/*!********************************!*\
  !*** ./blocks/global/icons.js ***!
  \********************************/
/*! exports provided: wistiaIcon, desktopIcon, laptopIcon, tabletLandscapeIcon, tabletPortraitIcon, mobileIcon, vAlignEnd, vAlignCenter, vAlignStart, hDist, vDist, vStretch, hStretch, hAlignEnd, hAlignCenter, hAlignStart, plusOnly, plusFilled, dashOnly, bodyIcon, headerIcon, toggleIcon, buttonIcon, rowIcon, columnIcon, sectionIcon, containerIcon, cardIcon, templateIconMissing */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "wistiaIcon", function() { return wistiaIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "desktopIcon", function() { return desktopIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "laptopIcon", function() { return laptopIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "tabletLandscapeIcon", function() { return tabletLandscapeIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "tabletPortraitIcon", function() { return tabletPortraitIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mobileIcon", function() { return mobileIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "vAlignEnd", function() { return vAlignEnd; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "vAlignCenter", function() { return vAlignCenter; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "vAlignStart", function() { return vAlignStart; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hDist", function() { return hDist; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "vDist", function() { return vDist; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "vStretch", function() { return vStretch; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hStretch", function() { return hStretch; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hAlignEnd", function() { return hAlignEnd; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hAlignCenter", function() { return hAlignCenter; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "hAlignStart", function() { return hAlignStart; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "plusOnly", function() { return plusOnly; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "plusFilled", function() { return plusFilled; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "dashOnly", function() { return dashOnly; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "bodyIcon", function() { return bodyIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "headerIcon", function() { return headerIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "toggleIcon", function() { return toggleIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "buttonIcon", function() { return buttonIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "rowIcon", function() { return rowIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "columnIcon", function() { return columnIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "sectionIcon", function() { return sectionIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "containerIcon", function() { return containerIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "cardIcon", function() { return cardIcon; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "templateIconMissing", function() { return templateIconMissing; });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);


/** ============================================================================
 * icons
 *
 * @file
 *
 * @package   row
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ========================================================================== */

/**
 * Backport from Gutenberg 5.5
 * Source: https://github.com/WordPress/gutenberg/blob/master/packages/block-editor/src/components/block-vertical-alignment-toolbar/icons.js
 */

var wistiaIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M15.85,4.41C16.2,2.35,15,1.78,15,1.78s.06,1.68-3,2C9.26,4.14.08,3.89.08,3.89l3,3.4A2.49,2.49,0,0,0,5.16,8.38q2.12.07,4.23-.06a9.82,9.82,0,0,0,5-1.7A3.93,3.93,0,0,0,15.85,4.41Z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M16,6.54a6.05,6.05,0,0,1-2.21,1.91A11.07,11.07,0,0,1,9.25,9.67c-1.14.12-3.22,0-4.12,0A2.36,2.36,0,0,0,3,10.8L0,14.15H1.81c.78,0,5.67.29,7.82-.3C16.67,11.9,16,6.54,16,6.54Z"
}));
var desktopIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M1.45.73A1.45,1.45,0,0,0,0,2.18v8.73a1.45,1.45,0,0,0,1.45,1.45h5.1a1.46,1.46,0,0,1-1.46,1.46v1.45h5.82V13.82a1.46,1.46,0,0,1-1.46-1.46h5.1A1.45,1.45,0,0,0,16,10.91V2.18A1.45,1.45,0,0,0,14.55.73Zm0,1.45h13.1V9.45H1.45Zm6.55,8a.73.73,0,1,1-.73.73A.73.73,0,0,1,8,10.18Z"
}));
var laptopIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M2.67,2.67A1.34,1.34,0,0,0,1.33,4v6.67A1.34,1.34,0,0,0,2.67,12H0v1.33H16V12H13.33a1.34,1.34,0,0,0,1.34-1.33V4a1.34,1.34,0,0,0-1.34-1.33ZM2.67,4H13.33v6.67H2.67Z"
}));
var tabletLandscapeIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M16,12V4a1.82,1.82,0,0,0-1.82-1.82H1.82A1.82,1.82,0,0,0,0,4v8a1.82,1.82,0,0,0,1.82,1.82H14.18A1.82,1.82,0,0,0,16,12ZM.64,8a.82.82,0,1,1,.81.82A.82.82,0,0,1,.64,8Zm2.27,4.36V3.64H14.55v8.72Z"
}));
var tabletPortraitIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M12,0H4A1.82,1.82,0,0,0,2.18,1.82V14.18A1.82,1.82,0,0,0,4,16h8a1.82,1.82,0,0,0,1.82-1.82V1.82A1.82,1.82,0,0,0,12,0ZM8,15.36a.82.82,0,1,1,.82-.81A.82.82,0,0,1,8,15.36Zm4.36-2.27H3.64V1.45h8.72Z"
}));
var mobileIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M13.09,14.18V1.82A1.81,1.81,0,0,0,11.27,0H4.73A1.81,1.81,0,0,0,2.91,1.82V14.18A1.81,1.81,0,0,0,4.73,16h6.54A1.81,1.81,0,0,0,13.09,14.18Zm-1.45.37H4.36V1.45H5.55l.52,1.06a.74.74,0,0,0,.65.4H9.25a.75.75,0,0,0,.65-.4l.52-1.06h1.22Z"
}));
var vAlignEnd = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M6 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V2z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M1 14.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5z"
}));
var vAlignCenter = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M6 13a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v10zM1 8a.5.5 0 0 0 .5.5H6v-1H1.5A.5.5 0 0 0 1 8zm14 0a.5.5 0 0 1-.5.5H10v-1h4.5a.5.5 0 0 1 .5.5z"
}));
var vAlignStart = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M6 14a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v10z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M1 1.5a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 0-1h-13a.5.5 0 0 0-.5.5z"
}));
var hDist = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M14.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 1 0v-13a.5.5 0 0 0-.5-.5zm-13 0a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 1 0v-13a.5.5 0 0 0-.5-.5z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M6 13a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v10z"
}));
var vDist = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M1 1.5a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 0-1h-13a.5.5 0 0 0-.5.5zm0 13a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 0-1h-13a.5.5 0 0 0-.5.5z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M2 7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7z"
}));
var vStretch = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M2.75,3.12a.38.38,0,0,0,.37.38h9.76a.38.38,0,0,0,0-.75H3.12A.38.38,0,0,0,2.75,3.12Z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M2.75,12.88a.38.38,0,0,0,.37.37h9.76a.38.38,0,0,0,0-.75H3.12A.38.38,0,0,0,2.75,12.88Z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M3.5,7.25a.75.75,0,0,1,.75-.75h7.5a.75.75,0,0,1,.75.75v1.5a.76.76,0,0,1-.75.75H4.25a.76.76,0,0,1-.75-.75Z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M9.39,5.4,8.19,4.2A.27.27,0,0,0,8,4.12H8a.27.27,0,0,0-.19.08L6.61,5.4a.28.28,0,0,0,.19.47h0A.27.27,0,0,0,7,5.79l1-1,1,1a.26.26,0,0,0,.38,0A.27.27,0,0,0,9.39,5.4Z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M9.4,10.2a.28.28,0,0,0-.2-.08h0A.27.27,0,0,0,9,10.2l-1,1-1-1a.29.29,0,0,0-.39,0,.28.28,0,0,0,0,.39L7.81,11.8a.27.27,0,0,0,.38,0L9.4,10.59a.27.27,0,0,0,.08-.19A.28.28,0,0,0,9.4,10.2Z"
}));
var hStretch = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M12.88,2.75a.38.38,0,0,0-.38.37v9.76a.38.38,0,0,0,.75,0V3.12A.38.38,0,0,0,12.88,2.75Z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M3.12,2.75a.38.38,0,0,0-.37.37v9.76a.38.38,0,0,0,.75,0V3.12A.38.38,0,0,0,3.12,2.75Z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M8.75,3.5a.75.75,0,0,1,.75.75v7.5a.75.75,0,0,1-.75.75H7.25a.76.76,0,0,1-.75-.75V4.25a.76.76,0,0,1,.75-.75Z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M10.6,9.39l1.2-1.2A.27.27,0,0,0,11.88,8h0a.27.27,0,0,0-.08-.19l-1.2-1.2a.28.28,0,0,0-.47.19h0a.27.27,0,0,0,.08.2l1,1-1,1a.26.26,0,0,0,0,.38A.27.27,0,0,0,10.6,9.39Z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M5.8,9.4a.28.28,0,0,0,.08-.2h0A.27.27,0,0,0,5.8,9l-1-1,1-1a.29.29,0,0,0,0-.39.28.28,0,0,0-.39,0L4.2,7.81a.27.27,0,0,0,0,.38L5.41,9.4a.27.27,0,0,0,.19.08A.28.28,0,0,0,5.8,9.4Z"
}));
var hAlignEnd = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M14.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 1 0v-13a.5.5 0 0 0-.5-.5z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M13 7a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7z"
}));
var hAlignCenter = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M8 1a.5.5 0 0 1 .5.5V6h-1V1.5A.5.5 0 0 1 8 1zm0 14a.5.5 0 0 1-.5-.5V10h1v4.5a.5.5 0 0 1-.5.5zM2 7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7z"
}));
var hAlignStart = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M1.5 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M3 7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7z"
}));
var plusOnly = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  className: "bi bi-plus btn-icon-closed",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"
}));
var plusFilled = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  className: "bi bi-plus-square-fill",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"
}));
var dashOnly = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  className: "bi bi-dash btn-icon-opened",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"
}));
var bodyIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M2.56.61A1.58,1.58,0,0,0,1,2.17V13.83a1.58,1.58,0,0,0,1.56,1.56H13.44A1.58,1.58,0,0,0,15,13.83V2.17A1.58,1.58,0,0,0,13.44.61Zm0,1.56H13.44V13.83H2.56Zm1.55.77V4.5h7.78V2.94Zm0,3.12V9.94h7.78V6.06Zm0,5.44v1.56h7.78V11.5Z"
}));
var headerIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M2.56,1A1.58,1.58,0,0,0,1,2.56V15H2.56V2.56H13.44V15H15V2.56A1.58,1.58,0,0,0,13.44,1ZM4.11,4.11V7.22h7.78V4.11Zm0,6.22v1.56h7.78V10.33Zm0,3.11V15H9.56V13.44Z"
}));
var toggleIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M2,1.5a1,1,0,0,0-1,1v10H7.26a4.7,4.7,0,0,1-.23-1H2v-7H13V6.76a4.45,4.45,0,0,1,1,.5V2.5a1,1,0,0,0-1-1ZM4,6a.5.5,0,1,0,.5.5A.5.5,0,0,0,4,6ZM6,6A.5.5,0,0,0,6,7H9.44A4.58,4.58,0,0,1,11,6.53s0,0,0,0a.5.5,0,0,0-.5-.5Zm5.5,1.5A3.5,3.5,0,1,0,15,11,3.5,3.5,0,0,0,11.5,7.5ZM4,8a.5.5,0,1,0,.5.5A.5.5,0,0,0,4,8ZM6,8A.5.5,0,0,0,6,9H7.47a4.9,4.9,0,0,1,.68-1Zm5.5,1a.5.5,0,0,1,.5.5v1h1a.5.5,0,0,1,0,1H12v1a.5.5,0,0,1-1,0v-1H10a.5.5,0,0,1,0-1h1v-1A.5.5,0,0,1,11.5,9Z"
}));
var buttonIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M2.12,4.36A1.12,1.12,0,0,0,1,5.48v5a1.12,1.12,0,0,0,1.12,1.12H13.88A1.12,1.12,0,0,0,15,10.52v-5a1.12,1.12,0,0,0-1.12-1.12Zm8.27,2.89a.74.74,0,0,1,.77.83.78.78,0,1,1-1.55,0A.74.74,0,0,1,10.39,7.25Zm-7.45,0h.73c.32,0,.5.15.5.39A.34.34,0,0,1,3.88,8V8a.38.38,0,0,1,.37.37c0,.28-.22.46-.56.46H2.94Zm1.7,0h.41v1a.28.28,0,1,0,.55,0v-1H6v1a.6.6,0,0,1-.68.59.6.6,0,0,1-.68-.59Zm1.76,0H7.71v.32H7.26V8.87h-.4V7.61H6.4ZM8,7.29H9.34v.32H8.88V8.87h-.4V7.61H8Zm3.54,0h.32l.66.89h0V7.29H13V8.87h-.32L12,8h0v.9h-.38Zm-8.23.28v.36h.21c.15,0,.23-.07.23-.18s-.08-.18-.22-.18Zm7.05,0c-.23,0-.37.19-.37.5s.14.5.37.5.37-.2.37-.5S10.61,7.58,10.39,7.58Zm-7,.6v.41h.24c.17,0,.26-.08.26-.21s-.1-.2-.26-.2Z"
}));
var rowIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "1em",
  height: "1em",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M16,5.74V2.26a.35.35,0,0,0-.35-.35H.35A.35.35,0,0,0,0,2.26V5.74ZM0,6.43H16V9.57H0Zm0,3.83v3.48a.35.35,0,0,0,.35.35h15.3a.35.35,0,0,0,.35-.35V10.26Z"
}));
var columnIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "1em",
  height: "1em",
  viewBox: "0 0 16 16",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M.36,1.09A.37.37,0,0,0,0,1.47V14.53a.37.37,0,0,0,.36.38H4.73V1.09Zm5.09,0V14.91h5.1V1.09Zm5.82,0V14.91h4.37a.37.37,0,0,0,.36-.39v-13a.37.37,0,0,0-.36-.38Z"
}));
var sectionIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "1em",
  height: "1em",
  viewBox: "0 0 16 16",
  fill: "currentColor",
  style: {
    minWidth: '16px'
  }
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M.36,1.09A.37.37,0,0,0,0,1.47V7.64H4.73V1.09Zm5.09,0V7.64h5.1V1.09Zm5.82,0V7.64H16V1.47a.37.37,0,0,0-.36-.38ZM0,8.36v6.16a.37.37,0,0,0,.36.39H4.73V8.36Zm5.45,0v6.55h5.1V8.36Zm5.82,0v6.55h4.37a.37.37,0,0,0,.36-.39V8.36Z"
}));
var containerIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "1em",
  height: "1em",
  viewBox: "0 0 16 16",
  fill: "currentColor",
  style: {
    minWidth: '16px'
  }
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M.35,1.91A.35.35,0,0,0,0,2.26V13.74a.35.35,0,0,0,.35.35h15.3a.35.35,0,0,0,.35-.35V2.26a.35.35,0,0,0-.35-.35Zm.35.7H15.3V5.74H.7Zm0,3.82H15.3V9.57H.7Zm0,3.83H15.3v3.13H.7Z"
}));
var cardIcon = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  xmlns: "http://www.w3.org/2000/svg",
  width: "1em",
  height: "1em",
  viewBox: "0 0 16 16",
  fill: "currentColor",
  className: "bi bi-card-text",
  style: {
    minWidth: '16px'
  }
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"
}), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"
}));
var templateIconMissing = Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["SVG"], {
  width: "16",
  height: "16",
  viewBox: "0 0 16 16",
  xmlns: "http://www.w3.org/2000/svg",
  fill: "currentColor"
}, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Path"], {
  fillRule: "evenodd",
  d: "M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"
}));

/***/ }),

/***/ "./blocks/toggle/block.json":
/*!**********************************!*\
  !*** ./blocks/toggle/block.json ***!
  \**********************************/
/*! exports provided: apiVersion, name, title, category, attributes, providesContext, supports, default */
/***/ (function(module) {

module.exports = JSON.parse("{\"apiVersion\":2,\"name\":\"rwp/toggle\",\"title\":\"Toggle\",\"category\":\"design\",\"attributes\":{\"isOpen\":{\"type\":\"boolean\",\"default\":false},\"toggleId\":{\"type\":\"string\"}},\"providesContext\":{\"rwp-toggle/isOpen\":\"isOpen\",\"rwp-toggle/toggleId\":\"toggleId\"},\"supports\":{\"anchor\":true}}");

/***/ }),

/***/ "./blocks/toggle/edit.js":
/*!*******************************!*\
  !*** ./blocks/toggle/edit.js ***!
  \*******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/dom-ready */ "@wordpress/dom-ready");
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _global_helpers__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ../global/helpers */ "./blocks/global/helpers.js");


/** ============================================================================
 * edit
 *
 * @file
 *
 * @package   RIESTERWP Plugin
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ========================================================================== */


var _ = __webpack_require__(/*! lodash */ "lodash");





 //import './edit.scss';


var BLOCK_TEMPLATE = [['rwp/toggle-bar', {}], ['rwp/toggle-body', {}]];
var ALLOWED_BLOCKS = ['rwp/toggle-bar', 'rwp/toggle-body'];
var TEMPLATE_LOCK = 'all';
wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/toggle', function (className, blockName) {
  if (blockName !== 'rwp/toggle') {
    return className;
  }

  className = Object(_global_helpers__WEBPACK_IMPORTED_MODULE_7__["classNames"])('rwp', 'rwp-toggle');
  return className;
});

function toggleEdit(props) {
  var attributes = props.attributes,
      setAttributes = props.setAttributes,
      clientId = props.clientId;
  var className = attributes.className,
      isOpen = attributes.isOpen,
      toggleId = attributes.toggleId;
  var blockProps = Object(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__["useBlockProps"])();
  var newId = 'rwp-toggle-' + clientId.replace(/(-\w*)/g, '');

  if (_.isNil(toggleId) || _.isEmpty(toggleId)) {
    setAttributes({
      toggleId: newId
    });
  }

  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", blockProps, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__["InspectorControls"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__["PanelBody"], {
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('Toggle Settings', 'rwp'),
    initialOpen: true
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__["PanelRow"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__["ToggleControl"], {
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('Is toggle body initially opened?', 'rwp'),
    checked: isOpen,
    onChange: function onChange(val) {
      return setAttributes({
        isOpen: val
      });
    }
  })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__["PanelRow"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__["TextControl"], {
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('Toggle ID', 'rwp'),
    value: toggleId,
    onChange: function onChange(val) {
      return setAttributes({
        toggleId: val
      });
    }
  })))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_5__["InnerBlocks"], {
    template: BLOCK_TEMPLATE,
    templateLock: TEMPLATE_LOCK,
    allowedBlocks: ALLOWED_BLOCKS
  }));
}

/* harmony default export */ __webpack_exports__["default"] = (toggleEdit);

/***/ }),

/***/ "./blocks/toggle/index.js":
/*!********************************!*\
  !*** ./blocks/toggle/index.js ***!
  \********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _global_icons__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../global/icons */ "./blocks/global/icons.js");
/* harmony import */ var _toggle_bar__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./toggle-bar */ "./blocks/toggle/toggle-bar/index.js");
/* harmony import */ var _toggle_body__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./toggle-body */ "./blocks/toggle/toggle-body/index.js");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./edit */ "./blocks/toggle/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./block.json */ "./blocks/toggle/block.json");
var _block_json__WEBPACK_IMPORTED_MODULE_5___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./block.json */ "./blocks/toggle/block.json", 1);
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./save */ "./blocks/toggle/save.js");
/* harmony import */ var _variations__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./variations */ "./blocks/toggle/variations.js");
/**
 * ============================================================================
 * BLOCK: rwp/toggle
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */








var name = _block_json__WEBPACK_IMPORTED_MODULE_5__.name;
var settings = Object.assign(_block_json__WEBPACK_IMPORTED_MODULE_5__, {
  icon: _global_icons__WEBPACK_IMPORTED_MODULE_1__["toggleIcon"],
  variations: _variations__WEBPACK_IMPORTED_MODULE_7__["default"],
  edit: _edit__WEBPACK_IMPORTED_MODULE_4__["default"],
  save: _save__WEBPACK_IMPORTED_MODULE_6__["default"]
});
Object(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__["registerBlockType"])(name, settings);

/***/ }),

/***/ "./blocks/toggle/save.js":
/*!*******************************!*\
  !*** ./blocks/toggle/save.js ***!
  \*******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return Save; });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);


/** ============================================================================
 * save
 *
 * @file
 *
 * @package   __kebabCase_name__
 * @since     <<projectversion>>
 * @version   <<projectversion>>
 * @author    Sam Rankin <you@you.you>
 * @copyright 2020 RIESTER
 * ========================================================================== */

function Save() {
  var blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__["useBlockProps"].save();
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", blockProps, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__["InnerBlocks"].Content, null));
}

/***/ }),

/***/ "./blocks/toggle/toggle-bar/block.json":
/*!*********************************************!*\
  !*** ./blocks/toggle/toggle-bar/block.json ***!
  \*********************************************/
/*! exports provided: apiVersion, name, title, category, parent, icon, supports, attributes, usesContext, default */
/***/ (function(module) {

module.exports = JSON.parse("{\"apiVersion\":2,\"name\":\"rwp/toggle-bar\",\"title\":\"Toggle Bar\",\"category\":\"design\",\"parent\":\"rwp/toggle\",\"icon\":\"feedback\",\"supports\":{\"inserter\":false},\"attributes\":{\"toggleBarIsOpen\":{\"type\":\"boolean\",\"default\":false},\"toggleBarId\":{\"type\":\"string\",\"default\":\"\"},\"buttonStyle\":{\"type\":\"string\",\"default\":\"btn-outline-primary\"},\"openedIcon\":{\"type\":\"string\",\"default\":\"glaza glaza-minus\"},\"closedIcon\":{\"type\":\"string\",\"default\":\"glaza glaza-plus\"},\"iconPosition\":{\"type\":\"string\",\"default\":\"left\"}},\"usesContext\":[\"rwp-toggle/isOpen\",\"rwp-toggle/toggleId\"]}");

/***/ }),

/***/ "./blocks/toggle/toggle-bar/edit.js":
/*!******************************************!*\
  !*** ./blocks/toggle/toggle-bar/edit.js ***!
  \******************************************/
/*! exports provided: createToggleButtonAtts, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "createToggleButtonAtts", function() { return createToggleButtonAtts; });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _global_helpers__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../global/helpers */ "./blocks/global/helpers.js");


/**
 * ============================================================================
 * edit
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */
var _ = __webpack_require__(/*! lodash */ "lodash");





 //import './edit.scss';


var BLOCK_TEMPLATE = [['core/paragraph', {
  placeholder: 'Toggle Bar Content'
}]];
var ALLOWED_BLOCKS = [];
var TEMPLATE_LOCK = false;
wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/toggle-bar', function (className, blockName) {
  if (blockName !== 'rwp/toggle-bar') {
    return className;
  }

  className = Object(_global_helpers__WEBPACK_IMPORTED_MODULE_6__["classNames"])('rwp', 'rwp-toggle-bar');
  return className;
});
function createToggleButtonAtts(attributes) {
  var iconPosition = attributes.iconPosition,
      buttonStyle = attributes.buttonStyle,
      openedIcon = attributes.openedIcon,
      closedIcon = attributes.closedIcon,
      toggleBarIsOpen = attributes.toggleBarIsOpen,
      toggleBarId = attributes.toggleBarId,
      className = attributes.className;
  var classes = Object(_global_helpers__WEBPACK_IMPORTED_MODULE_6__["classNames"])('btn', 'btn-toggle', buttonStyle, "btn-toggle-".concat(iconPosition));
  return {
    className: classes,
    type: 'button',
    'data-toggle': 'collapse',
    'aria-expanded': toggleBarIsOpen,
    id: "".concat(toggleBarId, "-header"),
    'aria-controls': "".concat(toggleBarId, "-body"),
    'data-target': "#".concat(toggleBarId, "-body")
  };
}

function toggleBarEdit(props) {
  var attributes = props.attributes,
      setAttributes = props.setAttributes,
      clientId = props.clientId,
      isSelected = props.isSelected,
      hasInnerBlocks = props.hasInnerBlocks,
      name = props.name,
      context = props.context;
  var className = attributes.className,
      toggleBarIsOpen = attributes.toggleBarIsOpen,
      toggleBarId = attributes.toggleBarId,
      iconPosition = attributes.iconPosition,
      buttonStyle = attributes.buttonStyle,
      openedIcon = attributes.openedIcon,
      closedIcon = attributes.closedIcon;
  var isOpen = context['rwp-toggle/isOpen'];
  var toggleId = context['rwp-toggle/toggleId'];

  if (!_.isNil(toggleId)) {
    setAttributes({
      toggleBarId: toggleId
    });
  }

  if (!_.isNil(isOpen)) {
    setAttributes({
      toggleBarIsOpen: isOpen
    });
  }

  var blockProps = Object(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__["useBlockProps"])();
  var btnProps = createToggleButtonAtts(attributes);
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Flex"], blockProps, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__["InspectorControls"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["PanelBody"], {
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Toggle Bar Settings', 'rwp'),
    initialOpen: true
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["PanelRow"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["SelectControl"], {
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Button Style'),
    value: buttonStyle,
    onChange: function onChange(val) {
      setAttributes({
        buttonStyle: val
      });
    },
    options: _global_helpers__WEBPACK_IMPORTED_MODULE_6__["buttonOptions"]
  })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["PanelRow"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("label", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Icon Position', 'rwp')), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["ButtonGroup"], {
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Icon Position', 'rwp')
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Button"], {
    value: 'left',
    isPrimary: iconPosition === 'left',
    isSecondary: iconPosition !== 'left',
    onClick: function onClick(val) {
      return setAttributes({
        iconPosition: 'left'
      });
    }
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Left', 'rwp')), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Button"], {
    value: 'right',
    isPrimary: iconPosition === 'right',
    isSecondary: iconPosition !== 'right',
    onClick: function onClick(val) {
      return setAttributes({
        iconPosition: 'right'
      });
    }
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Right', 'rwp')))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["PanelRow"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["TextControl"], {
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Opened Icon Classes', 'rwp'),
    value: openedIcon,
    onChange: function onChange(val) {
      return setAttributes({
        openedIcon: val
      });
    }
  })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["PanelRow"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["TextControl"], {
    label: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__["__"])('Closed Icon Classes', 'rwp'),
    value: closedIcon,
    onChange: function onChange(val) {
      return setAttributes({
        closedIcon: val
      });
    }
  })))), iconPosition === 'left' ? Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["Fragment"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["FlexItem"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Button"], btnProps, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("span", {
    className: "btn-icon"
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Icon"], {
    icon: closedIcon,
    className: Object(_global_helpers__WEBPACK_IMPORTED_MODULE_6__["classNames"])('btn-icon-closed', closedIcon),
    "aria-hidden": "true",
    role: "presentation"
  }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Icon"], {
    icon: openedIcon,
    className: Object(_global_helpers__WEBPACK_IMPORTED_MODULE_6__["classNames"])('btn-icon-opened', openedIcon),
    "aria-hidden": "true",
    role: "presentation"
  })))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["FlexBlock"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__["InnerBlocks"], {
    template: BLOCK_TEMPLATE,
    orientation: "horizontal",
    templateLock: TEMPLATE_LOCK
  }))) : Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["Fragment"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["FlexBlock"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__["InnerBlocks"], {
    template: BLOCK_TEMPLATE,
    templateLock: TEMPLATE_LOCK,
    orientation: "horizontal"
  })), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["FlexItem"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Button"], btnProps, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("span", {
    className: "btn-icon"
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Icon"], {
    icon: closedIcon,
    className: Object(_global_helpers__WEBPACK_IMPORTED_MODULE_6__["classNames"])('btn-icon-closed', closedIcon),
    "aria-hidden": "true",
    role: "presentation"
  }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__["Icon"], {
    icon: openedIcon,
    className: Object(_global_helpers__WEBPACK_IMPORTED_MODULE_6__["classNames"])('btn-icon-opened', openedIcon),
    "aria-hidden": "true",
    role: "presentation"
  }))))));
}

/* harmony default export */ __webpack_exports__["default"] = (toggleBarEdit);

/***/ }),

/***/ "./blocks/toggle/toggle-bar/index.js":
/*!*******************************************!*\
  !*** ./blocks/toggle/toggle-bar/index.js ***!
  \*******************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./edit */ "./blocks/toggle/toggle-bar/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./block.json */ "./blocks/toggle/toggle-bar/block.json");
var _block_json__WEBPACK_IMPORTED_MODULE_2___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./block.json */ "./blocks/toggle/toggle-bar/block.json", 1);
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./blocks/toggle/toggle-bar/save.js");
/* harmony import */ var _variations__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./variations */ "./blocks/toggle/toggle-bar/variations.js");
/**
 * ============================================================================
 * BLOCK: rwp/toggle-bar
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */
 // import { toggleBarIcon as icon } from '../global/icons';




 //import './index.scss';

var name = _block_json__WEBPACK_IMPORTED_MODULE_2__.name;
var settings = Object.assign(_block_json__WEBPACK_IMPORTED_MODULE_2__, {
  //icon,
  variations: _variations__WEBPACK_IMPORTED_MODULE_4__["default"],
  edit: _edit__WEBPACK_IMPORTED_MODULE_1__["default"],
  save: _save__WEBPACK_IMPORTED_MODULE_3__["default"]
});
Object(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__["registerBlockType"])(name, settings);

/***/ }),

/***/ "./blocks/toggle/toggle-bar/save.js":
/*!******************************************!*\
  !*** ./blocks/toggle/toggle-bar/save.js ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return Save; });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./blocks/toggle/toggle-bar/edit.js");
/* harmony import */ var _global_helpers__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../global/helpers */ "./blocks/global/helpers.js");


/**
 * ============================================================================
 * save
 *
 * @file
 * @package
 * @since     <<projectversion>>
 * @version   <<projectversion>>
 * @author    Sam Rankin <you@you.you>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */



function Save(_ref) {
  var attributes = _ref.attributes;
  var blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__["useBlockProps"].save();
  var btnProps = Object(_edit__WEBPACK_IMPORTED_MODULE_2__["createToggleButtonAtts"])(attributes);
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", blockProps, attributes.iconPosition === 'left' ? Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["Fragment"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("button", btnProps, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("span", {
    className: "btn-icon"
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("i", {
    className: Object(_global_helpers__WEBPACK_IMPORTED_MODULE_3__["classNames"])('btn-icon-closed', attributes.closedIcon),
    "aria-hidden": "true",
    role: "presentation"
  }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("i", {
    className: Object(_global_helpers__WEBPACK_IMPORTED_MODULE_3__["classNames"])('btn-icon-opened', attributes.openedIcon),
    "aria-hidden": "true",
    role: "presentation"
  }))), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
    className: "toggle-bar-content"
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__["InnerBlocks"].Content, null))) : Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["Fragment"], null, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", {
    className: "toggle-bar-content"
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__["InnerBlocks"].Content, null)), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("button", btnProps, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("span", {
    className: "btn-icon"
  }, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("i", {
    className: Object(_global_helpers__WEBPACK_IMPORTED_MODULE_3__["classNames"])('btn-icon-closed', attributes.closedIcon),
    "aria-hidden": "true",
    role: "presentation"
  }), Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("i", {
    className: Object(_global_helpers__WEBPACK_IMPORTED_MODULE_3__["classNames"])('btn-icon-opened', attributes.openedIcon),
    "aria-hidden": "true",
    role: "presentation"
  })))));
}

/***/ }),

/***/ "./blocks/toggle/toggle-bar/variations.js":
/*!************************************************!*\
  !*** ./blocks/toggle/toggle-bar/variations.js ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/**
 * ============================================================================
 * variations
 *
 * @file
 * @package
 * @since     <<projectversion>>
 * @version   <<projectversion>>
 * @author    Sam Rankin <you@you.you>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

/**
 * WordPress dependencies
 */

/** @typedef {import('@wordpress/blocks').WPBlockVariation} WPBlockVariation */

/**
 * Template option choices for predefined columns layouts.
 *
 * @type {WPBlockVariation[]}
 */

var variations = [// {
  //     name: '',
  //     title: __('', 'rwp'),
  //     description: __('', 'rwp'),
  //     icon: '',
  //     innerBlocks: [],
  //     scope: ['block'],
  // },
];
/* harmony default export */ __webpack_exports__["default"] = (variations);

/***/ }),

/***/ "./blocks/toggle/toggle-body/block.json":
/*!**********************************************!*\
  !*** ./blocks/toggle/toggle-body/block.json ***!
  \**********************************************/
/*! exports provided: apiVersion, name, title, category, icon, attributes, usesContext, parent, supports, default */
/***/ (function(module) {

module.exports = JSON.parse("{\"apiVersion\":2,\"name\":\"rwp/toggle-body\",\"title\":\"Toggle Body\",\"category\":\"design\",\"icon\":\"feedback\",\"attributes\":{\"toggleBodyIsOpen\":{\"type\":\"boolean\",\"default\":false},\"toggleBodyId\":{\"type\":\"string\",\"default\":\"\"}},\"usesContext\":[\"rwp-toggle/isOpen\",\"rwp-toggle/toggleId\"],\"parent\":[\"rwp/toggle\"],\"supports\":{\"inserter\":false,\"multiple\":false}}");

/***/ }),

/***/ "./blocks/toggle/toggle-body/edit.js":
/*!*******************************************!*\
  !*** ./blocks/toggle/toggle-body/edit.js ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/compose */ "@wordpress/compose");
/* harmony import */ var _wordpress_compose__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_compose__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _global_helpers__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../../global/helpers */ "./blocks/global/helpers.js");


/** ============================================================================
 * edit
 *
 * @file
 *
 * @package   RIESTERWP Plugin
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ========================================================================== */
var _ = __webpack_require__(/*! lodash */ "lodash");





 //import './edit.scss';


var BLOCK_TEMPLATE = [['core/paragraph', {
  placeholder: 'Toggle Body Content'
}]];
var ALLOWED_BLOCKS = [];
var TEMPLATE_LOCK = false;
wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/toggle-body', function (className, blockName) {
  if (blockName !== 'rwp/toggle-body') {
    return className;
  }

  className = Object(_global_helpers__WEBPACK_IMPORTED_MODULE_6__["classNames"])('rwp', 'rwp-toggle-body');
  return className;
});

function toggleBodyEdit(props) {
  var attributes = props.attributes,
      setAttributes = props.setAttributes,
      clientId = props.clientId,
      isSelected = props.isSelected,
      hasInnerBlocks = props.hasInnerBlocks,
      name = props.name,
      context = props.context;
  var className = attributes.className,
      toggleBodyIsOpen = attributes.toggleBodyIsOpen,
      toggleBodyId = attributes.toggleBodyId;
  var isOpen = context['rwp-toggle/isOpen'];
  var toggleId = context['rwp-toggle/toggleId'];
  var classes = Object(_global_helpers__WEBPACK_IMPORTED_MODULE_6__["classNames"])('', className);

  if (!_.isNil(toggleId)) {
    setAttributes({
      toggleBodyId: toggleId
    });
  }

  if (!_.isNil(isOpen)) {
    setAttributes({
      toggleBodyIsOpen: isOpen
    });
  }

  if (!toggleBodyIsOpen) {
    if (classes.match('show')) {
      classes = classes.replace('show', '');
    }
  } else {
    classes = Object(_global_helpers__WEBPACK_IMPORTED_MODULE_6__["classNames"])('show', classes);
  }

  var blockProps = Object(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__["useBlockProps"])({
    className: classes
  });
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", blockProps, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_4__["InnerBlocks"], {
    template: BLOCK_TEMPLATE,
    templateLock: TEMPLATE_LOCK
  }));
}

/* harmony default export */ __webpack_exports__["default"] = (toggleBodyEdit);

/***/ }),

/***/ "./blocks/toggle/toggle-body/index.js":
/*!********************************************!*\
  !*** ./blocks/toggle/toggle-body/index.js ***!
  \********************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./edit */ "./blocks/toggle/toggle-body/edit.js");
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./block.json */ "./blocks/toggle/toggle-body/block.json");
var _block_json__WEBPACK_IMPORTED_MODULE_2___namespace = /*#__PURE__*/__webpack_require__.t(/*! ./block.json */ "./blocks/toggle/toggle-body/block.json", 1);
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./save */ "./blocks/toggle/toggle-body/save.js");
/* harmony import */ var _variations__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./variations */ "./blocks/toggle/toggle-body/variations.js");
/**
 * ============================================================================
 * BLOCK: rwp/toggle-body
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */





var name = _block_json__WEBPACK_IMPORTED_MODULE_2__.name;
var settings = Object.assign(_block_json__WEBPACK_IMPORTED_MODULE_2__, {
  //icon,
  variations: _variations__WEBPACK_IMPORTED_MODULE_4__["default"],
  edit: _edit__WEBPACK_IMPORTED_MODULE_1__["default"],
  save: _save__WEBPACK_IMPORTED_MODULE_3__["default"]
});
Object(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__["registerBlockType"])(name, settings);

/***/ }),

/***/ "./blocks/toggle/toggle-body/save.js":
/*!*******************************************!*\
  !*** ./blocks/toggle/toggle-body/save.js ***!
  \*******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return Save; });
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _global_helpers__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../global/helpers */ "./blocks/global/helpers.js");


/** ============================================================================
 * save
 *
 * @file
 *
 * @package   __kebabCase_name__
 * @since     <<projectversion>>
 * @version   <<projectversion>>
 * @author    Sam Rankin <you@you.you>
 * @copyright 2020 RIESTER
 * ========================================================================== */


function Save(props) {
  var attributes = props.attributes;
  var classes = Object(_global_helpers__WEBPACK_IMPORTED_MODULE_2__["classNames"])('collapse', attributes.className);
  var toggleBodyIsOpen = attributes.toggleBodyIsOpen,
      toggleBodyId = attributes.toggleBodyId;

  if (!_.isUndefined(toggleBodyIsOpen)) {
    if (!toggleBodyIsOpen) {
      if (classes.match('show')) {
        classes = classes.replace('show', '');
      }
    } else {
      classes = Object(_global_helpers__WEBPACK_IMPORTED_MODULE_2__["classNames"])('show', classes);
    }
  }

  var blockProps = _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__["useBlockProps"].save({
    className: classes,
    id: "".concat(attributes.toggleBodyId, "-body"),
    'aria-labelledby': "".concat(attributes.toggleBodyId, "-header")
  });
  return Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])("div", blockProps, Object(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createElement"])(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_1__["InnerBlocks"].Content, null));
}

/***/ }),

/***/ "./blocks/toggle/toggle-body/variations.js":
/*!*************************************************!*\
  !*** ./blocks/toggle/toggle-body/variations.js ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/**
 * ============================================================================
 * variations
 *
 * @file
 * @package
 * @since     <<projectversion>>
 * @version   <<projectversion>>
 * @author    Sam Rankin <you@you.you>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

/**
 * WordPress dependencies
 */

/** @typedef {import('@wordpress/blocks').WPBlockVariation} WPBlockVariation */

/**
 * Template option choices for predefined columns layouts.
 *
 * @type {WPBlockVariation[]}
 */

var variations = [// {
  //     name: '',
  //     title: __('', 'rwp'),
  //     description: __('', 'rwp'),
  //     icon: '',
  //     innerBlocks: [],
  //     scope: ['block'],
  // },
];
/* harmony default export */ __webpack_exports__["default"] = (variations);

/***/ }),

/***/ "./blocks/toggle/variations.js":
/*!*************************************!*\
  !*** ./blocks/toggle/variations.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_0__);
/**
 * ============================================================================
 * variations
 *
 * @file
 * @package
 * @since     <<projectversion>>
 * @version   <<projectversion>>
 * @author    Sam Rankin <you@you.you>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

/**
 * WordPress dependencies
 */

/** @typedef {import('@wordpress/blocks').WPBlockVariation} WPBlockVariation */

/**
 * Template option choices for predefined columns layouts.
 *
 * @type {WPBlockVariation[]}
 */

var variations = [// {
  //     name: '',
  //     title: __('', 'rwp'),
  //     description: __('', 'rwp'),
  //     icon: '',
  //     innerBlocks: [],
  //     scope: ['block'],
  // },
];
/* harmony default export */ __webpack_exports__["default"] = (variations);

/***/ }),

/***/ 6:
/*!**************************************!*\
  !*** multi ./blocks/toggle/index.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./blocks/toggle/index.js */"./blocks/toggle/index.js");


/***/ }),

/***/ "@wordpress/block-editor":
/*!*************************************!*\
  !*** external ["wp","blockEditor"] ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["blockEditor"]; }());

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["blocks"]; }());

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["components"]; }());

/***/ }),

/***/ "@wordpress/compose":
/*!*********************************!*\
  !*** external ["wp","compose"] ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["compose"]; }());

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["data"]; }());

/***/ }),

/***/ "@wordpress/dom-ready":
/*!**********************************!*\
  !*** external ["wp","domReady"] ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["domReady"]; }());

/***/ }),

/***/ "@wordpress/editor":
/*!********************************!*\
  !*** external ["wp","editor"] ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["editor"]; }());

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["element"]; }());

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["i18n"]; }());

/***/ }),

/***/ "@wordpress/token-list":
/*!***********************************!*\
  !*** external ["wp","tokenList"] ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["wp"]["tokenList"]; }());

/***/ }),

/***/ "lodash":
/*!*************************!*\
  !*** external "lodash" ***!
  \*************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function() { module.exports = window["lodash"]; }());

/***/ })

/******/ });
//# sourceMappingURL=rwp-toggle-38989121.js.map