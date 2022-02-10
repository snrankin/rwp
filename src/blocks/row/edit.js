/**
 * ============================================================================
 * edit
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
import { isNil, get } from 'lodash';
import {
	RangeControl,
	PanelBody,
	PanelRow,
	ToggleControl,
} from '@wordpress/components';
import { compose } from '@wordpress/compose';

import {
	InnerBlocks,
	BlockControls,
	AlignmentToolbar,
	InspectorControls,
	useBlockProps,
	__experimentalBlockVariationPicker as VariationPicker,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
} from '@wordpress/block-editor';

import { createBlocksFromInnerBlocksTemplate } from '@wordpress/blocks';

import { withSelect, useSelect } from '@wordpress/data';

//import './edit.scss';

import { vStretch, hAlignStart } from '../global/icons';

import {
	classNames,
	uniqueClasses,
	updateClassesFromAtts,
	alignControls,
} from '../global/helpers';

export function rowClasses(attributes) {
	const {
		rowColsXl,
		rowColsLg,
		rowColsMl,
		rowColsMd,
		rowColsMs,
		rowColsSm,
		hAlign,
		vAlign,
		className,
		noGutters,
	} = attributes;
	let classes = classNames(className, {
		'no-gutters': noGutters,
	});

	if (rowColsSm > 0) {
		classes = updateClassesFromAtts(
			`row-cols-sm-${rowColsSm}`,
			classes,
			/row-cols-sm-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /row-cols-sm-[\d|\w]+/);
	}

	if (rowColsMs > 0) {
		classes = updateClassesFromAtts(
			`row-cols-ms-${rowColsMs}`,
			classes,
			/row-cols-ms-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /row-cols-ms-[\d|\w]+/);
	}

	if (rowColsMd > 0) {
		classes = updateClassesFromAtts(
			`row-cols-md-${rowColsMd}`,
			classes,
			/row-cols-md-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /row-cols-md-[\d|\w]+/);
	}

	if (rowColsMl > 0) {
		classes = updateClassesFromAtts(
			`row-cols-ml-${rowColsMl}`,
			classes,
			/row-cols-ml-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /row-cols-ml-[\d|\w]+/);
	}

	if (rowColsLg > 0) {
		classes = updateClassesFromAtts(
			`row-cols-lg-${rowColsLg}`,
			classes,
			/row-cols-lg-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /row-cols-lg-[\d|\w]+/);
	}

	if (rowColsXl > 0) {
		classes = updateClassesFromAtts(
			`row-cols-xl-${rowColsXl}`,
			classes,
			/row-cols-xl-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /row-cols-xl-[\d|\w]+/);
	}

	if (!isNil(hAlign) && hAlign !== 'none' && hAlign !== '') {
		classes = updateClassesFromAtts(
			hAlign,
			classes,
			/justify-content-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts(
			'',
			classes,
			/justify-content-[\d|\w]+/
		);
	}

	if (!isNil(vAlign) && vAlign !== 'none' && vAlign !== '') {
		classes = updateClassesFromAtts(
			vAlign,
			classes,
			/align-items-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /align-items-[\d|\w]+/);
	}

	classes = uniqueClasses(classes);

	return classes;
}

const ColumnsRangeControl = ({
	label,
	attributeName,
	value,
	setAttributes,
	...props
}) => {
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
			max={12}
			{...props}
		/>
	);
};

const BLOCK_TEMPLATE = [['rwp/column', {}]];
const ALLOWED_BLOCKS = ['rwp/column'];
const TEMPLATE_LOCK = false;

wp.hooks.addFilter(
	'blocks.getBlockDefaultClassName',
	'rwp/row',
	(className, blockName) => {
		if (blockName !== 'rwp/row') {
			return className;
		}

		className = classNames('rwp', 'row');

		return className;
	}
);

function Edit(props) {
	const {
		attributes,
		setAttributes,
		clientId,
		hasInnerBlocks,
		blockType,
		defaultVariation,
		variations,
	} = props;
	const {
		noGutters,
		hAlign,
		vAlign,
		rowColsXl,
		rowColsLg,
		rowColsMl,
		rowColsMd,
		rowColsMs,
	} = attributes;

	const classes = rowClasses(attributes);

	const blockProps = useBlockProps({
		className: classes,
	});

	const innerBlocksProps = useInnerBlocksProps(blockProps, {
		templateLock: TEMPLATE_LOCK,
		allowedBlocks: ALLOWED_BLOCKS,
		orientation: 'horizontal',
		renderAppender: hasInnerBlocks
			? undefined
			: InnerBlocks.ButtonBlockAppender,
	});

	const placeholder = (
		<div {...blockProps}>
			<VariationPicker
				icon={get(blockType, ['icon', 'src'])}
				label={get(blockType, ['title'])}
				variations={variations}
				onSelect={(nextVariation = defaultVariation) => {
					if (nextVariation.attributes) {
						setAttributes(nextVariation.attributes);
					}
					if (nextVariation.innerBlocks) {
						wp.data
							.dispatch('core/block-editor')
							.replaceInnerBlocks(
								clientId,
								createBlocksFromInnerBlocksTemplate(
									nextVariation.innerBlocks
								),
								true
							);
					}
				}}
				allowSkip
			/>
		</div>
	);

	return (
		<>
			<BlockControls>
				<AlignmentToolbar
					value={hAlign}
					icon={hAlignStart}
					label={__('Change horizontal alignment of columns', 'rwp')}
					onChange={(val) => setAttributes({ hAlign: val })}
					alignmentControls={alignControls('columns', 'horizontal')}
				/>
				<AlignmentToolbar
					value={vAlign}
					icon={vStretch}
					label={__('Change vertical alignment of columns', 'rwp')}
					onChange={(val) =>
						setAttributes({
							vAlign: val,
						})
					}
					alignmentControls={alignControls(
						'columns',
						'vertical',
						'align-items'
					)}
				/>
			</BlockControls>
			<InspectorControls>
				<PanelBody title={__('Row Settings', 'rwp')} initialOpen={true}>
					<PanelRow>
						<ToggleControl
							label={__('Remove Gutters', 'rwp')}
							checked={noGutters}
							onChange={(isChecked) =>
								setAttributes({ noGutters: isChecked })
							}
						/>
					</PanelRow>
					<PanelRow>
						<ColumnsRangeControl
							label={__('Number of columns per row XL', 'rwp')}
							attributeName="rowColsXl"
							value={rowColsXl}
							setAttributes={setAttributes}
						/>
					</PanelRow>
					<PanelRow>
						<ColumnsRangeControl
							label={__('Number of columns per row LG', 'rwp')}
							attributeName="rowColsLg"
							value={rowColsLg}
							setAttributes={setAttributes}
						/>
					</PanelRow>
					<PanelRow>
						<ColumnsRangeControl
							label={__('Number of columns per row ML', 'rwp')}
							attributeName="rowColsMl"
							value={rowColsMl}
							setAttributes={setAttributes}
						/>
					</PanelRow>
					<PanelRow>
						<ColumnsRangeControl
							label={__('Number of columns per row MD', 'rwp')}
							attributeName="rowColsMd"
							value={rowColsMd}
							setAttributes={setAttributes}
						/>
					</PanelRow>
					<PanelRow>
						<ColumnsRangeControl
							label={__('Number of columns per row MS', 'rwp')}
							attributeName="rowColsMs"
							value={rowColsMs}
							setAttributes={setAttributes}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			{hasInnerBlocks ? <div {...innerBlocksProps} /> : placeholder}
		</>
	);
}
export default compose(
	withSelect((select, ownProps) => {
		const { clientId, name, setAttributes } = ownProps;
		const { getBlockOrder } =
			select('core/block-editor') || select('core/editor');

		const hasInnerBlocks = useSelect(
			(select) => {
				const { getBlock } = select('core/block-editor');
				const block = getBlock(clientId);
				return !!(block && block.innerBlocks.length);
			},
			[clientId]
		);

		const { getBlockVariations, getBlockType, getDefaultBlockVariation } =
			select('core/blocks');

		return {
			clientId,
			blockType: getBlockType(name),
			defaultVariation: getDefaultBlockVariation(name, 'block'),
			variations: getBlockVariations(name, 'block'),
			hasInnerBlocks,
		};
	})
)(Edit);
