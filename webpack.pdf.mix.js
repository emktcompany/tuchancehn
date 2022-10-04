let mix = require('laravel-mix'),
  tailwindcss = require('tailwindcss');

if (!mix.inProduction()) {
  mix.sourceMaps();
}

mix.sass('resources/assets/sass/pdf.scss', 'public/css')
  .browserSync(process.env.APP_URL || '127.0.0.1:8000')
  .options({
    processCssUrls: false,
    postCss: [
      tailwindcss('resources/assets/js/tailwind.pdf.js'),
    ]
  });
