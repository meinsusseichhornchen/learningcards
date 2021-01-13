module.exports = {
  purge: [],
  theme: {
    fontFamily: {
      'display': ['Metropolis-Regular'],
      'body' : ['Raleway']
    },
    extend: {
      colors: {
        white: '#FFFFFF',
        hiro: {
          ligthest: '#B0B0E3',
          lighter: '#1B1B4B',
          default: '#111130',
        },
        corn: '#ECE753',
        crayola: '#F9C784',
        eerie: '#161515',
        cultured: '#F0F0F0',
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
