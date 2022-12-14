/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ './js/src/frontend.js':
/*!****************************!*\
  !*** ./js/src/frontend.js ***!
  \****************************/
/***/ (function() {

eval('var _this = this;\n\n/* global jQuery, gform, gforms_recaptcha_recaptcha_strings, grecaptcha */\n(function ($, gform, grecaptcha, strings) {\n  /**\n   * Make the API request to Google to get the reCAPTCHA token right before submission.\n   *\n   * @since 1.0\n   *\n   * @param {Object} e The event object.\n   * @return {void}\n   */\n  var getToken = function getToken(e) {\n    var form = $(e.data.form);\n    var recaptchaField = form.find(\'.ginput_recaptchav3\');\n    var dataInput = recaptchaField.find(\'.gfield_recaptcha_response\');\n\n    if (!dataInput.length || dataInput.val().length) {\n      return;\n    }\n\n    e.preventDefault();\n    grecaptcha.ready(function () {\n      grecaptcha.execute(strings.site_key, {\n        action: \'submit\'\n      }).then(function (token) {\n        if (token.length && typeof token === \'string\') {\n          dataInput.val(token);\n        }\n\n        form.submit();\n      });\n    });\n  };\n  /**\n   * Add event listeners to the form.\n   *\n   * @since 1.0\n   *\n   * @param {string|number} formId The numeric ID of the form.\n   * @return {void}\n   */\n\n\n  var addFormEventListeners = function addFormEventListeners(formId) {\n    var $form = $("#gform_".concat(formId, ":not(.recaptcha-v3-initialized)"));\n    var $submit = $form.find("#gform_submit_button_".concat(formId));\n    $form.on(\'submit\', {\n      form: $form\n    }, getToken);\n    $submit.on(\'click\', {\n      form: $form\n    }, getToken);\n    $form.addClass(\'recaptcha-v3-initialized\');\n  };\n  /**\n   * The reCAPTCHA handler.\n   *\n   * @since 1.0\n   *\n   * @return {void}\n   */\n\n\n  var gfRecaptcha = function gfRecaptcha() {\n    var self = _this;\n    /**\n     * Initialize the Recaptcha handler.\n     *\n     * @since 1.0\n     *\n     * @return {void}\n     */\n\n    self.init = function () {\n      self.elements = {\n        formIds: self.getFormIds()\n      };\n      self.addEventListeners();\n    };\n    /**\n     * Get an array of form IDs.\n     *\n     * @since 1.0\n     *\n     * @return {Array} Array of form IDs.\n     */\n\n\n    self.getFormIds = function () {\n      var ids = [];\n      $(\'form\').each(function (index) {\n        ids.push($(\'form\').get(index).id.split(\'gform_\')[1]);\n      });\n      return ids;\n    };\n    /**\n     * Add event listeners to the page.\n     *\n     * @since 1.0\n     *\n     * @return {void}\n     */\n\n\n    self.addEventListeners = function () {\n      self.elements.formIds.forEach(function (formId) {\n        addFormEventListeners(formId);\n      });\n      $(document).on(\'gform_post_render\', function (event, formId) {\n        addFormEventListeners(formId);\n      });\n    };\n\n    self.init();\n  }; // Initialize and run the whole shebang.\n\n\n  $(document).ready(function () {\n    gfRecaptcha();\n  });\n})(jQuery, gform, grecaptcha, gforms_recaptcha_recaptcha_strings);\n\n//# sourceURL=webpack://gravityformsrecaptcha/./js/src/frontend.js?');

/***/ }),

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__['./js/src/frontend.js']();
/******/ 	
/******/ })()
;