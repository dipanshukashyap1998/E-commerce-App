<?php

namespace App\Services;

use Razorpay\Api\Api;

class RazorpayService
{
    protected $key_id, $key_secret;
    protected $api, $order_id;

    public function __construct()
    {
        $config = config('payment');
        $this->key_id = $config['key_id'];
        $this->key_secret = $config['key_secret'];

        $this->api = new Api($this->key_id, $this->key_secret);
    }

    public function createOrder( $transaction_id,$amount, $user)
    {
        $order = $this->api->order->create(array('amount' => $amount * 100, 'currency' => 'INR'));
        // dd($order);
        return [
            'key' => $this->key_id,
            'amount' => $amount * 100,
            'name' => $user->name,
            'razorpay_id' => $order['id'],
        ];

    }

    public function verifyTransaction()
    {

    }
}
