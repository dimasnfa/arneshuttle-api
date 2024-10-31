<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver; 
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'contact' => 'required|string',
            'password' => 'required|string',
        ]);

        $driver = Driver::where('contact', $request->contact)->first();

        if ($driver && Hash::check($request->password, $driver->password) && $driver->is_active == 'y') {
            $token = $driver->createToken('api_token')->plainTextToken;

            Session::put('driver', $driver); 

            return response()->json([
                'message' => 'Login Berhasil', 
                'token' => $token, 
                'token_type' => 'Bearer'
            ], 200);
        }

        return response()->json(['message' => 'Login Gagal'], 401);
    }             

    public function logout(Request $request){

        // dd($request->user());
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout Berhasil'], 200);
    }
}

