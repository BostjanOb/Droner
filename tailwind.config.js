module.exports = {
  purge: [
    './resources/**/*.php'
  ],
  theme: {
    container: {
      center: true
    },
    extend: {}
  },
  variants: {},
  plugins: [
    require('@tailwindcss/custom-forms')
  ]
}
