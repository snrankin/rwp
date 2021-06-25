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
import { __ } from '@wordpress/i18n';

import {
	withColors,
	InspectorControls,
	BlockControls,
	useBlockProps,
} from '@wordpress/block-editor';
import {
	Toolbar,
	ToolbarItem,
	DropdownMenu,
	AlignmentToolbar,
	Icon,
	SVG,
	Path,
	PanelBody,
	PanelRow,
	Panel,
	TextControl,
} from '@wordpress/components';

import { withSelect, useSelect } from '@wordpress/data';

import { favicon, glazaIcons } from './glaza-icons';

import { classNames, hasValue } from '../global/helpers';

import './edit.scss';

wp.hooks.addFilter(
	'blocks.getBlockDefaultClassName',
	'rwp/icon',
	(className, blockName) => {
		if (blockName !== 'rwp/icon') {
			return className;
		}

		className = classNames('rwp', 'rwp-icon');

		return className;
	}
);

function Edit(props) {
	const { attributes, setAttributes, clientId, isSelected, name } = props;
	const { className, iconClass, alignment } = attributes;

	const blockProps = useBlockProps();

	const icon = classNames('glaza', iconClass);

	return (
		<div {...blockProps}>
			<BlockControls>
				<ToolbarItem>
					{(toolbarItemHTMLProps) => (
						<DropdownMenu
							icon={favicon}
							toggleProps={toolbarItemHTMLProps}
							label={'Choose Icon'}
							controls={glazaIcons(setAttributes)}
						/>
					)}
				</ToolbarItem>
			</BlockControls>
			<InspectorControls></InspectorControls>
			<i className={icon} aria-hidden="true" role="presentation" />
		</div>
	);
}
export default compose(
	withSelect((select, props) => {
		const { clientId, name, setAttributes } = props;
		return {
			clientId,
		};
	})
)(Edit);
