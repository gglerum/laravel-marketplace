<template>
  <div class="container mt-4">
  	<b-card @submit="placeAdvert">
		<b-form id="advert-form">
		<strong>Advertentiegegevens</strong>
	      <b-form-group
	        label="Titel:"
	        label-for="advert-title"
	        description="Bedenk een titel die direct duidelijk maakt wat je verkoopt."
	      >
	        <b-form-input
	          id="advert-title"
	          name="title"
	          type="text"
	          required
	          placeholder="Advertentie titel"
	        ></b-form-input>
	      </b-form-group>

	      <b-form-group
	        label="Omschrijving"
	        label-for="advert-description"
	        description="Vat in één zin samen waar het aanbod uit bestaat."
	      >
	        <b-textarea
	          id="advert-description"
	          name="description"
	          required
	          placeholder="Advertentie omschrijving"
	        ></b-textarea>
	      </b-form-group>

	      <b-form-group
	        label="Text:"
	        label-for="advert-text"
	        description="Voorkom misverstanden door zo volledig mogelijk te zijn."
	      >
	        <b-textarea
	          id="advert-text"
	          name="text"
	          required
	          placeholder="Advertentie text"
	        ></b-textarea>
	      </b-form-group>

	      <b-form-group
	        label="Vraagprijs:"
	        label-for="advert-price"
	        description="Wat wil je voor jouw aanbod ontvangen?."
	      >
	        <b-form-input
	          id="advert-price"
	          name="price"
	          type="number"
	          required
	          placeholder="Geef een bedrag op"
	        ></b-form-input>
	      </b-form-group>

	      <hr />

	      <strong>Afwijkend afhaal/verzend adres</strong>

	      <b-form-group
	        label="Adres:"
	        label-for="advert-address"
	        description="Geef hier een afwijkend adres op."
	      >
	        <b-form-input
	          id="advert-address"
	          type="text"
	          name="address"
	          placeholder="Afwijkend adres"
	        ></b-form-input>
	      </b-form-group>

	      <b-form-group
	        label="Postcode:"
	        label-for="advert-postalcode"
	        description="We'll never share your email with anyone else."
	      >
	        <b-form-input
	          id="advert-postalcode"
	          type="text"
	          name="postal_code"
	          placeholder="Afwijkend postcode"
	        ></b-form-input>
	      </b-form-group>

	      <hr />

	      <b-button class="lg-2" type="submit" variant="primary">Plaats advertentie</b-button>
	      
	    </b-form>
	 </b-card>
  </div>
</template>

<script> 
export default {
	methods: {
		placeAdvert(e){
			e.preventDefault();
			this.$store.dispatch('account/post', new FormData(document.getElementById('advert-form')) );
		}
	}
}
</script>