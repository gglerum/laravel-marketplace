<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auction;
use Illuminate\Validation\Rule;

class AuctionController extends Controller
{

    private function __validate(){
        $request = request();

        $validateData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'text' => 'required',
            'address' => [
                //'alpha_num',
                Rule::requiredIf($request->postal_code)
            ],
            'postal_code' => [
                //'alpha_num',
                Rule::requiredIf($request->address)
            ],
            'price'=> 'required|numeric'
        ]);

        return $validateData;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "Listing";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->__validate();
        
        Auction::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'text' => $request->text,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'price' => $request->price,
        ]);

        
        return response()->json(['created' => 'true'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Auction::with(['bids'=>function($query){
            $query->with('user');
        },'user'])->findOrFail($id);
    }

    public function bid($id){
        $request = request();

        if($request->bid){
              Auction::find($id)->bids()->create([
                    'user_id' => 1000,
                    'amount' => $request->bid
                ]);
        }

        return Auction::with(['bids'=>function($query){
            $query->with('user');
        },'user'])->findOrFail($id); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auction $auction)
    {
        $this->__validate();

        $auction->fill([
            'title' => $request->title,
            'description' => $request->description,
            'text' => $request->text,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'price' => $request->price,
        ]);

        if($auction->save()){
            return response()->json(['updated' => 'true'], 201);            
        }

        return response()->json(['updated' => 'false'], 102);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auction)
    {
        if($auction->exists)
        {
            if($auction->delete())
            {
                return response()->json(['deleted' => 'true'], 200);
            }
            else
            {
                return response()->json(['deleted' => 'false'], 417);   
            }
        }
        return response()->json(['deleted' => 'false'], 410);
    }
}
