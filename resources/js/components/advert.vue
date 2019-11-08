<template>
	<b-container v-if="advert" class="pt-4">
		<b-row class="justify-content-md-center">
			<b-col cols="8">
				<b-card :title="advert.title" class="mb-4">
					<p><strong>Vraag prijs: <em>€ {{advert.price}}</em></strong></p>
					<p><strong>{{advert.description}}</strong></p>
					<b-card-text>{{advert.text}}</b-card-text>
				</b-card>
			</b-col>
			<b-col cols="4">
				<b-card header="Contactgegevens" class="mb-4">
					{{advert.user.name}}
					<address>
						<strong>Adres</strong><br />
						{{advert.postal_code}}
					</address>
				</b-card>
				<b-card header="Biedingen" class="mb-4">
					<b-list-group>
						<b-list-group-item v-for="bid in advert.bids" :key="bid.id">
							<strong v-if="bid.user">{{bid.user.name}}</strong> <em>€ {{bid.amount}}</em>
						</b-list-group-item>
					</b-list-group>
					<b-form id="bid-form" @submit="postBid">
						<b-form-group
					        label="Bod uitbrengen:"
					        label-for="bid"
					        description="Adverteerder kan ten alle tijden het bod afwijzen."
					      >
					        <b-form-input class="lg-10" id="bid" name="bid" type="number" required placeholder="10"></b-form-input>
					        <b-button class="lg-2" type="submit" variant="primary">Bied</b-button>
      					</b-form-group>
					</b-form>
				</b-card>
			</b-col>
		</b-row>
	</b-container>
</template>
<script>
import { mapState } from 'vuex'

export default {
	computed: mapState({
		advert: state => state.adverts.current
	}),
	methods: {
		postBid(e){
			e.preventDefault();
			this.$store.dispatch('adverts/bid', {id: this.advert.id, data: new FormData(document.getElementById('bid-form'))})
		}
	}
}
</script>