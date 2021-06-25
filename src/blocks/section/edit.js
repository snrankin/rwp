/**
 * ============================================================================
 * edit
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

import { __ } from '@wordpress/i18n';
import TokenList from '@wordpress/token-list';
import { get, omit, pick, isEmpty, isUndefined, isNil } from 'lodash';
const metadata = require('./block.json');
const styles = metadata.styles;
import {
	PanelBody,
	PanelRow,
	TextControl,
	Button,
	ResponsiveWrapper,
	Spinner,
	Icon,
	withNotices,
} from '@wordpress/components';
import {
	compose,
	createHigherOrderComponent,
	withState,
} from '@wordpress/compose';

import {
	InnerBlocks,
	InspectorControls,
	BlockControls,
	useBlockProps,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
	withColors,
	MediaPlaceholder,
	MediaUpload,
	MediaUploadCheck,
} from '@wordpress/block-editor';

import { useSelect, getSelectedBlock, withSelect } from '@wordpress/data';

import './edit.scss';

import {
	classNames,
	uniqueClasses,
	updateClassesFromAtts,
	hasBackgroundClass,
} from '../global/helpers';
import { RWPBGImage } from '../global/images';
const ALLOWED_MEDIA_TYPES = ['image'];
const BLOCK_TEMPLATE = [['rwp/container', {}, [['rwp/row', {}]]]];
const ALLOWED_BLOCKS = ['rwp/container'];

wp.hooks.addFilter(
	'blocks.getBlockDefaultClassName',
	'rwp/section',
	(className, blockName) => {
		if (blockName !== 'rwp/section') {
			return className;
		}

		className = classNames('rwp', 'section-wrapper');

		return className;
	}
);

function sectionEdit(props) {
	const {
		attributes,
		setAttributes,
		clientId,
		isSelected,
		hasInnerBlocks,
		blockType,
		defaultVariation,
		variations,
		name,
		backgroundColor,
		setBackgroundColor,
		type,
		media,
		bgImage,
	} = props;
	const {
		innerClasses,
		bgImageId,
		bgImageUrl,
		bgImageWidth,
		bgImageHeight,
		className,
	} = attributes;

	const innerBlocksProps = useInnerBlocksProps(
		{
			className: classNames('section-inner', innerClasses),
		},
		{
			templateLock: false,
			allowedBlocks: ALLOWED_BLOCKS,
			template: BLOCK_TEMPLATE,
			renderAppender: hasInnerBlocks
				? undefined
				: InnerBlocks.ButtonBlockAppender,
		}
	);

	let classes = classNames(className);
	classes = hasBackgroundClass(bgImageId, backgroundColor, className);

	const bgImageObj = useSelect(
		(select) => {
			return select('core').getMedia(bgImageId);
		},
		[bgImageId]
	);

	const removeMedia = () => {
		props.setAttributes({
			mediaId: 0,
			mediaUrl: '',
		});
	};

	const onSelectMedia = (media) => {
		props.setAttributes({
			mediaId: media.id,
			mediaUrl: media.url,
		});
	};

	const blockProps = useBlockProps({
		className: classes,
		style: {
			backgroundImage:
				attributes.mediaUrl != ''
					? 'url("' + attributes.mediaUrl + '")'
					: 'none',
		},
	});

	console.log(bgImageObj);

	return (
		<div {...blockProps}>
			<InspectorControls>
				<PanelBody
					title={__('Section Settings', 'rwp')}
					initialOpen={true}
				>
					<PanelRow>
						<div className="editor-post-featured-image">
							<MediaUploadCheck>
								<MediaUpload
									onSelect={onSelectMedia}
									value={attributes.mediaId}
									allowedTypes={['image']}
									render={({ open }) => (
										<Button
											className={
												attributes.mediaId == 0
													? 'editor-post-featured-image__toggle'
													: 'editor-post-featured-image__preview'
											}
											onClick={open}
										>
											{attributes.mediaId == 0 &&
												__('Choose an image', 'awp')}
											{props.media != undefined && (
												<ResponsiveWrapper
													naturalWidth={
														props.media
															.media_details.width
													}
													naturalHeight={
														props.media
															.media_details
															.height
													}
												>
													<img
														src={
															props.media
																.source_url
														}
													/>
												</ResponsiveWrapper>
											)}
										</Button>
									)}
								/>
							</MediaUploadCheck>
							{attributes.mediaId != 0 && (
								<MediaUploadCheck>
									<MediaUpload
										title={__('Replace image', 'awp')}
										value={attributes.mediaId}
										onSelect={onSelectMedia}
										allowedTypes={['image']}
										render={({ open }) => (
											<Button onClick={open} isDefault>
												{__('Replace image', 'awp')}
											</Button>
										)}
									/>
								</MediaUploadCheck>
							)}
							{attributes.mediaId != 0 && (
								<MediaUploadCheck>
									<Button
										onClick={removeMedia}
										isLink
										isDestructive
									>
										{__('Remove image', 'awp')}
									</Button>
								</MediaUploadCheck>
							)}
						</div>
					</PanelRow>
					<PanelRow>
						<TextControl
							label={__('Inner Classes', 'rwp')}
							value={innerClasses}
							onChange={(val) =>
								setAttributes({ innerClasses: val })
							}
						/>
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			<div {...innerBlocksProps} />
		</div>
	);
}

export default compose(
	withSelect((select, ownProps) => {
		const { clientId, name, setAttributes } = ownProps;
		const { getBlockOrder, getBlock } =
			select('core/block-editor') || select('core/editor');
		const { getBlockVariations, getBlockType, getDefaultBlockVariation } =
			select('core/blocks');
		const { bgImageId } = ownProps.attributes;

		const block = getBlock(clientId);

		const hasInnerBlocks = useSelect(
			(select) => {
				return !!(block && block.innerBlocks.length);
			},
			[block]
		);

		const bgImage = useSelect(
			(select) => {
				return select('core').getMedia(bgImageId);
			},
			[bgImageId]
		);

		return {
			blockType: getBlockType(name),
			bgImage,
			media: ownProps.attributes.mediaId
				? select('core').getMedia(ownProps.attributes.mediaId)
				: undefined,
			defaultVariation: getDefaultBlockVariation(name, 'block'),
			variations: getBlockVariations(name, 'block'),
			hasInnerBlocks,
		};
	}),
	withColors({
		backgroundColor: 'background-color',
	})
)(sectionEdit);
