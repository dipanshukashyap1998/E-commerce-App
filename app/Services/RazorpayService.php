<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Cast\Bool_;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

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
        return [
            'key' => $this->key_id,
            'amount' => $amount * 100,
            'name' => $user->name,
            'razorpay_id' => $order['id'],
        ];

    }

    public function verifyTransaction($order_id,$payment_id,$signature):bool
    {
        // $request = request();
        try{

            $orderId = $order_id;
            $paymentId = $payment_id ;
            $signature = $signature;

            // dd($order_id,$payment_id,$signature);

            $this->api->utility->verifyPaymentSignature([
                'razorpay_signature'  => $signature,
                'razorpay_payment_id'  => $paymentId,
                'razorpay_order_id' => $orderId,
            ]);
                return true;
        }
        catch (SignatureVerificationError $e) {
            Log::error('Razorpay Error : ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error("Razorpay transaction verification failed ". $orderId);
            return false;
        }
    }
}
