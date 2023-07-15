<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DummyController extends Controller
{
    public function getPostData()
    {
       $response =  Http::get('https://jsonplaceholder.typicode.com/posts');
       dd($response->collect()); // Collect method is used to read data, without collect method we cannot read data
    }
}
