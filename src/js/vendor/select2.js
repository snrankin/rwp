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
	$.fn.select2.defaults.set('width', '100%');
	if (select2Inputs.length > 0) {
		select2Inputs.forEach(function (input) {
			let isSmall = input.classList.contains('form-select-sm');
			let isLarge = input.classList.contains('form-select-lg');

			let select2Options = {
				dropdownParent: input.parentElement,
				minimumResultsForSearch: 'Infinity',
				theme: 'bootstrap-5',
				width: '100%',
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

	/**
	 * Make select 2 option groups collapsible
	 *
	 * @link https://stackoverflow.com/a/52157352
	 */

	const optgroupState = {};

	$('body').on('click', '.select2-container--open .select2-results__group', function () {
		$(this).toggleClass('open').siblings().toggle();

		const id = $(this).closest('.select2-results__options').attr('id');
		const index = $('.select2-results__group').index(this);
		optgroupState[id][index] = !optgroupState[id][index];
	});

	$('.select2').on('select2:open', function () {
		$('.select2-dropdown--below').css('opacity', 0);

		setTimeout(() => {
			const groups = $('.select2-container--open .select2-results__group');
			const id = $('.select2-results__options').attr('id');
			if (!optgroupState[id]) {
				optgroupState[id] = {};
			}
			$.each(groups, (index, v) => {
				optgroupState[id][index] = optgroupState[id][index] || false;
				optgroupState[id][index] ? $(v).siblings().show() : $(v).siblings().hide();
			});
			$('.select2-dropdown--below').css('opacity', 1);
		}, 0);
	});
});
