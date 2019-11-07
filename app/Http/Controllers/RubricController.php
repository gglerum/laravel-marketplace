<?php

namespace App\Http\Controllers;

use App\Rubric;
use Illuminate\Http\Request;

class RubricController extends Controller
{
    private function __validate(){
        $request = request();

        $validateData = $request->validate([
            'title' => 'required|unique:auctions|max:255',
            'description' => 'required'
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
        //Limit amount of children to be displayed to five
        $withChildren = Rubric::with([
            'children' => function($query){
                $query->take(5);
            }
        ]);

        //Only get the rubrics that are not a child
        $rubrics = $withChildren->has('parent', '=', 'null')->get();

        return array_chunk( $rubrics->toArray(), 3);
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
        
        $response = Rubric::create([
            'parent_id' => $request->parent_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if($response)
        {
            return response()->json(['created' => 'true'], 201);
        }
        else
        {
            return response()->json(['created' => 'false'], 417);   
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rubric  $rubric
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $withChildren = Rubric::with([
            'children' => function($query){
                        $query->with('children')->take(5);
                    },
            'auctions'
        ]);
        $rubric = $withChildren->findOrFail($id);

        return $rubric;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rubric  $rubric
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rubric $rubric)
    {
         $this->__validate();
        
        $rubric->fill([
            'parent_id' => $request->parent_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if($rubric->save())
        {
            return response()->json(['updated' => 'true'], 201);
        }
        else
        {
            return response()->json(['updated' => 'false'], 417);   
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rubric  $rubric
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rubric $rubric)
    {
        if($rubric->exists)
        {
            if($rubric->delete())
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
