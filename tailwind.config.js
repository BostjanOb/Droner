const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  purge: {
    content: ['./resources/**/*.php'],
    options: {
      whitelist: [
        'w-3',
        'w-4',
        'w-5',
        'w-6',

        'h-3',
        'h-4',
        'h-5',
        'h-6'
      ]
    }
  },
  theme: {
    container: {
      center: true
    },
    extend: {
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans]
      }
    }
  },
  variants: {},
  plugins: [
    require('@tailwindcss/ui')
  ]
}
