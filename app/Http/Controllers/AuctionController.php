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
            'title' => 'required|unique:auctions|max:255',
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        if(app()->runningUnitTests()){
            return response()->json(['created' => 'true'], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Auction $auction)
    {
        //
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
            return response()->json(['created' => 'true'], 201);            
        }

        return response()->json(['created' => 'false'], 102);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
