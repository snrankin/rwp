/**
 * ============================================================================
 * modal
 *
 * @package
 * @since     1.0.0
 * @version   1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */

import { Fancybox } from '@fancyapps/ui';

Fancybox.bind('[data-fancybox]', {
	template: {
		// Loading indicator icon
		spinner:
			'<span class="btn-icon has-spinner"><span class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></span></span>',
	},
	on: {
		reveal: (instance) => {
			const trigger = instance.options.$trigger;
			const theme = trigger.getAttribute('data-theme');
			const group = trigger.getAttribute('data-fancybox');
			const container = instance.$container;

			if (!rwp.isEmpty(group)) {
				container.classList.add(`modal-group-${group}`);
			}

			if (!rwp.isEmpty(theme)) {
				container.classList.add(`modal-theme-${theme}`);
			}
		},
	},
});
