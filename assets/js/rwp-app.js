!function(){var t={844:function(t){var n;n=function(){function t(n,e,r,o){var i,u,c,f,a=t.mq;for(e="string"==typeof e?e:"",r=0<r?e?+r:r>>0:1,o=0<o?+o:0>o?-o:"px"==e?256:e?32:1,n+=":",e+=")",f=r;o&&0<=f;f+=o){if(c=a("(min-"+n+f+e),u=a("(max-"+n+f+e),c&&u)return a("("+n+(f>>0)+e)?f>>0:f;null==i?o=(i=!u)?c&&o:-o:(u?i:!i)&&(i=!i,o=-o/2)}return 0}var n="matchMedia",e="undefined"!=typeof window&&window;return t.actual=t,t.as=function(n){return function(e){return t(e,n)}},t.is=t.mq=e[n]||e[n="msMatchMedia"]?function(t){return!!e[n](t).matches}:function(){return!1},t},t.exports?t.exports=n():this.actual=n()},757:function(t){var n;n=function(){var t={},n="undefined"!=typeof window&&window,e="undefined"!=typeof document&&document,r=e&&e.documentElement,o=n.matchMedia||n.msMatchMedia,i=o?function(t){return!!o.call(n,t).matches}:function(){return!1},u=t.viewportW=function(){var t=r.clientWidth,e=n.innerWidth;return t<e?e:t},c=t.viewportH=function(){var t=r.clientHeight,e=n.innerHeight;return t<e?e:t};function f(){return{width:u(),height:c()}}function a(t,n){return!(!(t=t&&!t.nodeType?t[0]:t)||1!==t.nodeType)&&function(t,n){var e={};return n=+n||0,e.width=(e.right=t.right+n)-(e.left=t.left-n),e.height=(e.bottom=t.bottom+n)-(e.top=t.top-n),e}(t.getBoundingClientRect(),n)}return t.mq=i,t.matchMedia=o?function(){return o.apply(n,arguments)}:function(){return{}},t.viewport=f,t.scrollX=function(){return n.pageXOffset||r.scrollLeft},t.scrollY=function(){return n.pageYOffset||r.scrollTop},t.rectangle=a,t.aspect=function(t){var n=(t=null==t?f():1===t.nodeType?a(t):t).height,e=t.width;return n="function"==typeof n?n.call(t):n,(e="function"==typeof e?e.call(t):e)/n},t.inX=function(t,n){var e=a(t,n);return!!e&&e.right>=0&&e.left<=u()},t.inY=function(t,n){var e=a(t,n);return!!e&&e.bottom>=0&&e.top<=c()},t.inViewport=function(t,n){var e=a(t,n);return!!e&&e.bottom>=0&&e.right>=0&&e.top<=c()&&e.left<=u()},t},t.exports?t.exports=n():this.verge=n()},609:function(t){"use strict";t.exports=jQuery},92:function(t){"use strict";t.exports=void 0}},n={};function e(r){var o=n[r];if(void 0!==o)return o.exports;var i=n[r]={exports:{}};return t[r].call(i.exports,i,i.exports,e),i.exports}e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,{a:n}),n},e.d=function(t,n){for(var r in n)e.o(n,r)&&!e.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:n[r]})},e.o=function(t,n){return Object.prototype.hasOwnProperty.call(t,n)},function(){"use strict";e(844),e(757),e(609),e(92)}()}();