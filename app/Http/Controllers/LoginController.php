<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // LOGIN
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'msg' => "Incorrect Credentials",
                'code' => 404
            ], 404);
        }
        $token = $user->createToken('my-token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
            'msg' => 'Login Successfull',
        ], 200);
    }
    // SIGNUP
    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'string|required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|min:10|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => $validator->errors(),
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,

        ]);

        $token = $user->createToken('my-token')->plainTextToken;

        return response()->json([
            'data' => $user,
            'token' => $token,
            'msg' => 'Signup Successfull',
        ], 200);
    }
    // CHANGE PASSWORD
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'msg' => $validator->errors(),
            ], 400);
        }
    }
}
