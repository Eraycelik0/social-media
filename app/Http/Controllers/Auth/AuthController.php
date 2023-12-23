<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Media\MediaService;
use DateTime;
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
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'first_name'=>'required',
            'last_name'=>'required',
            'password' => 'required|min:8|regex:/^.*(?=.{7,})(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            'date_of_birth' => 'required|date|date_format:Y-m-d',
            'gender' => 'in:Male,Female,Other',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = new User();

        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->date_of_birth = (new DateTime($request->date_of_birth))->format('Y-m-d');
        $user->gender = $request->input('gender');
        if($request->has('profile_photo')) {
            $image = MediaService::processImage($request->file('profile_photo'));
            if ($image) {
                $user->profile_photo_url = $image;
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid profile photo'], 400);
            }
        } $user->save();

        $token = $user->createToken('login');

        return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $token->plainTextToken], 201);
    }

    public function login(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $login, 'password' => $password]) || Auth::attempt(['username' => $login, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('login');

            return response()->json(['user' => $user, 'token' => $token->plainTextToken])->setStatusCode(200);
        } else {
            return response()->json(['errors' => ['Email and password do not match']])->setStatusCode(401);
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
