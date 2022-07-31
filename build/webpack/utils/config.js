/** ============================================================================
 * config
 *
 * @version   1.0.0
 * @author    Sam Rankin <srankin@riester.com>
 * @copyright 2022 RIESTER
 * ========================================================================== */

// ======================= Import Vendor Dependencies ======================= //
const _ = require('lodash');
const path = require('path');
const { argv } = require('yargs');
const { merge } = require('webpack-merge');
const StyleLintPlugin = require('stylelint-webpack-plugin');
const ESLintPlugin = require('eslint-webpack-plugin');
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts');
const ExtractCssChunks = require('mini-css-extract-plugin');
const CleanupMiniCssExtractPlugin = require('cleanup-mini-css-extract-plugin');
const magicImporter = require('node-sass-magic-importer');
const { WebpackManifestPlugin } = require('webpack-manifest-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const WebpackBuildNotifierPlugin = require('webpack-build-notifier');
const FriendlyErrorsPlugin = require('@soda/friendly-errors-webpack-plugin');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

// ======================== Import Local Dependencies ======================= //
const { isEmpty, env, manifest, filePaths, fileNames, pathByType, copyPath } = require('./utils');

const configFile = require('../../../config.json');

// =========================== Setup File Globals =========================== //

const folders = _.get(configFile, 'folders', {});
const useCache = !isEmpty(argv.cache);
const groupName = !isEmpty(argv.name) ? argv.name : '';
const buildWatch = !isEmpty(argv.watch);
const configName = !isEmpty(argv['config-name']) ? argv['config-name'] : '';
const isProduction = env() === 'production';
const jsDist = _.replace(filePaths.js.dist, filePaths.dist + '/', '');
const imagesDist = _.replace(filePaths.images.dist, filePaths.dist + '/', '');
const fontsDist = _.replace(filePaths.fonts.dist, filePaths.dist + '/', '');
const cssDist = _.replace(filePaths.css.dist, filePaths.dist + '/', '');
const buildGroup = !isEmpty(groupName) ? groupName : 'Build';
const buildType = !isEmpty(configName) ? `: ${configName}` : '';
const buildName = `${buildGroup}${buildType} - ${env()}`;
const shouldAnalyze = !isEmpty(argv.profile);
const serverUp = !isEmpty(argv.serve);
const isHot = !isEmpty(argv.hot);

let buildStats = {
    preset: !isEmpty(argv.stats) ? argv.stats : 'errors-only',
    colors: true,
    excludeAssets: ['**/*.map'],
    hash: false,
    version: false,
    timings: false,
    children: false,
    errors: false,
    errorDetails: false,
    errorStack: false,
    warnings: false,
    chunks: false,
    modules: false,
    reasons: false,
    source: false,
    moduleTrace: false,
    publicPath: false,
};

if (argv.stats === 'verbose') {
    buildStats = {
        preset: 'verbose',
        colors: true,
        builtAt: false,
        excludeAssets: ['**/*.map'],
        hash: false,
        version: false,
        env: true,
        timings: false,
        children: true,
        errors: true,
        errorDetails: 'auto',
        errorStack: true,
        warnings: true,
        chunks: true,
        modules: true,
        logging: true,
        cachedModules: true,
        reasons: true,
        moduleAssets: false,
        source: false,
        moduleTrace: true,
        publicPath: false,
    };
}
function createConfig() {
    const entryFiles = fileNames(groupName, configName, configFile.entry);

    let customConfig = {};
    if (_.isString(groupName) && groupName !== '' && _.has(configFile.entry, groupName)) {
        customConfig = configFile.entry[groupName];
        customConfig = _.omit(customConfig, 'files');
    }
    _.defaultsDeep(customConfig, configFile);
    const fileprefix = !_.isUndefined(customConfig.fileprefix) ? customConfig.fileprefix : '';
    customConfig.paths = filePaths;

    let filenameTemplate = customConfig.enabled.cachebusting ? `${fileprefix}${customConfig.cachebusting}` : `${fileprefix}[name]`;

    if (isProduction) {
        filenameTemplate = filenameTemplate + '.min';
    }

    const assetnameTemplate = customConfig.enabled.cachebusting ? `[path]${customConfig.cachebusting}[ext][query]` : '[path][name][ext][query]';

    let newConfig = {
        webpack: {
            mode: env(),
            entry: entryFiles,
            cache: useCache
                ? {
                      type: 'filesystem',
                      cacheDirectory: path.join(filePaths.root, '.cache'),
                  }
                : false,
            context: filePaths.src || filePaths.root,
            stats: buildStats,
            output: {
                path: filePaths.dist,
                publicPath: filePaths.public,
                filename: `${jsDist}/${filenameTemplate}.js`,
                assetModuleFilename: assetnameTemplate,
                chunkFilename: '[name].js',
            },
            watchOptions: {
                ignored: [filePaths.dist, path.join(filePaths.root, 'node_modules')],
            },
            optimization: {
                nodeEnv: env(),
                mangleExports: isProduction,
                minimize: true,
                minimizer: [
                    new TerserPlugin({
                        test: /\.js(\?.*)?$/i,
                        terserOptions: {
                            format: {
                                comments: false,
                                ecma: 2017,
                                beautify: !isProduction,
                            },
                            ecma: 2017,
                            safari10: true,
                            mangle: isProduction,
                            compress: isProduction,
                            sourceMap: !isProduction,
                        },
                        parallel: true,
                        extractComments: false,
                    }),
                ],
                providedExports: true,
                splitChunks: {
                    maxInitialRequests: Infinity,
                    minSize: 0,
                    hidePathInfo: true,
                    chunks: 'all',
                    automaticNameDelimiter: '-',
                    filename: path.join(folders.js, `${filenameTemplate}.js`),
                    cacheGroups: {
                        defaultVendors: false,
                        default: false,
                        vendors: {
                            test: /[\\/]node_modules[\\/]/,
                            layer: 'vendors',
                            chunks: 'all',
                            idHint: 'vendors',
                            name: 'vendors',
                            priority: -5,
                        },
                    },
                },
            },
            node: {
                __filename: true,
                __dirname: true,
            },
            infrastructureLogging: {
                level: 'warn',
            },
            ignoreWarnings: [
                {
                    module: /sass-loader\/dist\/cjs\.js/, // A RegExp
                },
            ],
            externals: {
                jquery: 'jQuery',
            },
        },

        filename: filenameTemplate,
        assetname: assetnameTemplate,
        prefix: fileprefix,
        notify: {
            appName: configFile.app.name,
            buildSuccessful: true,
            suppressSuccess: 'initial',
            logo: filePaths.favicon,
            activateTerminalOnError: false,
            messageFormatter: (error) => {
                const type = _.get(error, 'error.name', '');
                let message = _.get(error, 'error.message', '');

                if ('SassError' === type) {
                    let file = _.get(error, 'error.originalSassError.file', '');
                    const line = _.get(error, 'error.originalSassError.line', '');
                    file = path.relative(process.cwd(), file);
                    message = `Error in ${file}:${line}`;
                }
                return message;
            },
            onClick: (notifier, options) => {
                let file = _.get(options, 'message', '');
                file = file.replace(/^Error\sin\s/, '');
                file = path.join(process.cwd(), file);
                file = `code -g ${file}`;

                const childProcess = require('child_process');
                childProcess.exec(file);
            },
        },
    };

    if (!isProduction) {
        newConfig.webpack.devtool = 'source-map';
    } else if (serverUp) {
        newConfig.webpack.devtool = 'inline-source-map';
    }

    newConfig = _.defaultsDeep(newConfig, customConfig);

    if (!isEmpty(configName) && _.isString(configName) && configName !== '') {
        newConfig = _.merge({ webpack: { name: configName } }, newConfig);
    }

    return newConfig;
}

const config = createConfig();

exports.folders = folders;
exports.useCache = useCache;
exports.groupName = groupName;
exports.buildWatch = buildWatch;
exports.configName = configName;
exports.isProduction = isProduction;
exports.jsDist = jsDist;
exports.imagesDist = imagesDist;
exports.fontsDist = fontsDist;
exports.cssDist = cssDist;
exports.buildGroup = buildGroup;
exports.buildType = buildType;
exports.buildName = buildName;
exports.config = config;
exports.serverUp = serverUp;
exports.isHot = isHot;

const cssLoaders = [
    {
        loader: ExtractCssChunks.loader,
        options: {
            publicPath: filePaths.public,
        },
    },
    {
        loader: 'css-loader',
        options: {
            sourceMap: !isProduction,
            importLoaders: 2,
            url: false,
        },
    },
    {
        loader: 'postcss-loader',
        options: {
            sourceMap: !isProduction,
            postcssOptions: {
                plugins: [
                    'postcss-fixes',
                    'postcss-momentum-scrolling',
                    'postcss-easings',

                    [
                        'postcss-inline-svg',
                        {
                            paths: [filePaths.images.src, path.join(filePaths.node, 'bootstrap-icons', 'icons')],
                        },
                    ],
                    [
                        'postcss-url',
                        [
                            {
                                filter: /\.(png|jpg|jpeg|gif|ico)$/,
                                url: (asset) => {
                                    const filename = path.basename(asset.relativePath);

                                    const imagePath = path.join(filePaths.images.dist, filename);
                                    const url = path.relative(filePaths.css.dist, imagePath);

                                    return url;
                                },
                                from: filePaths.css.src,
                                to: filePaths.images.dist,
                                assetsPath: folders.images,
                                basePath: filePaths.images.src,
                            },
                            {
                                filter: /\.(woff|woff2|eot|ttf|otf)$/,
                                url: (asset) => {
                                    const filename = path.basename(asset.relativePath);

                                    const fontPath = path.join(filePaths.fonts.dist, filename);
                                    const url = path.relative(filePaths.css.dist, fontPath);
                                    return url;
                                },
                                from: filePaths.css.src,
                                to: filePaths.fonts.dist,
                                assetsPath: folders.fonts,
                                basePath: filePaths.fonts.src,
                            },
                        ],
                    ],
                    [
                        'postcss-sort-media-queries',
                        {
                            configuration: {
                                unitlessMqAlwaysFirst: true,
                            },
                        },
                    ],
                    'autoprefixer',
                    isProduction
                        ? [
                              'cssnano',
                              {
                                  preset: [
                                      'default',
                                      {
                                          discardComments: {
                                              removeAll: true,
                                          },
                                      },
                                  ],
                              },
                          ]
                        : [
                              'cssnano',
                              {
                                  preset: [
                                      'lite',
                                      {
                                          normalizeWhitespace: false,
                                          mergeRules: true,
                                      },
                                  ],
                              },
                          ],
                ],
            },
        },
    },
];

exports.cssLoaders = cssLoaders;

const jsLoaders = [
    {
        enforce: 'pre',
        test: /\.(j|t)sx?$/,
        loader: 'import-glob-loader',
    },
];

exports.jsLoaders = jsLoaders;

let webpackConfig = {
    module: {
        rules: [
            ...jsLoaders,
            {
                test: /\.(sc|sa|j|cs)s$/,
                enforce: 'pre',
                use: ['source-map-loader'],
            },
            {
                test: /\.css$/,
                use: cssLoaders,
            },
            {
                test: /\.(sc|sa)ss$/,
                use: [
                    ...cssLoaders,
                    {
                        loader: 'sass-loader',
                        options: {
                            sourceMap: true, // required for resolve-url-loader
                            sassOptions: {
                                includePaths: [filePaths.node, filePaths.css.src],
                                outputStyle: 'expanded',
                                indentWidth: 4,
                                fiber: false,
                                importer: magicImporter(),
                            },
                        },
                    },
                ],
            },
            {
                test: /\.(woff|woff2|eot|ttf|otf)$/i,
                type: 'asset/resource',
                generator: {
                    filename: path.join(fontsDist, config.assetname),
                },
            },
            {
                test: /\.(png|svg|jpg|jpeg|gif|ico)$/i,
                type: 'asset/resource',
                generator: {
                    filename: path.join(imagesDist, config.assetname),
                },
            },
        ],
    },
    resolve: {
        modules: [filePaths.node, filePaths.src],
        enforceExtension: false,
    },
};

webpackConfig = merge(config.webpack, webpackConfig);

if (isProduction) {
    const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');
    webpackConfig = merge(webpackConfig, {
        optimization: {
            minimize: true,
            minimizer: [
                '...',
                new ImageMinimizerPlugin({
                    minimizer: {
                        implementation: ImageMinimizerPlugin.squooshMinify,
                    },
                }),
            ],
        },
    });
}

exports.baseConfig = webpackConfig;

const startingPlugins = [
    new ESLintPlugin({
        failOnWarning: false,
        emitError: !isProduction,
        emitWarning: !isProduction,
        formatter: require('eslint-formatter-pretty'),
        fix: true,
    }),
    new StyleLintPlugin({
        failOnWarning: false,
        failOnError: !buildWatch,
        emitError: !isProduction && !buildWatch,
        emitWarning: !isProduction && !buildWatch,
        formatter: require('stylelint-formatter-pretty'),
        lintDirtyModulesOnly: true,
        fix: !buildWatch,
        quiet: buildWatch,
    }),
    new RemoveEmptyScriptsPlugin({ verbose: !isProduction }),
    new ExtractCssChunks({
        filename: `${folders.css}/${config.filename}.css`,
    }),
    new CleanupMiniCssExtractPlugin(),
];

if (shouldAnalyze) {
    startingPlugins.unshift(
        new BundleAnalyzerPlugin({
            analyzerMode: 'static',
            reportTitle: buildName,
            excludeAssets: [/\.map$/],
        })
    );
}

exports.startingPlugins = startingPlugins;

const endingPlugins = [
    new WebpackManifestPlugin({
        fileName: filePaths.manifest,
        basePath: '',
        publicPath: '',
        map: (file) => {
            let fileName = !isEmpty(file.name) ? file.name : file.path;
            const ext = path.extname(fileName);
            fileName = path.basename(fileName.replace(/\?.*/gm, ''), ext);
            if (isProduction) {
                fileName = fileName + '.min';
            }
            fileName = fileName + ext;
            file.name = fileName;
            return file;
        },
        filter: (file) => {
            let fileName = !isEmpty(file.name) ? file.name : file.path;
            fileName = path.basename(fileName.replace(/\?.*/gm, ''));
            const pattern = /\.(map)$/i;
            return pattern.test(fileName) !== true;
        },
        seed: manifest,
        removeKeyHash: true,
    }),
];

if (argv.stats !== 'verbose') {
    endingPlugins.push(new FriendlyErrorsPlugin());
}
endingPlugins.push(new WebpackBuildNotifierPlugin(config.notify));

if (!isEmpty(config.copy)) {
    const CopyPlugin = require('copy-webpack-plugin');
    const copyPatterns = [];

    if (_.isArray(config.copy)) {
        _.each(config.copy, function (pattern) {
            if (_.isString(pattern)) {
                if (_.startsWith(pattern, '~')) {
                    pattern = pattern.replace('~', '');
                    pattern = copyPath(pattern);
                    // pattern = './' + path.relative(filePaths.node, pattern);
                    const name = path.basename(pattern);
                    let dest = path.dirname(pathByType(name)) + '/[name][ext]';
                    dest = path.join(filePaths.assets, dest);
                    dest = path.relative(filePaths.node, dest);
                    pattern = {
                        from: pattern,
                        to: dest,
                        context: filePaths.node,
                    };
                } else {
                    pattern = {
                        from: pattern,
                        to: filePaths.assets,
                    };
                }
            } else if (_.isPlainObject(pattern)) {
                let from = _.get(pattern, 'from');
                let dest = _.get(pattern, 'to');

                if (_.startsWith(from, '~')) {
                    from = from.replace('~', '');
                    from = copyPath(from);
                    // from = './' + path.relative(filePaths.node, from);
                    const name = path.basename(from);
                    if (isEmpty(dest)) {
                        dest = path.join(path.dirname(pathByType(name)), dest, '[name][ext]');
                        dest = path.join(filePaths.assets, dest);
                        dest = path.relative(filePaths.node, dest);
                    }
                    pattern.context = filePaths.node;
                }
                pattern.from = from;
                pattern.to = dest;
            }
            _.defaultsDeep(pattern, {
                noErrorOnMissing: true,
                globOptions: {
                    gitignore: true,
                },
                transform: {
                    cache: true,
                },
            });
            copyPatterns.push(pattern);
        });
    }
    endingPlugins.unshift(
        new CopyPlugin({
            patterns: config.copy,
            options: {
                concurrency: 100,
            },
        })
    );
}

exports.endingPlugins = endingPlugins;
