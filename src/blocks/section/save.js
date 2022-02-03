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

import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { classNames, uniqueClasses } from '../global/helpers';

export default function Save({ attributes }) {
	const { innerClasses, className } = attributes;
	const classes = uniqueClasses(classNames('section-wrapper', className));
	const blockProps = useBlockProps.save({
		className: classes,
	});

	const innerBlocksProps = {
		className: uniqueClasses(classNames('section-inner', innerClasses)),
	};

	return (
		<section {...blockProps}>
			<div {...innerBlocksProps}>
				<InnerBlocks.Content />
			</div>
		</section>
	);
}
