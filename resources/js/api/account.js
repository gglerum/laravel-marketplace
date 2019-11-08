import axios from 'axios';

export default {
	postAdvert(cb, data){
		const promise = axios.post('/api/auctions', data)/*this.options.weblogApi.categories*/
	    return promise.then(response => {
	      cb(response.data);
	    }) 
	}
}