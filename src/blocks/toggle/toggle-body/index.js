/**
 * ============================================================================
 * BLOCK: rwp/toggle-body
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

import edit from './edit';
import metadata from './block.json';
import save from './save';
import variations from './variations';

const { name } = metadata;

const settings = Object.assign(metadata, {
	//icon,
	variations,
	edit,
	save,
});

registerBlockType(name, settings);
