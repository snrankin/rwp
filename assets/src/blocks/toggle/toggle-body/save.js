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
import { classNames, hasValue, parentAtts } from '../../global/helpers';
export default function Save(props) {
	const { attributes } = props;
	let classes = classNames('collapse', attributes.className);

	const { toggleBodyIsOpen, toggleBodyId } = attributes;

	if (!_.isUndefined(toggleBodyIsOpen)) {
		if (!toggleBodyIsOpen) {
			if (classes.match('show')) {
				classes = classes.replace('show', '');
			}
		} else {
			classes = classNames('show', classes);
		}
	}
	const blockProps = useBlockProps.save({
		className: classes,
		id: `${attributes.toggleBodyId}-body`,
		'aria-labelledby': `${attributes.toggleBodyId}-header`,
	});

	return (
		<div {...blockProps}>
			<InnerBlocks.Content />
		</div>
	);
}
