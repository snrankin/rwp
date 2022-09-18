const { fileContents } = require('../webpack/utils/utils');
const config = require('conventional-changelog-conventionalcommits');

const newConfig = config({

	writerOpts: {
		title: 'Changelog',
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
			{ type: 'ci-fix', section: 'Continuous Integration', hidden: true },
		],
		ignoreReverted: true,
		doFlush: true,
	},
});

module.exports = newConfig;
