import axios from 'axios';

var _rubrics = []
var _rubric = null
 
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

  getRubric(cb, path) {
    if(path){
      const promise = axios.get(this.options.weblogApi.categories + '?path=' + path)
      return promise.then(response => {
        _rubric = response.data
        cb(_rubric);
      }) 
    }
    //setTimeout(() => cb(_categories.find(category=>data.id&&category.id==data.id || data.path&&category.path==data.path)), 100)
  },
}