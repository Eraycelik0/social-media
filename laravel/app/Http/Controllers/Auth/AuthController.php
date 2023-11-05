<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'profile_photo_url' => 'url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = new User();
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->date_of_birth = $request->input('date_of_birth');
        $user->gender = $request->input('gender');
        $user->profile_photo_url = $request->input('profile_photo_url');
        $user->save();

        $token = $user->createToken('login');


        return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $token->plainTextToken], 201);
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('login');

            return response()->json(['user' => $user, 'token' => $token->plainTextToken])->setStatusCode(200);
        } else {
            return response()->json(['errors' => ['Email and password do not match']])->setStatusCode(200);
        }
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);


        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            $status = Password::sendResetLink($request->only('email'));

            return $status === Password::RESET_LINK_SENT
                ? response()->json(['message' => 'Password reset link sent to your email.'], 200)
                : response()->json(['message' => 'Unable to send password reset link.'], 400);
        } else {
            return response()->json(['message' => 'Invalid email address.'], 400);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password),
            ])->save();
        });

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successful.'], 200);
        } else {
            return response()->json(['message' => 'Unable to reset password.'], 400);
        }
    }
}
