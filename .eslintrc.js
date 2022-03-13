module.exports = {
	root: true,
	extends: ['eslint:recommended', 'prettier'],
	ignorePatterns: ['assets/js/*.js', 'assets/src/js/vendor/modernizr.js', 'node_modules/**/*.js'],
	parser: '@babel/eslint-parser',
	globals: {
		rwp: true,
		document: true,
		fancybox: true,
		tns: true,
		select2: true,
		wp: true,
		wpApiSettings: true,
		_: true,
	},
	env: {
		es2017: true,
		amd: true,
		node: true,
		browser: true,
		jquery: true,
		mocha: true,
		commonjs: true,
	},
	parserOptions: {
		ecmaFeatures: {
			globalReturn: true,
			generators: false,
			objectLiteralDuplicateProperties: false,
			experimentalObjectRestSpread: true,
			jsx: true,
		},
		babelOptions: {
			presets: ['@babel/preset-react'],
		},
		jsx: true,
		requireConfigFile: false,
		ecmaVersion: 2017,
		allowImportExportEverywhere: true,
		sourceType: 'module',
	},
	settings: {
		'import/ignore': ['node_modules', '\\.(coffee|scss|css|less|hbs|svg|json)$'],
		react: {
			pragma: 'wp',
		},
	},
	rules: {
		quotes: ['error', 'single'],
		'no-async-promise-executor': 0,
		'no-dupe-else-if': 0,
		'no-import-assign': 0,
		'no-misleading-character-class': 0,
		'no-setter-return': 0,
		'no-useless-catch': 0,
		'no-unused-vars': 1,
		yoda: 0,
		'comma-dangle': [
			'error',
			{
				arrays: 'always-multiline',
				objects: 'always-multiline',
				imports: 'always-multiline',
				exports: 'always-multiline',
				functions: 'ignore',
			},
		],
	},
};
