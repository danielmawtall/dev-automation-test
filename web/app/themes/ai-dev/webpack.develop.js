const webpack = require('webpack')
const { merge } = require('webpack-merge')
const path = require('path')
const common = require('./webpack.common.js')
const BrowserSyncPlugin = require('browser-sync-webpack-plugin')

const devHost = process.env.DOCKER_HOSTNAME || 'auto-build-test.ssl.localhost'
const sslDir = path.join(__dirname, 'local-ssl')

module.exports = merge(common, {
  mode: 'development',
  devtool: 'inline-source-map',
  module: {
    rules: [

    ],
  },
  plugins: [
    new BrowserSyncPlugin({
      host: 'localhost',
      port: 3000,
      https: {
        key: path.join(sslDir, 'server.key'),
        cert: path.join(sslDir, 'server.crt'),
      },
      proxy: {
        target: 'https://127.0.0.1',
        proxyOptions: {
          secure: false,
          headers: { Host: devHost },
        },
      },
      files: ['**/*.php'],
      cors: true,
      reloadDelay: 0,
      open: false,
    }),
  ],
})
