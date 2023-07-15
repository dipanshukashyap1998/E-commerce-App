<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Product;
use App\Services\ShipRocketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
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
        $cartItems = Cart::with('product')->where('user_id', $request->user_id)->get();
        $grandTotal = 0;
        $total = 0;
        foreach ($cartItems as $item) {
            $total = (int)$item->product->price * $item->quantity;
            $grandTotal += $total;
        }

        $order = new Order;
        $order->user_id = $request->user_id;

        $ship_details = [                           // Shipping  details array
            'name' => $request->name,
            'phone' => $request->phone,
            'pincode' => $request->pincode,
            'address' => $request->address,
            'state' => $request->state,
        ];

        $ship_d = json_encode($ship_details); // Convert array into json format
        $order->shipping_details = $ship_d;
        $order->items = $cartItems->toArray();
        $order->total = $grandTotal;
        $res = $order->save();

        if ($res) {
            Cart::where('user_id', $request->user_id)->delete();
        }

        $order = Order::where('user_id', $request->user_id)->first(); // <- Question

        (new ShipRocketService())->createOrder($order);

        return response()->json([
            'msg' => 'Order placed',
            'data' => $order,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
