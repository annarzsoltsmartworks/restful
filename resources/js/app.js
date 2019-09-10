import Vue from 'vue'
import VueRouter from 'vue-router'

window.Vue = require('vue');

Vue.use(VueRouter)

Vue.component('articles-list', require('./components/ArticlesComponent.vue').default);
Vue.component('books-list', require('./components/BooksComponent.vue').default);

import App from './views/App'
import Home from './views/Home'
import Books from './views/Books'

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    }, {
      path: '/books',
      name: 'books',
      component: Books
    },

  ],
});

const app = new Vue({
  el: '#app',
  components: {App},
  router
});
