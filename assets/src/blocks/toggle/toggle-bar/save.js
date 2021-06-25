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
import { createToggleButtonAtts } from './edit';
import { classNames, hasValue } from '../../global/helpers';
export default function Save({ attributes }) {
	const blockProps = useBlockProps.save();
	const btnProps = createToggleButtonAtts(attributes);

	return (
		<div {...blockProps}>
			{attributes.iconPosition === 'left' ? (
				<>
					<button {...btnProps}>
						<span className="btn-icon">
							<i
								className={classNames(
									'btn-icon-closed',
									attributes.closedIcon
								)}
								aria-hidden="true"
								role="presentation"
							/>
							<i
								className={classNames(
									'btn-icon-opened',
									attributes.openedIcon
								)}
								aria-hidden="true"
								role="presentation"
							/>
						</span>
					</button>
					<div className="toggle-bar-content">
						<InnerBlocks.Content />
					</div>
				</>
			) : (
				<>
					<div className="toggle-bar-content">
						<InnerBlocks.Content />
					</div>
					<button {...btnProps}>
						<span className="btn-icon">
							<i
								className={classNames(
									'btn-icon-closed',
									attributes.closedIcon
								)}
								aria-hidden="true"
								role="presentation"
							/>
							<i
								className={classNames(
									'btn-icon-opened',
									attributes.openedIcon
								)}
								aria-hidden="true"
								role="presentation"
							/>
						</span>
					</button>
				</>
			)}
		</div>
	);
}
