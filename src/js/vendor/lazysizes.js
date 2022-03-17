/** ============================================================================
 * lazysizes
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

import 'lazysizes/plugins/parent-fit/ls.parent-fit';

import 'lazysizes';

import 'lazysizes/plugins/aspectratio/ls.aspectratio';
import 'lazysizes/plugins/respimg/ls.respimg';
import 'lazysizes/plugins/native-loading/ls.native-loading';

if (Modernizr.objectfit) {
	require('lazysizes/plugins/object-fit/ls.object-fit');
}

import 'lazysizes/plugins/print/ls.print';
import 'lazysizes/plugins/video-embed/ls.video-embed';
