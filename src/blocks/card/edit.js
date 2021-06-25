/**
 * ============================================================================
 * edit
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */
import { get, times } from 'lodash';

import { __ } from '@wordpress/i18n';
import { Component, Fragment } from '@wordpress/element';
import {
	PanelBody,
	PanelRow,
	ButtonGroup,
	Button,
} from '@wordpress/components';
import {
	compose,
	createHigherOrderComponent,
	withState,
} from '@wordpress/compose';

import {
	InnerBlocks,
	InspectorControls,
	BlockControls,
	AlignmentToolbar,
	withColors,
	PanelColorSettings,
	getColorClassName,
	BlockVerticalAlignmentToolbar,
	useBlockProps,
	__experimentalBlockVariationPicker as VariationPicker,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
} from '@wordpress/block-editor';

import { createBlocksFromInnerBlocksTemplate } from '@wordpress/blocks';

import { withSelect, useSelect } from '@wordpress/data';

import './edit.scss';

import {
	alignControls,
	blockHasParent,
	hasValue,
	parentType,
	uniqueClasses,
	updateClassesFromAtts,
} from '../global/helpers';

const BLOCK_TEMPLATE = [['core/paragraph', {}]];
const ALLOWED_BLOCKS = [
	'core/image',
	'core/list',
	'rwp/card-header',
	'rwp/card-body',
	'rwp/card-footer',
	'core/video',
	'core/gallery',
	'core/embed',
];
const TEMPLATE_LOCK = false;
const classNames = require('classnames/dedupe');

wp.hooks.addFilter(
	'blocks.getBlockDefaultClassName',
	'rwp/card',
	(className, blockName) => {
		if (blockName !== 'rwp/card') {
			return className;
		}

		className = classNames('rwp', 'rwp-card', 'card');

		return className;
	}
);

wp.hooks.addFilter(
	'editor.BlockListBlock',
	'rwp/card',
	createHigherOrderComponent((BlockListBlock) => {
		return (props) => {
			if (
				!blockHasParent(props.clientId) ||
				parentType(props) !== 'rwp/card'
			) {
				return <BlockListBlock {...props} />;
			}
			switch (props.name) {
				case 'core/image':
					props.attributes.className = classNames(
						props.attributes.className,
						'card-img'
					);
					break;
				case 'core/list':
					props.attributes.className = classNames(
						props.attributes.className,
						'list-group',
						'list-group-flush'
					);
					break;
			}
			return <BlockListBlock {...props} />;
		};
	})
);

function Edit(props) {
	const {
		attributes,
		setAttributes,
		clientId,
		isSelected,
		hasInnerBlocks,
		textColor,
		setTextColor,
		backgroundColor,
		setBackgroundColor,
		borderColor,
		setBorderColor,
		blockType,
		defaultVariation,
		variations,
		name,
	} = props;

	const { align, className, textAlignment } = attributes;

	let contentClasses = className;

	if (hasValue(textAlignment)) {
		contentClasses = updateClassesFromAtts(
			`text-${textAlignment}`,
			contentClasses,
			/text-[\d|\w]+/
		);
	} else {
		contentClasses = updateClassesFromAtts(
			'',
			contentClasses,
			/text-[\d|\w]+/
		);
	}

	const blockProps = useBlockProps({
		className: contentClasses,
	});
	const innerBlocksProps = useInnerBlocksProps(blockProps, {
		templateLock: TEMPLATE_LOCK,
		allowedBlocks: ALLOWED_BLOCKS,
		//orientation: 'horizontal',
		renderAppender: hasInnerBlocks
			? undefined
			: InnerBlocks.ButtonBlockAppender,
	});

	let content = (
		<>
			<BlockControls>
				<AlignmentToolbar
					value={textAlignment}
					onChange={(newalign) =>
						setAttributes({ textAlignment: newalign })
					}
				/>
			</BlockControls>
			<div {...innerBlocksProps} />
		</>
	);

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

	if (!hasInnerBlocks) {
		content = placeholder;
	}

	return content;
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
	}),
	withColors({
		textColor: 'color',
		backgroundColor: 'background-color',
		borderColor: 'border-color',
	})
)(Edit);
