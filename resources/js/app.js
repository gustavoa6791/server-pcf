require('./bootstrap')

window.Vue = require('vue')

import Vue from 'vue'
import Vuetify from 'vuetify' 
import store from './store/index'
import router from './router' 

Vue.use(Vuetify);


Vue.component('pacific-app', require('./views/App.vue').default)

const app = new Vue({
    vuetify: new Vuetify(),
    el: '#app',
    store,
    router,
});