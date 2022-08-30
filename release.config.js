/* eslint-disable no-template-curly-in-string */

const releaseMessage = 'chore(release): {{currentTag}} [skip ci]';
const preset = 'conventionalcommits';
const writerConfig = {
	ignoreReverted: true,
	doFlush: true,
	linkReferences: false,
	linkCompare: false,
};
const parserConfig = {
	issuePrefixes: ['RWP-'],
	mergePattern: "^Merge branch '([^']+)' of (.*)$", // eslint-disable-line
	mergeCorrespondence: ['branch', 'source'],
	types: [
		{
			type: 'revert',
			section: 'Reverts',
			hidden: true,
		},
	],
};

const presetConfig = {
	options: {
		commitUrlFormat: '{{host}}/{{owner}}/{{repository}}/commits/{{hash}}',
		issueUrlFormat: 'https://riester.atlassian.net/jira/software/projects/RWP/issues/{{id}}',
		issuePrefixes: ['RWP-'],
		compareUrlFormat: '{{host}}/{{owner}}/{{repository}}/branches/compare/{{currentTag}}%0D{{previousTag}}',
		releaseCommitMessageFormat: releaseMessage,
		linkReferences: false,
		linkCompare: false,
	},
	gitRawCommitsOpts: {
		'extended-regexp': true,
		grep: '^(reverts?)',
		'regexp-ignore-case': true,
		'invert-grep': true,
		'no-merges': true,
	},
};

require('dotenv').config();
console.log(process.env);

module.exports = {
	plugins: [
		[
			'@semantic-release/commit-analyzer',
			{
				preset,
				presetConfig,
				parserOpts: parserConfig,
				releaseRules: [
					{
						type: 'docs',
						scope: '*README*',
						release: 'patch',
					},
					{
						type: 'build',
						scope: 'deps',
						release: 'patch',
					},
					{
						type: 'docs',
						scope: '*readme*',
						release: 'patch',
					},
					{
						type: 'refactor',
						release: 'patch',
					},
					{
						type: 'chore',
						scope: 'release',
						release: false,
					},
					{
						scope: 'no-release',
						release: false,
					},
				],
			},
		],
		[
			'@google/semantic-release-replace-plugin',
			{
				replacements: [
					{
						files: ['rwp.php'],
						from: 'Version: .*',
						to: 'Version: ${nextRelease.version}', //eslint-disable-line
						results: [
							{
								file: 'rwp.php',
								hasChanged: true,
								numMatches: 1,
								numReplacements: 1,
							},
						],
						countMatches: true,
					},
				],
			},
		],
		[
			'@semantic-release/release-notes-generator',
			{
				preset,
				presetConfig,
				parserOpts: parserConfig,
				writerOpts: writerConfig,
			},
		],
		[
			'@semantic-release/changelog',
			{
				changelogTitle: '# RIESTERWP Core Changelog\n---',
			},
		],
		[
			'@semantic-release/npm',
			{
				npmPublish: false,
			},
		],
		[
			'@semantic-release/exec',
			{
				prepareCmd: 'npm run wp-readme',
			},
		],
		[
			'@semantic-release/exec',
			{
				prepareCmd: 'npm run archive',
			},
		],
		[
			'@semantic-release/git',
			{
				assets: ['release/rwp.zip', 'CHANGELOG.md', 'package.json', 'package-lock.json', 'rwp.php', 'readme.txt', 'README.md'],
				message: 'chore(release): ${nextRelease.version} [skip ci]', //eslint-disable-line
			},
		]
	],
	branches: ['master'],
};
