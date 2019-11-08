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
  //get single rubric by id
  get({dispatch, commit, state, getters}, id){
    //check if rubrics are available, else retrieve single post
    return new Promise((resolve, reject)=>{
      marketplace.getAdvert(advert=>{
        commit('setAdvert', advert);
        resolve();
      }, id);
    });
  },
  
  bid({dispatch, commit, state, getters}, data){
    return new Promise((resolve, reject)=>{
      marketplace.postBid(advert=>{
        commit('setAdvert', advert);
        resolve();
      }, data);
    });
  }
}

// mutations
const mutations = {
  setAdvert (state, advert) {
    state.current = advert;
  }
}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}