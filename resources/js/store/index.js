import Vue from 'vue'
import Vuex from 'vuex'
import rubrics from './modules/rubrics'
import adverts from './modules/adverts'
import account from './modules/account'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    rubrics,
    adverts,
    account
  },
  strict: debug
})