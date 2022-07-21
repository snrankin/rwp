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

import { __ } from '@wordpress/i18n';
import { isNil } from 'lodash';

import { PanelBody, PanelRow, TextControl } from '@wordpress/components';
import { compose } from '@wordpress/compose';

// eslint-disable-next-line
import { InnerBlocks, InspectorControls, useBlockProps, useInnerBlocksProps, withColors } from '@wordpress/block-editor';

import { useSelect, withSelect } from '@wordpress/data';

import './edit.scss';

import ImageSelectorEdit from '../global/bgimage';

import { classNames } from '../global/helpers';

//const BLOCK_TEMPLATE = [['rwp/container', {}, [['rwp/row', {}]]]];
const ALLOWED_BLOCKS = ['rwp/container'];

wp.hooks.addFilter('blocks.getBlockDefaultClassName', 'rwp/section', (className, blockName) => {
	if (blockName !== 'rwp/section') {
		return className;
	}

	className = classNames('rwp', 'section-wrapper');

	return className;
});

function Edit(props) {
	const { attributes, setAttributes } = props;
	// eslint-disable-next-line
	const { innerClasses, bgImageId, bgImageUrl, videoUrl, videoHost, videoId } = attributes;

	const innerBlocksProps = useInnerBlocksProps(
		{
			className: classNames('section-inner', innerClasses),
		},
		{
			templateLock: false,
			allowedBlocks: ALLOWED_BLOCKS,
			//template: BLOCK_TEMPLATE,
		}
	);

	let styles = {};
	if (!isNil(bgImageUrl)) {
		styles = {
			backgroundImage: `url(${bgImageUrl})`,
			backgroundSize: 'cover',
			backgroundRepeat: 'none',
		};
	}

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
	let videoElem = '';

	if (!isNil(videoId) && !isNil(videoHost)) {
		let videoParams = 'loop=1&autoplay=1';
		let videoClasses = 'media-src media-video embed-responsive-item';

		switch (videoHost) {
			case 'youtube':
				videoParams += '&controls=0&modestbranding=1&playsinline=1';

				videoElem = (
					<figure className="media-wrapper is-bg video-wrapper">
						<div className="media-content embed-responsive embed-responsive-16by9">
							<div className={videoClasses} data-youtube={videoId} data-ytparams={videoParams}></div>
						</div>
					</figure>
				);

				break;
			case 'vimeo':
				videoParams += '&muted=1&background=1';

				videoElem = (
					<figure className="media-wrapper is-bg video-wrapper">
						<div className="media-content embed-responsive embed-responsive-16by9">
							<div className={videoClasses} data-vimeo={videoId} data-vimeoparams={videoParams}></div>
						</div>
					</figure>
				);

				break;

			case 'wistia':
				videoClasses += ` wistia_embed wistia_async_${videoId} wistia-video playbar=false controlsVisibleOnLoad=false autoPlay=true muted=true silentAutoPlay=true videoFoam=false endVideoBehavior=loop no-video-foam`;

				videoElem = (
					<figure className="media-wrapper is-bg video-wrapper">
						<div className="media-content embed-responsive embed-responsive-16by9">
							<div className={videoClasses}></div>
						</div>
					</figure>
				);
				break;
		}
	}

	const blockProps = useBlockProps({
		style: styles,
	});

	return (
		<div {...blockProps}>
			<InspectorControls>
				<PanelBody title={__('Section Settings', 'rwp')} initialOpen={true}>
					<ImageSelectorEdit></ImageSelectorEdit>
					<PanelRow>
						<TextControl label={__('Video Url', 'rwp')} value={videoUrl} onChange={onVideoInput} />
					</PanelRow>
					<PanelRow>
						<TextControl label={__('Inner Classes', 'rwp')} value={innerClasses} onChange={(val) => setAttributes({ innerClasses: val })} />
					</PanelRow>
				</PanelBody>
			</InspectorControls>
			{videoElem}
			<div {...innerBlocksProps} />
		</div>
	);
}

export default compose(
	withSelect((select, props) => {
		const { clientId, name } = props;
		const { getBlock } = select('core/block-editor') || select('core/editor');
		const { getBlockVariations, getBlockType, getDefaultBlockVariation } = select('core/blocks');

		const block = getBlock(clientId);

		return {
			blockType: getBlockType(name),
			media: props.attributes.bgImageId ? select('core').getMedia(props.attributes.bgImageId) : undefined,
			defaultVariation: getDefaultBlockVariation(name, 'block'),
			variations: getBlockVariations(name, 'block'),
			hasInnerBlocks: useSelect(() => {
				return !!(block && block.innerBlocks.length);
			}, [block]),
		};
	}),
	withColors({
		backgroundColor: 'background-color',
	})
)(Edit);
