(function() {
    var __webpack_modules__ = {
        "./js/vendor/.modernizrrc": function(module) {
            (function(window) {
                var hadGlobal = "Modernizr" in window;
                var oldGlobal = window.Modernizr;
                (function(scriptGlobalObject, window, document, undefined) {
                    var tests = [];
                    var ModernizrProto = {
                        _version: "3.12.0",
                        _config: {
                            classPrefix: "",
                            enableClasses: true,
                            enableJSClass: true,
                            usePrefixes: true
                        },
                        _q: [],
                        on: function(test, cb) {
                            var self = this;
                            setTimeout((function() {
                                cb(self[test]);
                            }), 0);
                        },
                        addTest: function(name, fn, options) {
                            tests.push({
                                name,
                                fn,
                                options
                            });
                        },
                        addAsyncTest: function(fn) {
                            tests.push({
                                name: null,
                                fn
                            });
                        }
                    };
                    var Modernizr = function() {};
                    Modernizr.prototype = ModernizrProto;
                    Modernizr = new Modernizr;
                    var classes = [];
                    function is(obj, type) {
                        return typeof obj === type;
                    }
                    function testRunner() {
                        var featureNames;
                        var feature;
                        var aliasIdx;
                        var result;
                        var nameIdx;
                        var featureName;
                        var featureNameSplit;
                        for (var featureIdx in tests) {
                            if (tests.hasOwnProperty(featureIdx)) {
                                featureNames = [];
                                feature = tests[featureIdx];
                                if (feature.name) {
                                    featureNames.push(feature.name.toLowerCase());
                                    if (feature.options && feature.options.aliases && feature.options.aliases.length) {
                                        for (aliasIdx = 0; aliasIdx < feature.options.aliases.length; aliasIdx++) {
                                            featureNames.push(feature.options.aliases[aliasIdx].toLowerCase());
                                        }
                                    }
                                }
                                result = is(feature.fn, "function") ? feature.fn() : feature.fn;
                                for (nameIdx = 0; nameIdx < featureNames.length; nameIdx++) {
                                    featureName = featureNames[nameIdx];
                                    featureNameSplit = featureName.split(".");
                                    if (featureNameSplit.length === 1) {
                                        Modernizr[featureNameSplit[0]] = result;
                                    } else {
                                        if (!Modernizr[featureNameSplit[0]] || Modernizr[featureNameSplit[0]] && !(Modernizr[featureNameSplit[0]] instanceof Boolean)) {
                                            Modernizr[featureNameSplit[0]] = new Boolean(Modernizr[featureNameSplit[0]]);
                                        }
                                        Modernizr[featureNameSplit[0]][featureNameSplit[1]] = result;
                                    }
                                    classes.push((result ? "" : "no-") + featureNameSplit.join("-"));
                                }
                            }
                        }
                    }
                    var docElement = document.documentElement;
                    var isSVG = docElement.nodeName.toLowerCase() === "svg";
                    function setClasses(classes) {
                        var className = docElement.className;
                        var classPrefix = Modernizr._config.classPrefix || "";
                        if (isSVG) {
                            className = className.baseVal;
                        }
                        if (Modernizr._config.enableJSClass) {
                            var reJS = new RegExp("(^|\\s)" + classPrefix + "no-js(\\s|$)");
                            className = className.replace(reJS, "$1" + classPrefix + "js$2");
                        }
                        if (Modernizr._config.enableClasses) {
                            if (classes.length > 0) {
                                className += " " + classPrefix + classes.join(" " + classPrefix);
                            }
                            if (isSVG) {
                                docElement.className.baseVal = className;
                            } else {
                                docElement.className = className;
                            }
                        }
                    }
                    var hasOwnProp;
                    (function() {
                        var _hasOwnProperty = {}.hasOwnProperty;
                        if (!is(_hasOwnProperty, "undefined") && !is(_hasOwnProperty.call, "undefined")) {
                            hasOwnProp = function(object, property) {
                                return _hasOwnProperty.call(object, property);
                            };
                        } else {
                            hasOwnProp = function(object, property) {
                                return property in object && is(object.constructor.prototype[property], "undefined");
                            };
                        }
                    })();
                    ModernizrProto._l = {};
                    ModernizrProto.on = function(feature, cb) {
                        if (!this._l[feature]) {
                            this._l[feature] = [];
                        }
                        this._l[feature].push(cb);
                        if (Modernizr.hasOwnProperty(feature)) {
                            setTimeout((function() {
                                Modernizr._trigger(feature, Modernizr[feature]);
                            }), 0);
                        }
                    };
                    ModernizrProto._trigger = function(feature, res) {
                        if (!this._l[feature]) {
                            return;
                        }
                        var cbs = this._l[feature];
                        setTimeout((function() {
                            var i, cb;
                            for (i = 0; i < cbs.length; i++) {
                                cb = cbs[i];
                                cb(res);
                            }
                        }), 0);
                        delete this._l[feature];
                    };
                    function addTest(feature, test) {
                        if (typeof feature === "object") {
                            for (var key in feature) {
                                if (hasOwnProp(feature, key)) {
                                    addTest(key, feature[key]);
                                }
                            }
                        } else {
                            feature = feature.toLowerCase();
                            var featureNameSplit = feature.split(".");
                            var last = Modernizr[featureNameSplit[0]];
                            if (featureNameSplit.length === 2) {
                                last = last[featureNameSplit[1]];
                            }
                            if (typeof last !== "undefined") {
                                return Modernizr;
                            }
                            test = typeof test === "function" ? test() : test;
                            if (featureNameSplit.length === 1) {
                                Modernizr[featureNameSplit[0]] = test;
                            } else {
                                if (Modernizr[featureNameSplit[0]] && !(Modernizr[featureNameSplit[0]] instanceof Boolean)) {
                                    Modernizr[featureNameSplit[0]] = new Boolean(Modernizr[featureNameSplit[0]]);
                                }
                                Modernizr[featureNameSplit[0]][featureNameSplit[1]] = test;
                            }
                            setClasses([ (!!test && test !== false ? "" : "no-") + featureNameSplit.join("-") ]);
                            Modernizr._trigger(feature, test);
                        }
                        return Modernizr;
                    }
                    Modernizr._q.push((function() {
                        ModernizrProto.addTest = addTest;
                    }));
                    var omPrefixes = "Moz O ms Webkit";
                    var cssomPrefixes = ModernizrProto._config.usePrefixes ? omPrefixes.split(" ") : [];
                    ModernizrProto._cssomPrefixes = cssomPrefixes;
                    var atRule = function(prop) {
                        var length = prefixes.length;
                        var cssrule = window.CSSRule;
                        var rule;
                        if (typeof cssrule === "undefined") {
                            return undefined;
                        }
                        if (!prop) {
                            return false;
                        }
                        prop = prop.replace(/^@/, "");
                        rule = prop.replace(/-/g, "_").toUpperCase() + "_RULE";
                        if (rule in cssrule) {
                            return "@" + prop;
                        }
                        for (var i = 0; i < length; i++) {
                            var prefix = prefixes[i];
                            var thisRule = prefix.toUpperCase() + "_" + rule;
                            if (thisRule in cssrule) {
                                return "@-" + prefix.toLowerCase() + "-" + prop;
                            }
                        }
                        return false;
                    };
                    ModernizrProto.atRule = atRule;
                    var domPrefixes = ModernizrProto._config.usePrefixes ? omPrefixes.toLowerCase().split(" ") : [];
                    ModernizrProto._domPrefixes = domPrefixes;
                    function createElement() {
                        if (typeof document.createElement !== "function") {
                            return document.createElement(arguments[0]);
                        } else if (isSVG) {
                            return document.createElementNS.call(document, "http://www.w3.org/2000/svg", arguments[0]);
                        } else {
                            return document.createElement.apply(document, arguments);
                        }
                    }
                    var hasEvent = function() {
                        var needsFallback = !("onblur" in docElement);
                        function inner(eventName, element) {
                            var isSupported;
                            if (!eventName) {
                                return false;
                            }
                            if (!element || typeof element === "string") {
                                element = createElement(element || "div");
                            }
                            eventName = "on" + eventName;
                            isSupported = eventName in element;
                            if (!isSupported && needsFallback) {
                                if (!element.setAttribute) {
                                    element = createElement("div");
                                }
                                element.setAttribute(eventName, "");
                                isSupported = typeof element[eventName] === "function";
                                if (element[eventName] !== undefined) {
                                    element[eventName] = undefined;
                                }
                                element.removeAttribute(eventName);
                            }
                            return isSupported;
                        }
                        return inner;
                    }();
                    ModernizrProto.hasEvent = hasEvent;
                    var html5;
                    if (!isSVG) {
                        (function(window, document) {
                            var version = "3.7.3";
                            var options = window.html5 || {};
                            var reSkip = /^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i;
                            var saveClones = /^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i;
                            var supportsHtml5Styles;
                            var expando = "_html5shiv";
                            var expanID = 0;
                            var expandoData = {};
                            var supportsUnknownElements;
                            (function() {
                                try {
                                    var a = document.createElement("a");
                                    a.innerHTML = "<xyz></xyz>";
                                    supportsHtml5Styles = "hidden" in a;
                                    supportsUnknownElements = a.childNodes.length == 1 || function() {
                                        document.createElement("a");
                                        var frag = document.createDocumentFragment();
                                        return typeof frag.cloneNode == "undefined" || typeof frag.createDocumentFragment == "undefined" || typeof frag.createElement == "undefined";
                                    }();
                                } catch (e) {
                                    supportsHtml5Styles = true;
                                    supportsUnknownElements = true;
                                }
                            })();
                            function addStyleSheet(ownerDocument, cssText) {
                                var p = ownerDocument.createElement("p"), parent = ownerDocument.getElementsByTagName("head")[0] || ownerDocument.documentElement;
                                p.innerHTML = "x<style>" + cssText + "</style>";
                                return parent.insertBefore(p.lastChild, parent.firstChild);
                            }
                            function getElements() {
                                var elements = html5.elements;
                                return typeof elements == "string" ? elements.split(" ") : elements;
                            }
                            function addElements(newElements, ownerDocument) {
                                var elements = html5.elements;
                                if (typeof elements != "string") {
                                    elements = elements.join(" ");
                                }
                                if (typeof newElements != "string") {
                                    newElements = newElements.join(" ");
                                }
                                html5.elements = elements + " " + newElements;
                                shivDocument(ownerDocument);
                            }
                            function getExpandoData(ownerDocument) {
                                var data = expandoData[ownerDocument[expando]];
                                if (!data) {
                                    data = {};
                                    expanID++;
                                    ownerDocument[expando] = expanID;
                                    expandoData[expanID] = data;
                                }
                                return data;
                            }
                            function createElement(nodeName, ownerDocument, data) {
                                if (!ownerDocument) {
                                    ownerDocument = document;
                                }
                                if (supportsUnknownElements) {
                                    return ownerDocument.createElement(nodeName);
                                }
                                if (!data) {
                                    data = getExpandoData(ownerDocument);
                                }
                                var node;
                                if (data.cache[nodeName]) {
                                    node = data.cache[nodeName].cloneNode();
                                } else if (saveClones.test(nodeName)) {
                                    node = (data.cache[nodeName] = data.createElem(nodeName)).cloneNode();
                                } else {
                                    node = data.createElem(nodeName);
                                }
                                return node.canHaveChildren && !reSkip.test(nodeName) && !node.tagUrn ? data.frag.appendChild(node) : node;
                            }
                            function createDocumentFragment(ownerDocument, data) {
                                if (!ownerDocument) {
                                    ownerDocument = document;
                                }
                                if (supportsUnknownElements) {
                                    return ownerDocument.createDocumentFragment();
                                }
                                data = data || getExpandoData(ownerDocument);
                                var clone = data.frag.cloneNode(), i = 0, elems = getElements(), l = elems.length;
                                for (;i < l; i++) {
                                    clone.createElement(elems[i]);
                                }
                                return clone;
                            }
                            function shivMethods(ownerDocument, data) {
                                if (!data.cache) {
                                    data.cache = {};
                                    data.createElem = ownerDocument.createElement;
                                    data.createFrag = ownerDocument.createDocumentFragment;
                                    data.frag = data.createFrag();
                                }
                                ownerDocument.createElement = function(nodeName) {
                                    if (!html5.shivMethods) {
                                        return data.createElem(nodeName);
                                    }
                                    return createElement(nodeName, ownerDocument, data);
                                };
                                ownerDocument.createDocumentFragment = Function("h,f", "return function(){" + "var n=f.cloneNode(),c=n.createElement;" + "h.shivMethods&&(" + getElements().join().replace(/[\w\-:]+/g, (function(nodeName) {
                                    data.createElem(nodeName);
                                    data.frag.createElement(nodeName);
                                    return 'c("' + nodeName + '")';
                                })) + ");return n}")(html5, data.frag);
                            }
                            function shivDocument(ownerDocument) {
                                if (!ownerDocument) {
                                    ownerDocument = document;
                                }
                                var data = getExpandoData(ownerDocument);
                                if (html5.shivCSS && !supportsHtml5Styles && !data.hasCSS) {
                                    data.hasCSS = !!addStyleSheet(ownerDocument, "article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}" + "mark{background:#FF0;color:#000}" + "template{display:none}");
                                }
                                if (!supportsUnknownElements) {
                                    shivMethods(ownerDocument, data);
                                }
                                return ownerDocument;
                            }
                            var html5 = {
                                elements: options.elements || "abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video",
                                version,
                                shivCSS: options.shivCSS !== false,
                                supportsUnknownElements,
                                shivMethods: options.shivMethods !== false,
                                type: "default",
                                shivDocument,
                                createElement,
                                createDocumentFragment,
                                addElements
                            };
                            window.html5 = html5;
                            shivDocument(document);
                            var reMedia = /^$|\b(?:all|print)\b/;
                            var shivNamespace = "html5shiv";
                            var supportsShivableSheets = !supportsUnknownElements && function() {
                                var docEl = document.documentElement;
                                return !(typeof document.namespaces == "undefined" || typeof document.parentWindow == "undefined" || typeof docEl.applyElement == "undefined" || typeof docEl.removeNode == "undefined" || typeof window.attachEvent == "undefined");
                            }();
                            function addWrappers(ownerDocument) {
                                var node, nodes = ownerDocument.getElementsByTagName("*"), index = nodes.length, reElements = RegExp("^(?:" + getElements().join("|") + ")$", "i"), result = [];
                                while (index--) {
                                    node = nodes[index];
                                    if (reElements.test(node.nodeName)) {
                                        result.push(node.applyElement(createWrapper(node)));
                                    }
                                }
                                return result;
                            }
                            function createWrapper(element) {
                                var node, nodes = element.attributes, index = nodes.length, wrapper = element.ownerDocument.createElement(shivNamespace + ":" + element.nodeName);
                                while (index--) {
                                    node = nodes[index];
                                    node.specified && wrapper.setAttribute(node.nodeName, node.nodeValue);
                                }
                                wrapper.style.cssText = element.style.cssText;
                                return wrapper;
                            }
                            function shivCssText(cssText) {
                                var pair, parts = cssText.split("{"), index = parts.length, reElements = RegExp("(^|[\\s,>+~])(" + getElements().join("|") + ")(?=[[\\s,>+~#.:]|$)", "gi"), replacement = "$1" + shivNamespace + "\\:$2";
                                while (index--) {
                                    pair = parts[index] = parts[index].split("}");
                                    pair[pair.length - 1] = pair[pair.length - 1].replace(reElements, replacement);
                                    parts[index] = pair.join("}");
                                }
                                return parts.join("{");
                            }
                            function removeWrappers(wrappers) {
                                var index = wrappers.length;
                                while (index--) {
                                    wrappers[index].removeNode();
                                }
                            }
                            function shivPrint(ownerDocument) {
                                var shivedSheet, wrappers, data = getExpandoData(ownerDocument), namespaces = ownerDocument.namespaces, ownerWindow = ownerDocument.parentWindow;
                                if (!supportsShivableSheets || ownerDocument.printShived) {
                                    return ownerDocument;
                                }
                                if (typeof namespaces[shivNamespace] == "undefined") {
                                    namespaces.add(shivNamespace);
                                }
                                function removeSheet() {
                                    clearTimeout(data._removeSheetTimer);
                                    if (shivedSheet) {
                                        shivedSheet.removeNode(true);
                                    }
                                    shivedSheet = null;
                                }
                                ownerWindow.attachEvent("onbeforeprint", (function() {
                                    removeSheet();
                                    var imports, length, sheet, collection = ownerDocument.styleSheets, cssText = [], index = collection.length, sheets = Array(index);
                                    while (index--) {
                                        sheets[index] = collection[index];
                                    }
                                    while (sheet = sheets.pop()) {
                                        if (!sheet.disabled && reMedia.test(sheet.media)) {
                                            try {
                                                imports = sheet.imports;
                                                length = imports.length;
                                            } catch (er) {
                                                length = 0;
                                            }
                                            for (index = 0; index < length; index++) {
                                                sheets.push(imports[index]);
                                            }
                                            try {
                                                cssText.push(sheet.cssText);
                                            } catch (er) {}
                                        }
                                    }
                                    cssText = shivCssText(cssText.reverse().join(""));
                                    wrappers = addWrappers(ownerDocument);
                                    shivedSheet = addStyleSheet(ownerDocument, cssText);
                                }));
                                ownerWindow.attachEvent("onafterprint", (function() {
                                    removeWrappers(wrappers);
                                    clearTimeout(data._removeSheetTimer);
                                    data._removeSheetTimer = setTimeout(removeSheet, 500);
                                }));
                                ownerDocument.printShived = true;
                                return ownerDocument;
                            }
                            html5.type += " print";
                            html5.shivPrint = shivPrint;
                            shivPrint(document);
                            if (true && module.exports) {
                                module.exports = html5;
                            }
                        })(typeof window !== "undefined" ? window : this, document);
                    }
                    var err = function() {};
                    var warn = function() {};
                    if (window.console) {
                        err = function() {
                            var method = console.error ? "error" : "log";
                            window.console[method].apply(window.console, Array.prototype.slice.call(arguments));
                        };
                        warn = function() {
                            var method = console.warn ? "warn" : "log";
                            window.console[method].apply(window.console, Array.prototype.slice.call(arguments));
                        };
                    }
                    ModernizrProto.load = function() {
                        if ("yepnope" in window) {
                            warn("yepnope.js (aka Modernizr.load) is no longer included as part of Modernizr. yepnope appears to be available on the page, so we’ll use it to handle this call to Modernizr.load, but please update your code to use yepnope directly.\n See http://github.com/Modernizr/Modernizr/issues/1182 for more information.");
                            window.yepnope.apply(window, [].slice.call(arguments, 0));
                        } else {
                            err("yepnope.js (aka Modernizr.load) is no longer included as part of Modernizr. Get it from http://yepnopejs.com. See http://github.com/Modernizr/Modernizr/issues/1182 for more information.");
                        }
                    };
                    function getBody() {
                        var body = document.body;
                        if (!body) {
                            body = createElement(isSVG ? "svg" : "body");
                            body.fake = true;
                        }
                        return body;
                    }
                    function injectElementWithStyles(rule, callback, nodes, testnames) {
                        var mod = "modernizr";
                        var style;
                        var ret;
                        var node;
                        var docOverflow;
                        var div = createElement("div");
                        var body = getBody();
                        if (parseInt(nodes, 10)) {
                            while (nodes--) {
                                node = createElement("div");
                                node.id = testnames ? testnames[nodes] : mod + (nodes + 1);
                                div.appendChild(node);
                            }
                        }
                        style = createElement("style");
                        style.type = "text/css";
                        style.id = "s" + mod;
                        (!body.fake ? div : body).appendChild(style);
                        body.appendChild(div);
                        if (style.styleSheet) {
                            style.styleSheet.cssText = rule;
                        } else {
                            style.appendChild(document.createTextNode(rule));
                        }
                        div.id = mod;
                        if (body.fake) {
                            body.style.background = "";
                            body.style.overflow = "hidden";
                            docOverflow = docElement.style.overflow;
                            docElement.style.overflow = "hidden";
                            docElement.appendChild(body);
                        }
                        ret = callback(div, rule);
                        if (body.fake && body.parentNode) {
                            body.parentNode.removeChild(body);
                            docElement.style.overflow = docOverflow;
                            docElement.offsetHeight;
                        } else {
                            div.parentNode.removeChild(div);
                        }
                        return !!ret;
                    }
                    function computedStyle(elem, pseudo, prop) {
                        var result;
                        if ("getComputedStyle" in window) {
                            result = getComputedStyle.call(window, elem, pseudo);
                            var console = window.console;
                            if (result !== null) {
                                if (prop) {
                                    result = result.getPropertyValue(prop);
                                }
                            } else {
                                if (console) {
                                    var method = console.error ? "error" : "log";
                                    console[method].call(console, "getComputedStyle returning null, its possible modernizr test results are inaccurate");
                                }
                            }
                        } else {
                            result = !pseudo && elem.currentStyle && elem.currentStyle[prop];
                        }
                        return result;
                    }
                    var mq = function() {
                        var matchMedia = window.matchMedia || window.msMatchMedia;
                        if (matchMedia) {
                            return function(mq) {
                                var mql = matchMedia(mq);
                                return mql && mql.matches || false;
                            };
                        }
                        return function(mq) {
                            var bool = false;
                            injectElementWithStyles("@media " + mq + " { #modernizr { position: absolute; } }", (function(node) {
                                bool = computedStyle(node, null, "position") === "absolute";
                            }));
                            return bool;
                        };
                    }();
                    ModernizrProto.mq = mq;
                    function contains(str, substr) {
                        return !!~("" + str).indexOf(substr);
                    }
                    var modElem = {
                        elem: createElement("modernizr")
                    };
                    Modernizr._q.push((function() {
                        delete modElem.elem;
                    }));
                    var mStyle = {
                        style: modElem.elem.style
                    };
                    Modernizr._q.unshift((function() {
                        delete mStyle.style;
                    }));
                    function domToCSS(name) {
                        return name.replace(/([A-Z])/g, (function(str, m1) {
                            return "-" + m1.toLowerCase();
                        })).replace(/^ms-/, "-ms-");
                    }
                    function nativeTestProps(props, value) {
                        var i = props.length;
                        if ("CSS" in window && "supports" in window.CSS) {
                            while (i--) {
                                if (window.CSS.supports(domToCSS(props[i]), value)) {
                                    return true;
                                }
                            }
                            return false;
                        } else if ("CSSSupportsRule" in window) {
                            var conditionText = [];
                            while (i--) {
                                conditionText.push("(" + domToCSS(props[i]) + ":" + value + ")");
                            }
                            conditionText = conditionText.join(" or ");
                            return injectElementWithStyles("@supports (" + conditionText + ") { #modernizr { position: absolute; } }", (function(node) {
                                return computedStyle(node, null, "position") === "absolute";
                            }));
                        }
                        return undefined;
                    }
                    function cssToDOM(name) {
                        return name.replace(/([a-z])-([a-z])/g, (function(str, m1, m2) {
                            return m1 + m2.toUpperCase();
                        })).replace(/^-/, "");
                    }
                    function testProps(props, prefixed, value, skipValueTest) {
                        skipValueTest = is(skipValueTest, "undefined") ? false : skipValueTest;
                        if (!is(value, "undefined")) {
                            var result = nativeTestProps(props, value);
                            if (!is(result, "undefined")) {
                                return result;
                            }
                        }
                        var afterInit, i, propsLength, prop, before;
                        var elems = [ "modernizr", "tspan", "samp" ];
                        while (!mStyle.style && elems.length) {
                            afterInit = true;
                            mStyle.modElem = createElement(elems.shift());
                            mStyle.style = mStyle.modElem.style;
                        }
                        function cleanElems() {
                            if (afterInit) {
                                delete mStyle.style;
                                delete mStyle.modElem;
                            }
                        }
                        propsLength = props.length;
                        for (i = 0; i < propsLength; i++) {
                            prop = props[i];
                            before = mStyle.style[prop];
                            if (contains(prop, "-")) {
                                prop = cssToDOM(prop);
                            }
                            if (mStyle.style[prop] !== undefined) {
                                if (!skipValueTest && !is(value, "undefined")) {
                                    try {
                                        mStyle.style[prop] = value;
                                    } catch (e) {}
                                    if (mStyle.style[prop] !== before) {
                                        cleanElems();
                                        return prefixed === "pfx" ? prop : true;
                                    }
                                } else {
                                    cleanElems();
                                    return prefixed === "pfx" ? prop : true;
                                }
                            }
                        }
                        cleanElems();
                        return false;
                    }
                    function fnBind(fn, that) {
                        return function() {
                            return fn.apply(that, arguments);
                        };
                    }
                    function testDOMProps(props, obj, elem) {
                        var item;
                        for (var i in props) {
                            if (props[i] in obj) {
                                if (elem === false) {
                                    return props[i];
                                }
                                item = obj[props[i]];
                                if (is(item, "function")) {
                                    return fnBind(item, elem || obj);
                                }
                                return item;
                            }
                        }
                        return false;
                    }
                    function testPropsAll(prop, prefixed, elem, value, skipValueTest) {
                        var ucProp = prop.charAt(0).toUpperCase() + prop.slice(1), props = (prop + " " + cssomPrefixes.join(ucProp + " ") + ucProp).split(" ");
                        if (is(prefixed, "string") || is(prefixed, "undefined")) {
                            return testProps(props, prefixed, value, skipValueTest);
                        } else {
                            props = (prop + " " + domPrefixes.join(ucProp + " ") + ucProp).split(" ");
                            return testDOMProps(props, prefixed, elem);
                        }
                    }
                    ModernizrProto.testAllProps = testPropsAll;
                    var prefixed = ModernizrProto.prefixed = function(prop, obj, elem) {
                        if (prop.indexOf("@") === 0) {
                            return atRule(prop);
                        }
                        if (prop.indexOf("-") !== -1) {
                            prop = cssToDOM(prop);
                        }
                        if (!obj) {
                            return testPropsAll(prop, "pfx");
                        } else {
                            return testPropsAll(prop, obj, elem);
                        }
                    };
                    var prefixes = ModernizrProto._config.usePrefixes ? " -webkit- -moz- -o- -ms- ".split(" ") : [ "", "" ];
                    ModernizrProto._prefixes = prefixes;
                    var prefixedCSS = ModernizrProto.prefixedCSS = function(prop) {
                        var prefixedProp = prefixed(prop);
                        return prefixedProp && domToCSS(prefixedProp);
                    };
                    function testAllProps(prop, value, skipValueTest) {
                        return testPropsAll(prop, undefined, undefined, value, skipValueTest);
                    }
                    ModernizrProto.testAllProps = testAllProps;
                    var testProp = ModernizrProto.testProp = function(prop, value, useValue) {
                        return testProps([ prop ], undefined, value, useValue);
                    };
                    var testStyles = ModernizrProto.testStyles = injectElementWithStyles;
                    (function() {
                        var elem = createElement("audio");
                        Modernizr.addTest("audio", (function() {
                            var bool = false;
                            try {
                                bool = !!elem.canPlayType;
                                if (bool) {
                                    bool = new Boolean(bool);
                                }
                            } catch (e) {}
                            return bool;
                        }));
                        try {
                            if (!!elem.canPlayType) {
                                Modernizr.addTest("audio.ogg", elem.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/, ""));
                                Modernizr.addTest("audio.mp3", elem.canPlayType('audio/mpeg; codecs="mp3"').replace(/^no$/, ""));
                                Modernizr.addTest("audio.opus", elem.canPlayType('audio/ogg; codecs="opus"') || elem.canPlayType('audio/webm; codecs="opus"').replace(/^no$/, ""));
                                Modernizr.addTest("audio.wav", elem.canPlayType('audio/wav; codecs="1"').replace(/^no$/, ""));
                                Modernizr.addTest("audio.m4a", (elem.canPlayType("audio/x-m4a;") || elem.canPlayType("audio/aac;")).replace(/^no$/, ""));
                            }
                        } catch (e) {}
                    })();
                    Modernizr.addAsyncTest((function() {
                        var timeout;
                        var waitTime = 200;
                        var retries = 5;
                        var currentTry = 0;
                        var elem = createElement("audio");
                        var elemStyle = elem.style;
                        function testAutoplay(arg) {
                            currentTry++;
                            clearTimeout(timeout);
                            var result = arg && arg.type === "playing" || elem.currentTime !== 0;
                            if (!result && currentTry < retries) {
                                timeout = setTimeout(testAutoplay, waitTime);
                                return;
                            }
                            elem.removeEventListener("playing", testAutoplay, false);
                            addTest("audioautoplay", result);
                            if (elem.parentNode) {
                                elem.parentNode.removeChild(elem);
                            }
                        }
                        if (!Modernizr.audio || !("autoplay" in elem)) {
                            addTest("audioautoplay", false);
                            return;
                        }
                        elemStyle.position = "absolute";
                        elemStyle.height = 0;
                        elemStyle.width = 0;
                        try {
                            if (Modernizr.audio.mp3) {
                                elem.src = "data:audio/mpeg;base64,/+MYxAAAAANIAUAAAASEEB/jwOFM/0MM/90b/+RhST//w4NFwOjf///PZu////9lns5GFDv//l9GlUIEEIAAAgIg8Ir/JGq3/+MYxDsLIj5QMYcoAP0dv9HIjUcH//yYSg+CIbkGP//8w0bLVjUP///3Z0x5QCAv/yLjwtGKTEFNRTMuOTeqqqqqqqqqqqqq/+MYxEkNmdJkUYc4AKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq";
                            } else if (Modernizr.audio.wav) {
                                elem.src = "data:audio/wav;base64,UklGRjQAAABXQVZFZm10IBAAAAABAAEAEAAAABAAAAABAAgAZGF0YRAAAAB/f39/f39/f39/f39/f39/";
                            } else {
                                addTest("audioautoplay", false);
                                return;
                            }
                        } catch (e) {
                            addTest("audioautoplay", false);
                            return;
                        }
                        elem.setAttribute("autoplay", "");
                        elemStyle.cssText = "display:none";
                        docElement.appendChild(elem);
                        setTimeout((function() {
                            elem.addEventListener("playing", testAutoplay, false);
                            timeout = setTimeout(testAutoplay, waitTime);
                        }), 0);
                    }));
                    Modernizr.addTest("audioloop", "loop" in createElement("audio"));
                    Modernizr.addAsyncTest((function() {
                        var timeout;
                        var waitTime = 300;
                        var elem = createElement("audio");
                        var elemStyle = elem.style;
                        function testpreload(event) {
                            clearTimeout(timeout);
                            var result = event !== undefined && event.type === "loadeddata" ? true : false;
                            elem.removeEventListener("loadeddata", testpreload, false);
                            addTest("audiopreload", result);
                            if (elem.parentNode) {
                                elem.parentNode.removeChild(elem);
                            }
                        }
                        if (!Modernizr.audio || !("preload" in elem)) {
                            addTest("audiopreload", false);
                            return;
                        }
                        elemStyle.position = "absolute";
                        elemStyle.height = 0;
                        elemStyle.width = 0;
                        try {
                            if (Modernizr.audio.mp3) {
                                elem.src = "data:audio/mpeg;base64,//MUxAAB6AXgAAAAAPP+c6nf//yi/6f3//MUxAMAAAIAAAjEcH//0fTX6C9Lf//0//MUxA4BeAIAAAAAAKX2/6zv//+IlR4f//MUxBMCMAH8AAAAABYWalVMQU1FMy45//MUxBUB0AH0AAAAADkuM1VVVVVVVVVV//MUxBgBUATowAAAAFVVVVVVVVVVVVVV";
                            } else if (Modernizr.audio.m4a) {
                                elem.src = "data:audio/x-m4a;base64,AAAAGGZ0eXBNNEEgAAACAGlzb21pc28yAAAACGZyZWUAAAAfbWRhdN4EAABsaWJmYWFjIDEuMjgAAAFoAQBHAAACiG1vb3YAAABsbXZoZAAAAAB8JbCAfCWwgAAAA+gAAAAYAAEAAAEAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAIAAAG0dHJhawAAAFx0a2hkAAAAD3wlsIB8JbCAAAAAAQAAAAAAAAAYAAAAAAAAAAAAAAAAAQAAAAABAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAABUG1kaWEAAAAgbWRoZAAAAAB8JbCAfCWwgAAArEQAAAQAVcQAAAAAAC1oZGxyAAAAAAAAAABzb3VuAAAAAAAAAAAAAAAAU291bmRIYW5kbGVyAAAAAPttaW5mAAAAEHNtaGQAAAAAAAAAAAAAACRkaW5mAAAAHGRyZWYAAAAAAAAAAQAAAAx1cmwgAAAAAQAAAL9zdGJsAAAAW3N0c2QAAAAAAAAAAQAAAEttcDRhAAAAAAAAAAEAAAAAAAAAAAACABAAAAAArEQAAAAAACdlc2RzAAAAAAMZAAEABBFAFQAAAAABftAAAAAABQISCAYBAgAAABhzdHRzAAAAAAAAAAEAAAABAAAEAAAAABxzdHNjAAAAAAAAAAEAAAABAAAAAQAAAAEAAAAUc3RzegAAAAAAAAAXAAAAAQAAABRzdGNvAAAAAAAAAAEAAAAoAAAAYHVkdGEAAABYbWV0YQAAAAAAAAAhaGRscgAAAAAAAAAAbWRpcmFwcGwAAAAAAAAAAAAAAAAraWxzdAAAACOpdG9vAAAAG2RhdGEAAAABAAAAAExhdmY1Mi42NC4y";
                            } else if (Modernizr.audio.ogg) {
                                elem.src = "data:audio/ogg;base64,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lFJKKaWUUkoppZRSSimllFJKKaWUUkqppJRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoplVJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSSimllFJKKaWUUkoppZRSCgCQinAAkHowoQwUGrISAEgFAACMUUopxpyDEDHmGGPQSSgpYsw5xhyUklLlHIQQUmktt8o5CCGk1FJtmXNSWosx5hgz56SkFFvNOYdSUoux5ppr7qS0VmuuNedaWqs115xzzbm0FmuuOdecc8sx15xzzjnnGHPOOeecc84FAOA0OACAHtiwOsJJ0VhgoSErAYBUAAACGaUYc8456BBSjDnnHIQQIoUYc845CCFUjDnnHHQQQqgYc8w5CCGEkDnnHIQQQgghcw466CCEEEIHHYQQQgihlM5BCCGEEEooIYQQQgghhBA6CCGEEEIIIYQQQgghhFJKCCGEEEIJoZRQAABggQMAQIANqyOcFI0FFhqyEgAAAgCAHJagUs6EQY5Bjw1BylEzDUJMOdGZYk5qMxVTkDkQnXQSGWpB2V4yCwAAgCAAIMAEEBggKPhCCIgxAABBiMwQCYVVsMCgDBoc5gHAA0SERACQmKBIu7iALgNc0MVdB0IIQhCCWBxAAQk4OOGGJ97whBucoFNU6iAAAAAAAAwA4AEA4KAAIiKaq7C4wMjQ2ODo8AgAAAAAABYA+AAAOD6AiIjmKiwuMDI0Njg6PAIAAAAAAAAAAICAgAAAAAAAQAAAAICAT2dnUwAE7AwAAAAAAAD/QwAAAgAAADuydfsFAQEBAQEACg4ODg==";
                            } else if (Modernizr.audio.wav) {
                                elem.src = "data:audio/wav;base64,UklGRvwZAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YdgZAAAAAAEA/v8CAP//AAABAP////8DAPz/BAD9/wEAAAAAAAAAAAABAP7/AgD//wAAAQD//wAAAQD//wAAAQD+/wIA//8AAAAAAAD//wIA/v8BAAAA//8BAAAA//8BAP//AQAAAP//AQD//wEAAAD//wEA//8BAP//AQD//wEA//8BAP//AQD+/wMA/f8DAP3/AgD+/wIA/////wMA/f8CAP7/AgD+/wMA/f8CAP7/AgD//wAAAAAAAAAAAQD+/wIA/v8CAP7/AwD9/wIA/v8BAAEA/v8CAP7/AQAAAAAAAAD//wEAAAD//wIA/f8DAP7/AQD//wEAAAD//wEA//8CAP7/AQD//wIA/v8CAP7/AQAAAAAAAAD//wEAAAAAAAAA//8BAP//AgD9/wQA+/8FAPz/AgAAAP//AgD+/wEAAAD//wIA/v8CAP3/BAD8/wQA/P8DAP7/AwD8/wQA/P8DAP7/AQAAAAAA//8BAP//AgD+/wEAAAD//wIA/v8BAP//AQD//wEAAAD//wEA//8BAAAAAAAAAP//AgD+/wEAAAAAAAAAAAD//wEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//AgD+/wIA/v8BAP//AQABAP7/AQD//wIA/v8CAP3/AwD/////AgD9/wMA/v8BAP//AQAAAP//AQD//wEA//8BAP//AAABAP//AAABAP//AQD//wAAAAACAP3/AwD9/wIA//8BAP//AQD//wEA//8BAP//AgD9/wMA/v8AAAIA/f8CAAAA/v8EAPv/BAD9/wIAAAD+/wQA+v8HAPr/BAD+/wEAAAD//wIA/f8EAPz/BAD7/wUA/P8EAPz/AwD+/wEAAAD//wEAAAAAAP//AgD8/wUA+/8FAPz/AwD9/wIA//8AAAEA/v8CAP//AQD//wAAAAABAP//AgD9/wMA/f8EAPz/AwD+/wAAAwD7/wUA/P8DAP7/AQAAAP//AgD+/wEAAQD+/wIA/v8BAAEA/v8CAP7/AQAAAP//AgD9/wMA/f8DAP7/AgD+/wEAAAAAAAEA//8AAAEA/v8DAP3/AgD//wEA//8BAP7/AwD9/wMA/v8BAP//AQAAAP//AgD9/wMA/v8BAP//AQAAAP//AgD+/wEAAQD+/wIA/////wIA//8AAAEA/f8DAP//AAABAP////8DAP3/AwD+/wEA//8BAP//AQAAAAAA//8BAP//AQD//wEA//8BAP//AAAAAAEA//8BAP7/AgD//wEA//8AAAAAAAAAAAAAAAD//wIA/v8BAAAA//8BAAEA/v8BAAAA//8DAPz/AwD+/wIA/v8CAP3/AwD+/wEAAAD//wEA//8BAAAA//8BAAAA/v8EAPv/BAD+/wAAAAABAP7/AgD//wAAAAABAP7/AgD//wAAAAAAAAAAAAABAP3/BAD8/wQA/f8BAAAAAAABAP7/AgD+/wIA/v8CAP7/AgD+/wIA/v8BAAAAAAD//wIA/f8DAP7/AAABAP//AAACAPz/BAD9/wIA//8AAP//AwD9/wMA/P8EAP3/AwD9/wIA//8BAP//AQD+/wMA/f8DAP7/AAABAP//AQAAAP//AQD//wIA/f8DAP7/AQAAAP//AQAAAAAA//8CAP7/AQABAP7/AgD+/wEAAQD+/wIA/v8CAP////8CAP7/AgD//wAAAAABAP7/AwD9/wIAAAD+/wMA/f8CAP//AQD+/wMA/f8CAP//AAACAPz/BQD6/wUA/v///wIA/v8CAP3/BAD7/wYA+v8FAPz/AwD/////AgD+/wEAAAD//wEAAAD//wIA/f8DAP7/AQAAAP//AgD//wAA//8BAAAAAAAAAP//AQD//wEA//8AAAIA/f8DAP3/AgAAAP//AQD//wEA//8AAAEA//8BAP////8CAP//AAABAP3/BAD9/wIA/v8BAAEA//8BAP7/AgD//wEA//8AAAEA//8BAP//AAAAAAEA//8BAP7/AgD//wEA//8AAAAAAQD+/wIA/v8BAAAAAAD//wIA/v8BAAAAAAAAAAAAAQD+/wMA/f8CAP//AQD//wIA/f8DAP7/AQD//wEA//8CAP7/AAABAP7/AwD9/wMA/v8AAAEA//8BAAAAAAD//wIA/v8BAAAA//8CAP7/AgD+/wEA//8CAP7/AgD//wAAAAAAAAAAAQD//wEA/v8DAPz/BQD8/wIA//8AAAEAAAD//wEA//8BAP//AQAAAAAA//8BAP//AgD+/wEAAAAAAP//AQD+/wMA/////wEA/v8CAP//AQD//wEA//8AAAEA//8BAAAA/v8EAPz/AwD+/wEAAAAAAAAA//8CAP7/AQD//wEA//8BAP//AAABAP7/AwD9/wIA//8BAP//AQD//wEA//8AAAEA/v8EAPv/BAD9/wIA//8BAP7/AwD9/wIA//8AAAEA//8BAP//AQD//wAAAQD//wEAAAD+/wMA/v8AAAIA/f8DAP7/AQD//wAAAQD+/wMA/f8CAP//AAABAP7/AgD+/wMA/f8CAP7/AQABAP7/AgD+/wIA/v8CAP7/AwD8/wMA//8AAAEA//8AAAAAAAABAP//AQD//wAAAQD//wIA/f8DAP3/AwD+/wAAAgD9/wIA//8AAAEAAAD+/wMA/P8FAPv/BAD9/wIA//8AAP//AgD+/wIA/v8BAAAAAAD//wEAAAAAAP//AQD//wEA//8BAP//AAABAP7/AwD9/wIA//8BAP//AAABAP//AQD//wAAAQD//wEA//8BAP//AAABAAAA//8BAP7/AwD9/wMA/f8DAP3/AgD//wEA//8BAP7/AgD//wAAAgD8/wQA/f8CAP//AQD+/wMA/f8CAP7/AgD//wAAAAAAAAAAAAABAP7/AwD9/wIA/v8DAP3/AwD9/wIA/v8DAPz/BQD7/wQA/f8CAP7/AwD9/wMA/f8CAP//AQAAAP7/AwD+/wEA//8AAAEAAAAAAP//AAABAP//AQAAAP7/AwD9/wMA/f8CAP//AQD//wEA//8AAAIA/f8CAAAA//8BAAAA//8BAAAA/v8EAPv/BAD9/wIA//8AAAEA/v8CAP//AAABAP//AAABAP//AAABAP7/AwD8/wQA/f8CAAAA/v8DAP3/AwD9/wMA/v8BAAAA//8BAAAA//8CAP7/AQAAAAAAAAAAAAAA//8CAP7/AgD+/wIA/v8CAP7/AgD//wAAAQD//wAAAQD//wAAAQD//wAAAQD+/wIA//8AAAAAAQD+/wMA/f8CAP//AQD//wEA//8AAAEA/v8DAP3/AgD//wAAAAABAP7/AwD9/wIA//8AAAEA/v8DAP3/AgD//wAAAAABAP7/AwD8/wMA/v8CAP//AAD//wIA/v8CAP7/AQABAP7/AQAAAP//AgD/////AQD//wEAAAD//wEA/v8EAPv/BAD9/wMA/v8BAAAA//8BAAEA/P8GAPr/BQD8/wMA/v8BAAAA//8CAP7/AQABAP3/BAD7/wYA+/8EAPz/AwD//wEA//8BAP7/BAD8/wMA/v8AAAIA/v8BAAAA//8BAAAA//8BAAAA//8CAP3/AwD+/wAAAgD8/wUA/P8DAP7/AAABAAAAAAD//wEAAAD//wIA/f8DAP7/AQAAAAAAAAAAAAAAAAAAAAAAAAAAAAEA/f8EAPz/AwD/////AgD+/wIA/f8DAP7/AgD+/wEA//8CAP7/AQD//wEAAAAAAP//AQAAAP//AgD9/wMA/v8BAAAA//8BAP//AQAAAP//AAACAP3/BAD7/wQA/v8BAAAA//8BAP//AQAAAP//AQAAAP7/BAD7/wUA+/8EAP3/AgD//wAAAQD+/wIA//8AAAEA/v8CAP//AQD+/wEAAAAAAAAAAAD//wEA//8CAP3/AwD9/wIA//8AAAAAAAAAAAAA//8BAP//AgD+/wEA//8CAP7/AQAAAP//AgD/////AgD/////AgD+/wIA//8AAP//AQABAP7/AgD9/wMA/v8CAP////8BAAAAAAAAAAAA//8CAP////8DAPz/AwD+/wEAAAAAAP//AQD//wEAAAD//wEAAAD+/wQA+/8FAPz/AgAAAP//AgD9/wMA/v8BAAAAAAD//wEAAAD//wIA/v8BAAAAAAD//wIA/v8BAAAA//8BAAAA//8CAP7/AQD//wEA//8BAAAA//8BAP//AAABAP//AQAAAP7/AgD//wEA//8AAAAAAQD+/wMA/P8EAP7///8DAPz/BQD8/wEAAQD+/wMA/v8AAAEA//8BAP//AQD//wEA/v8CAP//AQD//wAAAAABAAAA//8BAP//AQAAAAAA//8BAP//AgD+/wAAAQD//wIA/f8CAP//AQAAAP7/AwD9/wMA/v8BAP//AAABAP//AgD9/wIA//8BAAAA//8BAAAA//8CAP3/AwD+/wEAAAD+/wQA/P8DAP7/AAACAP7/AQAAAP//AQAAAP//AQAAAP//AgD9/wIAAAD//wIA/f8DAP7/AQD//wEA//8CAP7/AQD//wAAAQD//wEA//8AAAAAAQD//wEAAAD9/wUA+/8FAPz/AgD//wAAAQD//wAAAQD+/wMA/f8BAAEA/v8CAP7/AgD+/wIA/v8BAAAAAAAAAAAAAAD//wIA/v8CAP////8CAP7/AgD+/wIA/v8CAP7/AQAAAP//AQAAAP//AQD//wAAAQD//wAAAQD+/wMA/f8CAAAA/v8DAP3/AgAAAP//AQAAAP7/AwD9/wMA/v8BAP//AQD//wEAAAD+/wMA/f8CAAAA/v8CAP//AAAAAAEA//8AAAEA/v8DAP3/AwD9/wIA//8BAP//AgD8/wQA/v8BAAAA/v8CAP//AQD//wAAAAAAAAEA/f8EAPz/BAD9/wIA//8AAAAAAAABAP//AAAAAAAAAAABAP3/BAD9/wIA/v8BAAEA//8AAAAA//8CAP7/AgD9/wQA+/8FAPv/BQD8/wMA/f8DAP3/AwD+/wAAAgD9/wMA/f8CAAAA/v8EAPv/BQD7/wUA/P8DAP///v8DAP3/BAD8/wMA/f8DAP7/AQD//wEAAAD//wEA/v8CAAAA/v8CAP7/AgD//wAAAAAAAAAAAQD+/wIA//8AAAEA/v8DAPz/BAD9/wIA//8AAP//AgD//wEA/v8BAAAAAQD//wAAAAAAAAEA//8AAAEA//8BAP//AAABAP//AQD+/wIA/v8DAPz/BAD8/wQA/f8BAAAAAQD+/wMA/P8DAP//AAAAAAAAAAD//wMA+/8FAP3/AQABAP3/BAD8/wMA/v8BAAAA//8CAP3/AwD+/wEAAQD9/wMA/f8EAPz/BAD7/wQA/v8BAAEA/f8DAP7/AQAAAP//AgD+/wEAAAD//wIA/v8CAP7/AgD+/wEAAQD//wEA/v8CAP7/BAD7/wQA/f8CAAAA//8AAAAAAAABAP//AQD+/wEAAQD+/wMA/f8BAAEA/v8DAPz/AwD/////AwD8/wQA/P8DAP7/AgD//wAA//8BAAAAAAAAAP//AgD+/wEAAAD//wIA/v8BAAAA//8CAP3/AgD//wAAAQD+/wIA/v8BAAAA//8CAP7/AgD+/wEA//8CAP3/BAD7/wQA/v8BAAAA//8AAAEAAAD//wIA/f8DAP7/AgD+/wIA/v8CAP7/AgD+/wEAAAAAAP//AgD9/wMA/v8BAP//AgD9/wMA/v8AAAEA//8BAP//AQD//wEA//8AAAEA/v8EAPz/AgD//wAAAQAAAP//AAABAP//AQD//wEAAAD//wEA//8BAAEA/f8DAP7/AQABAP3/AwD+/wIA/////wEAAAAAAAAAAAD//wIA/v8CAP////8CAP7/AgD//wAA//8CAP3/BAD9/wAAAgD9/wMA/v8BAP//AQAAAP//AQAAAP//AgD9/wMA/f8EAPz/AwD+/wEAAAAAAAAAAAD//wIA/f8EAP3/AAABAAAA//8CAP7/AQAAAP//AQAAAAAA//8BAP//AQAAAP//AQAAAP//AQAAAP//AgD9/wMA/v8BAP//AQAAAP//AQD//wIA/v8CAP3/BAD9/wEAAAD//wEAAQD9/wMA/f8CAAAA/v8DAP3/AgD//wAAAQD+/wIA/v8CAP7/AQAAAP//AgD+/wEAAAAAAP//AwD7/wUA/f8BAAEA/v8BAAEA/v8DAP3/AgD//wEA//8BAP//AQD//wEA//8CAP3/BAD7/wQA/////wIA/v8AAAIA/v8CAP3/BAD7/wUA/P8DAP3/AwD9/wMA/v8AAAIA/v8CAP7/AgD+/wIA//8AAAEA/v8CAP7/AgD//wAAAAD//wEAAAAAAAAA//8BAP7/BAD7/wUA/P8CAAAA//8BAP//AQAAAP//AgD9/wMA/v8BAAAA//8BAAAA//8CAP3/AwD+/wEA//8CAP3/AwD+/wAAAwD8/wIAAAD//wIA/////wIA/v8CAP7/AgD+/wEAAAAAAAAAAAAAAP//AgD+/wIA//8AAAAA//8CAP7/AgD+/wEA//8CAP3/AwD9/wMA/v8BAP7/AwD9/wMA/f8CAP//AQD+/wIA//8BAP//AQD+/wMA/v8BAAAA//8BAAAA//8CAP7/AQAAAP//AgD+/wIA/v8CAP//AAAAAAEA//8BAP//AAABAAAA//8BAP//AQD//wEA//8BAP//AQAAAP//AQD//wEAAAD//wIA/f8CAAAA//8BAAAA//8BAP//AAABAP//AQD//wAAAAAAAAEA/v8CAP//AQD//wAAAAABAP7/AwD9/wIAAAD+/wIA//8BAP//AgD9/wMA/f8DAP7/AgD+/wEAAAAAAAEA/v8CAP7/AgD//wAAAAAAAAAAAAAAAP//AgD/////AgD9/wQA/f8BAAAAAAAAAAEA/f8DAP////8DAP3/AQABAP7/AgD//wAAAQD+/wMA/f8CAP7/AQABAP7/AwD7/wYA+v8FAP3/AQABAP7/AgD+/wMA/f8CAP7/AwD+/wEA//8BAP//AQAAAP7/BQD5/wcA+v8FAPz/AwD+/wIA/v8BAAAA//8DAPv/BQD8/wMA/////wEAAAAAAAAAAAD//wIA/f8DAP7/AQAAAP//AQAAAP//AgD+/wIA/v8BAAEA/f8EAPz/AwD+/wEA//8CAP7/AQD//wEA//8CAP7/AQAAAP//AgD+/wEAAAAAAAAAAAAAAAAAAAD//wIA/f8EAPz/AwD+/wEA//8CAP7/AgD+/wEAAQD+/wEAAQD+/wIA/////wIA//8AAAAAAAAAAAAAAAD//wEAAAAAAP//AgD9/wMA/v8BAP//AQAAAP//AQD//wEA//8BAP//AQD//wEA//8BAP//AQAAAP7/AwD9/wMA/v8BAP7/AwD9/wMA/v8BAP//AAABAP//AQD//wAAAAABAP//AAAAAAAAAQD//wEA/v8CAAAA/v8EAPv/BAD9/wIAAAD+/wMA/P8DAP//AAAAAP//AQD//wIA/f8DAP3/AwD9/wMA/v8BAAAA//8BAAAA//8CAP3/AwD9/wQA+/8FAPv/BQD8/wMA/v8BAAAA//8BAP//AgD+/wEAAAD//wIA/v8BAAEA/f8DAP3/AgAAAP//AQD//wAAAQD//wEA//8BAP//AQD//wEA/v8DAP3/AgAAAP7/AwD9/wIAAAD//wEAAAD//wIA/f8DAP7/AgD9/wQA+/8FAPz/AgAAAP//AgD9/wIA//8BAP//AQD//wEA//8BAP//AQD//wIA/f8DAP3/AgD//wAAAQD+/wIA/v8BAAEA/v8CAP7/AgD+/wMA/P8DAP//AAABAP7/AQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEA/v8CAP3/BAD8/wMA/v8BAAAAAAD//wEAAAAAAAAAAAD//wEAAAAAAAAA//8BAP//AgD+/wEA//8CAP3/AwD9/wMA/f8EAPv/BAD+/wAAAQD//wEA//8BAP//AAABAP//AQD//wEAAAD//wEA//8BAP//AgD9/wMA/v8AAAIA/f8DAP7/AAACAP3/AwD+/wEA//8BAP//AQAAAP//AQAAAP7/AwD9/wMA/v8AAAEA//8BAP//AAAAAAEA//8AAAEA/v8CAP//AAAAAAEA/v8DAPz/BAD9/wEAAQD+/wEAAQD9/wQA/P8DAP7/AQAAAAAAAAAAAAAAAAAAAAAAAQD+/wIA/////wIA/v8BAAAA//8BAP//AQD//wEA//8BAAAA/v8EAPz/AwD///7/BAD8/wMA/////wIA/v8CAP////8CAP7/AgD+/wIA/v8CAP////8CAP7/AwD9/wIA/v8CAP//AAABAP7/AwD9/wEAAQD+/wMA/f8CAP//AAAAAAEA/v8DAPz/BAD9/wIA/v8CAP7/AgD//wAAAAD//wIA/v8CAP7/AQAAAAAA//8CAP7/AgD+/wIA/v8CAP7/AwD8/wUA+v8GAPv/AwD//wAAAAAAAAAA//8DAPv/BQD9/wAAAgD9/wMA/v8BAP//AQAAAP//AgD9/wMA/v8BAAAA//8BAAAAAAAAAP//AQAAAAAAAAD//wEA//8CAP3/AwD+/wAAAgD+/wEAAAD//wIA/v8CAP7/AgD/////AwD8/wUA/P8CAP//AQD//wIA/f8DAP3/AwD+/wAAAQD+/wMA/f8DAP3/AgD//wAAAQD//wEA//8BAP7/AwD+/wEA//8AAAEA//8CAPz/BAD9/wIA//8AAAEA/v8DAPz/BAD9/wIA//8AAAEA/v8CAP7/AgD//wEA/f8EAPz/BAD+////AgD//wAAAQD//wAAAQD//wEA//8BAP7/AwD+/wEA";
                            } else {
                                addTest("audiopreload", false);
                                return;
                            }
                        } catch (e) {
                            addTest("audiopreload", false);
                            return;
                        }
                        elem.setAttribute("preload", "auto");
                        elem.style.cssText = "display:none";
                        docElement.appendChild(elem);
                        setTimeout((function() {
                            elem.addEventListener("loadeddata", testpreload, false);
                            timeout = setTimeout(testpreload, waitTime);
                        }), 0);
                    }));
                    Modernizr.addTest("cors", "XMLHttpRequest" in window && "withCredentials" in new XMLHttpRequest);
                    Modernizr.addTest("cssall", "all" in docElement.style);
                    Modernizr.addTest("cssanimations", testAllProps("animationName", "a", true));
                    Modernizr.addTest("cssgridlegacy", testAllProps("grid-columns", "10px", true));
                    Modernizr.addTest("cssgrid", testAllProps("grid-template-rows", "none", true));
                    Modernizr.addTest("cubicbezierrange", (function() {
                        var el = createElement("a");
                        el.style.cssText = prefixes.join("transition-timing-function:cubic-bezier(1,0,0,1.1); ");
                        return !!el.style.length;
                    }));
                    var supportsFn = window.CSS && window.CSS.supports.bind(window.CSS) || window.supportsCSS;
                    Modernizr.addTest("customproperties", !!supportsFn && (supportsFn("--f:0") || supportsFn("--f", 0)));
                    Modernizr.addTest("focusvisible", (function() {
                        try {
                            document.querySelector(":focus-visible");
                        } catch (error) {
                            return false;
                        }
                        return true;
                    }));
                    Modernizr.addTest("focuswithin", (function() {
                        try {
                            document.querySelector(":focus-within");
                        } catch (error) {
                            return false;
                        }
                        return true;
                    }));
                    Modernizr.addTest("hairline", (function() {
                        return testStyles("#modernizr {border:.5px solid transparent}", (function(elem) {
                            return elem.offsetHeight === 1;
                        }));
                    }));
                    Modernizr.addTest("hsla", (function() {
                        var style = createElement("a").style;
                        style.cssText = "background-color:hsla(120,40%,100%,.5)";
                        return contains(style.backgroundColor, "rgba") || contains(style.backgroundColor, "hsla");
                    }));
                    Modernizr.addTest("mediaqueries", mq("only all"));
                    Modernizr.addTest("multiplebgs", (function() {
                        var style = createElement("a").style;
                        style.cssText = "background:url(https://),url(https://),red url(https://)";
                        return /(url\s*\(.*?){3}/.test(style.background);
                    }));
                    Modernizr.addTest("objectfit", !!prefixed("objectFit"), {
                        aliases: [ "object-fit" ]
                    });
                    Modernizr.addTest("csspointerevents", (function() {
                        var style = createElement("a").style;
                        style.cssText = "pointer-events:auto";
                        return style.pointerEvents === "auto";
                    }));
                    Modernizr.addTest("csspositionsticky", (function() {
                        var prop = "position:";
                        var value = "sticky";
                        var el = createElement("a");
                        var mStyle = el.style;
                        mStyle.cssText = prop + prefixes.join(value + ";" + prop).slice(0, -prop.length);
                        return mStyle.position.indexOf(value) !== -1;
                    }));
                    testStyles("#modernizr{overflow: scroll; width: 40px; height: 40px; }#" + prefixes.join("scrollbar{width:10px}" + " #modernizr::").split("#").slice(1).join("#") + "scrollbar{width:10px}", (function(node) {
                        Modernizr.addTest("cssscrollbar", "scrollWidth" in node && node.scrollWidth === 30);
                    }));
                    Modernizr.addTest("scrollsnappoints", testAllProps("scrollSnapType"));
                    testStyles("#modernizr{position: absolute; top: -10em; visibility:hidden; font: normal 10px arial;}#subpixel{float: left; font-size: 33.3333%;}", (function(elem) {
                        var subpixel = elem.firstChild;
                        subpixel.innerHTML = "This is a text written in Arial";
                        Modernizr.addTest("subpixelfont", computedStyle(subpixel, null, "width") !== "44px");
                    }), 1, [ "subpixel" ]);
                    Modernizr.addTest("willchange", "willChange" in docElement.style);
                    Modernizr.addTest("hidden", "hidden" in createElement("a"));
                    Modernizr.addTest("intersectionobserver", "IntersectionObserver" in window);
                    Modernizr.addTest("canvas", (function() {
                        var elem = createElement("canvas");
                        return !!(elem.getContext && elem.getContext("2d"));
                    }));
                    Modernizr.addTest("canvastext", (function() {
                        if (Modernizr.canvas === false) {
                            return false;
                        }
                        return typeof createElement("canvas").getContext("2d").fillText === "function";
                    }));
                    Modernizr.addTest("emoji", (function() {
                        if (!Modernizr.canvastext) {
                            return false;
                        }
                        var node = createElement("canvas");
                        var ctx = node.getContext("2d");
                        var backingStoreRatio = ctx.webkitBackingStorePixelRatio || ctx.mozBackingStorePixelRatio || ctx.msBackingStorePixelRatio || ctx.oBackingStorePixelRatio || ctx.backingStorePixelRatio || 1;
                        var offset = 12 * backingStoreRatio;
                        ctx.fillStyle = "#f00";
                        ctx.textBaseline = "top";
                        ctx.font = "32px Arial";
                        ctx.fillText("🐨", 0, 0);
                        return ctx.getImageData(offset, offset, 1, 1).data[0] !== 0;
                    }));
                    Modernizr.addTest("geolocation", "geolocation" in navigator);
                    Modernizr.addTest("hiddenscroll", (function() {
                        return testStyles("#modernizr {width:100px;height:100px;overflow:scroll}", (function(elem) {
                            return elem.offsetWidth === elem.clientWidth;
                        }));
                    }));
                    Modernizr.addTest("history", (function() {
                        var ua = navigator.userAgent;
                        if (!ua) {
                            return false;
                        }
                        if ((ua.indexOf("Android 2.") !== -1 || ua.indexOf("Android 4.0") !== -1) && ua.indexOf("Mobile Safari") !== -1 && ua.indexOf("Chrome") === -1 && ua.indexOf("Windows Phone") === -1 && location.protocol !== "file:") {
                            return false;
                        }
                        return window.history && "pushState" in window.history;
                    }));
                    Modernizr.addTest("htmlimports", "import" in createElement("link"));
                    Modernizr.addTest("ie8compat", !window.addEventListener && !!document.documentMode && document.documentMode === 7);
                    Modernizr.addTest("mediasource", "MediaSource" in window);
                    Modernizr.addTest("hovermq", mq("(hover)"));
                    Modernizr.addTest("pointermq", mq("(pointer:coarse),(pointer:fine),(pointer:none)"));
                    Modernizr.addTest("notification", (function() {
                        if (!window.Notification || !window.Notification.requestPermission) {
                            return false;
                        }
                        if (window.Notification.permission === "granted") {
                            return true;
                        }
                        try {
                            new window.Notification("");
                        } catch (e) {
                            if (e.name === "TypeError") {
                                return false;
                            }
                        }
                        return true;
                    }));
                    Modernizr.addTest("pagevisibility", !!prefixed("hidden", document, false));
                    Modernizr.addTest("performance", !!prefixed("performance", window));
                    Modernizr.addTest("scrolltooptions", (function() {
                        var body = getBody();
                        var returnTo = window.pageYOffset;
                        var needsFill = body.clientHeight <= window.innerHeight;
                        if (needsFill) {
                            var div = createElement("div");
                            div.style.height = window.innerHeight - body.clientHeight + 1 + "px";
                            div.style.display = "block";
                            body.appendChild(div);
                        }
                        window.scrollTo({
                            top: 1
                        });
                        var result = window.pageYOffset !== 0;
                        if (needsFill) {
                            body.removeChild(div);
                        }
                        window.scrollTo(0, returnTo);
                        return result;
                    }));
                    Modernizr.addTest("stylescoped", "scoped" in createElement("style"));
                    (function() {
                        var elem = createElement("video");
                        Modernizr.addTest("video", (function() {
                            var bool = false;
                            try {
                                bool = !!elem.canPlayType;
                                if (bool) {
                                    bool = new Boolean(bool);
                                }
                            } catch (e) {}
                            return bool;
                        }));
                        try {
                            if (!!elem.canPlayType) {
                                Modernizr.addTest("video.ogg", elem.canPlayType('video/ogg; codecs="theora"').replace(/^no$/, ""));
                                Modernizr.addTest("video.h264", elem.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/, ""));
                                Modernizr.addTest("video.h265", elem.canPlayType('video/mp4; codecs="hev1"').replace(/^no$/, ""));
                                Modernizr.addTest("video.webm", elem.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/, ""));
                                Modernizr.addTest("video.vp9", elem.canPlayType('video/webm; codecs="vp9"').replace(/^no$/, ""));
                                Modernizr.addTest("video.hls", elem.canPlayType('application/x-mpegURL; codecs="avc1.42E01E"').replace(/^no$/, ""));
                                Modernizr.addTest("video.av1", elem.canPlayType('video/mp4; codecs="av01"').replace(/^no$/, ""));
                            }
                        } catch (e) {}
                    })();
                    Modernizr.addAsyncTest((function() {
                        var timeout;
                        var waitTime = 200;
                        var retries = 5;
                        var currentTry = 0;
                        var elem = createElement("video");
                        var elemStyle = elem.style;
                        function testAutoplay(arg) {
                            currentTry++;
                            clearTimeout(timeout);
                            var result = arg && arg.type === "playing" || elem.currentTime !== 0;
                            if (!result && currentTry < retries) {
                                timeout = setTimeout(testAutoplay, waitTime);
                                return;
                            }
                            elem.removeEventListener("playing", testAutoplay, false);
                            addTest("videoautoplay", result);
                            if (elem.parentNode) {
                                elem.parentNode.removeChild(elem);
                            }
                        }
                        if (!Modernizr.video || !("autoplay" in elem)) {
                            addTest("videoautoplay", false);
                            return;
                        }
                        elemStyle.position = "absolute";
                        elemStyle.height = 0;
                        elemStyle.width = 0;
                        try {
                            if (Modernizr.video.ogg) {
                                elem.src = "data:video/ogg;base64,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";
                            } else if (Modernizr.video.h264) {
                                elem.src = "data:video/mp4;base64,AAAAIGZ0eXBpc29tAAACAGlzb21pc28yYXZjMW1wNDEAAAAIZnJlZQAAAs1tZGF0AAACrgYF//+q3EXpvebZSLeWLNgg2SPu73gyNjQgLSBjb3JlIDE0OCByMjYwMSBhMGNkN2QzIC0gSC4yNjQvTVBFRy00IEFWQyBjb2RlYyAtIENvcHlsZWZ0IDIwMDMtMjAxNSAtIGh0dHA6Ly93d3cudmlkZW9sYW4ub3JnL3gyNjQuaHRtbCAtIG9wdGlvbnM6IGNhYmFjPTEgcmVmPTMgZGVibG9jaz0xOjA6MCBhbmFseXNlPTB4MzoweDExMyBtZT1oZXggc3VibWU9NyBwc3k9MSBwc3lfcmQ9MS4wMDowLjAwIG1peGVkX3JlZj0xIG1lX3JhbmdlPTE2IGNocm9tYV9tZT0xIHRyZWxsaXM9MSA4eDhkY3Q9MSBjcW09MCBkZWFkem9uZT0yMSwxMSBmYXN0X3Bza2lwPTEgY2hyb21hX3FwX29mZnNldD0tMiB0aHJlYWRzPTEgbG9va2FoZWFkX3RocmVhZHM9MSBzbGljZWRfdGhyZWFkcz0wIG5yPTAgZGVjaW1hdGU9MSBpbnRlcmxhY2VkPTAgYmx1cmF5X2NvbXBhdD0wIGNvbnN0cmFpbmVkX2ludHJhPTAgYmZyYW1lcz0zIGJfcHlyYW1pZD0yIGJfYWRhcHQ9MSBiX2JpYXM9MCBkaXJlY3Q9MSB3ZWlnaHRiPTEgb3Blbl9nb3A9MCB3ZWlnaHRwPTIga2V5aW50PTI1MCBrZXlpbnRfbWluPTEwIHNjZW5lY3V0PTQwIGludHJhX3JlZnJlc2g9MCByY19sb29rYWhlYWQ9NDAgcmM9Y3JmIG1idHJlZT0xIGNyZj0yMy4wIHFjb21wPTAuNjAgcXBtaW49MCBxcG1heD02OSBxcHN0ZXA9NCBpcF9yYXRpbz0xLjQwIGFxPTE6MS4wMACAAAAAD2WIhAA3//728P4FNjuZQQAAAu5tb292AAAAbG12aGQAAAAAAAAAAAAAAAAAAAPoAAAAZAABAAABAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACAAACGHRyYWsAAABcdGtoZAAAAAMAAAAAAAAAAAAAAAEAAAAAAAAAZAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAEAAAAAAAgAAAAIAAAAAACRlZHRzAAAAHGVsc3QAAAAAAAAAAQAAAGQAAAAAAAEAAAAAAZBtZGlhAAAAIG1kaGQAAAAAAAAAAAAAAAAAACgAAAAEAFXEAAAAAAAtaGRscgAAAAAAAAAAdmlkZQAAAAAAAAAAAAAAAFZpZGVvSGFuZGxlcgAAAAE7bWluZgAAABR2bWhkAAAAAQAAAAAAAAAAAAAAJGRpbmYAAAAcZHJlZgAAAAAAAAABAAAADHVybCAAAAABAAAA+3N0YmwAAACXc3RzZAAAAAAAAAABAAAAh2F2YzEAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAgACAEgAAABIAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAY//8AAAAxYXZjQwFkAAr/4QAYZ2QACqzZX4iIhAAAAwAEAAADAFA8SJZYAQAGaOvjyyLAAAAAGHN0dHMAAAAAAAAAAQAAAAEAAAQAAAAAHHN0c2MAAAAAAAAAAQAAAAEAAAABAAAAAQAAABRzdHN6AAAAAAAAAsUAAAABAAAAFHN0Y28AAAAAAAAAAQAAADAAAABidWR0YQAAAFptZXRhAAAAAAAAACFoZGxyAAAAAAAAAABtZGlyYXBwbAAAAAAAAAAAAAAAAC1pbHN0AAAAJal0b28AAAAdZGF0YQAAAAEAAAAATGF2ZjU2LjQwLjEwMQ==";
                            } else {
                                addTest("videoautoplay", false);
                                return;
                            }
                        } catch (e) {
                            addTest("videoautoplay", false);
                            return;
                        }
                        elem.setAttribute("autoplay", "");
                        elemStyle.cssText = "display:none";
                        docElement.appendChild(elem);
                        setTimeout((function() {
                            elem.addEventListener("playing", testAutoplay, false);
                            timeout = setTimeout(testAutoplay, waitTime);
                        }), 0);
                    }));
                    Modernizr.addTest("videocrossorigin", "crossOrigin" in createElement("video"));
                    Modernizr.addTest("videoloop", "loop" in createElement("video"));
                    Modernizr.addTest("videopreload", "preload" in createElement("video"));
                    testRunner();
                    setClasses(classes);
                    delete ModernizrProto.addTest;
                    delete ModernizrProto.addAsyncTest;
                    for (var i = 0; i < Modernizr._q.length; i++) {
                        Modernizr._q[i]();
                    }
                    scriptGlobalObject.Modernizr = Modernizr;
                })(window, window, document);
                module.exports = window.Modernizr;
                if (hadGlobal) {
                    window.Modernizr = oldGlobal;
                } else {
                    delete window.Modernizr;
                }
            })(window);
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
    var __webpack_exports__ = __webpack_require__("./js/vendor/.modernizrrc");
})();
//# sourceMappingURL=rwp-modernizr.js.map