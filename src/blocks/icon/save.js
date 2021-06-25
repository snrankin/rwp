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

import { useBlockProps } from '@wordpress/block-editor';

import { classNames, hasValue } from '../global/helpers';
export default function Save({ attributes, className }) {
	const iconClass = attributes.iconClass;
	return (
		<i
			aria-hidden="true"
			role="presentation"
			{...useBlockProps.save({
				className: classNames('glaza', iconClass),
			})}
		/>
	);
}
