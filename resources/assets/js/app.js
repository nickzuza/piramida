// require('vue-resource');
require("babel-polyfill");

window.Vue = require('vue');



import VueLocalStorage from 'vue-localstorage';
window.Vue.use(VueLocalStorage);

// import VueResource from 'vue-resource';
// window.Vue.use(VueResource);
import VueViewports from 'vue-viewports'

window.Vue.use(VueViewports, { 320: 'mobile', 768: 'tablet', 1270: 'desktop' });

import VeeValidate from 'vee-validate';
window.Vue.use(VeeValidate);


// window.velocity = require('velocity-animate');

// import VueYouTubeEmbed from 'vue-youtube-embed'
// Vue.use(VueYouTubeEmbed)

window.$ = window.jQuery = require('jquery');

window.velocity = require('velocity-animate');

var loadTouchEvents = require('jquery-touch-events');
loadTouchEvents($);

require('viewport-units-buggyfill').init();

require('lightbox2');

require('slick-carousel');


require('./plugin');
require('./filial');
require('./home');
require('./product');
require('./cart');
require('./firstCat');
require('./userCab');
require('./contacts');
require('./catalog');
require('./favorits');
