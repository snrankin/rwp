module.exports = {
	extends: ['stylelint-config-standard-scss', 'stylelint-config-prettier'],
	rules: {
		'at-rule-empty-line-before': null,
		'at-rule-no-unknown': null,
		'color-function-notation': null,
		'custom-property-pattern': null,
		'declaration-colon-newline-after': null,
		'font-family-no-missing-generic-family-keyword': null,
		'no-descending-specificity': null,
		'no-empty-source': null,
		'property-no-unknown': null,
		'scss/at-extend-no-missing-placeholder': null,
		'scss/comment-no-empty': null,
		'scss/double-slash-comment-whitespace-inside': null,
		'scss/no-global-function-names': null,
		'scss/at-if-no-null': null,
		'scss/operator-no-unspaced': null,
		'selector-class-pattern': null,
		'string-quotes': 'single',
	},
	overrides: [
		{
			files: ['**/*.scss'],
			customSyntax: 'postcss-scss',
		},
	],
};
