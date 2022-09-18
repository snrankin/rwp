const { fileContents } = require('../webpack/utils/utils');
const config = require('conventional-changelog-conventionalcommits');
const headerTemplate = fileContents('build/docs/templates/header.hbs');

console.log('🚀 ~ file: config.js ~ line 5 ~ headerTemplate', headerTemplate);

const newConfig = config({
	issueUrlFormat: 'https://riester.atlassian.net/jira/software/projects/RWP/issues/{{id}}',
	issuePrefixes: ['RWP-'],
	compareUrlFormat: '{{host}}/{{owner}}/{{repository}}/branches/compare/{{currentTag}}%0D{{previousTag}}',

	config: {
		writerOpts: {
			headerPartial: headerTemplate,
		},
	},
	parserOpts: {
		issuePrefixes: ['RWP-'],
		mergePattern: "^Merge branch '([^']+)' of (.*)$", // eslint-disable-line
		mergeCorrespondence: ['branch', 'source'],
	},
	writerOpts: {
		title: 'Changelog',
		issueUrlFormat: 'https://riester.atlassian.net/jira/software/projects/RWP/issues/{{id}}',
		issuePrefixes: ['RWP-'],
		compareUrlFormat: '{{host}}/{{owner}}/{{repository}}/branches/compare/{{currentTag}}%0D{{previousTag}}',
		types: [
			{ type: 'feat', section: 'Features' },
			{ type: 'feature', section: 'Features' },
			{ type: 'fix', section: 'Bug Fixes' },
			{ type: 'perf', section: 'Performance Improvements' },
			{ type: 'revert', section: 'Reverts', hidden: true },
			{ type: 'docs', section: 'Documentation', hidden: true },
			{ type: 'style', section: 'Styles', hidden: true },
			{ type: 'chore', section: 'Miscellaneous Chores', hidden: true },
			{ type: 'refactor', section: 'Code Refactoring', hidden: true },
			{ type: 'test', section: 'Tests', hidden: true },
			{ type: 'build', section: 'Build System', hidden: true },
			{ type: 'ci', section: 'Continuous Integration', hidden: true },
		],
		ignoreReverted: true,
		doFlush: true,
		headerPartial: headerTemplate,
	},
});

console.log('🚀 ~ file: config.js ~ line 41 ~ newConfig', `${newConfig}`);

module.exports = newConfig;
