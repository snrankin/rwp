/**
 * ============================================================================
 * images
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
import { get, omit, pick, isEmpty, isUndefined, isNil } from 'lodash';
import {
	sectionClasses,
	sectionInnerClasses,
	classNames,
	generateClasses,
} from './helpers';
/**
 * WordPress dependencies
 */
import { renderToString } from '@wordpress/element';
import {
	createBlock,
	getBlockType,
	getBlockVariations,
} from '@wordpress/blocks';
import {
	vAlignStart,
	vAlignCenter,
	vAlignEnd,
	hAlignStart,
	hAlignCenter,
	hAlignEnd,
	hDist,
	vStretch,
	dashOnly,
	plusOnly,
} from './icons';
import {
	RangeControl,
	PanelBody,
	PanelRow,
	Button,
	ResponsiveWrapper,
	Spinner,
	Icon,
	withNotices,
} from '@wordpress/components';

import { Component, Fragment, useEffect, useRef } from '@wordpress/element';
import { withSelect, useSelect } from '@wordpress/data';
import * as BlockEditor from '@wordpress/block-editor';
import * as Editor from '@wordpress/editor';
const {
	BlockAlignmentToolbar,
	BlockControls,
	BlockIcon,
	MediaPlaceholder,
	MediaUpload,
	MediaUploadCheck,
	RichText,
	useBlockProps,
} = BlockEditor || Editor;
import { image as icon } from '@wordpress/icons';

const ALLOWED_MEDIA_TYPES = ['image'];

function imageSizes(image) {
	if (typeof image === 'object') {
		const sizes = [];
		if (image.sizes && image.mime_type !== 'image/svg+xml') {
			for (const [name, size] of Object.entries(image.sizes)) {
				let url = new URL(size.url);
				url = url.pathname;
				sizes.push(`${url} ${size.width}w ${size.height}h`);
			}
		}
		if (sizes.length > 1) {
			return sizes.join(', ');
		}
	}
}

function imageSources(image) {
	if (typeof image === 'object') {
		const sizes = [];

		if (image.media_details.sizes && image.mime_type !== 'image/svg+xml') {
			for (const [name, size] of Object.entries(
				image.media_details.sizes
			)) {
				const url = `${size.source_url} ${size.width}w ${size.height}h`;
				sizes.push({
					dataSrcset: url,
					dataAspectratio: `${size.width}/${size.height}`,
					media: `--media-${name}`,
					type: size.mime_type,
				});
			}
		}
		if (sizes.length > 0) {
			return sizes.map((size) => (
				<source
					type={size.type}
					data-srcset={size.dataSrcset}
					media={size.media}
					data-aspectratio={size.dataAspectratio}
				/>
			));
		}
	}
}

function bgSizes(image) {}

export function displayImage(imageID, classes = '', isBG = false) {
	if (typeof imageID !== undefined) {
		const image = wp.data.select('core').getMedia(imageID);

		if (typeof image === 'object') {
			const coverSize = isBG ? 'cover' : 'contain';
			return (
				<figure
					className={classNames(
						'figure media-wrapper image-wrapper',
						classes,
						{
							'is-bg': isBG,
						}
					)}
				>
					<picture className="media-content">
						<img
							loading="lazy"
							className="media-src media-image lazyload"
							alt={image.alt_text}
							title={image.title.rendered}
							srcSet="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
							width={image.media_details.width}
							height={image.media_details.height}
							data-src={image.source_url}
							data-srcset={imageSizes(image)}
							data-parent-fit={coverSize}
							//eslint-disable-next-line
							data-parent-container=".media-wrapper"
						/>
					</picture>
				</figure>
			);
		}
	}
}

function getImgByID(id) {
	const img = useSelect(
		(select) => {
			return select('core').getMedia(id);
		},
		[id]
	);
	console.log({ img, id });
	return img;
}

export const RWPBGImage = ({
	label,
	attributeName,
	attributeValue,
	srcsetName,
	srcsetValue,
	urlName,
	urlValue,
	setAttributes,
	...props
}) => {
	let img = null;
	if (!isNil(attributeValue)) {
		img = getImgByID(attributeValue);
	}

	console.log({ img, attributeValue });

	const instructions = (
		<p>{__('You need permission to upload media.', 'rwp')}</p>
	);

	const onUpdateImage = (media) => {
		img = media;
		setAttributes({
			[attributeName]: media.id,
		});
	};

	const onRemoveImage = () => {
		img = null;
		setAttributes({
			[srcsetName]: '',
			[attributeName]: 0,
			[urlName]: '',
		});
	};

	return (
		<div className="editor-post-featured-image">
			<MediaUploadCheck fallback={instructions}>
				<MediaUpload
					title={__('Background image', 'rwp')}
					onSelect={onUpdateImage}
					allowedTypes={ALLOWED_MEDIA_TYPES}
					value={attributeValue}
					render={({ open }) => (
						<div className="editor-post-featured-image__container">
							<Button
								className={
									!isNil(img)
										? 'editor-post-featured-image__toggle'
										: 'editor-post-featured-image__preview'
								}
								onClick={open}
							>
								{isNil(attributeValue) &&
									__('Set background image', 'rwp')}
								{!isNil(attributeValue) && isNil(img) && (
									<Spinner />
								)}
								{!isNil(attributeValue) && !isNil(img) && (
									<ResponsiveWrapper
										naturalWidth={img.media_details.width}
										naturalHeight={img.media_details.height}
									>
										<img
											src={img.source_url}
											alt={__('Background image', 'rwp')}
										/>
									</ResponsiveWrapper>
								)}
							</Button>
						</div>
					)}
				/>
			</MediaUploadCheck>
			{!isNil(attributeValue) && !isNil(img) && (
				<MediaUploadCheck>
					<MediaUpload
						title={__('Background image', 'rwp')}
						onSelect={onUpdateImage}
						allowedTypes={ALLOWED_MEDIA_TYPES}
						value={attributeValue}
						render={({ open }) => (
							<Button onClick={open} isSecondary>
								{__('Replace background image', 'rwp')}
							</Button>
						)}
					/>
				</MediaUploadCheck>
			)}
			{!isNil(attributeValue) && (
				<MediaUploadCheck>
					<Button onClick={onRemoveImage} isLink isDestructive>
						{__('Remove background image', 'rwp')}
					</Button>
				</MediaUploadCheck>
			)}
		</div>
	);
};
