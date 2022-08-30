const { fileContents } = require('../webpack/utils/utils');

module.exports = {
	options: {
		commitUrlFormat: '{{host}}/{{owner}}/{{repository}}/commits/{{hash}}',
		compareUrlFormat: '{{host}}/{{owner}}/{{repository}}/compare/{{currentTag}}%0D{{previousTag}}#diff',
		issueUrlFormat: '{{host}}/{{owner}}/{{repository}}/issue/{{id}}',
		issuePrefixes: ['RWP-'],
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
	parserOpts: {
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
	},
	writerOpts: {
		// groupBy: false,
		ignoreReverted: true,
		doFlush: true,
		// mainTemplate: fileContents('build/docs/templates/template.hbs'),
		headerPartial: fileContents('build/docs/templates/header.hbs'),
		// footerPartial: fileContents('build/docs/templates/footer.hbs'),
		commitPartial: '* {{header}}\n',
	},
};
