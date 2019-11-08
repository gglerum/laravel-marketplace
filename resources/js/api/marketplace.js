import axios from 'axios';

var _rubrics = []
var _rubric = null
var _advert = null
 
export default {
  // _fetchPosts(cb, category_id){
  //   const promise = axios.get(this.options.weblogApi.posts + '/' + category_id)
  //   return promise.then(response => {
  //     cb(response.data.data);
  //   }) 
  // },

  // getPosts (cb, category_id) {
  //     this._fetchPosts((_posts)=>cb(_posts, category_id), category_id);
  // },

  // getPost(cb, path) {
  //   const promise = axios.get(this.options.weblogApi.post + '?path=' + path)
  //   return promise.then(response => {
  //     cb(response.data);
  //   }) 
  // },

  getTopRubrics (cb) {
    const promise = axios.get('/api/rubrics')/*this.options.weblogApi.categories*/
    return promise.then(response => {
      _rubrics = response.data
      cb(_rubrics);
    }) 
  }, 

  getRubric(cb, id) {
    if(id){
      const promise = axios.get(`/api/rubrics/${id}`)
      return promise.then(response => {
        _rubric = response.data
        cb(_rubric);
      }) 
    }
  },

  getAdvert(cb, id) {
    if(id){
      const promise = axios.get(`/api/auctions/${id}`)
      return promise.then(response => {
        _advert = response.data
        cb(_advert);
      }) 
    }
  },

  postBid(cb, data){
      const promise = axios.post(
        `/api/auctions/${data.id}/bid`,
        data.data
      );
      return promise.then(response => {
        _advert = response.data
        cb(_advert);
      }) 
  }
}