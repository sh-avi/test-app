<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    // Create New User
    public function signup(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required','confirmed','min:6'],
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create($formFields);

        // Login
        $token = $user->createToken('AuthToken', ['expires_in' => 10080])->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'message' => 'Signup successful'
        ], 200);

    }

    // login user
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $existingToken = $user->tokens->first();

            if ($existingToken) {
                $token = $existingToken->accessToken;
            } else {
                $token = $user->createToken('AuthToken', ['expires_in' => 10080])->accessToken;
            }

            return response()->json([
                'token' => $token,
                'user' => $user,
                'message' => 'Login successful'
            ], 200);
        } else {
            // If the credentials are incorrect, return an error message
            return response()->json(['message' => 'Invalid credentials'], 401);

        }

    }

    // Logout User
    public function logout(Request $request) {
            $user = $request->user();

            if ($user) {
                $user->tokens->each(function ($token, $key) {
                    $token->delete();
                });

                return response()->json(['message' => 'Logged out successfully'], 200);
            }

            return response()->json(['message' => 'No user logged in'], 401);
    }
    
}
