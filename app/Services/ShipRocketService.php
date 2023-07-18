<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Token;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;

class ShipRocketService
{
    private string $email, $password, $baseURL;
    private const CREATE_TOKEN_URL = '/v1/external/auth/login';
    private const CREATE_ORDER_URL = '/v1/external/orders/create/adhoc';
    private $token;

    function __construct()
    {
        $config = config('shiprocket');
        $this->email = $config['email'];
        $this->password = $config['password'];
        $this->baseURL = $config['base_url'];
    }

    private function createToken()
    {
        try {
            $httpRequest = Http::contentType('application/json')->post($this->baseURL . self::CREATE_TOKEN_URL, [
                'email' => $this->email,
                'password' => $this->password,
            ]);

            if ($httpRequest->failed()) throw new Exception('Not able to generate token');
            return $httpRequest->json('token');
        } catch (Exception $e) {
            throw new Exception('Not able to generate token');
        }
    }

    private function getToken()
    {
        $tokenRecord = Token::where('name', 'shiprocket')->whereDate('expiry', '>', now())->first();
        if ($tokenRecord) return $tokenRecord->token;

        Token::updateOrCreate([
            'name' => 'shiprocket'
        ], ['expiry' => now()->addDay(9), 'token' => $token = $this->createToken()]);

        return $token;
    }

    public function createOrder($order, $length = '10.5', $breadth = '140.5', $height = '56.2', $weight = '500')
    {
        $token = $this->getToken();

        $id = $order->user_id;

        $user = User::find($id);

        try {
            $orderItems = [];

            foreach ($order->items as $item) {
                $record = [];
                $record['name'] = $item['product']['name'];
                $record['sku'] = $item['product']['slug'];
                $record['units'] = $item['product']['quantity'];
                $record['selling_price'] = $item['product']['price'];
                $record['discount'] = "0";
                $record['tax'] = "0";
                $record['hsn'] = "441122";
                $orderItems[] = $record;
            }
            $s_details = json_decode($order->shipping_details,true);
    
            $httpRequest = Http::contentType('application/json')
                ->withToken($token)->post($this->baseURL . self::CREATE_ORDER_URL, [
                    'order_id' => $order->id,
                    'order_date' => $order->created_at,
                    'pickup_location' => 'Primary',
                    'channel_id' => '',
                    'comment' => '',
                    "billing_customer_name" => $user['name'],
                    "billing_last_name" => "",
                    "billing_address" => $s_details['address'],
                    "billing_address_2" => "",
                    "billing_city" => "",
                    "billing_pincode" => $s_details['pincode'],
                    "billing_state" => $s_details['state'],
                    "billing_country" => "India",
                    "billing_email" => $user['email'],
                    "billing_phone" => $s_details['phone'],
                    "shipping_is_billing" => true,
                    "shipping_customer_name" => "",
                    "shipping_last_name" => "",
                    "shipping_address" => "",
                    "shipping_address_2" => "",
                    "shipping_city" => "",
                    "shipping_pincode" => "",
                    "shipping_country" => "",
                    "shipping_state" => "",
                    "shipping_email" => "",
                    "shipping_phone" => "",
                    "order_items" => $orderItems,
                    "payment_method" => "Prepaid",
                    "shipping_charges" => 0,
                    "giftwrap_charges" => 0,
                    "transaction_charges" => 0,
                    "total_discount" => 0,
                    "sub_total" => $order->total,
                    "length" => $length,
                    "breadth" => $breadth,
                    "height" => $height,
                    "weight" => $weight,
                ]);

            if ($httpRequest->failed()) throw new Exception('Order failed: ' . $httpRequest->body());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
