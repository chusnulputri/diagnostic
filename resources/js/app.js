
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// import Vue from 'vue/dist/vue.js'
require('./bootstrap');

window.Vue        = require('vue/dist/vue.js');
window.Vuelidate  = require('vuelidate').default;
window.Timeago    = require('vue-timeago').default;
window.validator  =  require('vuelidate/dist/validators.min.js');
window.feather    = require('feather-icons');
window.moment     = require('moment');

Vue.use(feather)
Vue.use(Vuelidate);
Vue.use(Timeago, {
    name: 'Timeago', // Component name, `Timeago` by default
    locale: 'en', // Default locale
    // We use `date-fns` under the hood
    // So you can use all locales from it
    locales: {
      'zh-CN': require('date-fns/locale/zh_cn'),
      'id'   : require('date-fns/locale/id')
    }
  })

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/sample/sampleComponent.js').default);
Vue.component('vue-select', require('./components/select/select_custom.component.js').default);
Vue.component('vue-datepicker', require('./components/datepicker/datepicker.component.js').default);
Vue.component('vue-datatable', require('./components/datatable/datatable.component.js').default);
Vue.component('vue-inputmask', require('./components/inputmask/customInputmask.component.js').default);
Vue.component('vue-mask', require('./components/mask/mask.component.js').default);
Vue.component('vue-datepicker', require('./components/datepicker/datepicker.component.js').default);
Vue.component('vue-picker', require('./components/picker/picker.component.js').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */



