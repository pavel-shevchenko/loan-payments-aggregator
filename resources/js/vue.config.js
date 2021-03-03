const dotenv = require('dotenv');
dotenv.config({ path: '../../.env' });

module.exports = {
  outputDir: '../../public',
  pages: {
    index: {
      entry: 'src/main.ts',
      template: 'src/html.template',
      filename: '../resources/views/mortgage_spa.blade.php',
      title: 'Mortgage aggregator'
    }
  },
  chainWebpack: config => {
    config.module
      .rule('graphql')
      .test(/\.(graphql|gql)$/)
      .use('graphql-tag/loader')
      .loader('graphql-tag/loader')
      .end()
  }
}
