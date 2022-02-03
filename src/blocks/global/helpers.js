/**
 * ============================================================================
 * helpers
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */
import { __ } from '@wordpress/i18n';
import memoize from 'memize';
import { kebabCase } from 'lodash';
/**
 * WordPress dependencies
 */
import { renderToString } from '@wordpress/element';
import { createBlock, getBlockType, getBlockVariations } from '@wordpress/blocks';
import { vAlignStart, vAlignCenter, vAlignEnd, hAlignStart, hAlignCenter, hAlignEnd, hDist, vDist, hStretch, vStretch, dashOnly, plusOnly } from './icons';
import { RangeControl, PanelBody, PanelRow, Button, ResponsiveWrapper, Spinner, Icon } from '@wordpress/components';

import { Component, Fragment } from '@wordpress/element';
import { withSelect } from '@wordpress/data';
import * as BlockEditor from '@wordpress/block-editor';
import * as Editor from '@wordpress/editor';
const { InnerBlocks, InspectorControls, BlockControls, AlignmentToolbar, MediaPlaceholder, MediaUpload, MediaUploadCheck, getColorClassName } = BlockEditor || Editor;

export const classNames = require('classnames/dedupe');

export function hasValue(variable) {
	if (typeof variable !== 'undefined' && variable != undefined && variable != null && variable != '' && variable != [] && variable != {}) {
		return true;
	}
	return false;
}

const breakpoints = {
	Sm: {
		name: 'Phone Portrait',
		class: 'sm',
		width: 360,
	},
	Ms: {
		name: 'Phone Landscape',
		class: 'ms',
		width: 576,
	},
	Md: {
		name: 'Tablet Portrait',
		class: 'md',
		width: 768,
	},
	Ml: {
		name: 'Tablet Landscape',
		class: 'Ml',
		width: 1024,
	},
	Lg: {
		name: 'Small Desktop',
		class: 'Lg',
		width: 1280,
	},
	Xl: {
		name: 'Large Desktop',
		class: 'Xl',
		width: 1440,
	},
};

const columns = [];

for (let i = 0; i < 13; i++) {
	if (i !== 0) {
		const colPercent = i / 12;
		columns[i] = colPercent;
	}
}

export const bsColumns = columns;

export function bsVariations(title = '', attr = '') {
	return [
		{
			name: `${attr}-primary`,
			label: __(`Primary ${title}`, 'rwp'),
		},
		{
			name: `${attr}-secondary`,
			label: __(`Secondary ${title}`, 'rwp'),
		},
		{
			name: `${attr}-tertiary`,
			label: __(`Tertiary ${title}`, 'rwp'),
		},
		{
			name: `${attr}-info`,
			label: __(`Info ${title}`, 'rwp'),
		},
		{
			name: `${attr}-success`,
			label: __(`Success ${title}`, 'rwp'),
		},
		{
			name: `${attr}-warning`,
			label: __(`Warning ${title}`, 'rwp'),
		},
		{
			name: `${attr}-danger`,
			label: __(`Danger ${title}`, 'rwp'),
		},
		{
			name: `${attr}-light`,
			label: __(`Light ${title}`, 'rwp'),
		},
		{
			name: `${attr}-dark`,
			label: __(`Dark ${title}`, 'rwp'),
		},
		{
			name: `${attr}-white`,
			label: __(`White ${title}`, 'rwp'),
		},
		{
			name: `${attr}-black`,
			label: __(`Black ${title}`, 'rwp'),
		},
	];
}

export function hasBackgroundClass(bgImageId = 0, backgroundColor = null, className = '', styles = []) {
	const activeStyle = getActiveStyle(styles, className);
	const hasbgId = bgImageId != 0;
	let hasbgColor = false;
	const hasStyle = activeStyle != false && activeStyle !== 'default';

	if (backgroundColor != null) {
		if (backgroundColor.color !== undefined) {
			hasbgColor = true;
		}
	}

	const hasBG = hasbgId || hasbgColor || hasStyle;

	if (hasBG) {
		className = uniqueClasses(classNames(className, 'has-background'));
	} else if (className.match(/has-background/)) {
		className = updateClassesFromAtts('', className, /has-background/);
	}
	return className;
}

export function selfAlignClass(align = '', $type = 'flex') {
	if (align == undefined) {
		return;
	}

	let alignClass = '';

	if ($type === 'flex') {
		switch (align) {
			case 'left':
				alignClass = 'align-self-start';
				break;
			case 'center':
				alignClass = 'align-self-center';
				break;
			case 'right':
				alignClass = 'align-self-end';
				break;
			case 'wide':
				alignClass = 'align-self-stretch';
				break;
			case 'full':
				alignClass = 'w-100';
				break;
		}
	}

	return alignClass;
}

export function closest(needle, haystack) {
	if (Array.isArray(haystack)) {
		return haystack.reduce((a, b) => {
			const aDiff = Math.abs(a - needle);
			const bDiff = Math.abs(b - needle);

			if (aDiff === bDiff) {
				return a > b ? a : b;
			}
			return bDiff < aDiff ? b : a;
		});
	}
	return false;
}

export function arraySearch(arr, val) {
	for (let i = 0; i < arr.length; i++) if (arr[i] === val) return i;
	return false;
}

export const onlyUnique = (value, index, self) => {
	return self.indexOf(value) === index;
};
export const ALLOWED_MEDIA_TYPES = ['image'];

export const blockHasParent = (clientId) => {
	const rootID = wp.data.select('core/block-editor').getBlockHierarchyRootClientId(clientId);

	return clientId !== rootID;
};

export function parentAtts(childBlock) {
	if (blockHasParent(childBlock.clientId)) {
		const parents = wp.data.select('core/block-editor').getBlocksByClientId(childBlock.rootClientId);
		return parents[0];
	}
}

export function updateClassesFromStyles(attr, className, classReg) {
	if (typeof attr !== 'undefined' && attr != undefined && attr !== '') {
		if (typeof className === 'string') {
			if (className.match(classReg)) {
				className = className.replace(classReg, attr);
			} else {
				className = classNames(attr, className);
			}
		} else if (typeof className === 'undefined') {
			className = attr;
		}
	}
	return className;
}

export function updateClassesFromAtts(attr, className, classReg) {
	if (typeof attr !== 'undefined' && attr != undefined) {
		if (typeof className === 'string') {
			if (className.match(classReg)) {
				className = className.replace(classReg, attr);
			} else {
				className = classNames(attr, className);
			}
		} else if (typeof className === 'undefined') {
			className = attr;
		}
	}
	return className;
}

export function parentType(childBlock) {
	if (blockHasParent(childBlock.clientId)) {
		const parentAttrs = parentAtts(childBlock);

		return parentAttrs.name;
	}
}

function justifyControls(controls, direction = 'horizontal', prop = 'justify-content') {
	return [
		{
			icon: direction === 'horizontal' ? hAlignStart : vAlignStart,
			title: direction === 'horizontal' ? __(`Align ${controls} left`, 'rwp') : __(`Align ${controls} top`, 'rwp'),
			align: `${prop}-start`,
		},
		{
			icon: direction === 'horizontal' ? hAlignCenter : vAlignCenter,
			title: direction === 'horizontal' ? __(`Align horizontally ${controls} center`, 'rwp') : __(`Align vertically ${controls} center`, 'rwp'),
			align: `${prop}-center`,
		},
		{
			icon: direction === 'horizontal' ? hAlignEnd : vAlignEnd,
			title: direction === 'horizontal' ? __(`Align ${controls} right`, 'rwp') : __(`Align ${controls} end`, 'rwp'),
			align: `${prop}-end`,
		},
		{
			icon: direction === 'horizontal' ? hDist : vDist,
			title: __(`Space out ${controls}`, 'rwp'),
			align: `${prop}-between`,
		},
		{
			icon: direction === 'horizontal' ? hDist : vDist,
			title: __(`Space around ${controls}`, 'rwp'),
			align: `${prop}-around`,
		},
		{
			icon: direction === 'horizontal' ? hAlignStart : vAlignStart,
			title: __('Default Alignment', 'rwp'),
			align: '',
		},
	];
}

function alignItemsControls(controls, direction = 'horizontal', prop = 'align-items') {
	return [
		{
			icon: direction === 'horizontal' ? hAlignStart : vAlignStart,
			title: direction === 'horizontal' ? __(`Align ${controls} left`, 'rwp') : __(`Align ${controls} top`, 'rwp'),
			align: `${prop}-start`,
		},
		{
			icon: direction === 'horizontal' ? hAlignCenter : vAlignCenter,
			title: direction === 'horizontal' ? __(`Align horizontally ${controls} center`, 'rwp') : __(`Align vertically ${controls} center`, 'rwp'),
			align: `${prop}-center`,
		},
		{
			icon: direction === 'horizontal' ? hAlignEnd : vAlignEnd,
			title: direction === 'horizontal' ? __(`Align ${controls} right`, 'rwp') : __(`Align ${controls} end`, 'rwp'),
			align: `${prop}-end`,
		},
		{
			icon: direction === 'horizontal' ? hStretch : vStretch,
			title: direction === 'horizontal' ? __(`Full width ${controls}`, 'rwp') : __(`Full Height ${controls}`, 'rwp'),
			align: `${prop}-stretch`,
		},
		{
			icon: direction === 'horizontal' ? hAlignStart : vAlignStart,
			title: __('Default Alignment', 'rwp'),
			align: '',
		},
	];
}

export function alignControls(controls, direction = 'horizontal', prop = 'justify-content') {
	const hAlignControls = prop === 'justify-content' ? justifyControls(controls, direction) : alignItemsControls(controls, direction);

	const vAlignControls = prop === 'justify-content' ? justifyControls(controls, direction) : alignItemsControls(controls, direction);

	if (direction === 'vertical') {
		return vAlignControls;
	}
	return hAlignControls;
}

export function toggleIcon(attributes) {
	let { iconPosition, closedIcon, openedIcon } = attributes;

	if (iconPosition == null || iconPosition == '') {
		iconPosition = 'left';
	}

	iconPosition = 'icon-' + iconPosition;

	return (
		<span className={classNames('btn-icon', iconPosition)}>
			<i className={classNames('btn-icon-closed', closedIcon)} ariaHidden="true" role="presentation" />
			<i className={classNames('btn-icon-opened', openedIcon)} aria-hidden="true" role="presentation" />
		</span>
	);
}

export function toggleButton(attributes) {
	let { className, id, btnClasses, iconPosition, closedIcon, openedIcon, opened, content } = attributes;

	className = classNames(['btn', className]);
	const icon = toggleIcon(attributes);
	return (
		<div className={classNames(['toggle-block d-flex align-items-center', `toggle-icon-${iconPosition}`])}>
			<Button id={id + '-header'} className={className} type="button" data-toggle="collapse" data-target={'#' + id + '-body'} aria-expanded={opened} aria-controls={id + '-body'}>
				{icon}
			</Button>
			<RichText.Content tagName="span" value={content} className="toggle-text" />
		</div>
	);
}

export function editToggleButton(attributes, setAttributes) {
	let { className, id, btnClasses, iconPosition, closedIcon, openedIcon, opened, content } = attributes;
	className = classNames(['btn', className]);
	const icon = toggleIcon(openedIcon, closedIcon, iconPosition);
	return (
		<div className={classNames(['toggle-block d-flex align-items-center', `toggle-icon-${iconPosition}`])}>
			<Button id={id + '-header'} className={className} type="button" data-toggle="collapse" data-target={'#' + id + '-body'} aria-expanded={opened} aria-controls={id + '-body'}>
				{icon}
			</Button>
			<RichText tagName="span" value={content} onChange={(content) => setAttributes({ content })} placeholder={__('Button Toggle Text…')} className="toggle-text" />
		</div>
	);
}
import TokenList from '@wordpress/token-list';
/**
 * Returns the active style from the given className.
 *
 * @param {Array}  styles    Block style variations.
 * @param {string} className Class name
 *
 * @return {Object?} The active style.
 */

export function getActiveStyle(styles, className) {
	const classes = new TokenList(className).values();

	for (const style of classes) {
		if (style.indexOf('is-style-') === -1) {
			continue;
		}

		const styleName = style.substring(9);
		if (styleName) {
			return styleName;
		}
	}

	return find(styles, { isDefault: true });
}

export function getStyleClasses(props) {
	const { attributes } = props;
	let { textColor, bgColor, bgImage, textAlignment, hAlign, vAlign, className, alignType } = attributes;

	let classes = classNames(className, {
		[className]: className != undefined,
	});

	if (textColor != undefined) {
		textColor = `has-${textColor}-color`;
		classes = updateClassesFromStyles(textColor, classes, /has-[\w-]*-color/);
	}
	if (bgColor != undefined) {
		bgColor = `has-${bgColor}-background-color`;
		classes = updateClassesFromStyles(bgColor, classes, /has-[\w-]*-background-color/);
	}
	if (textAlignment != undefined && textAlignment != 'none' && textAlignment != 'default' && textAlignment != '') {
		textAlignment = `has-text-align-${textAlignment}`;
		classes = updateClassesFromStyles(textAlignment, classes, /has-text-align-\w+/);
	}
	let hasBG = false;
	if (className != undefined) {
		if (className.match(/is-style[\w-]*/)) {
			if (className.match(/is-style-default/)) {
				hasBG = false;
			} else {
				hasBG = true;
			}
		}
	} else if (bgImage != undefined) {
		hasBG = true;
	} else if (bgColor != undefined) {
		hasBG = true;
	}
	classes = classNames(classes, className, {
		'has-background': hasBG,
	});
	classes = uniqueClasses(classes);
	return classes;
}

export function uniqueClasses(classes = []) {
	if (Array.isArray(classes)) {
		classes = classes.split(' ');

		classes = classes.filter(onlyUnique);

		classes = classes.join(' ');
	}

	return classes;
}

/**
 * Generates classes from the attributes based on block type
 *
 * @date 24/11/2020
 * @export
 * @param  blockName
 * @param  attributes
 * @param  string     blockName The name of the block
 * @param  object     attributes
 * @return string The classes
 */
export function generateClasses(blockName, attributes) {
	let classes = '';
	let type = '';
	if ('className' in attributes) {
		classes = classNames(classes, attributes.className);
	}
	if ('textColor' in attributes) {
		classes = updateClassesFromStyles(attributes.textColor, classes, /has-[\w-]*-color/);
	}
	if ('bgColor' in attributes) {
		classes = updateClassesFromStyles(attributes.bgColor, classes, /has-[\w-]*-background-color/);
	}

	if ('textAlignment' in attributes) {
		const textAlign = attributes.textAlignment != null ? 'has-text-align-' + attributes.textAlignment : '';
		classes = updateClassesFromStyles(textAlign, classes, /has-text-align-\w+/);
	}
	if (typeof blockName === 'string' && blockName.match('rwp/')) {
		type = blockName.replace('rwp/', '');
		blockName = blockName.replace('/', '-');

		classes = classNames('rwp', blockName);

		switch (type) {
			case 'section':
				classes = classNames(classes, 'section-wrapper', {
					'has-background': typeof attributes.bgImage !== undefined && attributes.bgImage != null,
				});
				break;
			case 'container':
				classes = classNames(classes, {
					'container-fluid': attributes.fluid,
					container: !attributes.fluid,
					'container-sm': attributes.fluidSm,
					'container-ms': attributes.fluidMs,
					'container-md': attributes.fluidMd,
					'container-ml': attributes.fluidMl,
					'container-lg': attributes.fluidLg,
					'container-xl': attributes.fluidXl,
				});
				break;
			case 'card':
				classes = classNames(classes, attributes.textColorClass, attributes.bgColorClass, {
					'flex-column': attributes.layout == 'vertical',
					'flex-row': attributes.layout == 'horizontal',
				});
				break;
			case 'row':
				classes = classNames(classes, {
					[`row-cols-sm-${attributes.rowColsSm}`]: attributes.rowColsSm > 0,
					[`row-cols-ms-${attributes.rowColsMs}`]: attributes.rowColsMs > 0,
					[`row-cols-md-${attributes.rowColsMd}`]: attributes.rowColsMd > 0,
					[`row-cols-ml-${attributes.rowColsMl}`]: attributes.rowColsMl > 0,
					[`row-cols-lg-${attributes.rowColsLg}`]: attributes.rowColsLg > 0,
					[`row-cols-xl-${attributes.rowColsXl}`]: attributes.rowColsXl > 0,
					[`justify-content-${attributes.hAlign}`]: attributes.hAlign !== 'none',
					[`align-items-${attributes.vAlign}`]: attributes.vAlign !== 'none',
				});
				break;
			case 'column':
				classes = classNames(classes, 'col', {
					'col-sm-auto': attributes.autoSm,
					'col-ms-auto': attributes.autoMs,
					'col-md-auto': attributes.autoMd,
					'col-ml-auto': attributes.autoMl,
					'col-lg-auto': attributes.autoLg,
					'col-xl-auto': attributes.autoXl,
					[`col-sm-${attributes.sizeSm}`]: !attributes.autoSm && attributes.sizeSm > 0,
					[`col-ms-${attributes.sizeMs}`]: !attributes.autoMs && attributes.sizeMs > 0,
					[`col-md-${attributes.sizeMd}`]: !attributes.autoMd && attributes.sizeMd > 0,
					[`col-ml-${attributes.sizeMl}`]: !attributes.autoMl && attributes.sizeMl > 0,
					[`col-lg-${attributes.sizeLg}`]: !attributes.autoLg && attributes.sizeLg > 0,
					[`col-xl-${attributes.sizeXl}`]: !attributes.autoXl && attributes.sizeXl > 0,
					[`col-sm-${attributes.offsetSm}`]: attributes.offsetSm > 0,
					[`col-ms-${attributes.offsetMs}`]: attributes.offsetMs > 0,
					[`col-md-${attributes.offsetMd}`]: attributes.offsetMd > 0,
					[`col-ml-${attributes.offsetMl}`]: attributes.offsetMl > 0,
					[`col-lg-${attributes.offsetLg}`]: attributes.offsetLg > 0,
					[`col-xl-${attributes.offsetXl}`]: attributes.offsetXl > 0,
				});
				break;
			case 'toggle-body':
				classes = classNames(classes, 'collapse', {
					show: attributes.isOpenBody,
				});
				break;
			case 'toggle-button':
				classes = classNames(classes, 'btn');
				break;
			default:
				break;
		}
	} else if (blockName === 'core/image') {
		const { url, alt, caption, align, href, rel, linkClass, width, height, id, linkTarget, sizeSlug, title } = attributes;
		classes = classNames('media-wrapper', 'image-wrapper', {
			[`align${align}`]: align,
			[`size-${sizeSlug}`]: sizeSlug,
			'is-resized': width || height,
		});
	} else if (blockName === 'core/column') {
		classes = classNames(classes, 'col', {
			'col-sm-auto': attributes.autoSm,
			'col-ms-auto': attributes.autoMs,
			'col-md-auto': attributes.autoMd,
			'col-ml-auto': attributes.autoMl,
			'col-lg-auto': attributes.autoLg,
			'col-xl-auto': attributes.autoXl,
			[`col-sm-${attributes.sizeSm}`]: !attributes.autoSm && attributes.sizeSm > 0,
			[`col-ms-${attributes.sizeMs}`]: !attributes.autoMs && attributes.sizeMs > 0,
			[`col-md-${attributes.sizeMd}`]: !attributes.autoMd && attributes.sizeMd > 0,
			[`col-ml-${attributes.sizeMl}`]: !attributes.autoMl && attributes.sizeMl > 0,
			[`col-lg-${attributes.sizeLg}`]: !attributes.autoLg && attributes.sizeLg > 0,
			[`col-xl-${attributes.sizeXl}`]: !attributes.autoXl && attributes.sizeXl > 0,
			[`col-sm-${attributes.offsetSm}`]: attributes.offsetSm > 0,
			[`col-ms-${attributes.offsetMs}`]: attributes.offsetMs > 0,
			[`col-md-${attributes.offsetMd}`]: attributes.offsetMd > 0,
			[`col-ml-${attributes.offsetMl}`]: attributes.offsetMl > 0,
			[`col-lg-${attributes.offsetLg}`]: attributes.offsetLg > 0,
			[`col-xl-${attributes.offsetXl}`]: attributes.offsetXl > 0,
		});
	} else if (blockName === 'core/columns') {
		classes = classNames(classes, 'row', {
			[`row-cols-ms-${attributes.rowColsMs}`]: attributes.rowColsMs > 0,
			[`row-cols-md-${attributes.rowColsMd}`]: attributes.rowColsMd > 0,
			[`row-cols-ml-${attributes.rowColsMl}`]: attributes.rowColsMl > 0,
			[`row-cols-lg-${attributes.rowColsLg}`]: attributes.rowColsLg > 0,
			[`row-cols-xl-${attributes.rowColsXl}`]: attributes.rowColsXl > 0,
			[`justify-content-${attributes.hAlign}`]: attributes.hAlign !== 'none',
			[`align-items-${attributes.vAlign}`]: attributes.vAlign !== 'none',
		});
	}
	classes = classes.split(' ');

	classes = classes.filter(onlyUnique);

	classes = classes.join(' ');
	return classes;
}

export function contentClasses(contentClass = 'content-wrapper', attributes = { hAlign: 'none', vAlign: 'none' }, type = 'flex') {
	const { hAlign, vAlign } = attributes;

	return classNames(contentClass, {
		[`align-items-${hAlign}`]: hAlign !== 'none' && type === 'flex',
		[`justify-content-${vAlign}`]: vAlign !== 'none' && type === 'flex',
		[`text-${hAlign}`]: hAlign !== 'none' && type === 'type',
	});
}

function imageSizes(image) {
	if (typeof image === 'object') {
		const sizes = [];
		if (image.sizes && image.mime_type !== 'image/svg+xml') {
			for (const [name, size] of Object.entries(image.sizes)) {
				let url = new URL(size.url);
				url = url.pathname;
				sizes.push(`${url} ${size.width}w ${size.height}h`);
			}
		}
		if (sizes.length > 1) {
			return sizes.join(', ');
		}
	}
}

export function displayBGImage(srcset = '') {
	if (srcset !== '') {
		return <div className="section-bg is-bg lazyload" data-sizes="auto" data-bgset={srcset}></div>;
	}
}
const solidVariations = bsVariations('Button', 'btn');
const outlineVariations = bsVariations('Button Outline', 'btn-outline');

const variations = solidVariations.concat(outlineVariations);

variations.push({
	name: 'btn-link',
	label: __('Plain link style', 'rwp'),
});

const buttonOpts = [
	{
		label: __('Select an option', 'rwp'),
		value: '',
	},
];

variations.forEach((element) => {
	buttonOpts.push({
		value: element.name,
		label: element.label,
	});
});

export const buttonVariations = variations;

export const buttonOptions = buttonOpts;
