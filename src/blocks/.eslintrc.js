module.exports = {
    env: {
        browser: true,
        es2021: true,
    },
    extends: ['plugin:@wordpress/eslint-plugin/recommended'],
    globals: {
        wp: true,
        wpApiSettings: true,
        window: true,
        document: true,
        _: true,
    },
    parser: '@babel/eslint-parser',
    ignorePatterns: ['global/*'],
    parserOptions: {
        ecmaFeatures: {
            jsx: true,
        },
        babelOptions: {
            presets: ['@babel/preset-react'],
            plugins: ['@babel/plugin-syntax-jsx'],
        },
        requireConfigFile: false,
        ecmaVersion: 'latest',
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
    plugins: ['react', '@typescript-eslint'],
};
