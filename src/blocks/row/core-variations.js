/**
 * ============================================================================
 * variations
 *
 * @file
 * @package
 * @since     0.1.1
 * @version   0.1.1
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

/**
 * WordPress dependencies
 */
import { Path, SVG } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

/** @typedef {import('@wordpress/blocks').WPBlockVariation} WPBlockVariation */

/**
 * Template option choices for predefined columns layouts.
 *
 * @type {WPBlockVariation[]}
 */
const variations = [
	{
		name: 'one-column-full',
		title: __('100'),
		description: __('One column'),
		icon: (
			<SVG
				width="48"
				height="48"
				viewBox="0 0 48 48"
				xmlns="http://www.w3.org/2000/svg"
			>
				<Path
					fillRule="evenodd"
					clipRule="evenodd"
					d="m39.0625 14h-30.0625v20.0938h30.0625zm-30.0625-2c-1.10457 0-2 .8954-2 2v20.0938c0 1.1045.89543 2 2 2h30.0625c1.1046 0 2-.8955 2-2v-20.0938c0-1.1046-.8954-2-2-2z"
				/>
			</SVG>
		),
		innerBlocks: [['core/column', { width: 100, sizeXl: 12 }]],
		scope: ['block'],
	},
	{
		name: 'two-columns-equal',
		title: __('50 / 50'),
		description: __('Two columns; equal split'),
		icon: (
			<SVG
				width="48"
				height="48"
				viewBox="0 0 48 48"
				xmlns="http://www.w3.org/2000/svg"
			>
				<Path
					fillRule="evenodd"
					clipRule="evenodd"
					d="M39 12C40.1046 12 41 12.8954 41 14V34C41 35.1046 40.1046 36 39 36H9C7.89543 36 7 35.1046 7 34V14C7 12.8954 7.89543 12 9 12H39ZM39 34V14H25V34H39ZM23 34H9V14H23V34Z"
				/>
			</SVG>
		),
		isDefault: true,
		innerBlocks: [
			['core/column', { width: '50%', sizeXl: 6 }],
			['core/column', { width: '50%', sizeXl: 6 }],
		],
		scope: ['block'],
	},
	{
		name: 'main-col-sidebar-left',
		title: __('Sidebar Left'),
		description: __('Main column with sidebar on left'),
		icon: (
			<SVG
				width="48"
				height="48"
				viewBox="0 0 48 48"
				xmlns="http://www.w3.org/2000/svg"
			>
				<Path
					fillRule="evenodd"
					clipRule="evenodd"
					d="M39 12C40.1046 12 41 12.8954 41 14V34C41 35.1046 40.1046 36 39 36H9C7.89543 36 7 35.1046 7 34V14C7 12.8954 7.89543 12 9 12H39ZM39 34V14H20V34H39ZM18 34H9V14H18V34Z"
				/>
			</SVG>
		),
		innerBlocks: [
			[
				'core/column',
				{ width: '33.33%', sizeMl: 4, sizeXl: 4, offsetXl: 1 },
			],
			['core/column', { width: '58.33%', sizeXl: 7, sizeMl: 8 }],
		],
		scope: ['block'],
	},
	{
		name: 'main-col-sidebar',
		title: __('Sidebar Right'),
		description: __('Main column with sidebar on right'),
		icon: (
			<SVG
				width="48"
				height="48"
				viewBox="0 0 48 48"
				xmlns="http://www.w3.org/2000/svg"
			>
				<Path
					fillRule="evenodd"
					clipRule="evenodd"
					d="M39 12C40.1046 12 41 12.8954 41 14V34C41 35.1046 40.1046 36 39 36H9C7.89543 36 7 35.1046 7 34V14C7 12.8954 7.89543 12 9 12H39ZM39 34V14H30V34H39ZM28 34H9V14H28V34Z"
				/>
			</SVG>
		),
		innerBlocks: [
			['core/column', { width: '58.33%', sizeXl: 7, sizeMl: 8 }],
			[
				'core/column',
				{ width: '33.33%', sizeMl: 4, sizeXl: 4, offsetXl: 1 },
			],
		],
		scope: ['block'],
	},
	{
		name: 'three-columns-equal',
		title: __('33 / 33 / 33'),
		description: __('Three columns; equal split'),
		icon: (
			<SVG
				width="48"
				height="48"
				viewBox="0 0 48 48"
				xmlns="http://www.w3.org/2000/svg"
			>
				<Path
					fillRule="evenodd"
					d="M41 14a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h30a2 2 0 0 0 2-2V14zM28.5 34h-9V14h9v20zm2 0V14H39v20h-8.5zm-13 0H9V14h8.5v20z"
				/>
			</SVG>
		),
		innerBlocks: [
			['core/column', { width: '33.33%', sizeMl: 4, sizeXl: 4 }],
			['core/column', { width: '33.33%', sizeMl: 4, sizeXl: 4 }],
			['core/column', { width: '33.33%', sizeMl: 4, sizeXl: 4 }],
		],
		scope: ['block'],
	},
];

export default variations;