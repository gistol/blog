import Vue from 'vue';
import Vuex from 'vuex';
import Router from 'vue-router';
import { sync } from 'vuex-router-sync';

import App from './App';
import VuexStore from './vuex-store';
import { routes } from './router-config';

Vue.use(Vuex);
Vue.use(Router);

const store = new Vuex.Store(VuexStore);

const router = new Router({routes, mode: 'history',});

sync(store, router);

// =====================================================================================================================

import VueAnalytics from 'vue-analytics'

Vue.use(VueAnalytics, {
    id: 'UA-47178876-8',
    router
});

// =====================================================================================================================

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faSpinner } from '@fortawesome/free-solid-svg-icons'
import { faCalendarAlt } from '@fortawesome/free-solid-svg-icons'
import { faEnvelope } from '@fortawesome/free-solid-svg-icons'
import { faGithub } from '@fortawesome/free-brands-svg-icons'
import { faLinkedin } from '@fortawesome/free-brands-svg-icons'
import { faTwitterSquare } from '@fortawesome/free-brands-svg-icons'

library.add(faSpinner);
library.add(faCalendarAlt);
library.add(faEnvelope);
library.add(faGithub);
library.add(faLinkedin);
library.add(faTwitterSquare);

Vue.component('font-awesome-icon', FontAwesomeIcon);

// =====================================================================================================================
// todo DOM Manipülasyonu yapılmamalı!

const hljs = require('highlight.js');

window.updatePostContent = () => {

    document.querySelectorAll('#post_content pre code').forEach(function(item) {
        hljs.highlightBlock(item);
    });

    document.querySelectorAll('#post_content table').forEach(function(item) {
        item.classList.add('table');
        item.classList.add('table-bordered');
    });

    document.querySelectorAll('#post_content h3, h4, h5').forEach(function(item) {
        item.classList.add('text-danger');
    });

    document.querySelectorAll('#post_content img').forEach(function(item) {
        item.classList.add('img-fluid');
    });
};

// =====================================================================================================================

new Vue({
    router,
    store,
    render: h => h(App),
}).$mount('#app');

// =====================================================================================================================

require('../css/main.scss');