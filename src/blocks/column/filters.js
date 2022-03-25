/**
 * ============================================================================
 * filters
 *
 * @file
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

import { __ } from '@wordpress/i18n';

import { compose, createHigherOrderComponent, withState } from '@wordpress/compose';

import { withSelect, useSelect } from '@wordpress/data';

import { RangeControl, PanelBody, PanelRow, ToggleControl, Flex, FlexBlock, FlexItem, Toolbar, ToolbarGroup, ToolbarButton, ResizableBox, Panel } from '@wordpress/components';
import { Component, Fragment, cloneElement, createElement } from '@wordpress/element';
import { InnerBlocks, BlockControls, BlockVerticalAlignmentToolbar, InspectorControls, useBlockProps, __experimentalUseInnerBlocksProps as useInnerBlocksProps } from '@wordpress/block-editor';
import TokenList from '@wordpress/token-list';

import { vAlignStart, vAlignCenter, vAlignEnd, hAlignStart, hAlignCenter, hAlignEnd, vDist, hStretch, desktopIcon, laptopIcon, tabletLandscapeIcon, tabletPortraitIcon, mobileIcon } from '../global/icons';

import { classNames, generateClasses, contentClasses, alignControls, bsColumns, closest, arraySearch, getStyleClasses, uniqueClasses, updateClassesFromAtts } from '../global/helpers';

const newAtts = {
	apiVersion: 2,
	attributes: {
		hAlign: {
			type: 'string',
			default: 'none',
		},
		vAlign: {
			type: 'string',
			default: 'none',
		},
		sizeSm: {
			type: 'number',
			default: 0,
		},
		sizeMs: {
			type: 'number',
			default: 0,
		},
		sizeMd: {
			type: 'number',
			default: 0,
		},
		sizeMl: {
			type: 'number',
			default: 0,
		},
		sizeLg: {
			type: 'number',
			default: 0,
		},
		sizeXl: {
			type: 'number',
			default: 0,
		},
		offsetSm: {
			type: 'number',
			default: 0,
		},
		offsetMs: {
			type: 'number',
			default: 0,
		},
		offsetMd: {
			type: 'number',
			default: 0,
		},
		offsetMl: {
			type: 'number',
			default: 0,
		},
		offsetLg: {
			type: 'number',
			default: 0,
		},
		offsetXl: {
			type: 'number',
			default: 0,
		},
		autoSm: {
			type: 'boolean',
			default: false,
		},
		autoMs: {
			type: 'boolean',
			default: false,
		},
		autoMd: {
			type: 'boolean',
			default: false,
		},
		autoMl: {
			type: 'boolean',
			default: false,
		},
		autoLg: {
			type: 'boolean',
			default: false,
		},
		autoXl: {
			type: 'boolean',
			default: false,
		},
	},
};

function compareColWidth(attributes) {
	const { width, sizeXl } = attributes;

	const colWidth = parseFloat(width) / 100;
	const closestCol = closest(colWidth, bsColumns);
	let colWidthClass = closest(closestCol, bsColumns);
	colWidthClass = arraySearch(bsColumns, colWidthClass);

	if (colWidthClass == sizeXl) {
		return true;
	}
	return false;
}

function getColWidth(attributes, type = 'class') {
	const { width, sizeXl } = attributes;

	let colWidth;

	if (type === 'class') {
		colWidth = parseFloat(width) / 100;
		colWidth = closest(colWidth, bsColumns);
		colWidth = arraySearch(bsColumns, colWidth);
		colWidth = colWidth - 1;
	} else {
		colWidth = bsColumns[sizeXl];
		colWidth = colWidth * 100;
		colWidth = `${colWidth}%`;
	}

	return colWidth;
}

const colWidths = (attributes) => {
	const { sizeXl, sizeLg, sizeMl, sizeMd, sizeMs, sizeSm, autoXl, autoLg, autoMl, autoMd, autoMs, autoSm, offsetXl, offsetLg, offsetMl, offsetMd, offsetMs, offsetSm, hAlign, vAlign, className, width } = attributes;

	let classes = className;

	if (!autoSm && sizeSm > 0) {
		classes = updateClassesFromAtts(`col-sm-${sizeSm}`, classes, /col-sm-[\d|\w]+/);
	} else if (autoSm && sizeSm > 0) {
		classes = updateClassesFromAtts('col-sm-auto', classes, /col-sm-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /col-sm-[\d|\w]+/);
	}

	if (!autoMs && sizeMs > 0) {
		classes = updateClassesFromAtts(`col-ms-${sizeMs}`, classes, /col-ms-[\d|\w]+/);
	} else if (autoMs && sizeMs > 0) {
		classes = updateClassesFromAtts('col-ms-auto', classes, /col-ms-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /col-ms-[\d|\w]+/);
	}

	if (!autoMd && sizeMd > 0) {
		classes = updateClassesFromAtts(`col-md-${sizeMd}`, classes, /col-md-[\d|\w]+/);
	} else if (autoMd && sizeMd > 0) {
		classes = updateClassesFromAtts('col-md-auto', classes, /col-md-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /col-md-[\d|\w]+/);
	}

	if (!autoMl && sizeMl > 0) {
		classes = updateClassesFromAtts(`col-ml-${sizeMl}`, classes, /col-ml-[\d|\w]+/);
	} else if (autoMl && sizeMl > 0) {
		classes = updateClassesFromAtts('col-ml-auto', classes, /col-ml-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /col-ml-[\d|\w]+/);
	}

	if (!autoLg && sizeLg > 0) {
		classes = updateClassesFromAtts(`col-lg-${sizeLg}`, classes, /col-lg-[\d|\w]+/);
	} else if (autoLg && sizeLg > 0) {
		classes = updateClassesFromAtts('col-lg-auto', classes, /col-lg-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /col-lg-[\d|\w]+/);
	}

	if (!autoXl && sizeXl > 0) {
		classes = updateClassesFromAtts(`col-xl-${sizeXl}`, classes, /col-xl-[\d|\w]+/);
	} else if (autoXl && sizeXl > 0) {
		classes = updateClassesFromAtts('col-xl-auto', classes, /col-xl-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /col-xl-[\d|\w]+/);
	}

	if (offsetSm > 0) {
		classes = updateClassesFromAtts(`offset-sm-${offsetSm}`, classes, /offset-sm-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-sm-[\d|\w]+/);
	}

	if (offsetMs > 0) {
		classes = updateClassesFromAtts(`offset-ms-${offsetMs}`, classes, /offset-ms-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-ms-[\d|\w]+/);
	}

	if (offsetMd > 0) {
		classes = updateClassesFromAtts(`offset-md-${offsetMd}`, classes, /offset-md-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-md-[\d|\w]+/);
	}

	if (offsetMl > 0) {
		classes = updateClassesFromAtts(`offset-ml-${offsetMl}`, classes, /offset-ml-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-ml-[\d|\w]+/);
	}

	if (offsetLg > 0) {
		classes = updateClassesFromAtts(`offset-lg-${offsetLg}`, classes, /offset-lg-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-lg-[\d|\w]+/);
	}

	if (offsetXl > 0) {
		classes = updateClassesFromAtts(`offset-xl-${offsetXl}`, classes, /offset-xl-[\d|\w]+/);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-xl-[\d|\w]+/);
	}
	classes = uniqueClasses(classes);

	return classes;
};

const ColumnSizeRangeControl = ({ label, attributeName, value, setAttributes, ...props }) => {
	return (
		<RangeControl
			label={label}
			value={value}
			onChange={(selectedSize) => {
				if (attributeName === 'sizeXl') {
					if (selectedSize > 0) {
						let colWidth = bsColumns[selectedSize];
						colWidth = colWidth * 100;
						setAttributes({
							[attributeName]: selectedSize,
							width: colWidth,
						});
					} else {
						setAttributes({
							[attributeName]: selectedSize,
							width: '',
						});
					}
				} else {
					setAttributes({
						[attributeName]: selectedSize,
					});
				}
			}}
			min={0}
			max={12}
			{...props}
		/>
	);
};

wp.hooks.addFilter('blocks.registerBlockType', 'rwp/column', (props, name) => {
	if ('core/column' !== name) {
		return props;
	}

	const newAttributes = Object.assign(newAtts, props.attributes);

	return { ...props, newAttributes };
});

wp.hooks.addFilter('blocks.getSaveElement', 'core/column', (element, block, attributes) => {
	if ('core/column' !== block.name) {
		return element;
	}

	const elementChildren = createElement(
		'div',
		{
			className: 'content-wrapper',
		},
		element.props.children
	);
	element = cloneElement(element, null, elementChildren);

	return element;
});

wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/column', (className, blockName) => {
	return blockName === 'core/column' ? 'col' : className;
});

wp.hooks.addFilter(
	'editor.BlockListBlock',
	'rwp/column',
	createHigherOrderComponent((BlockListBlock) => {
		return (props) => {
			if (props.name !== 'core/column') {
				return <BlockListBlock {...props} />;
			}

			const { attributes, setAttributes } = props;

			if (!compareColWidth(attributes)) {
				const colWidth = getColWidth(attributes, 'number');
				props.attributes.width = colWidth;
				props.attributes.sizeXl = getColWidth(attributes);

				if (props.attributes.style !== undefined) {
					props.attributes.style.flexBasis = colWidth;
				} else {
					props.attributes.style = {
						flexBasis: colWidth,
					};
				}
			}

			const { width, sizeXl } = attributes;
			const classes = colWidths(attributes);
			props.attributes.className = classes;

			return <BlockListBlock {...props} />;
		};
	})
);

wp.hooks.addFilter(
	'editor.BlockEdit',
	'rwp/column',
	createHigherOrderComponent((BlockEdit) => {
		return (props) => {
			if ('core/column' !== props.name) {
				return <BlockEdit {...props} />;
			}

			const { attributes, setAttributes } = props;
			const { sizeXl, sizeLg, sizeMl, sizeMd, sizeMs, sizeSm, autoXl, autoLg, autoMl, autoMd, autoMs, autoSm, offsetXl, offsetLg, offsetMl, offsetMd, offsetMs, offsetSm, hAlign, vAlign, className, width } = attributes;

			const innerBlocksProps = useInnerBlocksProps({
				className: 'content-wrapper',
			});

			return (
				<>
					<BlockEdit {...props} />
					<InspectorControls>
						<PanelBody title={__('Screens > 1440px', 'rwp')} initialOpen={true} icon={desktopIcon}>
							<ColumnSizeRangeControl label={__('Column Width', 'rwp')} attributeName="sizeXl" value={sizeXl} setAttributes={setAttributes} />
							<PanelRow>
								<ToggleControl
									label={__('Auto Size', 'rwp')}
									checked={autoXl}
									onChange={(isChecked) =>
										setAttributes({
											autoXl: isChecked,
											width: '',
											sizeXl: 0,
										})
									}
								/>
							</PanelRow>
							<PanelRow>
								<ColumnSizeRangeControl label={__('Column offset', 'rwp')} attributeName="offsetXl" value={offsetXl} setAttributes={setAttributes} />
							</PanelRow>
						</PanelBody>
						<PanelBody title={__('Screens > 1280px', 'rwp')} initialOpen={false} icon={laptopIcon}>
							<PanelRow>
								<ColumnSizeRangeControl label={__('Column Width', 'rwp')} attributeName="sizeLg" value={sizeLg} setAttributes={setAttributes} />
							</PanelRow>
							<PanelRow>
								<ToggleControl
									label={__('Auto Size', 'rwp')}
									checked={autoLg}
									onChange={(isChecked) =>
										setAttributes({
											autoLg: isChecked,
											sizeLg: 0,
										})
									}
								/>
							</PanelRow>
							<PanelRow>
								<ColumnSizeRangeControl label={__('Column offset', 'rwp')} attributeName="offsetLg" value={offsetLg} setAttributes={setAttributes} />
							</PanelRow>
						</PanelBody>
						<PanelBody title={__('Screens > 1024px', 'rwp')} initialOpen={false} icon={tabletLandscapeIcon}>
							<PanelRow>
								<ColumnSizeRangeControl label={__('Column Width', 'rwp')} attributeName="sizeMl" value={sizeMl} setAttributes={setAttributes} />
							</PanelRow>
							<PanelRow>
								<ToggleControl
									label={__('Auto Size', 'rwp')}
									checked={autoMl}
									onChange={(isChecked) =>
										setAttributes({
											autoMl: isChecked,
											sizeMl: 0,
										})
									}
								/>
							</PanelRow>
							<PanelRow>
								<ColumnSizeRangeControl label={__('Column offset', 'rwp')} attributeName="offsetMl" value={offsetMl} setAttributes={setAttributes} />
							</PanelRow>
						</PanelBody>
						<PanelBody title={__('Screens > 768px', 'rwp')} initialOpen={false} icon={tabletPortraitIcon}>
							<PanelRow>
								<ColumnSizeRangeControl label={__('Column Width', 'rwp')} attributeName="sizeMd" value={sizeMd} setAttributes={setAttributes} />
							</PanelRow>
							<PanelRow>
								<ToggleControl
									label={__('Auto Size', 'rwp')}
									checked={autoMd}
									onChange={(isChecked) =>
										setAttributes({
											autoMd: isChecked,
											sizeMd: 0,
										})
									}
								/>
							</PanelRow>
							<PanelRow>
								<ColumnSizeRangeControl label={__('Column offset', 'rwp')} attributeName="offsetLg" value={offsetLg} setAttributes={setAttributes} />
							</PanelRow>
						</PanelBody>
						<PanelBody title={__('Screens < 768px', 'rwp')} initialOpen={false} icon={mobileIcon}>
							<PanelRow>
								<ColumnSizeRangeControl label={__('Column Width', 'rwp')} attributeName="sizeSm" value={sizeSm} setAttributes={setAttributes} />
							</PanelRow>
							<PanelRow>
								<ToggleControl
									label={__('Auto Size', 'rwp')}
									checked={autoSm}
									onChange={(isChecked) =>
										setAttributes({
											autoSm: isChecked,
											sizeSm: 0,
										})
									}
								/>
							</PanelRow>
							<PanelRow>
								<ColumnSizeRangeControl label={__('Column offset', 'rwp')} attributeName="offsetSm" value={offsetSm} setAttributes={setAttributes} />
							</PanelRow>
						</PanelBody>
					</InspectorControls>
				</>
			);
		};
	})
);
