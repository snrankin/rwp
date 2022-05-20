(function() {
    var __webpack_modules__ = {
        "../node_modules/lazysizes/lazysizes.js": function(module) {
            (function(window, factory) {
                var lazySizes = factory(window, window.document, Date);
                window.lazySizes = lazySizes;
                if (true && module.exports) {
                    module.exports = lazySizes;
                }
            })(typeof window != "undefined" ? window : {}, (function l(window, document, Date) {
                "use strict";
                var lazysizes, lazySizesCfg;
                (function() {
                    var prop;
                    var lazySizesDefaults = {
                        lazyClass: "lazyload",
                        loadedClass: "lazyloaded",
                        loadingClass: "lazyloading",
                        preloadClass: "lazypreload",
                        errorClass: "lazyerror",
                        autosizesClass: "lazyautosizes",
                        fastLoadedClass: "ls-is-cached",
                        iframeLoadMode: 0,
                        srcAttr: "data-src",
                        srcsetAttr: "data-srcset",
                        sizesAttr: "data-sizes",
                        minSize: 40,
                        customMedia: {},
                        init: true,
                        expFactor: 1.5,
                        hFac: .8,
                        loadMode: 2,
                        loadHidden: true,
                        ricTimeout: 0,
                        throttleDelay: 125
                    };
                    lazySizesCfg = window.lazySizesConfig || window.lazysizesConfig || {};
                    for (prop in lazySizesDefaults) {
                        if (!(prop in lazySizesCfg)) {
                            lazySizesCfg[prop] = lazySizesDefaults[prop];
                        }
                    }
                })();
                if (!document || !document.getElementsByClassName) {
                    return {
                        init: function() {},
                        cfg: lazySizesCfg,
                        noSupport: true
                    };
                }
                var docElem = document.documentElement;
                var supportPicture = window.HTMLPictureElement;
                var _addEventListener = "addEventListener";
                var _getAttribute = "getAttribute";
                var addEventListener = window[_addEventListener].bind(window);
                var setTimeout = window.setTimeout;
                var requestAnimationFrame = window.requestAnimationFrame || setTimeout;
                var requestIdleCallback = window.requestIdleCallback;
                var regPicture = /^picture$/i;
                var loadEvents = [ "load", "error", "lazyincluded", "_lazyloaded" ];
                var regClassCache = {};
                var forEach = Array.prototype.forEach;
                var hasClass = function(ele, cls) {
                    if (!regClassCache[cls]) {
                        regClassCache[cls] = new RegExp("(\\s|^)" + cls + "(\\s|$)");
                    }
                    return regClassCache[cls].test(ele[_getAttribute]("class") || "") && regClassCache[cls];
                };
                var addClass = function(ele, cls) {
                    if (!hasClass(ele, cls)) {
                        ele.setAttribute("class", (ele[_getAttribute]("class") || "").trim() + " " + cls);
                    }
                };
                var removeClass = function(ele, cls) {
                    var reg;
                    if (reg = hasClass(ele, cls)) {
                        ele.setAttribute("class", (ele[_getAttribute]("class") || "").replace(reg, " "));
                    }
                };
                var addRemoveLoadEvents = function(dom, fn, add) {
                    var action = add ? _addEventListener : "removeEventListener";
                    if (add) {
                        addRemoveLoadEvents(dom, fn);
                    }
                    loadEvents.forEach((function(evt) {
                        dom[action](evt, fn);
                    }));
                };
                var triggerEvent = function(elem, name, detail, noBubbles, noCancelable) {
                    var event = document.createEvent("Event");
                    if (!detail) {
                        detail = {};
                    }
                    detail.instance = lazysizes;
                    event.initEvent(name, !noBubbles, !noCancelable);
                    event.detail = detail;
                    elem.dispatchEvent(event);
                    return event;
                };
                var updatePolyfill = function(el, full) {
                    var polyfill;
                    if (!supportPicture && (polyfill = window.picturefill || lazySizesCfg.pf)) {
                        if (full && full.src && !el[_getAttribute]("srcset")) {
                            el.setAttribute("srcset", full.src);
                        }
                        polyfill({
                            reevaluate: true,
                            elements: [ el ]
                        });
                    } else if (full && full.src) {
                        el.src = full.src;
                    }
                };
                var getCSS = function(elem, style) {
                    return (getComputedStyle(elem, null) || {})[style];
                };
                var getWidth = function(elem, parent, width) {
                    width = width || elem.offsetWidth;
                    while (width < lazySizesCfg.minSize && parent && !elem._lazysizesWidth) {
                        width = parent.offsetWidth;
                        parent = parent.parentNode;
                    }
                    return width;
                };
                var rAF = function() {
                    var running, waiting;
                    var firstFns = [];
                    var secondFns = [];
                    var fns = firstFns;
                    var run = function() {
                        var runFns = fns;
                        fns = firstFns.length ? secondFns : firstFns;
                        running = true;
                        waiting = false;
                        while (runFns.length) {
                            runFns.shift()();
                        }
                        running = false;
                    };
                    var rafBatch = function(fn, queue) {
                        if (running && !queue) {
                            fn.apply(this, arguments);
                        } else {
                            fns.push(fn);
                            if (!waiting) {
                                waiting = true;
                                (document.hidden ? setTimeout : requestAnimationFrame)(run);
                            }
                        }
                    };
                    rafBatch._lsFlush = run;
                    return rafBatch;
                }();
                var rAFIt = function(fn, simple) {
                    return simple ? function() {
                        rAF(fn);
                    } : function() {
                        var that = this;
                        var args = arguments;
                        rAF((function() {
                            fn.apply(that, args);
                        }));
                    };
                };
                var throttle = function(fn) {
                    var running;
                    var lastTime = 0;
                    var gDelay = lazySizesCfg.throttleDelay;
                    var rICTimeout = lazySizesCfg.ricTimeout;
                    var run = function() {
                        running = false;
                        lastTime = Date.now();
                        fn();
                    };
                    var idleCallback = requestIdleCallback && rICTimeout > 49 ? function() {
                        requestIdleCallback(run, {
                            timeout: rICTimeout
                        });
                        if (rICTimeout !== lazySizesCfg.ricTimeout) {
                            rICTimeout = lazySizesCfg.ricTimeout;
                        }
                    } : rAFIt((function() {
                        setTimeout(run);
                    }), true);
                    return function(isPriority) {
                        var delay;
                        if (isPriority = isPriority === true) {
                            rICTimeout = 33;
                        }
                        if (running) {
                            return;
                        }
                        running = true;
                        delay = gDelay - (Date.now() - lastTime);
                        if (delay < 0) {
                            delay = 0;
                        }
                        if (isPriority || delay < 9) {
                            idleCallback();
                        } else {
                            setTimeout(idleCallback, delay);
                        }
                    };
                };
                var debounce = function(func) {
                    var timeout, timestamp;
                    var wait = 99;
                    var run = function() {
                        timeout = null;
                        func();
                    };
                    var later = function() {
                        var last = Date.now() - timestamp;
                        if (last < wait) {
                            setTimeout(later, wait - last);
                        } else {
                            (requestIdleCallback || run)(run);
                        }
                    };
                    return function() {
                        timestamp = Date.now();
                        if (!timeout) {
                            timeout = setTimeout(later, wait);
                        }
                    };
                };
                var loader = function() {
                    var preloadElems, isCompleted, resetPreloadingTimer, loadMode, started;
                    var eLvW, elvH, eLtop, eLleft, eLright, eLbottom, isBodyHidden;
                    var regImg = /^img$/i;
                    var regIframe = /^iframe$/i;
                    var supportScroll = "onscroll" in window && !/(gle|ing)bot/.test(navigator.userAgent);
                    var shrinkExpand = 0;
                    var currentExpand = 0;
                    var isLoading = 0;
                    var lowRuns = -1;
                    var resetPreloading = function(e) {
                        isLoading--;
                        if (!e || isLoading < 0 || !e.target) {
                            isLoading = 0;
                        }
                    };
                    var isVisible = function(elem) {
                        if (isBodyHidden == null) {
                            isBodyHidden = getCSS(document.body, "visibility") == "hidden";
                        }
                        return isBodyHidden || !(getCSS(elem.parentNode, "visibility") == "hidden" && getCSS(elem, "visibility") == "hidden");
                    };
                    var isNestedVisible = function(elem, elemExpand) {
                        var outerRect;
                        var parent = elem;
                        var visible = isVisible(elem);
                        eLtop -= elemExpand;
                        eLbottom += elemExpand;
                        eLleft -= elemExpand;
                        eLright += elemExpand;
                        while (visible && (parent = parent.offsetParent) && parent != document.body && parent != docElem) {
                            visible = (getCSS(parent, "opacity") || 1) > 0;
                            if (visible && getCSS(parent, "overflow") != "visible") {
                                outerRect = parent.getBoundingClientRect();
                                visible = eLright > outerRect.left && eLleft < outerRect.right && eLbottom > outerRect.top - 1 && eLtop < outerRect.bottom + 1;
                            }
                        }
                        return visible;
                    };
                    var checkElements = function() {
                        var eLlen, i, rect, autoLoadElem, loadedSomething, elemExpand, elemNegativeExpand, elemExpandVal, beforeExpandVal, defaultExpand, preloadExpand, hFac;
                        var lazyloadElems = lazysizes.elements;
                        if ((loadMode = lazySizesCfg.loadMode) && isLoading < 8 && (eLlen = lazyloadElems.length)) {
                            i = 0;
                            lowRuns++;
                            for (;i < eLlen; i++) {
                                if (!lazyloadElems[i] || lazyloadElems[i]._lazyRace) {
                                    continue;
                                }
                                if (!supportScroll || lazysizes.prematureUnveil && lazysizes.prematureUnveil(lazyloadElems[i])) {
                                    unveilElement(lazyloadElems[i]);
                                    continue;
                                }
                                if (!(elemExpandVal = lazyloadElems[i][_getAttribute]("data-expand")) || !(elemExpand = elemExpandVal * 1)) {
                                    elemExpand = currentExpand;
                                }
                                if (!defaultExpand) {
                                    defaultExpand = !lazySizesCfg.expand || lazySizesCfg.expand < 1 ? docElem.clientHeight > 500 && docElem.clientWidth > 500 ? 500 : 370 : lazySizesCfg.expand;
                                    lazysizes._defEx = defaultExpand;
                                    preloadExpand = defaultExpand * lazySizesCfg.expFactor;
                                    hFac = lazySizesCfg.hFac;
                                    isBodyHidden = null;
                                    if (currentExpand < preloadExpand && isLoading < 1 && lowRuns > 2 && loadMode > 2 && !document.hidden) {
                                        currentExpand = preloadExpand;
                                        lowRuns = 0;
                                    } else if (loadMode > 1 && lowRuns > 1 && isLoading < 6) {
                                        currentExpand = defaultExpand;
                                    } else {
                                        currentExpand = shrinkExpand;
                                    }
                                }
                                if (beforeExpandVal !== elemExpand) {
                                    eLvW = innerWidth + elemExpand * hFac;
                                    elvH = innerHeight + elemExpand;
                                    elemNegativeExpand = elemExpand * -1;
                                    beforeExpandVal = elemExpand;
                                }
                                rect = lazyloadElems[i].getBoundingClientRect();
                                if ((eLbottom = rect.bottom) >= elemNegativeExpand && (eLtop = rect.top) <= elvH && (eLright = rect.right) >= elemNegativeExpand * hFac && (eLleft = rect.left) <= eLvW && (eLbottom || eLright || eLleft || eLtop) && (lazySizesCfg.loadHidden || isVisible(lazyloadElems[i])) && (isCompleted && isLoading < 3 && !elemExpandVal && (loadMode < 3 || lowRuns < 4) || isNestedVisible(lazyloadElems[i], elemExpand))) {
                                    unveilElement(lazyloadElems[i]);
                                    loadedSomething = true;
                                    if (isLoading > 9) {
                                        break;
                                    }
                                } else if (!loadedSomething && isCompleted && !autoLoadElem && isLoading < 4 && lowRuns < 4 && loadMode > 2 && (preloadElems[0] || lazySizesCfg.preloadAfterLoad) && (preloadElems[0] || !elemExpandVal && (eLbottom || eLright || eLleft || eLtop || lazyloadElems[i][_getAttribute](lazySizesCfg.sizesAttr) != "auto"))) {
                                    autoLoadElem = preloadElems[0] || lazyloadElems[i];
                                }
                            }
                            if (autoLoadElem && !loadedSomething) {
                                unveilElement(autoLoadElem);
                            }
                        }
                    };
                    var throttledCheckElements = throttle(checkElements);
                    var switchLoadingClass = function(e) {
                        var elem = e.target;
                        if (elem._lazyCache) {
                            delete elem._lazyCache;
                            return;
                        }
                        resetPreloading(e);
                        addClass(elem, lazySizesCfg.loadedClass);
                        removeClass(elem, lazySizesCfg.loadingClass);
                        addRemoveLoadEvents(elem, rafSwitchLoadingClass);
                        triggerEvent(elem, "lazyloaded");
                    };
                    var rafedSwitchLoadingClass = rAFIt(switchLoadingClass);
                    var rafSwitchLoadingClass = function(e) {
                        rafedSwitchLoadingClass({
                            target: e.target
                        });
                    };
                    var changeIframeSrc = function(elem, src) {
                        var loadMode = elem.getAttribute("data-load-mode") || lazySizesCfg.iframeLoadMode;
                        if (loadMode == 0) {
                            elem.contentWindow.location.replace(src);
                        } else if (loadMode == 1) {
                            elem.src = src;
                        }
                    };
                    var handleSources = function(source) {
                        var customMedia;
                        var sourceSrcset = source[_getAttribute](lazySizesCfg.srcsetAttr);
                        if (customMedia = lazySizesCfg.customMedia[source[_getAttribute]("data-media") || source[_getAttribute]("media")]) {
                            source.setAttribute("media", customMedia);
                        }
                        if (sourceSrcset) {
                            source.setAttribute("srcset", sourceSrcset);
                        }
                    };
                    var lazyUnveil = rAFIt((function(elem, detail, isAuto, sizes, isImg) {
                        var src, srcset, parent, isPicture, event, firesLoad;
                        if (!(event = triggerEvent(elem, "lazybeforeunveil", detail)).defaultPrevented) {
                            if (sizes) {
                                if (isAuto) {
                                    addClass(elem, lazySizesCfg.autosizesClass);
                                } else {
                                    elem.setAttribute("sizes", sizes);
                                }
                            }
                            srcset = elem[_getAttribute](lazySizesCfg.srcsetAttr);
                            src = elem[_getAttribute](lazySizesCfg.srcAttr);
                            if (isImg) {
                                parent = elem.parentNode;
                                isPicture = parent && regPicture.test(parent.nodeName || "");
                            }
                            firesLoad = detail.firesLoad || "src" in elem && (srcset || src || isPicture);
                            event = {
                                target: elem
                            };
                            addClass(elem, lazySizesCfg.loadingClass);
                            if (firesLoad) {
                                clearTimeout(resetPreloadingTimer);
                                resetPreloadingTimer = setTimeout(resetPreloading, 2500);
                                addRemoveLoadEvents(elem, rafSwitchLoadingClass, true);
                            }
                            if (isPicture) {
                                forEach.call(parent.getElementsByTagName("source"), handleSources);
                            }
                            if (srcset) {
                                elem.setAttribute("srcset", srcset);
                            } else if (src && !isPicture) {
                                if (regIframe.test(elem.nodeName)) {
                                    changeIframeSrc(elem, src);
                                } else {
                                    elem.src = src;
                                }
                            }
                            if (isImg && (srcset || isPicture)) {
                                updatePolyfill(elem, {
                                    src
                                });
                            }
                        }
                        if (elem._lazyRace) {
                            delete elem._lazyRace;
                        }
                        removeClass(elem, lazySizesCfg.lazyClass);
                        rAF((function() {
                            var isLoaded = elem.complete && elem.naturalWidth > 1;
                            if (!firesLoad || isLoaded) {
                                if (isLoaded) {
                                    addClass(elem, lazySizesCfg.fastLoadedClass);
                                }
                                switchLoadingClass(event);
                                elem._lazyCache = true;
                                setTimeout((function() {
                                    if ("_lazyCache" in elem) {
                                        delete elem._lazyCache;
                                    }
                                }), 9);
                            }
                            if (elem.loading == "lazy") {
                                isLoading--;
                            }
                        }), true);
                    }));
                    var unveilElement = function(elem) {
                        if (elem._lazyRace) {
                            return;
                        }
                        var detail;
                        var isImg = regImg.test(elem.nodeName);
                        var sizes = isImg && (elem[_getAttribute](lazySizesCfg.sizesAttr) || elem[_getAttribute]("sizes"));
                        var isAuto = sizes == "auto";
                        if ((isAuto || !isCompleted) && isImg && (elem[_getAttribute]("src") || elem.srcset) && !elem.complete && !hasClass(elem, lazySizesCfg.errorClass) && hasClass(elem, lazySizesCfg.lazyClass)) {
                            return;
                        }
                        detail = triggerEvent(elem, "lazyunveilread").detail;
                        if (isAuto) {
                            autoSizer.updateElem(elem, true, elem.offsetWidth);
                        }
                        elem._lazyRace = true;
                        isLoading++;
                        lazyUnveil(elem, detail, isAuto, sizes, isImg);
                    };
                    var afterScroll = debounce((function() {
                        lazySizesCfg.loadMode = 3;
                        throttledCheckElements();
                    }));
                    var altLoadmodeScrollListner = function() {
                        if (lazySizesCfg.loadMode == 3) {
                            lazySizesCfg.loadMode = 2;
                        }
                        afterScroll();
                    };
                    var onload = function() {
                        if (isCompleted) {
                            return;
                        }
                        if (Date.now() - started < 999) {
                            setTimeout(onload, 999);
                            return;
                        }
                        isCompleted = true;
                        lazySizesCfg.loadMode = 3;
                        throttledCheckElements();
                        addEventListener("scroll", altLoadmodeScrollListner, true);
                    };
                    return {
                        _: function() {
                            started = Date.now();
                            lazysizes.elements = document.getElementsByClassName(lazySizesCfg.lazyClass);
                            preloadElems = document.getElementsByClassName(lazySizesCfg.lazyClass + " " + lazySizesCfg.preloadClass);
                            addEventListener("scroll", throttledCheckElements, true);
                            addEventListener("resize", throttledCheckElements, true);
                            addEventListener("pageshow", (function(e) {
                                if (e.persisted) {
                                    var loadingElements = document.querySelectorAll("." + lazySizesCfg.loadingClass);
                                    if (loadingElements.length && loadingElements.forEach) {
                                        requestAnimationFrame((function() {
                                            loadingElements.forEach((function(img) {
                                                if (img.complete) {
                                                    unveilElement(img);
                                                }
                                            }));
                                        }));
                                    }
                                }
                            }));
                            if (window.MutationObserver) {
                                new MutationObserver(throttledCheckElements).observe(docElem, {
                                    childList: true,
                                    subtree: true,
                                    attributes: true
                                });
                            } else {
                                docElem[_addEventListener]("DOMNodeInserted", throttledCheckElements, true);
                                docElem[_addEventListener]("DOMAttrModified", throttledCheckElements, true);
                                setInterval(throttledCheckElements, 999);
                            }
                            addEventListener("hashchange", throttledCheckElements, true);
                            [ "focus", "mouseover", "click", "load", "transitionend", "animationend" ].forEach((function(name) {
                                document[_addEventListener](name, throttledCheckElements, true);
                            }));
                            if (/d$|^c/.test(document.readyState)) {
                                onload();
                            } else {
                                addEventListener("load", onload);
                                document[_addEventListener]("DOMContentLoaded", throttledCheckElements);
                                setTimeout(onload, 2e4);
                            }
                            if (lazysizes.elements.length) {
                                checkElements();
                                rAF._lsFlush();
                            } else {
                                throttledCheckElements();
                            }
                        },
                        checkElems: throttledCheckElements,
                        unveil: unveilElement,
                        _aLSL: altLoadmodeScrollListner
                    };
                }();
                var autoSizer = function() {
                    var autosizesElems;
                    var sizeElement = rAFIt((function(elem, parent, event, width) {
                        var sources, i, len;
                        elem._lazysizesWidth = width;
                        width += "px";
                        elem.setAttribute("sizes", width);
                        if (regPicture.test(parent.nodeName || "")) {
                            sources = parent.getElementsByTagName("source");
                            for (i = 0, len = sources.length; i < len; i++) {
                                sources[i].setAttribute("sizes", width);
                            }
                        }
                        if (!event.detail.dataAttr) {
                            updatePolyfill(elem, event.detail);
                        }
                    }));
                    var getSizeElement = function(elem, dataAttr, width) {
                        var event;
                        var parent = elem.parentNode;
                        if (parent) {
                            width = getWidth(elem, parent, width);
                            event = triggerEvent(elem, "lazybeforesizes", {
                                width,
                                dataAttr: !!dataAttr
                            });
                            if (!event.defaultPrevented) {
                                width = event.detail.width;
                                if (width && width !== elem._lazysizesWidth) {
                                    sizeElement(elem, parent, event, width);
                                }
                            }
                        }
                    };
                    var updateElementsSizes = function() {
                        var i;
                        var len = autosizesElems.length;
                        if (len) {
                            i = 0;
                            for (;i < len; i++) {
                                getSizeElement(autosizesElems[i]);
                            }
                        }
                    };
                    var debouncedUpdateElementsSizes = debounce(updateElementsSizes);
                    return {
                        _: function() {
                            autosizesElems = document.getElementsByClassName(lazySizesCfg.autosizesClass);
                            addEventListener("resize", debouncedUpdateElementsSizes);
                        },
                        checkElems: debouncedUpdateElementsSizes,
                        updateElem: getSizeElement
                    };
                }();
                var init = function() {
                    if (!init.i && document.getElementsByClassName) {
                        init.i = true;
                        autoSizer._();
                        loader._();
                    }
                };
                setTimeout((function() {
                    if (lazySizesCfg.init) {
                        init();
                    }
                }));
                lazysizes = {
                    cfg: lazySizesCfg,
                    autoSizer,
                    loader,
                    init,
                    uP: updatePolyfill,
                    aC: addClass,
                    rC: removeClass,
                    hC: hasClass,
                    fire: triggerEvent,
                    gW: getWidth,
                    rAF
                };
                return lazysizes;
            }));
        },
        "../node_modules/lazysizes/plugins/aspectratio/ls.aspectratio.js": function(module, exports, __webpack_require__) {
            var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;
            var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;
            (function(window, factory) {
                var globalInstall = function() {
                    factory(window.lazySizes);
                    window.removeEventListener("lazyunveilread", globalInstall, true);
                };
                factory = factory.bind(null, window, window.document);
                if (true && module.exports) {
                    factory(__webpack_require__("../node_modules/lazysizes/lazysizes.js"));
                } else if (true) {
                    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__("../node_modules/lazysizes/lazysizes.js") ], 
                    __WEBPACK_AMD_DEFINE_FACTORY__ = factory, __WEBPACK_AMD_DEFINE_RESULT__ = typeof __WEBPACK_AMD_DEFINE_FACTORY__ === "function" ? __WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__) : __WEBPACK_AMD_DEFINE_FACTORY__, 
                    __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
                } else {}
            })(window, (function(window, document, lazySizes) {
                "use strict";
                if (!window.addEventListener) {
                    return;
                }
                var forEach = Array.prototype.forEach;
                var imageRatio, extend$, $;
                var regPicture = /^picture$/i;
                var aspectRatioAttr = "data-aspectratio";
                var aspectRatioSel = "img[" + aspectRatioAttr + "]";
                var matchesMedia = function(media) {
                    if (window.matchMedia) {
                        matchesMedia = function(media) {
                            return !media || (matchMedia(media) || {}).matches;
                        };
                    } else if (window.Modernizr && Modernizr.mq) {
                        return !media || Modernizr.mq(media);
                    } else {
                        return !media;
                    }
                    return matchesMedia(media);
                };
                var addClass = lazySizes.aC;
                var removeClass = lazySizes.rC;
                var lazySizesConfig = lazySizes.cfg;
                function AspectRatio() {
                    this.ratioElems = document.getElementsByClassName("lazyaspectratio");
                    this._setupEvents();
                    this.processImages();
                }
                AspectRatio.prototype = {
                    _setupEvents: function() {
                        var module = this;
                        var addRemoveAspectRatio = function(elem) {
                            if (elem.naturalWidth < 36) {
                                module.addAspectRatio(elem, true);
                            } else {
                                module.removeAspectRatio(elem, true);
                            }
                        };
                        var onload = function() {
                            module.processImages();
                        };
                        document.addEventListener("load", (function(e) {
                            if (e.target.getAttribute && e.target.getAttribute(aspectRatioAttr)) {
                                addRemoveAspectRatio(e.target);
                            }
                        }), true);
                        addEventListener("resize", function() {
                            var timer;
                            var resize = function() {
                                forEach.call(module.ratioElems, addRemoveAspectRatio);
                            };
                            return function() {
                                clearTimeout(timer);
                                timer = setTimeout(resize, 99);
                            };
                        }());
                        document.addEventListener("DOMContentLoaded", onload);
                        addEventListener("load", onload);
                    },
                    processImages: function(context) {
                        var elements, i;
                        if (!context) {
                            context = document;
                        }
                        if ("length" in context && !context.nodeName) {
                            elements = context;
                        } else {
                            elements = context.querySelectorAll(aspectRatioSel);
                        }
                        for (i = 0; i < elements.length; i++) {
                            if (elements[i].naturalWidth > 36) {
                                this.removeAspectRatio(elements[i]);
                                continue;
                            }
                            this.addAspectRatio(elements[i]);
                        }
                    },
                    getSelectedRatio: function(img) {
                        var i, len, sources, customMedia, ratio;
                        var parent = img.parentNode;
                        if (parent && regPicture.test(parent.nodeName || "")) {
                            sources = parent.getElementsByTagName("source");
                            for (i = 0, len = sources.length; i < len; i++) {
                                customMedia = sources[i].getAttribute("data-media") || sources[i].getAttribute("media");
                                if (lazySizesConfig.customMedia[customMedia]) {
                                    customMedia = lazySizesConfig.customMedia[customMedia];
                                }
                                if (matchesMedia(customMedia)) {
                                    ratio = sources[i].getAttribute(aspectRatioAttr);
                                    break;
                                }
                            }
                        }
                        return ratio || img.getAttribute(aspectRatioAttr) || "";
                    },
                    parseRatio: function() {
                        var regRatio = /^\s*([+\d\.]+)(\s*[\/x]\s*([+\d\.]+))?\s*$/;
                        var ratioCache = {};
                        return function(ratio) {
                            var match;
                            if (!ratioCache[ratio] && (match = ratio.match(regRatio))) {
                                if (match[3]) {
                                    ratioCache[ratio] = match[1] / match[3];
                                } else {
                                    ratioCache[ratio] = match[1] * 1;
                                }
                            }
                            return ratioCache[ratio];
                        };
                    }(),
                    addAspectRatio: function(img, notNew) {
                        var ratio;
                        var width = img.offsetWidth;
                        var height = img.offsetHeight;
                        if (!notNew) {
                            addClass(img, "lazyaspectratio");
                        }
                        if (width < 36 && height <= 0) {
                            if (width || height && window.console) {
                                console.log("Define width or height of image, so we can calculate the other dimension");
                            }
                            return;
                        }
                        ratio = this.getSelectedRatio(img);
                        ratio = this.parseRatio(ratio);
                        if (ratio) {
                            if (width) {
                                img.style.height = width / ratio + "px";
                            } else {
                                img.style.width = height * ratio + "px";
                            }
                        }
                    },
                    removeAspectRatio: function(img) {
                        removeClass(img, "lazyaspectratio");
                        img.style.height = "";
                        img.style.width = "";
                        img.removeAttribute(aspectRatioAttr);
                    }
                };
                extend$ = function() {
                    $ = window.jQuery || window.Zepto || window.shoestring || window.$;
                    if ($ && $.fn && !$.fn.imageRatio && $.fn.filter && $.fn.add && $.fn.find) {
                        $.fn.imageRatio = function() {
                            imageRatio.processImages(this.find(aspectRatioSel).add(this.filter(aspectRatioSel)));
                            return this;
                        };
                    } else {
                        $ = false;
                    }
                };
                extend$();
                setTimeout(extend$);
                imageRatio = new AspectRatio;
                window.imageRatio = imageRatio;
                if (true && module.exports) {
                    module.exports = imageRatio;
                } else if (true) {
                    !(__WEBPACK_AMD_DEFINE_FACTORY__ = imageRatio, __WEBPACK_AMD_DEFINE_RESULT__ = typeof __WEBPACK_AMD_DEFINE_FACTORY__ === "function" ? __WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module) : __WEBPACK_AMD_DEFINE_FACTORY__, 
                    __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
                }
            }));
        },
        "../node_modules/lazysizes/plugins/native-loading/ls.native-loading.js": function(module, exports, __webpack_require__) {
            var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;
            (function(window, factory) {
                var globalInstall = function() {
                    factory(window.lazySizes);
                    window.removeEventListener("lazyunveilread", globalInstall, true);
                };
                factory = factory.bind(null, window, window.document);
                if (true && module.exports) {
                    factory(__webpack_require__("../node_modules/lazysizes/lazysizes.js"));
                } else if (true) {
                    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__("../node_modules/lazysizes/lazysizes.js") ], 
                    __WEBPACK_AMD_DEFINE_FACTORY__ = factory, __WEBPACK_AMD_DEFINE_RESULT__ = typeof __WEBPACK_AMD_DEFINE_FACTORY__ === "function" ? __WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__) : __WEBPACK_AMD_DEFINE_FACTORY__, 
                    __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
                } else {}
            })(window, (function(window, document, lazySizes) {
                "use strict";
                var imgSupport = "loading" in HTMLImageElement.prototype;
                var iframeSupport = "loading" in HTMLIFrameElement.prototype;
                var isConfigSet = false;
                var oldPrematureUnveil = lazySizes.prematureUnveil;
                var cfg = lazySizes.cfg;
                var listenerMap = {
                    focus: 1,
                    mouseover: 1,
                    click: 1,
                    load: 1,
                    transitionend: 1,
                    animationend: 1,
                    scroll: 1,
                    resize: 1
                };
                if (!cfg.nativeLoading) {
                    cfg.nativeLoading = {};
                }
                if (!window.addEventListener || !window.MutationObserver || !imgSupport && !iframeSupport) {
                    return;
                }
                function disableEvents() {
                    var loader = lazySizes.loader;
                    var throttledCheckElements = loader.checkElems;
                    var removeALSL = function() {
                        setTimeout((function() {
                            window.removeEventListener("scroll", loader._aLSL, true);
                        }), 1e3);
                    };
                    var currentListenerMap = typeof cfg.nativeLoading.disableListeners == "object" ? cfg.nativeLoading.disableListeners : listenerMap;
                    if (currentListenerMap.scroll) {
                        window.addEventListener("load", removeALSL);
                        removeALSL();
                        window.removeEventListener("scroll", throttledCheckElements, true);
                    }
                    if (currentListenerMap.resize) {
                        window.removeEventListener("resize", throttledCheckElements, true);
                    }
                    Object.keys(currentListenerMap).forEach((function(name) {
                        if (currentListenerMap[name]) {
                            document.removeEventListener(name, throttledCheckElements, true);
                        }
                    }));
                }
                function runConfig() {
                    if (isConfigSet) {
                        return;
                    }
                    isConfigSet = true;
                    if (imgSupport && iframeSupport && cfg.nativeLoading.disableListeners) {
                        if (cfg.nativeLoading.disableListeners === true) {
                            cfg.nativeLoading.setLoadingAttribute = true;
                        }
                        disableEvents();
                    }
                    if (cfg.nativeLoading.setLoadingAttribute) {
                        window.addEventListener("lazybeforeunveil", (function(e) {
                            var element = e.target;
                            if ("loading" in element && !element.getAttribute("loading")) {
                                element.setAttribute("loading", "lazy");
                            }
                        }), true);
                    }
                }
                lazySizes.prematureUnveil = function prematureUnveil(element) {
                    if (!isConfigSet) {
                        runConfig();
                    }
                    if ("loading" in element && (cfg.nativeLoading.setLoadingAttribute || element.getAttribute("loading")) && (element.getAttribute("data-sizes") != "auto" || element.offsetWidth)) {
                        return true;
                    }
                    if (oldPrematureUnveil) {
                        return oldPrematureUnveil(element);
                    }
                };
            }));
        },
        "../node_modules/lazysizes/plugins/object-fit/ls.object-fit.js": function(module, exports, __webpack_require__) {
            var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;
            (function(window, factory) {
                if (!window) {
                    return;
                }
                var globalInstall = function(initialEvent) {
                    factory(window.lazySizes, initialEvent);
                    window.removeEventListener("lazyunveilread", globalInstall, true);
                };
                factory = factory.bind(null, window, window.document);
                if (true && module.exports) {
                    factory(__webpack_require__("../node_modules/lazysizes/lazysizes.js"));
                } else if (true) {
                    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__("../node_modules/lazysizes/lazysizes.js") ], 
                    __WEBPACK_AMD_DEFINE_FACTORY__ = factory, __WEBPACK_AMD_DEFINE_RESULT__ = typeof __WEBPACK_AMD_DEFINE_FACTORY__ === "function" ? __WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__) : __WEBPACK_AMD_DEFINE_FACTORY__, 
                    __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
                } else {}
            })(typeof window != "undefined" ? window : 0, (function(window, document, lazySizes, initialEvent) {
                "use strict";
                var cloneElementClass;
                var style = document.createElement("a").style;
                var fitSupport = "objectFit" in style;
                var positionSupport = fitSupport && "objectPosition" in style;
                var regCssFit = /object-fit["']*\s*:\s*["']*(contain|cover)/;
                var regCssPosition = /object-position["']*\s*:\s*["']*(.+?)(?=($|,|'|"|;))/;
                var blankSrc = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
                var regBgUrlEscape = /\(|\)|'/;
                var positionDefaults = {
                    center: "center",
                    "50% 50%": "center"
                };
                function getObject(element) {
                    var css = getComputedStyle(element, null) || {};
                    var content = css.fontFamily || "";
                    var objectFit = content.match(regCssFit) || "";
                    var objectPosition = objectFit && content.match(regCssPosition) || "";
                    if (objectPosition) {
                        objectPosition = objectPosition[1];
                    }
                    return {
                        fit: objectFit && objectFit[1] || "",
                        position: positionDefaults[objectPosition] || objectPosition || "center"
                    };
                }
                function generateStyleClass() {
                    if (cloneElementClass) {
                        return;
                    }
                    var styleElement = document.createElement("style");
                    cloneElementClass = lazySizes.cfg.objectFitClass || "lazysizes-display-clone";
                    document.querySelector("head").appendChild(styleElement);
                }
                function removePrevClone(element) {
                    var prev = element.previousElementSibling;
                    if (prev && lazySizes.hC(prev, cloneElementClass)) {
                        prev.parentNode.removeChild(prev);
                        element.style.position = prev.getAttribute("data-position") || "";
                        element.style.visibility = prev.getAttribute("data-visibility") || "";
                    }
                }
                function initFix(element, config) {
                    var switchClassesAdded, addedSrc, styleElement, styleElementStyle;
                    var lazysizesCfg = lazySizes.cfg;
                    var onChange = function() {
                        var src = element.currentSrc || element.src;
                        if (src && addedSrc !== src) {
                            addedSrc = src;
                            styleElementStyle.backgroundImage = "url(" + (regBgUrlEscape.test(src) ? JSON.stringify(src) : src) + ")";
                            if (!switchClassesAdded) {
                                switchClassesAdded = true;
                                lazySizes.rC(styleElement, lazysizesCfg.loadingClass);
                                lazySizes.aC(styleElement, lazysizesCfg.loadedClass);
                            }
                        }
                    };
                    var rafedOnChange = function() {
                        lazySizes.rAF(onChange);
                    };
                    element._lazysizesParentFit = config.fit;
                    element.addEventListener("lazyloaded", rafedOnChange, true);
                    element.addEventListener("load", rafedOnChange, true);
                    lazySizes.rAF((function() {
                        var hideElement = element;
                        var container = element.parentNode;
                        if (container.nodeName.toUpperCase() == "PICTURE") {
                            hideElement = container;
                            container = container.parentNode;
                        }
                        removePrevClone(hideElement);
                        if (!cloneElementClass) {
                            generateStyleClass();
                        }
                        styleElement = element.cloneNode(false);
                        styleElementStyle = styleElement.style;
                        styleElement.addEventListener("load", (function() {
                            var curSrc = styleElement.currentSrc || styleElement.src;
                            if (curSrc && curSrc != blankSrc) {
                                styleElement.src = blankSrc;
                                styleElement.srcset = "";
                            }
                        }));
                        lazySizes.rC(styleElement, lazysizesCfg.loadedClass);
                        lazySizes.rC(styleElement, lazysizesCfg.lazyClass);
                        lazySizes.rC(styleElement, lazysizesCfg.autosizesClass);
                        lazySizes.aC(styleElement, lazysizesCfg.loadingClass);
                        lazySizes.aC(styleElement, cloneElementClass);
                        [ "data-parent-fit", "data-parent-container", "data-object-fit-polyfilled", lazysizesCfg.srcsetAttr, lazysizesCfg.srcAttr ].forEach((function(attr) {
                            styleElement.removeAttribute(attr);
                        }));
                        styleElement.src = blankSrc;
                        styleElement.srcset = "";
                        styleElementStyle.backgroundRepeat = "no-repeat";
                        styleElementStyle.backgroundPosition = config.position;
                        styleElementStyle.backgroundSize = config.fit;
                        styleElement.setAttribute("data-position", hideElement.style.position);
                        styleElement.setAttribute("data-visibility", hideElement.style.visibility);
                        hideElement.style.visibility = "hidden";
                        hideElement.style.position = "absolute";
                        element.setAttribute("data-parent-fit", config.fit);
                        element.setAttribute("data-parent-container", "prev");
                        element.setAttribute("data-object-fit-polyfilled", "");
                        element._objectFitPolyfilledDisplay = styleElement;
                        container.insertBefore(styleElement, hideElement);
                        if (element._lazysizesParentFit) {
                            delete element._lazysizesParentFit;
                        }
                        if (element.complete) {
                            onChange();
                        }
                    }));
                }
                if (!fitSupport || !positionSupport) {
                    var onRead = function(e) {
                        if (e.detail.instance != lazySizes) {
                            return;
                        }
                        var element = e.target;
                        var obj = getObject(element);
                        if (obj.fit && (!fitSupport || obj.position != "center")) {
                            initFix(element, obj);
                            return true;
                        }
                        return false;
                    };
                    window.addEventListener("lazybeforesizes", (function(e) {
                        if (e.detail.instance != lazySizes) {
                            return;
                        }
                        var element = e.target;
                        if (element.getAttribute("data-object-fit-polyfilled") != null && !element._objectFitPolyfilledDisplay) {
                            if (!onRead(e)) {
                                lazySizes.rAF((function() {
                                    element.removeAttribute("data-object-fit-polyfilled");
                                }));
                            }
                        }
                    }));
                    window.addEventListener("lazyunveilread", onRead, true);
                    if (initialEvent && initialEvent.detail) {
                        onRead(initialEvent);
                    }
                }
            }));
        },
        "../node_modules/lazysizes/plugins/parent-fit/ls.parent-fit.js": function(module, exports, __webpack_require__) {
            var jQuery = __webpack_require__("jquery");
            var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;
            (function(window, factory) {
                if (!window) {
                    return;
                }
                var globalInstall = function() {
                    factory(window.lazySizes);
                    window.removeEventListener("lazyunveilread", globalInstall, true);
                };
                factory = factory.bind(null, window, window.document);
                if (true && module.exports) {
                    factory(__webpack_require__("../node_modules/lazysizes/lazysizes.js"));
                } else if (true) {
                    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__("../node_modules/lazysizes/lazysizes.js") ], 
                    __WEBPACK_AMD_DEFINE_FACTORY__ = factory, __WEBPACK_AMD_DEFINE_RESULT__ = typeof __WEBPACK_AMD_DEFINE_FACTORY__ === "function" ? __WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__) : __WEBPACK_AMD_DEFINE_FACTORY__, 
                    __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
                } else {}
            })(typeof window != "undefined" ? window : 0, (function(window, document, lazySizes) {
                "use strict";
                if (!window.addEventListener) {
                    return;
                }
                var regDescriptors = /\s+(\d+)(w|h)\s+(\d+)(w|h)/;
                var regCssFit = /parent-fit["']*\s*:\s*["']*(contain|cover|width)/;
                var regCssObject = /parent-container["']*\s*:\s*["']*(.+?)(?=(\s|$|,|'|"|;))/;
                var regPicture = /^picture$/i;
                var cfg = lazySizes.cfg;
                var getCSS = function(elem) {
                    return getComputedStyle(elem, null) || {};
                };
                var parentFit = {
                    getParent: function(element, parentSel) {
                        var parent = element;
                        var parentNode = element.parentNode;
                        if ((!parentSel || parentSel == "prev") && parentNode && regPicture.test(parentNode.nodeName || "")) {
                            parentNode = parentNode.parentNode;
                        }
                        if (parentSel != "self") {
                            if (parentSel == "prev") {
                                parent = element.previousElementSibling;
                            } else if (parentSel && (parentNode.closest || window.jQuery)) {
                                parent = (parentNode.closest ? parentNode.closest(parentSel) : jQuery(parentNode).closest(parentSel)[0]) || parentNode;
                            } else {
                                parent = parentNode;
                            }
                        }
                        return parent;
                    },
                    getFit: function(element) {
                        var tmpMatch, parentObj;
                        var css = getCSS(element);
                        var content = css.content || css.fontFamily;
                        var obj = {
                            fit: element._lazysizesParentFit || element.getAttribute("data-parent-fit")
                        };
                        if (!obj.fit && content && (tmpMatch = content.match(regCssFit))) {
                            obj.fit = tmpMatch[1];
                        }
                        if (obj.fit) {
                            parentObj = element._lazysizesParentContainer || element.getAttribute("data-parent-container");
                            if (!parentObj && content && (tmpMatch = content.match(regCssObject))) {
                                parentObj = tmpMatch[1];
                            }
                            obj.parent = parentFit.getParent(element, parentObj);
                        } else {
                            obj.fit = css.objectFit;
                        }
                        return obj;
                    },
                    getImageRatio: function(element) {
                        var i, srcset, media, ratio, match, width, height;
                        var parent = element.parentNode;
                        var elements = parent && regPicture.test(parent.nodeName || "") ? parent.querySelectorAll("source, img") : [ element ];
                        for (i = 0; i < elements.length; i++) {
                            element = elements[i];
                            srcset = element.getAttribute(cfg.srcsetAttr) || element.getAttribute("srcset") || element.getAttribute("data-pfsrcset") || element.getAttribute("data-risrcset") || "";
                            media = element._lsMedia || element.getAttribute("media");
                            media = cfg.customMedia[element.getAttribute("data-media") || media] || media;
                            if (srcset && (!media || (window.matchMedia && matchMedia(media) || {}).matches)) {
                                ratio = parseFloat(element.getAttribute("data-aspectratio"));
                                if (!ratio) {
                                    match = srcset.match(regDescriptors);
                                    if (match) {
                                        if (match[2] == "w") {
                                            width = match[1];
                                            height = match[3];
                                        } else {
                                            width = match[3];
                                            height = match[1];
                                        }
                                    } else {
                                        width = element.getAttribute("width");
                                        height = element.getAttribute("height");
                                    }
                                    ratio = width / height;
                                }
                                break;
                            }
                        }
                        return ratio;
                    },
                    calculateSize: function(element, width) {
                        var displayRatio, height, imageRatio, retWidth;
                        var fitObj = this.getFit(element);
                        var fit = fitObj.fit;
                        var fitElem = fitObj.parent;
                        if (fit != "width" && (fit != "contain" && fit != "cover" || !(imageRatio = this.getImageRatio(element)))) {
                            return width;
                        }
                        if (fitElem) {
                            width = fitElem.clientWidth;
                        } else {
                            fitElem = element;
                        }
                        retWidth = width;
                        if (fit == "width") {
                            retWidth = width;
                        } else {
                            height = fitElem.clientHeight;
                            if ((displayRatio = width / height) && (fit == "cover" && displayRatio < imageRatio || fit == "contain" && displayRatio > imageRatio)) {
                                retWidth = width * (imageRatio / displayRatio);
                            }
                        }
                        return retWidth;
                    }
                };
                lazySizes.parentFit = parentFit;
                document.addEventListener("lazybeforesizes", (function(e) {
                    if (e.defaultPrevented || e.detail.instance != lazySizes) {
                        return;
                    }
                    var element = e.target;
                    e.detail.width = parentFit.calculateSize(element, e.detail.width);
                }));
            }));
        },
        "../node_modules/lazysizes/plugins/print/ls.print.js": function(module, exports, __webpack_require__) {
            var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;
            (function(window, factory) {
                var globalInstall = function() {
                    factory(window.lazySizes);
                    window.removeEventListener("lazyunveilread", globalInstall, true);
                };
                factory = factory.bind(null, window, window.document);
                if (true && module.exports) {
                    factory(__webpack_require__("../node_modules/lazysizes/lazysizes.js"));
                } else if (true) {
                    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__("../node_modules/lazysizes/lazysizes.js") ], 
                    __WEBPACK_AMD_DEFINE_FACTORY__ = factory, __WEBPACK_AMD_DEFINE_RESULT__ = typeof __WEBPACK_AMD_DEFINE_FACTORY__ === "function" ? __WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__) : __WEBPACK_AMD_DEFINE_FACTORY__, 
                    __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
                } else {}
            })(window, (function(window, document, lazySizes) {
                "use strict";
                var config, elements, onprint, printMedia;
                if (window.addEventListener) {
                    config = lazySizes && lazySizes.cfg;
                    elements = config.lazyClass || "lazyload";
                    onprint = function() {
                        var i, len;
                        if (typeof elements == "string") {
                            elements = document.getElementsByClassName(elements);
                        }
                        if (lazySizes) {
                            for (i = 0, len = elements.length; i < len; i++) {
                                lazySizes.loader.unveil(elements[i]);
                            }
                        }
                    };
                    addEventListener("beforeprint", onprint, false);
                    if (!("onbeforeprint" in window) && window.matchMedia && (printMedia = matchMedia("print")) && printMedia.addListener) {
                        printMedia.addListener((function() {
                            if (printMedia.matches) {
                                onprint();
                            }
                        }));
                    }
                }
            }));
        },
        "../node_modules/lazysizes/plugins/respimg/ls.respimg.js": function(module, exports, __webpack_require__) {
            var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;
            (function(window, factory) {
                if (!window) {
                    return;
                }
                var globalInstall = function() {
                    factory(window.lazySizes);
                    window.removeEventListener("lazyunveilread", globalInstall, true);
                };
                factory = factory.bind(null, window, window.document);
                if (true && module.exports) {
                    factory(__webpack_require__("../node_modules/lazysizes/lazysizes.js"));
                } else if (true) {
                    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__("../node_modules/lazysizes/lazysizes.js") ], 
                    __WEBPACK_AMD_DEFINE_FACTORY__ = factory, __WEBPACK_AMD_DEFINE_RESULT__ = typeof __WEBPACK_AMD_DEFINE_FACTORY__ === "function" ? __WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__) : __WEBPACK_AMD_DEFINE_FACTORY__, 
                    __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
                } else {}
            })(typeof window != "undefined" ? window : 0, (function(window, document, lazySizes) {
                "use strict";
                var polyfill;
                var lazySizesCfg = lazySizes.cfg;
                var img = document.createElement("img");
                var supportSrcset = "sizes" in img && "srcset" in img;
                var regHDesc = /\s+\d+h/g;
                var fixEdgeHDescriptor = function() {
                    var regDescriptors = /\s+(\d+)(w|h)\s+(\d+)(w|h)/;
                    var forEach = Array.prototype.forEach;
                    return function() {
                        var img = document.createElement("img");
                        var removeHDescriptors = function(source) {
                            var ratio, match;
                            var srcset = source.getAttribute(lazySizesCfg.srcsetAttr);
                            if (srcset) {
                                if (match = srcset.match(regDescriptors)) {
                                    if (match[2] == "w") {
                                        ratio = match[1] / match[3];
                                    } else {
                                        ratio = match[3] / match[1];
                                    }
                                    if (ratio) {
                                        source.setAttribute("data-aspectratio", ratio);
                                    }
                                    source.setAttribute(lazySizesCfg.srcsetAttr, srcset.replace(regHDesc, ""));
                                }
                            }
                        };
                        var handler = function(e) {
                            if (e.detail.instance != lazySizes) {
                                return;
                            }
                            var picture = e.target.parentNode;
                            if (picture && picture.nodeName == "PICTURE") {
                                forEach.call(picture.getElementsByTagName("source"), removeHDescriptors);
                            }
                            removeHDescriptors(e.target);
                        };
                        var test = function() {
                            if (!!img.currentSrc) {
                                document.removeEventListener("lazybeforeunveil", handler);
                            }
                        };
                        document.addEventListener("lazybeforeunveil", handler);
                        img.onload = test;
                        img.onerror = test;
                        img.srcset = "data:,a 1w 1h";
                        if (img.complete) {
                            test();
                        }
                    };
                }();
                if (!lazySizesCfg.supportsType) {
                    lazySizesCfg.supportsType = function(type) {
                        return !type;
                    };
                }
                if (window.HTMLPictureElement && supportSrcset) {
                    if (!lazySizes.hasHDescriptorFix && document.msElementsFromPoint) {
                        lazySizes.hasHDescriptorFix = true;
                        fixEdgeHDescriptor();
                    }
                    return;
                }
                if (window.picturefill || lazySizesCfg.pf) {
                    return;
                }
                lazySizesCfg.pf = function(options) {
                    var i, len;
                    if (window.picturefill) {
                        return;
                    }
                    for (i = 0, len = options.elements.length; i < len; i++) {
                        polyfill(options.elements[i]);
                    }
                };
                polyfill = function() {
                    var ascendingSort = function(a, b) {
                        return a.w - b.w;
                    };
                    var regPxLength = /^\s*\d+\.*\d*px\s*$/;
                    var reduceCandidate = function(srces) {
                        var lowerCandidate, bonusFactor;
                        var len = srces.length;
                        var candidate = srces[len - 1];
                        var i = 0;
                        for (i; i < len; i++) {
                            candidate = srces[i];
                            candidate.d = candidate.w / srces.w;
                            if (candidate.d >= srces.d) {
                                if (!candidate.cached && (lowerCandidate = srces[i - 1]) && lowerCandidate.d > srces.d - .13 * Math.pow(srces.d, 2.2)) {
                                    bonusFactor = Math.pow(lowerCandidate.d - .6, 1.6);
                                    if (lowerCandidate.cached) {
                                        lowerCandidate.d += .15 * bonusFactor;
                                    }
                                    if (lowerCandidate.d + (candidate.d - srces.d) * bonusFactor > srces.d) {
                                        candidate = lowerCandidate;
                                    }
                                }
                                break;
                            }
                        }
                        return candidate;
                    };
                    var parseWsrcset = function() {
                        var candidates;
                        var regWCandidates = /(([^,\s].[^\s]+)\s+(\d+)w)/g;
                        var regMultiple = /\s/;
                        var addCandidate = function(match, candidate, url, wDescriptor) {
                            candidates.push({
                                c: candidate,
                                u: url,
                                w: wDescriptor * 1
                            });
                        };
                        return function(input) {
                            candidates = [];
                            input = input.trim();
                            input.replace(regHDesc, "").replace(regWCandidates, addCandidate);
                            if (!candidates.length && input && !regMultiple.test(input)) {
                                candidates.push({
                                    c: input,
                                    u: input,
                                    w: 99
                                });
                            }
                            return candidates;
                        };
                    }();
                    var runMatchMedia = function() {
                        if (runMatchMedia.init) {
                            return;
                        }
                        runMatchMedia.init = true;
                        addEventListener("resize", function() {
                            var timer;
                            var matchMediaElems = document.getElementsByClassName("lazymatchmedia");
                            var run = function() {
                                var i, len;
                                for (i = 0, len = matchMediaElems.length; i < len; i++) {
                                    polyfill(matchMediaElems[i]);
                                }
                            };
                            return function() {
                                clearTimeout(timer);
                                timer = setTimeout(run, 66);
                            };
                        }());
                    };
                    var createSrcset = function(elem, isImage) {
                        var parsedSet;
                        var srcSet = elem.getAttribute("srcset") || elem.getAttribute(lazySizesCfg.srcsetAttr);
                        if (!srcSet && isImage) {
                            srcSet = !elem._lazypolyfill ? elem.getAttribute(lazySizesCfg.srcAttr) || elem.getAttribute("src") : elem._lazypolyfill._set;
                        }
                        if (!elem._lazypolyfill || elem._lazypolyfill._set != srcSet) {
                            parsedSet = parseWsrcset(srcSet || "");
                            if (isImage && elem.parentNode) {
                                parsedSet.isPicture = elem.parentNode.nodeName.toUpperCase() == "PICTURE";
                                if (parsedSet.isPicture) {
                                    if (window.matchMedia) {
                                        lazySizes.aC(elem, "lazymatchmedia");
                                        runMatchMedia();
                                    }
                                }
                            }
                            parsedSet._set = srcSet;
                            Object.defineProperty(elem, "_lazypolyfill", {
                                value: parsedSet,
                                writable: true
                            });
                        }
                    };
                    var getX = function(elem) {
                        var dpr = window.devicePixelRatio || 1;
                        var optimum = lazySizes.getX && lazySizes.getX(elem);
                        return Math.min(optimum || dpr, 2.5, dpr);
                    };
                    var matchesMedia = function(media) {
                        if (window.matchMedia) {
                            matchesMedia = function(media) {
                                return !media || (matchMedia(media) || {}).matches;
                            };
                        } else {
                            return !media;
                        }
                        return matchesMedia(media);
                    };
                    var getCandidate = function(elem) {
                        var sources, i, len, media, source, srces, src, width;
                        source = elem;
                        createSrcset(source, true);
                        srces = source._lazypolyfill;
                        if (srces.isPicture) {
                            for (i = 0, sources = elem.parentNode.getElementsByTagName("source"), len = sources.length; i < len; i++) {
                                if (lazySizesCfg.supportsType(sources[i].getAttribute("type"), elem) && matchesMedia(sources[i].getAttribute("media"))) {
                                    source = sources[i];
                                    createSrcset(source);
                                    srces = source._lazypolyfill;
                                    break;
                                }
                            }
                        }
                        if (srces.length > 1) {
                            width = source.getAttribute("sizes") || "";
                            width = regPxLength.test(width) && parseInt(width, 10) || lazySizes.gW(elem, elem.parentNode);
                            srces.d = getX(elem);
                            if (!srces.src || !srces.w || srces.w < width) {
                                srces.w = width;
                                src = reduceCandidate(srces.sort(ascendingSort));
                                srces.src = src;
                            } else {
                                src = srces.src;
                            }
                        } else {
                            src = srces[0];
                        }
                        return src;
                    };
                    var p = function(elem) {
                        if (supportSrcset && elem.parentNode && elem.parentNode.nodeName.toUpperCase() != "PICTURE") {
                            return;
                        }
                        var candidate = getCandidate(elem);
                        if (candidate && candidate.u && elem._lazypolyfill.cur != candidate.u) {
                            elem._lazypolyfill.cur = candidate.u;
                            candidate.cached = true;
                            elem.setAttribute(lazySizesCfg.srcAttr, candidate.u);
                            elem.setAttribute("src", candidate.u);
                        }
                    };
                    p.parse = parseWsrcset;
                    return p;
                }();
                if (lazySizesCfg.loadedClass && lazySizesCfg.loadingClass) {
                    (function() {
                        var sels = [];
                        [ 'img[sizes$="px"][srcset].', "picture > img:not([srcset])." ].forEach((function(sel) {
                            sels.push(sel + lazySizesCfg.loadedClass);
                            sels.push(sel + lazySizesCfg.loadingClass);
                        }));
                        lazySizesCfg.pf({
                            elements: document.querySelectorAll(sels.join(", "))
                        });
                    })();
                }
            }));
        },
        "../node_modules/lazysizes/plugins/video-embed/ls.video-embed.js": function(module, exports, __webpack_require__) {
            var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;
            (function(window, factory) {
                if (!window) {
                    return;
                }
                var globalInstall = function() {
                    factory(window.lazySizes);
                    window.removeEventListener("lazyunveilread", globalInstall, true);
                };
                factory = factory.bind(null, window, window.document);
                if (true && module.exports) {
                    factory(__webpack_require__("../node_modules/lazysizes/lazysizes.js"));
                } else if (true) {
                    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__("../node_modules/lazysizes/lazysizes.js") ], 
                    __WEBPACK_AMD_DEFINE_FACTORY__ = factory, __WEBPACK_AMD_DEFINE_RESULT__ = typeof __WEBPACK_AMD_DEFINE_FACTORY__ === "function" ? __WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__) : __WEBPACK_AMD_DEFINE_FACTORY__, 
                    __WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
                } else {}
            })(typeof window != "undefined" ? window : 0, (function(window, document, lazySizes) {
                "use strict";
                if (!document.getElementsByClassName) {
                    return;
                }
                var protocol = location.protocol == "https:" ? "https:" : "http:";
                var idIndex = Date.now();
                var regId = /\{\{id}}/;
                var regYtImg = /\{\{hqdefault}}/;
                var regAmp = /^&/;
                var regValidParam = /^[a-z0-9-_&=]+$/i;
                var youtubeImg = protocol + "//img.youtube.com/vi/{{id}}/{{hqdefault}}.jpg";
                var youtubeIframe = protocol + "//www.youtube.com/embed/{{id}}?autoplay=1";
                var vimeoApi = protocol + "//vimeo.com/api/oembed.json?url=https%3A//vimeo.com/{{id}}";
                var vimeoIframe = protocol + "//player.vimeo.com/video/{{id}}?autoplay=1";
                function getJSON(url, callback) {
                    var id = "vimeoCallback" + idIndex;
                    var script = document.createElement("script");
                    url += "&callback=" + id;
                    idIndex++;
                    window[id] = function(data) {
                        script.parentNode.removeChild(script);
                        delete window[id];
                        callback(data);
                    };
                    script.src = url;
                    document.head.appendChild(script);
                }
                function embedVimeoImg(id, elem) {
                    getJSON(vimeoApi.replace(regId, id), (function(data) {
                        if (data && data.thumbnail_url) {
                            elem.style.backgroundImage = "url(" + data.thumbnail_url + ")";
                        }
                    }));
                    elem.addEventListener("click", embedVimeoIframe);
                }
                function embedVimeoIframe(e) {
                    var elem = e.currentTarget;
                    var id = elem.getAttribute("data-vimeo");
                    var vimeoParams = elem.getAttribute("data-vimeoparams") || "";
                    elem.removeEventListener("click", embedVimeoIframe);
                    if (!id || !regValidParam.test(id) || vimeoParams && !regValidParam.test(vimeoParams)) {
                        return;
                    }
                    if (vimeoParams && !regAmp.test(vimeoParams)) {
                        vimeoParams = "&" + vimeoParams;
                    }
                    e.preventDefault();
                    elem.innerHTML = '<iframe src="' + vimeoIframe.replace(regId, id) + vimeoParams + '" ' + 'frameborder="0" allowfullscreen="" width="640" height="390"></iframe>';
                }
                function embedYoutubeImg(id, elem) {
                    var ytImg = elem.getAttribute("data-thumb-size") || lazySizes.cfg.ytThumb || "hqdefault";
                    elem.style.backgroundImage = "url(" + youtubeImg.replace(regId, id).replace(regYtImg, ytImg) + ")";
                    elem.addEventListener("click", embedYoutubeIframe);
                }
                function embedYoutubeIframe(e) {
                    var elem = e.currentTarget;
                    var id = elem.getAttribute("data-youtube");
                    var youtubeParams = elem.getAttribute("data-ytparams") || "";
                    elem.removeEventListener("click", embedYoutubeIframe);
                    if (!id || !regValidParam.test(id) || youtubeParams && !regValidParam.test(youtubeParams)) {
                        return;
                    }
                    if (youtubeParams && !regAmp.test(youtubeParams)) {
                        youtubeParams = "&" + youtubeParams;
                    }
                    e.preventDefault();
                    elem.innerHTML = '<iframe src="' + youtubeIframe.replace(regId, id) + youtubeParams + '" ' + 'frameborder="0" allowfullscreen="" width="640" height="390"></iframe>';
                }
                document.addEventListener("lazybeforeunveil", (function(e) {
                    if (e.detail.instance != lazySizes) {
                        return;
                    }
                    var elem = e.target;
                    var youtube = elem.getAttribute("data-youtube");
                    var vimeo = elem.getAttribute("data-vimeo");
                    if (youtube && elem) {
                        embedYoutubeImg(youtube, elem);
                    }
                    if (vimeo && elem) {
                        embedVimeoImg(vimeo, elem);
                    }
                }));
            }));
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
        var getProto = Object.getPrototypeOf ? function(obj) {
            return Object.getPrototypeOf(obj);
        } : function(obj) {
            return obj.__proto__;
        };
        var leafPrototypes;
        __webpack_require__.t = function(value, mode) {
            if (mode & 1) value = this(value);
            if (mode & 8) return value;
            if (typeof value === "object" && value) {
                if (mode & 4 && value.__esModule) return value;
                if (mode & 16 && typeof value.then === "function") return value;
            }
            var ns = Object.create(null);
            __webpack_require__.r(ns);
            var def = {};
            leafPrototypes = leafPrototypes || [ null, getProto({}), getProto([]), getProto(getProto) ];
            for (var current = mode & 2 && value; typeof current == "object" && !~leafPrototypes.indexOf(current); current = getProto(current)) {
                Object.getOwnPropertyNames(current).forEach((function(key) {
                    def[key] = function() {
                        return value[key];
                    };
                }));
            }
            def["default"] = function() {
                return value;
            };
            __webpack_require__.d(ns, def);
            return ns;
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
        Promise.resolve().then(__webpack_require__.t.bind(__webpack_require__, "../node_modules/lazysizes/plugins/parent-fit/ls.parent-fit.js", 23));
        Promise.resolve().then(__webpack_require__.t.bind(__webpack_require__, "../node_modules/lazysizes/lazysizes.js", 23));
        Promise.resolve().then(__webpack_require__.t.bind(__webpack_require__, "../node_modules/lazysizes/plugins/aspectratio/ls.aspectratio.js", 23));
        Promise.resolve().then(__webpack_require__.t.bind(__webpack_require__, "../node_modules/lazysizes/plugins/respimg/ls.respimg.js", 23));
        Promise.resolve().then(__webpack_require__.t.bind(__webpack_require__, "../node_modules/lazysizes/plugins/native-loading/ls.native-loading.js", 23));
        if (Modernizr.objectfit) {
            Promise.resolve().then(__webpack_require__.t.bind(__webpack_require__, "../node_modules/lazysizes/plugins/object-fit/ls.object-fit.js", 23));
        }
        Promise.resolve().then(__webpack_require__.t.bind(__webpack_require__, "../node_modules/lazysizes/plugins/print/ls.print.js", 23));
        Promise.resolve().then(__webpack_require__.t.bind(__webpack_require__, "../node_modules/lazysizes/plugins/video-embed/ls.video-embed.js", 23));
    }();
    !function() {
        "use strict";
        __webpack_require__.r(__webpack_exports__);
    }();
})();
//# sourceMappingURL=rwp-lazysizes.js.map