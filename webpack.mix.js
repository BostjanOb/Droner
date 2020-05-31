const mix = require('laravel-mix')
require('laravel-mix-purge-svg');

mix.postCss('resources/css/app.css', 'public/css', [require('tailwindcss')])
  .purgeSvg()
  .version()
  .browserSync({
    proxy: 'droner.test'
  })
