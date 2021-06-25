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
const _ = require('lodash');
import { __ } from '@wordpress/i18n';

import {
	PanelBody,
	PanelRow,
	TextControl,
	ToggleControl,
	ButtonGroup,
	Button,
	SelectControl,
	Icon,
	Flex,
	FlexBlock,
	FlexItem,
} from '@wordpress/components';
import {
	compose,
	withState,
	createHigherOrderComponent,
} from '@wordpress/compose';

import {
	InnerBlocks,
	InspectorControls,
	useBlockProps,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
} from '@wordpress/block-editor';

import { withSelect, useSelect } from '@wordpress/data';

//import './edit.scss';

import {
	classNames,
	hasValue,
	buttonOptions,
	blockHasParent,
	parentType,
	parentAtts,
} from '../../global/helpers';

const BLOCK_TEMPLATE = [
	[
		'core/paragraph',
		{
			placeholder: 'Toggle Bar Content',
		},
	],
];
const ALLOWED_BLOCKS = [];
const TEMPLATE_LOCK = false;

wp.hooks.addFilter(
	'blocks.getBlockDefaultClassName',
	'rwp/toggle-bar',
	(className, blockName) => {
		if (blockName !== 'rwp/toggle-bar') {
			return className;
		}

		className = classNames('rwp', 'rwp-toggle-bar');

		return className;
	}
);

export function createToggleButtonAtts(attributes) {
	const {
		iconPosition,
		buttonStyle,
		openedIcon,
		closedIcon,
		toggleBarIsOpen,
		toggleBarId,
		className,
	} = attributes;

	const classes = classNames(
		'btn',
		'btn-toggle',
		buttonStyle,
		`btn-toggle-${iconPosition}`
	);

	return {
		className: classes,
		type: 'button',
		'data-toggle': 'collapse',
		'aria-expanded': toggleBarIsOpen,
		id: `${toggleBarId}-header`,
		'aria-controls': `${toggleBarId}-body`,
		'data-target': `#${toggleBarId}-body`,
	};
}

function toggleBarEdit(props) {
	const {
		attributes,
		setAttributes,
		clientId,
		isSelected,
		hasInnerBlocks,
		name,
		context,
	} = props;
	const {
		className,
		toggleBarIsOpen,
		toggleBarId,
		iconPosition,
		buttonStyle,
		openedIcon,
		closedIcon,
	} = attributes;

	const isOpen = context['rwp-toggle/isOpen'];
	const toggleId = context['rwp-toggle/toggleId'];

	if (!_.isNil(toggleId)) {
		setAttributes({
			toggleBarId: toggleId,
		});
	}

	if (!_.isNil(isOpen)) {
		setAttributes({
			toggleBarIsOpen: isOpen,
		});
	}

	const blockProps = useBlockProps();

	const btnProps = createToggleButtonAtts(attributes);
	return (
		<Flex {...blockProps}>
			<InspectorControls>
				<PanelBody
					title={__('Toggle Bar Settings', 'rwp')}
					initialOpen={true}
				>
					<PanelRow>
						<SelectControl
							label={__('Button Style')}
							value={buttonStyle}
							onChange={(val) => {
								setAttributes({ buttonStyle: val });
							}}
							options={buttonOptions}
						/>
					</PanelRow>
					<PanelRow>
						<label>{__('Icon Position', 'rwp')}</label>
						<ButtonGroup label={__('Icon Position', 'rwp')}>
							<Button
								value={'left'}
								isPrimary={iconPosition === 'left'}
								isSecondary={iconPosition !== 'left'}
								onClick={(val) =>
									setAttributes({
										iconPosition: 'left',
									})
								}
							>
								{__('Left', 'rwp')}
							</Button>
							<Button
								value={'right'}
								isPrimary={iconPosition === 'right'}
								isSecondary={iconPosition !== 'right'}
								onClick={(val) =>
									setAttributes({
										iconPosition: 'right',
									})
								}
							>
								{__('Right', 'rwp')}
							</Button>
						</ButtonGroup>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={__('Opened Icon Classes', 'rwp')}
							value={openedIcon}
							onChange={(val) =>
								setAttributes({ openedIcon: val })
							}
						/>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={__('Closed Icon Classes', 'rwp')}
							value={closedIcon}
							onChange={(val) =>
								setAttributes({ closedIcon: val })
							}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>

			{iconPosition === 'left' ? (
				<>
					<FlexItem>
						<Button {...btnProps}>
							<span className="btn-icon">
								<Icon
									icon={closedIcon}
									className={classNames(
										'btn-icon-closed',
										closedIcon
									)}
									aria-hidden="true"
									role="presentation"
								/>
								<Icon
									icon={openedIcon}
									className={classNames(
										'btn-icon-opened',
										openedIcon
									)}
									aria-hidden="true"
									role="presentation"
								/>
							</span>
						</Button>
					</FlexItem>
					<FlexBlock>
						<InnerBlocks
							template={BLOCK_TEMPLATE}
							orientation="horizontal"
							templateLock={TEMPLATE_LOCK}
						/>
					</FlexBlock>
				</>
			) : (
				<>
					<FlexBlock>
						<InnerBlocks
							template={BLOCK_TEMPLATE}
							templateLock={TEMPLATE_LOCK}
							orientation="horizontal"
						/>
					</FlexBlock>
					<FlexItem>
						<Button {...btnProps}>
							<span className="btn-icon">
								<Icon
									icon={closedIcon}
									className={classNames(
										'btn-icon-closed',
										closedIcon
									)}
									aria-hidden="true"
									role="presentation"
								/>
								<Icon
									icon={openedIcon}
									className={classNames(
										'btn-icon-opened',
										openedIcon
									)}
									aria-hidden="true"
									role="presentation"
								/>
							</span>
						</Button>
					</FlexItem>
				</>
			)}
		</Flex>
	);
}
export default toggleBarEdit;
