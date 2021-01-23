require('./bootstrap');

require('moment');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';

import StoreVue from '../js/Store/index'

Vue.mixin({ methods: { route } });
Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
import Vuex from 'vuex'

import fillter from './filter'

Vue.use(Vuex)
const app = document.getElementById('app');

const store = new Vuex.Store(StoreVue)

 
import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)
  

new Vue({
    store,
    fillter,

    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
