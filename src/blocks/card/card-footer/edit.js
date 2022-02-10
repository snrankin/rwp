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

import { compose } from '@wordpress/compose';

import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

import { withSelect, useSelect } from '@wordpress/data';

//import './edit.scss';

import { classNames, uniqueClasses } from '../../global/helpers';

const BLOCK_TEMPLATE = [
	[
		[
			'core/buttons',
			{},
			[
				['core/button', { content: 'Button 1' }],
				['core/button', { content: 'Button 2' }],
			],
		],
	],
];
const ALLOWED_BLOCKS = ['core/button', 'core/buttons', 'core/paragraph', 'core/list', 'rwp/icon'];
const TEMPLATE_LOCK = false;

wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/card-footer', (className, blockName) => {
	if (blockName !== 'rwp/card-footer') {
		return className;
	}

	className = classNames('rwp', 'card-footer');

	return className;
});

function Edit(props) {
	const { attributes, hasInnerBlocks } = props;
	const { className } = attributes;

	const blockProps = useBlockProps();

	blockProps.className = uniqueClasses(classNames(blockProps.className, className));

	return (
		<div {...blockProps}>
			<InnerBlocks templateLock={TEMPLATE_LOCK} allowedBlocks={ALLOWED_BLOCKS} template={BLOCK_TEMPLATE} renderAppender={hasInnerBlocks ? undefined : InnerBlocks.ButtonBlockAppender} />
		</div>
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
