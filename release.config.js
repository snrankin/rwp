/* eslint-disable no-template-curly-in-string */

const preset = 'conventionalcommits';


module.exports = {
	plugins: [
		[
			'@semantic-release/commit-analyzer',
			{
				preset,
				// presetConfig,
				// parserOpts: parserConfig,
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
				// presetConfig,
				// parserOpts: parserConfig,
				// writerOpts: writerConfig,
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
				prepareCmd: 'wp-readme readme -m rwp.php -i CHANGELOG.md -l 3 -d build/docs/partials -r ./CHANGELOG.md',
			},
		],
		[
			'@semantic-release/exec',
			{
				prepareCmd: 'wpackio-scripts pack',
			},
		],
		[
			'@semantic-release/git',
			{
				assets: ['release/rwp.zip', 'CHANGELOG.md', 'package.json', 'package-lock.json', 'rwp.php', 'readme.txt', 'README.md'],
				message: 'chore(release): ${nextRelease.version} [skip ci]', //eslint-disable-line
			},
		],
		[
			'@semantic-release/github',
			{
				addReleases: 'top',
				assets: ['release/rwp.zip'],
			},
		],
	],
	branches: ['main'],
};
