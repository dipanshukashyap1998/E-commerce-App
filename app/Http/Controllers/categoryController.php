<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'slug'=>'required'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'msg'=>$validator->errors(),
            ],422);
        }else
        {
            $category = new Category;
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->save();

            return response()->json([
                'msg'=>'Data inserted succesfully',
                'data'=> $category,
            ],200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findorfail($id);

        return response()->json([
            'data'=>$category
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $category = Category::findorfail($id);


        if($request->has('name'))
        {
            $category->name = $request->name;
            $category->slug = strtolower($request->name);
        }

        dd($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findorfail($id);
        $category->delete();

        return response()->json([
            'data'=>$category,
            'msg'=>'data successfully deleted',
        ],200);
    }
}
