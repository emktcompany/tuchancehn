let mix = require('laravel-mix'),
  tailwindcss = require('tailwindcss'),
  _ = require('lodash');

Mix.listen('loading-rules', function (rules) {
  var index = _.findIndex(rules, (rule) => {
    return /\(\?\!font\)\./.test(rule.test.toString());
  }), regex;

  if (index >= 0) {
    regex = rules[index].test.source.replace("!font", "!font|svg");
    rules[index].test = new RegExp(regex);
  }
});

if (!mix.inProduction()) {
  mix.sourceMaps();
} else {
  mix.version();
}

mix.webpackConfig({
  output: {
    publicPath:    '/',
    chunkFilename: 'js/[name].js',
  }
});

mix.js('resources/assets/js/entry/client.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css')
  .browserSync(process.env.APP_URL || '127.0.0.1:8000', {https: true})
  .extract([
    'vue/dist/vue.runtime',
    'vue-carousel',
    'vue-the-mask',
    'vue2-collapse',
    // 'vue-wysiwyg',
    'v-tooltip',
    'vue-ripple-directive',
    'vue-click-outside',
    'vuejs-paginate',
    'vue-router',
    'vue-axios',
    'axios',
    'dayjs',
    'dayjs/locale/es',
    '@websanova/vue-auth',
    '@websanova/vue-auth/drivers/auth/bearer.js',
    '@websanova/vue-auth/drivers/http/axios.1.x.js',
    '@websanova/vue-auth/drivers/router/vue-router.2.x.js',
  ])
  .options({
    processCssUrls: false,
    postCss: [
      tailwindcss('resources/assets/js/tailwind.js'),
    ],
    vue: {
      transformToRequire: {
        'svg-icon': 'src',
        img:        'src',
        image:      'xlink:href'
      }
    }
  })
  .webpackConfig({
    resolve: {
      alias: {
        '@':      path.resolve(__dirname, 'resources/assets/js'),
        '@html':  path.resolve(__dirname, 'resources/assets/html'),
        '@css':   path.resolve(__dirname, 'resources/assets/css'),
        '@scss':  path.resolve(__dirname, 'resources/assets/sass'),
        '@fonts': path.resolve(__dirname, 'resources/assets/fonts'),
        '@svg':   path.resolve(__dirname, 'resources/assets/svg'),
        '@img':   path.resolve(__dirname, 'resources/assets/images')
      }
    },
    module: {
      rules: [
        {
          test:   /\.svg$/,
          loader: 'svg-inline-loader?removeSVGTagAttrs=false'
        }
      ]
    }
  });
