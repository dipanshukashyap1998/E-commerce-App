<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Cart;

class cartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::all();

        return response()->json([
            'data'=> $cart,
        ],200);
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
            'user_id'=>'required',
            'product_id'=>'required'
        ]);
        if($validator->fails())
        {
            return response()->json([
                'msg'=>$validator->errors(),
            ],422);
        }else
        {

            $cart = new Cart;
            $cart->user_id = $request->user_id;
            $cart->product_id = $request->product_id;
            $cart->quantity=$request->quantity;
            $cart->save();

            return response()->json([
                'msg'=>'Data inserted succesfully',
                'data'=> $cart,
            ],200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cart = Cart::findorfail($id);

        return response()->json([
            'data'=>$cart
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
        $cart = Cart::findorFail($id);

        if($request->has('quantity'))
        {
            $cart->quantity = $request->quantity;
        }

        $cart->save();

        return response()->json([
            'data' => 'cart updated successfully'
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::findorfail($id);
        $cart->delete();

        return response()->json([
            'data'=>$cart,
            'msg'=>'data successfully deleted',
        ],200);
    }

}
