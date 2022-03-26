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
rwp = typeof rwp === 'undefined' ? {} : rwp;

rwp.slider = (containerClass, args = {}) => {
	const leftArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>';
	const rightArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>';
	const bullet = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/></svg>';
	const bulletActive = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg>';
	const defaults = {
		navPosition: 'bottom',
		navAsThumbnails: false,
		mode: 'gallery',
		loop: false,
		controlsText: ['<span aria-hidden="true" role="presentation" class="btn-icon">' + leftArrow + '</span>' + '<span class="btn-text visually-hidden">Previous</span>', '<span class="btn-text visually-hidden">Next</span>' + '<span aria-hidden="true" role="presentation" class="btn-icon">' + rightArrow + '</span>'],
		lazyloadSelector: '.lazyload',
		lazyload: true,
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

	if (!rwp.isEmpty(args)) {
		rwp.defaultsDeep(args, defaults);
	} else {
		args = defaults;
	}

	const hasThumbnails = rwp.get(args, 'navAsThumbnails', false);

	if (hasThumbnails) {
		args.slideBy = 1;
	}

	console.log(args);

	const changeActiveClass = function (navItem) {
		let button = navItem.querySelector('.btn');
		if (!rwp.isEmpty(button)) {
			if (navItem.classList.contains('tns-nav-active')) {
				button.classList.add('active');
			} else {
				button.classList.remove('active');
			}
		}
	};

	let init = (elem) => {
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

		if (rwp.has(elem, 'navItems') && !rwp.isEmpty(elem.navItems)) {
			let slides = elem.slideItems;
			slides = rwp.reject(slides, function (slide) {
				return slide.classList.contains('tns-slide-cloned');
			});

			let navContainer = elem.navContainer;
			let standardNavContainer = navContainer.classList.length == 1 && navContainer.classList.contains('tns-nav'); // Make sure a custom nav container isn't specified
			if (standardNavContainer) {
				rwp.each(elem.navItems, function (el, i) {
					let navItem = el.cloneNode();

					navItem.classList.add('btn');
					navItem.classList.add('btn-link');
					let navItemContent = rwp.stringToHtml(`<span aria-hidden="true" role="presentation" class="btn-icon"><span aria-hidden="true" role="presentation" class="btn-icon-opened">${bulletActive}</span><span aria-hidden="true" role="presentation" class="btn-icon-closed">${bullet}</span></span>`);
					if (hasThumbnails) {
						let slide = slides[i];
						let thumb = slide.querySelector('img').cloneNode();

						let thumbWrapper = rwp.stringToHtml('<span aria-hidden="true" role="presentation" class="btn-icon"></span>');
						thumbWrapper.append(thumb);
						navItemContent = thumbWrapper;
					} else {
						navItem.classList.add('btn-toggle');
					}

					navItem.append(navItemContent);
					let navItemWrapper = rwp.stringToHtml('<span class="tns-nav-item"></span>');
					navItemWrapper.append(navItem);

					navItem = navItemWrapper;

					changeActiveClass(navItem);

					el.parentNode.replaceChild(navItem, el);
				});
				if (hasThumbnails) {
					navContainer.classList.add('tns-thumbnails');
				}
			}
		}
	};

	if (!rwp.has(args, 'onInit')) {
		args.onInit = init;
	}

	const changeActiveClasses = function (elem) {
		if (rwp.has(elem, 'navItems') && !rwp.isEmpty(elem.navItems)) {
			elem.navItems = rwp.map(elem.navItems, function (navItem) {
				changeActiveClass(navItem);
			});
		}
	};

	if (!rwp.isEmpty(containerClass)) {
		let sliders = document.querySelectorAll(containerClass);
		if (sliders.length > 0) {
			sliders.forEach((element) => {
				element.classList.add('tns');
			});
		}
		if (!rwp.has(args, 'container')) {
			args.container = containerClass;
		}
		let sliderInstance = tns(args);

		sliderInstance.events.on('indexChanged', changeActiveClasses);

		return sliderInstance;
	}
};
