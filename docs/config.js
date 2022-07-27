const fs = require('fs');
const path = require('path');
const config = require('conventional-changelog-conventionalcommits');
const fullPath = (filePath) => {
	return path.join(process.cwd(), filePath);
};
function fileContents(filePath = '') {
	filePath = fullPath(filePath);
	if (fs.existsSync(filePath)) {
		const file = fs.readFileSync(filePath);
		if (file) {
			return file.toString();
		}
	} else {
		console.error(`${filePath} does not exist`);
		return '';
	}
}

module.exports = config({
	commitUrlFormat: '{{host}}/{{owner}}/{{repository}}/commits/{{hash}}',
	compareUrlFormat: '{{host}}/{{owner}}/{{repository}}/compare/{{currentTag}}%0D{{previousTag}}#diff',
	issueUrlFormat: '{{host}}/{{owner}}/{{repository}}/issue/{{id}}',
	issuePrefixes: ['RWP-'],
	parserOpts: {
		issuePrefixes: ['RWP-'],
		mergePattern: "^Merge branch '([^']+)' of (.*)$", // eslint-disable-line
		mergeCorrespondence: ['branch', 'source'],
	},
	writerOpts: {
		ignoreReverted: true,
	},
});
