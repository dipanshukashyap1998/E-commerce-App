<?php

namespace App\Services;

class Razorpay
{
    private $key_id , $key_secret,$baseUrl;

    public function __construct() {

        $config = config('payment');
        $this->key_id = config('key_id');
        $this->key_secret = config('key_secret');
        $this->baseUrl = config('base_url');
    }

    
}
