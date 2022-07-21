/** ============================================================================
 * bgimage
 *
 * @package   RWP
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ========================================================================== */

// edit.js

// Load dependencies
import { __ } from '@wordpress/i18n';
import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, Button, ResponsiveWrapper, Spinner } from '@wordpress/components';

const ALLOWED_MEDIA_TYPES = ['image'];

function BackgroundImg(props) {
	const { attributes, setAttributes, bgImage, className } = props;
	const { bgImageId, bgImageUrl } = attributes;
	const instructions = <p>{__('To edit the background image, you need permission to upload media.', 'rwp')}</p>;

	const onUpdateImage = (media) => {
		setAttributes({
			bgImage: media,
			bgImageId: media.id,
			bgImageUrl: media.url,
		});
	};

	const onRemoveImage = () => {
		setAttributes({
			bgImage: undefined,
			bgImageId: 0,
			bgImageUrl: '',
		});
	};

	return (
		<>
			<div className="editor-post-featured-image">
				<MediaUploadCheck fallback={instructions}>
					<MediaUpload
						title={__('Background image', 'rwp')}
						onSelect={onUpdateImage}
						allowedTypes={ALLOWED_MEDIA_TYPES}
						value={bgImageId}
						render={({ open }) => (
							<Button className={!bgImageId ? 'editor-post-featured-image__toggle' : 'editor-post-featured-image__preview'} onClick={open}>
								{!bgImageId && __('Set background image', 'rwp')}
								{!!bgImageId && !bgImage && <Spinner />}
								{!!bgImageId && bgImage && (
									<ResponsiveWrapper naturalWidth={bgImage.media_details.width} naturalHeight={bgImage.media_details.height}>
										<img src={bgImage.source_url} alt={__('Background image', 'rwp')} />
									</ResponsiveWrapper>
								)}
							</Button>
						)}
					/>
				</MediaUploadCheck>
				{!!bgImageId && bgImage && (
					<MediaUploadCheck>
						<MediaUpload
							title={__('Background image', 'rwp')}
							onSelect={onUpdateImage}
							allowedTypes={ALLOWED_MEDIA_TYPES}
							value={bgImageId}
							render={({ open }) => (
								<Button onClick={open} isDefault isLarge>
									{__('Replace background image', 'rwp')}
								</Button>
							)}
						/>
					</MediaUploadCheck>
				)}
				{!!bgImageId && (
					<MediaUploadCheck>
						<Button onClick={onRemoveImage} isLink isDestructive>
							{__('Remove background image', 'rwp')}
						</Button>
					</MediaUploadCheck>
				)}
			</div>
		</>
	);
}

export default BackgroundImg;
