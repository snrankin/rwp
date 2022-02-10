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

import {
	RangeControl,
	PanelBody,
	PanelRow,
	ToggleControl,
	Panel,
	TextControl,
} from '@wordpress/components';
import {
	compose,
	createHigherOrderComponent,
	withState,
} from '@wordpress/compose';

import {
	InnerBlocks,
	BlockControls,
	BlockAlignmentToolbar,
	AlignmentToolbar,
	BlockVerticalAlignmentToolbar,
	InspectorControls,
	useBlockProps,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
} from '@wordpress/block-editor';

import { withSelect, useSelect, useDispatch } from '@wordpress/data';

import {
	vAlignStart,
	vAlignCenter,
	vAlignEnd,
	vStretch,
	hStretch,
	hAlignStart,
	hAlignCenter,
	hAlignEnd,
	vDist,
	desktopIcon,
	laptopIcon,
	tabletLandscapeIcon,
	tabletPortraitIcon,
	mobileIcon,
} from '../global/icons';

import {
	classNames,
	alignControls,
	bsColumns,
	closest,
	arraySearch,
	getStyleClasses,
	uniqueClasses,
	updateClassesFromAtts,
	selfAlignClass,
	hasValue,
} from '../global/helpers';

import './edit.scss';

const BLOCK_TEMPLATE = [['core/paragraph', {}]];
const ALLOWED_BLOCKS = [];
const TEMPLATE_LOCK = false;

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

export function colWidths(attributes) {
	const {
		sizeXl,
		sizeLg,
		sizeMl,
		sizeMd,
		sizeMs,
		sizeSm,
		autoXl,
		autoLg,
		autoMl,
		autoMd,
		autoMs,
		autoSm,
		offsetXl,
		offsetLg,
		offsetMl,
		offsetMd,
		offsetMs,
		offsetSm,
		hAlign,
		vAlign,
		className,
		width,
	} = attributes;

	let classes = className;

	if ((sizeSm > 0) & !autoSm) {
		classes = updateClassesFromAtts(
			`col-sm-${sizeSm}`,
			classes,
			/col-sm-[\d|\w]+/
		);
	} else if (autoSm) {
		classes = updateClassesFromAtts(
			'col-sm-auto',
			classes,
			/col-sm-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /col-sm-[\d|\w]+/);
	}

	if ((sizeMs > 0) & !autoMs) {
		classes = updateClassesFromAtts(
			`col-ms-${sizeMs}`,
			classes,
			/col-ms-[\d|\w]+/
		);
	} else if (autoMs) {
		classes = updateClassesFromAtts(
			'col-ms-auto',
			classes,
			/col-ms-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /col-ms-[\d|\w]+/);
	}

	if ((sizeMd > 0) & !autoMd) {
		classes = updateClassesFromAtts(
			`col-md-${sizeMd}`,
			classes,
			/col-md-[\d|\w]+/
		);
	} else if (autoMd) {
		classes = updateClassesFromAtts(
			'col-md-auto',
			classes,
			/col-md-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /col-md-[\d|\w]+/);
	}

	if ((sizeMl > 0) & !autoMl) {
		classes = updateClassesFromAtts(
			`col-ml-${sizeMl}`,
			classes,
			/col-ml-[\d|\w]+/
		);
	} else if (autoMl) {
		classes = updateClassesFromAtts(
			'col-ml-auto',
			classes,
			/col-ml-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /col-ml-[\d|\w]+/);
	}

	if ((sizeLg > 0) & !autoLg) {
		classes = updateClassesFromAtts(
			`col-lg-${sizeLg}`,
			classes,
			/col-lg-[\d|\w]+/
		);
	} else if (autoLg) {
		classes = updateClassesFromAtts(
			'col-lg-auto',
			classes,
			/col-lg-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /col-lg-[\d|\w]+/);
	}

	if ((sizeXl > 0) & !autoXl) {
		classes = updateClassesFromAtts(
			`col-xl-${sizeXl}`,
			classes,
			/col-xl-[\d|\w]+/
		);
	} else if (autoXl) {
		classes = updateClassesFromAtts(
			'col-xl-auto',
			classes,
			/col-xl-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /col-xl-[\d|\w]+/);
	}

	if (offsetSm > 0) {
		classes = updateClassesFromAtts(
			`offset-sm-${offsetSm}`,
			classes,
			/offset-sm-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-sm-[\d|\w]+/);
	}

	if (offsetMs > 0) {
		classes = updateClassesFromAtts(
			`offset-ms-${offsetMs}`,
			classes,
			/offset-ms-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-ms-[\d|\w]+/);
	}

	if (offsetMd > 0) {
		classes = updateClassesFromAtts(
			`offset-md-${offsetMd}`,
			classes,
			/offset-md-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-md-[\d|\w]+/);
	}

	if (offsetMl > 0) {
		classes = updateClassesFromAtts(
			`offset-ml-${offsetMl}`,
			classes,
			/offset-ml-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-ml-[\d|\w]+/);
	}

	if (offsetLg > 0) {
		classes = updateClassesFromAtts(
			`offset-lg-${offsetLg}`,
			classes,
			/offset-lg-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-lg-[\d|\w]+/);
	}

	if (offsetXl > 0) {
		classes = updateClassesFromAtts(
			`offset-xl-${offsetXl}`,
			classes,
			/offset-xl-[\d|\w]+/
		);
	} else {
		classes = updateClassesFromAtts('', classes, /offset-xl-[\d|\w]+/);
	}
	classes = uniqueClasses(classes);

	return classes;
}

const ColumnSizeRangeControl = ({
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

wp.hooks.addFilter(
	'blocks.getBlockDefaultClassName',
	'rwp/column',
	(className, blockName) => {
		if (blockName !== 'rwp/column') {
			return className;
		}

		className = classNames('rwp', 'col');

		return className;
	}
);

function Edit(props) {
	const {
		attributes,
		setAttributes,
		clientId,
		isSelected,
		hasInnerBlocks,
		name,
	} = props;
	const {
		sizeXl,
		sizeLg,
		sizeMl,
		sizeMd,
		sizeMs,
		sizeSm,
		autoXl,
		autoLg,
		autoMl,
		autoMd,
		autoMs,
		autoSm,
		offsetXl,
		offsetLg,
		offsetMl,
		offsetMd,
		offsetMs,
		offsetSm,
		align,
		hAlign,
		vAlign,
		className,
		width,
		innerClasses,
	} = attributes;

	const { updateBlockAttributes } = useDispatch('core/block-editor');

	const alignClass = selfAlignClass(align);

	const colClasses = colWidths(attributes);

	const classes = classNames(className, colClasses, alignClass);

	const blockProps = useBlockProps({
		className: classes,
	});

	const contentClasses = classNames('content-wrapper', {
		[`${attributes.innerClasses}`]: hasValue(attributes.innerClasses),
		[`${attributes.vAlign}`]: hasValue(attributes.vAlign),
		[`${attributes.hAlign}`]: hasValue(attributes.hAlign),
	});

	const innerBlocksProps = useInnerBlocksProps(
		{
			className: contentClasses,
		},
		{
			renderAppender: hasInnerBlocks
				? undefined
				: InnerBlocks.ButtonBlockAppender,
		}
	);

	return (
		<div {...blockProps}>
			<BlockControls>
				<AlignmentToolbar
					value={hAlign}
					label={__('Change horizontal alignment of content', 'rwp')}
					onChange={(val) => setAttributes({ hAlign: val })}
					alignmentControls={alignControls(
						'content',
						'horizontal',
						'align-items'
					)}
				/>
				<AlignmentToolbar
					value={vAlign}
					label={__('Change vertical alignment of content', 'rwp')}
					onChange={(val) =>
						setAttributes({
							vAlign: val,
						})
					}
					alignmentControls={alignControls('content', 'vertical')}
				/>
			</BlockControls>
			<InspectorControls>
				<PanelBody
					title={__('Screens > 1440px', 'rwp')}
					initialOpen={true}
					icon={desktopIcon}
				>
					<ColumnSizeRangeControl
						label={__('Column Width', 'rwp')}
						attributeName="sizeXl"
						value={sizeXl}
						setAttributes={setAttributes}
						disabled={autoXl}
					/>
					<PanelRow>
						<ToggleControl
							label={__('Auto Size', 'rwp')}
							checked={autoXl}
							onChange={(isChecked) =>
								setAttributes({
									autoXl: isChecked,
									sizeXl: 0,
								})
							}
						/>
					</PanelRow>
					<PanelRow>
						<ColumnSizeRangeControl
							label={__('Column offset', 'rwp')}
							attributeName="offsetXl"
							value={offsetXl}
							setAttributes={setAttributes}
						/>
					</PanelRow>
				</PanelBody>
				<PanelBody
					title={__('Screens > 1280px', 'rwp')}
					initialOpen={false}
					icon={laptopIcon}
				>
					<PanelRow>
						<ColumnSizeRangeControl
							label={__('Column Width', 'rwp')}
							attributeName="sizeLg"
							value={sizeLg}
							setAttributes={setAttributes}
							disabled={autoLg}
						/>
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
						<ColumnSizeRangeControl
							label={__('Column offset', 'rwp')}
							attributeName="offsetLg"
							value={offsetLg}
							setAttributes={setAttributes}
						/>
					</PanelRow>
				</PanelBody>
				<PanelBody
					title={__('Screens > 1024px', 'rwp')}
					initialOpen={false}
					icon={tabletLandscapeIcon}
				>
					<PanelRow>
						<ColumnSizeRangeControl
							label={__('Column Width', 'rwp')}
							attributeName="sizeMl"
							value={sizeMl}
							setAttributes={setAttributes}
							disabled={autoMl}
						/>
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
						<ColumnSizeRangeControl
							label={__('Column offset', 'rwp')}
							attributeName="offsetMl"
							value={offsetMl}
							setAttributes={setAttributes}
						/>
					</PanelRow>
				</PanelBody>
				<PanelBody
					title={__('Screens > 768px', 'rwp')}
					initialOpen={false}
					icon={tabletPortraitIcon}
				>
					<PanelRow>
						<ColumnSizeRangeControl
							label={__('Column Width', 'rwp')}
							attributeName="sizeMd"
							value={sizeMd}
							setAttributes={setAttributes}
							disabled={autoMd}
						/>
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
						<ColumnSizeRangeControl
							label={__('Column offset', 'rwp')}
							attributeName="offsetMd"
							value={offsetMd}
							setAttributes={setAttributes}
							disabled={autoMd}
						/>
					</PanelRow>
				</PanelBody>
				<PanelBody
					title={__('Screens < 768px', 'rwp')}
					initialOpen={false}
					icon={mobileIcon}
				>
					<PanelRow>
						<ColumnSizeRangeControl
							label={__('Column Width', 'rwp')}
							attributeName="sizeSm"
							value={sizeSm}
							setAttributes={setAttributes}
							disabled={autoSm}
						/>
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
						<ColumnSizeRangeControl
							label={__('Column offset', 'rwp')}
							attributeName="offsetSm"
							value={offsetSm}
							setAttributes={setAttributes}
						/>
					</PanelRow>
				</PanelBody>
				<PanelBody
					title={__('Extra Column Settings', 'rwp')}
					initialOpen={true}
				>
					<PanelRow>
						<TextControl
							label={__('Inner Classes', 'rwp')}
							value={innerClasses}
							onChange={(val) =>
								setAttributes({ innerClasses: val })
							}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			<div {...innerBlocksProps} />
		</div>
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
