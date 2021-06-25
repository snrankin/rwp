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
import {
	classNames,
	uniqueClasses,
	updateClassesFromAtts,
} from '../global/helpers';

import { rowClasses } from './edit';

export default function Save({ attributes }) {
	return (
		<div
			{...useBlockProps.save({
				className: rowClasses(attributes),
			})}
		>
			<InnerBlocks.Content />
		</div>
	);
}
