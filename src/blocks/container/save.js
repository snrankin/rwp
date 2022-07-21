/**
 * ============================================================================
 * save
 *
 * @file
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';
import { classNames, uniqueClasses } from '../global/helpers';
export default function Save({ attributes }) {
	const classes = uniqueClasses(
		classNames(attributes.className, {
			'container-fluid': attributes.fluid,
			container: !attributes.fluid,
			'container-sm': attributes.fluidSm,
			'container-md': attributes.fluidMd,
			'container-lg': attributes.fluidLg,
			'container-xl': attributes.fluidXl,
			'container-xxl': attributes.fluidXXl,
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
