<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;

class AuthController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:user', ['except' => ['login', 'register', 'handleGoogleRedirect', 'handleGoogleCallback', 'loginWithGoogleId']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth('user')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }

    public function register(RegisterUserRequest $request)
    {
        $user_data = $request->validated();
        $user_data['password'] = Hash::make($user_data['password']);
        $user = User::create($user_data);
        event(new Registered($user));
        return response()->json(['message' => 'User created successfully'], 201);
    }

    public function verifyUserEmail(Request $request): RedirectResponse
    {
        $user = User::find($request->route('id'));

        if ($user->hasVerifiedEmail()) {
            return redirect('/login?emailVerified=already');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return redirect('/login?emailVerified=true');
    }

    public function sendEmailVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }

    public function logout()
    {
        auth('user')->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    public function refresh()
    {
        return $this->createNewToken(auth('user')->refresh());
    }

    public function userProfile()
    {
        return response()->json(auth('user')->user());
    }

    protected function createNewToken($token)
    {
        $user = auth('user')->user();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('user')->factory()->getTTL() * 600,
            'user' => $user
        ]);
    }
}
