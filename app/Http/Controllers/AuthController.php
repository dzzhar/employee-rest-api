<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // membuat fitur register
    public function register(Request $request)
    {
        // menangkap inputan
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        // menginsert data ke table user
        $user = User::create($input);

        $data = [
            'message' => 'User is Created Successfully',
            'data' => $user
        ];

        // mengirim response JSON dan status code
        return response()->json($data, 201);
    }

    // membuat fitur login
    public function login(Request $request)
    {
        // menangkap input user
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // mengambil data user (DB)
        $user = User::where('email', $input['email'])->first();

        // membandingkan input user dengan data user (DB)
        $isLoginSuccessfully = (
            $input['email'] == $user->email
            &&
            Hash::check($input['password'], $user->password)
        );

        if ($isLoginSuccessfully) {
            // membuat token
            $token = $user->createToken('auth_token');

            $data = [
                'message' => 'Login Successfully',
                'token' => $token->plainTextToken
            ];

            // mengembalikan response JSON
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Username or Password is Wrong'
            ];

            return response()->json($data, 401);
        }
    }
}
