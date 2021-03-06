require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Vue from 'vue'
import Productlist from './components/productList'
import Productcreate from './components/productCreate'
import Productedit from './components/productEdit'

import { config } from './config';

Vue.prototype.appConfig = config

const app = new Vue({
    el: '#app',
    components: { Productlist, Productcreate, Productedit }
})

