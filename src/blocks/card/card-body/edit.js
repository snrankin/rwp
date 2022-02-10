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

import { createHigherOrderComponent, compose } from '@wordpress/compose';

// eslint-disable-next-line
import { InnerBlocks, useBlockProps, __experimentalUseInnerBlocksProps as useInnerBlocksProps } from '@wordpress/block-editor';

import { withSelect, useSelect } from '@wordpress/data';

import { classNames, blockHasParent, parentType } from '../../global/helpers';

const ALLOWED_BLOCKS = ['core/button', 'core/buttons', 'core/heading', 'core/paragraph', 'core/list', 'core/quote', 'rwp/icon', 'gravityforms/form'];
const TEMPLATE_LOCK = false;

wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/card-body', (className, blockName) => {
	if (blockName !== 'rwp/card-body') {
		return className;
	}

	className = classNames('rwp', 'card-body');

	return className;
});

wp.hooks.addFilter(
	'editor.BlockListBlock',
	'rwp/card',
	createHigherOrderComponent((BlockListBlock) => {
		return (props) => {
			if (!blockHasParent(props.clientId) || parentType(props) !== 'rwp/card-body') {
				return <BlockListBlock {...props} />;
			}
			let classes = props.attributes.className;
			switch (props.name) {
				case 'core/paragraph':
					classes = classNames(classes, 'card-text');
					props.attributes.className = classes;
					break;
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
	const { hasInnerBlocks } = props;

	const blockProps = useBlockProps();
	const innerBlocksProps = useInnerBlocksProps(blockProps, {
		templateLock: TEMPLATE_LOCK,
		allowedBlocks: ALLOWED_BLOCKS,
		renderAppender: hasInnerBlocks ? undefined : InnerBlocks.ButtonBlockAppender,
	});

	return (
		<>
			<div {...innerBlocksProps} />
		</>
	);
}
export default compose(
	withSelect((select, ownProps) => {
		const { clientId, name } = ownProps;

		const hasInnerBlocks = useSelect(() => {
			const { getBlock } = select('core/block-editor');
			const block = getBlock(clientId);
			return !!(block && block.innerBlocks.length);
		}, [clientId]);

		const { getBlockVariations, getBlockType, getDefaultBlockVariation } = select('core/blocks');

		return {
			clientId,
			blockType: getBlockType(name),
			defaultVariation: getDefaultBlockVariation(name, 'block'),
			variations: getBlockVariations(name, 'block'),
			hasInnerBlocks,
		};
	})
)(Edit);
