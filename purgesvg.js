module.exports = {
  content: [
    './resources/views/layouts/app.blade.php'
  ],
  svgs: [
    {
      in: './node_modules/@fortawesome/fontawesome-free/sprites/*.svg',
      out: './resources/icons.svg'
    },
    {
      in: './resources/customIcons.svg',
      out: './resources/icons.svg'
    }

  ],
  whitelist: {
    'customIcons.svg': [
      'drone'
    ],
    'regular.svg': [
      'check-circle',
      'play-circle'
    ],
    'brands.svg': [
      'git-alt'
    ],
    'solid.svg': [
      'cog',
      'check',
      'chevron-left',
      'chevron-right',
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
