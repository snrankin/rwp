module.exports = {
	extends: ['stylelint-config-standard-scss', 'stylelint-config-prettier'],
	rules: {
		'no-empty-source': null,
		'string-quotes': 'single',
		'at-rule-no-unknown': null,
		'at-rule-empty-line-before': null,
		'property-no-unknown': null,
		'no-descending-specificity': null,
		'declaration-colon-newline-after': null,
		'font-family-no-missing-generic-family-keyword': null,
		'selector-class-pattern': null,
		'custom-property-pattern': null,
		'scss/no-global-function-names': null,
	},
	overrides: [
		{
			files: ['**/*.scss'],
			customSyntax: 'postcss-scss',
		},
	],
};
