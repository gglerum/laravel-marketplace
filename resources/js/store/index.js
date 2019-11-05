import Vue from 'vue'
import Vuex from 'vuex'
import rubrics from './modules/rubrics'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    rubrics,
  },
  strict: debug
})