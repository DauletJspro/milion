require('./bootstrap');

window.Vue = require('vue');

import App from './components/App';
import axios from 'axios';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import {routes} from './routes';


Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app_table',
    router: router,
    render: h => h(App),
});
