/**
 * ============================================================================
 * save
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import {
	classNames,
	uniqueClasses,
	updateClassesFromAtts,
} from '../global/helpers';
export default function Save({ attributes }) {
	const classes = uniqueClasses(
		classNames(attributes.className, {
			'container-fluid': attributes.fluid,
			container: !attributes.fluid,
			'container-sm': attributes.fluidSm,
			'container-ms': attributes.fluidMs,
			'container-md': attributes.fluidMd,
			'container-ml': attributes.fluidMl,
			'container-lg': attributes.fluidLg,
			'container-xl': attributes.fluidXl,
		})
	);
	return (
		<div
			{...useBlockProps.save({
				className: classes,
			})}
		>
			<InnerBlocks.Content />
		</div>
	);
}
