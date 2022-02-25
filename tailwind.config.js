const colors = require("tailwindcss/colors");

module.exports = {
  content: [ 
    "./february/menu-page.php", 
    "./src/js/*.js", 
  ],
  theme: {
    extend: {},
    colors: {
      transparent: "transparent",
      current: "currentColor",
      black: colors.black,
      white: colors.white,
      gray: colors.gray,
      slate: colors.slate,
      green: colors.emerald,
      sky: colors.sky,
      yellow: colors.yellow,
      red: colors.red,
      teal: colors.teal,
      // teal : 'white',
    },
  },
  plugins: [
    require("tailwindcss"),
    require('@tailwindcss/forms'),
    require('tailwind-scrollbar')
  ],
  important: true,
};
