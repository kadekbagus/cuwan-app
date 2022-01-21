require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Vue from 'vue'
import Hello from './components/hello'
import Productlist from './components/productList'
import Productcreate from './components/productCreate'
import Productedit from './components/productEdit'

const app = new Vue({
    el: '#app',
    components: { Hello, Productlist, Productcreate, Productedit }
})

