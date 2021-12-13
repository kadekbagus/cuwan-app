require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Vue from 'vue'
import Hello from './components/hello'

const app = new Vue({
    el: '#app',
    components: { Hello }
})

