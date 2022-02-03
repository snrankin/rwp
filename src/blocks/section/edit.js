/**
 * ============================================================================
 * edit
 *
 * @file
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

/* WordPress Dependencies */

import { __ } from '@wordpress/i18n';
import { compose } from '@wordpress/compose';
import { PanelBody, PanelRow, TextControl, Button, ResponsiveWrapper, Spinner } from '@wordpress/components';
import { InnerBlocks, InspectorControls, useBlockProps, MediaUpload, withColors, MediaUploadCheck } from '@wordpress/block-editor';
import { useSelect, withSelect } from '@wordpress/data';

/* Other External Dependencies */

import { isNil } from 'lodash';

/* Internal Dependencies */

import { classNames, hasBackgroundClass } from '../global/helpers';
import './edit.scss';

/* Block Constants */

const ALLOWED_MEDIA_TYPES = ['image'];

/* Block Filters */

wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/section', (className, blockName) => {
	if (blockName !== 'rwp/section') {
		return className;
	}

	className = classNames('rwp', 'section-wrapper');

	return className;
});

/* Compose Function */

function sectionEdit(props) {
	const { attributes, setAttributes, backgroundColor } = props;
	const { innerClasses, bgImageId, bgImage, className, videoUrl } = attributes;

	let classes = classNames(className);
	classes = hasBackgroundClass(bgImageId, backgroundColor, className);

	const onRemoveMedia = () => {
		props.setAttributes({
			bgImage: null,
			bgImageId: 0,
			bgImageUrl: '',
		});
	};

	const onSelectMedia = (media) => {
		props.setAttributes({
			bgImage: media,
			bgImageId: media.id,
			bgImageUrl: media.url,
		});
	};

	const onVideoInput = (val) => {
		let vidID = ''; // eslint-disable-line
		let host = ''; // eslint-disable-line
		if (!isNil(val)) {
			const videoIdRE = new RegExp(/(?:\.(?:net|com|org)\/(?:[^/]+\/.+\/|(?:v(?:ideo)?|e(?:mbed)?|media(?:s)?)\/|.*[?&]v=)|youtu\.be\/)(?<videoID>[^."&?/\s\n\r\t\0]{9,11})/);
			const videoMatches = val.match(videoIdRE);
			if (!isNil(videoMatches[1])) {
				vidID = videoMatches[1];
			}
			const videoHostRE = new RegExp(/(youtu(.?be)?|vimeo|wistia|wi\.st)/);
			const hostMatches = val.match(videoHostRE);
			if (!isNil(hostMatches[0])) {
				host = hostMatches[0];
				if (host === 'youtu.be') {
					host = 'youtube';
				}
			}
		}

		props.setAttributes({
			videoUrl: val,
			videoHost: host,
			videoId: vidID,
		});
	};

	// eslint-disable-next-line
	const blockProps = useBlockProps({
		className: classes,
	});

	return (
		<div {...blockProps}>
			<InspectorControls>
				<PanelBody title={__('Section Settings', 'rwp')} initialOpen={true}>
					<PanelRow>
						<div className="editor-post-featured-image">
							<MediaUploadCheck>
								<MediaUpload
									onSelect={onSelectMedia}
									value={bgImageId}
									allowedTypes={['image']}
									render={({ open }) => (
										<Button className={!bgImageId ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview'} onClick={open}>
											{!bgImageId && __('Set background image', 'image-selector-example')}
											{!!bgImageId && !bgImage && <Spinner />}
											{!!bgImageId && bgImage && (
												<ResponsiveWrapper naturalWidth={bgImage.media_details.width} naturalHeight={bgImage.media_details.height}>
													<img src={bgImage.source_url} alt={__('Background image', 'image-selector-example')} />
												</ResponsiveWrapper>
											)}
										</Button>
									)}
								/>
							</MediaUploadCheck>
							{!!bgImageId && bgImage && (
								<MediaUploadCheck>
									<MediaUpload
										title={__('Background image', 'image-selector-example')}
										onSelect={onSelectMedia}
										allowedTypes={ALLOWED_MEDIA_TYPES}
										value={bgImageId}
										render={({ open }) => (
											<Button onClick={open} isDefault isLarge>
												{__('Replace background image', 'image-selector-example')}
											</Button>
										)}
									/>
								</MediaUploadCheck>
							)}
							{!!bgImageId && (
								<MediaUploadCheck>
									<Button onClick={onRemoveMedia} isLink isDestructive>
										{__('Remove background image', 'image-selector-example')}
									</Button>
								</MediaUploadCheck>
							)}
						</div>
					</PanelRow>
					<PanelRow>
						<TextControl label={__('Video Url', 'rwp')} value={videoUrl} onChange={onVideoInput} />
					</PanelRow>
					<PanelRow>
						<TextControl label={__('Inner Classes', 'rwp')} value={innerClasses} onChange={(val) => setAttributes({ innerClasses: val })} />
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			<InnerBlocks />
		</div>
	);
}

export default compose(
	withSelect((select, ownProps) => {
		const { clientId, name } = ownProps;
		const { getBlock } = select('core/block-editor') || select('core/editor');
		const { getBlockVariations, getBlockType, getDefaultBlockVariation } = select('core/blocks');
		const { bgImageId } = ownProps.attributes;

		const block = getBlock(clientId);

		const hasInnerBlocks = useSelect(() => {
			return !!(block && block.innerBlocks.length);
		}, [block]);

		const bgImage = useSelect(() => {
			return select('core').getMedia(bgImageId);
		}, [bgImageId]);

		return {
			blockType: getBlockType(name),
			bgImage,
			media: ownProps.attributes.bgImageId ? select('core').getMedia(ownProps.attributes.bgImageId) : undefined,
			defaultVariation: getDefaultBlockVariation(name, 'block'),
			variations: getBlockVariations(name, 'block'),
			hasInnerBlocks,
		};
	}),
	withColors({
		backgroundColor: 'background-color',
	})
)(sectionEdit);
