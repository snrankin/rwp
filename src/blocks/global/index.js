/**
 * ============================================================================
 * global
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
import {
	compose,
	createHigherOrderComponent,
	withState,
} from '@wordpress/compose';
import * as BlockEditor from '@wordpress/block-editor';
import * as Editor from '@wordpress/editor';
const {
	InnerBlocks,
	InspectorControls,
	BlockControls,
	RichText,
	AlignmentToolbar,
} = BlockEditor || Editor;
import {
	RangeControl,
	PanelBody,
	PanelRow,
	ToggleControl,
	Flex,
	FlexBlock,
	FlexItem,
	Toolbar,
	ToolbarGroup,
	ToolbarButton,
	ResizableBox,
	Panel,
} from '@wordpress/components';
import { Component, Fragment, cloneElement } from '@wordpress/element';
import {
	generateClasses,
	bsVariations,
	buttonVariations,
	classNames,
	closest,
	bsColumns,
	arraySearch,
	getStyleClasses,
} from './helpers';

import {
	vAlignStart,
	vAlignCenter,
	vAlignEnd,
	hAlignStart,
	hAlignCenter,
	hAlignEnd,
	vDist,
	hStretch,
	desktopIcon,
	laptopIcon,
	tabletLandscapeIcon,
	tabletPortraitIcon,
	mobileIcon,
} from '../global/icons';

buttonVariations.forEach((element) => {
	wp.blocks.registerBlockStyle('core/button', element);
});

// wp.hooks.addFilter(
//     'editor.BlockListBlock',
//     'rwp/global',
//     createHigherOrderComponent((BlockListBlock) => {
//         return (props) => {
//             if (props.name === 'rwp/section') {
//                 return <BlockListBlock {...props} />;
//             }
//             let styleClasses = getStyleClasses(props);
//             let classes = generateClasses(props.name, props.attributes);
//             classes = classNames(classes, styleClasses);
//             props.attributes.className = styleClasses;
//             props.className = classNames('section-wrapper', classes);

//             return <BlockListBlock {...props} />;
//         };
//     })
// );
