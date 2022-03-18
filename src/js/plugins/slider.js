/**
 * ============================================================================
 * slider
 *
 * @package
 * @since     1.0.0
 * @version   1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */

import { tns } from 'tiny-slider/src/tiny-slider';

import { has, defaultsDeep, forEach, isEmpty } from '../util/utils';

const leftArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>';
const rightArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>';
const bullet = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/></svg>';
const bulletActive = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg>';

/**
 * Wrapper for tiny slider with some defaults set
 *
 * @param {string} [containerClass='.gallery-slider']
 * @param {*} [args={}]
 * @return {TinySliderInstance}
 */
export function slider(containerClass = '.gallery-slider', args = {}) {
	const defaults = {
		navPosition: 'bottom',
		loop: false,
		controlsText: ['<span aria-hidden="true" role="presentation" class="btn-icon">' + leftArrow + '</span>' + '<span class="btn-text visually-hidden">Previous</span>', '<span class="btn-text visually-hidden">Next</span>' + '<span aria-hidden="true" role="presentation" class="btn-icon">' + rightArrow + '</span>'],
		lazyloadSelector: '.lazyload',
		lazyload: true,
		onInit: (elem) => {
			const sliderID = '#' + elem.container.getAttribute('id');
			const wrapperID = sliderID + '-ow';

			if (elem.hasControls) {
				elem.prevButton.classList.add('btn', 'prev');
				elem.nextButton.classList.add('btn', 'next');
				const sliderheight = $(sliderID).outerHeight(true);

				$(wrapperID)
					.find('.tns-controls .btn')
					.css({ top: sliderheight * 0.5 });
			}
			if (has(elem, 'navItems') && !isEmpty(elem.navItems) && !elem.navAsThumbnails) {
				const navItems = elem.navItems;

				if (navItems.length) {
					forEach(navItems, function (value, i) {
						navItems[i].classList.add('btn');
						navItems[i].classList.add('btn-toggle');
						navItems[i].innerHTML = '<span aria-hidden="true" role="presentation" class="btn-icon">' + '<span aria-hidden="true" role="presentation" class="btn-icon-opened">' + bulletActive + '</span>' + '<span aria-hidden="true" role="presentation" class="btn-icon-closed">' + bullet + '</span>' + '</span>';
					});
				}
			}
		},
		updateSliderHeight: (elem) => {
			const sliderID = '#' + elem.container.getAttribute('id');
			const wrapperID = sliderID + '-ow';

			if (elem.hasControls) {
				elem.prevButton.classList.add('btn', 'prev');
				elem.nextButton.classList.add('btn', 'next');
				const sliderheight = $(sliderID).outerHeight(true);

				$(wrapperID)
					.find('.tns-controls .btn')
					.css({ top: sliderheight * 0.5 });
			}
		},
	};

	if (!isEmpty(args)) {
		args = defaultsDeep(args, defaults);
	} else {
		args = defaults;
	}

	if (isEmpty(containerClass)) {
		containerClass = '.gallery-slider';
	}

	if (!isEmpty(containerClass) && !has(args, 'container')) {
		args.container = containerClass;
	}

	let sliderInstance = tns(args);

	return sliderInstance;
}
