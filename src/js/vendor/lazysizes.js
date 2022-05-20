/** ============================================================================
 * lazysizes
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

import(/* webpackMode: "eager" */ 'lazysizes/plugins/parent-fit/ls.parent-fit');

import(/* webpackMode: "eager" */ 'lazysizes');

import(/* webpackMode: "eager" */ 'lazysizes/plugins/aspectratio/ls.aspectratio');
import(/* webpackMode: "eager" */ 'lazysizes/plugins/respimg/ls.respimg');
import(/* webpackMode: "eager" */ 'lazysizes/plugins/native-loading/ls.native-loading');

if (Modernizr.objectfit) {
	import(/* webpackMode: "eager" */ 'lazysizes/plugins/object-fit/ls.object-fit');
}

import(/* webpackMode: "eager" */ 'lazysizes/plugins/print/ls.print');
import(/* webpackMode: "eager" */ 'lazysizes/plugins/video-embed/ls.video-embed');
