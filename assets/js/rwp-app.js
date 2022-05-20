(function() {
    var __webpack_modules__ = {
        "../node_modules/actual/actual.js": function(module) {
            !function(root, name, make) {
                if (true && module.exports) module.exports = make(); else root[name] = make();
            }(this, "actual", (function() {
                function actual(feature, unit, init, step) {
                    var up, gte, lte, curr, mq = actual["mq"];
                    unit = typeof unit == "string" ? unit : "";
                    init = 0 < init ? unit ? +init : init >> 0 : 1;
                    step = 0 < step ? +step : 0 > step ? -step : "px" == unit ? 256 : unit ? 32 : 1;
                    for (feature += ":", unit += ")", curr = init; step && 0 <= curr; curr += step) {
                        lte = mq("(min-" + feature + curr + unit);
                        gte = mq("(max-" + feature + curr + unit);
                        if (lte && gte) return mq("(" + feature + (curr >> 0) + unit) ? curr >> 0 : curr;
                        if (null == up) step = (up = !gte) ? lte && step : -step; else if (gte ? up : !up) up = !up, 
                        step = -step / 2;
                    }
                    return 0;
                }
                function as(unit) {
                    return function(feature) {
                        return actual(feature, unit);
                    };
                }
                var media = "matchMedia", win = typeof window != "undefined" && window;
                actual["actual"] = actual;
                actual["as"] = as;
                actual["is"] = actual["mq"] = win[media] || win[media = "msMatchMedia"] ? function(q) {
                    return !!win[media](q).matches;
                } : function() {
                    return false;
                };
                return actual;
            }));
        },
        "../node_modules/verge/verge.js": function(module) {
            !function(root, name, make) {
                if (true && module["exports"]) module["exports"] = make(); else root[name] = make();
            }(this, "verge", (function() {
                var xports = {}, win = typeof window != "undefined" && window, doc = typeof document != "undefined" && document, docElem = doc && doc.documentElement, matchMedia = win["matchMedia"] || win["msMatchMedia"], mq = matchMedia ? function(q) {
                    return !!matchMedia.call(win, q).matches;
                } : function() {
                    return false;
                }, viewportW = xports["viewportW"] = function() {
                    var a = docElem["clientWidth"], b = win["innerWidth"];
                    return a < b ? b : a;
                }, viewportH = xports["viewportH"] = function() {
                    var a = docElem["clientHeight"], b = win["innerHeight"];
                    return a < b ? b : a;
                };
                xports["mq"] = mq;
                xports["matchMedia"] = matchMedia ? function() {
                    return matchMedia.apply(win, arguments);
                } : function() {
                    return {};
                };
                function viewport() {
                    return {
                        width: viewportW(),
                        height: viewportH()
                    };
                }
                xports["viewport"] = viewport;
                xports["scrollX"] = function() {
                    return win.pageXOffset || docElem.scrollLeft;
                };
                xports["scrollY"] = function() {
                    return win.pageYOffset || docElem.scrollTop;
                };
                function calibrate(coords, cushion) {
                    var o = {};
                    cushion = +cushion || 0;
                    o["width"] = (o["right"] = coords["right"] + cushion) - (o["left"] = coords["left"] - cushion);
                    o["height"] = (o["bottom"] = coords["bottom"] + cushion) - (o["top"] = coords["top"] - cushion);
                    return o;
                }
                function rectangle(el, cushion) {
                    el = el && !el.nodeType ? el[0] : el;
                    if (!el || 1 !== el.nodeType) return false;
                    return calibrate(el.getBoundingClientRect(), cushion);
                }
                xports["rectangle"] = rectangle;
                function aspect(o) {
                    o = null == o ? viewport() : 1 === o.nodeType ? rectangle(o) : o;
                    var h = o["height"], w = o["width"];
                    h = typeof h == "function" ? h.call(o) : h;
                    w = typeof w == "function" ? w.call(o) : w;
                    return w / h;
                }
                xports["aspect"] = aspect;
                xports["inX"] = function(el, cushion) {
                    var r = rectangle(el, cushion);
                    return !!r && r.right >= 0 && r.left <= viewportW();
                };
                xports["inY"] = function(el, cushion) {
                    var r = rectangle(el, cushion);
                    return !!r && r.bottom >= 0 && r.top <= viewportH();
                };
                xports["inViewport"] = function(el, cushion) {
                    var r = rectangle(el, cushion);
                    return !!r && r.bottom >= 0 && r.right >= 0 && r.top <= viewportH() && r.left <= viewportW();
                };
                return xports;
            }));
        },
        "../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _arrayLikeToArray;
                }
            });
            function _arrayLikeToArray(arr, len) {
                if (len == null || len > arr.length) len = arr.length;
                for (var i = 0, arr2 = new Array(len); i < len; i++) {
                    arr2[i] = arr[i];
                }
                return arr2;
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _arrayWithHoles;
                }
            });
            function _arrayWithHoles(arr) {
                if (Array.isArray(arr)) return arr;
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _arrayWithoutHoles;
                }
            });
            var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js");
            function _arrayWithoutHoles(arr) {
                if (Array.isArray(arr)) return (0, _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(arr);
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/defineProperty.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _defineProperty;
                }
            });
            function _defineProperty(obj, key, value) {
                if (key in obj) {
                    Object.defineProperty(obj, key, {
                        value,
                        enumerable: true,
                        configurable: true,
                        writable: true
                    });
                } else {
                    obj[key] = value;
                }
                return obj;
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/iterableToArray.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _iterableToArray;
                }
            });
            function _iterableToArray(iter) {
                if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _iterableToArrayLimit;
                }
            });
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
        },
        "../node_modules/@babel/runtime/helpers/esm/nonIterableRest.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _nonIterableRest;
                }
            });
            function _nonIterableRest() {
                throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _nonIterableSpread;
                }
            });
            function _nonIterableSpread() {
                throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/slicedToArray.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _slicedToArray;
                }
            });
            var _arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js");
            var _iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js");
            var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js");
            var _nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/nonIterableRest.js");
            function _slicedToArray(arr, i) {
                return (0, _arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__["default"])(arr) || (0, 
                _iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__["default"])(arr, i) || (0, 
                _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__["default"])(arr, i) || (0, 
                _nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/toConsumableArray.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _toConsumableArray;
                }
            });
            var _arrayWithoutHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js");
            var _iterableToArray_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/iterableToArray.js");
            var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js");
            var _nonIterableSpread_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js");
            function _toConsumableArray(arr) {
                return (0, _arrayWithoutHoles_js__WEBPACK_IMPORTED_MODULE_0__["default"])(arr) || (0, 
                _iterableToArray_js__WEBPACK_IMPORTED_MODULE_1__["default"])(arr) || (0, _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__["default"])(arr) || (0, 
                _nonIterableSpread_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _unsupportedIterableToArray;
                }
            });
            var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js");
            function _unsupportedIterableToArray(o, minLen) {
                if (!o) return;
                if (typeof o === "string") return (0, _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(o, minLen);
                var n = Object.prototype.toString.call(o).slice(8, -1);
                if (n === "Object" && o.constructor) n = o.constructor.name;
                if (n === "Map" || n === "Set") return Array.from(o);
                if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return (0, 
                _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(o, minLen);
            }
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
        __webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
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
        __webpack_require__.r(__webpack_exports__);
        __webpack_require__.d(__webpack_exports__, {
            bsAtts: function() {
                return bsAtts;
            },
            camelCase: function() {
                return camelCase;
            },
            changeTag: function() {
                return changeTag;
            },
            eventFire: function() {
                return eventFire;
            },
            extend: function() {
                return extend;
            },
            filterPath: function() {
                return filterPath;
            },
            get: function() {
                return get;
            },
            getBootstrapBP: function() {
                return getBootstrapBP;
            },
            getBootstrapVar: function() {
                return getBootstrapVar;
            },
            getHash: function() {
                return getHash;
            },
            getTag: function() {
                return getTag;
            },
            getTallest: function() {
                return getTallest;
            },
            getWidest: function() {
                return getWidest;
            },
            has: function() {
                return has;
            },
            isBootstrapBP: function() {
                return isBootstrapBP;
            },
            isEmpty: function() {
                return isEmpty;
            },
            isReduced: function() {
                return isReduced;
            },
            listen: function() {
                return listen;
            },
            logCustomProperties: function() {
                return logCustomProperties;
            },
            matchHeights: function() {
                return matchHeights;
            },
            matchWidths: function() {
                return matchWidths;
            },
            noBubbles: function() {
                return noBubbles;
            },
            noDefault: function() {
                return noDefault;
            },
            omit: function() {
                return omit;
            },
            screenSize: function() {
                return screenSize;
            },
            sortObjectByKeys: function() {
                return sortObjectByKeys;
            },
            stringToHtml: function() {
                return stringToHtml;
            },
            unwrapElement: function() {
                return unwrapElement;
            },
            wrapElement: function() {
                return wrapElement;
            }
        });
        var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/slicedToArray.js");
        var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/toConsumableArray.js");
        var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/defineProperty.js");
        var actual__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/actual/actual.js");
        var actual__WEBPACK_IMPORTED_MODULE_3___default = __webpack_require__.n(actual__WEBPACK_IMPORTED_MODULE_3__);
        var verge__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/verge/verge.js");
        var verge__WEBPACK_IMPORTED_MODULE_4___default = __webpack_require__.n(verge__WEBPACK_IMPORTED_MODULE_4__);
        var __WEBPACK_REEXPORT_OBJECT__ = {};
        for (var __WEBPACK_IMPORT_KEY__ in verge__WEBPACK_IMPORTED_MODULE_4__) if ([ "default", "isReduced", "has", "eventFire", "listen", "noDefault", "noBubbles", "extend", "get", "isEmpty", "omit", "getTag", "camelCase", "changeTag", "stringToHtml", "wrapElement", "unwrapElement", "screenSize", "filterPath", "getHash", "getTallest", "matchHeights", "getWidest", "matchWidths", "bsAtts", "getBootstrapVar", "getBootstrapBP", "isBootstrapBP", "sortObjectByKeys", "logCustomProperties" ].indexOf(__WEBPACK_IMPORT_KEY__) < 0) __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = function(key) {
            return verge__WEBPACK_IMPORTED_MODULE_4__[key];
        }.bind(0, __WEBPACK_IMPORT_KEY__);
        __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);
        function ownKeys(object, enumerableOnly) {
            var keys = Object.keys(object);
            if (Object.getOwnPropertySymbols) {
                var symbols = Object.getOwnPropertySymbols(object);
                enumerableOnly && (symbols = symbols.filter((function(sym) {
                    return Object.getOwnPropertyDescriptor(object, sym).enumerable;
                }))), keys.push.apply(keys, symbols);
            }
            return keys;
        }
        function _objectSpread(target) {
            for (var i = 1; i < arguments.length; i++) {
                var source = null != arguments[i] ? arguments[i] : {};
                i % 2 ? ownKeys(Object(source), !0).forEach((function(key) {
                    (0, _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_2__["default"])(target, key, source[key]);
                })) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach((function(key) {
                    Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
                }));
            }
            return target;
        }
        var isReduced = window.matchMedia("(prefers-reduced-motion: reduce)") === true || window.matchMedia("(prefers-reduced-motion: reduce)").matches === true;
        function has(obj, path) {
            var pathArray = Array.isArray(path) ? path : path.match(/([^[.\]])+/g);
            return !!pathArray.reduce((function(prevObj, key) {
                return prevObj && prevObj[key];
            }), obj);
        }
        function eventFire(el, etype) {
            if (el.fireEvent) {
                el.fireEvent("on" + etype);
            } else {
                var evObj = document.createEvent("Events");
                evObj.initEvent(etype, true, false);
                el.dispatchEvent(evObj);
            }
        }
        function listen(el, etype, fn, nobubble, stopdefault) {
            nobubble = nobubble || false;
            stopdefault = stopdefault || false;
            var fnwrap = function fnwrap(e) {
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
                el.attachEvent("on" + etype, fnwrap);
            } else {
                el.addEventListener(etype, fnwrap, false);
            }
        }
        function noDefault(e) {
            if (e.preventDefault) {
                e.preventDefault();
            } else {
                e.returnValue = false;
            }
        }
        function noBubbles(e) {
            if (e.stopPropagation) {
                e.stopPropagation();
            } else {
                e.cancelBubble = true;
            }
        }
        function extend() {
            var obj, name, copy, target = arguments[0] || {}, i = 1, length = arguments.length;
            for (;i < length; i++) {
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
        function get(obj, path, defValue) {
            if (!path) return undefined;
            var pathArray = Array.isArray(path) ? path : path.match(/([^[.\]])+/g);
            var result = pathArray.reduce((function(prevObj, key) {
                return prevObj && prevObj[key];
            }), obj);
            return result === undefined ? defValue : result;
        }
        function isEmpty(el) {
            if (el === undefined || el == null) {
                return true;
            }
            if (typeof el === "string" && el.length > 0) {
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
        function omit(obj, props) {
            obj = _objectSpread({}, obj);
            props.forEach((function(prop) {
                return delete obj[prop];
            }));
            return obj;
        }
        function getTag(value) {
            if (value == null) {
                return value === undefined ? "[object Undefined]" : "[object Null]";
            }
            return Object.prototype.toString.call(value);
        }
        function camelCase(str) {
            return "".concat(str.charAt(0).toLowerCase()).concat(str.replace(/[\W_]/g, "|").split("|").map((function(part) {
                return "".concat(part.charAt(0).toUpperCase()).concat(part.slice(1));
            })).join("").slice(1));
        }
        function changeTag(original, tag) {
            var replacement = document.createElement(tag);
            for (var i = 0, l = original.attributes.length; i < l; ++i) {
                var nodeName = original.attributes.item(i).nodeName;
                var nodeValue = original.attributes.item(i).nodeValue;
                replacement.setAttribute(nodeName, nodeValue);
            }
            replacement.innerHTML = original.innerHTML;
            original.parentNode.replaceChild(replacement, original);
            return original;
        }
        var domParserSupport = function() {
            if (!window.DOMParser) return false;
            var parser = new DOMParser;
            try {
                parser.parseFromString("x", "text/html");
            } catch (err) {
                return false;
            }
            return true;
        }();
        function stringToHtml(str) {
            if (domParserSupport) {
                var parser = new DOMParser;
                var doc = parser.parseFromString(str, "text/html");
                return doc.body.firstElementChild;
            }
            var dom = document.createElement("div");
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
        function isNodeList(el) {
            if (typeof el.length === "number" && typeof el.item !== "undefined" && typeof el.entries === "function" && typeof el.forEach === "function" && typeof el.keys === "function" && typeof el.values === "function") {
                if (isElement(el[0])) {
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        }
        function wrapElement(toWrap, wrapper) {
            wrapper = stringToHtml(wrapper);
            var parent;
            if (isNodeList(toWrap) && toWrap.length > 0) {
                parent = toWrap[0].parentNode;
                parent.insertBefore(wrapper, toWrap[0]);
                toWrap.forEach((function(item) {
                    wrapper.appendChild(item);
                }));
            } else {
                parent = toWrap.parentNode;
                parent.insertBefore(wrapper, toWrap);
                wrapper.appendChild(toWrap);
            }
        }
        function unwrapElement(el) {
            var parent = el.parentNode;
            while (el.firstChild) {
                parent.insertBefore(el.firstChild, el);
            }
            parent.removeChild(el);
        }
        function screenSize(prop) {
            var size = {
                width: actual__WEBPACK_IMPORTED_MODULE_3__.actual.actual("width", "px"),
                height: actual__WEBPACK_IMPORTED_MODULE_3__.actual.actual("height", "px")
            };
            window.addEventListener("resize", (function() {
                size.width = actual__WEBPACK_IMPORTED_MODULE_3__.actual.actual("width", "px");
                size.hieght = actual__WEBPACK_IMPORTED_MODULE_3__.actual.actual("height", "px");
            }));
            if (!isEmpty(prop)) {
                return size[prop];
            }
            return size;
        }
        function filterPath(string) {
            return string.replace(/^\//, "").replace(/(index|default).[a-zA-Z]{3,4}$/, "").replace(/\/$/, "");
        }
        function getHash(string) {
            var index = string.indexOf("#");
            if (index !== -1) {
                return string.substring(index + 1);
            }
            return false;
        }
        function getTallest(el) {
            var matches = document.querySelectorAll(el);
            if (matches.length > 1) {
                var heights = matches.map((function(elem) {
                    return elem.offsetHeight;
                }));
                return Math.max.apply(null, heights);
            }
            return false;
        }
        function matchHeights() {
            var elem = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
            var breakpoint = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
            var matches = document.querySelectorAll(elem);
            if (matches.length > 1) {
                if (!isEmpty(breakpoint) && isBootstrapBP(breakpoint) || isEmpty(breakpoint)) {
                    var minHeight = getTallest(elem);
                    if (false !== minHeight) {
                        minHeight += "px";
                        matches.forEach((function(el) {
                            el.style.minHeight = minHeight;
                        }));
                    }
                } else {
                    matches.forEach((function(el) {
                        el.style.removeProperty("minHeight");
                    }));
                }
                window.addEventListener("resize", (function() {
                    matchHeights(elem);
                }));
            }
        }
        function getWidest(el) {
            var matches = document.querySelectorAll(el);
            if (matches.length > 1) {
                var widths = matches.map((function(elem) {
                    return elem.offsetWidth;
                }));
                return Math.max.apply(null, widths);
            }
            return false;
        }
        function matchWidths() {
            var elem = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
            var breakpoint = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;
            var matches = document.querySelectorAll(elem);
            if (matches.length > 1) {
                if (!isEmpty(breakpoint) && isBootstrapBP(breakpoint) || isEmpty(breakpoint)) {
                    var minWidth = getWidest(elem);
                    if (false !== minWidth) {
                        minWidth += "px";
                        matches.forEach((function(el) {
                            el.style.minWidth = minWidth;
                        }));
                    }
                } else {
                    matches.forEach((function(el) {
                        el.style.removeProperty("minWidth");
                    }));
                }
                window.addEventListener("resize", (function() {
                    matchWidths(elem);
                }));
            }
        }
        var isSameDomain = function isSameDomain(styleSheet) {
            if (!styleSheet.href) {
                return true;
            }
            return styleSheet.href.indexOf(window.location.origin) === 0;
        };
        var isStyleRule = function isStyleRule(rule) {
            return rule.type === 1;
        };
        var getCSSCustomPropIndex = function getCSSCustomPropIndex() {
            var index = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "--";
            return (0, _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_1__["default"])(document.styleSheets).filter(isSameDomain).reduce((function(finalArr, sheet) {
                return finalArr.concat((0, _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_1__["default"])(sheet.cssRules).filter(isStyleRule).reduce((function(propValArr, rule) {
                    var props = (0, _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_1__["default"])(rule.style).map((function(propName) {
                        return [ propName.trim(), rule.style.getPropertyValue(propName).trim() ];
                    })).filter((function(_ref) {
                        var _ref2 = (0, _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__["default"])(_ref, 1), propName = _ref2[0];
                        return propName.indexOf(index) === 0;
                    }));
                    return [].concat((0, _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_1__["default"])(propValArr), (0, 
                    _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_1__["default"])(props));
                }), []));
            }), []);
        };
        function bsAtts() {
            var props = getCSSCustomPropIndex("--bs-");
            props = Object.fromEntries(props);
            props = sortObjectByKeys(props);
            return props;
        }
        function getBootstrapVar() {
            var v = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
            var props = bsAtts();
            return get(props, v, false);
        }
        function getBootstrapBP(breakpoint) {
            breakpoint = "--bs-bp-".concat(breakpoint);
            return getBootstrapVar(breakpoint);
        }
        function isBootstrapBP(breakpoint) {
            var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "min-width";
            breakpoint = getBootstrapBP(breakpoint);
            return (0, verge__WEBPACK_IMPORTED_MODULE_4__.mq)("(".concat(type, ": ").concat(breakpoint, ")"));
        }
        function sortObjectByKeys(o) {
            return Object.keys(o).sort().reduce((function(r, k) {
                return r[k] = o[k], r;
            }), {});
        }
        function logCustomProperties() {
            var props = getCSSCustomPropIndex();
            props = Object.fromEntries(props);
            props = sortObjectByKeys(props);
            console.groupCollapsed("Custom CSS Properties");
            console.table(props);
            console.groupEnd();
        }
    }();
    var __webpack_export_target__ = rwp = typeof rwp === "undefined" ? {} : rwp;
    for (var i in __webpack_exports__) __webpack_export_target__[i] = __webpack_exports__[i];
    if (__webpack_exports__.__esModule) Object.defineProperty(__webpack_export_target__, "__esModule", {
        value: true
    });
})();
//# sourceMappingURL=rwp-app.js.map