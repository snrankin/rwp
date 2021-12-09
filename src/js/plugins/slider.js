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

import { has, isUndefined, defaultsDeep, isNil } from 'lodash';

class RWPSlider {
	constructor(args = {}) {
		const defaults = {
			navPosition: 'bottom',
			loop: false,
			controlsText: [
				'<span aria-hidden="true" role="presentation" class="btn-icon">' +
					'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>' +
					'</span>' +
					'<span class="btn-text sr-only">Previous</span>',
				'<span class="btn-text sr-only">Next</span>' +
					'<span aria-hidden="true" role="presentation" class="btn-icon">' +
					'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>' +
					'</span>',
			],
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
						.find('.tns-controls')
						.css({ height: sliderheight });
				}
				if (has(elem, 'navItems') && !isUndefined(elem.navItems)) {
					const navItems = elem.navItems;

					if (navItems.length) {
						for (let i = 0; i < navItems.length; i++) {
							navItems[i].classList.add('btn');
							navItems[i].classList.add('btn-toggle');
							navItems[i].innerHTML =
								'<span aria-hidden="true" role="presentation" class="btn-icon">' +
								'<span aria-hidden="true" role="presentation" class="btn-icon-opened">' +
								'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg>' +
								'</span>' +
								'<span aria-hidden="true" role="presentation" class="btn-icon-closed">' +
								'<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/></svg>' +
								'</span>' +
								'</span>';

							if (i === elem.index) {
								navItems[i].classList.add('active');
							}
						}
					}
				}
			},
		};

		this.sliderOpts = defaultsDeep(args, defaults);
	}

	init(containerClass = '.gallery-slider') {
		if (isUndefined(containerClass)) {
			containerClass = '.gallery-slider';
		}
		const container = document.querySelector(containerClass);
		if (!isNil(container)) {
			const options = this.sliderOpts;
			options.container = containerClass;
			const tnsSlider = tns(options);
			tnsSlider.events.on('indexChanged', function (info) {
				const indexPrev = info.indexCached,
					indexCurrent = info.index;

				info.navItems[indexPrev].classList.remove('active');

				info.navItems[indexCurrent].classList.add('active');
			});
			window.addEventListener('resize', function () {
				$('.tns-outer').each(function (el) {
					const sliderheight = $(el)
						.find('.tns-inner')
						.outerHeight(true);

					$(el).find('.tns-controls').css({ height: sliderheight });
				});
			});

			return tnsSlider;
		}
	}
}
export default RWPSlider;
