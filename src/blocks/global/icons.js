/**
 * ============================================================================
 * icons
 *
 * @file
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2020 RIESTER
 * ==========================================================================
 */

import { Icon, SVG, Path, Cricle, Rect } from '@wordpress/components';

/**
 * Backport from Gutenberg 5.5
 * Source: https://github.com/WordPress/gutenberg/blob/master/packages/block-editor/src/components/block-vertical-alignment-toolbar/icons.js
 */

export const wistiaIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M15.85,4.41C16.2,2.35,15,1.78,15,1.78s.06,1.68-3,2C9.26,4.14.08,3.89.08,3.89l3,3.4A2.49,2.49,0,0,0,5.16,8.38q2.12.07,4.23-.06a9.82,9.82,0,0,0,5-1.7A3.93,3.93,0,0,0,15.85,4.41Z" />
		<Path fillRule="evenodd" d="M16,6.54a6.05,6.05,0,0,1-2.21,1.91A11.07,11.07,0,0,1,9.25,9.67c-1.14.12-3.22,0-4.12,0A2.36,2.36,0,0,0,3,10.8L0,14.15H1.81c.78,0,5.67.29,7.82-.3C16.67,11.9,16,6.54,16,6.54Z" />
	</SVG>
);

export const desktopIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M1.45.73A1.45,1.45,0,0,0,0,2.18v8.73a1.45,1.45,0,0,0,1.45,1.45h5.1a1.46,1.46,0,0,1-1.46,1.46v1.45h5.82V13.82a1.46,1.46,0,0,1-1.46-1.46h5.1A1.45,1.45,0,0,0,16,10.91V2.18A1.45,1.45,0,0,0,14.55.73Zm0,1.45h13.1V9.45H1.45Zm6.55,8a.73.73,0,1,1-.73.73A.73.73,0,0,1,8,10.18Z" />
	</SVG>
);

export const laptopIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M2.67,2.67A1.34,1.34,0,0,0,1.33,4v6.67A1.34,1.34,0,0,0,2.67,12H0v1.33H16V12H13.33a1.34,1.34,0,0,0,1.34-1.33V4a1.34,1.34,0,0,0-1.34-1.33ZM2.67,4H13.33v6.67H2.67Z" />
	</SVG>
);

export const tabletLandscapeIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M16,12V4a1.82,1.82,0,0,0-1.82-1.82H1.82A1.82,1.82,0,0,0,0,4v8a1.82,1.82,0,0,0,1.82,1.82H14.18A1.82,1.82,0,0,0,16,12ZM.64,8a.82.82,0,1,1,.81.82A.82.82,0,0,1,.64,8Zm2.27,4.36V3.64H14.55v8.72Z" />
	</SVG>
);

export const tabletPortraitIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M12,0H4A1.82,1.82,0,0,0,2.18,1.82V14.18A1.82,1.82,0,0,0,4,16h8a1.82,1.82,0,0,0,1.82-1.82V1.82A1.82,1.82,0,0,0,12,0ZM8,15.36a.82.82,0,1,1,.82-.81A.82.82,0,0,1,8,15.36Zm4.36-2.27H3.64V1.45h8.72Z" />
	</SVG>
);

export const mobileIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M13.09,14.18V1.82A1.81,1.81,0,0,0,11.27,0H4.73A1.81,1.81,0,0,0,2.91,1.82V14.18A1.81,1.81,0,0,0,4.73,16h6.54A1.81,1.81,0,0,0,13.09,14.18Zm-1.45.37H4.36V1.45H5.55l.52,1.06a.74.74,0,0,0,.65.4H9.25a.75.75,0,0,0,.65-.4l.52-1.06h1.22Z" />
	</SVG>
);

export const vAlignEnd = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M6 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V2z" />
		<Path fillRule="evenodd" d="M1 14.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5z" />
	</SVG>
);

export const vAlignCenter = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M6 13a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v10zM1 8a.5.5 0 0 0 .5.5H6v-1H1.5A.5.5 0 0 0 1 8zm14 0a.5.5 0 0 1-.5.5H10v-1h4.5a.5.5 0 0 1 .5.5z" />
	</SVG>
);

export const vAlignStart = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M6 14a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v10z" />
		<Path fillRule="evenodd" d="M1 1.5a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 0-1h-13a.5.5 0 0 0-.5.5z" />
	</SVG>
);

export const hDist = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M14.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 1 0v-13a.5.5 0 0 0-.5-.5zm-13 0a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 1 0v-13a.5.5 0 0 0-.5-.5z" />
		<Path fillRule="evenodd" d="M6 13a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1v10z" />
	</SVG>
);

export const vDist = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M1 1.5a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 0-1h-13a.5.5 0 0 0-.5.5zm0 13a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 0-1h-13a.5.5 0 0 0-.5.5z" />
		<Path fillRule="evenodd" d="M2 7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7z" />
	</SVG>
);

export const vStretch = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M2.75,3.12a.38.38,0,0,0,.37.38h9.76a.38.38,0,0,0,0-.75H3.12A.38.38,0,0,0,2.75,3.12Z" />
		<Path fillRule="evenodd" d="M2.75,12.88a.38.38,0,0,0,.37.37h9.76a.38.38,0,0,0,0-.75H3.12A.38.38,0,0,0,2.75,12.88Z" />
		<Path fillRule="evenodd" d="M3.5,7.25a.75.75,0,0,1,.75-.75h7.5a.75.75,0,0,1,.75.75v1.5a.76.76,0,0,1-.75.75H4.25a.76.76,0,0,1-.75-.75Z" />
		<Path fillRule="evenodd" d="M9.39,5.4,8.19,4.2A.27.27,0,0,0,8,4.12H8a.27.27,0,0,0-.19.08L6.61,5.4a.28.28,0,0,0,.19.47h0A.27.27,0,0,0,7,5.79l1-1,1,1a.26.26,0,0,0,.38,0A.27.27,0,0,0,9.39,5.4Z" />
		<Path fillRule="evenodd" d="M9.4,10.2a.28.28,0,0,0-.2-.08h0A.27.27,0,0,0,9,10.2l-1,1-1-1a.29.29,0,0,0-.39,0,.28.28,0,0,0,0,.39L7.81,11.8a.27.27,0,0,0,.38,0L9.4,10.59a.27.27,0,0,0,.08-.19A.28.28,0,0,0,9.4,10.2Z" />
	</SVG>
);

export const hStretch = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M12.88,2.75a.38.38,0,0,0-.38.37v9.76a.38.38,0,0,0,.75,0V3.12A.38.38,0,0,0,12.88,2.75Z" />
		<Path fillRule="evenodd" d="M3.12,2.75a.38.38,0,0,0-.37.37v9.76a.38.38,0,0,0,.75,0V3.12A.38.38,0,0,0,3.12,2.75Z" />
		<Path fillRule="evenodd" d="M8.75,3.5a.75.75,0,0,1,.75.75v7.5a.75.75,0,0,1-.75.75H7.25a.76.76,0,0,1-.75-.75V4.25a.76.76,0,0,1,.75-.75Z" />
		<Path fillRule="evenodd" d="M10.6,9.39l1.2-1.2A.27.27,0,0,0,11.88,8h0a.27.27,0,0,0-.08-.19l-1.2-1.2a.28.28,0,0,0-.47.19h0a.27.27,0,0,0,.08.2l1,1-1,1a.26.26,0,0,0,0,.38A.27.27,0,0,0,10.6,9.39Z" />
		<Path fillRule="evenodd" d="M5.8,9.4a.28.28,0,0,0,.08-.2h0A.27.27,0,0,0,5.8,9l-1-1,1-1a.29.29,0,0,0,0-.39.28.28,0,0,0-.39,0L4.2,7.81a.27.27,0,0,0,0,.38L5.41,9.4a.27.27,0,0,0,.19.08A.28.28,0,0,0,5.8,9.4Z" />
	</SVG>
);

export const hAlignEnd = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M14.5 1a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 1 0v-13a.5.5 0 0 0-.5-.5z" />
		<Path fillRule="evenodd" d="M13 7a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V7z" />
	</SVG>
);

export const hAlignCenter = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M8 1a.5.5 0 0 1 .5.5V6h-1V1.5A.5.5 0 0 1 8 1zm0 14a.5.5 0 0 1-.5-.5V10h1v4.5a.5.5 0 0 1-.5.5zM2 7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V7z" />
	</SVG>
);

export const hAlignStart = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M1.5 1a.5.5 0 0 1 .5.5v13a.5.5 0 0 1-1 0v-13a.5.5 0 0 1 .5-.5z" />
		<Path fillRule="evenodd" d="M3 7a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V7z" />
	</SVG>
);

export const plusOnly = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" className="bi bi-plus btn-icon-closed" fill="currentColor">
		<Path fillRule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
	</SVG>
);

export const plusFilled = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" className="bi bi-plus-square-fill" fill="currentColor">
		<Path fillRule="evenodd" d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
	</SVG>
);

export const dashOnly = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" className="bi bi-dash btn-icon-opened" fill="currentColor">
		<Path fillRule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z" />
	</SVG>
);

export const bodyIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M2.56.61A1.58,1.58,0,0,0,1,2.17V13.83a1.58,1.58,0,0,0,1.56,1.56H13.44A1.58,1.58,0,0,0,15,13.83V2.17A1.58,1.58,0,0,0,13.44.61Zm0,1.56H13.44V13.83H2.56Zm1.55.77V4.5h7.78V2.94Zm0,3.12V9.94h7.78V6.06Zm0,5.44v1.56h7.78V11.5Z" />
	</SVG>
);

export const headerIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M2.56,1A1.58,1.58,0,0,0,1,2.56V15H2.56V2.56H13.44V15H15V2.56A1.58,1.58,0,0,0,13.44,1ZM4.11,4.11V7.22h7.78V4.11Zm0,6.22v1.56h7.78V10.33Zm0,3.11V15H9.56V13.44Z" />
	</SVG>
);

export const toggleIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M2,1.5a1,1,0,0,0-1,1v10H7.26a4.7,4.7,0,0,1-.23-1H2v-7H13V6.76a4.45,4.45,0,0,1,1,.5V2.5a1,1,0,0,0-1-1ZM4,6a.5.5,0,1,0,.5.5A.5.5,0,0,0,4,6ZM6,6A.5.5,0,0,0,6,7H9.44A4.58,4.58,0,0,1,11,6.53s0,0,0,0a.5.5,0,0,0-.5-.5Zm5.5,1.5A3.5,3.5,0,1,0,15,11,3.5,3.5,0,0,0,11.5,7.5ZM4,8a.5.5,0,1,0,.5.5A.5.5,0,0,0,4,8ZM6,8A.5.5,0,0,0,6,9H7.47a4.9,4.9,0,0,1,.68-1Zm5.5,1a.5.5,0,0,1,.5.5v1h1a.5.5,0,0,1,0,1H12v1a.5.5,0,0,1-1,0v-1H10a.5.5,0,0,1,0-1h1v-1A.5.5,0,0,1,11.5,9Z" />
	</SVG>
);

export const buttonIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M2.12,4.36A1.12,1.12,0,0,0,1,5.48v5a1.12,1.12,0,0,0,1.12,1.12H13.88A1.12,1.12,0,0,0,15,10.52v-5a1.12,1.12,0,0,0-1.12-1.12Zm8.27,2.89a.74.74,0,0,1,.77.83.78.78,0,1,1-1.55,0A.74.74,0,0,1,10.39,7.25Zm-7.45,0h.73c.32,0,.5.15.5.39A.34.34,0,0,1,3.88,8V8a.38.38,0,0,1,.37.37c0,.28-.22.46-.56.46H2.94Zm1.7,0h.41v1a.28.28,0,1,0,.55,0v-1H6v1a.6.6,0,0,1-.68.59.6.6,0,0,1-.68-.59Zm1.76,0H7.71v.32H7.26V8.87h-.4V7.61H6.4ZM8,7.29H9.34v.32H8.88V8.87h-.4V7.61H8Zm3.54,0h.32l.66.89h0V7.29H13V8.87h-.32L12,8h0v.9h-.38Zm-8.23.28v.36h.21c.15,0,.23-.07.23-.18s-.08-.18-.22-.18Zm7.05,0c-.23,0-.37.19-.37.5s.14.5.37.5.37-.2.37-.5S10.61,7.58,10.39,7.58Zm-7,.6v.41h.24c.17,0,.26-.08.26-.21s-.1-.2-.26-.2Z" />
	</SVG>
);

export const rowIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M16,5.74V2.26a.35.35,0,0,0-.35-.35H.35A.35.35,0,0,0,0,2.26V5.74ZM0,6.43H16V9.57H0Zm0,3.83v3.48a.35.35,0,0,0,.35.35h15.3a.35.35,0,0,0,.35-.35V10.26Z" />
	</SVG>
);

export const columnIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor">
		<Path fillRule="evenodd" d="M.36,1.09A.37.37,0,0,0,0,1.47V14.53a.37.37,0,0,0,.36.38H4.73V1.09Zm5.09,0V14.91h5.1V1.09Zm5.82,0V14.91h4.37a.37.37,0,0,0,.36-.39v-13a.37.37,0,0,0-.36-.38Z" />
	</SVG>
);

export const sectionIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" style={{ minWidth: '16px' }}>
		<Path fillRule="evenodd" d="M.36,1.09A.37.37,0,0,0,0,1.47V7.64H4.73V1.09Zm5.09,0V7.64h5.1V1.09Zm5.82,0V7.64H16V1.47a.37.37,0,0,0-.36-.38ZM0,8.36v6.16a.37.37,0,0,0,.36.39H4.73V8.36Zm5.45,0v6.55h5.1V8.36Zm5.82,0v6.55h4.37a.37.37,0,0,0,.36-.39V8.36Z" />
	</SVG>
);

export const containerIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" style={{ minWidth: '16px' }}>
		<Path fillRule="evenodd" d="M.35,1.91A.35.35,0,0,0,0,2.26V13.74a.35.35,0,0,0,.35.35h15.3a.35.35,0,0,0,.35-.35V2.26a.35.35,0,0,0-.35-.35Zm.35.7H15.3V5.74H.7Zm0,3.82H15.3V9.57H.7Zm0,3.83H15.3v3.13H.7Z" />
	</SVG>
);

export const cardIcon = (
	<SVG xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" className="bi bi-card-text" style={{ minWidth: '16px' }}>
		<Path fillRule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
		<Path fillRule="evenodd" d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z" />
	</SVG>
);

export const templateIconMissing = (
	<SVG width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
		<Path fillRule="evenodd" d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z" />
	</SVG>
);
