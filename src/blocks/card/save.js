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

import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { uniqueClasses, updateClassesFromAtts } from '../global/helpers';
const classNames = require('classnames/dedupe');
export default function Save(props) {
	let contentClasses = classNames('card', props.attributes.className);

	contentClasses = updateClassesFromAtts(`text-${props.attributes.textAlignment}`, contentClasses, /text-[\d|\w]+/);
	return (
		<div
			{...useBlockProps.save({
				className: contentClasses,
			})}
		>
			<InnerBlocks.Content />
		</div>
	);
}
