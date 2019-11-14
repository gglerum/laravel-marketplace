<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        window.onload = function(){
            var stripe = Stripe('pk_test_QCKW2NB4AEqYXTh4QLsiHkO200DlyBPcOL');

            var elements = stripe.elements();
            var cardElement = elements.create('card');
            cardElement.mount('#card-element');

            var cardButton = document.getElementById('card-button');

            cardButton.addEventListener('click', function(ev) {
              ev.preventDefault();
              var clientSecret = cardButton.dataset.secret;
              var cardholderName = document.getElementById('cardholder-name');

              stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                  card: cardElement,
                  billing_details: {name: cardholderName.value},
                }
              }).then(function(result) {
                if (result.error) {
                  // Display error.message in your UI.
                  
                } else {
                  // The payment has succeeded. Display a success message.
                }
                console.log(result);
              });
            });
        }
    </script>
</head>
<body>
    <div id="app" style="width: 400px; margin: 100px auto;">
        <form>
            <input id="cardholder-name" type="text">
            <!-- placeholder for Elements -->
            <div id="card-element"></div>
            <button id="card-button" data-secret="{{$client_secret}}">
              Submit Payment
            </button>
        </form>
    </div>
</body>