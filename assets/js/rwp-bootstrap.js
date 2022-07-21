(function() {
    var __webpack_modules__ = {
        "../node_modules/@popperjs/core/lib/createPopper.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                createPopper: function() {
                    return createPopper;
                },
                detectOverflow: function() {
                    return _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_13__["default"];
                },
                popperGenerator: function() {
                    return popperGenerator;
                }
            });
            var _dom_utils_getCompositeRect_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getCompositeRect.js");
            var _dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js");
            var _dom_utils_listScrollParents_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/listScrollParents.js");
            var _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js");
            var _dom_utils_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");
            var _utils_orderModifiers_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/orderModifiers.js");
            var _utils_debounce_js__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/debounce.js");
            var _utils_validateModifiers_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/validateModifiers.js");
            var _utils_uniqueBy_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/uniqueBy.js");
            var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
            var _utils_mergeByName_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/mergeByName.js");
            var _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/detectOverflow.js");
            var _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            var _enums_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var INVALID_ELEMENT_ERROR = "Popper: Invalid reference or popper argument provided. They must be either a DOM element or virtual element.";
            var INFINITE_LOOP_ERROR = "Popper: An infinite loop in the modifiers cycle has been detected! The cycle has been interrupted to prevent a browser crash.";
            var DEFAULT_OPTIONS = {
                placement: "bottom",
                modifiers: [],
                strategy: "absolute"
            };
            function areValidElements() {
                for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
                    args[_key] = arguments[_key];
                }
                return !args.some((function(element) {
                    return !(element && typeof element.getBoundingClientRect === "function");
                }));
            }
            function popperGenerator(generatorOptions) {
                if (generatorOptions === void 0) {
                    generatorOptions = {};
                }
                var _generatorOptions = generatorOptions, _generatorOptions$def = _generatorOptions.defaultModifiers, defaultModifiers = _generatorOptions$def === void 0 ? [] : _generatorOptions$def, _generatorOptions$def2 = _generatorOptions.defaultOptions, defaultOptions = _generatorOptions$def2 === void 0 ? DEFAULT_OPTIONS : _generatorOptions$def2;
                return function createPopper(reference, popper, options) {
                    if (options === void 0) {
                        options = defaultOptions;
                    }
                    var state = {
                        placement: "bottom",
                        orderedModifiers: [],
                        options: Object.assign({}, DEFAULT_OPTIONS, defaultOptions),
                        modifiersData: {},
                        elements: {
                            reference,
                            popper
                        },
                        attributes: {},
                        styles: {}
                    };
                    var effectCleanupFns = [];
                    var isDestroyed = false;
                    var instance = {
                        state,
                        setOptions: function setOptions(setOptionsAction) {
                            var options = typeof setOptionsAction === "function" ? setOptionsAction(state.options) : setOptionsAction;
                            cleanupModifierEffects();
                            state.options = Object.assign({}, defaultOptions, state.options, options);
                            state.scrollParents = {
                                reference: (0, _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isElement)(reference) ? (0, 
                                _dom_utils_listScrollParents_js__WEBPACK_IMPORTED_MODULE_1__["default"])(reference) : reference.contextElement ? (0, 
                                _dom_utils_listScrollParents_js__WEBPACK_IMPORTED_MODULE_1__["default"])(reference.contextElement) : [],
                                popper: (0, _dom_utils_listScrollParents_js__WEBPACK_IMPORTED_MODULE_1__["default"])(popper)
                            };
                            var orderedModifiers = (0, _utils_orderModifiers_js__WEBPACK_IMPORTED_MODULE_2__["default"])((0, 
                            _utils_mergeByName_js__WEBPACK_IMPORTED_MODULE_3__["default"])([].concat(defaultModifiers, state.options.modifiers)));
                            state.orderedModifiers = orderedModifiers.filter((function(m) {
                                return m.enabled;
                            }));
                            if (true) {
                                var modifiers = (0, _utils_uniqueBy_js__WEBPACK_IMPORTED_MODULE_4__["default"])([].concat(orderedModifiers, state.options.modifiers), (function(_ref) {
                                    var name = _ref.name;
                                    return name;
                                }));
                                (0, _utils_validateModifiers_js__WEBPACK_IMPORTED_MODULE_5__["default"])(modifiers);
                                if ((0, _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_6__["default"])(state.options.placement) === _enums_js__WEBPACK_IMPORTED_MODULE_7__.auto) {
                                    var flipModifier = state.orderedModifiers.find((function(_ref2) {
                                        var name = _ref2.name;
                                        return name === "flip";
                                    }));
                                    if (!flipModifier) {
                                        console.error([ 'Popper: "auto" placements require the "flip" modifier be', "present and enabled to work." ].join(" "));
                                    }
                                }
                                var _getComputedStyle = (0, _dom_utils_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_8__["default"])(popper), marginTop = _getComputedStyle.marginTop, marginRight = _getComputedStyle.marginRight, marginBottom = _getComputedStyle.marginBottom, marginLeft = _getComputedStyle.marginLeft;
                                if ([ marginTop, marginRight, marginBottom, marginLeft ].some((function(margin) {
                                    return parseFloat(margin);
                                }))) {
                                    console.warn([ 'Popper: CSS "margin" styles cannot be used to apply padding', "between the popper and its reference element or boundary.", "To replicate margin, use the `offset` modifier, as well as", "the `padding` option in the `preventOverflow` and `flip`", "modifiers." ].join(" "));
                                }
                            }
                            runModifierEffects();
                            return instance.update();
                        },
                        forceUpdate: function forceUpdate() {
                            if (isDestroyed) {
                                return;
                            }
                            var _state$elements = state.elements, reference = _state$elements.reference, popper = _state$elements.popper;
                            if (!areValidElements(reference, popper)) {
                                if (true) {
                                    console.error(INVALID_ELEMENT_ERROR);
                                }
                                return;
                            }
                            state.rects = {
                                reference: (0, _dom_utils_getCompositeRect_js__WEBPACK_IMPORTED_MODULE_9__["default"])(reference, (0, 
                                _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_10__["default"])(popper), state.options.strategy === "fixed"),
                                popper: (0, _dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_11__["default"])(popper)
                            };
                            state.reset = false;
                            state.placement = state.options.placement;
                            state.orderedModifiers.forEach((function(modifier) {
                                return state.modifiersData[modifier.name] = Object.assign({}, modifier.data);
                            }));
                            var __debug_loops__ = 0;
                            for (var index = 0; index < state.orderedModifiers.length; index++) {
                                if (true) {
                                    __debug_loops__ += 1;
                                    if (__debug_loops__ > 100) {
                                        console.error(INFINITE_LOOP_ERROR);
                                        break;
                                    }
                                }
                                if (state.reset === true) {
                                    state.reset = false;
                                    index = -1;
                                    continue;
                                }
                                var _state$orderedModifie = state.orderedModifiers[index], fn = _state$orderedModifie.fn, _state$orderedModifie2 = _state$orderedModifie.options, _options = _state$orderedModifie2 === void 0 ? {} : _state$orderedModifie2, name = _state$orderedModifie.name;
                                if (typeof fn === "function") {
                                    state = fn({
                                        state,
                                        options: _options,
                                        name,
                                        instance
                                    }) || state;
                                }
                            }
                        },
                        update: (0, _utils_debounce_js__WEBPACK_IMPORTED_MODULE_12__["default"])((function() {
                            return new Promise((function(resolve) {
                                instance.forceUpdate();
                                resolve(state);
                            }));
                        })),
                        destroy: function destroy() {
                            cleanupModifierEffects();
                            isDestroyed = true;
                        }
                    };
                    if (!areValidElements(reference, popper)) {
                        if (true) {
                            console.error(INVALID_ELEMENT_ERROR);
                        }
                        return instance;
                    }
                    instance.setOptions(options).then((function(state) {
                        if (!isDestroyed && options.onFirstUpdate) {
                            options.onFirstUpdate(state);
                        }
                    }));
                    function runModifierEffects() {
                        state.orderedModifiers.forEach((function(_ref3) {
                            var name = _ref3.name, _ref3$options = _ref3.options, options = _ref3$options === void 0 ? {} : _ref3$options, effect = _ref3.effect;
                            if (typeof effect === "function") {
                                var cleanupFn = effect({
                                    state,
                                    name,
                                    instance,
                                    options
                                });
                                var noopFn = function noopFn() {};
                                effectCleanupFns.push(cleanupFn || noopFn);
                            }
                        }));
                    }
                    function cleanupModifierEffects() {
                        effectCleanupFns.forEach((function(fn) {
                            return fn();
                        }));
                        effectCleanupFns = [];
                    }
                    return instance;
                };
            }
            var createPopper = popperGenerator();
        },
        "../node_modules/@popperjs/core/lib/dom-utils/contains.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return contains;
                }
            });
            var _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            function contains(parent, child) {
                var rootNode = child.getRootNode && child.getRootNode();
                if (parent.contains(child)) {
                    return true;
                } else if (rootNode && (0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isShadowRoot)(rootNode)) {
                    var next = child;
                    do {
                        if (next && parent.isSameNode(next)) {
                            return true;
                        }
                        next = next.parentNode || next.host;
                    } while (next);
                }
                return false;
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getBoundingClientRect;
                }
            });
            var _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            var _utils_math_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/math.js");
            function getBoundingClientRect(element, includeScale) {
                if (includeScale === void 0) {
                    includeScale = false;
                }
                var rect = element.getBoundingClientRect();
                var scaleX = 1;
                var scaleY = 1;
                if ((0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(element) && includeScale) {
                    var offsetHeight = element.offsetHeight;
                    var offsetWidth = element.offsetWidth;
                    if (offsetWidth > 0) {
                        scaleX = (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_1__.round)(rect.width) / offsetWidth || 1;
                    }
                    if (offsetHeight > 0) {
                        scaleY = (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_1__.round)(rect.height) / offsetHeight || 1;
                    }
                }
                return {
                    width: rect.width / scaleX,
                    height: rect.height / scaleY,
                    top: rect.top / scaleY,
                    right: rect.right / scaleX,
                    bottom: rect.bottom / scaleY,
                    left: rect.left / scaleX,
                    x: rect.left / scaleX,
                    y: rect.top / scaleY
                };
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getClippingRect.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getClippingRect;
                }
            });
            var _enums_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var _getViewportRect_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getViewportRect.js");
            var _getDocumentRect_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getDocumentRect.js");
            var _listScrollParents_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/listScrollParents.js");
            var _getOffsetParent_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js");
            var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
            var _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");
            var _instanceOf_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            var _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js");
            var _getParentNode_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getParentNode.js");
            var _contains_js__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/contains.js");
            var _getNodeName_js__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
            var _utils_rectToClientRect_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/rectToClientRect.js");
            var _utils_math_js__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/math.js");
            function getInnerBoundingClientRect(element) {
                var rect = (0, _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element);
                rect.top = rect.top + element.clientTop;
                rect.left = rect.left + element.clientLeft;
                rect.bottom = rect.top + element.clientHeight;
                rect.right = rect.left + element.clientWidth;
                rect.width = element.clientWidth;
                rect.height = element.clientHeight;
                rect.x = rect.left;
                rect.y = rect.top;
                return rect;
            }
            function getClientRectFromMixedType(element, clippingParent) {
                return clippingParent === _enums_js__WEBPACK_IMPORTED_MODULE_1__.viewport ? (0, 
                _utils_rectToClientRect_js__WEBPACK_IMPORTED_MODULE_2__["default"])((0, _getViewportRect_js__WEBPACK_IMPORTED_MODULE_3__["default"])(element)) : (0, 
                _instanceOf_js__WEBPACK_IMPORTED_MODULE_4__.isElement)(clippingParent) ? getInnerBoundingClientRect(clippingParent) : (0, 
                _utils_rectToClientRect_js__WEBPACK_IMPORTED_MODULE_2__["default"])((0, _getDocumentRect_js__WEBPACK_IMPORTED_MODULE_5__["default"])((0, 
                _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_6__["default"])(element)));
            }
            function getClippingParents(element) {
                var clippingParents = (0, _listScrollParents_js__WEBPACK_IMPORTED_MODULE_7__["default"])((0, 
                _getParentNode_js__WEBPACK_IMPORTED_MODULE_8__["default"])(element));
                var canEscapeClipping = [ "absolute", "fixed" ].indexOf((0, _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_9__["default"])(element).position) >= 0;
                var clipperElement = canEscapeClipping && (0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_4__.isHTMLElement)(element) ? (0, 
                _getOffsetParent_js__WEBPACK_IMPORTED_MODULE_10__["default"])(element) : element;
                if (!(0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_4__.isElement)(clipperElement)) {
                    return [];
                }
                return clippingParents.filter((function(clippingParent) {
                    return (0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_4__.isElement)(clippingParent) && (0, 
                    _contains_js__WEBPACK_IMPORTED_MODULE_11__["default"])(clippingParent, clipperElement) && (0, 
                    _getNodeName_js__WEBPACK_IMPORTED_MODULE_12__["default"])(clippingParent) !== "body";
                }));
            }
            function getClippingRect(element, boundary, rootBoundary) {
                var mainClippingParents = boundary === "clippingParents" ? getClippingParents(element) : [].concat(boundary);
                var clippingParents = [].concat(mainClippingParents, [ rootBoundary ]);
                var firstClippingParent = clippingParents[0];
                var clippingRect = clippingParents.reduce((function(accRect, clippingParent) {
                    var rect = getClientRectFromMixedType(element, clippingParent);
                    accRect.top = (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_13__.max)(rect.top, accRect.top);
                    accRect.right = (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_13__.min)(rect.right, accRect.right);
                    accRect.bottom = (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_13__.min)(rect.bottom, accRect.bottom);
                    accRect.left = (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_13__.max)(rect.left, accRect.left);
                    return accRect;
                }), getClientRectFromMixedType(element, firstClippingParent));
                clippingRect.width = clippingRect.right - clippingRect.left;
                clippingRect.height = clippingRect.bottom - clippingRect.top;
                clippingRect.x = clippingRect.left;
                clippingRect.y = clippingRect.top;
                return clippingRect;
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getCompositeRect.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getCompositeRect;
                }
            });
            var _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js");
            var _getNodeScroll_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getNodeScroll.js");
            var _getNodeName_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
            var _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            var _getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js");
            var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
            var _isScrollParent_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js");
            var _utils_math_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/math.js");
            function isElementScaled(element) {
                var rect = element.getBoundingClientRect();
                var scaleX = (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_0__.round)(rect.width) / element.offsetWidth || 1;
                var scaleY = (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_0__.round)(rect.height) / element.offsetHeight || 1;
                return scaleX !== 1 || scaleY !== 1;
            }
            function getCompositeRect(elementOrVirtualElement, offsetParent, isFixed) {
                if (isFixed === void 0) {
                    isFixed = false;
                }
                var isOffsetParentAnElement = (0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isHTMLElement)(offsetParent);
                var offsetParentIsScaled = (0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isHTMLElement)(offsetParent) && isElementScaled(offsetParent);
                var documentElement = (0, _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(offsetParent);
                var rect = (0, _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_3__["default"])(elementOrVirtualElement, offsetParentIsScaled);
                var scroll = {
                    scrollLeft: 0,
                    scrollTop: 0
                };
                var offsets = {
                    x: 0,
                    y: 0
                };
                if (isOffsetParentAnElement || !isOffsetParentAnElement && !isFixed) {
                    if ((0, _getNodeName_js__WEBPACK_IMPORTED_MODULE_4__["default"])(offsetParent) !== "body" || (0, 
                    _isScrollParent_js__WEBPACK_IMPORTED_MODULE_5__["default"])(documentElement)) {
                        scroll = (0, _getNodeScroll_js__WEBPACK_IMPORTED_MODULE_6__["default"])(offsetParent);
                    }
                    if ((0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isHTMLElement)(offsetParent)) {
                        offsets = (0, _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_3__["default"])(offsetParent, true);
                        offsets.x += offsetParent.clientLeft;
                        offsets.y += offsetParent.clientTop;
                    } else if (documentElement) {
                        offsets.x = (0, _getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_7__["default"])(documentElement);
                    }
                }
                return {
                    x: rect.left + scroll.scrollLeft - offsets.x,
                    y: rect.top + scroll.scrollTop - offsets.y,
                    width: rect.width,
                    height: rect.height
                };
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getComputedStyle;
                }
            });
            var _getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
            function getComputedStyle(element) {
                return (0, _getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element).getComputedStyle(element);
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getDocumentElement;
                }
            });
            var _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            function getDocumentElement(element) {
                return (((0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isElement)(element) ? element.ownerDocument : element.document) || window.document).documentElement;
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getDocumentRect.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getDocumentRect;
                }
            });
            var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
            var _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");
            var _getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js");
            var _getWindowScroll_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js");
            var _utils_math_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/math.js");
            function getDocumentRect(element) {
                var _element$ownerDocumen;
                var html = (0, _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element);
                var winScroll = (0, _getWindowScroll_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element);
                var body = (_element$ownerDocumen = element.ownerDocument) == null ? void 0 : _element$ownerDocumen.body;
                var width = (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_2__.max)(html.scrollWidth, html.clientWidth, body ? body.scrollWidth : 0, body ? body.clientWidth : 0);
                var height = (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_2__.max)(html.scrollHeight, html.clientHeight, body ? body.scrollHeight : 0, body ? body.clientHeight : 0);
                var x = -winScroll.scrollLeft + (0, _getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_3__["default"])(element);
                var y = -winScroll.scrollTop;
                if ((0, _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_4__["default"])(body || html).direction === "rtl") {
                    x += (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_2__.max)(html.clientWidth, body ? body.clientWidth : 0) - width;
                }
                return {
                    width,
                    height,
                    x,
                    y
                };
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getHTMLElementScroll.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getHTMLElementScroll;
                }
            });
            function getHTMLElementScroll(element) {
                return {
                    scrollLeft: element.scrollLeft,
                    scrollTop: element.scrollTop
                };
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getLayoutRect;
                }
            });
            var _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js");
            function getLayoutRect(element) {
                var clientRect = (0, _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element);
                var width = element.offsetWidth;
                var height = element.offsetHeight;
                if (Math.abs(clientRect.width - width) <= 1) {
                    width = clientRect.width;
                }
                if (Math.abs(clientRect.height - height) <= 1) {
                    height = clientRect.height;
                }
                return {
                    x: element.offsetLeft,
                    y: element.offsetTop,
                    width,
                    height
                };
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getNodeName.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getNodeName;
                }
            });
            function getNodeName(element) {
                return element ? (element.nodeName || "").toLowerCase() : null;
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getNodeScroll.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getNodeScroll;
                }
            });
            var _getWindowScroll_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js");
            var _getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
            var _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            var _getHTMLElementScroll_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getHTMLElementScroll.js");
            function getNodeScroll(node) {
                if (node === (0, _getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node) || !(0, 
                _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isHTMLElement)(node)) {
                    return (0, _getWindowScroll_js__WEBPACK_IMPORTED_MODULE_2__["default"])(node);
                } else {
                    return (0, _getHTMLElementScroll_js__WEBPACK_IMPORTED_MODULE_3__["default"])(node);
                }
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getOffsetParent;
                }
            });
            var _getWindow_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
            var _getNodeName_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
            var _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");
            var _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            var _isTableElement_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/isTableElement.js");
            var _getParentNode_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getParentNode.js");
            function getTrueOffsetParent(element) {
                if (!(0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(element) || (0, 
                _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element).position === "fixed") {
                    return null;
                }
                return element.offsetParent;
            }
            function getContainingBlock(element) {
                var isFirefox = navigator.userAgent.toLowerCase().indexOf("firefox") !== -1;
                var isIE = navigator.userAgent.indexOf("Trident") !== -1;
                if (isIE && (0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(element)) {
                    var elementCss = (0, _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element);
                    if (elementCss.position === "fixed") {
                        return null;
                    }
                }
                var currentNode = (0, _getParentNode_js__WEBPACK_IMPORTED_MODULE_2__["default"])(element);
                if ((0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isShadowRoot)(currentNode)) {
                    currentNode = currentNode.host;
                }
                while ((0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(currentNode) && [ "html", "body" ].indexOf((0, 
                _getNodeName_js__WEBPACK_IMPORTED_MODULE_3__["default"])(currentNode)) < 0) {
                    var css = (0, _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__["default"])(currentNode);
                    if (css.transform !== "none" || css.perspective !== "none" || css.contain === "paint" || [ "transform", "perspective" ].indexOf(css.willChange) !== -1 || isFirefox && css.willChange === "filter" || isFirefox && css.filter && css.filter !== "none") {
                        return currentNode;
                    } else {
                        currentNode = currentNode.parentNode;
                    }
                }
                return null;
            }
            function getOffsetParent(element) {
                var window = (0, _getWindow_js__WEBPACK_IMPORTED_MODULE_4__["default"])(element);
                var offsetParent = getTrueOffsetParent(element);
                while (offsetParent && (0, _isTableElement_js__WEBPACK_IMPORTED_MODULE_5__["default"])(offsetParent) && (0, 
                _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__["default"])(offsetParent).position === "static") {
                    offsetParent = getTrueOffsetParent(offsetParent);
                }
                if (offsetParent && ((0, _getNodeName_js__WEBPACK_IMPORTED_MODULE_3__["default"])(offsetParent) === "html" || (0, 
                _getNodeName_js__WEBPACK_IMPORTED_MODULE_3__["default"])(offsetParent) === "body" && (0, 
                _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_1__["default"])(offsetParent).position === "static")) {
                    return window;
                }
                return offsetParent || getContainingBlock(element) || window;
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getParentNode.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getParentNode;
                }
            });
            var _getNodeName_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
            var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
            var _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            function getParentNode(element) {
                if ((0, _getNodeName_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element) === "html") {
                    return element;
                }
                return element.assignedSlot || element.parentNode || ((0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isShadowRoot)(element) ? element.host : null) || (0, 
                _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(element);
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getScrollParent.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getScrollParent;
                }
            });
            var _getParentNode_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getParentNode.js");
            var _isScrollParent_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js");
            var _getNodeName_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
            var _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            function getScrollParent(node) {
                if ([ "html", "body", "#document" ].indexOf((0, _getNodeName_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node)) >= 0) {
                    return node.ownerDocument.body;
                }
                if ((0, _instanceOf_js__WEBPACK_IMPORTED_MODULE_1__.isHTMLElement)(node) && (0, 
                _isScrollParent_js__WEBPACK_IMPORTED_MODULE_2__["default"])(node)) {
                    return node;
                }
                return getScrollParent((0, _getParentNode_js__WEBPACK_IMPORTED_MODULE_3__["default"])(node));
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getViewportRect.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getViewportRect;
                }
            });
            var _getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
            var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
            var _getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js");
            function getViewportRect(element) {
                var win = (0, _getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element);
                var html = (0, _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element);
                var visualViewport = win.visualViewport;
                var width = html.clientWidth;
                var height = html.clientHeight;
                var x = 0;
                var y = 0;
                if (visualViewport) {
                    width = visualViewport.width;
                    height = visualViewport.height;
                    if (!/^((?!chrome|android).)*safari/i.test(navigator.userAgent)) {
                        x = visualViewport.offsetLeft;
                        y = visualViewport.offsetTop;
                    }
                }
                return {
                    width,
                    height,
                    x: x + (0, _getWindowScrollBarX_js__WEBPACK_IMPORTED_MODULE_2__["default"])(element),
                    y
                };
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getWindow.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getWindow;
                }
            });
            function getWindow(node) {
                if (node == null) {
                    return window;
                }
                if (node.toString() !== "[object Window]") {
                    var ownerDocument = node.ownerDocument;
                    return ownerDocument ? ownerDocument.defaultView || window : window;
                }
                return node;
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getWindowScroll;
                }
            });
            var _getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
            function getWindowScroll(node) {
                var win = (0, _getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node);
                var scrollLeft = win.pageXOffset;
                var scrollTop = win.pageYOffset;
                return {
                    scrollLeft,
                    scrollTop
                };
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/getWindowScrollBarX.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getWindowScrollBarX;
                }
            });
            var _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js");
            var _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
            var _getWindowScroll_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindowScroll.js");
            function getWindowScrollBarX(element) {
                return (0, _getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_0__["default"])((0, 
                _getDocumentElement_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element)).left + (0, 
                _getWindowScroll_js__WEBPACK_IMPORTED_MODULE_2__["default"])(element).scrollLeft;
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                isElement: function() {
                    return isElement;
                },
                isHTMLElement: function() {
                    return isHTMLElement;
                },
                isShadowRoot: function() {
                    return isShadowRoot;
                }
            });
            var _getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
            function isElement(node) {
                var OwnElement = (0, _getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node).Element;
                return node instanceof OwnElement || node instanceof Element;
            }
            function isHTMLElement(node) {
                var OwnElement = (0, _getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node).HTMLElement;
                return node instanceof OwnElement || node instanceof HTMLElement;
            }
            function isShadowRoot(node) {
                if (typeof ShadowRoot === "undefined") {
                    return false;
                }
                var OwnElement = (0, _getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(node).ShadowRoot;
                return node instanceof OwnElement || node instanceof ShadowRoot;
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return isScrollParent;
                }
            });
            var _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");
            function isScrollParent(element) {
                var _getComputedStyle = (0, _getComputedStyle_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element), overflow = _getComputedStyle.overflow, overflowX = _getComputedStyle.overflowX, overflowY = _getComputedStyle.overflowY;
                return /auto|scroll|overlay|hidden/.test(overflow + overflowY + overflowX);
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/isTableElement.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return isTableElement;
                }
            });
            var _getNodeName_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
            function isTableElement(element) {
                return [ "table", "td", "th" ].indexOf((0, _getNodeName_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element)) >= 0;
            }
        },
        "../node_modules/@popperjs/core/lib/dom-utils/listScrollParents.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return listScrollParents;
                }
            });
            var _getScrollParent_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getScrollParent.js");
            var _getParentNode_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getParentNode.js");
            var _getWindow_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
            var _isScrollParent_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/isScrollParent.js");
            function listScrollParents(element, list) {
                var _element$ownerDocumen;
                if (list === void 0) {
                    list = [];
                }
                var scrollParent = (0, _getScrollParent_js__WEBPACK_IMPORTED_MODULE_0__["default"])(element);
                var isBody = scrollParent === ((_element$ownerDocumen = element.ownerDocument) == null ? void 0 : _element$ownerDocumen.body);
                var win = (0, _getWindow_js__WEBPACK_IMPORTED_MODULE_1__["default"])(scrollParent);
                var target = isBody ? [ win ].concat(win.visualViewport || [], (0, _isScrollParent_js__WEBPACK_IMPORTED_MODULE_2__["default"])(scrollParent) ? scrollParent : []) : scrollParent;
                var updatedList = list.concat(target);
                return isBody ? updatedList : updatedList.concat(listScrollParents((0, _getParentNode_js__WEBPACK_IMPORTED_MODULE_3__["default"])(target)));
            }
        },
        "../node_modules/@popperjs/core/lib/enums.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                afterMain: function() {
                    return afterMain;
                },
                afterRead: function() {
                    return afterRead;
                },
                afterWrite: function() {
                    return afterWrite;
                },
                auto: function() {
                    return auto;
                },
                basePlacements: function() {
                    return basePlacements;
                },
                beforeMain: function() {
                    return beforeMain;
                },
                beforeRead: function() {
                    return beforeRead;
                },
                beforeWrite: function() {
                    return beforeWrite;
                },
                bottom: function() {
                    return bottom;
                },
                clippingParents: function() {
                    return clippingParents;
                },
                end: function() {
                    return end;
                },
                left: function() {
                    return left;
                },
                main: function() {
                    return main;
                },
                modifierPhases: function() {
                    return modifierPhases;
                },
                placements: function() {
                    return placements;
                },
                popper: function() {
                    return popper;
                },
                read: function() {
                    return read;
                },
                reference: function() {
                    return reference;
                },
                right: function() {
                    return right;
                },
                start: function() {
                    return start;
                },
                top: function() {
                    return top;
                },
                variationPlacements: function() {
                    return variationPlacements;
                },
                viewport: function() {
                    return viewport;
                },
                write: function() {
                    return write;
                }
            });
            var top = "top";
            var bottom = "bottom";
            var right = "right";
            var left = "left";
            var auto = "auto";
            var basePlacements = [ top, bottom, right, left ];
            var start = "start";
            var end = "end";
            var clippingParents = "clippingParents";
            var viewport = "viewport";
            var popper = "popper";
            var reference = "reference";
            var variationPlacements = basePlacements.reduce((function(acc, placement) {
                return acc.concat([ placement + "-" + start, placement + "-" + end ]);
            }), []);
            var placements = [].concat(basePlacements, [ auto ]).reduce((function(acc, placement) {
                return acc.concat([ placement, placement + "-" + start, placement + "-" + end ]);
            }), []);
            var beforeRead = "beforeRead";
            var read = "read";
            var afterRead = "afterRead";
            var beforeMain = "beforeMain";
            var main = "main";
            var afterMain = "afterMain";
            var beforeWrite = "beforeWrite";
            var write = "write";
            var afterWrite = "afterWrite";
            var modifierPhases = [ beforeRead, read, afterRead, beforeMain, main, afterMain, beforeWrite, write, afterWrite ];
        },
        "../node_modules/@popperjs/core/lib/index.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                afterMain: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.afterMain;
                },
                afterRead: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.afterRead;
                },
                afterWrite: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.afterWrite;
                },
                applyStyles: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.applyStyles;
                },
                arrow: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.arrow;
                },
                auto: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.auto;
                },
                basePlacements: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.basePlacements;
                },
                beforeMain: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.beforeMain;
                },
                beforeRead: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.beforeRead;
                },
                beforeWrite: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.beforeWrite;
                },
                bottom: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.bottom;
                },
                clippingParents: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.clippingParents;
                },
                computeStyles: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.computeStyles;
                },
                createPopper: function() {
                    return _popper_js__WEBPACK_IMPORTED_MODULE_4__.createPopper;
                },
                createPopperBase: function() {
                    return _createPopper_js__WEBPACK_IMPORTED_MODULE_2__.createPopper;
                },
                createPopperLite: function() {
                    return _popper_lite_js__WEBPACK_IMPORTED_MODULE_5__.createPopper;
                },
                detectOverflow: function() {
                    return _createPopper_js__WEBPACK_IMPORTED_MODULE_3__["default"];
                },
                end: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.end;
                },
                eventListeners: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.eventListeners;
                },
                flip: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.flip;
                },
                hide: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.hide;
                },
                left: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.left;
                },
                main: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.main;
                },
                modifierPhases: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.modifierPhases;
                },
                offset: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.offset;
                },
                placements: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.placements;
                },
                popper: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper;
                },
                popperGenerator: function() {
                    return _createPopper_js__WEBPACK_IMPORTED_MODULE_2__.popperGenerator;
                },
                popperOffsets: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.popperOffsets;
                },
                preventOverflow: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__.preventOverflow;
                },
                read: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.read;
                },
                reference: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.reference;
                },
                right: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.right;
                },
                start: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.start;
                },
                top: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.top;
                },
                variationPlacements: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.variationPlacements;
                },
                viewport: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.viewport;
                },
                write: function() {
                    return _enums_js__WEBPACK_IMPORTED_MODULE_0__.write;
                }
            });
            var _enums_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var _modifiers_index_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/index.js");
            var _createPopper_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/createPopper.js");
            var _createPopper_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/detectOverflow.js");
            var _popper_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/popper.js");
            var _popper_lite_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/popper-lite.js");
        },
        "../node_modules/@popperjs/core/lib/modifiers/applyStyles.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var _dom_utils_getNodeName_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getNodeName.js");
            var _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            function applyStyles(_ref) {
                var state = _ref.state;
                Object.keys(state.elements).forEach((function(name) {
                    var style = state.styles[name] || {};
                    var attributes = state.attributes[name] || {};
                    var element = state.elements[name];
                    if (!(0, _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(element) || !(0, 
                    _dom_utils_getNodeName_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element)) {
                        return;
                    }
                    Object.assign(element.style, style);
                    Object.keys(attributes).forEach((function(name) {
                        var value = attributes[name];
                        if (value === false) {
                            element.removeAttribute(name);
                        } else {
                            element.setAttribute(name, value === true ? "" : value);
                        }
                    }));
                }));
            }
            function effect(_ref2) {
                var state = _ref2.state;
                var initialStyles = {
                    popper: {
                        position: state.options.strategy,
                        left: "0",
                        top: "0",
                        margin: "0"
                    },
                    arrow: {
                        position: "absolute"
                    },
                    reference: {}
                };
                Object.assign(state.elements.popper.style, initialStyles.popper);
                state.styles = initialStyles;
                if (state.elements.arrow) {
                    Object.assign(state.elements.arrow.style, initialStyles.arrow);
                }
                return function() {
                    Object.keys(state.elements).forEach((function(name) {
                        var element = state.elements[name];
                        var attributes = state.attributes[name] || {};
                        var styleProperties = Object.keys(state.styles.hasOwnProperty(name) ? state.styles[name] : initialStyles[name]);
                        var style = styleProperties.reduce((function(style, property) {
                            style[property] = "";
                            return style;
                        }), {});
                        if (!(0, _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_0__.isHTMLElement)(element) || !(0, 
                        _dom_utils_getNodeName_js__WEBPACK_IMPORTED_MODULE_1__["default"])(element)) {
                            return;
                        }
                        Object.assign(element.style, style);
                        Object.keys(attributes).forEach((function(attribute) {
                            element.removeAttribute(attribute);
                        }));
                    }));
                };
            }
            __webpack_exports__["default"] = {
                name: "applyStyles",
                enabled: true,
                phase: "write",
                fn: applyStyles,
                effect,
                requires: [ "computeStyles" ]
            };
        },
        "../node_modules/@popperjs/core/lib/modifiers/arrow.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
            var _dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js");
            var _dom_utils_contains_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/contains.js");
            var _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js");
            var _utils_getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js");
            var _utils_within_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/within.js");
            var _utils_mergePaddingObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/mergePaddingObject.js");
            var _utils_expandToHashMap_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/expandToHashMap.js");
            var _enums_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            var toPaddingObject = function toPaddingObject(padding, state) {
                padding = typeof padding === "function" ? padding(Object.assign({}, state.rects, {
                    placement: state.placement
                })) : padding;
                return (0, _utils_mergePaddingObject_js__WEBPACK_IMPORTED_MODULE_0__["default"])(typeof padding !== "number" ? padding : (0, 
                _utils_expandToHashMap_js__WEBPACK_IMPORTED_MODULE_1__["default"])(padding, _enums_js__WEBPACK_IMPORTED_MODULE_2__.basePlacements));
            };
            function arrow(_ref) {
                var _state$modifiersData$;
                var state = _ref.state, name = _ref.name, options = _ref.options;
                var arrowElement = state.elements.arrow;
                var popperOffsets = state.modifiersData.popperOffsets;
                var basePlacement = (0, _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(state.placement);
                var axis = (0, _utils_getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_4__["default"])(basePlacement);
                var isVertical = [ _enums_js__WEBPACK_IMPORTED_MODULE_2__.left, _enums_js__WEBPACK_IMPORTED_MODULE_2__.right ].indexOf(basePlacement) >= 0;
                var len = isVertical ? "height" : "width";
                if (!arrowElement || !popperOffsets) {
                    return;
                }
                var paddingObject = toPaddingObject(options.padding, state);
                var arrowRect = (0, _dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_5__["default"])(arrowElement);
                var minProp = axis === "y" ? _enums_js__WEBPACK_IMPORTED_MODULE_2__.top : _enums_js__WEBPACK_IMPORTED_MODULE_2__.left;
                var maxProp = axis === "y" ? _enums_js__WEBPACK_IMPORTED_MODULE_2__.bottom : _enums_js__WEBPACK_IMPORTED_MODULE_2__.right;
                var endDiff = state.rects.reference[len] + state.rects.reference[axis] - popperOffsets[axis] - state.rects.popper[len];
                var startDiff = popperOffsets[axis] - state.rects.reference[axis];
                var arrowOffsetParent = (0, _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_6__["default"])(arrowElement);
                var clientSize = arrowOffsetParent ? axis === "y" ? arrowOffsetParent.clientHeight || 0 : arrowOffsetParent.clientWidth || 0 : 0;
                var centerToReference = endDiff / 2 - startDiff / 2;
                var min = paddingObject[minProp];
                var max = clientSize - arrowRect[len] - paddingObject[maxProp];
                var center = clientSize / 2 - arrowRect[len] / 2 + centerToReference;
                var offset = (0, _utils_within_js__WEBPACK_IMPORTED_MODULE_7__.within)(min, center, max);
                var axisProp = axis;
                state.modifiersData[name] = (_state$modifiersData$ = {}, _state$modifiersData$[axisProp] = offset, 
                _state$modifiersData$.centerOffset = offset - center, _state$modifiersData$);
            }
            function effect(_ref2) {
                var state = _ref2.state, options = _ref2.options;
                var _options$element = options.element, arrowElement = _options$element === void 0 ? "[data-popper-arrow]" : _options$element;
                if (arrowElement == null) {
                    return;
                }
                if (typeof arrowElement === "string") {
                    arrowElement = state.elements.popper.querySelector(arrowElement);
                    if (!arrowElement) {
                        return;
                    }
                }
                if (true) {
                    if (!(0, _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_8__.isHTMLElement)(arrowElement)) {
                        console.error([ 'Popper: "arrow" element must be an HTMLElement (not an SVGElement).', "To use an SVG arrow, wrap it in an HTMLElement that will be used as", "the arrow." ].join(" "));
                    }
                }
                if (!(0, _dom_utils_contains_js__WEBPACK_IMPORTED_MODULE_9__["default"])(state.elements.popper, arrowElement)) {
                    if (true) {
                        console.error([ 'Popper: "arrow" modifier\'s `element` must be a child of the popper', "element." ].join(" "));
                    }
                    return;
                }
                state.elements.arrow = arrowElement;
            }
            __webpack_exports__["default"] = {
                name: "arrow",
                enabled: true,
                phase: "main",
                fn: arrow,
                effect,
                requires: [ "popperOffsets" ],
                requiresIfExists: [ "preventOverflow" ]
            };
        },
        "../node_modules/@popperjs/core/lib/modifiers/computeStyles.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                mapToStyles: function() {
                    return mapToStyles;
                }
            });
            var _enums_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js");
            var _dom_utils_getWindow_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
            var _dom_utils_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
            var _dom_utils_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getComputedStyle.js");
            var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
            var _utils_getVariation_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getVariation.js");
            var _utils_math_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/math.js");
            var unsetSides = {
                top: "auto",
                right: "auto",
                bottom: "auto",
                left: "auto"
            };
            function roundOffsetsByDPR(_ref) {
                var x = _ref.x, y = _ref.y;
                var win = window;
                var dpr = win.devicePixelRatio || 1;
                return {
                    x: (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_0__.round)(x * dpr) / dpr || 0,
                    y: (0, _utils_math_js__WEBPACK_IMPORTED_MODULE_0__.round)(y * dpr) / dpr || 0
                };
            }
            function mapToStyles(_ref2) {
                var _Object$assign2;
                var popper = _ref2.popper, popperRect = _ref2.popperRect, placement = _ref2.placement, variation = _ref2.variation, offsets = _ref2.offsets, position = _ref2.position, gpuAcceleration = _ref2.gpuAcceleration, adaptive = _ref2.adaptive, roundOffsets = _ref2.roundOffsets, isFixed = _ref2.isFixed;
                var _offsets$x = offsets.x, x = _offsets$x === void 0 ? 0 : _offsets$x, _offsets$y = offsets.y, y = _offsets$y === void 0 ? 0 : _offsets$y;
                var _ref3 = typeof roundOffsets === "function" ? roundOffsets({
                    x,
                    y
                }) : {
                    x,
                    y
                };
                x = _ref3.x;
                y = _ref3.y;
                var hasX = offsets.hasOwnProperty("x");
                var hasY = offsets.hasOwnProperty("y");
                var sideX = _enums_js__WEBPACK_IMPORTED_MODULE_1__.left;
                var sideY = _enums_js__WEBPACK_IMPORTED_MODULE_1__.top;
                var win = window;
                if (adaptive) {
                    var offsetParent = (0, _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_2__["default"])(popper);
                    var heightProp = "clientHeight";
                    var widthProp = "clientWidth";
                    if (offsetParent === (0, _dom_utils_getWindow_js__WEBPACK_IMPORTED_MODULE_3__["default"])(popper)) {
                        offsetParent = (0, _dom_utils_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_4__["default"])(popper);
                        if ((0, _dom_utils_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_5__["default"])(offsetParent).position !== "static" && position === "absolute") {
                            heightProp = "scrollHeight";
                            widthProp = "scrollWidth";
                        }
                    }
                    offsetParent = offsetParent;
                    if (placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.top || (placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.left || placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.right) && variation === _enums_js__WEBPACK_IMPORTED_MODULE_1__.end) {
                        sideY = _enums_js__WEBPACK_IMPORTED_MODULE_1__.bottom;
                        var offsetY = isFixed && offsetParent === win && win.visualViewport ? win.visualViewport.height : offsetParent[heightProp];
                        y -= offsetY - popperRect.height;
                        y *= gpuAcceleration ? 1 : -1;
                    }
                    if (placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.left || (placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.top || placement === _enums_js__WEBPACK_IMPORTED_MODULE_1__.bottom) && variation === _enums_js__WEBPACK_IMPORTED_MODULE_1__.end) {
                        sideX = _enums_js__WEBPACK_IMPORTED_MODULE_1__.right;
                        var offsetX = isFixed && offsetParent === win && win.visualViewport ? win.visualViewport.width : offsetParent[widthProp];
                        x -= offsetX - popperRect.width;
                        x *= gpuAcceleration ? 1 : -1;
                    }
                }
                var commonStyles = Object.assign({
                    position
                }, adaptive && unsetSides);
                var _ref4 = roundOffsets === true ? roundOffsetsByDPR({
                    x,
                    y
                }) : {
                    x,
                    y
                };
                x = _ref4.x;
                y = _ref4.y;
                if (gpuAcceleration) {
                    var _Object$assign;
                    return Object.assign({}, commonStyles, (_Object$assign = {}, _Object$assign[sideY] = hasY ? "0" : "", 
                    _Object$assign[sideX] = hasX ? "0" : "", _Object$assign.transform = (win.devicePixelRatio || 1) <= 1 ? "translate(" + x + "px, " + y + "px)" : "translate3d(" + x + "px, " + y + "px, 0)", 
                    _Object$assign));
                }
                return Object.assign({}, commonStyles, (_Object$assign2 = {}, _Object$assign2[sideY] = hasY ? y + "px" : "", 
                _Object$assign2[sideX] = hasX ? x + "px" : "", _Object$assign2.transform = "", _Object$assign2));
            }
            function computeStyles(_ref5) {
                var state = _ref5.state, options = _ref5.options;
                var _options$gpuAccelerat = options.gpuAcceleration, gpuAcceleration = _options$gpuAccelerat === void 0 ? true : _options$gpuAccelerat, _options$adaptive = options.adaptive, adaptive = _options$adaptive === void 0 ? true : _options$adaptive, _options$roundOffsets = options.roundOffsets, roundOffsets = _options$roundOffsets === void 0 ? true : _options$roundOffsets;
                if (true) {
                    var transitionProperty = (0, _dom_utils_getComputedStyle_js__WEBPACK_IMPORTED_MODULE_5__["default"])(state.elements.popper).transitionProperty || "";
                    if (adaptive && [ "transform", "top", "right", "bottom", "left" ].some((function(property) {
                        return transitionProperty.indexOf(property) >= 0;
                    }))) {
                        console.warn([ "Popper: Detected CSS transitions on at least one of the following", 'CSS properties: "transform", "top", "right", "bottom", "left".', "\n\n", 'Disable the "computeStyles" modifier\'s `adaptive` option to allow', "for smooth transitions, or remove these properties from the CSS", "transition declaration on the popper element if only transitioning", "opacity or background-color for example.", "\n\n", "We recommend using the popper element as a wrapper around an inner", "element that can have any CSS property transitioned for animations." ].join(" "));
                    }
                }
                var commonStyles = {
                    placement: (0, _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_6__["default"])(state.placement),
                    variation: (0, _utils_getVariation_js__WEBPACK_IMPORTED_MODULE_7__["default"])(state.placement),
                    popper: state.elements.popper,
                    popperRect: state.rects.popper,
                    gpuAcceleration,
                    isFixed: state.options.strategy === "fixed"
                };
                if (state.modifiersData.popperOffsets != null) {
                    state.styles.popper = Object.assign({}, state.styles.popper, mapToStyles(Object.assign({}, commonStyles, {
                        offsets: state.modifiersData.popperOffsets,
                        position: state.options.strategy,
                        adaptive,
                        roundOffsets
                    })));
                }
                if (state.modifiersData.arrow != null) {
                    state.styles.arrow = Object.assign({}, state.styles.arrow, mapToStyles(Object.assign({}, commonStyles, {
                        offsets: state.modifiersData.arrow,
                        position: "absolute",
                        adaptive: false,
                        roundOffsets
                    })));
                }
                state.attributes.popper = Object.assign({}, state.attributes.popper, {
                    "data-popper-placement": state.placement
                });
            }
            __webpack_exports__["default"] = {
                name: "computeStyles",
                enabled: true,
                phase: "beforeWrite",
                fn: computeStyles,
                data: {}
            };
        },
        "../node_modules/@popperjs/core/lib/modifiers/eventListeners.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var _dom_utils_getWindow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getWindow.js");
            var passive = {
                passive: true
            };
            function effect(_ref) {
                var state = _ref.state, instance = _ref.instance, options = _ref.options;
                var _options$scroll = options.scroll, scroll = _options$scroll === void 0 ? true : _options$scroll, _options$resize = options.resize, resize = _options$resize === void 0 ? true : _options$resize;
                var window = (0, _dom_utils_getWindow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(state.elements.popper);
                var scrollParents = [].concat(state.scrollParents.reference, state.scrollParents.popper);
                if (scroll) {
                    scrollParents.forEach((function(scrollParent) {
                        scrollParent.addEventListener("scroll", instance.update, passive);
                    }));
                }
                if (resize) {
                    window.addEventListener("resize", instance.update, passive);
                }
                return function() {
                    if (scroll) {
                        scrollParents.forEach((function(scrollParent) {
                            scrollParent.removeEventListener("scroll", instance.update, passive);
                        }));
                    }
                    if (resize) {
                        window.removeEventListener("resize", instance.update, passive);
                    }
                };
            }
            __webpack_exports__["default"] = {
                name: "eventListeners",
                enabled: true,
                phase: "write",
                fn: function fn() {},
                effect,
                data: {}
            };
        },
        "../node_modules/@popperjs/core/lib/modifiers/flip.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var _utils_getOppositePlacement_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getOppositePlacement.js");
            var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
            var _utils_getOppositeVariationPlacement_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getOppositeVariationPlacement.js");
            var _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/detectOverflow.js");
            var _utils_computeAutoPlacement_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/computeAutoPlacement.js");
            var _enums_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var _utils_getVariation_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getVariation.js");
            function getExpandedFallbackPlacements(placement) {
                if ((0, _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(placement) === _enums_js__WEBPACK_IMPORTED_MODULE_1__.auto) {
                    return [];
                }
                var oppositePlacement = (0, _utils_getOppositePlacement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(placement);
                return [ (0, _utils_getOppositeVariationPlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(placement), oppositePlacement, (0, 
                _utils_getOppositeVariationPlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(oppositePlacement) ];
            }
            function flip(_ref) {
                var state = _ref.state, options = _ref.options, name = _ref.name;
                if (state.modifiersData[name]._skip) {
                    return;
                }
                var _options$mainAxis = options.mainAxis, checkMainAxis = _options$mainAxis === void 0 ? true : _options$mainAxis, _options$altAxis = options.altAxis, checkAltAxis = _options$altAxis === void 0 ? true : _options$altAxis, specifiedFallbackPlacements = options.fallbackPlacements, padding = options.padding, boundary = options.boundary, rootBoundary = options.rootBoundary, altBoundary = options.altBoundary, _options$flipVariatio = options.flipVariations, flipVariations = _options$flipVariatio === void 0 ? true : _options$flipVariatio, allowedAutoPlacements = options.allowedAutoPlacements;
                var preferredPlacement = state.options.placement;
                var basePlacement = (0, _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(preferredPlacement);
                var isBasePlacement = basePlacement === preferredPlacement;
                var fallbackPlacements = specifiedFallbackPlacements || (isBasePlacement || !flipVariations ? [ (0, 
                _utils_getOppositePlacement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(preferredPlacement) ] : getExpandedFallbackPlacements(preferredPlacement));
                var placements = [ preferredPlacement ].concat(fallbackPlacements).reduce((function(acc, placement) {
                    return acc.concat((0, _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(placement) === _enums_js__WEBPACK_IMPORTED_MODULE_1__.auto ? (0, 
                    _utils_computeAutoPlacement_js__WEBPACK_IMPORTED_MODULE_4__["default"])(state, {
                        placement,
                        boundary,
                        rootBoundary,
                        padding,
                        flipVariations,
                        allowedAutoPlacements
                    }) : placement);
                }), []);
                var referenceRect = state.rects.reference;
                var popperRect = state.rects.popper;
                var checksMap = new Map;
                var makeFallbackChecks = true;
                var firstFittingPlacement = placements[0];
                for (var i = 0; i < placements.length; i++) {
                    var placement = placements[i];
                    var _basePlacement = (0, _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(placement);
                    var isStartVariation = (0, _utils_getVariation_js__WEBPACK_IMPORTED_MODULE_5__["default"])(placement) === _enums_js__WEBPACK_IMPORTED_MODULE_1__.start;
                    var isVertical = [ _enums_js__WEBPACK_IMPORTED_MODULE_1__.top, _enums_js__WEBPACK_IMPORTED_MODULE_1__.bottom ].indexOf(_basePlacement) >= 0;
                    var len = isVertical ? "width" : "height";
                    var overflow = (0, _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_6__["default"])(state, {
                        placement,
                        boundary,
                        rootBoundary,
                        altBoundary,
                        padding
                    });
                    var mainVariationSide = isVertical ? isStartVariation ? _enums_js__WEBPACK_IMPORTED_MODULE_1__.right : _enums_js__WEBPACK_IMPORTED_MODULE_1__.left : isStartVariation ? _enums_js__WEBPACK_IMPORTED_MODULE_1__.bottom : _enums_js__WEBPACK_IMPORTED_MODULE_1__.top;
                    if (referenceRect[len] > popperRect[len]) {
                        mainVariationSide = (0, _utils_getOppositePlacement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(mainVariationSide);
                    }
                    var altVariationSide = (0, _utils_getOppositePlacement_js__WEBPACK_IMPORTED_MODULE_2__["default"])(mainVariationSide);
                    var checks = [];
                    if (checkMainAxis) {
                        checks.push(overflow[_basePlacement] <= 0);
                    }
                    if (checkAltAxis) {
                        checks.push(overflow[mainVariationSide] <= 0, overflow[altVariationSide] <= 0);
                    }
                    if (checks.every((function(check) {
                        return check;
                    }))) {
                        firstFittingPlacement = placement;
                        makeFallbackChecks = false;
                        break;
                    }
                    checksMap.set(placement, checks);
                }
                if (makeFallbackChecks) {
                    var numberOfChecks = flipVariations ? 3 : 1;
                    var _loop = function _loop(_i) {
                        var fittingPlacement = placements.find((function(placement) {
                            var checks = checksMap.get(placement);
                            if (checks) {
                                return checks.slice(0, _i).every((function(check) {
                                    return check;
                                }));
                            }
                        }));
                        if (fittingPlacement) {
                            firstFittingPlacement = fittingPlacement;
                            return "break";
                        }
                    };
                    for (var _i = numberOfChecks; _i > 0; _i--) {
                        var _ret = _loop(_i);
                        if (_ret === "break") break;
                    }
                }
                if (state.placement !== firstFittingPlacement) {
                    state.modifiersData[name]._skip = true;
                    state.placement = firstFittingPlacement;
                    state.reset = true;
                }
            }
            __webpack_exports__["default"] = {
                name: "flip",
                enabled: true,
                phase: "main",
                fn: flip,
                requiresIfExists: [ "offset" ],
                data: {
                    _skip: false
                }
            };
        },
        "../node_modules/@popperjs/core/lib/modifiers/hide.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var _enums_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/detectOverflow.js");
            function getSideOffsets(overflow, rect, preventedOffsets) {
                if (preventedOffsets === void 0) {
                    preventedOffsets = {
                        x: 0,
                        y: 0
                    };
                }
                return {
                    top: overflow.top - rect.height - preventedOffsets.y,
                    right: overflow.right - rect.width + preventedOffsets.x,
                    bottom: overflow.bottom - rect.height + preventedOffsets.y,
                    left: overflow.left - rect.width - preventedOffsets.x
                };
            }
            function isAnySideFullyClipped(overflow) {
                return [ _enums_js__WEBPACK_IMPORTED_MODULE_0__.top, _enums_js__WEBPACK_IMPORTED_MODULE_0__.right, _enums_js__WEBPACK_IMPORTED_MODULE_0__.bottom, _enums_js__WEBPACK_IMPORTED_MODULE_0__.left ].some((function(side) {
                    return overflow[side] >= 0;
                }));
            }
            function hide(_ref) {
                var state = _ref.state, name = _ref.name;
                var referenceRect = state.rects.reference;
                var popperRect = state.rects.popper;
                var preventedOffsets = state.modifiersData.preventOverflow;
                var referenceOverflow = (0, _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_1__["default"])(state, {
                    elementContext: "reference"
                });
                var popperAltOverflow = (0, _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_1__["default"])(state, {
                    altBoundary: true
                });
                var referenceClippingOffsets = getSideOffsets(referenceOverflow, referenceRect);
                var popperEscapeOffsets = getSideOffsets(popperAltOverflow, popperRect, preventedOffsets);
                var isReferenceHidden = isAnySideFullyClipped(referenceClippingOffsets);
                var hasPopperEscaped = isAnySideFullyClipped(popperEscapeOffsets);
                state.modifiersData[name] = {
                    referenceClippingOffsets,
                    popperEscapeOffsets,
                    isReferenceHidden,
                    hasPopperEscaped
                };
                state.attributes.popper = Object.assign({}, state.attributes.popper, {
                    "data-popper-reference-hidden": isReferenceHidden,
                    "data-popper-escaped": hasPopperEscaped
                });
            }
            __webpack_exports__["default"] = {
                name: "hide",
                enabled: true,
                phase: "main",
                requiresIfExists: [ "preventOverflow" ],
                fn: hide
            };
        },
        "../node_modules/@popperjs/core/lib/modifiers/index.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                applyStyles: function() {
                    return _applyStyles_js__WEBPACK_IMPORTED_MODULE_0__["default"];
                },
                arrow: function() {
                    return _arrow_js__WEBPACK_IMPORTED_MODULE_1__["default"];
                },
                computeStyles: function() {
                    return _computeStyles_js__WEBPACK_IMPORTED_MODULE_2__["default"];
                },
                eventListeners: function() {
                    return _eventListeners_js__WEBPACK_IMPORTED_MODULE_3__["default"];
                },
                flip: function() {
                    return _flip_js__WEBPACK_IMPORTED_MODULE_4__["default"];
                },
                hide: function() {
                    return _hide_js__WEBPACK_IMPORTED_MODULE_5__["default"];
                },
                offset: function() {
                    return _offset_js__WEBPACK_IMPORTED_MODULE_6__["default"];
                },
                popperOffsets: function() {
                    return _popperOffsets_js__WEBPACK_IMPORTED_MODULE_7__["default"];
                },
                preventOverflow: function() {
                    return _preventOverflow_js__WEBPACK_IMPORTED_MODULE_8__["default"];
                }
            });
            var _applyStyles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/applyStyles.js");
            var _arrow_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/arrow.js");
            var _computeStyles_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/computeStyles.js");
            var _eventListeners_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/eventListeners.js");
            var _flip_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/flip.js");
            var _hide_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/hide.js");
            var _offset_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/offset.js");
            var _popperOffsets_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/popperOffsets.js");
            var _preventOverflow_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/preventOverflow.js");
        },
        "../node_modules/@popperjs/core/lib/modifiers/offset.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                distanceAndSkiddingToXY: function() {
                    return distanceAndSkiddingToXY;
                }
            });
            var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
            var _enums_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            function distanceAndSkiddingToXY(placement, rects, offset) {
                var basePlacement = (0, _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(placement);
                var invertDistance = [ _enums_js__WEBPACK_IMPORTED_MODULE_1__.left, _enums_js__WEBPACK_IMPORTED_MODULE_1__.top ].indexOf(basePlacement) >= 0 ? -1 : 1;
                var _ref = typeof offset === "function" ? offset(Object.assign({}, rects, {
                    placement
                })) : offset, skidding = _ref[0], distance = _ref[1];
                skidding = skidding || 0;
                distance = (distance || 0) * invertDistance;
                return [ _enums_js__WEBPACK_IMPORTED_MODULE_1__.left, _enums_js__WEBPACK_IMPORTED_MODULE_1__.right ].indexOf(basePlacement) >= 0 ? {
                    x: distance,
                    y: skidding
                } : {
                    x: skidding,
                    y: distance
                };
            }
            function offset(_ref2) {
                var state = _ref2.state, options = _ref2.options, name = _ref2.name;
                var _options$offset = options.offset, offset = _options$offset === void 0 ? [ 0, 0 ] : _options$offset;
                var data = _enums_js__WEBPACK_IMPORTED_MODULE_1__.placements.reduce((function(acc, placement) {
                    acc[placement] = distanceAndSkiddingToXY(placement, state.rects, offset);
                    return acc;
                }), {});
                var _data$state$placement = data[state.placement], x = _data$state$placement.x, y = _data$state$placement.y;
                if (state.modifiersData.popperOffsets != null) {
                    state.modifiersData.popperOffsets.x += x;
                    state.modifiersData.popperOffsets.y += y;
                }
                state.modifiersData[name] = data;
            }
            __webpack_exports__["default"] = {
                name: "offset",
                enabled: true,
                phase: "main",
                requires: [ "popperOffsets" ],
                fn: offset
            };
        },
        "../node_modules/@popperjs/core/lib/modifiers/popperOffsets.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var _utils_computeOffsets_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/computeOffsets.js");
            function popperOffsets(_ref) {
                var state = _ref.state, name = _ref.name;
                state.modifiersData[name] = (0, _utils_computeOffsets_js__WEBPACK_IMPORTED_MODULE_0__["default"])({
                    reference: state.rects.reference,
                    element: state.rects.popper,
                    strategy: "absolute",
                    placement: state.placement
                });
            }
            __webpack_exports__["default"] = {
                name: "popperOffsets",
                enabled: true,
                phase: "read",
                fn: popperOffsets,
                data: {}
            };
        },
        "../node_modules/@popperjs/core/lib/modifiers/preventOverflow.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var _enums_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
            var _utils_getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js");
            var _utils_getAltAxis_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getAltAxis.js");
            var _utils_within_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/within.js");
            var _dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getLayoutRect.js");
            var _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getOffsetParent.js");
            var _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/detectOverflow.js");
            var _utils_getVariation_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getVariation.js");
            var _utils_getFreshSideObject_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getFreshSideObject.js");
            var _utils_math_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/math.js");
            function preventOverflow(_ref) {
                var state = _ref.state, options = _ref.options, name = _ref.name;
                var _options$mainAxis = options.mainAxis, checkMainAxis = _options$mainAxis === void 0 ? true : _options$mainAxis, _options$altAxis = options.altAxis, checkAltAxis = _options$altAxis === void 0 ? false : _options$altAxis, boundary = options.boundary, rootBoundary = options.rootBoundary, altBoundary = options.altBoundary, padding = options.padding, _options$tether = options.tether, tether = _options$tether === void 0 ? true : _options$tether, _options$tetherOffset = options.tetherOffset, tetherOffset = _options$tetherOffset === void 0 ? 0 : _options$tetherOffset;
                var overflow = (0, _utils_detectOverflow_js__WEBPACK_IMPORTED_MODULE_0__["default"])(state, {
                    boundary,
                    rootBoundary,
                    padding,
                    altBoundary
                });
                var basePlacement = (0, _utils_getBasePlacement_js__WEBPACK_IMPORTED_MODULE_1__["default"])(state.placement);
                var variation = (0, _utils_getVariation_js__WEBPACK_IMPORTED_MODULE_2__["default"])(state.placement);
                var isBasePlacement = !variation;
                var mainAxis = (0, _utils_getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(basePlacement);
                var altAxis = (0, _utils_getAltAxis_js__WEBPACK_IMPORTED_MODULE_4__["default"])(mainAxis);
                var popperOffsets = state.modifiersData.popperOffsets;
                var referenceRect = state.rects.reference;
                var popperRect = state.rects.popper;
                var tetherOffsetValue = typeof tetherOffset === "function" ? tetherOffset(Object.assign({}, state.rects, {
                    placement: state.placement
                })) : tetherOffset;
                var normalizedTetherOffsetValue = typeof tetherOffsetValue === "number" ? {
                    mainAxis: tetherOffsetValue,
                    altAxis: tetherOffsetValue
                } : Object.assign({
                    mainAxis: 0,
                    altAxis: 0
                }, tetherOffsetValue);
                var offsetModifierState = state.modifiersData.offset ? state.modifiersData.offset[state.placement] : null;
                var data = {
                    x: 0,
                    y: 0
                };
                if (!popperOffsets) {
                    return;
                }
                if (checkMainAxis) {
                    var _offsetModifierState$;
                    var mainSide = mainAxis === "y" ? _enums_js__WEBPACK_IMPORTED_MODULE_5__.top : _enums_js__WEBPACK_IMPORTED_MODULE_5__.left;
                    var altSide = mainAxis === "y" ? _enums_js__WEBPACK_IMPORTED_MODULE_5__.bottom : _enums_js__WEBPACK_IMPORTED_MODULE_5__.right;
                    var len = mainAxis === "y" ? "height" : "width";
                    var offset = popperOffsets[mainAxis];
                    var min = offset + overflow[mainSide];
                    var max = offset - overflow[altSide];
                    var additive = tether ? -popperRect[len] / 2 : 0;
                    var minLen = variation === _enums_js__WEBPACK_IMPORTED_MODULE_5__.start ? referenceRect[len] : popperRect[len];
                    var maxLen = variation === _enums_js__WEBPACK_IMPORTED_MODULE_5__.start ? -popperRect[len] : -referenceRect[len];
                    var arrowElement = state.elements.arrow;
                    var arrowRect = tether && arrowElement ? (0, _dom_utils_getLayoutRect_js__WEBPACK_IMPORTED_MODULE_6__["default"])(arrowElement) : {
                        width: 0,
                        height: 0
                    };
                    var arrowPaddingObject = state.modifiersData["arrow#persistent"] ? state.modifiersData["arrow#persistent"].padding : (0, 
                    _utils_getFreshSideObject_js__WEBPACK_IMPORTED_MODULE_7__["default"])();
                    var arrowPaddingMin = arrowPaddingObject[mainSide];
                    var arrowPaddingMax = arrowPaddingObject[altSide];
                    var arrowLen = (0, _utils_within_js__WEBPACK_IMPORTED_MODULE_8__.within)(0, referenceRect[len], arrowRect[len]);
                    var minOffset = isBasePlacement ? referenceRect[len] / 2 - additive - arrowLen - arrowPaddingMin - normalizedTetherOffsetValue.mainAxis : minLen - arrowLen - arrowPaddingMin - normalizedTetherOffsetValue.mainAxis;
                    var maxOffset = isBasePlacement ? -referenceRect[len] / 2 + additive + arrowLen + arrowPaddingMax + normalizedTetherOffsetValue.mainAxis : maxLen + arrowLen + arrowPaddingMax + normalizedTetherOffsetValue.mainAxis;
                    var arrowOffsetParent = state.elements.arrow && (0, _dom_utils_getOffsetParent_js__WEBPACK_IMPORTED_MODULE_9__["default"])(state.elements.arrow);
                    var clientOffset = arrowOffsetParent ? mainAxis === "y" ? arrowOffsetParent.clientTop || 0 : arrowOffsetParent.clientLeft || 0 : 0;
                    var offsetModifierValue = (_offsetModifierState$ = offsetModifierState == null ? void 0 : offsetModifierState[mainAxis]) != null ? _offsetModifierState$ : 0;
                    var tetherMin = offset + minOffset - offsetModifierValue - clientOffset;
                    var tetherMax = offset + maxOffset - offsetModifierValue;
                    var preventedOffset = (0, _utils_within_js__WEBPACK_IMPORTED_MODULE_8__.within)(tether ? (0, 
                    _utils_math_js__WEBPACK_IMPORTED_MODULE_10__.min)(min, tetherMin) : min, offset, tether ? (0, 
                    _utils_math_js__WEBPACK_IMPORTED_MODULE_10__.max)(max, tetherMax) : max);
                    popperOffsets[mainAxis] = preventedOffset;
                    data[mainAxis] = preventedOffset - offset;
                }
                if (checkAltAxis) {
                    var _offsetModifierState$2;
                    var _mainSide = mainAxis === "x" ? _enums_js__WEBPACK_IMPORTED_MODULE_5__.top : _enums_js__WEBPACK_IMPORTED_MODULE_5__.left;
                    var _altSide = mainAxis === "x" ? _enums_js__WEBPACK_IMPORTED_MODULE_5__.bottom : _enums_js__WEBPACK_IMPORTED_MODULE_5__.right;
                    var _offset = popperOffsets[altAxis];
                    var _len = altAxis === "y" ? "height" : "width";
                    var _min = _offset + overflow[_mainSide];
                    var _max = _offset - overflow[_altSide];
                    var isOriginSide = [ _enums_js__WEBPACK_IMPORTED_MODULE_5__.top, _enums_js__WEBPACK_IMPORTED_MODULE_5__.left ].indexOf(basePlacement) !== -1;
                    var _offsetModifierValue = (_offsetModifierState$2 = offsetModifierState == null ? void 0 : offsetModifierState[altAxis]) != null ? _offsetModifierState$2 : 0;
                    var _tetherMin = isOriginSide ? _min : _offset - referenceRect[_len] - popperRect[_len] - _offsetModifierValue + normalizedTetherOffsetValue.altAxis;
                    var _tetherMax = isOriginSide ? _offset + referenceRect[_len] + popperRect[_len] - _offsetModifierValue - normalizedTetherOffsetValue.altAxis : _max;
                    var _preventedOffset = tether && isOriginSide ? (0, _utils_within_js__WEBPACK_IMPORTED_MODULE_8__.withinMaxClamp)(_tetherMin, _offset, _tetherMax) : (0, 
                    _utils_within_js__WEBPACK_IMPORTED_MODULE_8__.within)(tether ? _tetherMin : _min, _offset, tether ? _tetherMax : _max);
                    popperOffsets[altAxis] = _preventedOffset;
                    data[altAxis] = _preventedOffset - _offset;
                }
                state.modifiersData[name] = data;
            }
            __webpack_exports__["default"] = {
                name: "preventOverflow",
                enabled: true,
                phase: "main",
                fn: preventOverflow,
                requiresIfExists: [ "offset" ]
            };
        },
        "../node_modules/@popperjs/core/lib/popper-lite.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                createPopper: function() {
                    return createPopper;
                },
                defaultModifiers: function() {
                    return defaultModifiers;
                },
                detectOverflow: function() {
                    return _createPopper_js__WEBPACK_IMPORTED_MODULE_5__["default"];
                },
                popperGenerator: function() {
                    return _createPopper_js__WEBPACK_IMPORTED_MODULE_4__.popperGenerator;
                }
            });
            var _createPopper_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/createPopper.js");
            var _createPopper_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/detectOverflow.js");
            var _modifiers_eventListeners_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/eventListeners.js");
            var _modifiers_popperOffsets_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/popperOffsets.js");
            var _modifiers_computeStyles_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/computeStyles.js");
            var _modifiers_applyStyles_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/applyStyles.js");
            var defaultModifiers = [ _modifiers_eventListeners_js__WEBPACK_IMPORTED_MODULE_0__["default"], _modifiers_popperOffsets_js__WEBPACK_IMPORTED_MODULE_1__["default"], _modifiers_computeStyles_js__WEBPACK_IMPORTED_MODULE_2__["default"], _modifiers_applyStyles_js__WEBPACK_IMPORTED_MODULE_3__["default"] ];
            var createPopper = (0, _createPopper_js__WEBPACK_IMPORTED_MODULE_4__.popperGenerator)({
                defaultModifiers
            });
        },
        "../node_modules/@popperjs/core/lib/popper.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                applyStyles: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.applyStyles;
                },
                arrow: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.arrow;
                },
                computeStyles: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.computeStyles;
                },
                createPopper: function() {
                    return createPopper;
                },
                createPopperLite: function() {
                    return _popper_lite_js__WEBPACK_IMPORTED_MODULE_11__.createPopper;
                },
                defaultModifiers: function() {
                    return defaultModifiers;
                },
                detectOverflow: function() {
                    return _createPopper_js__WEBPACK_IMPORTED_MODULE_10__["default"];
                },
                eventListeners: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.eventListeners;
                },
                flip: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.flip;
                },
                hide: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.hide;
                },
                offset: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.offset;
                },
                popperGenerator: function() {
                    return _createPopper_js__WEBPACK_IMPORTED_MODULE_9__.popperGenerator;
                },
                popperOffsets: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.popperOffsets;
                },
                preventOverflow: function() {
                    return _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__.preventOverflow;
                }
            });
            var _createPopper_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__("../node_modules/@popperjs/core/lib/createPopper.js");
            var _createPopper_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/detectOverflow.js");
            var _modifiers_eventListeners_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/eventListeners.js");
            var _modifiers_popperOffsets_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/popperOffsets.js");
            var _modifiers_computeStyles_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/computeStyles.js");
            var _modifiers_applyStyles_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/applyStyles.js");
            var _modifiers_offset_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/offset.js");
            var _modifiers_flip_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/flip.js");
            var _modifiers_preventOverflow_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/preventOverflow.js");
            var _modifiers_arrow_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/arrow.js");
            var _modifiers_hide_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/hide.js");
            var _popper_lite_js__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__("../node_modules/@popperjs/core/lib/popper-lite.js");
            var _modifiers_index_js__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__("../node_modules/@popperjs/core/lib/modifiers/index.js");
            var defaultModifiers = [ _modifiers_eventListeners_js__WEBPACK_IMPORTED_MODULE_0__["default"], _modifiers_popperOffsets_js__WEBPACK_IMPORTED_MODULE_1__["default"], _modifiers_computeStyles_js__WEBPACK_IMPORTED_MODULE_2__["default"], _modifiers_applyStyles_js__WEBPACK_IMPORTED_MODULE_3__["default"], _modifiers_offset_js__WEBPACK_IMPORTED_MODULE_4__["default"], _modifiers_flip_js__WEBPACK_IMPORTED_MODULE_5__["default"], _modifiers_preventOverflow_js__WEBPACK_IMPORTED_MODULE_6__["default"], _modifiers_arrow_js__WEBPACK_IMPORTED_MODULE_7__["default"], _modifiers_hide_js__WEBPACK_IMPORTED_MODULE_8__["default"] ];
            var createPopper = (0, _createPopper_js__WEBPACK_IMPORTED_MODULE_9__.popperGenerator)({
                defaultModifiers
            });
        },
        "../node_modules/@popperjs/core/lib/utils/computeAutoPlacement.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return computeAutoPlacement;
                }
            });
            var _getVariation_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getVariation.js");
            var _enums_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var _detectOverflow_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/detectOverflow.js");
            var _getBasePlacement_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
            function computeAutoPlacement(state, options) {
                if (options === void 0) {
                    options = {};
                }
                var _options = options, placement = _options.placement, boundary = _options.boundary, rootBoundary = _options.rootBoundary, padding = _options.padding, flipVariations = _options.flipVariations, _options$allowedAutoP = _options.allowedAutoPlacements, allowedAutoPlacements = _options$allowedAutoP === void 0 ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.placements : _options$allowedAutoP;
                var variation = (0, _getVariation_js__WEBPACK_IMPORTED_MODULE_1__["default"])(placement);
                var placements = variation ? flipVariations ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.variationPlacements : _enums_js__WEBPACK_IMPORTED_MODULE_0__.variationPlacements.filter((function(placement) {
                    return (0, _getVariation_js__WEBPACK_IMPORTED_MODULE_1__["default"])(placement) === variation;
                })) : _enums_js__WEBPACK_IMPORTED_MODULE_0__.basePlacements;
                var allowedPlacements = placements.filter((function(placement) {
                    return allowedAutoPlacements.indexOf(placement) >= 0;
                }));
                if (allowedPlacements.length === 0) {
                    allowedPlacements = placements;
                    if (true) {
                        console.error([ "Popper: The `allowedAutoPlacements` option did not allow any", "placements. Ensure the `placement` option matches the variation", "of the allowed placements.", 'For example, "auto" cannot be used to allow "bottom-start".', 'Use "auto-start" instead.' ].join(" "));
                    }
                }
                var overflows = allowedPlacements.reduce((function(acc, placement) {
                    acc[placement] = (0, _detectOverflow_js__WEBPACK_IMPORTED_MODULE_2__["default"])(state, {
                        placement,
                        boundary,
                        rootBoundary,
                        padding
                    })[(0, _getBasePlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(placement)];
                    return acc;
                }), {});
                return Object.keys(overflows).sort((function(a, b) {
                    return overflows[a] - overflows[b];
                }));
            }
        },
        "../node_modules/@popperjs/core/lib/utils/computeOffsets.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return computeOffsets;
                }
            });
            var _getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getBasePlacement.js");
            var _getVariation_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getVariation.js");
            var _getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js");
            var _enums_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            function computeOffsets(_ref) {
                var reference = _ref.reference, element = _ref.element, placement = _ref.placement;
                var basePlacement = placement ? (0, _getBasePlacement_js__WEBPACK_IMPORTED_MODULE_0__["default"])(placement) : null;
                var variation = placement ? (0, _getVariation_js__WEBPACK_IMPORTED_MODULE_1__["default"])(placement) : null;
                var commonX = reference.x + reference.width / 2 - element.width / 2;
                var commonY = reference.y + reference.height / 2 - element.height / 2;
                var offsets;
                switch (basePlacement) {
                  case _enums_js__WEBPACK_IMPORTED_MODULE_2__.top:
                    offsets = {
                        x: commonX,
                        y: reference.y - element.height
                    };
                    break;

                  case _enums_js__WEBPACK_IMPORTED_MODULE_2__.bottom:
                    offsets = {
                        x: commonX,
                        y: reference.y + reference.height
                    };
                    break;

                  case _enums_js__WEBPACK_IMPORTED_MODULE_2__.right:
                    offsets = {
                        x: reference.x + reference.width,
                        y: commonY
                    };
                    break;

                  case _enums_js__WEBPACK_IMPORTED_MODULE_2__.left:
                    offsets = {
                        x: reference.x - element.width,
                        y: commonY
                    };
                    break;

                  default:
                    offsets = {
                        x: reference.x,
                        y: reference.y
                    };
                }
                var mainAxis = basePlacement ? (0, _getMainAxisFromPlacement_js__WEBPACK_IMPORTED_MODULE_3__["default"])(basePlacement) : null;
                if (mainAxis != null) {
                    var len = mainAxis === "y" ? "height" : "width";
                    switch (variation) {
                      case _enums_js__WEBPACK_IMPORTED_MODULE_2__.start:
                        offsets[mainAxis] = offsets[mainAxis] - (reference[len] / 2 - element[len] / 2);
                        break;

                      case _enums_js__WEBPACK_IMPORTED_MODULE_2__.end:
                        offsets[mainAxis] = offsets[mainAxis] + (reference[len] / 2 - element[len] / 2);
                        break;

                      default:
                    }
                }
                return offsets;
            }
        },
        "../node_modules/@popperjs/core/lib/utils/debounce.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return debounce;
                }
            });
            function debounce(fn) {
                var pending;
                return function() {
                    if (!pending) {
                        pending = new Promise((function(resolve) {
                            Promise.resolve().then((function() {
                                pending = undefined;
                                resolve(fn());
                            }));
                        }));
                    }
                    return pending;
                };
            }
        },
        "../node_modules/@popperjs/core/lib/utils/detectOverflow.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return detectOverflow;
                }
            });
            var _dom_utils_getClippingRect_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getClippingRect.js");
            var _dom_utils_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getDocumentElement.js");
            var _dom_utils_getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/getBoundingClientRect.js");
            var _computeOffsets_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/computeOffsets.js");
            var _rectToClientRect_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/rectToClientRect.js");
            var _enums_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/@popperjs/core/lib/dom-utils/instanceOf.js");
            var _mergePaddingObject_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/mergePaddingObject.js");
            var _expandToHashMap_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/expandToHashMap.js");
            function detectOverflow(state, options) {
                if (options === void 0) {
                    options = {};
                }
                var _options = options, _options$placement = _options.placement, placement = _options$placement === void 0 ? state.placement : _options$placement, _options$boundary = _options.boundary, boundary = _options$boundary === void 0 ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.clippingParents : _options$boundary, _options$rootBoundary = _options.rootBoundary, rootBoundary = _options$rootBoundary === void 0 ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.viewport : _options$rootBoundary, _options$elementConte = _options.elementContext, elementContext = _options$elementConte === void 0 ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper : _options$elementConte, _options$altBoundary = _options.altBoundary, altBoundary = _options$altBoundary === void 0 ? false : _options$altBoundary, _options$padding = _options.padding, padding = _options$padding === void 0 ? 0 : _options$padding;
                var paddingObject = (0, _mergePaddingObject_js__WEBPACK_IMPORTED_MODULE_1__["default"])(typeof padding !== "number" ? padding : (0, 
                _expandToHashMap_js__WEBPACK_IMPORTED_MODULE_2__["default"])(padding, _enums_js__WEBPACK_IMPORTED_MODULE_0__.basePlacements));
                var altContext = elementContext === _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper ? _enums_js__WEBPACK_IMPORTED_MODULE_0__.reference : _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper;
                var popperRect = state.rects.popper;
                var element = state.elements[altBoundary ? altContext : elementContext];
                var clippingClientRect = (0, _dom_utils_getClippingRect_js__WEBPACK_IMPORTED_MODULE_3__["default"])((0, 
                _dom_utils_instanceOf_js__WEBPACK_IMPORTED_MODULE_4__.isElement)(element) ? element : element.contextElement || (0, 
                _dom_utils_getDocumentElement_js__WEBPACK_IMPORTED_MODULE_5__["default"])(state.elements.popper), boundary, rootBoundary);
                var referenceClientRect = (0, _dom_utils_getBoundingClientRect_js__WEBPACK_IMPORTED_MODULE_6__["default"])(state.elements.reference);
                var popperOffsets = (0, _computeOffsets_js__WEBPACK_IMPORTED_MODULE_7__["default"])({
                    reference: referenceClientRect,
                    element: popperRect,
                    strategy: "absolute",
                    placement
                });
                var popperClientRect = (0, _rectToClientRect_js__WEBPACK_IMPORTED_MODULE_8__["default"])(Object.assign({}, popperRect, popperOffsets));
                var elementClientRect = elementContext === _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper ? popperClientRect : referenceClientRect;
                var overflowOffsets = {
                    top: clippingClientRect.top - elementClientRect.top + paddingObject.top,
                    bottom: elementClientRect.bottom - clippingClientRect.bottom + paddingObject.bottom,
                    left: clippingClientRect.left - elementClientRect.left + paddingObject.left,
                    right: elementClientRect.right - clippingClientRect.right + paddingObject.right
                };
                var offsetData = state.modifiersData.offset;
                if (elementContext === _enums_js__WEBPACK_IMPORTED_MODULE_0__.popper && offsetData) {
                    var offset = offsetData[placement];
                    Object.keys(overflowOffsets).forEach((function(key) {
                        var multiply = [ _enums_js__WEBPACK_IMPORTED_MODULE_0__.right, _enums_js__WEBPACK_IMPORTED_MODULE_0__.bottom ].indexOf(key) >= 0 ? 1 : -1;
                        var axis = [ _enums_js__WEBPACK_IMPORTED_MODULE_0__.top, _enums_js__WEBPACK_IMPORTED_MODULE_0__.bottom ].indexOf(key) >= 0 ? "y" : "x";
                        overflowOffsets[key] += offset[axis] * multiply;
                    }));
                }
                return overflowOffsets;
            }
        },
        "../node_modules/@popperjs/core/lib/utils/expandToHashMap.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return expandToHashMap;
                }
            });
            function expandToHashMap(value, keys) {
                return keys.reduce((function(hashMap, key) {
                    hashMap[key] = value;
                    return hashMap;
                }), {});
            }
        },
        "../node_modules/@popperjs/core/lib/utils/format.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return format;
                }
            });
            function format(str) {
                for (var _len = arguments.length, args = new Array(_len > 1 ? _len - 1 : 0), _key = 1; _key < _len; _key++) {
                    args[_key - 1] = arguments[_key];
                }
                return [].concat(args).reduce((function(p, c) {
                    return p.replace(/%s/, c);
                }), str);
            }
        },
        "../node_modules/@popperjs/core/lib/utils/getAltAxis.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getAltAxis;
                }
            });
            function getAltAxis(axis) {
                return axis === "x" ? "y" : "x";
            }
        },
        "../node_modules/@popperjs/core/lib/utils/getBasePlacement.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getBasePlacement;
                }
            });
            function getBasePlacement(placement) {
                return placement.split("-")[0];
            }
        },
        "../node_modules/@popperjs/core/lib/utils/getFreshSideObject.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getFreshSideObject;
                }
            });
            function getFreshSideObject() {
                return {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                };
            }
        },
        "../node_modules/@popperjs/core/lib/utils/getMainAxisFromPlacement.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getMainAxisFromPlacement;
                }
            });
            function getMainAxisFromPlacement(placement) {
                return [ "top", "bottom" ].indexOf(placement) >= 0 ? "x" : "y";
            }
        },
        "../node_modules/@popperjs/core/lib/utils/getOppositePlacement.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getOppositePlacement;
                }
            });
            var hash = {
                left: "right",
                right: "left",
                bottom: "top",
                top: "bottom"
            };
            function getOppositePlacement(placement) {
                return placement.replace(/left|right|bottom|top/g, (function(matched) {
                    return hash[matched];
                }));
            }
        },
        "../node_modules/@popperjs/core/lib/utils/getOppositeVariationPlacement.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getOppositeVariationPlacement;
                }
            });
            var hash = {
                start: "end",
                end: "start"
            };
            function getOppositeVariationPlacement(placement) {
                return placement.replace(/start|end/g, (function(matched) {
                    return hash[matched];
                }));
            }
        },
        "../node_modules/@popperjs/core/lib/utils/getVariation.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return getVariation;
                }
            });
            function getVariation(placement) {
                return placement.split("-")[1];
            }
        },
        "../node_modules/@popperjs/core/lib/utils/math.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                max: function() {
                    return max;
                },
                min: function() {
                    return min;
                },
                round: function() {
                    return round;
                }
            });
            var max = Math.max;
            var min = Math.min;
            var round = Math.round;
        },
        "../node_modules/@popperjs/core/lib/utils/mergeByName.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return mergeByName;
                }
            });
            function mergeByName(modifiers) {
                var merged = modifiers.reduce((function(merged, current) {
                    var existing = merged[current.name];
                    merged[current.name] = existing ? Object.assign({}, existing, current, {
                        options: Object.assign({}, existing.options, current.options),
                        data: Object.assign({}, existing.data, current.data)
                    }) : current;
                    return merged;
                }), {});
                return Object.keys(merged).map((function(key) {
                    return merged[key];
                }));
            }
        },
        "../node_modules/@popperjs/core/lib/utils/mergePaddingObject.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return mergePaddingObject;
                }
            });
            var _getFreshSideObject_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/getFreshSideObject.js");
            function mergePaddingObject(paddingObject) {
                return Object.assign({}, (0, _getFreshSideObject_js__WEBPACK_IMPORTED_MODULE_0__["default"])(), paddingObject);
            }
        },
        "../node_modules/@popperjs/core/lib/utils/orderModifiers.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return orderModifiers;
                }
            });
            var _enums_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            function order(modifiers) {
                var map = new Map;
                var visited = new Set;
                var result = [];
                modifiers.forEach((function(modifier) {
                    map.set(modifier.name, modifier);
                }));
                function sort(modifier) {
                    visited.add(modifier.name);
                    var requires = [].concat(modifier.requires || [], modifier.requiresIfExists || []);
                    requires.forEach((function(dep) {
                        if (!visited.has(dep)) {
                            var depModifier = map.get(dep);
                            if (depModifier) {
                                sort(depModifier);
                            }
                        }
                    }));
                    result.push(modifier);
                }
                modifiers.forEach((function(modifier) {
                    if (!visited.has(modifier.name)) {
                        sort(modifier);
                    }
                }));
                return result;
            }
            function orderModifiers(modifiers) {
                var orderedModifiers = order(modifiers);
                return _enums_js__WEBPACK_IMPORTED_MODULE_0__.modifierPhases.reduce((function(acc, phase) {
                    return acc.concat(orderedModifiers.filter((function(modifier) {
                        return modifier.phase === phase;
                    })));
                }), []);
            }
        },
        "../node_modules/@popperjs/core/lib/utils/rectToClientRect.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return rectToClientRect;
                }
            });
            function rectToClientRect(rect) {
                return Object.assign({}, rect, {
                    left: rect.x,
                    top: rect.y,
                    right: rect.x + rect.width,
                    bottom: rect.y + rect.height
                });
            }
        },
        "../node_modules/@popperjs/core/lib/utils/uniqueBy.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return uniqueBy;
                }
            });
            function uniqueBy(arr, fn) {
                var identifiers = new Set;
                return arr.filter((function(item) {
                    var identifier = fn(item);
                    if (!identifiers.has(identifier)) {
                        identifiers.add(identifier);
                        return true;
                    }
                }));
            }
        },
        "../node_modules/@popperjs/core/lib/utils/validateModifiers.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return validateModifiers;
                }
            });
            var _format_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/format.js");
            var _enums_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/enums.js");
            var INVALID_MODIFIER_ERROR = 'Popper: modifier "%s" provided an invalid %s property, expected %s but got %s';
            var MISSING_DEPENDENCY_ERROR = 'Popper: modifier "%s" requires "%s", but "%s" modifier is not available';
            var VALID_PROPERTIES = [ "name", "enabled", "phase", "fn", "effect", "requires", "options" ];
            function validateModifiers(modifiers) {
                modifiers.forEach((function(modifier) {
                    [].concat(Object.keys(modifier), VALID_PROPERTIES).filter((function(value, index, self) {
                        return self.indexOf(value) === index;
                    })).forEach((function(key) {
                        switch (key) {
                          case "name":
                            if (typeof modifier.name !== "string") {
                                console.error((0, _format_js__WEBPACK_IMPORTED_MODULE_0__["default"])(INVALID_MODIFIER_ERROR, String(modifier.name), '"name"', '"string"', '"' + String(modifier.name) + '"'));
                            }
                            break;

                          case "enabled":
                            if (typeof modifier.enabled !== "boolean") {
                                console.error((0, _format_js__WEBPACK_IMPORTED_MODULE_0__["default"])(INVALID_MODIFIER_ERROR, modifier.name, '"enabled"', '"boolean"', '"' + String(modifier.enabled) + '"'));
                            }
                            break;

                          case "phase":
                            if (_enums_js__WEBPACK_IMPORTED_MODULE_1__.modifierPhases.indexOf(modifier.phase) < 0) {
                                console.error((0, _format_js__WEBPACK_IMPORTED_MODULE_0__["default"])(INVALID_MODIFIER_ERROR, modifier.name, '"phase"', "either " + _enums_js__WEBPACK_IMPORTED_MODULE_1__.modifierPhases.join(", "), '"' + String(modifier.phase) + '"'));
                            }
                            break;

                          case "fn":
                            if (typeof modifier.fn !== "function") {
                                console.error((0, _format_js__WEBPACK_IMPORTED_MODULE_0__["default"])(INVALID_MODIFIER_ERROR, modifier.name, '"fn"', '"function"', '"' + String(modifier.fn) + '"'));
                            }
                            break;

                          case "effect":
                            if (modifier.effect != null && typeof modifier.effect !== "function") {
                                console.error((0, _format_js__WEBPACK_IMPORTED_MODULE_0__["default"])(INVALID_MODIFIER_ERROR, modifier.name, '"effect"', '"function"', '"' + String(modifier.fn) + '"'));
                            }
                            break;

                          case "requires":
                            if (modifier.requires != null && !Array.isArray(modifier.requires)) {
                                console.error((0, _format_js__WEBPACK_IMPORTED_MODULE_0__["default"])(INVALID_MODIFIER_ERROR, modifier.name, '"requires"', '"array"', '"' + String(modifier.requires) + '"'));
                            }
                            break;

                          case "requiresIfExists":
                            if (!Array.isArray(modifier.requiresIfExists)) {
                                console.error((0, _format_js__WEBPACK_IMPORTED_MODULE_0__["default"])(INVALID_MODIFIER_ERROR, modifier.name, '"requiresIfExists"', '"array"', '"' + String(modifier.requiresIfExists) + '"'));
                            }
                            break;

                          case "options":
                          case "data":
                            break;

                          default:
                            console.error('PopperJS: an invalid property has been provided to the "' + modifier.name + '" modifier, valid properties are ' + VALID_PROPERTIES.map((function(s) {
                                return '"' + s + '"';
                            })).join(", ") + '; but "' + key + '" was provided.');
                        }
                        modifier.requires && modifier.requires.forEach((function(requirement) {
                            if (modifiers.find((function(mod) {
                                return mod.name === requirement;
                            })) == null) {
                                console.error((0, _format_js__WEBPACK_IMPORTED_MODULE_0__["default"])(MISSING_DEPENDENCY_ERROR, String(modifier.name), requirement, requirement));
                            }
                        }));
                    }));
                }));
            }
        },
        "../node_modules/@popperjs/core/lib/utils/within.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                within: function() {
                    return within;
                },
                withinMaxClamp: function() {
                    return withinMaxClamp;
                }
            });
            var _math_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/utils/math.js");
            function within(min, value, max) {
                return (0, _math_js__WEBPACK_IMPORTED_MODULE_0__.max)(min, (0, _math_js__WEBPACK_IMPORTED_MODULE_0__.min)(value, max));
            }
            function withinMaxClamp(min, value, max) {
                var v = within(min, value, max);
                return v > max ? max : v;
            }
        },
        "../node_modules/bootstrap/dist/js/bootstrap.esm.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                Alert: function() {
                    return Alert;
                },
                Button: function() {
                    return Button;
                },
                Carousel: function() {
                    return Carousel;
                },
                Collapse: function() {
                    return Collapse;
                },
                Dropdown: function() {
                    return Dropdown;
                },
                Modal: function() {
                    return Modal;
                },
                Offcanvas: function() {
                    return Offcanvas;
                },
                Popover: function() {
                    return Popover;
                },
                ScrollSpy: function() {
                    return ScrollSpy;
                },
                Tab: function() {
                    return Tab;
                },
                Toast: function() {
                    return Toast;
                },
                Tooltip: function() {
                    return Tooltip;
                }
            });
            var _popperjs_core__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@popperjs/core/lib/index.js");
            var _popperjs_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@popperjs/core/lib/popper.js");
            var __webpack_provided_window_dot_jQuery = __webpack_require__("jquery");
            const MAX_UID = 1e6;
            const MILLISECONDS_MULTIPLIER = 1e3;
            const TRANSITION_END = "transitionend";
            const toType = object => {
                if (object === null || object === undefined) {
                    return `${object}`;
                }
                return Object.prototype.toString.call(object).match(/\s([a-z]+)/i)[1].toLowerCase();
            };
            const getUID = prefix => {
                do {
                    prefix += Math.floor(Math.random() * MAX_UID);
                } while (document.getElementById(prefix));
                return prefix;
            };
            const getSelector = element => {
                let selector = element.getAttribute("data-bs-target");
                if (!selector || selector === "#") {
                    let hrefAttribute = element.getAttribute("href");
                    if (!hrefAttribute || !hrefAttribute.includes("#") && !hrefAttribute.startsWith(".")) {
                        return null;
                    }
                    if (hrefAttribute.includes("#") && !hrefAttribute.startsWith("#")) {
                        hrefAttribute = `#${hrefAttribute.split("#")[1]}`;
                    }
                    selector = hrefAttribute && hrefAttribute !== "#" ? hrefAttribute.trim() : null;
                }
                return selector;
            };
            const getSelectorFromElement = element => {
                const selector = getSelector(element);
                if (selector) {
                    return document.querySelector(selector) ? selector : null;
                }
                return null;
            };
            const getElementFromSelector = element => {
                const selector = getSelector(element);
                return selector ? document.querySelector(selector) : null;
            };
            const getTransitionDurationFromElement = element => {
                if (!element) {
                    return 0;
                }
                let {transitionDuration, transitionDelay} = window.getComputedStyle(element);
                const floatTransitionDuration = Number.parseFloat(transitionDuration);
                const floatTransitionDelay = Number.parseFloat(transitionDelay);
                if (!floatTransitionDuration && !floatTransitionDelay) {
                    return 0;
                }
                transitionDuration = transitionDuration.split(",")[0];
                transitionDelay = transitionDelay.split(",")[0];
                return (Number.parseFloat(transitionDuration) + Number.parseFloat(transitionDelay)) * MILLISECONDS_MULTIPLIER;
            };
            const triggerTransitionEnd = element => {
                element.dispatchEvent(new Event(TRANSITION_END));
            };
            const isElement = object => {
                if (!object || typeof object !== "object") {
                    return false;
                }
                if (typeof object.jquery !== "undefined") {
                    object = object[0];
                }
                return typeof object.nodeType !== "undefined";
            };
            const getElement = object => {
                if (isElement(object)) {
                    return object.jquery ? object[0] : object;
                }
                if (typeof object === "string" && object.length > 0) {
                    return document.querySelector(object);
                }
                return null;
            };
            const isVisible = element => {
                if (!isElement(element) || element.getClientRects().length === 0) {
                    return false;
                }
                const elementIsVisible = getComputedStyle(element).getPropertyValue("visibility") === "visible";
                const closedDetails = element.closest("details:not([open])");
                if (!closedDetails) {
                    return elementIsVisible;
                }
                if (closedDetails !== element) {
                    const summary = element.closest("summary");
                    if (summary && summary.parentNode !== closedDetails) {
                        return false;
                    }
                    if (summary === null) {
                        return false;
                    }
                }
                return elementIsVisible;
            };
            const isDisabled = element => {
                if (!element || element.nodeType !== Node.ELEMENT_NODE) {
                    return true;
                }
                if (element.classList.contains("disabled")) {
                    return true;
                }
                if (typeof element.disabled !== "undefined") {
                    return element.disabled;
                }
                return element.hasAttribute("disabled") && element.getAttribute("disabled") !== "false";
            };
            const findShadowRoot = element => {
                if (!document.documentElement.attachShadow) {
                    return null;
                }
                if (typeof element.getRootNode === "function") {
                    const root = element.getRootNode();
                    return root instanceof ShadowRoot ? root : null;
                }
                if (element instanceof ShadowRoot) {
                    return element;
                }
                if (!element.parentNode) {
                    return null;
                }
                return findShadowRoot(element.parentNode);
            };
            const noop = () => {};
            const reflow = element => {
                element.offsetHeight;
            };
            const getjQuery = () => {
                if (__webpack_provided_window_dot_jQuery && !document.body.hasAttribute("data-bs-no-jquery")) {
                    return __webpack_provided_window_dot_jQuery;
                }
                return null;
            };
            const DOMContentLoadedCallbacks = [];
            const onDOMContentLoaded = callback => {
                if (document.readyState === "loading") {
                    if (!DOMContentLoadedCallbacks.length) {
                        document.addEventListener("DOMContentLoaded", (() => {
                            for (const callback of DOMContentLoadedCallbacks) {
                                callback();
                            }
                        }));
                    }
                    DOMContentLoadedCallbacks.push(callback);
                } else {
                    callback();
                }
            };
            const isRTL = () => document.documentElement.dir === "rtl";
            const defineJQueryPlugin = plugin => {
                onDOMContentLoaded((() => {
                    const $ = getjQuery();
                    if ($) {
                        const name = plugin.NAME;
                        const JQUERY_NO_CONFLICT = $.fn[name];
                        $.fn[name] = plugin.jQueryInterface;
                        $.fn[name].Constructor = plugin;
                        $.fn[name].noConflict = () => {
                            $.fn[name] = JQUERY_NO_CONFLICT;
                            return plugin.jQueryInterface;
                        };
                    }
                }));
            };
            const execute = callback => {
                if (typeof callback === "function") {
                    callback();
                }
            };
            const executeAfterTransition = (callback, transitionElement, waitForTransition = true) => {
                if (!waitForTransition) {
                    execute(callback);
                    return;
                }
                const durationPadding = 5;
                const emulatedDuration = getTransitionDurationFromElement(transitionElement) + durationPadding;
                let called = false;
                const handler = ({target}) => {
                    if (target !== transitionElement) {
                        return;
                    }
                    called = true;
                    transitionElement.removeEventListener(TRANSITION_END, handler);
                    execute(callback);
                };
                transitionElement.addEventListener(TRANSITION_END, handler);
                setTimeout((() => {
                    if (!called) {
                        triggerTransitionEnd(transitionElement);
                    }
                }), emulatedDuration);
            };
            const getNextActiveElement = (list, activeElement, shouldGetNext, isCycleAllowed) => {
                const listLength = list.length;
                let index = list.indexOf(activeElement);
                if (index === -1) {
                    return !shouldGetNext && isCycleAllowed ? list[listLength - 1] : list[0];
                }
                index += shouldGetNext ? 1 : -1;
                if (isCycleAllowed) {
                    index = (index + listLength) % listLength;
                }
                return list[Math.max(0, Math.min(index, listLength - 1))];
            };
            const namespaceRegex = /[^.]*(?=\..*)\.|.*/;
            const stripNameRegex = /\..*/;
            const stripUidRegex = /::\d+$/;
            const eventRegistry = {};
            let uidEvent = 1;
            const customEvents = {
                mouseenter: "mouseover",
                mouseleave: "mouseout"
            };
            const nativeEvents = new Set([ "click", "dblclick", "mouseup", "mousedown", "contextmenu", "mousewheel", "DOMMouseScroll", "mouseover", "mouseout", "mousemove", "selectstart", "selectend", "keydown", "keypress", "keyup", "orientationchange", "touchstart", "touchmove", "touchend", "touchcancel", "pointerdown", "pointermove", "pointerup", "pointerleave", "pointercancel", "gesturestart", "gesturechange", "gestureend", "focus", "blur", "change", "reset", "select", "submit", "focusin", "focusout", "load", "unload", "beforeunload", "resize", "move", "DOMContentLoaded", "readystatechange", "error", "abort", "scroll" ]);
            function makeEventUid(element, uid) {
                return uid && `${uid}::${uidEvent++}` || element.uidEvent || uidEvent++;
            }
            function getElementEvents(element) {
                const uid = makeEventUid(element);
                element.uidEvent = uid;
                eventRegistry[uid] = eventRegistry[uid] || {};
                return eventRegistry[uid];
            }
            function bootstrapHandler(element, fn) {
                return function handler(event) {
                    hydrateObj(event, {
                        delegateTarget: element
                    });
                    if (handler.oneOff) {
                        EventHandler.off(element, event.type, fn);
                    }
                    return fn.apply(element, [ event ]);
                };
            }
            function bootstrapDelegationHandler(element, selector, fn) {
                return function handler(event) {
                    const domElements = element.querySelectorAll(selector);
                    for (let {target} = event; target && target !== this; target = target.parentNode) {
                        for (const domElement of domElements) {
                            if (domElement !== target) {
                                continue;
                            }
                            hydrateObj(event, {
                                delegateTarget: target
                            });
                            if (handler.oneOff) {
                                EventHandler.off(element, event.type, selector, fn);
                            }
                            return fn.apply(target, [ event ]);
                        }
                    }
                };
            }
            function findHandler(events, callable, delegationSelector = null) {
                return Object.values(events).find((event => event.callable === callable && event.delegationSelector === delegationSelector));
            }
            function normalizeParameters(originalTypeEvent, handler, delegationFunction) {
                const isDelegated = typeof handler === "string";
                const callable = isDelegated ? delegationFunction : handler || delegationFunction;
                let typeEvent = getTypeEvent(originalTypeEvent);
                if (!nativeEvents.has(typeEvent)) {
                    typeEvent = originalTypeEvent;
                }
                return [ isDelegated, callable, typeEvent ];
            }
            function addHandler(element, originalTypeEvent, handler, delegationFunction, oneOff) {
                if (typeof originalTypeEvent !== "string" || !element) {
                    return;
                }
                let [isDelegated, callable, typeEvent] = normalizeParameters(originalTypeEvent, handler, delegationFunction);
                if (originalTypeEvent in customEvents) {
                    const wrapFunction = fn => function(event) {
                        if (!event.relatedTarget || event.relatedTarget !== event.delegateTarget && !event.delegateTarget.contains(event.relatedTarget)) {
                            return fn.call(this, event);
                        }
                    };
                    callable = wrapFunction(callable);
                }
                const events = getElementEvents(element);
                const handlers = events[typeEvent] || (events[typeEvent] = {});
                const previousFunction = findHandler(handlers, callable, isDelegated ? handler : null);
                if (previousFunction) {
                    previousFunction.oneOff = previousFunction.oneOff && oneOff;
                    return;
                }
                const uid = makeEventUid(callable, originalTypeEvent.replace(namespaceRegex, ""));
                const fn = isDelegated ? bootstrapDelegationHandler(element, handler, callable) : bootstrapHandler(element, callable);
                fn.delegationSelector = isDelegated ? handler : null;
                fn.callable = callable;
                fn.oneOff = oneOff;
                fn.uidEvent = uid;
                handlers[uid] = fn;
                element.addEventListener(typeEvent, fn, isDelegated);
            }
            function removeHandler(element, events, typeEvent, handler, delegationSelector) {
                const fn = findHandler(events[typeEvent], handler, delegationSelector);
                if (!fn) {
                    return;
                }
                element.removeEventListener(typeEvent, fn, Boolean(delegationSelector));
                delete events[typeEvent][fn.uidEvent];
            }
            function removeNamespacedHandlers(element, events, typeEvent, namespace) {
                const storeElementEvent = events[typeEvent] || {};
                for (const handlerKey of Object.keys(storeElementEvent)) {
                    if (handlerKey.includes(namespace)) {
                        const event = storeElementEvent[handlerKey];
                        removeHandler(element, events, typeEvent, event.callable, event.delegationSelector);
                    }
                }
            }
            function getTypeEvent(event) {
                event = event.replace(stripNameRegex, "");
                return customEvents[event] || event;
            }
            const EventHandler = {
                on(element, event, handler, delegationFunction) {
                    addHandler(element, event, handler, delegationFunction, false);
                },
                one(element, event, handler, delegationFunction) {
                    addHandler(element, event, handler, delegationFunction, true);
                },
                off(element, originalTypeEvent, handler, delegationFunction) {
                    if (typeof originalTypeEvent !== "string" || !element) {
                        return;
                    }
                    const [isDelegated, callable, typeEvent] = normalizeParameters(originalTypeEvent, handler, delegationFunction);
                    const inNamespace = typeEvent !== originalTypeEvent;
                    const events = getElementEvents(element);
                    const storeElementEvent = events[typeEvent] || {};
                    const isNamespace = originalTypeEvent.startsWith(".");
                    if (typeof callable !== "undefined") {
                        if (!Object.keys(storeElementEvent).length) {
                            return;
                        }
                        removeHandler(element, events, typeEvent, callable, isDelegated ? handler : null);
                        return;
                    }
                    if (isNamespace) {
                        for (const elementEvent of Object.keys(events)) {
                            removeNamespacedHandlers(element, events, elementEvent, originalTypeEvent.slice(1));
                        }
                    }
                    for (const keyHandlers of Object.keys(storeElementEvent)) {
                        const handlerKey = keyHandlers.replace(stripUidRegex, "");
                        if (!inNamespace || originalTypeEvent.includes(handlerKey)) {
                            const event = storeElementEvent[keyHandlers];
                            removeHandler(element, events, typeEvent, event.callable, event.delegationSelector);
                        }
                    }
                },
                trigger(element, event, args) {
                    if (typeof event !== "string" || !element) {
                        return null;
                    }
                    const $ = getjQuery();
                    const typeEvent = getTypeEvent(event);
                    const inNamespace = event !== typeEvent;
                    let jQueryEvent = null;
                    let bubbles = true;
                    let nativeDispatch = true;
                    let defaultPrevented = false;
                    if (inNamespace && $) {
                        jQueryEvent = $.Event(event, args);
                        $(element).trigger(jQueryEvent);
                        bubbles = !jQueryEvent.isPropagationStopped();
                        nativeDispatch = !jQueryEvent.isImmediatePropagationStopped();
                        defaultPrevented = jQueryEvent.isDefaultPrevented();
                    }
                    let evt = new Event(event, {
                        bubbles,
                        cancelable: true
                    });
                    evt = hydrateObj(evt, args);
                    if (defaultPrevented) {
                        evt.preventDefault();
                    }
                    if (nativeDispatch) {
                        element.dispatchEvent(evt);
                    }
                    if (evt.defaultPrevented && jQueryEvent) {
                        jQueryEvent.preventDefault();
                    }
                    return evt;
                }
            };
            function hydrateObj(obj, meta) {
                for (const [key, value] of Object.entries(meta || {})) {
                    try {
                        obj[key] = value;
                    } catch (_unused) {
                        Object.defineProperty(obj, key, {
                            configurable: true,
                            get() {
                                return value;
                            }
                        });
                    }
                }
                return obj;
            }
            const elementMap = new Map;
            const Data = {
                set(element, key, instance) {
                    if (!elementMap.has(element)) {
                        elementMap.set(element, new Map);
                    }
                    const instanceMap = elementMap.get(element);
                    if (!instanceMap.has(key) && instanceMap.size !== 0) {
                        console.error(`Bootstrap doesn't allow more than one instance per element. Bound instance: ${Array.from(instanceMap.keys())[0]}.`);
                        return;
                    }
                    instanceMap.set(key, instance);
                },
                get(element, key) {
                    if (elementMap.has(element)) {
                        return elementMap.get(element).get(key) || null;
                    }
                    return null;
                },
                remove(element, key) {
                    if (!elementMap.has(element)) {
                        return;
                    }
                    const instanceMap = elementMap.get(element);
                    instanceMap.delete(key);
                    if (instanceMap.size === 0) {
                        elementMap.delete(element);
                    }
                }
            };
            function normalizeData(value) {
                if (value === "true") {
                    return true;
                }
                if (value === "false") {
                    return false;
                }
                if (value === Number(value).toString()) {
                    return Number(value);
                }
                if (value === "" || value === "null") {
                    return null;
                }
                if (typeof value !== "string") {
                    return value;
                }
                try {
                    return JSON.parse(decodeURIComponent(value));
                } catch (_unused) {
                    return value;
                }
            }
            function normalizeDataKey(key) {
                return key.replace(/[A-Z]/g, (chr => `-${chr.toLowerCase()}`));
            }
            const Manipulator = {
                setDataAttribute(element, key, value) {
                    element.setAttribute(`data-bs-${normalizeDataKey(key)}`, value);
                },
                removeDataAttribute(element, key) {
                    element.removeAttribute(`data-bs-${normalizeDataKey(key)}`);
                },
                getDataAttributes(element) {
                    if (!element) {
                        return {};
                    }
                    const attributes = {};
                    const bsKeys = Object.keys(element.dataset).filter((key => key.startsWith("bs") && !key.startsWith("bsConfig")));
                    for (const key of bsKeys) {
                        let pureKey = key.replace(/^bs/, "");
                        pureKey = pureKey.charAt(0).toLowerCase() + pureKey.slice(1, pureKey.length);
                        attributes[pureKey] = normalizeData(element.dataset[key]);
                    }
                    return attributes;
                },
                getDataAttribute(element, key) {
                    return normalizeData(element.getAttribute(`data-bs-${normalizeDataKey(key)}`));
                }
            };
            class Config {
                static get Default() {
                    return {};
                }
                static get DefaultType() {
                    return {};
                }
                static get NAME() {
                    throw new Error('You have to implement the static method "NAME", for each component!');
                }
                _getConfig(config) {
                    config = this._mergeConfigObj(config);
                    config = this._configAfterMerge(config);
                    this._typeCheckConfig(config);
                    return config;
                }
                _configAfterMerge(config) {
                    return config;
                }
                _mergeConfigObj(config, element) {
                    const jsonConfig = isElement(element) ? Manipulator.getDataAttribute(element, "config") : {};
                    return {
                        ...this.constructor.Default,
                        ...typeof jsonConfig === "object" ? jsonConfig : {},
                        ...isElement(element) ? Manipulator.getDataAttributes(element) : {},
                        ...typeof config === "object" ? config : {}
                    };
                }
                _typeCheckConfig(config, configTypes = this.constructor.DefaultType) {
                    for (const property of Object.keys(configTypes)) {
                        const expectedTypes = configTypes[property];
                        const value = config[property];
                        const valueType = isElement(value) ? "element" : toType(value);
                        if (!new RegExp(expectedTypes).test(valueType)) {
                            throw new TypeError(`${this.constructor.NAME.toUpperCase()}: Option "${property}" provided type "${valueType}" but expected type "${expectedTypes}".`);
                        }
                    }
                }
            }
            const VERSION = "5.2.0";
            class BaseComponent extends Config {
                constructor(element, config) {
                    super();
                    element = getElement(element);
                    if (!element) {
                        return;
                    }
                    this._element = element;
                    this._config = this._getConfig(config);
                    Data.set(this._element, this.constructor.DATA_KEY, this);
                }
                dispose() {
                    Data.remove(this._element, this.constructor.DATA_KEY);
                    EventHandler.off(this._element, this.constructor.EVENT_KEY);
                    for (const propertyName of Object.getOwnPropertyNames(this)) {
                        this[propertyName] = null;
                    }
                }
                _queueCallback(callback, element, isAnimated = true) {
                    executeAfterTransition(callback, element, isAnimated);
                }
                _getConfig(config) {
                    config = this._mergeConfigObj(config, this._element);
                    config = this._configAfterMerge(config);
                    this._typeCheckConfig(config);
                    return config;
                }
                static getInstance(element) {
                    return Data.get(getElement(element), this.DATA_KEY);
                }
                static getOrCreateInstance(element, config = {}) {
                    return this.getInstance(element) || new this(element, typeof config === "object" ? config : null);
                }
                static get VERSION() {
                    return VERSION;
                }
                static get DATA_KEY() {
                    return `bs.${this.NAME}`;
                }
                static get EVENT_KEY() {
                    return `.${this.DATA_KEY}`;
                }
                static eventName(name) {
                    return `${name}${this.EVENT_KEY}`;
                }
            }
            const enableDismissTrigger = (component, method = "hide") => {
                const clickEvent = `click.dismiss${component.EVENT_KEY}`;
                const name = component.NAME;
                EventHandler.on(document, clickEvent, `[data-bs-dismiss="${name}"]`, (function(event) {
                    if ([ "A", "AREA" ].includes(this.tagName)) {
                        event.preventDefault();
                    }
                    if (isDisabled(this)) {
                        return;
                    }
                    const target = getElementFromSelector(this) || this.closest(`.${name}`);
                    const instance = component.getOrCreateInstance(target);
                    instance[method]();
                }));
            };
            const NAME$f = "alert";
            const DATA_KEY$a = "bs.alert";
            const EVENT_KEY$b = `.${DATA_KEY$a}`;
            const EVENT_CLOSE = `close${EVENT_KEY$b}`;
            const EVENT_CLOSED = `closed${EVENT_KEY$b}`;
            const CLASS_NAME_FADE$5 = "fade";
            const CLASS_NAME_SHOW$8 = "show";
            class Alert extends BaseComponent {
                static get NAME() {
                    return NAME$f;
                }
                close() {
                    const closeEvent = EventHandler.trigger(this._element, EVENT_CLOSE);
                    if (closeEvent.defaultPrevented) {
                        return;
                    }
                    this._element.classList.remove(CLASS_NAME_SHOW$8);
                    const isAnimated = this._element.classList.contains(CLASS_NAME_FADE$5);
                    this._queueCallback((() => this._destroyElement()), this._element, isAnimated);
                }
                _destroyElement() {
                    this._element.remove();
                    EventHandler.trigger(this._element, EVENT_CLOSED);
                    this.dispose();
                }
                static jQueryInterface(config) {
                    return this.each((function() {
                        const data = Alert.getOrCreateInstance(this);
                        if (typeof config !== "string") {
                            return;
                        }
                        if (data[config] === undefined || config.startsWith("_") || config === "constructor") {
                            throw new TypeError(`No method named "${config}"`);
                        }
                        data[config](this);
                    }));
                }
            }
            enableDismissTrigger(Alert, "close");
            defineJQueryPlugin(Alert);
            const NAME$e = "button";
            const DATA_KEY$9 = "bs.button";
            const EVENT_KEY$a = `.${DATA_KEY$9}`;
            const DATA_API_KEY$6 = ".data-api";
            const CLASS_NAME_ACTIVE$3 = "active";
            const SELECTOR_DATA_TOGGLE$5 = '[data-bs-toggle="button"]';
            const EVENT_CLICK_DATA_API$6 = `click${EVENT_KEY$a}${DATA_API_KEY$6}`;
            class Button extends BaseComponent {
                static get NAME() {
                    return NAME$e;
                }
                toggle() {
                    this._element.setAttribute("aria-pressed", this._element.classList.toggle(CLASS_NAME_ACTIVE$3));
                }
                static jQueryInterface(config) {
                    return this.each((function() {
                        const data = Button.getOrCreateInstance(this);
                        if (config === "toggle") {
                            data[config]();
                        }
                    }));
                }
            }
            EventHandler.on(document, EVENT_CLICK_DATA_API$6, SELECTOR_DATA_TOGGLE$5, (event => {
                event.preventDefault();
                const button = event.target.closest(SELECTOR_DATA_TOGGLE$5);
                const data = Button.getOrCreateInstance(button);
                data.toggle();
            }));
            defineJQueryPlugin(Button);
            const SelectorEngine = {
                find(selector, element = document.documentElement) {
                    return [].concat(...Element.prototype.querySelectorAll.call(element, selector));
                },
                findOne(selector, element = document.documentElement) {
                    return Element.prototype.querySelector.call(element, selector);
                },
                children(element, selector) {
                    return [].concat(...element.children).filter((child => child.matches(selector)));
                },
                parents(element, selector) {
                    const parents = [];
                    let ancestor = element.parentNode.closest(selector);
                    while (ancestor) {
                        parents.push(ancestor);
                        ancestor = ancestor.parentNode.closest(selector);
                    }
                    return parents;
                },
                prev(element, selector) {
                    let previous = element.previousElementSibling;
                    while (previous) {
                        if (previous.matches(selector)) {
                            return [ previous ];
                        }
                        previous = previous.previousElementSibling;
                    }
                    return [];
                },
                next(element, selector) {
                    let next = element.nextElementSibling;
                    while (next) {
                        if (next.matches(selector)) {
                            return [ next ];
                        }
                        next = next.nextElementSibling;
                    }
                    return [];
                },
                focusableChildren(element) {
                    const focusables = [ "a", "button", "input", "textarea", "select", "details", "[tabindex]", '[contenteditable="true"]' ].map((selector => `${selector}:not([tabindex^="-"])`)).join(",");
                    return this.find(focusables, element).filter((el => !isDisabled(el) && isVisible(el)));
                }
            };
            const NAME$d = "swipe";
            const EVENT_KEY$9 = ".bs.swipe";
            const EVENT_TOUCHSTART = `touchstart${EVENT_KEY$9}`;
            const EVENT_TOUCHMOVE = `touchmove${EVENT_KEY$9}`;
            const EVENT_TOUCHEND = `touchend${EVENT_KEY$9}`;
            const EVENT_POINTERDOWN = `pointerdown${EVENT_KEY$9}`;
            const EVENT_POINTERUP = `pointerup${EVENT_KEY$9}`;
            const POINTER_TYPE_TOUCH = "touch";
            const POINTER_TYPE_PEN = "pen";
            const CLASS_NAME_POINTER_EVENT = "pointer-event";
            const SWIPE_THRESHOLD = 40;
            const Default$c = {
                endCallback: null,
                leftCallback: null,
                rightCallback: null
            };
            const DefaultType$c = {
                endCallback: "(function|null)",
                leftCallback: "(function|null)",
                rightCallback: "(function|null)"
            };
            class Swipe extends Config {
                constructor(element, config) {
                    super();
                    this._element = element;
                    if (!element || !Swipe.isSupported()) {
                        return;
                    }
                    this._config = this._getConfig(config);
                    this._deltaX = 0;
                    this._supportPointerEvents = Boolean(window.PointerEvent);
                    this._initEvents();
                }
                static get Default() {
                    return Default$c;
                }
                static get DefaultType() {
                    return DefaultType$c;
                }
                static get NAME() {
                    return NAME$d;
                }
                dispose() {
                    EventHandler.off(this._element, EVENT_KEY$9);
                }
                _start(event) {
                    if (!this._supportPointerEvents) {
                        this._deltaX = event.touches[0].clientX;
                        return;
                    }
                    if (this._eventIsPointerPenTouch(event)) {
                        this._deltaX = event.clientX;
                    }
                }
                _end(event) {
                    if (this._eventIsPointerPenTouch(event)) {
                        this._deltaX = event.clientX - this._deltaX;
                    }
                    this._handleSwipe();
                    execute(this._config.endCallback);
                }
                _move(event) {
                    this._deltaX = event.touches && event.touches.length > 1 ? 0 : event.touches[0].clientX - this._deltaX;
                }
                _handleSwipe() {
                    const absDeltaX = Math.abs(this._deltaX);
                    if (absDeltaX <= SWIPE_THRESHOLD) {
                        return;
                    }
                    const direction = absDeltaX / this._deltaX;
                    this._deltaX = 0;
                    if (!direction) {
                        return;
                    }
                    execute(direction > 0 ? this._config.rightCallback : this._config.leftCallback);
                }
                _initEvents() {
                    if (this._supportPointerEvents) {
                        EventHandler.on(this._element, EVENT_POINTERDOWN, (event => this._start(event)));
                        EventHandler.on(this._element, EVENT_POINTERUP, (event => this._end(event)));
                        this._element.classList.add(CLASS_NAME_POINTER_EVENT);
                    } else {
                        EventHandler.on(this._element, EVENT_TOUCHSTART, (event => this._start(event)));
                        EventHandler.on(this._element, EVENT_TOUCHMOVE, (event => this._move(event)));
                        EventHandler.on(this._element, EVENT_TOUCHEND, (event => this._end(event)));
                    }
                }
                _eventIsPointerPenTouch(event) {
                    return this._supportPointerEvents && (event.pointerType === POINTER_TYPE_PEN || event.pointerType === POINTER_TYPE_TOUCH);
                }
                static isSupported() {
                    return "ontouchstart" in document.documentElement || navigator.maxTouchPoints > 0;
                }
            }
            const NAME$c = "carousel";
            const DATA_KEY$8 = "bs.carousel";
            const EVENT_KEY$8 = `.${DATA_KEY$8}`;
            const DATA_API_KEY$5 = ".data-api";
            const ARROW_LEFT_KEY$1 = "ArrowLeft";
            const ARROW_RIGHT_KEY$1 = "ArrowRight";
            const TOUCHEVENT_COMPAT_WAIT = 500;
            const ORDER_NEXT = "next";
            const ORDER_PREV = "prev";
            const DIRECTION_LEFT = "left";
            const DIRECTION_RIGHT = "right";
            const EVENT_SLIDE = `slide${EVENT_KEY$8}`;
            const EVENT_SLID = `slid${EVENT_KEY$8}`;
            const EVENT_KEYDOWN$1 = `keydown${EVENT_KEY$8}`;
            const EVENT_MOUSEENTER$1 = `mouseenter${EVENT_KEY$8}`;
            const EVENT_MOUSELEAVE$1 = `mouseleave${EVENT_KEY$8}`;
            const EVENT_DRAG_START = `dragstart${EVENT_KEY$8}`;
            const EVENT_LOAD_DATA_API$3 = `load${EVENT_KEY$8}${DATA_API_KEY$5}`;
            const EVENT_CLICK_DATA_API$5 = `click${EVENT_KEY$8}${DATA_API_KEY$5}`;
            const CLASS_NAME_CAROUSEL = "carousel";
            const CLASS_NAME_ACTIVE$2 = "active";
            const CLASS_NAME_SLIDE = "slide";
            const CLASS_NAME_END = "carousel-item-end";
            const CLASS_NAME_START = "carousel-item-start";
            const CLASS_NAME_NEXT = "carousel-item-next";
            const CLASS_NAME_PREV = "carousel-item-prev";
            const SELECTOR_ACTIVE = ".active";
            const SELECTOR_ITEM = ".carousel-item";
            const SELECTOR_ACTIVE_ITEM = SELECTOR_ACTIVE + SELECTOR_ITEM;
            const SELECTOR_ITEM_IMG = ".carousel-item img";
            const SELECTOR_INDICATORS = ".carousel-indicators";
            const SELECTOR_DATA_SLIDE = "[data-bs-slide], [data-bs-slide-to]";
            const SELECTOR_DATA_RIDE = '[data-bs-ride="carousel"]';
            const KEY_TO_DIRECTION = {
                [ARROW_LEFT_KEY$1]: DIRECTION_RIGHT,
                [ARROW_RIGHT_KEY$1]: DIRECTION_LEFT
            };
            const Default$b = {
                interval: 5e3,
                keyboard: true,
                pause: "hover",
                ride: false,
                touch: true,
                wrap: true
            };
            const DefaultType$b = {
                interval: "(number|boolean)",
                keyboard: "boolean",
                pause: "(string|boolean)",
                ride: "(boolean|string)",
                touch: "boolean",
                wrap: "boolean"
            };
            class Carousel extends BaseComponent {
                constructor(element, config) {
                    super(element, config);
                    this._interval = null;
                    this._activeElement = null;
                    this._isSliding = false;
                    this.touchTimeout = null;
                    this._swipeHelper = null;
                    this._indicatorsElement = SelectorEngine.findOne(SELECTOR_INDICATORS, this._element);
                    this._addEventListeners();
                    if (this._config.ride === CLASS_NAME_CAROUSEL) {
                        this.cycle();
                    }
                }
                static get Default() {
                    return Default$b;
                }
                static get DefaultType() {
                    return DefaultType$b;
                }
                static get NAME() {
                    return NAME$c;
                }
                next() {
                    this._slide(ORDER_NEXT);
                }
                nextWhenVisible() {
                    if (!document.hidden && isVisible(this._element)) {
                        this.next();
                    }
                }
                prev() {
                    this._slide(ORDER_PREV);
                }
                pause() {
                    if (this._isSliding) {
                        triggerTransitionEnd(this._element);
                    }
                    this._clearInterval();
                }
                cycle() {
                    this._clearInterval();
                    this._updateInterval();
                    this._interval = setInterval((() => this.nextWhenVisible()), this._config.interval);
                }
                _maybeEnableCycle() {
                    if (!this._config.ride) {
                        return;
                    }
                    if (this._isSliding) {
                        EventHandler.one(this._element, EVENT_SLID, (() => this.cycle()));
                        return;
                    }
                    this.cycle();
                }
                to(index) {
                    const items = this._getItems();
                    if (index > items.length - 1 || index < 0) {
                        return;
                    }
                    if (this._isSliding) {
                        EventHandler.one(this._element, EVENT_SLID, (() => this.to(index)));
                        return;
                    }
                    const activeIndex = this._getItemIndex(this._getActive());
                    if (activeIndex === index) {
                        return;
                    }
                    const order = index > activeIndex ? ORDER_NEXT : ORDER_PREV;
                    this._slide(order, items[index]);
                }
                dispose() {
                    if (this._swipeHelper) {
                        this._swipeHelper.dispose();
                    }
                    super.dispose();
                }
                _configAfterMerge(config) {
                    config.defaultInterval = config.interval;
                    return config;
                }
                _addEventListeners() {
                    if (this._config.keyboard) {
                        EventHandler.on(this._element, EVENT_KEYDOWN$1, (event => this._keydown(event)));
                    }
                    if (this._config.pause === "hover") {
                        EventHandler.on(this._element, EVENT_MOUSEENTER$1, (() => this.pause()));
                        EventHandler.on(this._element, EVENT_MOUSELEAVE$1, (() => this._maybeEnableCycle()));
                    }
                    if (this._config.touch && Swipe.isSupported()) {
                        this._addTouchEventListeners();
                    }
                }
                _addTouchEventListeners() {
                    for (const img of SelectorEngine.find(SELECTOR_ITEM_IMG, this._element)) {
                        EventHandler.on(img, EVENT_DRAG_START, (event => event.preventDefault()));
                    }
                    const endCallBack = () => {
                        if (this._config.pause !== "hover") {
                            return;
                        }
                        this.pause();
                        if (this.touchTimeout) {
                            clearTimeout(this.touchTimeout);
                        }
                        this.touchTimeout = setTimeout((() => this._maybeEnableCycle()), TOUCHEVENT_COMPAT_WAIT + this._config.interval);
                    };
                    const swipeConfig = {
                        leftCallback: () => this._slide(this._directionToOrder(DIRECTION_LEFT)),
                        rightCallback: () => this._slide(this._directionToOrder(DIRECTION_RIGHT)),
                        endCallback: endCallBack
                    };
                    this._swipeHelper = new Swipe(this._element, swipeConfig);
                }
                _keydown(event) {
                    if (/input|textarea/i.test(event.target.tagName)) {
                        return;
                    }
                    const direction = KEY_TO_DIRECTION[event.key];
                    if (direction) {
                        event.preventDefault();
                        this._slide(this._directionToOrder(direction));
                    }
                }
                _getItemIndex(element) {
                    return this._getItems().indexOf(element);
                }
                _setActiveIndicatorElement(index) {
                    if (!this._indicatorsElement) {
                        return;
                    }
                    const activeIndicator = SelectorEngine.findOne(SELECTOR_ACTIVE, this._indicatorsElement);
                    activeIndicator.classList.remove(CLASS_NAME_ACTIVE$2);
                    activeIndicator.removeAttribute("aria-current");
                    const newActiveIndicator = SelectorEngine.findOne(`[data-bs-slide-to="${index}"]`, this._indicatorsElement);
                    if (newActiveIndicator) {
                        newActiveIndicator.classList.add(CLASS_NAME_ACTIVE$2);
                        newActiveIndicator.setAttribute("aria-current", "true");
                    }
                }
                _updateInterval() {
                    const element = this._activeElement || this._getActive();
                    if (!element) {
                        return;
                    }
                    const elementInterval = Number.parseInt(element.getAttribute("data-bs-interval"), 10);
                    this._config.interval = elementInterval || this._config.defaultInterval;
                }
                _slide(order, element = null) {
                    if (this._isSliding) {
                        return;
                    }
                    const activeElement = this._getActive();
                    const isNext = order === ORDER_NEXT;
                    const nextElement = element || getNextActiveElement(this._getItems(), activeElement, isNext, this._config.wrap);
                    if (nextElement === activeElement) {
                        return;
                    }
                    const nextElementIndex = this._getItemIndex(nextElement);
                    const triggerEvent = eventName => EventHandler.trigger(this._element, eventName, {
                        relatedTarget: nextElement,
                        direction: this._orderToDirection(order),
                        from: this._getItemIndex(activeElement),
                        to: nextElementIndex
                    });
                    const slideEvent = triggerEvent(EVENT_SLIDE);
                    if (slideEvent.defaultPrevented) {
                        return;
                    }
                    if (!activeElement || !nextElement) {
                        return;
                    }
                    const isCycling = Boolean(this._interval);
                    this.pause();
                    this._isSliding = true;
                    this._setActiveIndicatorElement(nextElementIndex);
                    this._activeElement = nextElement;
                    const directionalClassName = isNext ? CLASS_NAME_START : CLASS_NAME_END;
                    const orderClassName = isNext ? CLASS_NAME_NEXT : CLASS_NAME_PREV;
                    nextElement.classList.add(orderClassName);
                    reflow(nextElement);
                    activeElement.classList.add(directionalClassName);
                    nextElement.classList.add(directionalClassName);
                    const completeCallBack = () => {
                        nextElement.classList.remove(directionalClassName, orderClassName);
                        nextElement.classList.add(CLASS_NAME_ACTIVE$2);
                        activeElement.classList.remove(CLASS_NAME_ACTIVE$2, orderClassName, directionalClassName);
                        this._isSliding = false;
                        triggerEvent(EVENT_SLID);
                    };
                    this._queueCallback(completeCallBack, activeElement, this._isAnimated());
                    if (isCycling) {
                        this.cycle();
                    }
                }
                _isAnimated() {
                    return this._element.classList.contains(CLASS_NAME_SLIDE);
                }
                _getActive() {
                    return SelectorEngine.findOne(SELECTOR_ACTIVE_ITEM, this._element);
                }
                _getItems() {
                    return SelectorEngine.find(SELECTOR_ITEM, this._element);
                }
                _clearInterval() {
                    if (this._interval) {
                        clearInterval(this._interval);
                        this._interval = null;
                    }
                }
                _directionToOrder(direction) {
                    if (isRTL()) {
                        return direction === DIRECTION_LEFT ? ORDER_PREV : ORDER_NEXT;
                    }
                    return direction === DIRECTION_LEFT ? ORDER_NEXT : ORDER_PREV;
                }
                _orderToDirection(order) {
                    if (isRTL()) {
                        return order === ORDER_PREV ? DIRECTION_LEFT : DIRECTION_RIGHT;
                    }
                    return order === ORDER_PREV ? DIRECTION_RIGHT : DIRECTION_LEFT;
                }
                static jQueryInterface(config) {
                    return this.each((function() {
                        const data = Carousel.getOrCreateInstance(this, config);
                        if (typeof config === "number") {
                            data.to(config);
                            return;
                        }
                        if (typeof config === "string") {
                            if (data[config] === undefined || config.startsWith("_") || config === "constructor") {
                                throw new TypeError(`No method named "${config}"`);
                            }
                            data[config]();
                        }
                    }));
                }
            }
            EventHandler.on(document, EVENT_CLICK_DATA_API$5, SELECTOR_DATA_SLIDE, (function(event) {
                const target = getElementFromSelector(this);
                if (!target || !target.classList.contains(CLASS_NAME_CAROUSEL)) {
                    return;
                }
                event.preventDefault();
                const carousel = Carousel.getOrCreateInstance(target);
                const slideIndex = this.getAttribute("data-bs-slide-to");
                if (slideIndex) {
                    carousel.to(slideIndex);
                    carousel._maybeEnableCycle();
                    return;
                }
                if (Manipulator.getDataAttribute(this, "slide") === "next") {
                    carousel.next();
                    carousel._maybeEnableCycle();
                    return;
                }
                carousel.prev();
                carousel._maybeEnableCycle();
            }));
            EventHandler.on(window, EVENT_LOAD_DATA_API$3, (() => {
                const carousels = SelectorEngine.find(SELECTOR_DATA_RIDE);
                for (const carousel of carousels) {
                    Carousel.getOrCreateInstance(carousel);
                }
            }));
            defineJQueryPlugin(Carousel);
            const NAME$b = "collapse";
            const DATA_KEY$7 = "bs.collapse";
            const EVENT_KEY$7 = `.${DATA_KEY$7}`;
            const DATA_API_KEY$4 = ".data-api";
            const EVENT_SHOW$6 = `show${EVENT_KEY$7}`;
            const EVENT_SHOWN$6 = `shown${EVENT_KEY$7}`;
            const EVENT_HIDE$6 = `hide${EVENT_KEY$7}`;
            const EVENT_HIDDEN$6 = `hidden${EVENT_KEY$7}`;
            const EVENT_CLICK_DATA_API$4 = `click${EVENT_KEY$7}${DATA_API_KEY$4}`;
            const CLASS_NAME_SHOW$7 = "show";
            const CLASS_NAME_COLLAPSE = "collapse";
            const CLASS_NAME_COLLAPSING = "collapsing";
            const CLASS_NAME_COLLAPSED = "collapsed";
            const CLASS_NAME_DEEPER_CHILDREN = `:scope .${CLASS_NAME_COLLAPSE} .${CLASS_NAME_COLLAPSE}`;
            const CLASS_NAME_HORIZONTAL = "collapse-horizontal";
            const WIDTH = "width";
            const HEIGHT = "height";
            const SELECTOR_ACTIVES = ".collapse.show, .collapse.collapsing";
            const SELECTOR_DATA_TOGGLE$4 = '[data-bs-toggle="collapse"]';
            const Default$a = {
                parent: null,
                toggle: true
            };
            const DefaultType$a = {
                parent: "(null|element)",
                toggle: "boolean"
            };
            class Collapse extends BaseComponent {
                constructor(element, config) {
                    super(element, config);
                    this._isTransitioning = false;
                    this._triggerArray = [];
                    const toggleList = SelectorEngine.find(SELECTOR_DATA_TOGGLE$4);
                    for (const elem of toggleList) {
                        const selector = getSelectorFromElement(elem);
                        const filterElement = SelectorEngine.find(selector).filter((foundElement => foundElement === this._element));
                        if (selector !== null && filterElement.length) {
                            this._triggerArray.push(elem);
                        }
                    }
                    this._initializeChildren();
                    if (!this._config.parent) {
                        this._addAriaAndCollapsedClass(this._triggerArray, this._isShown());
                    }
                    if (this._config.toggle) {
                        this.toggle();
                    }
                }
                static get Default() {
                    return Default$a;
                }
                static get DefaultType() {
                    return DefaultType$a;
                }
                static get NAME() {
                    return NAME$b;
                }
                toggle() {
                    if (this._isShown()) {
                        this.hide();
                    } else {
                        this.show();
                    }
                }
                show() {
                    if (this._isTransitioning || this._isShown()) {
                        return;
                    }
                    let activeChildren = [];
                    if (this._config.parent) {
                        activeChildren = this._getFirstLevelChildren(SELECTOR_ACTIVES).filter((element => element !== this._element)).map((element => Collapse.getOrCreateInstance(element, {
                            toggle: false
                        })));
                    }
                    if (activeChildren.length && activeChildren[0]._isTransitioning) {
                        return;
                    }
                    const startEvent = EventHandler.trigger(this._element, EVENT_SHOW$6);
                    if (startEvent.defaultPrevented) {
                        return;
                    }
                    for (const activeInstance of activeChildren) {
                        activeInstance.hide();
                    }
                    const dimension = this._getDimension();
                    this._element.classList.remove(CLASS_NAME_COLLAPSE);
                    this._element.classList.add(CLASS_NAME_COLLAPSING);
                    this._element.style[dimension] = 0;
                    this._addAriaAndCollapsedClass(this._triggerArray, true);
                    this._isTransitioning = true;
                    const complete = () => {
                        this._isTransitioning = false;
                        this._element.classList.remove(CLASS_NAME_COLLAPSING);
                        this._element.classList.add(CLASS_NAME_COLLAPSE, CLASS_NAME_SHOW$7);
                        this._element.style[dimension] = "";
                        EventHandler.trigger(this._element, EVENT_SHOWN$6);
                    };
                    const capitalizedDimension = dimension[0].toUpperCase() + dimension.slice(1);
                    const scrollSize = `scroll${capitalizedDimension}`;
                    this._queueCallback(complete, this._element, true);
                    this._element.style[dimension] = `${this._element[scrollSize]}px`;
                }
                hide() {
                    if (this._isTransitioning || !this._isShown()) {
                        return;
                    }
                    const startEvent = EventHandler.trigger(this._element, EVENT_HIDE$6);
                    if (startEvent.defaultPrevented) {
                        return;
                    }
                    const dimension = this._getDimension();
                    this._element.style[dimension] = `${this._element.getBoundingClientRect()[dimension]}px`;
                    reflow(this._element);
                    this._element.classList.add(CLASS_NAME_COLLAPSING);
                    this._element.classList.remove(CLASS_NAME_COLLAPSE, CLASS_NAME_SHOW$7);
                    for (const trigger of this._triggerArray) {
                        const element = getElementFromSelector(trigger);
                        if (element && !this._isShown(element)) {
                            this._addAriaAndCollapsedClass([ trigger ], false);
                        }
                    }
                    this._isTransitioning = true;
                    const complete = () => {
                        this._isTransitioning = false;
                        this._element.classList.remove(CLASS_NAME_COLLAPSING);
                        this._element.classList.add(CLASS_NAME_COLLAPSE);
                        EventHandler.trigger(this._element, EVENT_HIDDEN$6);
                    };
                    this._element.style[dimension] = "";
                    this._queueCallback(complete, this._element, true);
                }
                _isShown(element = this._element) {
                    return element.classList.contains(CLASS_NAME_SHOW$7);
                }
                _configAfterMerge(config) {
                    config.toggle = Boolean(config.toggle);
                    config.parent = getElement(config.parent);
                    return config;
                }
                _getDimension() {
                    return this._element.classList.contains(CLASS_NAME_HORIZONTAL) ? WIDTH : HEIGHT;
                }
                _initializeChildren() {
                    if (!this._config.parent) {
                        return;
                    }
                    const children = this._getFirstLevelChildren(SELECTOR_DATA_TOGGLE$4);
                    for (const element of children) {
                        const selected = getElementFromSelector(element);
                        if (selected) {
                            this._addAriaAndCollapsedClass([ element ], this._isShown(selected));
                        }
                    }
                }
                _getFirstLevelChildren(selector) {
                    const children = SelectorEngine.find(CLASS_NAME_DEEPER_CHILDREN, this._config.parent);
                    return SelectorEngine.find(selector, this._config.parent).filter((element => !children.includes(element)));
                }
                _addAriaAndCollapsedClass(triggerArray, isOpen) {
                    if (!triggerArray.length) {
                        return;
                    }
                    for (const element of triggerArray) {
                        element.classList.toggle(CLASS_NAME_COLLAPSED, !isOpen);
                        element.setAttribute("aria-expanded", isOpen);
                    }
                }
                static jQueryInterface(config) {
                    const _config = {};
                    if (typeof config === "string" && /show|hide/.test(config)) {
                        _config.toggle = false;
                    }
                    return this.each((function() {
                        const data = Collapse.getOrCreateInstance(this, _config);
                        if (typeof config === "string") {
                            if (typeof data[config] === "undefined") {
                                throw new TypeError(`No method named "${config}"`);
                            }
                            data[config]();
                        }
                    }));
                }
            }
            EventHandler.on(document, EVENT_CLICK_DATA_API$4, SELECTOR_DATA_TOGGLE$4, (function(event) {
                if (event.target.tagName === "A" || event.delegateTarget && event.delegateTarget.tagName === "A") {
                    event.preventDefault();
                }
                const selector = getSelectorFromElement(this);
                const selectorElements = SelectorEngine.find(selector);
                for (const element of selectorElements) {
                    Collapse.getOrCreateInstance(element, {
                        toggle: false
                    }).toggle();
                }
            }));
            defineJQueryPlugin(Collapse);
            const NAME$a = "dropdown";
            const DATA_KEY$6 = "bs.dropdown";
            const EVENT_KEY$6 = `.${DATA_KEY$6}`;
            const DATA_API_KEY$3 = ".data-api";
            const ESCAPE_KEY$2 = "Escape";
            const TAB_KEY$1 = "Tab";
            const ARROW_UP_KEY$1 = "ArrowUp";
            const ARROW_DOWN_KEY$1 = "ArrowDown";
            const RIGHT_MOUSE_BUTTON = 2;
            const EVENT_HIDE$5 = `hide${EVENT_KEY$6}`;
            const EVENT_HIDDEN$5 = `hidden${EVENT_KEY$6}`;
            const EVENT_SHOW$5 = `show${EVENT_KEY$6}`;
            const EVENT_SHOWN$5 = `shown${EVENT_KEY$6}`;
            const EVENT_CLICK_DATA_API$3 = `click${EVENT_KEY$6}${DATA_API_KEY$3}`;
            const EVENT_KEYDOWN_DATA_API = `keydown${EVENT_KEY$6}${DATA_API_KEY$3}`;
            const EVENT_KEYUP_DATA_API = `keyup${EVENT_KEY$6}${DATA_API_KEY$3}`;
            const CLASS_NAME_SHOW$6 = "show";
            const CLASS_NAME_DROPUP = "dropup";
            const CLASS_NAME_DROPEND = "dropend";
            const CLASS_NAME_DROPSTART = "dropstart";
            const CLASS_NAME_DROPUP_CENTER = "dropup-center";
            const CLASS_NAME_DROPDOWN_CENTER = "dropdown-center";
            const SELECTOR_DATA_TOGGLE$3 = '[data-bs-toggle="dropdown"]:not(.disabled):not(:disabled)';
            const SELECTOR_DATA_TOGGLE_SHOWN = `${SELECTOR_DATA_TOGGLE$3}.${CLASS_NAME_SHOW$6}`;
            const SELECTOR_MENU = ".dropdown-menu";
            const SELECTOR_NAVBAR = ".navbar";
            const SELECTOR_NAVBAR_NAV = ".navbar-nav";
            const SELECTOR_VISIBLE_ITEMS = ".dropdown-menu .dropdown-item:not(.disabled):not(:disabled)";
            const PLACEMENT_TOP = isRTL() ? "top-end" : "top-start";
            const PLACEMENT_TOPEND = isRTL() ? "top-start" : "top-end";
            const PLACEMENT_BOTTOM = isRTL() ? "bottom-end" : "bottom-start";
            const PLACEMENT_BOTTOMEND = isRTL() ? "bottom-start" : "bottom-end";
            const PLACEMENT_RIGHT = isRTL() ? "left-start" : "right-start";
            const PLACEMENT_LEFT = isRTL() ? "right-start" : "left-start";
            const PLACEMENT_TOPCENTER = "top";
            const PLACEMENT_BOTTOMCENTER = "bottom";
            const Default$9 = {
                autoClose: true,
                boundary: "clippingParents",
                display: "dynamic",
                offset: [ 0, 2 ],
                popperConfig: null,
                reference: "toggle"
            };
            const DefaultType$9 = {
                autoClose: "(boolean|string)",
                boundary: "(string|element)",
                display: "string",
                offset: "(array|string|function)",
                popperConfig: "(null|object|function)",
                reference: "(string|element|object)"
            };
            class Dropdown extends BaseComponent {
                constructor(element, config) {
                    super(element, config);
                    this._popper = null;
                    this._parent = this._element.parentNode;
                    this._menu = SelectorEngine.findOne(SELECTOR_MENU, this._parent);
                    this._inNavbar = this._detectNavbar();
                }
                static get Default() {
                    return Default$9;
                }
                static get DefaultType() {
                    return DefaultType$9;
                }
                static get NAME() {
                    return NAME$a;
                }
                toggle() {
                    return this._isShown() ? this.hide() : this.show();
                }
                show() {
                    if (isDisabled(this._element) || this._isShown()) {
                        return;
                    }
                    const relatedTarget = {
                        relatedTarget: this._element
                    };
                    const showEvent = EventHandler.trigger(this._element, EVENT_SHOW$5, relatedTarget);
                    if (showEvent.defaultPrevented) {
                        return;
                    }
                    this._createPopper();
                    if ("ontouchstart" in document.documentElement && !this._parent.closest(SELECTOR_NAVBAR_NAV)) {
                        for (const element of [].concat(...document.body.children)) {
                            EventHandler.on(element, "mouseover", noop);
                        }
                    }
                    this._element.focus();
                    this._element.setAttribute("aria-expanded", true);
                    this._menu.classList.add(CLASS_NAME_SHOW$6);
                    this._element.classList.add(CLASS_NAME_SHOW$6);
                    EventHandler.trigger(this._element, EVENT_SHOWN$5, relatedTarget);
                }
                hide() {
                    if (isDisabled(this._element) || !this._isShown()) {
                        return;
                    }
                    const relatedTarget = {
                        relatedTarget: this._element
                    };
                    this._completeHide(relatedTarget);
                }
                dispose() {
                    if (this._popper) {
                        this._popper.destroy();
                    }
                    super.dispose();
                }
                update() {
                    this._inNavbar = this._detectNavbar();
                    if (this._popper) {
                        this._popper.update();
                    }
                }
                _completeHide(relatedTarget) {
                    const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE$5, relatedTarget);
                    if (hideEvent.defaultPrevented) {
                        return;
                    }
                    if ("ontouchstart" in document.documentElement) {
                        for (const element of [].concat(...document.body.children)) {
                            EventHandler.off(element, "mouseover", noop);
                        }
                    }
                    if (this._popper) {
                        this._popper.destroy();
                    }
                    this._menu.classList.remove(CLASS_NAME_SHOW$6);
                    this._element.classList.remove(CLASS_NAME_SHOW$6);
                    this._element.setAttribute("aria-expanded", "false");
                    Manipulator.removeDataAttribute(this._menu, "popper");
                    EventHandler.trigger(this._element, EVENT_HIDDEN$5, relatedTarget);
                }
                _getConfig(config) {
                    config = super._getConfig(config);
                    if (typeof config.reference === "object" && !isElement(config.reference) && typeof config.reference.getBoundingClientRect !== "function") {
                        throw new TypeError(`${NAME$a.toUpperCase()}: Option "reference" provided type "object" without a required "getBoundingClientRect" method.`);
                    }
                    return config;
                }
                _createPopper() {
                    if (typeof _popperjs_core__WEBPACK_IMPORTED_MODULE_0__ === "undefined") {
                        throw new TypeError("Bootstrap's dropdowns require Popper (https://popper.js.org)");
                    }
                    let referenceElement = this._element;
                    if (this._config.reference === "parent") {
                        referenceElement = this._parent;
                    } else if (isElement(this._config.reference)) {
                        referenceElement = getElement(this._config.reference);
                    } else if (typeof this._config.reference === "object") {
                        referenceElement = this._config.reference;
                    }
                    const popperConfig = this._getPopperConfig();
                    this._popper = _popperjs_core__WEBPACK_IMPORTED_MODULE_1__.createPopper(referenceElement, this._menu, popperConfig);
                }
                _isShown() {
                    return this._menu.classList.contains(CLASS_NAME_SHOW$6);
                }
                _getPlacement() {
                    const parentDropdown = this._parent;
                    if (parentDropdown.classList.contains(CLASS_NAME_DROPEND)) {
                        return PLACEMENT_RIGHT;
                    }
                    if (parentDropdown.classList.contains(CLASS_NAME_DROPSTART)) {
                        return PLACEMENT_LEFT;
                    }
                    if (parentDropdown.classList.contains(CLASS_NAME_DROPUP_CENTER)) {
                        return PLACEMENT_TOPCENTER;
                    }
                    if (parentDropdown.classList.contains(CLASS_NAME_DROPDOWN_CENTER)) {
                        return PLACEMENT_BOTTOMCENTER;
                    }
                    const isEnd = getComputedStyle(this._menu).getPropertyValue("--bs-position").trim() === "end";
                    if (parentDropdown.classList.contains(CLASS_NAME_DROPUP)) {
                        return isEnd ? PLACEMENT_TOPEND : PLACEMENT_TOP;
                    }
                    return isEnd ? PLACEMENT_BOTTOMEND : PLACEMENT_BOTTOM;
                }
                _detectNavbar() {
                    return this._element.closest(SELECTOR_NAVBAR) !== null;
                }
                _getOffset() {
                    const {offset} = this._config;
                    if (typeof offset === "string") {
                        return offset.split(",").map((value => Number.parseInt(value, 10)));
                    }
                    if (typeof offset === "function") {
                        return popperData => offset(popperData, this._element);
                    }
                    return offset;
                }
                _getPopperConfig() {
                    const defaultBsPopperConfig = {
                        placement: this._getPlacement(),
                        modifiers: [ {
                            name: "preventOverflow",
                            options: {
                                boundary: this._config.boundary
                            }
                        }, {
                            name: "offset",
                            options: {
                                offset: this._getOffset()
                            }
                        } ]
                    };
                    if (this._inNavbar || this._config.display === "static") {
                        Manipulator.setDataAttribute(this._menu, "popper", "static");
                        defaultBsPopperConfig.modifiers = [ {
                            name: "applyStyles",
                            enabled: false
                        } ];
                    }
                    return {
                        ...defaultBsPopperConfig,
                        ...typeof this._config.popperConfig === "function" ? this._config.popperConfig(defaultBsPopperConfig) : this._config.popperConfig
                    };
                }
                _selectMenuItem({key, target}) {
                    const items = SelectorEngine.find(SELECTOR_VISIBLE_ITEMS, this._menu).filter((element => isVisible(element)));
                    if (!items.length) {
                        return;
                    }
                    getNextActiveElement(items, target, key === ARROW_DOWN_KEY$1, !items.includes(target)).focus();
                }
                static jQueryInterface(config) {
                    return this.each((function() {
                        const data = Dropdown.getOrCreateInstance(this, config);
                        if (typeof config !== "string") {
                            return;
                        }
                        if (typeof data[config] === "undefined") {
                            throw new TypeError(`No method named "${config}"`);
                        }
                        data[config]();
                    }));
                }
                static clearMenus(event) {
                    if (event.button === RIGHT_MOUSE_BUTTON || event.type === "keyup" && event.key !== TAB_KEY$1) {
                        return;
                    }
                    const openToggles = SelectorEngine.find(SELECTOR_DATA_TOGGLE_SHOWN);
                    for (const toggle of openToggles) {
                        const context = Dropdown.getInstance(toggle);
                        if (!context || context._config.autoClose === false) {
                            continue;
                        }
                        const composedPath = event.composedPath();
                        const isMenuTarget = composedPath.includes(context._menu);
                        if (composedPath.includes(context._element) || context._config.autoClose === "inside" && !isMenuTarget || context._config.autoClose === "outside" && isMenuTarget) {
                            continue;
                        }
                        if (context._menu.contains(event.target) && (event.type === "keyup" && event.key === TAB_KEY$1 || /input|select|option|textarea|form/i.test(event.target.tagName))) {
                            continue;
                        }
                        const relatedTarget = {
                            relatedTarget: context._element
                        };
                        if (event.type === "click") {
                            relatedTarget.clickEvent = event;
                        }
                        context._completeHide(relatedTarget);
                    }
                }
                static dataApiKeydownHandler(event) {
                    const isInput = /input|textarea/i.test(event.target.tagName);
                    const isEscapeEvent = event.key === ESCAPE_KEY$2;
                    const isUpOrDownEvent = [ ARROW_UP_KEY$1, ARROW_DOWN_KEY$1 ].includes(event.key);
                    if (!isUpOrDownEvent && !isEscapeEvent) {
                        return;
                    }
                    if (isInput && !isEscapeEvent) {
                        return;
                    }
                    event.preventDefault();
                    const getToggleButton = SelectorEngine.findOne(SELECTOR_DATA_TOGGLE$3, event.delegateTarget.parentNode);
                    const instance = Dropdown.getOrCreateInstance(getToggleButton);
                    if (isUpOrDownEvent) {
                        event.stopPropagation();
                        instance.show();
                        instance._selectMenuItem(event);
                        return;
                    }
                    if (instance._isShown()) {
                        event.stopPropagation();
                        instance.hide();
                        getToggleButton.focus();
                    }
                }
            }
            EventHandler.on(document, EVENT_KEYDOWN_DATA_API, SELECTOR_DATA_TOGGLE$3, Dropdown.dataApiKeydownHandler);
            EventHandler.on(document, EVENT_KEYDOWN_DATA_API, SELECTOR_MENU, Dropdown.dataApiKeydownHandler);
            EventHandler.on(document, EVENT_CLICK_DATA_API$3, Dropdown.clearMenus);
            EventHandler.on(document, EVENT_KEYUP_DATA_API, Dropdown.clearMenus);
            EventHandler.on(document, EVENT_CLICK_DATA_API$3, SELECTOR_DATA_TOGGLE$3, (function(event) {
                event.preventDefault();
                Dropdown.getOrCreateInstance(this).toggle();
            }));
            defineJQueryPlugin(Dropdown);
            const SELECTOR_FIXED_CONTENT = ".fixed-top, .fixed-bottom, .is-fixed, .sticky-top";
            const SELECTOR_STICKY_CONTENT = ".sticky-top";
            const PROPERTY_PADDING = "padding-right";
            const PROPERTY_MARGIN = "margin-right";
            class ScrollBarHelper {
                constructor() {
                    this._element = document.body;
                }
                getWidth() {
                    const documentWidth = document.documentElement.clientWidth;
                    return Math.abs(window.innerWidth - documentWidth);
                }
                hide() {
                    const width = this.getWidth();
                    this._disableOverFlow();
                    this._setElementAttributes(this._element, PROPERTY_PADDING, (calculatedValue => calculatedValue + width));
                    this._setElementAttributes(SELECTOR_FIXED_CONTENT, PROPERTY_PADDING, (calculatedValue => calculatedValue + width));
                    this._setElementAttributes(SELECTOR_STICKY_CONTENT, PROPERTY_MARGIN, (calculatedValue => calculatedValue - width));
                }
                reset() {
                    this._resetElementAttributes(this._element, "overflow");
                    this._resetElementAttributes(this._element, PROPERTY_PADDING);
                    this._resetElementAttributes(SELECTOR_FIXED_CONTENT, PROPERTY_PADDING);
                    this._resetElementAttributes(SELECTOR_STICKY_CONTENT, PROPERTY_MARGIN);
                }
                isOverflowing() {
                    return this.getWidth() > 0;
                }
                _disableOverFlow() {
                    this._saveInitialAttribute(this._element, "overflow");
                    this._element.style.overflow = "hidden";
                }
                _setElementAttributes(selector, styleProperty, callback) {
                    const scrollbarWidth = this.getWidth();
                    const manipulationCallBack = element => {
                        if (element !== this._element && window.innerWidth > element.clientWidth + scrollbarWidth) {
                            return;
                        }
                        this._saveInitialAttribute(element, styleProperty);
                        const calculatedValue = window.getComputedStyle(element).getPropertyValue(styleProperty);
                        element.style.setProperty(styleProperty, `${callback(Number.parseFloat(calculatedValue))}px`);
                    };
                    this._applyManipulationCallback(selector, manipulationCallBack);
                }
                _saveInitialAttribute(element, styleProperty) {
                    const actualValue = element.style.getPropertyValue(styleProperty);
                    if (actualValue) {
                        Manipulator.setDataAttribute(element, styleProperty, actualValue);
                    }
                }
                _resetElementAttributes(selector, styleProperty) {
                    const manipulationCallBack = element => {
                        const value = Manipulator.getDataAttribute(element, styleProperty);
                        if (value === null) {
                            element.style.removeProperty(styleProperty);
                            return;
                        }
                        Manipulator.removeDataAttribute(element, styleProperty);
                        element.style.setProperty(styleProperty, value);
                    };
                    this._applyManipulationCallback(selector, manipulationCallBack);
                }
                _applyManipulationCallback(selector, callBack) {
                    if (isElement(selector)) {
                        callBack(selector);
                        return;
                    }
                    for (const sel of SelectorEngine.find(selector, this._element)) {
                        callBack(sel);
                    }
                }
            }
            const NAME$9 = "backdrop";
            const CLASS_NAME_FADE$4 = "fade";
            const CLASS_NAME_SHOW$5 = "show";
            const EVENT_MOUSEDOWN = `mousedown.bs.${NAME$9}`;
            const Default$8 = {
                className: "modal-backdrop",
                clickCallback: null,
                isAnimated: false,
                isVisible: true,
                rootElement: "body"
            };
            const DefaultType$8 = {
                className: "string",
                clickCallback: "(function|null)",
                isAnimated: "boolean",
                isVisible: "boolean",
                rootElement: "(element|string)"
            };
            class Backdrop extends Config {
                constructor(config) {
                    super();
                    this._config = this._getConfig(config);
                    this._isAppended = false;
                    this._element = null;
                }
                static get Default() {
                    return Default$8;
                }
                static get DefaultType() {
                    return DefaultType$8;
                }
                static get NAME() {
                    return NAME$9;
                }
                show(callback) {
                    if (!this._config.isVisible) {
                        execute(callback);
                        return;
                    }
                    this._append();
                    const element = this._getElement();
                    if (this._config.isAnimated) {
                        reflow(element);
                    }
                    element.classList.add(CLASS_NAME_SHOW$5);
                    this._emulateAnimation((() => {
                        execute(callback);
                    }));
                }
                hide(callback) {
                    if (!this._config.isVisible) {
                        execute(callback);
                        return;
                    }
                    this._getElement().classList.remove(CLASS_NAME_SHOW$5);
                    this._emulateAnimation((() => {
                        this.dispose();
                        execute(callback);
                    }));
                }
                dispose() {
                    if (!this._isAppended) {
                        return;
                    }
                    EventHandler.off(this._element, EVENT_MOUSEDOWN);
                    this._element.remove();
                    this._isAppended = false;
                }
                _getElement() {
                    if (!this._element) {
                        const backdrop = document.createElement("div");
                        backdrop.className = this._config.className;
                        if (this._config.isAnimated) {
                            backdrop.classList.add(CLASS_NAME_FADE$4);
                        }
                        this._element = backdrop;
                    }
                    return this._element;
                }
                _configAfterMerge(config) {
                    config.rootElement = getElement(config.rootElement);
                    return config;
                }
                _append() {
                    if (this._isAppended) {
                        return;
                    }
                    const element = this._getElement();
                    this._config.rootElement.append(element);
                    EventHandler.on(element, EVENT_MOUSEDOWN, (() => {
                        execute(this._config.clickCallback);
                    }));
                    this._isAppended = true;
                }
                _emulateAnimation(callback) {
                    executeAfterTransition(callback, this._getElement(), this._config.isAnimated);
                }
            }
            const NAME$8 = "focustrap";
            const DATA_KEY$5 = "bs.focustrap";
            const EVENT_KEY$5 = `.${DATA_KEY$5}`;
            const EVENT_FOCUSIN$2 = `focusin${EVENT_KEY$5}`;
            const EVENT_KEYDOWN_TAB = `keydown.tab${EVENT_KEY$5}`;
            const TAB_KEY = "Tab";
            const TAB_NAV_FORWARD = "forward";
            const TAB_NAV_BACKWARD = "backward";
            const Default$7 = {
                autofocus: true,
                trapElement: null
            };
            const DefaultType$7 = {
                autofocus: "boolean",
                trapElement: "element"
            };
            class FocusTrap extends Config {
                constructor(config) {
                    super();
                    this._config = this._getConfig(config);
                    this._isActive = false;
                    this._lastTabNavDirection = null;
                }
                static get Default() {
                    return Default$7;
                }
                static get DefaultType() {
                    return DefaultType$7;
                }
                static get NAME() {
                    return NAME$8;
                }
                activate() {
                    if (this._isActive) {
                        return;
                    }
                    if (this._config.autofocus) {
                        this._config.trapElement.focus();
                    }
                    EventHandler.off(document, EVENT_KEY$5);
                    EventHandler.on(document, EVENT_FOCUSIN$2, (event => this._handleFocusin(event)));
                    EventHandler.on(document, EVENT_KEYDOWN_TAB, (event => this._handleKeydown(event)));
                    this._isActive = true;
                }
                deactivate() {
                    if (!this._isActive) {
                        return;
                    }
                    this._isActive = false;
                    EventHandler.off(document, EVENT_KEY$5);
                }
                _handleFocusin(event) {
                    const {trapElement} = this._config;
                    if (event.target === document || event.target === trapElement || trapElement.contains(event.target)) {
                        return;
                    }
                    const elements = SelectorEngine.focusableChildren(trapElement);
                    if (elements.length === 0) {
                        trapElement.focus();
                    } else if (this._lastTabNavDirection === TAB_NAV_BACKWARD) {
                        elements[elements.length - 1].focus();
                    } else {
                        elements[0].focus();
                    }
                }
                _handleKeydown(event) {
                    if (event.key !== TAB_KEY) {
                        return;
                    }
                    this._lastTabNavDirection = event.shiftKey ? TAB_NAV_BACKWARD : TAB_NAV_FORWARD;
                }
            }
            const NAME$7 = "modal";
            const DATA_KEY$4 = "bs.modal";
            const EVENT_KEY$4 = `.${DATA_KEY$4}`;
            const DATA_API_KEY$2 = ".data-api";
            const ESCAPE_KEY$1 = "Escape";
            const EVENT_HIDE$4 = `hide${EVENT_KEY$4}`;
            const EVENT_HIDE_PREVENTED$1 = `hidePrevented${EVENT_KEY$4}`;
            const EVENT_HIDDEN$4 = `hidden${EVENT_KEY$4}`;
            const EVENT_SHOW$4 = `show${EVENT_KEY$4}`;
            const EVENT_SHOWN$4 = `shown${EVENT_KEY$4}`;
            const EVENT_RESIZE$1 = `resize${EVENT_KEY$4}`;
            const EVENT_MOUSEDOWN_DISMISS = `mousedown.dismiss${EVENT_KEY$4}`;
            const EVENT_KEYDOWN_DISMISS$1 = `keydown.dismiss${EVENT_KEY$4}`;
            const EVENT_CLICK_DATA_API$2 = `click${EVENT_KEY$4}${DATA_API_KEY$2}`;
            const CLASS_NAME_OPEN = "modal-open";
            const CLASS_NAME_FADE$3 = "fade";
            const CLASS_NAME_SHOW$4 = "show";
            const CLASS_NAME_STATIC = "modal-static";
            const OPEN_SELECTOR$1 = ".modal.show";
            const SELECTOR_DIALOG = ".modal-dialog";
            const SELECTOR_MODAL_BODY = ".modal-body";
            const SELECTOR_DATA_TOGGLE$2 = '[data-bs-toggle="modal"]';
            const Default$6 = {
                backdrop: true,
                focus: true,
                keyboard: true
            };
            const DefaultType$6 = {
                backdrop: "(boolean|string)",
                focus: "boolean",
                keyboard: "boolean"
            };
            class Modal extends BaseComponent {
                constructor(element, config) {
                    super(element, config);
                    this._dialog = SelectorEngine.findOne(SELECTOR_DIALOG, this._element);
                    this._backdrop = this._initializeBackDrop();
                    this._focustrap = this._initializeFocusTrap();
                    this._isShown = false;
                    this._isTransitioning = false;
                    this._scrollBar = new ScrollBarHelper;
                    this._addEventListeners();
                }
                static get Default() {
                    return Default$6;
                }
                static get DefaultType() {
                    return DefaultType$6;
                }
                static get NAME() {
                    return NAME$7;
                }
                toggle(relatedTarget) {
                    return this._isShown ? this.hide() : this.show(relatedTarget);
                }
                show(relatedTarget) {
                    if (this._isShown || this._isTransitioning) {
                        return;
                    }
                    const showEvent = EventHandler.trigger(this._element, EVENT_SHOW$4, {
                        relatedTarget
                    });
                    if (showEvent.defaultPrevented) {
                        return;
                    }
                    this._isShown = true;
                    this._isTransitioning = true;
                    this._scrollBar.hide();
                    document.body.classList.add(CLASS_NAME_OPEN);
                    this._adjustDialog();
                    this._backdrop.show((() => this._showElement(relatedTarget)));
                }
                hide() {
                    if (!this._isShown || this._isTransitioning) {
                        return;
                    }
                    const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE$4);
                    if (hideEvent.defaultPrevented) {
                        return;
                    }
                    this._isShown = false;
                    this._isTransitioning = true;
                    this._focustrap.deactivate();
                    this._element.classList.remove(CLASS_NAME_SHOW$4);
                    this._queueCallback((() => this._hideModal()), this._element, this._isAnimated());
                }
                dispose() {
                    for (const htmlElement of [ window, this._dialog ]) {
                        EventHandler.off(htmlElement, EVENT_KEY$4);
                    }
                    this._backdrop.dispose();
                    this._focustrap.deactivate();
                    super.dispose();
                }
                handleUpdate() {
                    this._adjustDialog();
                }
                _initializeBackDrop() {
                    return new Backdrop({
                        isVisible: Boolean(this._config.backdrop),
                        isAnimated: this._isAnimated()
                    });
                }
                _initializeFocusTrap() {
                    return new FocusTrap({
                        trapElement: this._element
                    });
                }
                _showElement(relatedTarget) {
                    if (!document.body.contains(this._element)) {
                        document.body.append(this._element);
                    }
                    this._element.style.display = "block";
                    this._element.removeAttribute("aria-hidden");
                    this._element.setAttribute("aria-modal", true);
                    this._element.setAttribute("role", "dialog");
                    this._element.scrollTop = 0;
                    const modalBody = SelectorEngine.findOne(SELECTOR_MODAL_BODY, this._dialog);
                    if (modalBody) {
                        modalBody.scrollTop = 0;
                    }
                    reflow(this._element);
                    this._element.classList.add(CLASS_NAME_SHOW$4);
                    const transitionComplete = () => {
                        if (this._config.focus) {
                            this._focustrap.activate();
                        }
                        this._isTransitioning = false;
                        EventHandler.trigger(this._element, EVENT_SHOWN$4, {
                            relatedTarget
                        });
                    };
                    this._queueCallback(transitionComplete, this._dialog, this._isAnimated());
                }
                _addEventListeners() {
                    EventHandler.on(this._element, EVENT_KEYDOWN_DISMISS$1, (event => {
                        if (event.key !== ESCAPE_KEY$1) {
                            return;
                        }
                        if (this._config.keyboard) {
                            event.preventDefault();
                            this.hide();
                            return;
                        }
                        this._triggerBackdropTransition();
                    }));
                    EventHandler.on(window, EVENT_RESIZE$1, (() => {
                        if (this._isShown && !this._isTransitioning) {
                            this._adjustDialog();
                        }
                    }));
                    EventHandler.on(this._element, EVENT_MOUSEDOWN_DISMISS, (event => {
                        if (event.target !== event.currentTarget) {
                            return;
                        }
                        if (this._config.backdrop === "static") {
                            this._triggerBackdropTransition();
                            return;
                        }
                        if (this._config.backdrop) {
                            this.hide();
                        }
                    }));
                }
                _hideModal() {
                    this._element.style.display = "none";
                    this._element.setAttribute("aria-hidden", true);
                    this._element.removeAttribute("aria-modal");
                    this._element.removeAttribute("role");
                    this._isTransitioning = false;
                    this._backdrop.hide((() => {
                        document.body.classList.remove(CLASS_NAME_OPEN);
                        this._resetAdjustments();
                        this._scrollBar.reset();
                        EventHandler.trigger(this._element, EVENT_HIDDEN$4);
                    }));
                }
                _isAnimated() {
                    return this._element.classList.contains(CLASS_NAME_FADE$3);
                }
                _triggerBackdropTransition() {
                    const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE_PREVENTED$1);
                    if (hideEvent.defaultPrevented) {
                        return;
                    }
                    const isModalOverflowing = this._element.scrollHeight > document.documentElement.clientHeight;
                    const initialOverflowY = this._element.style.overflowY;
                    if (initialOverflowY === "hidden" || this._element.classList.contains(CLASS_NAME_STATIC)) {
                        return;
                    }
                    if (!isModalOverflowing) {
                        this._element.style.overflowY = "hidden";
                    }
                    this._element.classList.add(CLASS_NAME_STATIC);
                    this._queueCallback((() => {
                        this._element.classList.remove(CLASS_NAME_STATIC);
                        this._queueCallback((() => {
                            this._element.style.overflowY = initialOverflowY;
                        }), this._dialog);
                    }), this._dialog);
                    this._element.focus();
                }
                _adjustDialog() {
                    const isModalOverflowing = this._element.scrollHeight > document.documentElement.clientHeight;
                    const scrollbarWidth = this._scrollBar.getWidth();
                    const isBodyOverflowing = scrollbarWidth > 0;
                    if (isBodyOverflowing && !isModalOverflowing) {
                        const property = isRTL() ? "paddingLeft" : "paddingRight";
                        this._element.style[property] = `${scrollbarWidth}px`;
                    }
                    if (!isBodyOverflowing && isModalOverflowing) {
                        const property = isRTL() ? "paddingRight" : "paddingLeft";
                        this._element.style[property] = `${scrollbarWidth}px`;
                    }
                }
                _resetAdjustments() {
                    this._element.style.paddingLeft = "";
                    this._element.style.paddingRight = "";
                }
                static jQueryInterface(config, relatedTarget) {
                    return this.each((function() {
                        const data = Modal.getOrCreateInstance(this, config);
                        if (typeof config !== "string") {
                            return;
                        }
                        if (typeof data[config] === "undefined") {
                            throw new TypeError(`No method named "${config}"`);
                        }
                        data[config](relatedTarget);
                    }));
                }
            }
            EventHandler.on(document, EVENT_CLICK_DATA_API$2, SELECTOR_DATA_TOGGLE$2, (function(event) {
                const target = getElementFromSelector(this);
                if ([ "A", "AREA" ].includes(this.tagName)) {
                    event.preventDefault();
                }
                EventHandler.one(target, EVENT_SHOW$4, (showEvent => {
                    if (showEvent.defaultPrevented) {
                        return;
                    }
                    EventHandler.one(target, EVENT_HIDDEN$4, (() => {
                        if (isVisible(this)) {
                            this.focus();
                        }
                    }));
                }));
                const alreadyOpen = SelectorEngine.findOne(OPEN_SELECTOR$1);
                if (alreadyOpen) {
                    Modal.getInstance(alreadyOpen).hide();
                }
                const data = Modal.getOrCreateInstance(target);
                data.toggle(this);
            }));
            enableDismissTrigger(Modal);
            defineJQueryPlugin(Modal);
            const NAME$6 = "offcanvas";
            const DATA_KEY$3 = "bs.offcanvas";
            const EVENT_KEY$3 = `.${DATA_KEY$3}`;
            const DATA_API_KEY$1 = ".data-api";
            const EVENT_LOAD_DATA_API$2 = `load${EVENT_KEY$3}${DATA_API_KEY$1}`;
            const ESCAPE_KEY = "Escape";
            const CLASS_NAME_SHOW$3 = "show";
            const CLASS_NAME_SHOWING$1 = "showing";
            const CLASS_NAME_HIDING = "hiding";
            const CLASS_NAME_BACKDROP = "offcanvas-backdrop";
            const OPEN_SELECTOR = ".offcanvas.show";
            const EVENT_SHOW$3 = `show${EVENT_KEY$3}`;
            const EVENT_SHOWN$3 = `shown${EVENT_KEY$3}`;
            const EVENT_HIDE$3 = `hide${EVENT_KEY$3}`;
            const EVENT_HIDE_PREVENTED = `hidePrevented${EVENT_KEY$3}`;
            const EVENT_HIDDEN$3 = `hidden${EVENT_KEY$3}`;
            const EVENT_RESIZE = `resize${EVENT_KEY$3}`;
            const EVENT_CLICK_DATA_API$1 = `click${EVENT_KEY$3}${DATA_API_KEY$1}`;
            const EVENT_KEYDOWN_DISMISS = `keydown.dismiss${EVENT_KEY$3}`;
            const SELECTOR_DATA_TOGGLE$1 = '[data-bs-toggle="offcanvas"]';
            const Default$5 = {
                backdrop: true,
                keyboard: true,
                scroll: false
            };
            const DefaultType$5 = {
                backdrop: "(boolean|string)",
                keyboard: "boolean",
                scroll: "boolean"
            };
            class Offcanvas extends BaseComponent {
                constructor(element, config) {
                    super(element, config);
                    this._isShown = false;
                    this._backdrop = this._initializeBackDrop();
                    this._focustrap = this._initializeFocusTrap();
                    this._addEventListeners();
                }
                static get Default() {
                    return Default$5;
                }
                static get DefaultType() {
                    return DefaultType$5;
                }
                static get NAME() {
                    return NAME$6;
                }
                toggle(relatedTarget) {
                    return this._isShown ? this.hide() : this.show(relatedTarget);
                }
                show(relatedTarget) {
                    if (this._isShown) {
                        return;
                    }
                    const showEvent = EventHandler.trigger(this._element, EVENT_SHOW$3, {
                        relatedTarget
                    });
                    if (showEvent.defaultPrevented) {
                        return;
                    }
                    this._isShown = true;
                    this._backdrop.show();
                    if (!this._config.scroll) {
                        (new ScrollBarHelper).hide();
                    }
                    this._element.setAttribute("aria-modal", true);
                    this._element.setAttribute("role", "dialog");
                    this._element.classList.add(CLASS_NAME_SHOWING$1);
                    const completeCallBack = () => {
                        if (!this._config.scroll || this._config.backdrop) {
                            this._focustrap.activate();
                        }
                        this._element.classList.add(CLASS_NAME_SHOW$3);
                        this._element.classList.remove(CLASS_NAME_SHOWING$1);
                        EventHandler.trigger(this._element, EVENT_SHOWN$3, {
                            relatedTarget
                        });
                    };
                    this._queueCallback(completeCallBack, this._element, true);
                }
                hide() {
                    if (!this._isShown) {
                        return;
                    }
                    const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE$3);
                    if (hideEvent.defaultPrevented) {
                        return;
                    }
                    this._focustrap.deactivate();
                    this._element.blur();
                    this._isShown = false;
                    this._element.classList.add(CLASS_NAME_HIDING);
                    this._backdrop.hide();
                    const completeCallback = () => {
                        this._element.classList.remove(CLASS_NAME_SHOW$3, CLASS_NAME_HIDING);
                        this._element.removeAttribute("aria-modal");
                        this._element.removeAttribute("role");
                        if (!this._config.scroll) {
                            (new ScrollBarHelper).reset();
                        }
                        EventHandler.trigger(this._element, EVENT_HIDDEN$3);
                    };
                    this._queueCallback(completeCallback, this._element, true);
                }
                dispose() {
                    this._backdrop.dispose();
                    this._focustrap.deactivate();
                    super.dispose();
                }
                _initializeBackDrop() {
                    const clickCallback = () => {
                        if (this._config.backdrop === "static") {
                            EventHandler.trigger(this._element, EVENT_HIDE_PREVENTED);
                            return;
                        }
                        this.hide();
                    };
                    const isVisible = Boolean(this._config.backdrop);
                    return new Backdrop({
                        className: CLASS_NAME_BACKDROP,
                        isVisible,
                        isAnimated: true,
                        rootElement: this._element.parentNode,
                        clickCallback: isVisible ? clickCallback : null
                    });
                }
                _initializeFocusTrap() {
                    return new FocusTrap({
                        trapElement: this._element
                    });
                }
                _addEventListeners() {
                    EventHandler.on(this._element, EVENT_KEYDOWN_DISMISS, (event => {
                        if (event.key !== ESCAPE_KEY) {
                            return;
                        }
                        if (!this._config.keyboard) {
                            EventHandler.trigger(this._element, EVENT_HIDE_PREVENTED);
                            return;
                        }
                        this.hide();
                    }));
                }
                static jQueryInterface(config) {
                    return this.each((function() {
                        const data = Offcanvas.getOrCreateInstance(this, config);
                        if (typeof config !== "string") {
                            return;
                        }
                        if (data[config] === undefined || config.startsWith("_") || config === "constructor") {
                            throw new TypeError(`No method named "${config}"`);
                        }
                        data[config](this);
                    }));
                }
            }
            EventHandler.on(document, EVENT_CLICK_DATA_API$1, SELECTOR_DATA_TOGGLE$1, (function(event) {
                const target = getElementFromSelector(this);
                if ([ "A", "AREA" ].includes(this.tagName)) {
                    event.preventDefault();
                }
                if (isDisabled(this)) {
                    return;
                }
                EventHandler.one(target, EVENT_HIDDEN$3, (() => {
                    if (isVisible(this)) {
                        this.focus();
                    }
                }));
                const alreadyOpen = SelectorEngine.findOne(OPEN_SELECTOR);
                if (alreadyOpen && alreadyOpen !== target) {
                    Offcanvas.getInstance(alreadyOpen).hide();
                }
                const data = Offcanvas.getOrCreateInstance(target);
                data.toggle(this);
            }));
            EventHandler.on(window, EVENT_LOAD_DATA_API$2, (() => {
                for (const selector of SelectorEngine.find(OPEN_SELECTOR)) {
                    Offcanvas.getOrCreateInstance(selector).show();
                }
            }));
            EventHandler.on(window, EVENT_RESIZE, (() => {
                for (const element of SelectorEngine.find("[aria-modal][class*=show][class*=offcanvas-]")) {
                    if (getComputedStyle(element).position !== "fixed") {
                        Offcanvas.getOrCreateInstance(element).hide();
                    }
                }
            }));
            enableDismissTrigger(Offcanvas);
            defineJQueryPlugin(Offcanvas);
            const uriAttributes = new Set([ "background", "cite", "href", "itemtype", "longdesc", "poster", "src", "xlink:href" ]);
            const ARIA_ATTRIBUTE_PATTERN = /^aria-[\w-]*$/i;
            const SAFE_URL_PATTERN = /^(?:(?:https?|mailto|ftp|tel|file|sms):|[^#&/:?]*(?:[#/?]|$))/i;
            const DATA_URL_PATTERN = /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[\d+/a-z]+=*$/i;
            const allowedAttribute = (attribute, allowedAttributeList) => {
                const attributeName = attribute.nodeName.toLowerCase();
                if (allowedAttributeList.includes(attributeName)) {
                    if (uriAttributes.has(attributeName)) {
                        return Boolean(SAFE_URL_PATTERN.test(attribute.nodeValue) || DATA_URL_PATTERN.test(attribute.nodeValue));
                    }
                    return true;
                }
                return allowedAttributeList.filter((attributeRegex => attributeRegex instanceof RegExp)).some((regex => regex.test(attributeName)));
            };
            const DefaultAllowlist = {
                "*": [ "class", "dir", "id", "lang", "role", ARIA_ATTRIBUTE_PATTERN ],
                a: [ "target", "href", "title", "rel" ],
                area: [],
                b: [],
                br: [],
                col: [],
                code: [],
                div: [],
                em: [],
                hr: [],
                h1: [],
                h2: [],
                h3: [],
                h4: [],
                h5: [],
                h6: [],
                i: [],
                img: [ "src", "srcset", "alt", "title", "width", "height" ],
                li: [],
                ol: [],
                p: [],
                pre: [],
                s: [],
                small: [],
                span: [],
                sub: [],
                sup: [],
                strong: [],
                u: [],
                ul: []
            };
            function sanitizeHtml(unsafeHtml, allowList, sanitizeFunction) {
                if (!unsafeHtml.length) {
                    return unsafeHtml;
                }
                if (sanitizeFunction && typeof sanitizeFunction === "function") {
                    return sanitizeFunction(unsafeHtml);
                }
                const domParser = new window.DOMParser;
                const createdDocument = domParser.parseFromString(unsafeHtml, "text/html");
                const elements = [].concat(...createdDocument.body.querySelectorAll("*"));
                for (const element of elements) {
                    const elementName = element.nodeName.toLowerCase();
                    if (!Object.keys(allowList).includes(elementName)) {
                        element.remove();
                        continue;
                    }
                    const attributeList = [].concat(...element.attributes);
                    const allowedAttributes = [].concat(allowList["*"] || [], allowList[elementName] || []);
                    for (const attribute of attributeList) {
                        if (!allowedAttribute(attribute, allowedAttributes)) {
                            element.removeAttribute(attribute.nodeName);
                        }
                    }
                }
                return createdDocument.body.innerHTML;
            }
            const NAME$5 = "TemplateFactory";
            const Default$4 = {
                allowList: DefaultAllowlist,
                content: {},
                extraClass: "",
                html: false,
                sanitize: true,
                sanitizeFn: null,
                template: "<div></div>"
            };
            const DefaultType$4 = {
                allowList: "object",
                content: "object",
                extraClass: "(string|function)",
                html: "boolean",
                sanitize: "boolean",
                sanitizeFn: "(null|function)",
                template: "string"
            };
            const DefaultContentType = {
                entry: "(string|element|function|null)",
                selector: "(string|element)"
            };
            class TemplateFactory extends Config {
                constructor(config) {
                    super();
                    this._config = this._getConfig(config);
                }
                static get Default() {
                    return Default$4;
                }
                static get DefaultType() {
                    return DefaultType$4;
                }
                static get NAME() {
                    return NAME$5;
                }
                getContent() {
                    return Object.values(this._config.content).map((config => this._resolvePossibleFunction(config))).filter(Boolean);
                }
                hasContent() {
                    return this.getContent().length > 0;
                }
                changeContent(content) {
                    this._checkContent(content);
                    this._config.content = {
                        ...this._config.content,
                        ...content
                    };
                    return this;
                }
                toHtml() {
                    const templateWrapper = document.createElement("div");
                    templateWrapper.innerHTML = this._maybeSanitize(this._config.template);
                    for (const [selector, text] of Object.entries(this._config.content)) {
                        this._setContent(templateWrapper, text, selector);
                    }
                    const template = templateWrapper.children[0];
                    const extraClass = this._resolvePossibleFunction(this._config.extraClass);
                    if (extraClass) {
                        template.classList.add(...extraClass.split(" "));
                    }
                    return template;
                }
                _typeCheckConfig(config) {
                    super._typeCheckConfig(config);
                    this._checkContent(config.content);
                }
                _checkContent(arg) {
                    for (const [selector, content] of Object.entries(arg)) {
                        super._typeCheckConfig({
                            selector,
                            entry: content
                        }, DefaultContentType);
                    }
                }
                _setContent(template, content, selector) {
                    const templateElement = SelectorEngine.findOne(selector, template);
                    if (!templateElement) {
                        return;
                    }
                    content = this._resolvePossibleFunction(content);
                    if (!content) {
                        templateElement.remove();
                        return;
                    }
                    if (isElement(content)) {
                        this._putElementInTemplate(getElement(content), templateElement);
                        return;
                    }
                    if (this._config.html) {
                        templateElement.innerHTML = this._maybeSanitize(content);
                        return;
                    }
                    templateElement.textContent = content;
                }
                _maybeSanitize(arg) {
                    return this._config.sanitize ? sanitizeHtml(arg, this._config.allowList, this._config.sanitizeFn) : arg;
                }
                _resolvePossibleFunction(arg) {
                    return typeof arg === "function" ? arg(this) : arg;
                }
                _putElementInTemplate(element, templateElement) {
                    if (this._config.html) {
                        templateElement.innerHTML = "";
                        templateElement.append(element);
                        return;
                    }
                    templateElement.textContent = element.textContent;
                }
            }
            const NAME$4 = "tooltip";
            const DISALLOWED_ATTRIBUTES = new Set([ "sanitize", "allowList", "sanitizeFn" ]);
            const CLASS_NAME_FADE$2 = "fade";
            const CLASS_NAME_MODAL = "modal";
            const CLASS_NAME_SHOW$2 = "show";
            const SELECTOR_TOOLTIP_INNER = ".tooltip-inner";
            const SELECTOR_MODAL = `.${CLASS_NAME_MODAL}`;
            const EVENT_MODAL_HIDE = "hide.bs.modal";
            const TRIGGER_HOVER = "hover";
            const TRIGGER_FOCUS = "focus";
            const TRIGGER_CLICK = "click";
            const TRIGGER_MANUAL = "manual";
            const EVENT_HIDE$2 = "hide";
            const EVENT_HIDDEN$2 = "hidden";
            const EVENT_SHOW$2 = "show";
            const EVENT_SHOWN$2 = "shown";
            const EVENT_INSERTED = "inserted";
            const EVENT_CLICK$1 = "click";
            const EVENT_FOCUSIN$1 = "focusin";
            const EVENT_FOCUSOUT$1 = "focusout";
            const EVENT_MOUSEENTER = "mouseenter";
            const EVENT_MOUSELEAVE = "mouseleave";
            const AttachmentMap = {
                AUTO: "auto",
                TOP: "top",
                RIGHT: isRTL() ? "left" : "right",
                BOTTOM: "bottom",
                LEFT: isRTL() ? "right" : "left"
            };
            const Default$3 = {
                allowList: DefaultAllowlist,
                animation: true,
                boundary: "clippingParents",
                container: false,
                customClass: "",
                delay: 0,
                fallbackPlacements: [ "top", "right", "bottom", "left" ],
                html: false,
                offset: [ 0, 0 ],
                placement: "top",
                popperConfig: null,
                sanitize: true,
                sanitizeFn: null,
                selector: false,
                template: '<div class="tooltip" role="tooltip">' + '<div class="tooltip-arrow"></div>' + '<div class="tooltip-inner"></div>' + "</div>",
                title: "",
                trigger: "hover focus"
            };
            const DefaultType$3 = {
                allowList: "object",
                animation: "boolean",
                boundary: "(string|element)",
                container: "(string|element|boolean)",
                customClass: "(string|function)",
                delay: "(number|object)",
                fallbackPlacements: "array",
                html: "boolean",
                offset: "(array|string|function)",
                placement: "(string|function)",
                popperConfig: "(null|object|function)",
                sanitize: "boolean",
                sanitizeFn: "(null|function)",
                selector: "(string|boolean)",
                template: "string",
                title: "(string|element|function)",
                trigger: "string"
            };
            class Tooltip extends BaseComponent {
                constructor(element, config) {
                    if (typeof _popperjs_core__WEBPACK_IMPORTED_MODULE_0__ === "undefined") {
                        throw new TypeError("Bootstrap's tooltips require Popper (https://popper.js.org)");
                    }
                    super(element, config);
                    this._isEnabled = true;
                    this._timeout = 0;
                    this._isHovered = false;
                    this._activeTrigger = {};
                    this._popper = null;
                    this._templateFactory = null;
                    this._newContent = null;
                    this.tip = null;
                    this._setListeners();
                }
                static get Default() {
                    return Default$3;
                }
                static get DefaultType() {
                    return DefaultType$3;
                }
                static get NAME() {
                    return NAME$4;
                }
                enable() {
                    this._isEnabled = true;
                }
                disable() {
                    this._isEnabled = false;
                }
                toggleEnabled() {
                    this._isEnabled = !this._isEnabled;
                }
                toggle(event) {
                    if (!this._isEnabled) {
                        return;
                    }
                    if (event) {
                        const context = this._initializeOnDelegatedTarget(event);
                        context._activeTrigger.click = !context._activeTrigger.click;
                        if (context._isWithActiveTrigger()) {
                            context._enter();
                        } else {
                            context._leave();
                        }
                        return;
                    }
                    if (this._isShown()) {
                        this._leave();
                        return;
                    }
                    this._enter();
                }
                dispose() {
                    clearTimeout(this._timeout);
                    EventHandler.off(this._element.closest(SELECTOR_MODAL), EVENT_MODAL_HIDE, this._hideModalHandler);
                    if (this.tip) {
                        this.tip.remove();
                    }
                    this._disposePopper();
                    super.dispose();
                }
                show() {
                    if (this._element.style.display === "none") {
                        throw new Error("Please use show on visible elements");
                    }
                    if (!(this._isWithContent() && this._isEnabled)) {
                        return;
                    }
                    const showEvent = EventHandler.trigger(this._element, this.constructor.eventName(EVENT_SHOW$2));
                    const shadowRoot = findShadowRoot(this._element);
                    const isInTheDom = (shadowRoot || this._element.ownerDocument.documentElement).contains(this._element);
                    if (showEvent.defaultPrevented || !isInTheDom) {
                        return;
                    }
                    if (this.tip) {
                        this.tip.remove();
                        this.tip = null;
                    }
                    const tip = this._getTipElement();
                    this._element.setAttribute("aria-describedby", tip.getAttribute("id"));
                    const {container} = this._config;
                    if (!this._element.ownerDocument.documentElement.contains(this.tip)) {
                        container.append(tip);
                        EventHandler.trigger(this._element, this.constructor.eventName(EVENT_INSERTED));
                    }
                    if (this._popper) {
                        this._popper.update();
                    } else {
                        this._popper = this._createPopper(tip);
                    }
                    tip.classList.add(CLASS_NAME_SHOW$2);
                    if ("ontouchstart" in document.documentElement) {
                        for (const element of [].concat(...document.body.children)) {
                            EventHandler.on(element, "mouseover", noop);
                        }
                    }
                    const complete = () => {
                        const previousHoverState = this._isHovered;
                        this._isHovered = false;
                        EventHandler.trigger(this._element, this.constructor.eventName(EVENT_SHOWN$2));
                        if (previousHoverState) {
                            this._leave();
                        }
                    };
                    this._queueCallback(complete, this.tip, this._isAnimated());
                }
                hide() {
                    if (!this._isShown()) {
                        return;
                    }
                    const hideEvent = EventHandler.trigger(this._element, this.constructor.eventName(EVENT_HIDE$2));
                    if (hideEvent.defaultPrevented) {
                        return;
                    }
                    const tip = this._getTipElement();
                    tip.classList.remove(CLASS_NAME_SHOW$2);
                    if ("ontouchstart" in document.documentElement) {
                        for (const element of [].concat(...document.body.children)) {
                            EventHandler.off(element, "mouseover", noop);
                        }
                    }
                    this._activeTrigger[TRIGGER_CLICK] = false;
                    this._activeTrigger[TRIGGER_FOCUS] = false;
                    this._activeTrigger[TRIGGER_HOVER] = false;
                    this._isHovered = false;
                    const complete = () => {
                        if (this._isWithActiveTrigger()) {
                            return;
                        }
                        if (!this._isHovered) {
                            tip.remove();
                        }
                        this._element.removeAttribute("aria-describedby");
                        EventHandler.trigger(this._element, this.constructor.eventName(EVENT_HIDDEN$2));
                        this._disposePopper();
                    };
                    this._queueCallback(complete, this.tip, this._isAnimated());
                }
                update() {
                    if (this._popper) {
                        this._popper.update();
                    }
                }
                _isWithContent() {
                    return Boolean(this._getTitle());
                }
                _getTipElement() {
                    if (!this.tip) {
                        this.tip = this._createTipElement(this._newContent || this._getContentForTemplate());
                    }
                    return this.tip;
                }
                _createTipElement(content) {
                    const tip = this._getTemplateFactory(content).toHtml();
                    if (!tip) {
                        return null;
                    }
                    tip.classList.remove(CLASS_NAME_FADE$2, CLASS_NAME_SHOW$2);
                    tip.classList.add(`bs-${this.constructor.NAME}-auto`);
                    const tipId = getUID(this.constructor.NAME).toString();
                    tip.setAttribute("id", tipId);
                    if (this._isAnimated()) {
                        tip.classList.add(CLASS_NAME_FADE$2);
                    }
                    return tip;
                }
                setContent(content) {
                    this._newContent = content;
                    if (this._isShown()) {
                        this._disposePopper();
                        this.show();
                    }
                }
                _getTemplateFactory(content) {
                    if (this._templateFactory) {
                        this._templateFactory.changeContent(content);
                    } else {
                        this._templateFactory = new TemplateFactory({
                            ...this._config,
                            content,
                            extraClass: this._resolvePossibleFunction(this._config.customClass)
                        });
                    }
                    return this._templateFactory;
                }
                _getContentForTemplate() {
                    return {
                        [SELECTOR_TOOLTIP_INNER]: this._getTitle()
                    };
                }
                _getTitle() {
                    return this._resolvePossibleFunction(this._config.title) || this._config.originalTitle;
                }
                _initializeOnDelegatedTarget(event) {
                    return this.constructor.getOrCreateInstance(event.delegateTarget, this._getDelegateConfig());
                }
                _isAnimated() {
                    return this._config.animation || this.tip && this.tip.classList.contains(CLASS_NAME_FADE$2);
                }
                _isShown() {
                    return this.tip && this.tip.classList.contains(CLASS_NAME_SHOW$2);
                }
                _createPopper(tip) {
                    const placement = typeof this._config.placement === "function" ? this._config.placement.call(this, tip, this._element) : this._config.placement;
                    const attachment = AttachmentMap[placement.toUpperCase()];
                    return _popperjs_core__WEBPACK_IMPORTED_MODULE_1__.createPopper(this._element, tip, this._getPopperConfig(attachment));
                }
                _getOffset() {
                    const {offset} = this._config;
                    if (typeof offset === "string") {
                        return offset.split(",").map((value => Number.parseInt(value, 10)));
                    }
                    if (typeof offset === "function") {
                        return popperData => offset(popperData, this._element);
                    }
                    return offset;
                }
                _resolvePossibleFunction(arg) {
                    return typeof arg === "function" ? arg.call(this._element) : arg;
                }
                _getPopperConfig(attachment) {
                    const defaultBsPopperConfig = {
                        placement: attachment,
                        modifiers: [ {
                            name: "flip",
                            options: {
                                fallbackPlacements: this._config.fallbackPlacements
                            }
                        }, {
                            name: "offset",
                            options: {
                                offset: this._getOffset()
                            }
                        }, {
                            name: "preventOverflow",
                            options: {
                                boundary: this._config.boundary
                            }
                        }, {
                            name: "arrow",
                            options: {
                                element: `.${this.constructor.NAME}-arrow`
                            }
                        }, {
                            name: "preSetPlacement",
                            enabled: true,
                            phase: "beforeMain",
                            fn: data => {
                                this._getTipElement().setAttribute("data-popper-placement", data.state.placement);
                            }
                        } ]
                    };
                    return {
                        ...defaultBsPopperConfig,
                        ...typeof this._config.popperConfig === "function" ? this._config.popperConfig(defaultBsPopperConfig) : this._config.popperConfig
                    };
                }
                _setListeners() {
                    const triggers = this._config.trigger.split(" ");
                    for (const trigger of triggers) {
                        if (trigger === "click") {
                            EventHandler.on(this._element, this.constructor.eventName(EVENT_CLICK$1), this._config.selector, (event => this.toggle(event)));
                        } else if (trigger !== TRIGGER_MANUAL) {
                            const eventIn = trigger === TRIGGER_HOVER ? this.constructor.eventName(EVENT_MOUSEENTER) : this.constructor.eventName(EVENT_FOCUSIN$1);
                            const eventOut = trigger === TRIGGER_HOVER ? this.constructor.eventName(EVENT_MOUSELEAVE) : this.constructor.eventName(EVENT_FOCUSOUT$1);
                            EventHandler.on(this._element, eventIn, this._config.selector, (event => {
                                const context = this._initializeOnDelegatedTarget(event);
                                context._activeTrigger[event.type === "focusin" ? TRIGGER_FOCUS : TRIGGER_HOVER] = true;
                                context._enter();
                            }));
                            EventHandler.on(this._element, eventOut, this._config.selector, (event => {
                                const context = this._initializeOnDelegatedTarget(event);
                                context._activeTrigger[event.type === "focusout" ? TRIGGER_FOCUS : TRIGGER_HOVER] = context._element.contains(event.relatedTarget);
                                context._leave();
                            }));
                        }
                    }
                    this._hideModalHandler = () => {
                        if (this._element) {
                            this.hide();
                        }
                    };
                    EventHandler.on(this._element.closest(SELECTOR_MODAL), EVENT_MODAL_HIDE, this._hideModalHandler);
                    if (this._config.selector) {
                        this._config = {
                            ...this._config,
                            trigger: "manual",
                            selector: ""
                        };
                    } else {
                        this._fixTitle();
                    }
                }
                _fixTitle() {
                    const title = this._config.originalTitle;
                    if (!title) {
                        return;
                    }
                    if (!this._element.getAttribute("aria-label") && !this._element.textContent.trim()) {
                        this._element.setAttribute("aria-label", title);
                    }
                    this._element.removeAttribute("title");
                }
                _enter() {
                    if (this._isShown() || this._isHovered) {
                        this._isHovered = true;
                        return;
                    }
                    this._isHovered = true;
                    this._setTimeout((() => {
                        if (this._isHovered) {
                            this.show();
                        }
                    }), this._config.delay.show);
                }
                _leave() {
                    if (this._isWithActiveTrigger()) {
                        return;
                    }
                    this._isHovered = false;
                    this._setTimeout((() => {
                        if (!this._isHovered) {
                            this.hide();
                        }
                    }), this._config.delay.hide);
                }
                _setTimeout(handler, timeout) {
                    clearTimeout(this._timeout);
                    this._timeout = setTimeout(handler, timeout);
                }
                _isWithActiveTrigger() {
                    return Object.values(this._activeTrigger).includes(true);
                }
                _getConfig(config) {
                    const dataAttributes = Manipulator.getDataAttributes(this._element);
                    for (const dataAttribute of Object.keys(dataAttributes)) {
                        if (DISALLOWED_ATTRIBUTES.has(dataAttribute)) {
                            delete dataAttributes[dataAttribute];
                        }
                    }
                    config = {
                        ...dataAttributes,
                        ...typeof config === "object" && config ? config : {}
                    };
                    config = this._mergeConfigObj(config);
                    config = this._configAfterMerge(config);
                    this._typeCheckConfig(config);
                    return config;
                }
                _configAfterMerge(config) {
                    config.container = config.container === false ? document.body : getElement(config.container);
                    if (typeof config.delay === "number") {
                        config.delay = {
                            show: config.delay,
                            hide: config.delay
                        };
                    }
                    config.originalTitle = this._element.getAttribute("title") || "";
                    if (typeof config.title === "number") {
                        config.title = config.title.toString();
                    }
                    if (typeof config.content === "number") {
                        config.content = config.content.toString();
                    }
                    return config;
                }
                _getDelegateConfig() {
                    const config = {};
                    for (const key in this._config) {
                        if (this.constructor.Default[key] !== this._config[key]) {
                            config[key] = this._config[key];
                        }
                    }
                    return config;
                }
                _disposePopper() {
                    if (this._popper) {
                        this._popper.destroy();
                        this._popper = null;
                    }
                }
                static jQueryInterface(config) {
                    return this.each((function() {
                        const data = Tooltip.getOrCreateInstance(this, config);
                        if (typeof config !== "string") {
                            return;
                        }
                        if (typeof data[config] === "undefined") {
                            throw new TypeError(`No method named "${config}"`);
                        }
                        data[config]();
                    }));
                }
            }
            defineJQueryPlugin(Tooltip);
            const NAME$3 = "popover";
            const SELECTOR_TITLE = ".popover-header";
            const SELECTOR_CONTENT = ".popover-body";
            const Default$2 = {
                ...Tooltip.Default,
                content: "",
                offset: [ 0, 8 ],
                placement: "right",
                template: '<div class="popover" role="tooltip">' + '<div class="popover-arrow"></div>' + '<h3 class="popover-header"></h3>' + '<div class="popover-body"></div>' + "</div>",
                trigger: "click"
            };
            const DefaultType$2 = {
                ...Tooltip.DefaultType,
                content: "(null|string|element|function)"
            };
            class Popover extends Tooltip {
                static get Default() {
                    return Default$2;
                }
                static get DefaultType() {
                    return DefaultType$2;
                }
                static get NAME() {
                    return NAME$3;
                }
                _isWithContent() {
                    return this._getTitle() || this._getContent();
                }
                _getContentForTemplate() {
                    return {
                        [SELECTOR_TITLE]: this._getTitle(),
                        [SELECTOR_CONTENT]: this._getContent()
                    };
                }
                _getContent() {
                    return this._resolvePossibleFunction(this._config.content);
                }
                static jQueryInterface(config) {
                    return this.each((function() {
                        const data = Popover.getOrCreateInstance(this, config);
                        if (typeof config !== "string") {
                            return;
                        }
                        if (typeof data[config] === "undefined") {
                            throw new TypeError(`No method named "${config}"`);
                        }
                        data[config]();
                    }));
                }
            }
            defineJQueryPlugin(Popover);
            const NAME$2 = "scrollspy";
            const DATA_KEY$2 = "bs.scrollspy";
            const EVENT_KEY$2 = `.${DATA_KEY$2}`;
            const DATA_API_KEY = ".data-api";
            const EVENT_ACTIVATE = `activate${EVENT_KEY$2}`;
            const EVENT_CLICK = `click${EVENT_KEY$2}`;
            const EVENT_LOAD_DATA_API$1 = `load${EVENT_KEY$2}${DATA_API_KEY}`;
            const CLASS_NAME_DROPDOWN_ITEM = "dropdown-item";
            const CLASS_NAME_ACTIVE$1 = "active";
            const SELECTOR_DATA_SPY = '[data-bs-spy="scroll"]';
            const SELECTOR_TARGET_LINKS = "[href]";
            const SELECTOR_NAV_LIST_GROUP = ".nav, .list-group";
            const SELECTOR_NAV_LINKS = ".nav-link";
            const SELECTOR_NAV_ITEMS = ".nav-item";
            const SELECTOR_LIST_ITEMS = ".list-group-item";
            const SELECTOR_LINK_ITEMS = `${SELECTOR_NAV_LINKS}, ${SELECTOR_NAV_ITEMS} > ${SELECTOR_NAV_LINKS}, ${SELECTOR_LIST_ITEMS}`;
            const SELECTOR_DROPDOWN = ".dropdown";
            const SELECTOR_DROPDOWN_TOGGLE$1 = ".dropdown-toggle";
            const Default$1 = {
                offset: null,
                rootMargin: "0px 0px -25%",
                smoothScroll: false,
                target: null
            };
            const DefaultType$1 = {
                offset: "(number|null)",
                rootMargin: "string",
                smoothScroll: "boolean",
                target: "element"
            };
            class ScrollSpy extends BaseComponent {
                constructor(element, config) {
                    super(element, config);
                    this._targetLinks = new Map;
                    this._observableSections = new Map;
                    this._rootElement = getComputedStyle(this._element).overflowY === "visible" ? null : this._element;
                    this._activeTarget = null;
                    this._observer = null;
                    this._previousScrollData = {
                        visibleEntryTop: 0,
                        parentScrollTop: 0
                    };
                    this.refresh();
                }
                static get Default() {
                    return Default$1;
                }
                static get DefaultType() {
                    return DefaultType$1;
                }
                static get NAME() {
                    return NAME$2;
                }
                refresh() {
                    this._initializeTargetsAndObservables();
                    this._maybeEnableSmoothScroll();
                    if (this._observer) {
                        this._observer.disconnect();
                    } else {
                        this._observer = this._getNewObserver();
                    }
                    for (const section of this._observableSections.values()) {
                        this._observer.observe(section);
                    }
                }
                dispose() {
                    this._observer.disconnect();
                    super.dispose();
                }
                _configAfterMerge(config) {
                    config.target = getElement(config.target) || document.body;
                    return config;
                }
                _maybeEnableSmoothScroll() {
                    if (!this._config.smoothScroll) {
                        return;
                    }
                    EventHandler.off(this._config.target, EVENT_CLICK);
                    EventHandler.on(this._config.target, EVENT_CLICK, SELECTOR_TARGET_LINKS, (event => {
                        const observableSection = this._observableSections.get(event.target.hash);
                        if (observableSection) {
                            event.preventDefault();
                            const root = this._rootElement || window;
                            const height = observableSection.offsetTop - this._element.offsetTop;
                            if (root.scrollTo) {
                                root.scrollTo({
                                    top: height,
                                    behavior: "smooth"
                                });
                                return;
                            }
                            root.scrollTop = height;
                        }
                    }));
                }
                _getNewObserver() {
                    const options = {
                        root: this._rootElement,
                        threshold: [ .1, .5, 1 ],
                        rootMargin: this._getRootMargin()
                    };
                    return new IntersectionObserver((entries => this._observerCallback(entries)), options);
                }
                _observerCallback(entries) {
                    const targetElement = entry => this._targetLinks.get(`#${entry.target.id}`);
                    const activate = entry => {
                        this._previousScrollData.visibleEntryTop = entry.target.offsetTop;
                        this._process(targetElement(entry));
                    };
                    const parentScrollTop = (this._rootElement || document.documentElement).scrollTop;
                    const userScrollsDown = parentScrollTop >= this._previousScrollData.parentScrollTop;
                    this._previousScrollData.parentScrollTop = parentScrollTop;
                    for (const entry of entries) {
                        if (!entry.isIntersecting) {
                            this._activeTarget = null;
                            this._clearActiveClass(targetElement(entry));
                            continue;
                        }
                        const entryIsLowerThanPrevious = entry.target.offsetTop >= this._previousScrollData.visibleEntryTop;
                        if (userScrollsDown && entryIsLowerThanPrevious) {
                            activate(entry);
                            if (!parentScrollTop) {
                                return;
                            }
                            continue;
                        }
                        if (!userScrollsDown && !entryIsLowerThanPrevious) {
                            activate(entry);
                        }
                    }
                }
                _getRootMargin() {
                    return this._config.offset ? `${this._config.offset}px 0px -30%` : this._config.rootMargin;
                }
                _initializeTargetsAndObservables() {
                    this._targetLinks = new Map;
                    this._observableSections = new Map;
                    const targetLinks = SelectorEngine.find(SELECTOR_TARGET_LINKS, this._config.target);
                    for (const anchor of targetLinks) {
                        if (!anchor.hash || isDisabled(anchor)) {
                            continue;
                        }
                        const observableSection = SelectorEngine.findOne(anchor.hash, this._element);
                        if (isVisible(observableSection)) {
                            this._targetLinks.set(anchor.hash, anchor);
                            this._observableSections.set(anchor.hash, observableSection);
                        }
                    }
                }
                _process(target) {
                    if (this._activeTarget === target) {
                        return;
                    }
                    this._clearActiveClass(this._config.target);
                    this._activeTarget = target;
                    target.classList.add(CLASS_NAME_ACTIVE$1);
                    this._activateParents(target);
                    EventHandler.trigger(this._element, EVENT_ACTIVATE, {
                        relatedTarget: target
                    });
                }
                _activateParents(target) {
                    if (target.classList.contains(CLASS_NAME_DROPDOWN_ITEM)) {
                        SelectorEngine.findOne(SELECTOR_DROPDOWN_TOGGLE$1, target.closest(SELECTOR_DROPDOWN)).classList.add(CLASS_NAME_ACTIVE$1);
                        return;
                    }
                    for (const listGroup of SelectorEngine.parents(target, SELECTOR_NAV_LIST_GROUP)) {
                        for (const item of SelectorEngine.prev(listGroup, SELECTOR_LINK_ITEMS)) {
                            item.classList.add(CLASS_NAME_ACTIVE$1);
                        }
                    }
                }
                _clearActiveClass(parent) {
                    parent.classList.remove(CLASS_NAME_ACTIVE$1);
                    const activeNodes = SelectorEngine.find(`${SELECTOR_TARGET_LINKS}.${CLASS_NAME_ACTIVE$1}`, parent);
                    for (const node of activeNodes) {
                        node.classList.remove(CLASS_NAME_ACTIVE$1);
                    }
                }
                static jQueryInterface(config) {
                    return this.each((function() {
                        const data = ScrollSpy.getOrCreateInstance(this, config);
                        if (typeof config !== "string") {
                            return;
                        }
                        if (data[config] === undefined || config.startsWith("_") || config === "constructor") {
                            throw new TypeError(`No method named "${config}"`);
                        }
                        data[config]();
                    }));
                }
            }
            EventHandler.on(window, EVENT_LOAD_DATA_API$1, (() => {
                for (const spy of SelectorEngine.find(SELECTOR_DATA_SPY)) {
                    ScrollSpy.getOrCreateInstance(spy);
                }
            }));
            defineJQueryPlugin(ScrollSpy);
            const NAME$1 = "tab";
            const DATA_KEY$1 = "bs.tab";
            const EVENT_KEY$1 = `.${DATA_KEY$1}`;
            const EVENT_HIDE$1 = `hide${EVENT_KEY$1}`;
            const EVENT_HIDDEN$1 = `hidden${EVENT_KEY$1}`;
            const EVENT_SHOW$1 = `show${EVENT_KEY$1}`;
            const EVENT_SHOWN$1 = `shown${EVENT_KEY$1}`;
            const EVENT_CLICK_DATA_API = `click${EVENT_KEY$1}`;
            const EVENT_KEYDOWN = `keydown${EVENT_KEY$1}`;
            const EVENT_LOAD_DATA_API = `load${EVENT_KEY$1}`;
            const ARROW_LEFT_KEY = "ArrowLeft";
            const ARROW_RIGHT_KEY = "ArrowRight";
            const ARROW_UP_KEY = "ArrowUp";
            const ARROW_DOWN_KEY = "ArrowDown";
            const CLASS_NAME_ACTIVE = "active";
            const CLASS_NAME_FADE$1 = "fade";
            const CLASS_NAME_SHOW$1 = "show";
            const CLASS_DROPDOWN = "dropdown";
            const SELECTOR_DROPDOWN_TOGGLE = ".dropdown-toggle";
            const SELECTOR_DROPDOWN_MENU = ".dropdown-menu";
            const SELECTOR_DROPDOWN_ITEM = ".dropdown-item";
            const NOT_SELECTOR_DROPDOWN_TOGGLE = ":not(.dropdown-toggle)";
            const SELECTOR_TAB_PANEL = '.list-group, .nav, [role="tablist"]';
            const SELECTOR_OUTER = ".nav-item, .list-group-item";
            const SELECTOR_INNER = `.nav-link${NOT_SELECTOR_DROPDOWN_TOGGLE}, .list-group-item${NOT_SELECTOR_DROPDOWN_TOGGLE}, [role="tab"]${NOT_SELECTOR_DROPDOWN_TOGGLE}`;
            const SELECTOR_DATA_TOGGLE = '[data-bs-toggle="tab"], [data-bs-toggle="pill"], [data-bs-toggle="list"]';
            const SELECTOR_INNER_ELEM = `${SELECTOR_INNER}, ${SELECTOR_DATA_TOGGLE}`;
            const SELECTOR_DATA_TOGGLE_ACTIVE = `.${CLASS_NAME_ACTIVE}[data-bs-toggle="tab"], .${CLASS_NAME_ACTIVE}[data-bs-toggle="pill"], .${CLASS_NAME_ACTIVE}[data-bs-toggle="list"]`;
            class Tab extends BaseComponent {
                constructor(element) {
                    super(element);
                    this._parent = this._element.closest(SELECTOR_TAB_PANEL);
                    if (!this._parent) {
                        return;
                    }
                    this._setInitialAttributes(this._parent, this._getChildren());
                    EventHandler.on(this._element, EVENT_KEYDOWN, (event => this._keydown(event)));
                }
                static get NAME() {
                    return NAME$1;
                }
                show() {
                    const innerElem = this._element;
                    if (this._elemIsActive(innerElem)) {
                        return;
                    }
                    const active = this._getActiveElem();
                    const hideEvent = active ? EventHandler.trigger(active, EVENT_HIDE$1, {
                        relatedTarget: innerElem
                    }) : null;
                    const showEvent = EventHandler.trigger(innerElem, EVENT_SHOW$1, {
                        relatedTarget: active
                    });
                    if (showEvent.defaultPrevented || hideEvent && hideEvent.defaultPrevented) {
                        return;
                    }
                    this._deactivate(active, innerElem);
                    this._activate(innerElem, active);
                }
                _activate(element, relatedElem) {
                    if (!element) {
                        return;
                    }
                    element.classList.add(CLASS_NAME_ACTIVE);
                    this._activate(getElementFromSelector(element));
                    const complete = () => {
                        if (element.getAttribute("role") !== "tab") {
                            element.classList.add(CLASS_NAME_SHOW$1);
                            return;
                        }
                        element.focus();
                        element.removeAttribute("tabindex");
                        element.setAttribute("aria-selected", true);
                        this._toggleDropDown(element, true);
                        EventHandler.trigger(element, EVENT_SHOWN$1, {
                            relatedTarget: relatedElem
                        });
                    };
                    this._queueCallback(complete, element, element.classList.contains(CLASS_NAME_FADE$1));
                }
                _deactivate(element, relatedElem) {
                    if (!element) {
                        return;
                    }
                    element.classList.remove(CLASS_NAME_ACTIVE);
                    element.blur();
                    this._deactivate(getElementFromSelector(element));
                    const complete = () => {
                        if (element.getAttribute("role") !== "tab") {
                            element.classList.remove(CLASS_NAME_SHOW$1);
                            return;
                        }
                        element.setAttribute("aria-selected", false);
                        element.setAttribute("tabindex", "-1");
                        this._toggleDropDown(element, false);
                        EventHandler.trigger(element, EVENT_HIDDEN$1, {
                            relatedTarget: relatedElem
                        });
                    };
                    this._queueCallback(complete, element, element.classList.contains(CLASS_NAME_FADE$1));
                }
                _keydown(event) {
                    if (![ ARROW_LEFT_KEY, ARROW_RIGHT_KEY, ARROW_UP_KEY, ARROW_DOWN_KEY ].includes(event.key)) {
                        return;
                    }
                    event.stopPropagation();
                    event.preventDefault();
                    const isNext = [ ARROW_RIGHT_KEY, ARROW_DOWN_KEY ].includes(event.key);
                    const nextActiveElement = getNextActiveElement(this._getChildren().filter((element => !isDisabled(element))), event.target, isNext, true);
                    if (nextActiveElement) {
                        Tab.getOrCreateInstance(nextActiveElement).show();
                    }
                }
                _getChildren() {
                    return SelectorEngine.find(SELECTOR_INNER_ELEM, this._parent);
                }
                _getActiveElem() {
                    return this._getChildren().find((child => this._elemIsActive(child))) || null;
                }
                _setInitialAttributes(parent, children) {
                    this._setAttributeIfNotExists(parent, "role", "tablist");
                    for (const child of children) {
                        this._setInitialAttributesOnChild(child);
                    }
                }
                _setInitialAttributesOnChild(child) {
                    child = this._getInnerElement(child);
                    const isActive = this._elemIsActive(child);
                    const outerElem = this._getOuterElement(child);
                    child.setAttribute("aria-selected", isActive);
                    if (outerElem !== child) {
                        this._setAttributeIfNotExists(outerElem, "role", "presentation");
                    }
                    if (!isActive) {
                        child.setAttribute("tabindex", "-1");
                    }
                    this._setAttributeIfNotExists(child, "role", "tab");
                    this._setInitialAttributesOnTargetPanel(child);
                }
                _setInitialAttributesOnTargetPanel(child) {
                    const target = getElementFromSelector(child);
                    if (!target) {
                        return;
                    }
                    this._setAttributeIfNotExists(target, "role", "tabpanel");
                    if (child.id) {
                        this._setAttributeIfNotExists(target, "aria-labelledby", `#${child.id}`);
                    }
                }
                _toggleDropDown(element, open) {
                    const outerElem = this._getOuterElement(element);
                    if (!outerElem.classList.contains(CLASS_DROPDOWN)) {
                        return;
                    }
                    const toggle = (selector, className) => {
                        const element = SelectorEngine.findOne(selector, outerElem);
                        if (element) {
                            element.classList.toggle(className, open);
                        }
                    };
                    toggle(SELECTOR_DROPDOWN_TOGGLE, CLASS_NAME_ACTIVE);
                    toggle(SELECTOR_DROPDOWN_MENU, CLASS_NAME_SHOW$1);
                    toggle(SELECTOR_DROPDOWN_ITEM, CLASS_NAME_ACTIVE);
                    outerElem.setAttribute("aria-expanded", open);
                }
                _setAttributeIfNotExists(element, attribute, value) {
                    if (!element.hasAttribute(attribute)) {
                        element.setAttribute(attribute, value);
                    }
                }
                _elemIsActive(elem) {
                    return elem.classList.contains(CLASS_NAME_ACTIVE);
                }
                _getInnerElement(elem) {
                    return elem.matches(SELECTOR_INNER_ELEM) ? elem : SelectorEngine.findOne(SELECTOR_INNER_ELEM, elem);
                }
                _getOuterElement(elem) {
                    return elem.closest(SELECTOR_OUTER) || elem;
                }
                static jQueryInterface(config) {
                    return this.each((function() {
                        const data = Tab.getOrCreateInstance(this);
                        if (typeof config !== "string") {
                            return;
                        }
                        if (data[config] === undefined || config.startsWith("_") || config === "constructor") {
                            throw new TypeError(`No method named "${config}"`);
                        }
                        data[config]();
                    }));
                }
            }
            EventHandler.on(document, EVENT_CLICK_DATA_API, SELECTOR_DATA_TOGGLE, (function(event) {
                if ([ "A", "AREA" ].includes(this.tagName)) {
                    event.preventDefault();
                }
                if (isDisabled(this)) {
                    return;
                }
                Tab.getOrCreateInstance(this).show();
            }));
            EventHandler.on(window, EVENT_LOAD_DATA_API, (() => {
                for (const element of SelectorEngine.find(SELECTOR_DATA_TOGGLE_ACTIVE)) {
                    Tab.getOrCreateInstance(element);
                }
            }));
            defineJQueryPlugin(Tab);
            const NAME = "toast";
            const DATA_KEY = "bs.toast";
            const EVENT_KEY = `.${DATA_KEY}`;
            const EVENT_MOUSEOVER = `mouseover${EVENT_KEY}`;
            const EVENT_MOUSEOUT = `mouseout${EVENT_KEY}`;
            const EVENT_FOCUSIN = `focusin${EVENT_KEY}`;
            const EVENT_FOCUSOUT = `focusout${EVENT_KEY}`;
            const EVENT_HIDE = `hide${EVENT_KEY}`;
            const EVENT_HIDDEN = `hidden${EVENT_KEY}`;
            const EVENT_SHOW = `show${EVENT_KEY}`;
            const EVENT_SHOWN = `shown${EVENT_KEY}`;
            const CLASS_NAME_FADE = "fade";
            const CLASS_NAME_HIDE = "hide";
            const CLASS_NAME_SHOW = "show";
            const CLASS_NAME_SHOWING = "showing";
            const DefaultType = {
                animation: "boolean",
                autohide: "boolean",
                delay: "number"
            };
            const Default = {
                animation: true,
                autohide: true,
                delay: 5e3
            };
            class Toast extends BaseComponent {
                constructor(element, config) {
                    super(element, config);
                    this._timeout = null;
                    this._hasMouseInteraction = false;
                    this._hasKeyboardInteraction = false;
                    this._setListeners();
                }
                static get Default() {
                    return Default;
                }
                static get DefaultType() {
                    return DefaultType;
                }
                static get NAME() {
                    return NAME;
                }
                show() {
                    const showEvent = EventHandler.trigger(this._element, EVENT_SHOW);
                    if (showEvent.defaultPrevented) {
                        return;
                    }
                    this._clearTimeout();
                    if (this._config.animation) {
                        this._element.classList.add(CLASS_NAME_FADE);
                    }
                    const complete = () => {
                        this._element.classList.remove(CLASS_NAME_SHOWING);
                        EventHandler.trigger(this._element, EVENT_SHOWN);
                        this._maybeScheduleHide();
                    };
                    this._element.classList.remove(CLASS_NAME_HIDE);
                    reflow(this._element);
                    this._element.classList.add(CLASS_NAME_SHOW, CLASS_NAME_SHOWING);
                    this._queueCallback(complete, this._element, this._config.animation);
                }
                hide() {
                    if (!this.isShown()) {
                        return;
                    }
                    const hideEvent = EventHandler.trigger(this._element, EVENT_HIDE);
                    if (hideEvent.defaultPrevented) {
                        return;
                    }
                    const complete = () => {
                        this._element.classList.add(CLASS_NAME_HIDE);
                        this._element.classList.remove(CLASS_NAME_SHOWING, CLASS_NAME_SHOW);
                        EventHandler.trigger(this._element, EVENT_HIDDEN);
                    };
                    this._element.classList.add(CLASS_NAME_SHOWING);
                    this._queueCallback(complete, this._element, this._config.animation);
                }
                dispose() {
                    this._clearTimeout();
                    if (this.isShown()) {
                        this._element.classList.remove(CLASS_NAME_SHOW);
                    }
                    super.dispose();
                }
                isShown() {
                    return this._element.classList.contains(CLASS_NAME_SHOW);
                }
                _maybeScheduleHide() {
                    if (!this._config.autohide) {
                        return;
                    }
                    if (this._hasMouseInteraction || this._hasKeyboardInteraction) {
                        return;
                    }
                    this._timeout = setTimeout((() => {
                        this.hide();
                    }), this._config.delay);
                }
                _onInteraction(event, isInteracting) {
                    switch (event.type) {
                      case "mouseover":
                      case "mouseout":
                        this._hasMouseInteraction = isInteracting;
                        break;

                      case "focusin":
                      case "focusout":
                        this._hasKeyboardInteraction = isInteracting;
                        break;
                    }
                    if (isInteracting) {
                        this._clearTimeout();
                        return;
                    }
                    const nextElement = event.relatedTarget;
                    if (this._element === nextElement || this._element.contains(nextElement)) {
                        return;
                    }
                    this._maybeScheduleHide();
                }
                _setListeners() {
                    EventHandler.on(this._element, EVENT_MOUSEOVER, (event => this._onInteraction(event, true)));
                    EventHandler.on(this._element, EVENT_MOUSEOUT, (event => this._onInteraction(event, false)));
                    EventHandler.on(this._element, EVENT_FOCUSIN, (event => this._onInteraction(event, true)));
                    EventHandler.on(this._element, EVENT_FOCUSOUT, (event => this._onInteraction(event, false)));
                }
                _clearTimeout() {
                    clearTimeout(this._timeout);
                    this._timeout = null;
                }
                static jQueryInterface(config) {
                    return this.each((function() {
                        const data = Toast.getOrCreateInstance(this, config);
                        if (typeof config === "string") {
                            if (typeof data[config] === "undefined") {
                                throw new TypeError(`No method named "${config}"`);
                            }
                            data[config](this);
                        }
                    }));
                }
            }
            enableDismissTrigger(Toast);
            defineJQueryPlugin(Toast);
        },
        "../node_modules/domready/ready.js": function(module) {
            !function(name, definition) {
                if (true) module.exports = definition(); else {}
            }("domready", (function() {
                var fns = [], listener, doc = document, hack = doc.documentElement.doScroll, domContentLoaded = "DOMContentLoaded", loaded = (hack ? /^loaded|^c/ : /^loaded|^i|^c/).test(doc.readyState);
                if (!loaded) doc.addEventListener(domContentLoaded, listener = function() {
                    doc.removeEventListener(domContentLoaded, listener);
                    loaded = 1;
                    while (listener = fns.shift()) listener();
                });
                return function(fn) {
                    loaded ? setTimeout(fn, 0) : fns.push(fn);
                };
            }));
        },
        "../node_modules/hoverintent/index.js": function(module) {
            "use strict";
            module.exports = function(el, onOver, onOut) {
                var x, y, pX, pY;
                var mouseOver = false;
                var focused = false;
                var h = {}, state = 0, timer = 0;
                var options = {
                    sensitivity: 7,
                    interval: 100,
                    timeout: 0,
                    handleFocus: false
                };
                function delay(el, e) {
                    if (timer) timer = clearTimeout(timer);
                    state = 0;
                    return focused ? undefined : onOut.call(el, e);
                }
                function tracker(e) {
                    x = e.clientX;
                    y = e.clientY;
                }
                function compare(el, e) {
                    if (timer) timer = clearTimeout(timer);
                    if (Math.abs(pX - x) + Math.abs(pY - y) < options.sensitivity) {
                        state = 1;
                        return focused ? undefined : onOver.call(el, e);
                    } else {
                        pX = x;
                        pY = y;
                        timer = setTimeout((function() {
                            compare(el, e);
                        }), options.interval);
                    }
                }
                h.options = function(opt) {
                    var focusOptionChanged = opt.handleFocus !== options.handleFocus;
                    options = Object.assign({}, options, opt);
                    if (focusOptionChanged) {
                        options.handleFocus ? addFocus() : removeFocus();
                    }
                    return h;
                };
                function dispatchOver(e) {
                    mouseOver = true;
                    if (timer) timer = clearTimeout(timer);
                    el.removeEventListener("mousemove", tracker, false);
                    if (state !== 1) {
                        pX = e.clientX;
                        pY = e.clientY;
                        el.addEventListener("mousemove", tracker, false);
                        timer = setTimeout((function() {
                            compare(el, e);
                        }), options.interval);
                    }
                    return this;
                }
                function dispatchOut(e) {
                    mouseOver = false;
                    if (timer) timer = clearTimeout(timer);
                    el.removeEventListener("mousemove", tracker, false);
                    if (state === 1) {
                        timer = setTimeout((function() {
                            delay(el, e);
                        }), options.timeout);
                    }
                    return this;
                }
                function dispatchFocus(e) {
                    if (!mouseOver) {
                        focused = true;
                        onOver.call(el, e);
                    }
                }
                function dispatchBlur(e) {
                    if (!mouseOver && focused) {
                        focused = false;
                        onOut.call(el, e);
                    }
                }
                function addFocus() {
                    el.addEventListener("focus", dispatchFocus, false);
                    el.addEventListener("blur", dispatchBlur, false);
                }
                function removeFocus() {
                    el.removeEventListener("focus", dispatchFocus, false);
                    el.removeEventListener("blur", dispatchBlur, false);
                }
                h.remove = function() {
                    if (!el) return;
                    el.removeEventListener("mouseover", dispatchOver, false);
                    el.removeEventListener("mouseout", dispatchOut, false);
                    removeFocus();
                };
                if (el) {
                    el.addEventListener("mouseover", dispatchOver, false);
                    el.addEventListener("mouseout", dispatchOut, false);
                }
                return h;
            };
        },
        "./js/vendor/bootstrap/dropdown.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                Dropdown: function() {
                    return bootstrap__WEBPACK_IMPORTED_MODULE_1__.Dropdown;
                },
                initDropDown: function() {
                    return initDropDown;
                }
            });
            var hoverintent__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/hoverintent/index.js");
            var hoverintent__WEBPACK_IMPORTED_MODULE_0___default = __webpack_require__.n(hoverintent__WEBPACK_IMPORTED_MODULE_0__);
            var bootstrap__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/bootstrap/dist/js/bootstrap.esm.js");
            const CLASS_NAME = "has-child-dropdown-show";
            function focusIn(event) {
                if (event.type === "focus" || event.type === "focusin") {
                    let self = event.target;
                    if (self.hasAttribute("data-bs-toggle")) {
                        self.classList.add("focus");
                    }
                    while (!self.classList.contains("menu")) {
                        if ("li" === self.tagName.toLowerCase()) {
                            self.classList.add("focus");
                        }
                        self = self.parentNode;
                    }
                }
            }
            function focusOut(event) {
                if (event.type === "blur" || event.type === "focusout") {
                    let self = event.target;
                    while (!self.classList.contains("menu")) {
                        if ("li" === self.tagName.toLowerCase()) {
                            self.classList.remove("focus");
                        }
                        self = self.parentNode;
                    }
                }
            }
            function openSubMenu(event) {
                const elem = event.target;
                const parent = "li" !== elem.tagName.toLowerCase() ? elem.closest(".dropdown") : elem;
                const toggle = "button" !== elem.tagName.toLowerCase() ? parent.querySelector(':scope>[data-bs-toggle="dropdown"]') : elem;
                const target = parent.querySelector(":scope>.dropdown-menu");
                if (!target.classList.contains("show")) {
                    bootstrap__WEBPACK_IMPORTED_MODULE_1__.Dropdown.getOrCreateInstance(toggle).toggle();
                    parent.classList.add(CLASS_NAME);
                    bootstrap__WEBPACK_IMPORTED_MODULE_1__.Dropdown.clearMenus(event);
                }
            }
            function closeSubMenu(event) {
                const elem = event.target;
                const parent = "li" !== elem.tagName.toLowerCase() ? elem.closest(".dropdown") : elem;
                const toggle = "button" !== elem.tagName.toLowerCase() ? parent.querySelector(':scope>[data-bs-toggle="dropdown"]') : elem;
                const target = parent.querySelector(":scope>.dropdown-menu");
                if (target.classList.contains("show")) {
                    bootstrap__WEBPACK_IMPORTED_MODULE_1__.Dropdown.getOrCreateInstance(toggle).toggle();
                    parent.classList.remove(CLASS_NAME);
                }
            }
            function addToggleFocus() {
                const links = document.querySelectorAll("li:not(.has-children) > .menu-link");
                links.forEach((link => {
                    link.addEventListener("focus", focusIn, true);
                    link.addEventListener("blur", focusOut, true);
                }));
                const toggles = document.querySelectorAll(".menu-toggle");
                toggles.forEach((toggle => {
                    rwp.listen(toggle, "focus", openSubMenu, true);
                }));
            }
            function initDropDown() {
                bootstrap__WEBPACK_IMPORTED_MODULE_1__.Dropdown.prototype.toggle = function(_orginal) {
                    return function() {
                        document.querySelectorAll("." + CLASS_NAME).forEach((function(e) {
                            e.classList.remove(CLASS_NAME);
                        }));
                        let dd = this._element.closest(".dropdown").parentNode.closest(".dropdown");
                        for (;dd && dd !== document; dd = dd.parentNode.closest(".dropdown")) {
                            dd.classList.add(CLASS_NAME);
                        }
                        return _orginal.call(this);
                    };
                }(bootstrap__WEBPACK_IMPORTED_MODULE_1__.Dropdown.prototype.toggle);
                document.querySelectorAll(".dropdown").forEach((function(dd) {
                    dd.addEventListener("hide.bs.dropdown", (function(e) {
                        if (this.classList.contains(CLASS_NAME)) {
                            this.classList.remove(CLASS_NAME);
                            e.preventDefault();
                        }
                        e.stopPropagation();
                    }));
                }));
                document.querySelectorAll(".dropdown-hover, .dropdown-hover-all .dropdown").forEach((function(dd) {
                    const parent = dd;
                    hoverintent__WEBPACK_IMPORTED_MODULE_0__(dd, (function(e) {
                        parent.classList.add("hover");
                        openSubMenu(e);
                    }), (function(e) {
                        parent.classList.remove("hover");
                        closeSubMenu(e);
                    })).options({
                        timeout: 300,
                        interval: 200,
                        sensitivity: 10
                    });
                }));
                addToggleFocus();
            }
        },
        jquery: function(module) {
            "use strict";
            module.exports = jQuery;
        }
    };
    var __webpack_module_cache__ = {};
    function __webpack_require__(moduleId) {
        var cachedModule = __webpack_module_cache__[moduleId];
        if (cachedModule !== undefined) {
            return cachedModule.exports;
        }
        var module = __webpack_module_cache__[moduleId] = {
            exports: {}
        };
        __webpack_modules__[moduleId](module, module.exports, __webpack_require__);
        return module.exports;
    }
    !function() {
        __webpack_require__.n = function(module) {
            var getter = module && module.__esModule ? function() {
                return module["default"];
            } : function() {
                return module;
            };
            __webpack_require__.d(getter, {
                a: getter
            });
            return getter;
        };
    }();
    !function() {
        __webpack_require__.d = function(exports, definition) {
            for (var key in definition) {
                if (__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
                    Object.defineProperty(exports, key, {
                        enumerable: true,
                        get: definition[key]
                    });
                }
            }
        };
    }();
    !function() {
        __webpack_require__.o = function(obj, prop) {
            return Object.prototype.hasOwnProperty.call(obj, prop);
        };
    }();
    !function() {
        __webpack_require__.r = function(exports) {
            if (typeof Symbol !== "undefined" && Symbol.toStringTag) {
                Object.defineProperty(exports, Symbol.toStringTag, {
                    value: "Module"
                });
            }
            Object.defineProperty(exports, "__esModule", {
                value: true
            });
        };
    }();
    var __webpack_exports__ = {};
    !function() {
        "use strict";
        var __webpack_exports__ = {};
        __webpack_require__.r(__webpack_exports__);
    }();
    !function() {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
        var domready__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/domready/ready.js");
        var domready__WEBPACK_IMPORTED_MODULE_0___default = __webpack_require__.n(domready__WEBPACK_IMPORTED_MODULE_0__);
        var _bootstrap_dropdown__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("./js/vendor/bootstrap/dropdown.js");
        var bootstrap = __webpack_require__("../node_modules/bootstrap/dist/js/bootstrap.esm.js");
        Promise.resolve().then(__webpack_require__.bind(__webpack_require__, "../node_modules/bootstrap/dist/js/bootstrap.esm.js"));
        domready__WEBPACK_IMPORTED_MODULE_0___default()(_bootstrap_dropdown__WEBPACK_IMPORTED_MODULE_1__.initDropDown);
        domready__WEBPACK_IMPORTED_MODULE_0___default()((function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map((function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            }));
        }));
    }();
})();
//# sourceMappingURL=rwp-bootstrap.js.map