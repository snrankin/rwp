/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./blocks/card/card-body/edit.js":
/*!***************************************!*\
  !*** ./blocks/card/card-body/edit.js ***!
  \***************************************/
/***/ (function() {

throw new Error("Module build failed (from ../node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/card-body/edit.js: Support for the experimental syntax 'jsx' isn't currently enabled (42:12):\n\n\u001b[0m \u001b[90m 40 |\u001b[39m \t\t\u001b[36mreturn\u001b[39m (props) \u001b[33m=>\u001b[39m {\u001b[0m\n\u001b[0m \u001b[90m 41 |\u001b[39m \t\t\t\u001b[36mif\u001b[39m (\u001b[33m!\u001b[39mblockHasParent(props\u001b[33m.\u001b[39mclientId) \u001b[33m||\u001b[39m parentType(props) \u001b[33m!==\u001b[39m \u001b[32m'rwp/card-body'\u001b[39m) {\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 42 |\u001b[39m \t\t\t\t\u001b[36mreturn\u001b[39m \u001b[33m<\u001b[39m\u001b[33mBlockListBlock\u001b[39m {\u001b[33m...\u001b[39mprops} \u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m \t\t\t\t       \u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 43 |\u001b[39m \t\t\t}\u001b[0m\n\u001b[0m \u001b[90m 44 |\u001b[39m \t\t\t\u001b[36mlet\u001b[39m classes \u001b[33m=\u001b[39m props\u001b[33m.\u001b[39mattributes\u001b[33m.\u001b[39mclassName\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 45 |\u001b[39m \t\t\t\u001b[36mswitch\u001b[39m (props\u001b[33m.\u001b[39mname) {\u001b[0m\n\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\n    at instantiate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:72:32)\n    at constructor (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:358:12)\n    at Parser.raise (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3336:19)\n    at Parser.expectOnePlugin (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3393:18)\n    at Parser.parseExprAtom (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:13075:18)\n    at Parser.parseExprSubscripts (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12645:23)\n    at Parser.parseUpdate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12624:21)\n    at Parser.parseMaybeUnary (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12595:23)\n    at Parser.parseMaybeUnaryOrPrivate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12389:61)\n    at Parser.parseExprOps (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12396:23)");

/***/ }),

/***/ "./blocks/card/card-body/index.js":
/*!****************************************!*\
  !*** ./blocks/card/card-body/index.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../icons */ "./blocks/card/icons.js");
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_icons__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./blocks/card/card-body/edit.js");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_edit__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./block.json */ "./blocks/card/card-body/block.json");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./save */ "./blocks/card/card-body/save.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_save__WEBPACK_IMPORTED_MODULE_4__);
/**
 * ============================================================================
 * BLOCK: rwp/card-body
 *
 * @file
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */




 //import variations from './variations';
//import './index.scss';

var name = _block_json__WEBPACK_IMPORTED_MODULE_3__.name;
var settings = Object.assign(_block_json__WEBPACK_IMPORTED_MODULE_3__, {
  icon: _icons__WEBPACK_IMPORTED_MODULE_1__.cardBodyIcon,
  //variations,
  edit: (_edit__WEBPACK_IMPORTED_MODULE_2___default()),
  save: (_save__WEBPACK_IMPORTED_MODULE_4___default())
});
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(name, settings);

/***/ }),

/***/ "./blocks/card/card-body/save.js":
/*!***************************************!*\
  !*** ./blocks/card/card-body/save.js ***!
  \***************************************/
/***/ (function() {

throw new Error("Module build failed (from ../node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/card-body/save.js: Support for the experimental syntax 'jsx' isn't currently enabled (20:3):\n\n\u001b[0m \u001b[90m 18 |\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 19 |\u001b[39m \t\u001b[36mreturn\u001b[39m (\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 20 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33mdiv\u001b[39m {\u001b[33m...\u001b[39mblockProps}\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m \t\t\u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 21 |\u001b[39m \t\t\t\u001b[33m<\u001b[39m\u001b[33mInnerBlocks\u001b[39m\u001b[33m.\u001b[39m\u001b[33mContent\u001b[39m \u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 22 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33m/\u001b[39m\u001b[33mdiv\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 23 |\u001b[39m \t)\u001b[33m;\u001b[39m\u001b[0m\n\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\n    at instantiate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:72:32)\n    at constructor (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:358:12)\n    at Parser.raise (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3336:19)\n    at Parser.expectOnePlugin (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3393:18)\n    at Parser.parseExprAtom (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:13075:18)\n    at Parser.parseExprSubscripts (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12645:23)\n    at Parser.parseUpdate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12624:21)\n    at Parser.parseMaybeUnary (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12595:23)\n    at Parser.parseMaybeUnaryOrPrivate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12389:61)\n    at Parser.parseExprOps (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12396:23)");

/***/ }),

/***/ "./blocks/card/card-footer/edit.js":
/*!*****************************************!*\
  !*** ./blocks/card/card-footer/edit.js ***!
  \*****************************************/
/***/ (function() {

throw new Error("Module build failed (from ../node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/card-footer/edit.js: Support for the experimental syntax 'jsx' isn't currently enabled (58:3):\n\n\u001b[0m \u001b[90m 56 |\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 57 |\u001b[39m \t\u001b[36mreturn\u001b[39m (\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 58 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33mdiv\u001b[39m {\u001b[33m...\u001b[39mblockProps}\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m \t\t\u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 59 |\u001b[39m \t\t\t\u001b[33m<\u001b[39m\u001b[33mInnerBlocks\u001b[39m templateLock\u001b[33m=\u001b[39m{\u001b[33mTEMPLATE_LOCK\u001b[39m} allowedBlocks\u001b[33m=\u001b[39m{\u001b[33mALLOWED_BLOCKS\u001b[39m} template\u001b[33m=\u001b[39m{\u001b[33mBLOCK_TEMPLATE\u001b[39m} renderAppender\u001b[33m=\u001b[39m{hasInnerBlocks \u001b[33m?\u001b[39m undefined \u001b[33m:\u001b[39m \u001b[33mInnerBlocks\u001b[39m\u001b[33m.\u001b[39m\u001b[33mButtonBlockAppender\u001b[39m} \u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 60 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33m/\u001b[39m\u001b[33mdiv\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 61 |\u001b[39m \t)\u001b[33m;\u001b[39m\u001b[0m\n\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\n    at instantiate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:72:32)\n    at constructor (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:358:12)\n    at Parser.raise (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3336:19)\n    at Parser.expectOnePlugin (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3393:18)\n    at Parser.parseExprAtom (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:13075:18)\n    at Parser.parseExprSubscripts (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12645:23)\n    at Parser.parseUpdate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12624:21)\n    at Parser.parseMaybeUnary (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12595:23)\n    at Parser.parseMaybeUnaryOrPrivate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12389:61)\n    at Parser.parseExprOps (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12396:23)");

/***/ }),

/***/ "./blocks/card/card-footer/index.js":
/*!******************************************!*\
  !*** ./blocks/card/card-footer/index.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../icons */ "./blocks/card/icons.js");
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_icons__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./blocks/card/card-footer/edit.js");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_edit__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./block.json */ "./blocks/card/card-footer/block.json");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./save */ "./blocks/card/card-footer/save.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_save__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _variations__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./variations */ "./blocks/card/card-footer/variations.js");
/**
 * ============================================================================
 * BLOCK: rwp/card-footer
 *
 * @file
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */





 //import './index.scss';

var name = _block_json__WEBPACK_IMPORTED_MODULE_3__.name;
var settings = Object.assign(_block_json__WEBPACK_IMPORTED_MODULE_3__, {
  icon: _icons__WEBPACK_IMPORTED_MODULE_1__.cardFooterIcon,
  variations: _variations__WEBPACK_IMPORTED_MODULE_5__["default"],
  edit: (_edit__WEBPACK_IMPORTED_MODULE_2___default()),
  save: (_save__WEBPACK_IMPORTED_MODULE_4___default())
});
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(name, settings);

/***/ }),

/***/ "./blocks/card/card-footer/save.js":
/*!*****************************************!*\
  !*** ./blocks/card/card-footer/save.js ***!
  \*****************************************/
/***/ (function() {

throw new Error("Module build failed (from ../node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/card-footer/save.js: Support for the experimental syntax 'jsx' isn't currently enabled (20:3):\n\n\u001b[0m \u001b[90m 18 |\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 19 |\u001b[39m \t\u001b[36mreturn\u001b[39m (\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 20 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33mdiv\u001b[39m {\u001b[33m...\u001b[39mblockProps}\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m \t\t\u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 21 |\u001b[39m \t\t\t\u001b[33m<\u001b[39m\u001b[33mInnerBlocks\u001b[39m\u001b[33m.\u001b[39m\u001b[33mContent\u001b[39m \u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 22 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33m/\u001b[39m\u001b[33mdiv\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 23 |\u001b[39m \t)\u001b[33m;\u001b[39m\u001b[0m\n\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\n    at instantiate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:72:32)\n    at constructor (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:358:12)\n    at Parser.raise (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3336:19)\n    at Parser.expectOnePlugin (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3393:18)\n    at Parser.parseExprAtom (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:13075:18)\n    at Parser.parseExprSubscripts (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12645:23)\n    at Parser.parseUpdate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12624:21)\n    at Parser.parseMaybeUnary (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12595:23)\n    at Parser.parseMaybeUnaryOrPrivate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12389:61)\n    at Parser.parseExprOps (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12396:23)");

/***/ }),

/***/ "./blocks/card/card-footer/variations.js":
/*!***********************************************!*\
  !*** ./blocks/card/card-footer/variations.js ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
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
 * Template option choices for predefined columns layouts.
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

/***/ "./blocks/card/card-header/edit.js":
/*!*****************************************!*\
  !*** ./blocks/card/card-header/edit.js ***!
  \*****************************************/
/***/ (function() {

throw new Error("Module build failed (from ../node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/card-header/edit.js: Support for the experimental syntax 'jsx' isn't currently enabled (44:12):\n\n\u001b[0m \u001b[90m 42 |\u001b[39m \t\t\u001b[36mreturn\u001b[39m (props) \u001b[33m=>\u001b[39m {\u001b[0m\n\u001b[0m \u001b[90m 43 |\u001b[39m \t\t\t\u001b[36mif\u001b[39m (\u001b[33m!\u001b[39mblockHasParent(props\u001b[33m.\u001b[39mclientId) \u001b[33m||\u001b[39m parentType(props) \u001b[33m!==\u001b[39m \u001b[32m'rwp/card-body'\u001b[39m) {\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 44 |\u001b[39m \t\t\t\t\u001b[36mreturn\u001b[39m \u001b[33m<\u001b[39m\u001b[33mBlockListBlock\u001b[39m {\u001b[33m...\u001b[39mprops} \u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m \t\t\t\t       \u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 45 |\u001b[39m \t\t\t}\u001b[0m\n\u001b[0m \u001b[90m 46 |\u001b[39m \t\t\t\u001b[36mlet\u001b[39m classes \u001b[33m=\u001b[39m props\u001b[33m.\u001b[39mattributes\u001b[33m.\u001b[39mclassName\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 47 |\u001b[39m \t\t\t\u001b[36mswitch\u001b[39m (props\u001b[33m.\u001b[39mname) {\u001b[0m\n\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\n    at instantiate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:72:32)\n    at constructor (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:358:12)\n    at Parser.raise (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3336:19)\n    at Parser.expectOnePlugin (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3393:18)\n    at Parser.parseExprAtom (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:13075:18)\n    at Parser.parseExprSubscripts (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12645:23)\n    at Parser.parseUpdate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12624:21)\n    at Parser.parseMaybeUnary (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12595:23)\n    at Parser.parseMaybeUnaryOrPrivate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12389:61)\n    at Parser.parseExprOps (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12396:23)");

/***/ }),

/***/ "./blocks/card/card-header/index.js":
/*!******************************************!*\
  !*** ./blocks/card/card-header/index.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../icons */ "./blocks/card/icons.js");
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_icons__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./edit */ "./blocks/card/card-header/edit.js");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_edit__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./block.json */ "./blocks/card/card-header/block.json");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./save */ "./blocks/card/card-header/save.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_save__WEBPACK_IMPORTED_MODULE_4__);
/**
 * ============================================================================
 * BLOCK: rwp/card-header
 *
 * @file
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */




 //import variations from './variations';
//import './index.scss';

var name = _block_json__WEBPACK_IMPORTED_MODULE_3__.name;
var settings = Object.assign(_block_json__WEBPACK_IMPORTED_MODULE_3__, {
  icon: _icons__WEBPACK_IMPORTED_MODULE_1__.cardHeaderIcon,
  //variations,
  edit: (_edit__WEBPACK_IMPORTED_MODULE_2___default()),
  save: (_save__WEBPACK_IMPORTED_MODULE_4___default())
});
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(name, settings);

/***/ }),

/***/ "./blocks/card/card-header/save.js":
/*!*****************************************!*\
  !*** ./blocks/card/card-header/save.js ***!
  \*****************************************/
/***/ (function() {

throw new Error("Module build failed (from ../node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/card-header/save.js: Support for the experimental syntax 'jsx' isn't currently enabled (20:3):\n\n\u001b[0m \u001b[90m 18 |\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 19 |\u001b[39m \t\u001b[36mreturn\u001b[39m (\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 20 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33mdiv\u001b[39m {\u001b[33m...\u001b[39mblockProps}\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m \t\t\u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 21 |\u001b[39m \t\t\t\u001b[33m<\u001b[39m\u001b[33mInnerBlocks\u001b[39m\u001b[33m.\u001b[39m\u001b[33mContent\u001b[39m \u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 22 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33m/\u001b[39m\u001b[33mdiv\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 23 |\u001b[39m \t)\u001b[33m;\u001b[39m\u001b[0m\n\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\n    at instantiate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:72:32)\n    at constructor (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:358:12)\n    at Parser.raise (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3336:19)\n    at Parser.expectOnePlugin (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3393:18)\n    at Parser.parseExprAtom (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:13075:18)\n    at Parser.parseExprSubscripts (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12645:23)\n    at Parser.parseUpdate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12624:21)\n    at Parser.parseMaybeUnary (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12595:23)\n    at Parser.parseMaybeUnaryOrPrivate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12389:61)\n    at Parser.parseExprOps (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12396:23)");

/***/ }),

/***/ "./blocks/card/edit.js":
/*!*****************************!*\
  !*** ./blocks/card/edit.js ***!
  \*****************************/
/***/ (function() {

throw new Error("Module build failed (from ../node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/edit.js: Support for the experimental syntax 'jsx' isn't currently enabled (49:12):\n\n\u001b[0m \u001b[90m 47 |\u001b[39m \t\t\u001b[36mreturn\u001b[39m (props) \u001b[33m=>\u001b[39m {\u001b[0m\n\u001b[0m \u001b[90m 48 |\u001b[39m \t\t\t\u001b[36mif\u001b[39m (\u001b[33m!\u001b[39mblockHasParent(props\u001b[33m.\u001b[39mclientId) \u001b[33m||\u001b[39m parentType(props) \u001b[33m!==\u001b[39m \u001b[32m'rwp/card'\u001b[39m) {\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 49 |\u001b[39m \t\t\t\t\u001b[36mreturn\u001b[39m \u001b[33m<\u001b[39m\u001b[33mBlockListBlock\u001b[39m {\u001b[33m...\u001b[39mprops} \u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m \t\t\t\t       \u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 50 |\u001b[39m \t\t\t}\u001b[0m\n\u001b[0m \u001b[90m 51 |\u001b[39m \t\t\t\u001b[36mswitch\u001b[39m (props\u001b[33m.\u001b[39mname) {\u001b[0m\n\u001b[0m \u001b[90m 52 |\u001b[39m \t\t\t\t\u001b[36mcase\u001b[39m \u001b[32m'core/image'\u001b[39m\u001b[33m:\u001b[39m\u001b[0m\n\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\n    at instantiate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:72:32)\n    at constructor (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:358:12)\n    at Parser.raise (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3336:19)\n    at Parser.expectOnePlugin (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3393:18)\n    at Parser.parseExprAtom (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:13075:18)\n    at Parser.parseExprSubscripts (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12645:23)\n    at Parser.parseUpdate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12624:21)\n    at Parser.parseMaybeUnary (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12595:23)\n    at Parser.parseMaybeUnaryOrPrivate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12389:61)\n    at Parser.parseExprOps (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12396:23)");

/***/ }),

/***/ "./blocks/card/icons.js":
/*!******************************!*\
  !*** ./blocks/card/icons.js ***!
  \******************************/
/***/ (function() {

throw new Error("Module build failed (from ../node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/icons.js: Support for the experimental syntax 'jsx' isn't currently enabled (17:2):\n\n\u001b[0m \u001b[90m 15 |\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 16 |\u001b[39m \u001b[36mexport\u001b[39m \u001b[36mconst\u001b[39m cardIcon \u001b[33m=\u001b[39m (\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 17 |\u001b[39m \t\u001b[33m<\u001b[39m\u001b[33mSVG\u001b[39m xmlns\u001b[33m=\u001b[39m\u001b[32m\"http://www.w3.org/2000/svg\"\u001b[39m width\u001b[33m=\u001b[39m\u001b[32m\"64\"\u001b[39m height\u001b[33m=\u001b[39m\u001b[32m\"64\"\u001b[39m viewBox\u001b[33m=\u001b[39m\u001b[32m\"0 0 64 64\"\u001b[39m fill\u001b[33m=\u001b[39m\u001b[32m\"currentColor\"\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m \t\u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 18 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33mPath\u001b[39m d\u001b[33m=\u001b[39m\u001b[32m\"M19.48,41.74h25a1.39,1.39,0,0,0,0-2.78h-25a1.39,1.39,0,1,0,0,2.78Z\"\u001b[39m fillRule\u001b[33m=\u001b[39m\u001b[32m\"evenodd\"\u001b[39m \u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 19 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33mPath\u001b[39m d\u001b[33m=\u001b[39m\u001b[32m\"M19.48,55.65H36.17a1.39,1.39,0,0,0,0-2.78H19.48a1.39,1.39,0,1,0,0,2.78Z\"\u001b[39m fillRule\u001b[33m=\u001b[39m\u001b[32m\"evenodd\"\u001b[39m \u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 20 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33mPath\u001b[39m d\u001b[33m=\u001b[39m\u001b[32m\"M19.48,48.7h25a1.4,1.4,0,0,0,0-2.79h-25a1.4,1.4,0,0,0,0,2.79Z\"\u001b[39m fillRule\u001b[33m=\u001b[39m\u001b[32m\"evenodd\"\u001b[39m \u001b[33m/\u001b[39m\u001b[33m>\u001b[39m\u001b[0m\n\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\n    at instantiate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:72:32)\n    at constructor (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:358:12)\n    at Parser.raise (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3336:19)\n    at Parser.expectOnePlugin (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3393:18)\n    at Parser.parseExprAtom (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:13075:18)\n    at Parser.parseExprSubscripts (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12645:23)\n    at Parser.parseUpdate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12624:21)\n    at Parser.parseMaybeUnary (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12595:23)\n    at Parser.parseMaybeUnaryOrPrivate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12389:61)\n    at Parser.parseExprOps (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12396:23)");

/***/ }),

/***/ "./blocks/card/save.js":
/*!*****************************!*\
  !*** ./blocks/card/save.js ***!
  \*****************************/
/***/ (function() {

throw new Error("Module build failed (from ../node_modules/babel-loader/lib/index.js):\nSyntaxError: /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/save.js: Support for the experimental syntax 'jsx' isn't currently enabled (22:3):\n\n\u001b[0m \u001b[90m 20 |\u001b[39m \tcontentClasses \u001b[33m=\u001b[39m updateClassesFromAtts(\u001b[32m`text-${props.attributes.textAlignment}`\u001b[39m\u001b[33m,\u001b[39m contentClasses\u001b[33m,\u001b[39m \u001b[35m/text-[\\d|\\w]+/\u001b[39m)\u001b[33m;\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 21 |\u001b[39m \t\u001b[36mreturn\u001b[39m (\u001b[0m\n\u001b[0m\u001b[31m\u001b[1m>\u001b[22m\u001b[39m\u001b[90m 22 |\u001b[39m \t\t\u001b[33m<\u001b[39m\u001b[33mdiv\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m    |\u001b[39m \t\t\u001b[31m\u001b[1m^\u001b[22m\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 23 |\u001b[39m \t\t\t{\u001b[33m...\u001b[39museBlockProps\u001b[33m.\u001b[39msave({\u001b[0m\n\u001b[0m \u001b[90m 24 |\u001b[39m \t\t\t\tclassName\u001b[33m:\u001b[39m contentClasses\u001b[33m,\u001b[39m\u001b[0m\n\u001b[0m \u001b[90m 25 |\u001b[39m \t\t\t})}\u001b[0m\n\nAdd @babel/preset-react (https://github.com/babel/babel/tree/main/packages/babel-preset-react) to the 'presets' section of your Babel config to enable transformation.\nIf you want to leave it as-is, add @babel/plugin-syntax-jsx (https://github.com/babel/babel/tree/main/packages/babel-plugin-syntax-jsx) to the 'plugins' section to enable parsing.\n    at instantiate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:72:32)\n    at constructor (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:358:12)\n    at Parser.raise (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3336:19)\n    at Parser.expectOnePlugin (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:3393:18)\n    at Parser.parseExprAtom (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:13075:18)\n    at Parser.parseExprSubscripts (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12645:23)\n    at Parser.parseUpdate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12624:21)\n    at Parser.parseMaybeUnary (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12595:23)\n    at Parser.parseMaybeUnaryOrPrivate (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12389:61)\n    at Parser.parseExprOps (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/@babel/core/node_modules/@babel/parser/lib/index.js:12396:23)");

/***/ }),

/***/ "./blocks/card/variations.js":
/*!***********************************!*\
  !*** ./blocks/card/variations.js ***!
  \***********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./icons */ "./blocks/card/icons.js");
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_icons__WEBPACK_IMPORTED_MODULE_0__);
/**
 * ============================================================================
 * variations
 *
 * @file
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    Sam Rankin <srankin@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

/**
 * WordPress dependencies
 */

/** @typedef {import('@wordpress/blocks').WPBlockVariation} WPBlockVariation */

/**
 * Template option choices for predefined card layouts.
 *
 * @type {WPBlockVariation[]}
 */

var variations = [{
  name: 'default-card',
  isDefault: true,
  title: 'Default Card',
  icon: _icons__WEBPACK_IMPORTED_MODULE_0__.cardFull,
  scope: ['block'],
  example: {
    innerBlocks: [['core/heading', {
      content: 'Card Header',
      level: 2,
      className: 'card-header'
    }], ['core/image', {
      className: 'card-img',
      attributes: {
        url: 'https://dummyimage.com/600x16:9'
      }
    }], ['rwp/card-body', {}, [['core/heading', {
      content: 'Card Body Title',
      level: 4,
      className: 'card-title'
    }], ['core/paragraph', {
      content: 'Card Body',
      className: 'card-text'
    }]]], ['rwp/card-footer', {}, [['core/buttons', {}, [['core/button', {
      content: 'Button 1'
    }], ['core/button', {
      content: 'Button 2'
    }]]]]]]
  },
  description: 'A full vertical card with a header, image on top, body, and footer',
  attributes: {},
  innerBlocks: [['rwp/card-header', {}, [['core/heading', {
    placeholder: 'Card Heading',
    level: 2,
    className: 'card-title'
  }]]], ['core/image', {
    className: 'card-img'
  }], ['rwp/card-body', {}, [['core/heading', {
    placeholder: 'Card Body Title',
    level: 4,
    className: 'card-title'
  }], ['core/paragraph', {
    placeholder: 'Card Body',
    className: 'card-text'
  }]]], ['rwp/card-footer', {}, [['core/buttons', {}, [['core/button', {
    placeholder: 'Button 1'
  }], ['core/button', {
    placeholder: 'Button 2'
  }]]]]]]
}, {
  name: 'card-with-body',
  title: 'Card Body',
  scope: ['block'],
  icon: _icons__WEBPACK_IMPORTED_MODULE_0__.cardBody,
  description: 'A card with body only',
  attributes: {},
  innerBlocks: [['rwp/card-body', {}, [['rwp/card-header', {}, [['core/heading', {
    placeholder: 'Card Heading',
    level: 2,
    className: 'card-title'
  }]]], ['core/paragraph', {
    placeholder: 'Card Body',
    className: 'card-text'
  }]]]]
}, {
  name: 'card-with-header-body',
  title: 'Card with Header and Body',
  scope: ['block'],
  description: 'A card with header and body only',
  icon: _icons__WEBPACK_IMPORTED_MODULE_0__.cardHeaderBody,
  attributes: {},
  innerBlocks: [['rwp/card-header', {}, [['core/heading', {
    placeholder: 'Card Heading',
    level: 2,
    className: 'card-title'
  }]]], ['rwp/card-body', {}, [['core/heading', {
    placeholder: 'Card Body Title',
    level: 4,
    className: 'card-title'
  }], ['core/paragraph', {
    placeholder: 'Card Body',
    className: 'card-text'
  }]]]]
}, {
  name: 'card-with-body-footer',
  title: 'Card with Body and Footer',
  scope: ['block'],
  description: 'A card with body and footer only',
  icon: _icons__WEBPACK_IMPORTED_MODULE_0__.cardBodyFooter,
  attributes: {},
  innerBlocks: [['rwp/card-body', {}, [['core/heading', {
    placeholder: 'Card Body Title',
    level: 4,
    className: 'card-title'
  }], ['core/paragraph', {
    placeholder: 'Card Body',
    className: 'card-text'
  }]]], ['rwp/card-footer', {}, [['core/buttons', {}, [['core/button', {
    placeholder: 'Button 1'
  }], ['core/button', {
    placeholder: 'Button 2'
  }]]]]]]
}, {
  name: 'card-with-header-body-footer',
  scope: ['block'],
  title: 'Card with Header, Body and Footer',
  description: 'A card with header, body, and footer only',
  icon: _icons__WEBPACK_IMPORTED_MODULE_0__.cardHeaderBodyFooter,
  attributes: {},
  innerBlocks: [['rwp/card-header', {}, [['core/heading', {
    placeholder: 'Card Heading',
    level: 2,
    className: 'card-title'
  }]]], ['rwp/card-body', {}, [['core/heading', {
    placeholder: 'Card Body Title',
    level: 4,
    className: 'card-title'
  }], ['core/paragraph', {
    placeholder: 'Card Body',
    className: 'card-text'
  }]]], ['rwp/card-footer', {}, [['core/buttons', {}, [['core/button', {
    placeholder: 'Button 1'
  }], ['core/button', {
    placeholder: 'Button 2'
  }]]]]]]
}, {
  name: 'vertical-img-top',
  scope: ['block'],
  title: 'Vertical Card with Top Image',
  description: 'A vertical card with an image on top and body',
  icon: _icons__WEBPACK_IMPORTED_MODULE_0__.cardImgTop,
  attributes: {},
  innerBlocks: [['core/image', {
    className: 'card-img-top'
  }], ['rwp/card-body', {}, [['core/heading', {
    placeholder: 'Card Body Title',
    level: 4,
    className: 'card-title'
  }], ['core/paragraph', {
    placeholder: 'Card Body',
    className: 'card-text'
  }]]]]
}, {
  name: 'vertical-img-bottom',
  scope: ['block'],
  title: 'Vertical Card with Bottom Image',
  description: 'A vertical card with an image on bottom and body',
  icon: _icons__WEBPACK_IMPORTED_MODULE_0__.cardImgBottom,
  attributes: {},
  innerBlocks: [['rwp/card-body', {}, [['core/heading', {
    placeholder: 'Card Body Title',
    level: 4,
    className: 'card-title'
  }], ['core/paragraph', {
    placeholder: 'Card Body',
    className: 'card-text'
  }]]], ['core/image', {
    className: 'card-img-bottom'
  }]]
}, {
  name: 'horizontal-img-left',
  scope: ['block'],
  title: 'Horizontal Card with Left Image',
  description: 'A horizontal card with a image on left, body on right',
  icon: _icons__WEBPACK_IMPORTED_MODULE_0__.cardImgLeft,
  attributes: {
    className: 'card-row'
  },
  innerBlocks: [['core/image', {
    className: 'card-img-left'
  }], ['rwp/card-body', {}, [['core/heading', {
    placeholder: 'Card Body Title',
    level: 4,
    className: 'card-title'
  }], ['core/paragraph', {
    placeholder: 'Card Body',
    className: 'card-text'
  }]]]]
}, {
  name: 'horizontal-img-right',
  scope: ['block'],
  title: 'Horizontal Card with Right Image',
  description: 'A horizontal card with a image on right, body on right',
  icon: _icons__WEBPACK_IMPORTED_MODULE_0__.cardImgRight,
  attributes: {
    className: 'card-row'
  },
  innerBlocks: [['rwp/card-body', {}, [['core/heading', {
    placeholder: 'Card Body Title',
    level: 4,
    className: 'card-title'
  }], ['core/paragraph', {
    placeholder: 'Card Body',
    className: 'card-text'
  }]]], ['core/image', {
    className: 'card-img-right'
  }]]
}, {
  name: 'img-overlay',
  scope: ['block'],
  title: 'Card with Image overlay',
  description: 'A card with text overlaying an image',
  icon: _icons__WEBPACK_IMPORTED_MODULE_0__.cardImgOverlay,
  attributes: {
    className: 'card-row'
  },
  innerBlocks: [['core/image', {
    className: 'card-img'
  }], ['rwp/card-body', {}, [['core/heading', {
    placeholder: 'Card Body Title',
    level: 4,
    className: 'card-title'
  }], ['core/paragraph', {
    placeholder: 'Card Body',
    className: 'card-text'
  }]]]]
}];
/* harmony default export */ __webpack_exports__["default"] = (variations);

/***/ }),

/***/ "./blocks/card/index.scss":
/*!********************************!*\
  !*** ./blocks/card/index.scss ***!
  \********************************/
/***/ (function() {

throw new Error("Module build failed (from ../node_modules/mini-css-extract-plugin/dist/loader.js):\nHookWebpackError: Module build failed (from ../node_modules/sass-loader/dist/cjs.js):\nSassError: Undefined mixin.\n   ╷\n16 │     @include border-left-radius($card-border-radius);\n   │     ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^\n   ╵\n  src/blocks/card/index.scss 16:2  root stylesheet\n    at tryRunOrWebpackError (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/HookWebpackError.js:88:9)\n    at __webpack_require_module__ (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/Compilation.js:5051:12)\n    at __webpack_require__ (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/Compilation.js:5008:18)\n    at /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/Compilation.js:5079:20\n    at symbolIterator (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/neo-async/async.js:3485:9)\n    at done (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/neo-async/async.js:3527:9)\n    at Hook.eval [as callAsync] (eval at create (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/tapable/lib/HookCodeFactory.js:33:10), <anonymous>:15:1)\n    at Hook.CALL_ASYNC_DELEGATE [as _callAsync] (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/tapable/lib/Hook.js:18:14)\n    at /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/Compilation.js:4986:43\n    at symbolIterator (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/neo-async/async.js:3482:9)\n-- inner error --\nError: Module build failed (from ../node_modules/sass-loader/dist/cjs.js):\nSassError: Undefined mixin.\n   ╷\n16 │     @include border-left-radius($card-border-radius);\n   │     ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^\n   ╵\n  src/blocks/card/index.scss 16:2  root stylesheet\n    at Object.<anonymous> (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[10].use[1]!/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[10].use[2]!/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[10].use[3]!/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/index.scss:1:7)\n    at /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/javascript/JavascriptModulesPlugin.js:441:11\n    at Hook.eval [as call] (eval at create (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/tapable/lib/HookCodeFactory.js:19:10), <anonymous>:7:1)\n    at Hook.CALL_DELEGATE [as _call] (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/tapable/lib/Hook.js:14:14)\n    at /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/Compilation.js:5053:39\n    at tryRunOrWebpackError (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/HookWebpackError.js:83:7)\n    at __webpack_require_module__ (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/Compilation.js:5051:12)\n    at __webpack_require__ (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/Compilation.js:5008:18)\n    at /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/webpack/lib/Compilation.js:5079:20\n    at symbolIterator (/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/neo-async/async.js:3485:9)\n\nGenerated code for /Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/css-loader/dist/cjs.js??ruleSet[1].rules[10].use[1]!/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/postcss-loader/dist/cjs.js??ruleSet[1].rules[10].use[2]!/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/node_modules/sass-loader/dist/cjs.js??ruleSet[1].rules[10].use[3]!/Users/Shared/www/sites/rwp/app/public/wp-content/plugins/rwp/src/blocks/card/index.scss\n1 | throw new Error(\"Module build failed (from ../node_modules/sass-loader/dist/cjs.js):\\nSassError: Undefined mixin.\\n   ╷\\n16 │     @include border-left-radius($card-border-radius);\\n   │     ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^\\n   ╵\\n  src/blocks/card/index.scss 16:2  root stylesheet\");");

/***/ }),

/***/ "@wordpress/blocks":
/*!********************************!*\
  !*** external ["wp","blocks"] ***!
  \********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["blocks"];

/***/ }),

/***/ "./blocks/card/block.json":
/*!********************************!*\
  !*** ./blocks/card/block.json ***!
  \********************************/
/***/ (function(module) {

"use strict";
module.exports = JSON.parse('{"apiVersion":2,"attributes":{"backgroundColor":{"default":"","type":"string"},"borderColor":{"default":"","type":"string"},"layout":{"default":"vertical","type":"string"},"linkColor":{"default":"","type":"string"},"textAlignment":{"default":"","type":"string"},"textColor":{"default":"","type":"string"}},"category":"design","name":"rwp/card","supports":{"anchor":true,"color":{"background":true,"border":true,"gradient":true,"link":true,"text":true}},"title":"Card"}');

/***/ }),

/***/ "./blocks/card/card-body/block.json":
/*!******************************************!*\
  !*** ./blocks/card/card-body/block.json ***!
  \******************************************/
/***/ (function(module) {

"use strict";
module.exports = JSON.parse('{"apiVersion":2,"attributes":{},"category":"design","name":"rwp/card-body","parent":["rwp/card"],"supports":{"inserter":false,"multiple":false,"spacing":{"margin":true,"padding":true},"typography":{"fontSize":true}},"title":"Card Body"}');

/***/ }),

/***/ "./blocks/card/card-footer/block.json":
/*!********************************************!*\
  !*** ./blocks/card/card-footer/block.json ***!
  \********************************************/
/***/ (function(module) {

"use strict";
module.exports = JSON.parse('{"apiVersion":2,"attributes":{},"category":"design","name":"rwp/card-footer","parent":["rwp/card"],"supports":{"inserter":false,"multiple":false,"spacing":{"margin":true,"padding":true},"typography":{"fontSize":true}},"title":"Card Footer"}');

/***/ }),

/***/ "./blocks/card/card-header/block.json":
/*!********************************************!*\
  !*** ./blocks/card/card-header/block.json ***!
  \********************************************/
/***/ (function(module) {

"use strict";
module.exports = JSON.parse('{"apiVersion":2,"attributes":{},"category":"design","name":"rwp/card-header","parent":["rwp/card"],"supports":{"inserter":false,"multiple":false,"spacing":{"margin":true,"padding":true},"typography":{"fontSize":true}},"title":"Card Header"}');

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
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
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
/*!******************************!*\
  !*** ./blocks/card/index.js ***!
  \******************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/blocks */ "@wordpress/blocks");
/* harmony import */ var _wordpress_blocks__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _card_header__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./card-header */ "./blocks/card/card-header/index.js");
/* harmony import */ var _card_body__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./card-body */ "./blocks/card/card-body/index.js");
/* harmony import */ var _card_footer__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./card-footer */ "./blocks/card/card-footer/index.js");
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./icons */ "./blocks/card/icons.js");
/* harmony import */ var _icons__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_icons__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./edit */ "./blocks/card/edit.js");
/* harmony import */ var _edit__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_edit__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _block_json__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./block.json */ "./blocks/card/block.json");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./save */ "./blocks/card/save.js");
/* harmony import */ var _save__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_save__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _variations__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./variations */ "./blocks/card/variations.js");
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./index.scss */ "./blocks/card/index.scss");
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_index_scss__WEBPACK_IMPORTED_MODULE_9__);
/**
 * ============================================================================
 * BLOCK: rwp/card
 *
 * @file
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */










var name = _block_json__WEBPACK_IMPORTED_MODULE_6__.name;
var settings = Object.assign(_block_json__WEBPACK_IMPORTED_MODULE_6__, {
  icon: _icons__WEBPACK_IMPORTED_MODULE_4__.cardIcon,
  variations: _variations__WEBPACK_IMPORTED_MODULE_8__["default"],
  edit: (_edit__WEBPACK_IMPORTED_MODULE_5___default()),
  save: (_save__WEBPACK_IMPORTED_MODULE_7___default())
});
(0,_wordpress_blocks__WEBPACK_IMPORTED_MODULE_0__.registerBlockType)(name, settings);
}();
/******/ })()
;
//# sourceMappingURL=rwp-card.js.map