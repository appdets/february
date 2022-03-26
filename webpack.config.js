const path = require("path"); 

const production = 1

module.exports = {
  entry: "./src/js/index.js",
  output: {
    filename: "february.min.js",
    path: path.resolve(__dirname, "./february/"),
  },
  mode: production ? "production" : "development",
 
};
