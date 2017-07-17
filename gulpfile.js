const elixir = require('laravel-elixir');
require('laravel-elixir-vue-2');
//elixir.config.sourcemaps = false;


elixir(mix => {
    mix.less('styles.less','public/css')
       .webpack('app.js','public/js');
});
