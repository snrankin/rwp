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

import {
	classNames,
	uniqueClasses,
	updateClassesFromAtts,
	hasBackgroundClass,
} from '../global/helpers';

export default function Save({ attributes }) {
	const classes = hasBackgroundClass(
		attributes.bgImageId,
		attributes.backgroundColor,
		attributes.className
	);
	const blockProps = useBlockProps.save({
		className: classes,
	});

	const innerBlocksProps = {
		className: uniqueClasses(
			classNames('section-inner', attributes.innerClasses)
		),
	};
	return (
		<section {...blockProps}>
			<div {...innerBlocksProps}>
				<InnerBlocks.Content />
			</div>
		</section>
	);
}
