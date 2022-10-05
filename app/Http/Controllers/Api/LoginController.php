<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return 201;
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function registerUser(Request $request)
    {
        $User = User::where('email','=',$request->email)->first();
        if($User){
            return (new SuccessResponse())->toResponse('A User already exists with this email, Please Sign In', [
            ]);
        }
        $user = new User();
        $user->password = Hash::make($request->input('password'));
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'user' => new UserResource($user),
            'api_token' => $user->createToken('token-name')->plainTextToken
        ]);
    }
}
