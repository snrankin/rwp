module.exports = {
    extends: ['stylelint-config-standard-scss', 'stylelint-config-prettier'],
    rules: {
        'alpha-value-notation': 'number',
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
        'scss/at-if-no-null': null,
        'scss/comment-no-empty': null,
        'scss/dollar-variable-empty-line-before': null,
        'scss/double-slash-comment-empty-line-before': null,
        'scss/double-slash-comment-whitespace-inside': null,
        'scss/no-global-function-names': null,
        'scss/operator-no-unspaced': null,
        'selector-class-pattern': null,
		'selector-not-notation': null,
        'string-quotes': 'single',
        'value-keyword-case': [
            'lower',
            {
                camelCaseSvgKeywords: true,
            },
        ],
    },
    overrides: [
        {
            files: ['/src/**/*.scss'],
            customSyntax: 'postcss-scss',
        },
    ],
};
