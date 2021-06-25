/**
 * ============================================================================
 * BLOCK: rwp/card-body
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

import { cardBodyIcon as icon } from '../icons';

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
