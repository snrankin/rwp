(function() {
    var __webpack_modules__ = {
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
        "./js/public/common.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var smoothscroll_polyfill__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/smoothscroll-polyfill/dist/smoothscroll.js");
            var smoothscroll_polyfill__WEBPACK_IMPORTED_MODULE_0___default = __webpack_require__.n(smoothscroll_polyfill__WEBPACK_IMPORTED_MODULE_0__);
            var $ = __webpack_require__("jquery");
            rwp = typeof rwp === "undefined" ? {} : rwp;
            __webpack_exports__["default"] = {
                betterHashLinks() {
                    const id = location.hash.substring(1);
                    if (!/^[A-z0-9_-]+$/.test(id)) {
                        return;
                    }
                    const element = document.getElementById(id);
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
                setupOffcanvasNav() {
                    const elements = document.querySelectorAll(".offcanvas-toggle");
                    const matches = Array.from(elements);
                    if (matches.length > 0) {
                        matches.forEach((function(el) {
                            el.addEventListener("click", (function() {
                                el.classList.toggle("active");
                            }));
                        }));
                    }
                    const navbar = document.querySelector(".navbar");
                    const header = navbar.closest("header");
                    if (!rwp.isEmpty(navbar)) {
                        const navbarClasses = navbar.getAttribute("class");
                        const regex = new RegExp("navbar-expand-(\\w+)", "gm");
                        let breakpointClass = false;
                        if (regex.test(navbarClasses)) {
                            breakpointClass = navbarClasses.match(regex);
                            breakpointClass = breakpointClass[0];
                            breakpointClass = breakpointClass.split("-");
                            breakpointClass = breakpointClass.slice(-1).pop();
                        }
                        rwp.addHeaderOffset(".navbar .offcanvas", header, true, "marginTop", breakpointClass, "max-width");
                    }
                },
                resize() {},
                init() {
                    (0, smoothscroll_polyfill__WEBPACK_IMPORTED_MODULE_0__.polyfill)();
                },
                finalize() {
                    this.setupOffcanvasNav();
                    $(".screen-full").width(rwp.screenSize("width")).height(rwp.screenSize("height"));
                    $(".screen-width").width(rwp.screenSize("width"));
                    $(".screen-height").height(rwp.screenSize("height"));
                    window.addEventListener("click", this.betterHashLinks);
                }
            };
        },
        "./js/util/Router.js": function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {
            "use strict";
            __webpack_require__.r(__webpack_exports__);
            var domready__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/domready/ready.js");
            var domready__WEBPACK_IMPORTED_MODULE_0___default = __webpack_require__.n(domready__WEBPACK_IMPORTED_MODULE_0__);
            function camelCase(str) {
                return `${str.charAt(0).toLowerCase()}${str.replace(/[\W_]/g, "|").split("|").map((part => `${part.charAt(0).toUpperCase()}${part.slice(1)}`)).join("").slice(1)}`;
            }
            class Router {
                constructor(routes) {
                    this.routes = routes;
                }
                promisedEvent(route = {}, eventType = "", timeout = 0, ...args) {
                    const event = route[eventType];
                    const listener = () => {
                        setTimeout((() => {
                            event.apply(route, args);
                        }), timeout);
                    };
                    return new Promise((resolve => {
                        if ("resize" === eventType) {
                            window.addEventListener("resize", listener);
                        } else if ("init" === eventType) {
                            domready__WEBPACK_IMPORTED_MODULE_0___default()(listener);
                        } else if ("finalize" === eventType) {
                            window.addEventListener("load", listener, false);
                        }
                        resolve();
                    }));
                }
                async asyncEvent(route, eventType, ...args) {
                    let timeout = 1;
                    if ("finalize" === eventType) {
                        timeout = 2e3;
                    }
                    await this.promisedEvent(route, eventType, timeout, ...args);
                }
                fire(routeName, eventType = "init", ...args) {
                    document.dispatchEvent(new CustomEvent("routed", {
                        bubbles: true,
                        detail: {
                            routeName,
                            fn: eventType
                        }
                    }));
                    const route = this.routes[routeName];
                    const event = route[eventType];
                    const fire = routeName !== "" && route && typeof event === "function";
                    try {
                        if (fire) {
                            this.asyncEvent(route, eventType, ...args);
                        } else if (typeof event !== "function") {
                            throw new TypeError(`callback for ${route.name}.${eventType} must be a function`);
                        } else {
                            throw new Error(`cannot run ${route.name}.${eventType}`);
                        }
                    } catch (e) {
                        console.error("Router Error:", e.message);
                    }
                }
                loadEvents() {
                    const pageClasses = document.body.className.toLowerCase().replace(/-/g, "_").split(/\s+/).map(camelCase);
                    this.fire("common");
                    Object.keys(this.routes).forEach((route => {
                        if (pageClasses.includes(route) && route !== "common") {
                            this.fire(route);
                        }
                    }));
                    Object.keys(this.routes).forEach((route => {
                        if (pageClasses.includes(route) && route !== "common") {
                            this.fire(route, "finalize");
                        }
                    }));
                    Object.keys(this.routes).forEach((route => {
                        if (pageClasses.includes(route) && route !== "common") {
                            this.fire(route, "resize");
                        }
                    }));
                    this.fire("common", "finalize");
                    this.fire("common", "resize");
                }
            }
            __webpack_exports__["default"] = Router;
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
        var _util_Router__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("./js/util/Router.js");
        var _public_common__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("./js/public/common.js");
        const routes = new _util_Router__WEBPACK_IMPORTED_MODULE_0__["default"]({
            common: _public_common__WEBPACK_IMPORTED_MODULE_1__["default"]
        });
        routes.loadEvents();
    }();
    !function() {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
    }();
})();
//# sourceMappingURL=rwp-public.js.map