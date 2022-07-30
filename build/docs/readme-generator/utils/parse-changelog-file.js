const { readFileSync } = require('fs');

/**
 * Retrieve an entry object stub with the given date and version.
 *
 * @since 0.0.1
 *
 * @param {string} date    Release date in `YYYY-MM-DD` format.
 * @param {string} version A semver string.
 * @return {Object} Entry object.
 */
function getEntryObject(date, version) {
	return {
		date,
		version,
		logs: [],
	};
}

/**
 * Convert an entry item list into a string, preserving newlines within the list but stripping them from the start and end.
 *
 * @since 0.0.1
 *
 * @param {string[]} entry Array of lines.
 * @return {string} Joined entry string.
 */
function finalizeEntry(entry) {
	// Trim newlines from the beginning of the entry list.
	// if (!entry.logs[0]) {
	// 	entry.logs.splice(0, 1);
	// }

	// // Trim trailing nnewlines from the end of the entry list.
	// if (entry.logs.length > 0) {
	// 	while (!entry.logs[entry.logs.length - 1]) {
	// 		entry.logs.splice(entry.logs.length - 1, 1);
	// 	}
	// }

	// Join them all together with a new line.

	entry.logs = entry.logs.map((element, index) => {
		if (index > 0) {
			return element.replace(/^\*\*/, '\n**');
		} else {
			return element;
		}
	});

	entry.logs = entry.logs.join('\n');

	entry.logs = entry.logs.replace(/\\n\*\*/gm, '\\n\\n**');

	return entry;
}

function filterLogs(lines) {
	// Remove everything up to first version
	lines = lines.replace(/[^v\d]*/m, '');

	// // Remove all extra blank lines
	// lines = lines.replace(/^\n/gm, '');

	// Replace new line characters that were accidentally made into plain text
	lines = lines.replace(/\\n\\n/gm, '\n\t* ');

	lines = lines.replace(/###\s(.+\b)/gim, '\n\n**$1**');

	// // Remove revert commits
	// lines = lines.replace(/^[*|+|-]\sRevert\s"[^"]+"\n/gim, '');

	lines = lines.replace('Initial commit on laptop', '');

	return lines;
}

/**
 * Convert a changelog file to a JSON object
 *
 * @since 0.0.1
 *
 * @param {string} file Path to the changelog MD file.
 * @return {Object[]} Changelog as an array of JSON objects.
 */
module.exports = (file) => {
	const changelog = readFileSync(file, 'utf8');
	let lines = filterLogs(changelog);
	lines = lines.split('\n');
	const logs = [];
	// eslint-disable-next-line
	const regex = /v(?<version>[0-9]\d*\.[0-9]\d*\.[0-9]\d*(?:-(?:[0-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*)(?:\.(?:[0-9]\d*|\d*[a-zA-Z-][0-9a-zA-Z-]*))*)?(?:\+[0-9a-zA-Z-]+(?:\.[0-9a-zA-Z-]+)*)?) - (?<date>\d{4}\-\d{2}\-\d{2})/;

	let currEntry = {};

	lines.forEach((line) => {
		if (line.startsWith('====') || line.startsWith('----')) {
			return;
		}

		const parsed = regex.exec(line);

		// This is a header line.
		if (parsed) {
			if (typeof currEntry.logs !== 'undefined' && currEntry.logs.length > 0) {
				const filtered = currEntry.logs.filter(function (el) {
					if (el === '' && el.length <= 1) {
						return false;
					} else {
						return true;
					}
				});
				currEntry.logs = filtered;
				// Before we start processing the next log item, finalize what we've compiled from the previous.
				if (currEntry.logs && currEntry.logs.length) {
					logs.push(finalizeEntry(currEntry));
				}
			}

			currEntry = getEntryObject(parsed.groups.date, parsed.groups.version);
		} else {
			currEntry.logs.push(line);
		}
	});

	// The final entry in the changelog won't get caught by the next parsed date so we'll finalize that entry here at the end.
	logs.push(finalizeEntry(currEntry));

	return logs;
};
