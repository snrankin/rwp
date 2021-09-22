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

import { assign, has, isUndefined, defaultsDeep, isNil } from 'lodash';

Fancybox.bind('[data-fancybox]', {
	template: {
		// Close button icon
		closeButton:
			'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16"><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>',
		// Loading indicator icon
		spinner:
			'<span class="btn-icon has-spinner"><span class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></span></span>',
	},
	on: {
		reveal: (instance, slide) => {
			const trigger = instance.options.$trigger;
			const theme = trigger.getAttribute('data-theme');
			const group = trigger.getAttribute('data-fancybox');
			const container = instance.$container;

			if (!isNil(group)) {
				container.classList.add(`modal-group-${group}`);
			}

			if (!isNil(theme)) {
				container.classList.add(`modal-theme-${theme}`);
			}
		},
	},
});
