const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const path = require('path');

const mode = process.env.NODE_ENV || 'development';
const prod = mode === 'production';

module.exports = {
    entry: {
        campaign: ['./src/campaign/main.js'],
        template_1 : ['./src/template_1/main.js']
    },
    resolve: {
        alias: {
            svelte: path.resolve('node_modules', 'svelte'),
            '@app' : path.resolve('.','src')
        },
        extensions: ['.mjs', '.js', '.svelte'],
        mainFields: ['svelte', 'browser', 'module', 'main']
    },
    output: {
        path: __dirname + '/public/dist',
        filename: '[name].js',
        chunkFilename: '[name].[id].js'
    },
    module: {
        rules: [
            {
                test: /\.svelte$/,
                use: {
                    loader: 'svelte-loader',
                    options: {
                        emitCss: true,
                        hotReload: true
                    }
                }
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [
                    'style-loader',
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'postcss-loader',
                        options: {
                            // `postcssOptions` is needed for postcss 8.x;
                            // if you use postcss 7.x skip the key
                            postcssOptions: {
                              // postcss plugins, can be exported to postcss.config.js
                              plugins: function () {
                                return [
                                  require('autoprefixer')
                                ];
                              }
                            }
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            sassOptions: {
                                includePaths: [
                                    './src/material-ui-theme',
                                    './node_modules'
                                ]
                            }
                        }
                    }
                ]
            }
        ]
    },
    mode,
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
            chunkFilename: '[name].[id].css'
        })
    ],
    devtool: prod ? false: 'source-map',
    watchOptions: {
        poll: true,
        ignored: /node_modules/
    }
};