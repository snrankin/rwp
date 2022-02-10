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
const _ = require('lodash');
import { __ } from '@wordpress/i18n';
import { PanelBody, PanelRow } from '@wordpress/components';
import {
	compose,
	withState,
	createHigherOrderComponent,
} from '@wordpress/compose';

import {
	InnerBlocks,
	InspectorControls,
	BlockControls,
	useBlockProps,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
} from '@wordpress/block-editor';

import { withSelect, useSelect } from '@wordpress/data';

//import './edit.scss';

import {
	classNames,
	uniqueClasses,
	blockHasParent,
	parentType,
	parentAtts,
	hasValue,
	updateClassesFromAtts,
} from '../../global/helpers';

const BLOCK_TEMPLATE = [
	[
		'core/paragraph',
		{
			placeholder: 'Toggle Body Content',
		},
	],
];
const ALLOWED_BLOCKS = [];
const TEMPLATE_LOCK = false;

wp.hooks.addFilter(
	'blocks.getBlockDefaultClassName',
	'rwp/toggle-body',
	(className, blockName) => {
		if (blockName !== 'rwp/toggle-body') {
			return className;
		}

		className = classNames('rwp', 'rwp-toggle-body');

		return className;
	}
);

function toggleBodyEdit(props) {
	const {
		attributes,
		setAttributes,
		clientId,
		isSelected,
		hasInnerBlocks,
		name,
		context,
	} = props;
	const { className, toggleBodyIsOpen, toggleBodyId } = attributes;

	const isOpen = context['rwp-toggle/isOpen'];
	const toggleId = context['rwp-toggle/toggleId'];

	let classes = classNames('', className);

	if (!_.isNil(toggleId)) {
		setAttributes({
			toggleBodyId: toggleId,
		});
	}

	if (!_.isNil(isOpen)) {
		setAttributes({
			toggleBodyIsOpen: isOpen,
		});
	}
	if (!toggleBodyIsOpen) {
		if (classes.match('show')) {
			classes = classes.replace('show', '');
		}
	} else {
		classes = classNames('show', classes);
	}

	const blockProps = useBlockProps({
		className: classes,
	});

	return (
		<div {...blockProps}>
			<InnerBlocks
				template={BLOCK_TEMPLATE}
				templateLock={TEMPLATE_LOCK}
			/>
		</div>
	);
}
export default toggleBodyEdit;
