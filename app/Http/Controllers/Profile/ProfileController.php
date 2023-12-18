<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller {

    public function detail() {
        return response()->json(['message' => 'Profile get','data' => Auth::user()], 200);
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'unique:users',
            'email' => 'email|unique:users',
            'date_of_birth' => 'date|date_format:Y-m-d',
            'gender' => 'in:Male,Female,Other',
            'profile_photo_url' => 'url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = Auth::user();
        if($request->has('username')) $user->username = $request->input('username');
        if($request->has('email')) $user->email = $request->input('email');
        if($request->has('password')) $user->password = Hash::make($request->input('password'));
        if($request->has('first_name')) $user->first_name = $request->input('first_name');
        if($request->has('last_name')) $user->last_name = $request->input('last_name');
        if($request->has('date_of_birth')) $user->date_of_birth = (new DateTime($request->date_of_birth))->format('Y-m-d');
        if($request->has('gender')) $user->gender = $request->input('gender');
        if($request->has('profile_photo')) $user->profile_photo_url = Storage::url($request->file('profile_photo')->store('public/profile-photo'));

        $user->save();

        return response()->json(['message' => 'Profile Updated', 'data' => $user], 201);
    }
}
