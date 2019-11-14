<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StripeController extends Controller
{
	function __createStripeAccount($user){
		\Stripe\Stripe::setApiKey('sk_test_KSAvjIYHGOEkDRaZ4g4hoFP600FUiJ2Gs0');

		$acct = \Stripe\Account::create([
		     'country' => 'NL',
		     'type' => 'custom',
		     'requested_capabilities' => ['card_payments', 'transfers'],
		     'tos_acceptance' => [
		      'date' => time(),
		      'ip' => $_SERVER['REMOTE_ADDR']
		    ],
		    "business_profile" => [
		      "url" => 'http://script.dev',
		      "mcc" => '5931'
		  	],
			"business_type" => 'individual',
			//'mcc' => '5734',
			"external_account" =>  [
				"object"=>"bank_account",
  				"country"=>"US",
  				"currency"=>"usd",
  				"routing_number"=>"110000000",
  				"account_number"=>"000123456789"
  			],
			"individual" => [
				"first_name" => $user->name,
				"last_name" => "Doe",
				"email" => "john@doe.com",
				"phone" => "+31502112465",
				"dob" => ['day'=>'01','month'=>'01','year'=>'1988'],
				"address" => [
					"city" => "Amsterdam",
					"line1" => "Steet 12",
					"postal_code" => "9723 AS"
				],
				'verification'=>[
				 	"document"=>["front"=>"file_identity_document_success"],
				 	"additional_document"=>["front"=>"file_identity_document_success"]
				]
			]
		]);

		$user->stripe_id = $acct->id;

		$user->save();
	}

	function testAccount(){
		

		dump($acct);

	}

	function updateAccount(){
		\Stripe\Account::update(
		  'acct_1FdxkEK00Zrt3N1j',
		  [
		    'tos_acceptance' => [
		      'date' => time(),
		      'ip' => $_SERVER['REMOTE_ADDR']
		    ],
		    "business_profile" => [
		      "url" => 'http://script.dev',
		      "mcc" => '5931'
		  	],
			"business_type" => 'individual',
			//'mcc' => '5734',
			"external_account" =>  [
				"object"=>"bank_account",
  				"country"=>"US",
  				"currency"=>"usd",
  				"routing_number"=>"110000000",
  				"account_number"=>"000123456789"
  			],
			"individual" => [
				"first_name" => "John",
				"last_name" => "Doe",
				"email" => "john@doe.com",
				"phone" => "+31502112465",
				"dob" => ['day'=>'01','month'=>'01','year'=>'1988'],
				"address" => [
					"city" => "Amsterdam",
					"line1" => "Steet 12",
					"postal_code" => "9723 AS"
				],
				'verification'=>[
				 	"document"=>["front"=>"file_identity_document_success"],
				 	"additional_document"=>["front"=>"file_identity_document_success"]
				]
			]
		  ]
		);
	}

	function __updatePaymentIntent(){
		\Stripe\PaymentIntent::update(
		  "pi_1Feg44L2zfTV5KIDL1H9d0EH",
		  ['metadata' => ['auction_id' => $auction->id]]
		);
	}

	function testPayment(){
		\Stripe\Stripe::setApiKey('sk_test_KSAvjIYHGOEkDRaZ4g4hoFP600FUiJ2Gs0');


		$auction = \App\Auction::find(3);
		
		if(!$auction->user->stripe_id){
			$this->__createStripeAccount($auction->user);
		}

		$winningBid = $auction->bids()->orderBy('amount', 'desc')->first();

		$winningBid->winner = true;
		$winningBid->save();
	
		return view('stripe', ['client_secret'=>$auction->createTransaction()->client_secret]);
	}

	function update(){
		// Set your secret key: remember to change this to your live secret key in production
		// See your keys here: https://dashboard.stripe.com/account/apikeys
		\Stripe\Stripe::setApiKey('sk_test_KSAvjIYHGOEkDRaZ4g4hoFP600FUiJ2Gs0');

		// If you are testing your webhook locally with the Stripe CLI you
		// can find the endpoint's secret by running `stripe trigger`
		// Otherwise, find your endpoint's secret in your webhook settings in the Developer Dashboard
		$endpoint_secret = 'whsec_UT4TRzte2TylRD6j8Wejp2hEyt8Viy8k';

		$payload = @file_get_contents('php://input');
		$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
		$event = null;

		try {
		    $event = \Stripe\Webhook::constructEvent(
		        $payload, $sig_header, $endpoint_secret
		    );
		} catch(\UnexpectedValueException $e) {
		    // Invalid payload
		    http_response_code(400);
		    exit();
		} catch(\Stripe\Exception\SignatureVerificationException $e) {
		    // Invalid signature
		    http_response_code(400);
		    exit();
		}

		$transaction = \App\Transaction::where('stripe_id', $event->data->object->id)->first();
		$transaction->stripe_status = $event->data->object->status;
		$transaction->save();

		// // Handle the event
		// switch ($event->type) {
		//      case 'payment_intent.canceled':
		//          $transaction->stripe_status = $event->data->object->status;
		//          break;
		//      default:
		//          // Unexpected event type
		//          http_response_code(400);
		//          exit();
		// }

		http_response_code(200);
	}
}