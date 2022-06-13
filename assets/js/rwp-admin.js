(function() {
    var __webpack_modules__ = {
        "./js/public/common.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var smoothscroll_polyfill__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/smoothscroll-polyfill/dist/smoothscroll.js");
            var smoothscroll_polyfill__WEBPACK_IMPORTED_MODULE_0___default = __webpack_require__.n(smoothscroll_polyfill__WEBPACK_IMPORTED_MODULE_0__);
            var $ = __webpack_require__("jquery");
            rwp = typeof rwp === "undefined" ? {} : rwp;
            __webpack_exports__["default"] = {
                betterHashLinks: function betterHashLinks() {
                    var id = location.hash.substring(1);
                    if (!/^[A-z0-9_-]+$/.test(id)) {
                        return;
                    }
                    var element = document.getElementById(id);
                    if (element) {
                        if (!/^(?:a|select|input|button|textarea)$/i.test(element.tagName)) {
                            element.tabIndex = -1;
                        }
                        if (!rwp.isReduced) {
                            element.scrollIntoView({
                                behavior: "smooth"
                            });
                        }
                        if (element.is(":focus")) {
                            return false;
                        } else {
                            element.attr("tabindex", "-1");
                            element.focus();
                        }
                    }
                },
                resize: function resize() {},
                init: function init() {},
                finalize: function finalize() {
                    (0, smoothscroll_polyfill__WEBPACK_IMPORTED_MODULE_0__.polyfill)();
                    window.addEventListener("click", this.betterHashLinks);
                    $(".screen-full").width(rwp.screenSize("width")).height(rwp.screenSize("height"));
                    $(".screen-width").width(rwp.screenSize("width"));
                    $(".screen-height").height(rwp.screenSize("height"));
                }
            };
        },
        "./js/util/Router.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var _babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/asyncToGenerator.js");
            var _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/classCallCheck.js");
            var _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__("../node_modules/@babel/runtime/helpers/esm/createClass.js");
            var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__("../node_modules/@babel/runtime/regenerator/index.js");
            var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_3___default = __webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_3__);
            var domready__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__("../node_modules/domready/ready.js");
            var domready__WEBPACK_IMPORTED_MODULE_4___default = __webpack_require__.n(domready__WEBPACK_IMPORTED_MODULE_4__);
            function camelCase(str) {
                return "".concat(str.charAt(0).toLowerCase()).concat(str.replace(/[\W_]/g, "|").split("|").map((function(part) {
                    return "".concat(part.charAt(0).toUpperCase()).concat(part.slice(1));
                })).join("").slice(1));
            }
            var Router = function() {
                function Router(routes) {
                    (0, _babel_runtime_helpers_classCallCheck__WEBPACK_IMPORTED_MODULE_1__["default"])(this, Router);
                    this.routes = routes;
                }
                (0, _babel_runtime_helpers_createClass__WEBPACK_IMPORTED_MODULE_2__["default"])(Router, [ {
                    key: "promisedEvent",
                    value: function promisedEvent() {
                        var route = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
                        var eventType = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "";
                        var timeout = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
                        for (var _len = arguments.length, args = new Array(_len > 3 ? _len - 3 : 0), _key = 3; _key < _len; _key++) {
                            args[_key - 3] = arguments[_key];
                        }
                        var event = route[eventType];
                        var listener = function listener() {
                            setTimeout((function() {
                                event.apply(route, args);
                            }), timeout);
                        };
                        return new Promise((function(resolve) {
                            if ("resize" === eventType) {
                                window.addEventListener("resize", listener);
                            } else if ("init" == eventType) {
                                domready__WEBPACK_IMPORTED_MODULE_4___default()(listener);
                            } else if ("finalize" == eventType) {
                                window.addEventListener("load", listener, false);
                            }
                            resolve();
                        }));
                    }
                }, {
                    key: "asyncEvent",
                    value: function() {
                        var _asyncEvent = (0, _babel_runtime_helpers_asyncToGenerator__WEBPACK_IMPORTED_MODULE_0__["default"])(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_3___default().mark((function _callee(route, eventType) {
                            var timeout, _len2, args, _key2, _args = arguments;
                            return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_3___default().wrap((function _callee$(_context) {
                                while (1) {
                                    switch (_context.prev = _context.next) {
                                      case 0:
                                        timeout = 1;
                                        if ("finalize" == eventType) {
                                            timeout = 2e3;
                                        }
                                        for (_len2 = _args.length, args = new Array(_len2 > 2 ? _len2 - 2 : 0), _key2 = 2; _key2 < _len2; _key2++) {
                                            args[_key2 - 2] = _args[_key2];
                                        }
                                        _context.next = 5;
                                        return this.promisedEvent.apply(this, [ route, eventType, timeout ].concat(args));

                                      case 5:
                                      case "end":
                                        return _context.stop();
                                    }
                                }
                            }), _callee, this);
                        })));
                        function asyncEvent(_x, _x2) {
                            return _asyncEvent.apply(this, arguments);
                        }
                        return asyncEvent;
                    }()
                }, {
                    key: "fire",
                    value: function fire(routeName) {
                        var eventType = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "init";
                        document.dispatchEvent(new CustomEvent("routed", {
                            bubbles: true,
                            detail: {
                                routeName,
                                fn: eventType
                            }
                        }));
                        var route = this.routes[routeName], event = route[eventType];
                        var fire = routeName !== "" && route && typeof event === "function";
                        try {
                            if (fire) {
                                for (var _len3 = arguments.length, args = new Array(_len3 > 2 ? _len3 - 2 : 0), _key3 = 2; _key3 < _len3; _key3++) {
                                    args[_key3 - 2] = arguments[_key3];
                                }
                                this.asyncEvent.apply(this, [ route, eventType ].concat(args));
                            } else if (typeof event !== "function") {
                                throw new TypeError("callback for ".concat(route.name, ".").concat(eventType, " must be a function"));
                            } else {
                                throw new Error("cannot run ".concat(route.name, ".").concat(eventType));
                            }
                        } catch (e) {
                            console.error("Router Error:", e.message);
                        }
                    }
                }, {
                    key: "loadEvents",
                    value: function loadEvents() {
                        var _this = this;
                        var pageClasses = document.body.className.toLowerCase().replace(/-/g, "_").split(/\s+/).map(camelCase);
                        this.fire("common");
                        Object.keys(this.routes).forEach((function(route) {
                            if (pageClasses.includes(route) && route !== "common") {
                                _this.fire(route);
                            }
                        }));
                        Object.keys(this.routes).forEach((function(route) {
                            if (pageClasses.includes(route) && route !== "common") {
                                _this.fire(route, "finalize");
                            }
                        }));
                        Object.keys(this.routes).forEach((function(route) {
                            if (pageClasses.includes(route) && route !== "common") {
                                _this.fire(route, "resize");
                            }
                        }));
                        this.fire("common", "finalize");
                        this.fire("common", "resize");
                    }
                } ]);
                return Router;
            }();
            __webpack_exports__["default"] = Router;
        },
        "../node_modules/@babel/runtime/helpers/regeneratorRuntime.js": function(module, __unused_webpack_exports, __webpack_require__) {
            var _typeof = __webpack_require__("../node_modules/@babel/runtime/helpers/typeof.js")["default"];
            function _regeneratorRuntime() {
                "use strict";
                module.exports = _regeneratorRuntime = function _regeneratorRuntime() {
                    return exports;
                }, module.exports.__esModule = true, module.exports["default"] = module.exports;
                var exports = {}, Op = Object.prototype, hasOwn = Op.hasOwnProperty, $Symbol = "function" == typeof Symbol ? Symbol : {}, iteratorSymbol = $Symbol.iterator || "@@iterator", asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator", toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";
                function define(obj, key, value) {
                    return Object.defineProperty(obj, key, {
                        value,
                        enumerable: !0,
                        configurable: !0,
                        writable: !0
                    }), obj[key];
                }
                try {
                    define({}, "");
                } catch (err) {
                    define = function define(obj, key, value) {
                        return obj[key] = value;
                    };
                }
                function wrap(innerFn, outerFn, self, tryLocsList) {
                    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator, generator = Object.create(protoGenerator.prototype), context = new Context(tryLocsList || []);
                    return generator._invoke = function(innerFn, self, context) {
                        var state = "suspendedStart";
                        return function(method, arg) {
                            if ("executing" === state) throw new Error("Generator is already running");
                            if ("completed" === state) {
                                if ("throw" === method) throw arg;
                                return doneResult();
                            }
                            for (context.method = method, context.arg = arg; ;) {
                                var delegate = context.delegate;
                                if (delegate) {
                                    var delegateResult = maybeInvokeDelegate(delegate, context);
                                    if (delegateResult) {
                                        if (delegateResult === ContinueSentinel) continue;
                                        return delegateResult;
                                    }
                                }
                                if ("next" === context.method) context.sent = context._sent = context.arg; else if ("throw" === context.method) {
                                    if ("suspendedStart" === state) throw state = "completed", context.arg;
                                    context.dispatchException(context.arg);
                                } else "return" === context.method && context.abrupt("return", context.arg);
                                state = "executing";
                                var record = tryCatch(innerFn, self, context);
                                if ("normal" === record.type) {
                                    if (state = context.done ? "completed" : "suspendedYield", record.arg === ContinueSentinel) continue;
                                    return {
                                        value: record.arg,
                                        done: context.done
                                    };
                                }
                                "throw" === record.type && (state = "completed", context.method = "throw", context.arg = record.arg);
                            }
                        };
                    }(innerFn, self, context), generator;
                }
                function tryCatch(fn, obj, arg) {
                    try {
                        return {
                            type: "normal",
                            arg: fn.call(obj, arg)
                        };
                    } catch (err) {
                        return {
                            type: "throw",
                            arg: err
                        };
                    }
                }
                exports.wrap = wrap;
                var ContinueSentinel = {};
                function Generator() {}
                function GeneratorFunction() {}
                function GeneratorFunctionPrototype() {}
                var IteratorPrototype = {};
                define(IteratorPrototype, iteratorSymbol, (function() {
                    return this;
                }));
                var getProto = Object.getPrototypeOf, NativeIteratorPrototype = getProto && getProto(getProto(values([])));
                NativeIteratorPrototype && NativeIteratorPrototype !== Op && hasOwn.call(NativeIteratorPrototype, iteratorSymbol) && (IteratorPrototype = NativeIteratorPrototype);
                var Gp = GeneratorFunctionPrototype.prototype = Generator.prototype = Object.create(IteratorPrototype);
                function defineIteratorMethods(prototype) {
                    [ "next", "throw", "return" ].forEach((function(method) {
                        define(prototype, method, (function(arg) {
                            return this._invoke(method, arg);
                        }));
                    }));
                }
                function AsyncIterator(generator, PromiseImpl) {
                    function invoke(method, arg, resolve, reject) {
                        var record = tryCatch(generator[method], generator, arg);
                        if ("throw" !== record.type) {
                            var result = record.arg, value = result.value;
                            return value && "object" == _typeof(value) && hasOwn.call(value, "__await") ? PromiseImpl.resolve(value.__await).then((function(value) {
                                invoke("next", value, resolve, reject);
                            }), (function(err) {
                                invoke("throw", err, resolve, reject);
                            })) : PromiseImpl.resolve(value).then((function(unwrapped) {
                                result.value = unwrapped, resolve(result);
                            }), (function(error) {
                                return invoke("throw", error, resolve, reject);
                            }));
                        }
                        reject(record.arg);
                    }
                    var previousPromise;
                    this._invoke = function(method, arg) {
                        function callInvokeWithMethodAndArg() {
                            return new PromiseImpl((function(resolve, reject) {
                                invoke(method, arg, resolve, reject);
                            }));
                        }
                        return previousPromise = previousPromise ? previousPromise.then(callInvokeWithMethodAndArg, callInvokeWithMethodAndArg) : callInvokeWithMethodAndArg();
                    };
                }
                function maybeInvokeDelegate(delegate, context) {
                    var method = delegate.iterator[context.method];
                    if (undefined === method) {
                        if (context.delegate = null, "throw" === context.method) {
                            if (delegate.iterator["return"] && (context.method = "return", context.arg = undefined, 
                            maybeInvokeDelegate(delegate, context), "throw" === context.method)) return ContinueSentinel;
                            context.method = "throw", context.arg = new TypeError("The iterator does not provide a 'throw' method");
                        }
                        return ContinueSentinel;
                    }
                    var record = tryCatch(method, delegate.iterator, context.arg);
                    if ("throw" === record.type) return context.method = "throw", context.arg = record.arg, 
                    context.delegate = null, ContinueSentinel;
                    var info = record.arg;
                    return info ? info.done ? (context[delegate.resultName] = info.value, context.next = delegate.nextLoc, 
                    "return" !== context.method && (context.method = "next", context.arg = undefined), 
                    context.delegate = null, ContinueSentinel) : info : (context.method = "throw", context.arg = new TypeError("iterator result is not an object"), 
                    context.delegate = null, ContinueSentinel);
                }
                function pushTryEntry(locs) {
                    var entry = {
                        tryLoc: locs[0]
                    };
                    1 in locs && (entry.catchLoc = locs[1]), 2 in locs && (entry.finallyLoc = locs[2], 
                    entry.afterLoc = locs[3]), this.tryEntries.push(entry);
                }
                function resetTryEntry(entry) {
                    var record = entry.completion || {};
                    record.type = "normal", delete record.arg, entry.completion = record;
                }
                function Context(tryLocsList) {
                    this.tryEntries = [ {
                        tryLoc: "root"
                    } ], tryLocsList.forEach(pushTryEntry, this), this.reset(!0);
                }
                function values(iterable) {
                    if (iterable) {
                        var iteratorMethod = iterable[iteratorSymbol];
                        if (iteratorMethod) return iteratorMethod.call(iterable);
                        if ("function" == typeof iterable.next) return iterable;
                        if (!isNaN(iterable.length)) {
                            var i = -1, next = function next() {
                                for (;++i < iterable.length; ) {
                                    if (hasOwn.call(iterable, i)) return next.value = iterable[i], next.done = !1, next;
                                }
                                return next.value = undefined, next.done = !0, next;
                            };
                            return next.next = next;
                        }
                    }
                    return {
                        next: doneResult
                    };
                }
                function doneResult() {
                    return {
                        value: undefined,
                        done: !0
                    };
                }
                return GeneratorFunction.prototype = GeneratorFunctionPrototype, define(Gp, "constructor", GeneratorFunctionPrototype), 
                define(GeneratorFunctionPrototype, "constructor", GeneratorFunction), GeneratorFunction.displayName = define(GeneratorFunctionPrototype, toStringTagSymbol, "GeneratorFunction"), 
                exports.isGeneratorFunction = function(genFun) {
                    var ctor = "function" == typeof genFun && genFun.constructor;
                    return !!ctor && (ctor === GeneratorFunction || "GeneratorFunction" === (ctor.displayName || ctor.name));
                }, exports.mark = function(genFun) {
                    return Object.setPrototypeOf ? Object.setPrototypeOf(genFun, GeneratorFunctionPrototype) : (genFun.__proto__ = GeneratorFunctionPrototype, 
                    define(genFun, toStringTagSymbol, "GeneratorFunction")), genFun.prototype = Object.create(Gp), 
                    genFun;
                }, exports.awrap = function(arg) {
                    return {
                        __await: arg
                    };
                }, defineIteratorMethods(AsyncIterator.prototype), define(AsyncIterator.prototype, asyncIteratorSymbol, (function() {
                    return this;
                })), exports.AsyncIterator = AsyncIterator, exports.async = function(innerFn, outerFn, self, tryLocsList, PromiseImpl) {
                    void 0 === PromiseImpl && (PromiseImpl = Promise);
                    var iter = new AsyncIterator(wrap(innerFn, outerFn, self, tryLocsList), PromiseImpl);
                    return exports.isGeneratorFunction(outerFn) ? iter : iter.next().then((function(result) {
                        return result.done ? result.value : iter.next();
                    }));
                }, defineIteratorMethods(Gp), define(Gp, toStringTagSymbol, "Generator"), define(Gp, iteratorSymbol, (function() {
                    return this;
                })), define(Gp, "toString", (function() {
                    return "[object Generator]";
                })), exports.keys = function(object) {
                    var keys = [];
                    for (var key in object) {
                        keys.push(key);
                    }
                    return keys.reverse(), function next() {
                        for (;keys.length; ) {
                            var key = keys.pop();
                            if (key in object) return next.value = key, next.done = !1, next;
                        }
                        return next.done = !0, next;
                    };
                }, exports.values = values, Context.prototype = {
                    constructor: Context,
                    reset: function reset(skipTempReset) {
                        if (this.prev = 0, this.next = 0, this.sent = this._sent = undefined, this.done = !1, 
                        this.delegate = null, this.method = "next", this.arg = undefined, this.tryEntries.forEach(resetTryEntry), 
                        !skipTempReset) for (var name in this) {
                            "t" === name.charAt(0) && hasOwn.call(this, name) && !isNaN(+name.slice(1)) && (this[name] = undefined);
                        }
                    },
                    stop: function stop() {
                        this.done = !0;
                        var rootRecord = this.tryEntries[0].completion;
                        if ("throw" === rootRecord.type) throw rootRecord.arg;
                        return this.rval;
                    },
                    dispatchException: function dispatchException(exception) {
                        if (this.done) throw exception;
                        var context = this;
                        function handle(loc, caught) {
                            return record.type = "throw", record.arg = exception, context.next = loc, caught && (context.method = "next", 
                            context.arg = undefined), !!caught;
                        }
                        for (var i = this.tryEntries.length - 1; i >= 0; --i) {
                            var entry = this.tryEntries[i], record = entry.completion;
                            if ("root" === entry.tryLoc) return handle("end");
                            if (entry.tryLoc <= this.prev) {
                                var hasCatch = hasOwn.call(entry, "catchLoc"), hasFinally = hasOwn.call(entry, "finallyLoc");
                                if (hasCatch && hasFinally) {
                                    if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0);
                                    if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc);
                                } else if (hasCatch) {
                                    if (this.prev < entry.catchLoc) return handle(entry.catchLoc, !0);
                                } else {
                                    if (!hasFinally) throw new Error("try statement without catch or finally");
                                    if (this.prev < entry.finallyLoc) return handle(entry.finallyLoc);
                                }
                            }
                        }
                    },
                    abrupt: function abrupt(type, arg) {
                        for (var i = this.tryEntries.length - 1; i >= 0; --i) {
                            var entry = this.tryEntries[i];
                            if (entry.tryLoc <= this.prev && hasOwn.call(entry, "finallyLoc") && this.prev < entry.finallyLoc) {
                                var finallyEntry = entry;
                                break;
                            }
                        }
                        finallyEntry && ("break" === type || "continue" === type) && finallyEntry.tryLoc <= arg && arg <= finallyEntry.finallyLoc && (finallyEntry = null);
                        var record = finallyEntry ? finallyEntry.completion : {};
                        return record.type = type, record.arg = arg, finallyEntry ? (this.method = "next", 
                        this.next = finallyEntry.finallyLoc, ContinueSentinel) : this.complete(record);
                    },
                    complete: function complete(record, afterLoc) {
                        if ("throw" === record.type) throw record.arg;
                        return "break" === record.type || "continue" === record.type ? this.next = record.arg : "return" === record.type ? (this.rval = this.arg = record.arg, 
                        this.method = "return", this.next = "end") : "normal" === record.type && afterLoc && (this.next = afterLoc), 
                        ContinueSentinel;
                    },
                    finish: function finish(finallyLoc) {
                        for (var i = this.tryEntries.length - 1; i >= 0; --i) {
                            var entry = this.tryEntries[i];
                            if (entry.finallyLoc === finallyLoc) return this.complete(entry.completion, entry.afterLoc), 
                            resetTryEntry(entry), ContinueSentinel;
                        }
                    },
                    catch: function _catch(tryLoc) {
                        for (var i = this.tryEntries.length - 1; i >= 0; --i) {
                            var entry = this.tryEntries[i];
                            if (entry.tryLoc === tryLoc) {
                                var record = entry.completion;
                                if ("throw" === record.type) {
                                    var thrown = record.arg;
                                    resetTryEntry(entry);
                                }
                                return thrown;
                            }
                        }
                        throw new Error("illegal catch attempt");
                    },
                    delegateYield: function delegateYield(iterable, resultName, nextLoc) {
                        return this.delegate = {
                            iterator: values(iterable),
                            resultName,
                            nextLoc
                        }, "next" === this.method && (this.arg = undefined), ContinueSentinel;
                    }
                }, exports;
            }
            module.exports = _regeneratorRuntime, module.exports.__esModule = true, module.exports["default"] = module.exports;
        },
        "../node_modules/@babel/runtime/helpers/typeof.js": function(module) {
            function _typeof(obj) {
                "@babel/helpers - typeof";
                return module.exports = _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(obj) {
                    return typeof obj;
                } : function(obj) {
                    return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
                }, module.exports.__esModule = true, module.exports["default"] = module.exports, 
                _typeof(obj);
            }
            module.exports = _typeof, module.exports.__esModule = true, module.exports["default"] = module.exports;
        },
        "../node_modules/@babel/runtime/regenerator/index.js": function(module, __unused_webpack_exports, __webpack_require__) {
            var runtime = __webpack_require__("../node_modules/@babel/runtime/helpers/regeneratorRuntime.js")();
            module.exports = runtime;
            try {
                regeneratorRuntime = runtime;
            } catch (accidentalStrictMode) {
                if (typeof globalThis === "object") {
                    globalThis.regeneratorRuntime = runtime;
                } else {
                    Function("r", "regeneratorRuntime = r")(runtime);
                }
            }
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
        "../node_modules/smoothscroll-polyfill/dist/smoothscroll.js": function(module) {
            (function() {
                "use strict";
                function polyfill() {
                    var w = window;
                    var d = document;
                    if ("scrollBehavior" in d.documentElement.style && w.__forceSmoothScrollPolyfill__ !== true) {
                        return;
                    }
                    var Element = w.HTMLElement || w.Element;
                    var SCROLL_TIME = 468;
                    var original = {
                        scroll: w.scroll || w.scrollTo,
                        scrollBy: w.scrollBy,
                        elementScroll: Element.prototype.scroll || scrollElement,
                        scrollIntoView: Element.prototype.scrollIntoView
                    };
                    var now = w.performance && w.performance.now ? w.performance.now.bind(w.performance) : Date.now;
                    function isMicrosoftBrowser(userAgent) {
                        var userAgentPatterns = [ "MSIE ", "Trident/", "Edge/" ];
                        return new RegExp(userAgentPatterns.join("|")).test(userAgent);
                    }
                    var ROUNDING_TOLERANCE = isMicrosoftBrowser(w.navigator.userAgent) ? 1 : 0;
                    function scrollElement(x, y) {
                        this.scrollLeft = x;
                        this.scrollTop = y;
                    }
                    function ease(k) {
                        return .5 * (1 - Math.cos(Math.PI * k));
                    }
                    function shouldBailOut(firstArg) {
                        if (firstArg === null || typeof firstArg !== "object" || firstArg.behavior === undefined || firstArg.behavior === "auto" || firstArg.behavior === "instant") {
                            return true;
                        }
                        if (typeof firstArg === "object" && firstArg.behavior === "smooth") {
                            return false;
                        }
                        throw new TypeError("behavior member of ScrollOptions " + firstArg.behavior + " is not a valid value for enumeration ScrollBehavior.");
                    }
                    function hasScrollableSpace(el, axis) {
                        if (axis === "Y") {
                            return el.clientHeight + ROUNDING_TOLERANCE < el.scrollHeight;
                        }
                        if (axis === "X") {
                            return el.clientWidth + ROUNDING_TOLERANCE < el.scrollWidth;
                        }
                    }
                    function canOverflow(el, axis) {
                        var overflowValue = w.getComputedStyle(el, null)["overflow" + axis];
                        return overflowValue === "auto" || overflowValue === "scroll";
                    }
                    function isScrollable(el) {
                        var isScrollableY = hasScrollableSpace(el, "Y") && canOverflow(el, "Y");
                        var isScrollableX = hasScrollableSpace(el, "X") && canOverflow(el, "X");
                        return isScrollableY || isScrollableX;
                    }
                    function findScrollableParent(el) {
                        while (el !== d.body && isScrollable(el) === false) {
                            el = el.parentNode || el.host;
                        }
                        return el;
                    }
                    function step(context) {
                        var time = now();
                        var value;
                        var currentX;
                        var currentY;
                        var elapsed = (time - context.startTime) / SCROLL_TIME;
                        elapsed = elapsed > 1 ? 1 : elapsed;
                        value = ease(elapsed);
                        currentX = context.startX + (context.x - context.startX) * value;
                        currentY = context.startY + (context.y - context.startY) * value;
                        context.method.call(context.scrollable, currentX, currentY);
                        if (currentX !== context.x || currentY !== context.y) {
                            w.requestAnimationFrame(step.bind(w, context));
                        }
                    }
                    function smoothScroll(el, x, y) {
                        var scrollable;
                        var startX;
                        var startY;
                        var method;
                        var startTime = now();
                        if (el === d.body) {
                            scrollable = w;
                            startX = w.scrollX || w.pageXOffset;
                            startY = w.scrollY || w.pageYOffset;
                            method = original.scroll;
                        } else {
                            scrollable = el;
                            startX = el.scrollLeft;
                            startY = el.scrollTop;
                            method = scrollElement;
                        }
                        step({
                            scrollable,
                            method,
                            startTime,
                            startX,
                            startY,
                            x,
                            y
                        });
                    }
                    w.scroll = w.scrollTo = function() {
                        if (arguments[0] === undefined) {
                            return;
                        }
                        if (shouldBailOut(arguments[0]) === true) {
                            original.scroll.call(w, arguments[0].left !== undefined ? arguments[0].left : typeof arguments[0] !== "object" ? arguments[0] : w.scrollX || w.pageXOffset, arguments[0].top !== undefined ? arguments[0].top : arguments[1] !== undefined ? arguments[1] : w.scrollY || w.pageYOffset);
                            return;
                        }
                        smoothScroll.call(w, d.body, arguments[0].left !== undefined ? ~~arguments[0].left : w.scrollX || w.pageXOffset, arguments[0].top !== undefined ? ~~arguments[0].top : w.scrollY || w.pageYOffset);
                    };
                    w.scrollBy = function() {
                        if (arguments[0] === undefined) {
                            return;
                        }
                        if (shouldBailOut(arguments[0])) {
                            original.scrollBy.call(w, arguments[0].left !== undefined ? arguments[0].left : typeof arguments[0] !== "object" ? arguments[0] : 0, arguments[0].top !== undefined ? arguments[0].top : arguments[1] !== undefined ? arguments[1] : 0);
                            return;
                        }
                        smoothScroll.call(w, d.body, ~~arguments[0].left + (w.scrollX || w.pageXOffset), ~~arguments[0].top + (w.scrollY || w.pageYOffset));
                    };
                    Element.prototype.scroll = Element.prototype.scrollTo = function() {
                        if (arguments[0] === undefined) {
                            return;
                        }
                        if (shouldBailOut(arguments[0]) === true) {
                            if (typeof arguments[0] === "number" && arguments[1] === undefined) {
                                throw new SyntaxError("Value could not be converted");
                            }
                            original.elementScroll.call(this, arguments[0].left !== undefined ? ~~arguments[0].left : typeof arguments[0] !== "object" ? ~~arguments[0] : this.scrollLeft, arguments[0].top !== undefined ? ~~arguments[0].top : arguments[1] !== undefined ? ~~arguments[1] : this.scrollTop);
                            return;
                        }
                        var left = arguments[0].left;
                        var top = arguments[0].top;
                        smoothScroll.call(this, this, typeof left === "undefined" ? this.scrollLeft : ~~left, typeof top === "undefined" ? this.scrollTop : ~~top);
                    };
                    Element.prototype.scrollBy = function() {
                        if (arguments[0] === undefined) {
                            return;
                        }
                        if (shouldBailOut(arguments[0]) === true) {
                            original.elementScroll.call(this, arguments[0].left !== undefined ? ~~arguments[0].left + this.scrollLeft : ~~arguments[0] + this.scrollLeft, arguments[0].top !== undefined ? ~~arguments[0].top + this.scrollTop : ~~arguments[1] + this.scrollTop);
                            return;
                        }
                        this.scroll({
                            left: ~~arguments[0].left + this.scrollLeft,
                            top: ~~arguments[0].top + this.scrollTop,
                            behavior: arguments[0].behavior
                        });
                    };
                    Element.prototype.scrollIntoView = function() {
                        if (shouldBailOut(arguments[0]) === true) {
                            original.scrollIntoView.call(this, arguments[0] === undefined ? true : arguments[0]);
                            return;
                        }
                        var scrollableParent = findScrollableParent(this);
                        var parentRects = scrollableParent.getBoundingClientRect();
                        var clientRects = this.getBoundingClientRect();
                        if (scrollableParent !== d.body) {
                            smoothScroll.call(this, scrollableParent, scrollableParent.scrollLeft + clientRects.left - parentRects.left, scrollableParent.scrollTop + clientRects.top - parentRects.top);
                            if (w.getComputedStyle(scrollableParent).position !== "fixed") {
                                w.scrollBy({
                                    left: parentRects.left,
                                    top: parentRects.top,
                                    behavior: "smooth"
                                });
                            }
                        } else {
                            w.scrollBy({
                                left: clientRects.left,
                                top: clientRects.top,
                                behavior: "smooth"
                            });
                        }
                    };
                }
                if (true) {
                    module.exports = {
                        polyfill
                    };
                } else {}
            })();
        },
        jquery: function(module) {
            "use strict";
            module.exports = jQuery;
        },
        "../node_modules/@babel/runtime/helpers/esm/asyncToGenerator.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _asyncToGenerator;
                }
            });
            function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) {
                try {
                    var info = gen[key](arg);
                    var value = info.value;
                } catch (error) {
                    reject(error);
                    return;
                }
                if (info.done) {
                    resolve(value);
                } else {
                    Promise.resolve(value).then(_next, _throw);
                }
            }
            function _asyncToGenerator(fn) {
                return function() {
                    var self = this, args = arguments;
                    return new Promise((function(resolve, reject) {
                        var gen = fn.apply(self, args);
                        function _next(value) {
                            asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value);
                        }
                        function _throw(err) {
                            asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err);
                        }
                        _next(undefined);
                    }));
                };
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/classCallCheck.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _classCallCheck;
                }
            });
            function _classCallCheck(instance, Constructor) {
                if (!(instance instanceof Constructor)) {
                    throw new TypeError("Cannot call a class as a function");
                }
            }
        },
        "../node_modules/@babel/runtime/helpers/esm/createClass.js": function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            __webpack_require__.d(__webpack_exports__, {
                default: function() {
                    return _createClass;
                }
            });
            function _defineProperties(target, props) {
                for (var i = 0; i < props.length; i++) {
                    var descriptor = props[i];
                    descriptor.enumerable = descriptor.enumerable || false;
                    descriptor.configurable = true;
                    if ("value" in descriptor) descriptor.writable = true;
                    Object.defineProperty(target, descriptor.key, descriptor);
                }
            }
            function _createClass(Constructor, protoProps, staticProps) {
                if (protoProps) _defineProperties(Constructor.prototype, protoProps);
                if (staticProps) _defineProperties(Constructor, staticProps);
                Object.defineProperty(Constructor, "prototype", {
                    writable: false
                });
                return Constructor;
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
        var _util_Router__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("./js/util/Router.js");
        var _public_common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("./js/public/common.js");
        var routes = new _util_Router__WEBPACK_IMPORTED_MODULE_0__["default"]({
            common: _public_common__WEBPACK_IMPORTED_MODULE_1__["default"]
        });
        routes.loadEvents();
    }();
    !function() {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
    }();
})();
//# sourceMappingURL=rwp-admin.js.map