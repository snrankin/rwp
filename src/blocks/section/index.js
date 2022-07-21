/**
 * ============================================================================
 * BLOCK: rwp/section
 *
 * @file
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

import { registerBlockType } from '@wordpress/blocks';

import { sectionIcon as icon } from '../global/icons';

import edit from './edit';
import metadata from './block.json';
import save from './save';

//import './index.scss';

const { name } = metadata;

const settings = Object.assign(metadata, {
	icon,
	edit,
	save,
});

registerBlockType(name, settings);
