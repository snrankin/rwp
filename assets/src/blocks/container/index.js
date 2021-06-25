/**
 * ============================================================================
 * BLOCK: rwp/container
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

import { __ } from '@wordpress/i18n';

import { containerIcon as icon } from '../global/icons';

import edit from './edit';
import metadata from './block.json';
import save from './save';
import variations from './variations';

//import './index.scss';

const { name } = metadata;

const settings = Object.assign(metadata, {
	icon,
	variations,
	edit,
	save,
});

registerBlockType(name, settings);
