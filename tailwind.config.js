const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  purge: [
    './resources/**/*.blade.php',
     './resources/**/*.js',
     './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    screens: {
      'xs': '475px',
      ...defaultTheme.screens,
    },
    extend:{
      width: {
        '3/10': '30%',
      }
    }
  },
  variants: {
    extend: {
      fontSize: ['hover'],
    },
  },
  plugins: [],
}
