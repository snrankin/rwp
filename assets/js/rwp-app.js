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
            addHeaderOffset: function() {
                return addHeaderOffset;
            },
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
            getOffsetTop: function() {
                return getOffsetTop;
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
        var actual__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__("../node_modules/actual/actual.js");
        var actual__WEBPACK_IMPORTED_MODULE_0___default = __webpack_require__.n(actual__WEBPACK_IMPORTED_MODULE_0__);
        var verge__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__("../node_modules/verge/verge.js");
        var verge__WEBPACK_IMPORTED_MODULE_1___default = __webpack_require__.n(verge__WEBPACK_IMPORTED_MODULE_1__);
        var __WEBPACK_REEXPORT_OBJECT__ = {};
        for (var __WEBPACK_IMPORT_KEY__ in verge__WEBPACK_IMPORTED_MODULE_1__) if ([ "default", "isReduced", "has", "getOffsetTop", "eventFire", "listen", "noDefault", "noBubbles", "extend", "get", "isEmpty", "omit", "getTag", "camelCase", "changeTag", "stringToHtml", "wrapElement", "unwrapElement", "screenSize", "filterPath", "getHash", "getTallest", "matchHeights", "addHeaderOffset", "getWidest", "matchWidths", "bsAtts", "getBootstrapVar", "getBootstrapBP", "isBootstrapBP", "sortObjectByKeys", "logCustomProperties" ].indexOf(__WEBPACK_IMPORT_KEY__) < 0) __WEBPACK_REEXPORT_OBJECT__[__WEBPACK_IMPORT_KEY__] = function(key) {
            return verge__WEBPACK_IMPORTED_MODULE_1__[key];
        }.bind(0, __WEBPACK_IMPORT_KEY__);
        __webpack_require__.d(__webpack_exports__, __WEBPACK_REEXPORT_OBJECT__);
        const isReduced = window.matchMedia("(prefers-reduced-motion: reduce)") === true || window.matchMedia("(prefers-reduced-motion: reduce)").matches === true;
        function has(obj, path) {
            const pathArray = Array.isArray(path) ? path : path.match(/([^[.\]])+/g);
            return !!pathArray.reduce(((prevObj, key) => prevObj && prevObj[key]), obj);
        }
        function getOffsetTop(elem) {
            var distance = 0;
            if (elem.offsetParent) {
                do {
                    distance += elem.offsetTop;
                    elem = elem.offsetParent;
                } while (elem);
            }
            return distance < 0 ? 0 : distance;
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
            var fnwrap = function(e) {
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
            const pathArray = Array.isArray(path) ? path : path.match(/([^[.\]])+/g);
            const result = pathArray.reduce(((prevObj, key) => prevObj && prevObj[key]), obj);
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
            obj = {
                ...obj
            };
            props.forEach((prop => delete obj[prop]));
            return obj;
        }
        function getTag(value) {
            if (value == null) {
                return value === undefined ? "[object Undefined]" : "[object Null]";
            }
            return Object.prototype.toString.call(value);
        }
        function camelCase(str) {
            return `${str.charAt(0).toLowerCase()}${str.replace(/[\W_]/g, "|").split("|").map((part => `${part.charAt(0).toUpperCase()}${part.slice(1)}`)).join("").slice(1)}`;
        }
        function changeTag(original, tag) {
            const replacement = document.createElement(tag);
            for (let i = 0, l = original.attributes.length; i < l; ++i) {
                const nodeName = original.attributes.item(i).nodeName;
                const nodeValue = original.attributes.item(i).nodeValue;
                replacement.setAttribute(nodeName, nodeValue);
            }
            replacement.innerHTML = original.innerHTML;
            original.parentNode.replaceChild(replacement, original);
            return original;
        }
        const domParserSupport = function() {
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
                toWrap.forEach((item => {
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
            while (el.firstChild) parent.insertBefore(el.firstChild, el);
            parent.removeChild(el);
        }
        function screenSize(prop) {
            const size = {
                width: actual__WEBPACK_IMPORTED_MODULE_0__.actual.actual("width", "px"),
                height: actual__WEBPACK_IMPORTED_MODULE_0__.actual.actual("height", "px")
            };
            window.addEventListener("resize", (function() {
                size.width = actual__WEBPACK_IMPORTED_MODULE_0__.actual.actual("width", "px");
                size.hieght = actual__WEBPACK_IMPORTED_MODULE_0__.actual.actual("height", "px");
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
            const elements = document.querySelectorAll(el);
            const matches = Array.from(elements);
            if (matches.length > 1) {
                const heights = matches.map((function(elem) {
                    return elem.offsetHeight;
                }));
                return Math.max.apply(null, heights);
            }
            return false;
        }
        function matchHeights(elem = "", breakpoint = null) {
            const elements = document.querySelectorAll(elem);
            var matches = Array.from(elements);
            if (matches.length > 1) {
                if (!isEmpty(breakpoint) && isBootstrapBP(breakpoint) || isEmpty(breakpoint)) {
                    var minHeight = getTallest(elem);
                    if (false !== minHeight) {
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
        function addHeaderOffset(targetEl, header, includeAdminBar = false, prop = "marginTop", breakpoint = null, breakpointType = "min-width") {
            const elements = document.querySelectorAll(targetEl);
            var matches = Array.from(elements);
            if (matches.length > 0) {
                if (!isEmpty(breakpoint) && isBootstrapBP(breakpoint, breakpointType) || isEmpty(breakpoint)) {
                    let adminBarHeight = 0;
                    if (!isElement(header)) {
                        header = document.querySelector(header);
                    }
                    if (!isEmpty(header)) {
                        if (includeAdminBar) {
                            if (document.body.classList.contains("admin-bar")) {
                                let adminBar = document.getElementById("wpadminbar");
                                if (!isEmpty(adminBar)) {
                                    adminBarHeight = (0, verge__WEBPACK_IMPORTED_MODULE_1__.rectangle)(adminBar).height;
                                }
                            }
                        }
                        let headerHeight = (0, verge__WEBPACK_IMPORTED_MODULE_1__.rectangle)(header).height;
                        let offsetTop = headerHeight + adminBarHeight;
                        offsetTop = offsetTop + "px";
                        matches.forEach((function(el) {
                            el.style[prop] = offsetTop;
                        }));
                    }
                } else {
                    matches.forEach((function(el) {
                        el.style.removeProperty(prop);
                    }));
                }
            }
            window.addEventListener("resize", (function() {
                addHeaderOffset(targetEl, header, includeAdminBar, prop, breakpoint);
            }));
        }
        function getWidest(el) {
            const elements = document.querySelectorAll(el);
            const matches = Array.from(elements);
            if (matches.length > 1) {
                const widths = matches.map((function(elem) {
                    return elem.offsetWidth;
                }));
                return Math.max.apply(null, widths);
            }
            return false;
        }
        function matchWidths(elem = "", breakpoint = null) {
            const elements = document.querySelectorAll(elem);
            var matches = Array.from(elements);
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
        const isSameDomain = styleSheet => {
            if (!styleSheet.href) {
                return true;
            }
            return styleSheet.href.indexOf(window.location.origin) === 0;
        };
        const isStyleRule = rule => rule.type === 1;
        const getCSSCustomPropIndex = (index = "--") => [ ...document.styleSheets ].filter(isSameDomain).reduce(((finalArr, sheet) => finalArr.concat([ ...sheet.cssRules ].filter(isStyleRule).reduce(((propValArr, rule) => {
            const props = [ ...rule.style ].map((propName => [ propName.trim(), rule.style.getPropertyValue(propName).trim() ])).filter((([propName]) => propName.indexOf(index) === 0));
            return [ ...propValArr, ...props ];
        }), []))), []);
        function bsAtts() {
            let props = getCSSCustomPropIndex("--bs-");
            props = Object.fromEntries(props);
            props = sortObjectByKeys(props);
            return props;
        }
        function getBootstrapVar(v = "") {
            let props = bsAtts();
            return get(props, v, false);
        }
        function getBootstrapBP(breakpoint) {
            breakpoint = `--bs-bp-${breakpoint}`;
            return getBootstrapVar(breakpoint);
        }
        function isBootstrapBP(breakpoint, type = "min-width") {
            breakpoint = getBootstrapBP(breakpoint);
            return (0, verge__WEBPACK_IMPORTED_MODULE_1__.mq)(`(${type}: ${breakpoint})`);
        }
        function sortObjectByKeys(o) {
            return Object.keys(o).sort().reduce(((r, k) => (r[k] = o[k], r)), {});
        }
        function logCustomProperties() {
            let props = getCSSCustomPropIndex();
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