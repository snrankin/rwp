/**
 * ============================================================================
 * acf
 *
 * @package
 * @since     1.0.0
 * @version   1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */
const rwp = window.rwp || {}; // eslint-disable-line

function onlyUnique(value, index, self) {
	return self.indexOf(value) === index;
}

acf.addAction('load_field/name=bs_colors', function (field) {
	const bsAtts = rwp.bsAtts();
	const bsColors = bsAtts.colors;

	const fieldEl = field.$el.find('.acf-color-picker')[0];

	const colors = Object.values(bsColors).join(', ');

	$(fieldEl).attr('data-palette', colors);

	window.$color_palette = Object.values(bsColors);
});

acf.add_filter('color_picker_args', function (args, field) {
	const bsAtts = rwp.bsAtts();
	const bsColors = bsAtts.colors;
	args.palettes = Object.values(bsColors).filter(onlyUnique);

	// return
	return args;
});
