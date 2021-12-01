const path = require('path');
const CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    plugins: [
        new CopyWebpackPlugin(
            {
                patterns: [
                    { from: 'resources/images', to: 'images' }
                ]
            }
        ),
    ]
};
