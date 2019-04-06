/**
 * The Path module.
 */
const path = require('path');
/**
 * Custom Webpack config.
 */
module.exports = {
  resolve: {
    extensions: ['*', '.js', '.jsx'],
    alias: {
      // An alias for the JS imports.
      '@js': path.resolve(__dirname, './resources/js'),
      // An alias for the SASS imports.
      '@sass': path.resolve(__dirname, './resources/sass'),
    }
  }
};