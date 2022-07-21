module.exports = {
  globals: {
    rwp: true,
    window: true,
    document: true,
    fancybox: true,
    tns: true,
    select2: true,
    _: true,
    Modernizr: true,
    hoverintent: true,
    bs: true,
    bootstrap: true
  },
  ignorePatterns: ['./assets/js/**/*.js', './src/blocks/**/*.js', './src/js/vendor/modernizr.js', './node_modules/**/*.js'],
  env: {
    browser: true,
    amd: true,
    node: true,
    jquery: true,
    commonjs: true,
    es2022: true
  },
  extends: ['eslint:recommended', 'standard', 'prettier'],
  parserOptions: {
    ecmaVersion: 'latest',
    sourceType: 'module',
    requireConfigFile: false,
    allowImportExportEverywhere: true
  },
  plugins: ['import'],
  settings: {
    'import/ignore': ['node_modules', '\\.(coffee|scss|css|less|hbs|svg|json)$']
  },
  rules: {
    'no-console': 0,
    quotes: ['error', 'single'],
    'no-async-promise-executor': 0,
    'no-dupe-else-if': 0,
    'no-import-assign': 0,
    'no-misleading-character-class': 0,
    'no-setter-return': 0,
    'no-useless-catch': 0,
    'no-unused-vars': 1,
    yoda: 0
  }
}