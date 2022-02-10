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

/**
 * External dependencies
 */
import classnames from 'classnames';

import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

import { hasBackgroundClass } from '../global/helpers';

export default function Save({ attributes }) {
	const classes = hasBackgroundClass(attributes.bgImageId, attributes.backgroundColor, attributes.className);
	const blockProps = useBlockProps.save({
		className: classes,
	});

	const innerBlocksProps = {
		className: classnames('section-inner', attributes.innerClasses),
	};
	return (
		<section {...blockProps}>
			<div {...innerBlocksProps}>
				<InnerBlocks.Content />
			</div>
		</section>
	);
}
