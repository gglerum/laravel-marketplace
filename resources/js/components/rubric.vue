<template>
	<div v-if="rubric" class="pt-4">
		<b-card :title="rubric.title" class="mb-4">
			<b-card-text>{{rubric.description}}</b-card-text>
		</b-card>
		<b-card class="mb-4">
			<b-card-title>Advertenties voor {{rubric.title}}</b-card-title>
			<b-list-group>
				<b-list-group-item v-for="auction in rubric.auctions" :key="auction.id">
					{{auction.title}}
				</b-list-group-item>
			</b-list-group>
		</b-card>
	</div>
</template>
<script>
import { mapState } from 'vuex'

export default {
	computed: mapState({
		rubric: state => state.rubrics.current
	}),
}
</script>