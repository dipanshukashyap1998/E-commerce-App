<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment');
    }

    public function success()
    {
        return view('success');
    }

    public function save(Request $request)
    {
        $name = $request->name;
        $amount = $request->amount; 
    }
}
// key_id - rzp_test_nsK6GAlIefJH6e
// key_secret - ab4yP5Vkp3I6U8ABRw4vvJpJ
