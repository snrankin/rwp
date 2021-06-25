/**
 * ============================================================================
 * helpers
 *
 * @package
 * @since     0.1.0
 * @version   0.1.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2021 RIESTER
 * ==========================================================================
 */

/**
 * the most terrible camelizer on the internet, guaranteed!
 *
 * @param {string} str String that isn't camel-case, e.g., CAMeL_CaSEiS-harD
 * @return {string} String converted to camel-case, e.g., camelCaseIsHard
 */
export function camelCase(str) {
	`${str.charAt(0).toLowerCase()}${str
		.replace(/[\W_]/g, '|')
		.split('|')
		.map((part) => `${part.charAt(0).toUpperCase()}${part.slice(1)}`)
		.join('')
		.slice(1)}`;
}

/**
 * Change html tag
 *
 * @param {Element} original Node element
 * @param {string} tag the replacement tag
 * @return {string} String converted to camel-case, e.g., camelCaseIsHard
 */
export function changeTag(original, tag) {
	const replacement = document.createElement(tag);

	// Grab all of the original's attributes, and pass them to the replacement
	for (let i = 0, l = original.attributes.length; i < l; ++i) {
		const nodeName = original.attributes.item(i).nodeName;
		const nodeValue = original.attributes.item(i).nodeValue;

		replacement.setAttribute(nodeName, nodeValue);
	}

	// Persist contents
	replacement.innerHTML = original.innerHTML;

	// Switch!
	original.parentNode.replaceChild(replacement, original);

	return original;
}
