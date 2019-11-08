import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import VueRouter from 'vue-router'

import App from './components/main.vue'
import store from './store'

import RubricsList from './components/rubrics-list.vue' 
import View from './components/view.vue' 
import Manage from './components/manage.vue'
import AdvertForm from './components/manage/advert-form.vue'
  
Vue.use(VueRouter);   
Vue.use(BootstrapVue);
   
const routes = [ 
	{ path: '/', component: RubricsList, name: 'rubrics' },
	{ path: '/account', component: Manage, children:
	[
		{path: '', component: AdvertForm}
	] },
	{ path: '/(.*)', component: View }
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
