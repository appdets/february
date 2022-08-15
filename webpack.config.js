const path = require("path");

const { VueLoaderPlugin } = require("vue-loader");
const production = 0;

module.exports = {
  entry: "./src/js/index.js",
  output: {
    filename: "february.min.js",
    path: path.resolve(__dirname, "./february/"),
  },
  mode: production ? "production" : "development",
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        loader: "babel-loader",
      },
      {
        test: /\.vue$/,
        loader: "vue-loader",
      },
    ],
  },
  resolve: {
    alias: {
      vue$: "vue/dist/vue.esm-bundler.js",
    },
  },
  plugins: [new VueLoaderPlugin()],
};
