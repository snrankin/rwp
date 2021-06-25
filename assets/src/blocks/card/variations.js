/**
 * ============================================================================
 * variations
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    Sam Rankin <srankin@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

/**
 * WordPress dependencies
 */

import { __ } from '@wordpress/i18n';
import { Path, Circle, Rect, SVG } from '@wordpress/components';
import {
	cardFull,
	cardBody,
	cardHeaderBody,
	cardBodyFooter,
	cardHeaderBodyFooter,
	cardImgTop,
	cardImgBottom,
	cardImgLeft,
	cardImgRight,
	cardImgOverlay,
} from './icons';

/** @typedef {import('@wordpress/blocks').WPBlockVariation} WPBlockVariation */

/**
 * Template option choices for predefined card layouts.
 *
 * @type {WPBlockVariation[]}
 */
const variations = [
	{
		name: 'default-card',
		isDefault: true,
		title: 'Default Card',
		icon: cardFull,
		scope: ['block'],
		example: {
			innerBlocks: [
				[
					'core/heading',
					{
						content: 'Card Header',
						level: 2,
						className: 'card-header',
					},
				],
				[
					'core/image',
					{
						className: 'card-img',
						attributes: {
							url: 'https://dummyimage.com/600x16:9',
						},
					},
				],
				[
					'rwp/card-body',
					{},
					[
						[
							'core/heading',
							{
								content: 'Card Body Title',
								level: 4,
								className: 'card-title',
							},
						],
						[
							'core/paragraph',
							{
								content: 'Card Body',
								className: 'card-text',
							},
						],
					],
				],
				[
					'rwp/card-footer',
					{},
					[
						[
							'core/buttons',
							{},
							[
								['core/button', { content: 'Button 1' }],
								['core/button', { content: 'Button 2' }],
							],
						],
					],
				],
			],
		},
		description:
			'A full vertical card with a header, image on top, body, and footer',
		attributes: {},
		innerBlocks: [
			[
				'rwp/card-header',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Heading',
							level: 2,
							className: 'card-title',
						},
					],
				],
			],
			[
				'core/image',
				{
					className: 'card-img',
				},
			],
			[
				'rwp/card-body',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Body Title',
							level: 4,
							className: 'card-title',
						},
					],
					[
						'core/paragraph',
						{
							placeholder: 'Card Body',
							className: 'card-text',
						},
					],
				],
			],
			[
				'rwp/card-footer',
				{},
				[
					[
						'core/buttons',
						{},
						[
							['core/button', { placeholder: 'Button 1' }],
							['core/button', { placeholder: 'Button 2' }],
						],
					],
				],
			],
		],
	},
	{
		name: 'card-with-body',
		title: 'Card Body',
		scope: ['block'],
		icon: cardBody,
		description: 'A card with body only',
		attributes: {},
		innerBlocks: [
			[
				'rwp/card-body',
				{},
				[
					[
						'rwp/card-header',
						{},
						[
							[
								'core/heading',
								{
									placeholder: 'Card Heading',
									level: 2,
									className: 'card-title',
								},
							],
						],
					],
					[
						'core/paragraph',
						{
							placeholder: 'Card Body',
							className: 'card-text',
						},
					],
				],
			],
		],
	},
	{
		name: 'card-with-header-body',
		title: 'Card with Header and Body',
		scope: ['block'],
		description: 'A card with header and body only',
		icon: cardHeaderBody,
		attributes: {},
		innerBlocks: [
			[
				'rwp/card-header',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Heading',
							level: 2,
							className: 'card-title',
						},
					],
				],
			],
			[
				'rwp/card-body',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Body Title',
							level: 4,
							className: 'card-title',
						},
					],
					[
						'core/paragraph',
						{
							placeholder: 'Card Body',
							className: 'card-text',
						},
					],
				],
			],
		],
	},
	{
		name: 'card-with-body-footer',
		title: 'Card with Body and Footer',
		scope: ['block'],
		description: 'A card with body and footer only',
		icon: cardBodyFooter,
		attributes: {},
		innerBlocks: [
			[
				'rwp/card-body',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Body Title',
							level: 4,
							className: 'card-title',
						},
					],
					[
						'core/paragraph',
						{
							placeholder: 'Card Body',
							className: 'card-text',
						},
					],
				],
			],
			[
				'rwp/card-footer',
				{},
				[
					[
						'core/buttons',
						{},
						[
							['core/button', { placeholder: 'Button 1' }],
							['core/button', { placeholder: 'Button 2' }],
						],
					],
				],
			],
		],
	},
	{
		name: 'card-with-header-body-footer',
		scope: ['block'],
		title: 'Card with Header, Body and Footer',
		description: 'A card with header, body, and footer only',
		icon: cardHeaderBodyFooter,
		attributes: {},
		innerBlocks: [
			[
				'rwp/card-header',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Heading',
							level: 2,
							className: 'card-title',
						},
					],
				],
			],
			[
				'rwp/card-body',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Body Title',
							level: 4,
							className: 'card-title',
						},
					],
					[
						'core/paragraph',
						{
							placeholder: 'Card Body',
							className: 'card-text',
						},
					],
				],
			],
			[
				'rwp/card-footer',
				{},
				[
					[
						'core/buttons',
						{},
						[
							['core/button', { placeholder: 'Button 1' }],
							['core/button', { placeholder: 'Button 2' }],
						],
					],
				],
			],
		],
	},
	{
		name: 'vertical-img-top',
		scope: ['block'],
		title: 'Vertical Card with Top Image',
		description: 'A vertical card with an image on top and body',
		icon: cardImgTop,
		attributes: {},
		innerBlocks: [
			['core/image', { className: 'card-img-top' }],
			[
				'rwp/card-body',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Body Title',
							level: 4,
							className: 'card-title',
						},
					],
					[
						'core/paragraph',
						{
							placeholder: 'Card Body',
							className: 'card-text',
						},
					],
				],
			],
		],
	},
	{
		name: 'vertical-img-bottom',
		scope: ['block'],
		title: 'Vertical Card with Bottom Image',
		description: 'A vertical card with an image on bottom and body',
		icon: cardImgBottom,
		attributes: {},
		innerBlocks: [
			[
				'rwp/card-body',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Body Title',
							level: 4,
							className: 'card-title',
						},
					],
					[
						'core/paragraph',
						{
							placeholder: 'Card Body',
							className: 'card-text',
						},
					],
				],
			],
			['core/image', { className: 'card-img-bottom' }],
		],
	},
	{
		name: 'horizontal-img-left',
		scope: ['block'],
		title: 'Horizontal Card with Left Image',
		description: 'A horizontal card with a image on left, body on right',
		icon: cardImgLeft,
		attributes: {
			className: 'card-row',
		},
		innerBlocks: [
			['core/image', { className: 'card-img-left' }],
			[
				'rwp/card-body',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Body Title',
							level: 4,
							className: 'card-title',
						},
					],
					[
						'core/paragraph',
						{
							placeholder: 'Card Body',
							className: 'card-text',
						},
					],
				],
			],
		],
	},
	{
		name: 'horizontal-img-right',
		scope: ['block'],
		title: 'Horizontal Card with Right Image',
		description: 'A horizontal card with a image on right, body on right',
		icon: cardImgRight,
		attributes: {
			className: 'card-row',
		},
		innerBlocks: [
			[
				'rwp/card-body',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Body Title',
							level: 4,
							className: 'card-title',
						},
					],
					[
						'core/paragraph',
						{
							placeholder: 'Card Body',
							className: 'card-text',
						},
					],
				],
			],
			['core/image', { className: 'card-img-right' }],
		],
	},
	{
		name: 'img-overlay',
		scope: ['block'],
		title: 'Card with Image overlay',
		description: 'A card with text overlaying an image',
		icon: cardImgOverlay,
		attributes: {
			className: 'card-row',
		},

		innerBlocks: [
			['core/image', { className: 'card-img' }],
			[
				'rwp/card-body',
				{},
				[
					[
						'core/heading',
						{
							placeholder: 'Card Body Title',
							level: 4,
							className: 'card-title',
						},
					],
					[
						'core/paragraph',
						{
							placeholder: 'Card Body',
							className: 'card-text',
						},
					],
				],
			],
		],
	},
];

export default variations;
