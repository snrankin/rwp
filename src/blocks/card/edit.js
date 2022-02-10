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
import { get } from 'lodash';

import { Fragment } from '@wordpress/element';
import { compose, createHigherOrderComponent } from '@wordpress/compose';

// eslint-disable-next-line
import { BlockControls, AlignmentToolbar, withColors, useBlockProps, __experimentalBlockVariationPicker as VariationPicker, __experimentalUseInnerBlocksProps as useInnerBlocksProps } from '@wordpress/block-editor';

import { createBlocksFromInnerBlocksTemplate } from '@wordpress/blocks';

import { withSelect, useSelect } from '@wordpress/data';

import './edit.scss';

import { blockHasParent, hasValue, parentType, updateClassesFromAtts } from '../global/helpers';

const ALLOWED_BLOCKS = ['core/image', 'core/list', 'rwp/card-header', 'rwp/card-body', 'rwp/card-footer', 'core/video', 'core/gallery', 'core/embed'];
const TEMPLATE_LOCK = false;
const classNames = require('classnames/dedupe');

wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/card', (className, blockName) => {
	if (blockName !== 'rwp/card') {
		return className;
	}

	className = classNames('rwp', 'rwp-card', 'card');

	return className;
});

wp.hooks.addFilter(
	'editor.BlockListBlock',
	'rwp/card',
	createHigherOrderComponent((BlockListBlock) => {
		return (props) => {
			if (!blockHasParent(props.clientId) || parentType(props) !== 'rwp/card') {
				return <BlockListBlock {...props} />;
			}
			switch (props.name) {
				case 'core/image':
					props.attributes.className = classNames(props.attributes.className, 'card-img');
					break;
				case 'core/list':
					props.attributes.className = classNames(props.attributes.className, 'list-group', 'list-group-flush');
					break;
			}
			return <BlockListBlock {...props} />;
		};
	})
);

function Edit(props) {
	const { attributes, setAttributes, clientId, hasInnerBlocks, blockType, defaultVariation, variations } = props;

	const { className, textAlignment } = attributes;

	let contentClasses = className;

	if (hasValue(textAlignment)) {
		contentClasses = updateClassesFromAtts(`text-${textAlignment}`, contentClasses, /text-[\d|\w]+/);
	} else {
		contentClasses = updateClassesFromAtts('', contentClasses, /text-[\d|\w]+/);
	}

	const blockProps = useBlockProps({
		className: contentClasses,
	});
	const innerBlocksProps = useInnerBlocksProps(blockProps, {
		templateLock: TEMPLATE_LOCK,
		allowedBlocks: ALLOWED_BLOCKS,
		templateInsertUpdatesSelection: true,
	});

	let content = (
		<>
			<BlockControls>
				<AlignmentToolbar value={textAlignment} onChange={(newalign) => setAttributes({ textAlignment: newalign })} />
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
						wp.data.dispatch('core/block-editor').replaceInnerBlocks(clientId, createBlocksFromInnerBlocksTemplate(nextVariation.innerBlocks), true);
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
	}),
	withColors({
		textColor: 'color',
		backgroundColor: 'background-color',
		borderColor: 'border-color',
	})
)(Edit);
