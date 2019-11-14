<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auction extends Model
{
	use SoftDeletes;
    
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];

    protected $appends = ['path'];

    private function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
       $string = preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.

       return strtolower($string);
    }

    private function __createPaymentIntent($account_id, $auction_id, $amount){
        $amount *= 100;

        $paymentData = [
          'payment_method_types' => ['card'],
          'amount' => $amount,
          'currency' => 'eur',
          'transfer_data' => [
            'destination' => $account_id,
          ],
          'metadata' => [
            'auction_id' => $auction_id
          ]
        ];

        if($amount > 50000){
            $paymentData['application_fee_amount'] = $amount * 0.05;
        }

        $payment_intent = \Stripe\PaymentIntent::create($paymentData);
                
        return $payment_intent;
    }

    public function getPathAttribute(){
        return "a{$this->id}/{$this->clean($this->title)}";
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function rubrics(){
    	return $this->belongsToMany('App\Rubric');
    }

    public function promoted(){
    	return $this->hasOne('App\Promotion');
    }

    public function transaction(){
        return $this->hasOne('App\transaction');
    }

    public function bids(){
    	return $this->hasMany('App\Bid');
    }

    public function bidders()
    {
        return $this->hasManyThrough('App\Bid', 'App\User');
    }

    public function getWinningBidAttribute(){
        return $this->bids()->where('winner', true)->first();
    }

    public function createTransaction(){
        $paymentIntent = $this->__createPaymentIntent($this->user->stripe_id, $this->id, $this->winning_bid->amount);

        $this->transaction()->create([
            'stripe_id' => $paymentIntent->id,
            'stripe_status' => $paymentIntent->status
        ]);

        return  $paymentIntent;
    }
}
