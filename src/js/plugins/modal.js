/** ============================================================================
 * fancybox
 *
 * @version   1.0.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

import { Fancybox } from '@fancyapps/ui/src/Fancybox/Fancybox.js';
rwp = typeof rwp === 'undefined' ? {} : rwp;

rwp.modal = (selector = '[data-fancybox]', args = {}) => {
	const defaults = {
		template: '<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div>',
		on: {
			load: (instance, slide) => {
				console.log(`#${slide.index} slide is loaded!`);
				console.log(`This slide is selected: ${instance.getSlide().index === slide.index}`);
			},
		},
	};

	if (!rwp.isEmpty(args)) {
		args = rwp.defaultsDeep(args, defaults);
	} else {
		args = defaults;
	}

	if (!rwp.isEmpty(selector)) {
		let modal = new Fancybox(selector, args);

		return modal;
	}
};
