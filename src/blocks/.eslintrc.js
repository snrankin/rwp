/**
 * ============================================================================
 * .eslintrc
 *
 * @package
 * @since     1.0.0
 * @version   1.0.0
 * @author    RIESTER <wordpress@riester.com>
 * @copyright 2022 RIESTER
 * ==========================================================================
 */

module.exports = {
	extends: ['plugin:@wordpress/eslint-plugin/recommended', 'prettier'],
	parser: '@babel/eslint-parser',
	ignorePatterns: ['global/*'],
	globals: {
		wp: true,
		wpApiSettings: true,
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
		//'no-unused-vars': 0,
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
