import marketplace from '../../api/marketplace'
import Vue from 'vue'

// initial state
const state = {
  all: [],
  top: [],
  current: null
}

// getters
const getters = {
  getById: (state) => (id) => {
    return state.all.find(rubric => rubric.id === id);
  },
  currentId: (state) => {
    return state.current ? state.current.id : false;
  }
}

// actions
const actions = {
  getTop ({ commit }) {
    marketplace.getTopRubrics(rubrics => {
      commit('setTopRubrics', rubrics)
    })
  },
  //get single rubric by id
  get({dispatch, commit, state, getters}, id){
    //check if rubrics are available, else retrieve single post
    return new Promise((resolve, reject)=>{
      marketplace.getRubric(rubric=>{
        commit('setRubric', rubric);
        resolve();
      }, id);
    });
  }
}

// mutations
const mutations = {
  setTopRubrics (state, rubrics) {
    state.top = rubrics
  },
  setRubric (state, rubric) {
    state.current = rubric;
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}