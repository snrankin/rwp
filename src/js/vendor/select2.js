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
import 'jquery';
import(/* webpackMode: "eager" */ 'select2/dist/js/select2.full');

jQuery(document).ready(function ($) {
	const select2Inputs = document.querySelectorAll('.select2');
	$.fn.select2.defaults.set('minimumResultsForSearch', 'Infinity');
	$.fn.select2.defaults.set('theme', 'bootstrap-5');
	$.fn.select2.defaults.set('width', 'resolve');
	if (select2Inputs.length > 0) {
		select2Inputs.forEach(function (input) {
			let isSmall = input.classList.contains('form-select-sm');
			let isLarge = input.classList.contains('form-select-lg');

			let select2Options = {
				dropdownParent: input.parentElement,
				minimumResultsForSearch: 'Infinity',
				theme: 'bootstrap-5',
				width: 'resolve',
				templateResult: (data, container) => {
					if (data.element) {
						$(container).addClass($(data.element).attr('class'));
					}
					return data.text;
				},
			};

			if (isSmall) {
				select2Options.containerCssClass = 'select2--small'; // For Select2 v4.0
				select2Options.selectionCssClass = 'select2--small'; // For Select2 v4.1
				select2Options.dropdownCssClass = 'select2--small';
			}

			if (isLarge) {
				select2Options.containerCssClass = 'select2--large'; // For Select2 v4.0
				select2Options.selectionCssClass = 'select2--large'; // For Select2 v4.1
				select2Options.dropdownCssClass = 'select2--large';
			}
			$(input).select2(select2Options);
		});
	}
});
