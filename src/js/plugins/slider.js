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
import { /* webpackMode: "eager" */ tns } from 'tiny-slider/src/tiny-slider';
rwp = typeof rwp === 'undefined' ? {} : rwp;

const leftArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>';
const rightArrow = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>';
const bullet = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/></svg>';
const bulletActive = '<svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" class="bi bi-circle-fill" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg>';
const defaults = {
	container: '.tns',
	navPosition: 'bottom',
	navAsThumbnails: false,
	mode: 'gallery',
	controlsText: ['<span aria-hidden="true" role="presentation" class="btn-icon">' + leftArrow + '</span>' + '<span class="btn-text visually-hidden">Previous</span>', '<span class="btn-text visually-hidden">Next</span>' + '<span aria-hidden="true" role="presentation" class="btn-icon">' + rightArrow + '</span>'],
	autoplayHoverPause: true,
	lazyloadSelector: '.lazyload',
	lazyload: true,
	updateSliderHeight: (elem) => {
		updateBtnPosition(elem);
	},
};

function changeActiveClass(navItem) {
	let button = navItem.querySelector('.btn');
	if (!rwp.isEmpty(button)) {
		if (navItem.classList.contains('tns-nav-active')) {
			button.classList.add('active');
		} else {
			button.classList.remove('active');
		}
	}
}

function changeActiveClasses(elem) {
	if (rwp.has(elem, 'navItems') && !rwp.isEmpty(elem.navItems)) {
		let navItems = elem.navItems;
		navItems = Array.from(navItems);
		navItems.map(function (navItem) {
			let button = navItem.querySelector('.btn');
			if (!rwp.isEmpty(button)) {
				if (navItem.classList.contains('tns-nav-active')) {
					button.classList.add('active');
				} else {
					button.classList.remove('active');
				}
			}
		});
	}
}

function updateBtnPosition(elem) {
	const sliderID = elem.container.getAttribute('id');
	const wrapperID = sliderID + '-ow';
	const wrapper = document.getElementById(wrapperID);
	const container = document.getElementById(sliderID);
	if (elem.hasControls) {
		elem.prevButton.classList.add('btn', 'prev');
		elem.nextButton.classList.add('btn', 'next');
		elem.prevButton.setAttribute('tabindex', '0');
		elem.nextButton.setAttribute('tabindex', '0');
		let sliderheight = container.offsetHeight;

		let navBtns = wrapper.querySelectorAll('.tns-controls .btn');

		if (navBtns.length) {
			navBtns.forEach(function (btn) {
				let topStyle = sliderheight * 0.5;
				btn.style.top = `${topStyle}px`;
			});
		}
	}
}

function createNav(elem, hasThumbnails) {
	if (rwp.has(elem, 'navItems') && !rwp.isEmpty(elem.navItems)) {
		let slides = elem.slideItems;
		slides = Array.from(slides);
		slides = slides.filter(function (slide) {
			return !slide.classList.contains('tns-slide-cloned');
		});
		console.log('🚀 ~ file: slider.js ~ line 82 ~ slides', slides);

		let navContainer = elem.navContainer;
		let standardNavContainer = navContainer.classList.length == 1 && navContainer.classList.contains('tns-nav'); // Make sure a custom nav container isn't specified
		if (standardNavContainer) {
			let navItems = elem.navItems;
			navItems = Array.from(navItems);
			navItems.forEach(function (el, i) {
				let navItem = el.cloneNode();
				navItem.setAttribute('tabindex', '0');
				navItem.classList.add('btn');
				navItem.classList.add('btn-link');
				let navItemContent = rwp.stringToHtml(`<span aria-hidden="true" role="presentation" class="btn-icon"><span aria-hidden="true" role="presentation" class="icon-opened">${bulletActive}</span><span aria-hidden="true" role="presentation" class="icon-closed">${bullet}</span></span>`);
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
}

function slider(element, args = {}) {
	if (!rwp.isEmpty(args)) {
		args = rwp.extend(args, defaults);
	} else {
		args = defaults;
	}

	let inlineArgs = element.getAttribute('data-tns');
	if (!rwp.isEmpty(inlineArgs)) {
		inlineArgs = JSON.parse(inlineArgs);
		args = rwp.extend(inlineArgs, args);
	}

	const hasThumbnails = rwp.get(args, 'navAsThumbnails', false);

	if (hasThumbnails) {
		args.slideBy = 1;
	}

	let init = (elem) => {
		updateBtnPosition(elem);

		createNav(elem, hasThumbnails);
	};

	if (!rwp.has(args, 'onInit')) {
		args.onInit = init;
	}

	args.container = element;

	let sliderInstance = tns(args);

	sliderInstance.events.on('indexChanged', changeActiveClasses);

	return sliderInstance;
}

rwp.slider = slider;

window.addEventListener('load', function () {
	let sliders = document.querySelectorAll('.tns');
	if (sliders.length > 0) {
		sliders.forEach((element) => {
			var slide = slider(element);
			return slide;
		});
	}
});
