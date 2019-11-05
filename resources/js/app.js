import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'

import App from './components/main.vue'
import store from './store'

import RubricsList from './components/rubrics-list.vue' 
  
Vue.use(VueRouter);   
Vue.use(BootstrapVue);

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const routes = [
	{ path: '/', component: RubricsList, name: 'rubrics' },
]    

const router = new VueRouter({
  routes: routes,
  base: '/'
}) 

const app = new Vue({
    el: '#app',
    store,
    router,
    render: h => h(App)
}); 
