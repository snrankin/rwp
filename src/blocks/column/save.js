/**
 * ============================================================================
 * save
 *
 * @file
 * @package
 * @since     <<projectversion>>
 * @version   <<projectversion>>
 * @author    Sam Rankin <you@you.you>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

import {
	InnerBlocks,
	useBlockProps,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
} from '@wordpress/block-editor';

import { colWidths } from './edit';

import { classNames, selfAlignClass, hasValue } from '../global/helpers';

export default function Save({ attributes }) {
	const alignClass = selfAlignClass(attributes.align);

	const colClasses = colWidths(attributes);

	const blockProps = useBlockProps.save({
		className: classNames(attributes.className, colClasses, alignClass),
	});

	const innerBlocksProps = {
		className: classNames('content-wrapper', {
			[`${attributes.innerClasses}`]: hasValue(attributes.innerClasses),
			[`${attributes.vAlign}`]: hasValue(attributes.vAlign),
			[`${attributes.hAlign}`]: hasValue(attributes.hAlign),
		}),
	};

	return (
		<div {...blockProps}>
			<div {...innerBlocksProps}>
				<InnerBlocks.Content />
			</div>
		</div>
	);
}
