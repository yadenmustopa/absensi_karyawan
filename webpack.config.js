const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const path = require('path');

const mode = process.env.NODE_ENV || 'development';
const prod = mode === 'production';

module.exports = {
    entry: {
        home: ['./src/home/main.js'],
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
                test: /\.css$/,
                use: [
                  (mode === 'development' ? 'style-loader' : {
                    loader: MiniCssExtractPlugin.loader,
                    options: {
                      publicPath: '../'
                    }
                  }),
                  'css-loader',
                  'postcss-loader',
                ],
              },
              {
                test: /\.styl(us)?$/,
                use: [
                  (mode === 'development' ? 'style-loader' : {
                    loader: MiniCssExtractPlugin.loader,
                    options: {
                      publicPath: '../'
                    }
                  }),
                  'css-loader',
                  'postcss-loader',
                  'stylus-loader',
                ],
              },
              {
                test: /\.less$/,
                use: [
                  (mode === 'development' ? 'style-loader' : {
                    loader: MiniCssExtractPlugin.loader,
                    options: {
                      publicPath: '../'
                    }
                  }),
                  'css-loader',
                  'postcss-loader',
                  'less-loader',
                ],
              },
              {
                test: /\.(sa|sc)ss$/,
                use: [
                  (mode === 'development' ? 'style-loader' : {
                    loader: MiniCssExtractPlugin.loader,
                    options: {
                      publicPath: '../'
                    }
                  }),
                  'css-loader',
                  'postcss-loader',
                  'sass-loader',
                ],
              },
              {
                test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
                loader: 'url-loader',
                options: {
                  limit: 10000,
                  name: 'images/[name].[ext]',
        
                },
              },
        ]
    },
    mode,
    plugins: [
        new MiniCssExtractPlugin({
            filename: '[name].css',
            chunkFilename: '[name].[id].css'
        }),
    ],
    devtool: prod ? false: 'source-map',
    watchOptions: {
        poll: true,
        ignored: /node_modules/
    }
};