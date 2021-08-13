/**
 * ============================================================================
 * select2
 *
 * @package
 * @since     1.0.0
 * @version   4.1.0-rc.0
 * @author    Kevin Brown <wordpress@riester.com>
 * ==========================================================================
 */

import 'select2/dist/js/select2.full.js';

(function ($) {
	$('.select2').select2({
		theme: 'bootstrap-5',
	});
})(jQuery);
