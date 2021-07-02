const mix = require('laravel-mix');
const homedir = require('os').homedir();

mix
  .js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css', [
    require('@tailwindcss/jit'),
  ])
  .copyDirectory('resources/images', 'public/images')
  .copyDirectory('resources/videos', 'public/videos')
  .copy('resources/favicons', 'public/');

if (! mix.inProduction()) {
  const domain = 'freeping.test';
  mix.browserSync({
    proxy: 'https://' + domain,
    host: domain,
    open: false,
    https: {
      key: homedir + '/.config/valet/Certificates/' + domain + '.key',
      cert: homedir + '/.config/valet/Certificates/' + domain + '.crt',
    },
  })
}

if (mix.inProduction()) {
  mix.version();
}
