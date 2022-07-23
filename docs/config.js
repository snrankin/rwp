const fs = require('fs');
const path = require('path');

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

module.exports = {
	linkReferences: false,
	linkCompare: false,
	parserOpts: {
		linkReferences: false,
		linkCompare: false,
	},
	writerOpts: {
		groupBy: false,

		mainTemplate: fileContents('docs/templates/template.hbs'),
		headerPartial: fileContents('docs/templates/header.hbs'),
		footerPartial: fileContents('docs/templates/footer.hbs'),
		commitPartial: fileContents('docs/templates/commit.hbs'),
	},
};
