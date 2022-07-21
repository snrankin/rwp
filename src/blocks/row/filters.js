/**
 * ============================================================================
 * filters
 *
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */

import { __ } from '@wordpress/i18n';

import { RangeControl, PanelBody, PanelRow, ToggleControl, Flex, FlexItem, FlexBlock } from '@wordpress/components';
import { Component, Fragment } from '@wordpress/element';
import { withSelect } from '@wordpress/data';
import { compose, createHigherOrderComponent } from '@wordpress/compose';
import * as BlockEditor from '@wordpress/block-editor';
import * as Editor from '@wordpress/editor';

import { vAlignCenter, hAlignCenter } from '../global/icons';

const { InnerBlocks, InspectorControls, BlockControls, AlignmentToolbar } = BlockEditor || Editor; // Fallback to deprecated '@wordpress/editor' for backwards compatibility

import { generateClasses, alignControls, classNames, uniqueClasses, getStyleClasses, updateClassesFromAtts } from '../global/helpers';

const ColumnsRangeControl = ({ label, attributeName, value, setAttributes, ...props }) => {
	return (
		<RangeControl
			label={label}
			value={value}
			onChange={(selectedSize) => {
				setAttributes({
					[attributeName]: selectedSize,
				});
			}}
			min={0}
			max={6}
			{...props}
		/>
	);
};

wp.hooks.addFilter(
	'editor.BlockListBlock',
	'rwp/row',
	createHigherOrderComponent((BlockListBlock) => {
		return (props) => {
			if (props.name !== 'core/columns') {
				return <BlockListBlock {...props} />;
			}
			const { attributes } = props;
			const { rowColsXl, rowColsLg, rowColsMl, rowColsMd, rowColsMs, rowColsSm, hAlign, vAlign, className, noGutters } = attributes;
			let classes = classNames(className, {
				'no-gutters': noGutters,
			});

			if (rowColsSm > 0) {
				classes = updateClassesFromAtts(`row-cols-sm-${rowColsSm}`, classes, /row-cols-sm-[\d|\w]+/);
			} else {
				classes = updateClassesFromAtts('', classes, /row-cols-sm-[\d|\w]+/);
			}

			if (rowColsMs > 0) {
				classes = updateClassesFromAtts(`row-cols-ms-${rowColsMs}`, classes, /row-cols-ms-[\d|\w]+/);
			} else {
				classes = updateClassesFromAtts('', classes, /row-cols-ms-[\d|\w]+/);
			}

			if (rowColsMd > 0) {
				classes = updateClassesFromAtts(`row-cols-md-${rowColsMd}`, classes, /row-cols-md-[\d|\w]+/);
			} else {
				classes = updateClassesFromAtts('', classes, /row-cols-md-[\d|\w]+/);
			}

			if (rowColsMl > 0) {
				classes = updateClassesFromAtts(`row-cols-ml-${rowColsMl}`, classes, /row-cols-ml-[\d|\w]+/);
			} else {
				classes = updateClassesFromAtts('', classes, /row-cols-ml-[\d|\w]+/);
			}

			if (rowColsLg > 0) {
				classes = updateClassesFromAtts(`row-cols-lg-${rowColsLg}`, classes, /row-cols-lg-[\d|\w]+/);
			} else {
				classes = updateClassesFromAtts('', classes, /row-cols-lg-[\d|\w]+/);
			}

			if (rowColsXl > 0) {
				classes = updateClassesFromAtts(`row-cols-xl-${rowColsXl}`, classes, /row-cols-xl-[\d|\w]+/);
			} else {
				classes = updateClassesFromAtts('', classes, /row-cols-xl-[\d|\w]+/);
			}

			if (hAlign != undefined && hAlign !== 'none') {
				classes = updateClassesFromAtts(`justify-content-${hAlign}`, classes, /justify-content-[\d|\w]+/);
			} else {
				classes = updateClassesFromAtts('', classes, /justify-content-[\d|\w]+/);
			}

			if (vAlign != undefined && vAlign !== 'none') {
				classes = updateClassesFromAtts(`align-items-${vAlign}`, classes, /align-items-[\d|\w]+/);
			} else {
				classes = updateClassesFromAtts('', classes, /align-items-[\d|\w]+/);
			}

			classes = uniqueClasses(classes);
			props.attributes.className = classes;

			return <BlockListBlock {...props} />;
		};
	})
);

wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/row', (className, blockName) => {
	return blockName === 'core/columns' ? 'row' : className;
});

wp.hooks.addFilter(
	'editor.BlockEdit',
	'rwp/row',
	createHigherOrderComponent((BlockEdit) => {
		return (props) => {
			if ('core/columns' !== props.name) {
				return <BlockEdit {...props} />;
			}

			const { attributes, setAttributes } = props;
			const { noGutters, hAlign, vAlign, rowColsXl, rowColsLg, rowColsMl, rowColsMd, rowColsMs, className } = attributes;

			return (
				<Fragment>
					<BlockEdit {...props} />
					<InspectorControls>
						<PanelBody title={__('Row Settings', 'rwp')} initialOpen={true}>
							<PanelRow>
								<ToggleControl label={__('Remove Gutters', 'rwp')} checked={noGutters} onChange={(isChecked) => setAttributes({ noGutters: isChecked })} />
							</PanelRow>
							<PanelRow>
								<ColumnsRangeControl label={__('Number of columns per row XL', 'rwp')} attributeName="rowColsXl" value={rowColsXl} setAttributes={setAttributes} />
							</PanelRow>
							<PanelRow>
								<ColumnsRangeControl label={__('Number of columns per row LG', 'rwp')} attributeName="rowColsLg" value={rowColsLg} setAttributes={setAttributes} />
							</PanelRow>
							<PanelRow>
								<ColumnsRangeControl label={__('Number of columns per row ML', 'rwp')} attributeName="rowColsMl" value={rowColsMl} setAttributes={setAttributes} />
							</PanelRow>
							<PanelRow>
								<ColumnsRangeControl label={__('Number of columns per row MD', 'rwp')} attributeName="rowColsMd" value={rowColsMd} setAttributes={setAttributes} />
							</PanelRow>
							<PanelRow>
								<ColumnsRangeControl label={__('Number of columns per row MS', 'rwp')} attributeName="rowColsMs" value={rowColsMs} setAttributes={setAttributes} />
							</PanelRow>
						</PanelBody>
					</InspectorControls>
					<BlockControls>
						<AlignmentToolbar value={hAlign} icon={hAlignCenter} label={__('Change horizontal alignment of columns', 'rwp')} onChange={(val) => setAttributes({ hAlign: val })} alignmentControls={alignControls('columns', 'horizontal')} />
						<AlignmentToolbar
							value={vAlign}
							icon={vAlignCenter}
							label={__('Change vertical alignment of columns', 'rwp')}
							onChange={(val) =>
								setAttributes({
									vAlign: val,
								})
							}
							alignmentControls={alignControls('columns', 'vertical')}
						/>
					</BlockControls>
				</Fragment>
			);
		};
	})
);

import variations from './core-variations';

wp.hooks.addFilter('blocks.registerBlockType', 'rwp/row', (props, name) => {
	if ('core/columns' !== name) {
		return props;
	}

	const attributes = {
		...props.attributes,
		hAlign: {
			type: 'string',
			default: 'none',
		},
		vAlign: {
			type: 'string',
			default: 'none',
		},
		rowColsSm: {
			type: 'number',
			default: 0,
		},
		rowColsMs: {
			type: 'number',
			default: 0,
		},
		rowColsMd: {
			type: 'number',
			default: 0,
		},
		rowColsMl: {
			type: 'number',
			default: 0,
		},
		rowColsLg: {
			type: 'number',
			default: 0,
		},
		rowColsXl: {
			type: 'number',
			default: 0,
		},
		noGutters: {
			type: 'boolean',
			default: false,
		},
	};

	return { ...props, variations, attributes };
});
