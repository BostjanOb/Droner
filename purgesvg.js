module.exports = {
  content: [
    './resources/views/layouts/app.blade.php'
  ],
  svgs: [
    {
      in: './node_modules/@fortawesome/fontawesome-free/sprites/*.svg',
      out: './public/fa.svg'
    }

  ],
  whitelist: {
    'regular.svg': [
      'check-circle'
    ],
    'brands.svg': [
      'git-alt'
    ],
    'solid.svg': [
      'cog',
      'hourglass-half',
      'exclamation-circle',
      'save',
      'sync',
      'pencil-alt',
      'times'
    ]
  }
}
