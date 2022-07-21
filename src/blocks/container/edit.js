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

import { PanelBody, PanelRow, ToggleControl } from '@wordpress/components';
import { compose } from '@wordpress/compose';

// eslint-disable-next-line
import { InnerBlocks, InspectorControls, useBlockProps, __experimentalBlockVariationPicker as VariationPicker, __experimentalUseInnerBlocksProps as useInnerBlocksProps } from '@wordpress/block-editor';

import { useSelect, withSelect } from '@wordpress/data';

import { classNames, uniqueClasses } from '../global/helpers';

const BLOCK_TEMPLATE = [['rwp/row', {}]];

wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/container', (className, blockName) => {
	if (blockName !== 'rwp/container') {
		return className;
	}

	className = classNames('rwp', 'rwp-container');

	return className;
});

function Edit(props) {
	const { attributes, setAttributes, hasInnerBlocks } = props;
	const { fluid, fluidXXl, fluidXl, fluidLg, fluidMd, fluidSm, className } = attributes;

	const classes = uniqueClasses(
		classNames(className, {
			'container-fluid': fluid,
			container: !fluid,
			'container-sm': fluidSm,
			'container-md': fluidMd,
			'container-lg': fluidLg,
			'container-xl': fluidXl,
			'container-xxl': fluidXXl,
		})
	);

	const blockProps = useBlockProps({
		className: classes,
	});

	const innerBlocksProps = useInnerBlocksProps(blockProps, {
		template: BLOCK_TEMPLATE,
		renderAppender: hasInnerBlocks ? undefined : InnerBlocks.ButtonBlockAppender,
	});

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Container Settings', 'rwp')} initialOpen={true}>
					<PanelRow>
						<ToggleControl label={__('Is Fluid', 'rwp')} checked={fluid} onChange={(isChecked) => setAttributes({ fluid: isChecked })} />
					</PanelRow>
					<PanelRow>
						<ToggleControl label={__('Fluid until SM', 'rwp')} checked={fluidSm} onChange={(isChecked) => setAttributes({ fluidSm: isChecked })} />
					</PanelRow>
					<PanelRow>
						<ToggleControl label={__('Fluid until MD', 'rwp')} checked={fluidMd} onChange={(isChecked) => setAttributes({ fluidMd: isChecked })} />
					</PanelRow>
					<PanelRow>
						<ToggleControl label={__('Fluid until LG', 'rwp')} checked={fluidLg} onChange={(isChecked) => setAttributes({ fluidLg: isChecked })} />
					</PanelRow>
					<PanelRow>
						<ToggleControl label={__('Fluid until XL', 'rwp')} checked={fluidXl} onChange={(isChecked) => setAttributes({ fluidXl: isChecked })} />
					</PanelRow>
					<PanelRow>
						<ToggleControl label={__('Fluid until XXL', 'rwp')} checked={fluidXXl} onChange={(isChecked) => setAttributes({ fluidXXl: isChecked })} />
					</PanelRow>
				</PanelBody>
			</InspectorControls>

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
