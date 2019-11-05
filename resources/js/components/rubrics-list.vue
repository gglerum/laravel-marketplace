<template>
	<div class="container pt-3">
		<template v-for="rubric in rubrics">
			<b-card :key="rubric.id" :title="rubric.title">
				<b-card-text>{{rubric.description}}</b-card-text>
				<b-list-group>
					<b-list-group-item v-for="sub in rubric.children">{{sub.title}}</b-list-group-item>
				</b-list-group>
			</b-card>
		</template>
	</div>
</template>
<script>
import { mapState } from 'vuex'

export default {
	computed: mapState({
		rubrics: state => state.rubrics.top
	}),
	data(){
		return {}
	},
	created(){
		this.$store.dispatch('rubrics/getTop')
	}
}
</script>