import accountApi from '../../api/account'
import Vue from 'vue'

// initial state
const state = {
  adverts: []
}

// getters
const getters = {
 
}

// actions
const actions = {
  post({dispatch, commit, state, getters}, data){
    return new Promise((resolve, reject)=>{
      accountApi.postAdvert(adverts=>{
        commit('setAdverts', adverts);
        resolve();
      }, data);
    });
  }
}

// mutations
const mutations = {
  setAdverts (state, adverts) {
    state.adverts = adverts;
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}