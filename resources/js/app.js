require('./bootstrap')

window.Vue = require('vue')

import Vue from 'vue'
import Vuetify from 'vuetify' 
import store from './store/index'
   

Vue.use(Vuetify);

Vue.component('table-pacific-actions', require('./components/TablePacificActions.vue').default)

const app = new Vue({
    vuetify: new Vuetify(),
    el: '#app',
    store
});