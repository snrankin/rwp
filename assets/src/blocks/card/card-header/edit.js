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
	__experimentalBlockVariationPicker as VariationPicker,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
} from '@wordpress/block-editor';

import { withSelect, useSelect } from '@wordpress/data';

//import './edit.scss';

import {
	classNames,
	uniqueClasses,
	blockHasParent,
	parentType,
} from '../../global/helpers';

const BLOCK_TEMPLATE = [
	[
		'core/heading',
		{
			placeholder: 'Card Heading',
			level: 2,
			className: 'card-title',
		},
	],
];
const ALLOWED_BLOCKS = [
	'core/button',
	'core/buttons',
	'core/paragraph',
	'core/heading',
	'core/list',
	'rwp/icon',
];
const TEMPLATE_LOCK = false;

wp.hooks.addFilter(
	'blocks.getBlockDefaultClassName',
	'rwp/card-header',
	(className, blockName) => {
		if (blockName !== 'rwp/card-header') {
			return className;
		}

		className = classNames('rwp', 'card-header');

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
				parentType(props) !== 'rwp/card-body'
			) {
				return <BlockListBlock {...props} />;
			}
			let classes = props.attributes.className;
			switch (props.name) {
				case 'core/heading':
					classes = classNames(classes, 'card-title');
					props.attributes.className = classes;
					break;
				case 'rwp/icon':
					classes = classNames(classes, 'card-icon');
					props.attributes.className = classes;
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
		name,
	} = props;
	const { className } = attributes;

	const blockProps = useBlockProps();

	const innerBlocksProps = useInnerBlocksProps(blockProps, {
		templateLock: TEMPLATE_LOCK,
		allowedBlocks: ALLOWED_BLOCKS,
		renderAppender: hasInnerBlocks
			? undefined
			: InnerBlocks.ButtonBlockAppender,
	});

	return <div {...innerBlocksProps} />;
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
