<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['created_at', 'updated_at'];

    // private function __createPaymentIntent($account_id, $auction_id, $amount){
    //     $amount *= 100;

    //     $paymentData = [
    //       'payment_method_types' => ['card'],
    //       'amount' => $amount,
    //       'currency' => 'eur',
    //       'transfer_data' => [
    //         'destination' => $account_id,
    //       ],
    //       'metadata' => [
    //         'auction_id' => $auction_id
    //       ]
    //     ];

    //     if($amount > 50000){
    //         $paymentData['application_fee_amount'] = $amount * 0.05;
    //     }

    //     $payment_intent = \Stripe\PaymentIntent::create($paymentData);
                
    //     return $payment_intent;
    // }

    public function auction(){
    	return $this->belongsTo('App\Auction');
    }

    public function seller(){
    	return $this->hasOneThrough('App\Auction', 'App\User');
    }

    public function buyer(){
    	return $this->auction->winning_bid->user;
    }

    // public static function boot(){
    // 	parent::boot();

    // 	self::creating(function($model){
    // 		die($model);
    // 		$model->stripe_id = '12';

    // 		//$paymentIntent = $this->__createPaymentIntent($this->user->stripe_id, $model->account_id, $this->winning_bid->amount);
    // 		//die($model);
    // 	});
    // }
}
