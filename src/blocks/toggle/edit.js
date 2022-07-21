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
import domReady from '@wordpress/dom-ready';
const _ = require('lodash');
import { __ } from '@wordpress/i18n';
import { PanelBody, PanelRow, ToggleControl, TextControl } from '@wordpress/components';
import { compose, createHigherOrderComponent, withState } from '@wordpress/compose';

import { InnerBlocks, InspectorControls, useBlockProps, withColors, textControl, __experimentalUseInnerBlocksProps as useInnerBlocksProps } from '@wordpress/block-editor';

import { withSelect, useSelect } from '@wordpress/data';

//import './edit.scss';

import { classNames, hasValue, buttonOptions, updateClassesFromAtts, uniqueClasses, blockHasParent, parentType, parentAtts } from '../global/helpers';

const BLOCK_TEMPLATE = [
	['rwp/toggle-bar', {}],
	['rwp/toggle-body', {}],
];
const ALLOWED_BLOCKS = ['rwp/toggle-bar', 'rwp/toggle-body'];
const TEMPLATE_LOCK = 'all';

wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/toggle', (className, blockName) => {
	if (blockName !== 'rwp/toggle') {
		return className;
	}

	className = classNames('rwp', 'rwp-toggle');

	return className;
});

function toggleEdit(props) {
	const { attributes, setAttributes, clientId } = props;
	const { className, isOpen, toggleId } = attributes;

	const blockProps = useBlockProps();

	const newId = 'rwp-toggle-' + clientId.replace(/(-\w*)/g, '');

	if (_.isNil(toggleId) || _.isEmpty(toggleId)) {
		setAttributes({
			toggleId: newId,
		});
	}

	return (
		<div {...blockProps}>
			<InspectorControls>
				<PanelBody title={__('Toggle Settings', 'rwp')} initialOpen={true}>
					<PanelRow>
						<ToggleControl
							label={__('Is toggle body initially opened?', 'rwp')}
							checked={isOpen}
							onChange={(val) =>
								setAttributes({
									isOpen: val,
								})
							}
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={__('Toggle ID', 'rwp')}
							value={toggleId}
							onChange={(val) =>
								setAttributes({
									toggleId: val,
								})
							}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			<InnerBlocks template={BLOCK_TEMPLATE} templateLock={TEMPLATE_LOCK} allowedBlocks={ALLOWED_BLOCKS} />
		</div>
	);
}

export default toggleEdit;
