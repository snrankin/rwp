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

import { __ } from '@wordpress/i18n';

import { PanelBody, PanelRow, ToggleControl } from '@wordpress/components';
import {
	compose,
	createHigherOrderComponent,
	withState,
} from '@wordpress/compose';

import {
	InnerBlocks,
	InspectorControls,
	BlockControls,
	useBlockProps,
	__experimentalBlockVariationPicker as VariationPicker,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
} from '@wordpress/block-editor';

import { useSelect, withSelect } from '@wordpress/data';

import { classNames, uniqueClasses } from '../global/helpers';

const BLOCK_TEMPLATE = [['rwp/row', {}]];

wp.hooks.addFilter(
	'blocks.getBlockDefaultClassName',
	'rwp/container',
	(className, blockName) => {
		if (blockName !== 'rwp/container') {
			return className;
		}

		className = classNames('rwp', 'rwp-container');

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
		fluid,
		fluidXl,
		fluidLg,
		fluidMl,
		fluidMd,
		fluidMs,
		fluidSm,
		className,
	} = attributes;

	const classes = uniqueClasses(
		classNames(className, {
			'container-fluid': fluid,
			container: !fluid,
			'container-sm': fluidSm,
			'container-ms': fluidMs,
			'container-md': fluidMd,
			'container-ml': fluidMl,
			'container-lg': fluidLg,
			'container-xl': fluidXl,
		})
	);

	const blockProps = useBlockProps({
		className: classes,
	});

	const innerBlocksProps = useInnerBlocksProps(blockProps, {
		template: BLOCK_TEMPLATE,
		renderAppender: hasInnerBlocks
			? undefined
			: InnerBlocks.ButtonBlockAppender,
	});

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={__('Container Settings', 'rwp')}
					initialOpen={true}
				>
					<PanelRow>
						<ToggleControl
							label={__('Is Fluid', 'rwp')}
							checked={fluid}
							onChange={(isChecked) =>
								setAttributes({ fluid: isChecked })
							}
						/>
					</PanelRow>
					<PanelRow>
						<ToggleControl
							label={__('Fluid until SM', 'rwp')}
							checked={fluidSm}
							onChange={(isChecked) =>
								setAttributes({ fluidSm: isChecked })
							}
						/>
					</PanelRow>
					<PanelRow>
						<ToggleControl
							label={__('Fluid until MS', 'rwp')}
							checked={fluidMs}
							onChange={(isChecked) =>
								setAttributes({ fluidMs: isChecked })
							}
						/>
					</PanelRow>
					<PanelRow>
						<ToggleControl
							label={__('Fluid until MD', 'rwp')}
							checked={fluidMd}
							onChange={(isChecked) =>
								setAttributes({ fluidMd: isChecked })
							}
						/>
					</PanelRow>
					<PanelRow>
						<ToggleControl
							label={__('Fluid until ML', 'rwp')}
							checked={fluidMl}
							onChange={(isChecked) =>
								setAttributes({ fluidMl: isChecked })
							}
						/>
					</PanelRow>
					<PanelRow>
						<ToggleControl
							label={__('Fluid until LG', 'rwp')}
							checked={fluidLg}
							onChange={(isChecked) =>
								setAttributes({ fluidLg: isChecked })
							}
						/>
					</PanelRow>
					<PanelRow>
						<ToggleControl
							label={__('Fluid until XL', 'rwp')}
							checked={fluidXl}
							onChange={(isChecked) =>
								setAttributes({ fluidXl: isChecked })
							}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			<div {...innerBlocksProps} />
		</>
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
