<template>
	<div class="container">
		<rubric v-if="showRubric"></rubric>
		<advert v-else></advert>
	</div>
</template>

<script>
import rubric from './rubric.vue'
import advert from './advert.vue'

export default {
	components: {
		rubric,
		advert
	},
	data(){
		return {
			showRubric: true,
			itemId: null
		};
	},
	beforeRouteEnter: (to, from, next) => {
		let item = to.path.match(/([a-z](?:[0-9]+))\/(?:[a-z0-9\-]+)$/)[1];
				
		next(vm =>{
			vm[item[0] == 'r' ? 'getRubric' : 'getAdvert']( item.substring(1) );
			vm.showRubric = item[0] == 'r';
		});
	},
	methods: {
		getRubric(id){
			this.$store.dispatch('rubrics/get', id);
		},
		getAdvert(id){
			this.$store.dispatch('adverts/get', id);
		}
	}
}
</script>