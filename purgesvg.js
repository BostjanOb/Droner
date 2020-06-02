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
      'check-circle',
      'play-circle',
      'id-card'
    ],
    'brands.svg': [
      'git-alt'
    ],
    'solid.svg': [
      'cog',
      'hourglass-start',
      'hourglass-half',
      'hourglass-end',
      'exclamation-circle',
      'save',
      'sync',
      'pencil-alt',
      'times',
      'user'
    ]
  }
}
