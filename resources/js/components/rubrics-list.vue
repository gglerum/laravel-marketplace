<template>
	<div class="container pt-3">
		<template v-for="chunk in rubrics">	
			<b-card-group deck class="mb-4">
				<b-card v-for="rubric in chunk" :key="rubric.id" :title="rubric.title">
					<b-card-text>{{rubric.description}}</b-card-text>
					<template v-if="rubric.children.length">
						<p><strong>Rubrieken binnen {{rubric.title}}:</strong></p>
						<b-list-group class="mb-4">
							<b-list-group-item v-for="sub in rubric.children" :key="sub.id">
								<router-link :to="sub.path">{{sub.title}}</router-link>
							</b-list-group-item>
						</b-list-group>
					</template>
					<router-link :to="rubric.path">Bekijk advertenties in {{rubric.title}}</router-link>
				</b-card>
			</b-card-group>
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