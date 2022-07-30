const config = require('conventional-changelog-conventionalcommits');
const conventionalChangelogCore = require('conventional-changelog-core');
const { fileContents } = require('../webpack/utils/utils');
const _ = require('lodash');
const conventionalCommitsFilter = require('conventional-commits-filter');

module.exports = {
	options: {
		commitUrlFormat: '{{host}}/{{owner}}/{{repository}}/commits/{{hash}}',
		compareUrlFormat: '{{host}}/{{owner}}/{{repository}}/compare/{{currentTag}}%0D{{previousTag}}#diff',
		issueUrlFormat: '{{host}}/{{owner}}/{{repository}}/issue/{{id}}',
		issuePrefixes: ['RWP-'],
	},
	gitRawCommitsOpts: {
		'extended-regexp': true,
		grep: '^(reverts?)',
		'regexp-ignore-case': true,
		'invert-grep': true,
		'no-merges': true,
	},
	parserOpts: {
		issuePrefixes: ['RWP-'],
		mergePattern: "^Merge branch '([^']+)' of (.*)$", // eslint-disable-line
		mergeCorrespondence: ['branch', 'source'],
	},
	writerOpts: {
		ignoreReverted: true,
		doFlush: true,
	},
};
