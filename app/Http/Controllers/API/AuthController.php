<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\BaseController;

class AuthController extends BaseController
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'register']]);
    }

    // Login
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (!Auth::attempt($validatedData)) {
            return $this->sendError('Invalid Login.', [], 401);
        }
    
        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;
    
        return $this->sendResponse([
           'access_token' => $token,
           'token_type' => 'Bearer', 
        ], 'Login successful.');
    }
    

    // Register
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
    
        // if ($request->fails()) {
        //     return $this->sendError('Validation Error.', $request->errors()->all(), 422);
        // }
    
        $user = User::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return $this->sendResponse([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Registration successful.');
    }
    
    // Logout
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
    
        return $this->sendResponse(['message' => 'Successfully logged out'], 200);
    }

    // Get All users
    public function getUsers(){
        $users = User::all();
        return $this->sendResponse($users, 'Users retrived sccessfully');
    }
    
    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
