module.exports = {
  purge: [],
  theme: {
    fontFamily: {
      'display': ['Mulish'],
      'body' : ['Raleway']
    },
    extend: {
      colors: {
        white: '#FFFFFF',
        taunt: {
          ligthest: '#B0B0E3',
          lighter: '#1B1B4B',
          default: '#3C5471',
        },
        clouds: '#CAC194',
        boognish: '#848482',
        shadow: '#24272A',
        neutral: '#DEDEDE',
        success: '#2AB881',
        failed: '#C60125',
      }
    },
  },
  variants: {},
  plugins: [
      require('autoprefixer')
  ],
}
