<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();

        return response()->json([
            'data' => $product
        ], 200);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'required',
            'description' => 'required',
            'quantity' => 'required',
            'category_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => $validator->errors(),
            ], 422);
        } else {
            $product = new Product;
            $product->name = $request->name;
            $product->slug = strtolower($request->name);
            $product->price = $request->price;
            $product->image = $request->image;
            $product->description = $request->description;
            $product->quantity = $request->quantity;
            $product->category_id = $request->category_id;
            $product->status = 1;
            $product->save();

            return response()->json([
                'msg' => 'Data inserted succesfully',
                'data' => $product,
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findorfail($id);

        return response()->json([
            'data' => $product
        ], 200);
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
    public function update(string $id, Request $request)
    {
        // dd($request->all(), $id);
        $product = Product::findorFail($id);

        if ($request->has('name')) {
            $product->name = $request->name;
            $product->slug = strtolower($request->name);
        }

        if ($request->has('image')) {
            $product->image = $request->image;
        }

        if ($request->has('description')) {
            // dd($product);

            $product->description = $request->description;
        }

        if ($request->has('price')) {
            $product->price = $request->price;
        }

        if ($request->has('status')) {
            $product->status = $request->status;
        }

        if ($request->has('quantity')) {
            $product->quantity = $request->quantity;
        }

        if ($request->has('category_id')) {
            $product->category_id = $request->category_id;
        }

        // dd($product);
        $product->save();

        return response()->json([
            'data' => $request->all()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findorfail($id);
        $product->delete();

        return response()->json([
            'data' => $product,
            'msg' => 'data successfully deleted',
        ], 200);
    }
}
