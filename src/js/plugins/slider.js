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

import { has, assign, isUndefined, defaultsDeep, isNil, forEach } from 'lodash';

const leftArrow = require('bootstrap-icons/icons/chevron-left.svg');
const rightArrow = require('bootstrap-icons/icons/chevron-right.svg');
const bullet = require('bootstrap-icons/icons/circle.svg');
const bulletActive = require('bootstrap-icons/icons/circle-fill.svg');

export function slider(containerClass = '', args = {}) {
	const defaults = {
		navPosition: 'bottom',
		loop: false,
		controlsText: ['<span aria-hidden="true" role="presentation" class="btn-icon">' + leftArrow + '</span>' + '<span class="btn-text sr-only">Previous</span>', '<span class="btn-text sr-only">Next</span>' + '<span aria-hidden="true" role="presentation" class="btn-icon">' + rightArrow + '</span>'],
		lazyloadSelector: '.lazyload',
		lazyload: true,
		onInit: (elem) => {
			const sliderID = '#' + elem.container.getAttribute('id');
			const wrapperID = sliderID + '-ow';
			if (elem.hasControls) {
				elem.prevButton.classList.add('btn', 'prev');
				elem.nextButton.classList.add('btn', 'next');
				const sliderheight = $(sliderID).outerHeight(true);

				$(wrapperID).find('.tns-controls').css({ height: sliderheight });
			}
			if (has(elem, 'navItems') && !isUndefined(elem.navItems)) {
				const navItems = elem.navItems;

				if (navItems.length) {
					forEach(navItems, function (value, i) {
						navItems[i].classList.add('btn');
						navItems[i].classList.add('btn-toggle');
						navItems[i].innerHTML = '<span aria-hidden="true" role="presentation" class="btn-icon">' + '<span aria-hidden="true" role="presentation" class="btn-icon-opened">' + bulletActive + '</span>' + '<span aria-hidden="true" role="presentation" class="btn-icon-closed">' + bullet + '</span>' + '</span>';

						if (i === elem.index) {
							navItems[i].classList.add('active');
						}
					});
				}
			}
		},
	};

	const sliderOpts = defaultsDeep(args, defaults);

	if (isNil(containerClass)) {
		containerClass = '.gallery-slider';
	}

	const container = document.querySelector(containerClass);
	if (!isNil(container)) {
		const options = this.sliderOpts;

		assign(
			{
				container: containerClass,
			},
			sliderOpts
		);
	}

	const tnsSlider = tns(sliderOpts);

	tnsSlider.events.on('indexChanged', function (info) {
		if (has(info, 'navItems') && !isUndefined(info.navItems)) {
			let indexPrev = info.indexCached,
				indexCurrent = info.index;

			indexPrev = info.navItems[indexPrev];
			indexCurrent = info.navItems[indexCurrent];

			if (!isNil(indexPrev)) {
				indexPrev.classList.remove('active');
			}

			if (!isNil(indexCurrent)) {
				indexCurrent.classList.add('active');
			}
		}
	});

	window.addEventListener('resize', function () {
		$('.tns-outer').each(function (el) {
			const sliderheight = $(el).find('.tns-inner').outerHeight(true);

			$(el).find('.tns-controls').css({ height: sliderheight });
		});
	});

	return tnsSlider;
}
