/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('es6-promise').polyfill();
require('formdata-polyfill');

window.Vue = require('vue');

import Vuex from 'vuex';
import Language from '../../vendor/mariuzzo/laravel-js-localization/lib/lang.min';

import Validator from '../js/mixins/validator';
import Modal from '../js/plugins/modal';
import translations from '../js/translations';

Vue.use(Vuex);

window.Lang = new Language({
    messages: translations,
});

/* Make lodash globally accessible from every Vue component */
Object.defineProperty(Vue.prototype, '$_', { value: _ });

Vue.filter('trans', (...args) => {
    return Lang.get(...args)
});

/*
* Make File API accessible inside Vue components (in this way we can use instanceof
* to check if a variable is an instance of File object)
*/
Vue.prototype.File = File;

Vue.prototype.$filesize = window.filesize;

/*
 * Make translation method globally accessible within the scripts of every Vue component.
 */
Vue.prototype.$trans = function(...args) {
    return Lang.get(...args)
};

/* Plugin for managing modal windows */
Vue.use(Modal);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Maps all the components made inside the /components folder.
const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import auth from './store/auth';
import card from './store/card';
import collection from './store/collection'
import game from './store/game';
import score from './store/score';
import tag from './store/tag';
import error from './store/error'

const store = new Vuex.Store({
    modules: {
        auth,
        game,
        score,
        tag,
        collection,
        card,
        error,
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store
});
