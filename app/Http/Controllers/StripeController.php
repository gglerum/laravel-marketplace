<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StripeController extends Controller
{

	function testAccount(){
		\Stripe\Stripe::setApiKey('sk_test_KSAvjIYHGOEkDRaZ4g4hoFP600FUiJ2Gs0');

		$acct = \Stripe\Account::create([
		     'country' => 'NL',
		     'type' => 'custom',
		     'requested_capabilities' => ['card_payments', 'transfers'],
		]);

		\Stripe\Account::update(
		  'acct_1FdxkEK00Zrt3N1j',
		  [
		    'tos_acceptance' => [
		      'date' => time(),
		      'ip' => $_SERVER['REMOTE_ADDR']
		    ],
		    "business_profile" => [
		      "url" => 'http://script.dev'
		  	],
			"business_type" => 'individual',
			"individual" => [
				"firstname" => "John"
			]
		  ]
		);

		dump($acct);

	}

	function testPayment(){
		\Stripe\Stripe::setApiKey('sk_test_KSAvjIYHGOEkDRaZ4g4hoFP600FUiJ2Gs0');

		\Stripe\Account::update(
		  'acct_1FdxkEK00Zrt3N1j',
		  [
		    'tos_acceptance' => [
		      'date' => time(),
		      'ip' => $_SERVER['REMOTE_ADDR']
		    ],
		    "business_profile" => [
		      "url" => 'http://script.dev'
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
				// 'verification'=>[
				// 	"document"=>"file_identity_document_success"
				// ]
			]
		  ]
		);
		
		 dump(\Stripe\Account::retrieve( 'acct_1FdxkEK00Zrt3N1j'));
		

		// $payment_intent = \Stripe\PaymentIntent::create([
		//   'payment_method_types' => ['card'],
		//   'amount' => 1000,
		//   'currency' => 'eur',
		//   'application_fee_amount' => 123,
		//   'transfer_data' => [
		//     'destination' => 'acct_1FdxkEK00Zrt3N1j',
		//   ],
		// ]);
		// 
		

		//return view('stripe', ['client_secret'=>'pi_1Fdxq5L2zfTV5KIDQcGJYpYf_secret_yoEfincwG4ROFW7sVoUiWdyLk']);
	}
}