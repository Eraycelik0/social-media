<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Services\Media\MediaService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller {

    public function detail() {
        return response()->json(['message' => 'Profile get','data' => Auth::user()], 200);
    }

    public function update(Request $request) {
        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'username' => 'alpha_dash|unique:users,username,' . $user->id,
            'email' => 'email|unique:users,email,' . $user->id,
            'date_of_birth' => 'date|date_format:Y-m-d',
            'gender' => 'in:Male,Female,Other',
            'profile_photo' => 'file',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if ($request->has('username')) {
            $user->username = $request->input('username');
        }
        if ($request->has('email')) {
            $user->email = $request->input('email');
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        if ($request->has('first_name')) {
            $user->first_name = $request->input('first_name');
        }
        if ($request->has('last_name')) {
            $user->last_name = $request->input('last_name');
        }
        if ($request->has('date_of_birth')) {
            $user->date_of_birth = (new DateTime($request->date_of_birth))->format('Y-m-d');
        }
        if ($request->has('gender')) {
            $user->gender = $request->input('gender');
        }
        if ($request->has('title')) {
            $user->title = $request->input('title');
        }
        if ($request->has('description')) {
            $user->title = $request->input('description');
        }
        if ($request->has('profile_photo')) {
            $image = MediaService::processImage($request->file('profile_photo'));
            if ($image != false) {
                $user->profile_photo_url = $image;
            } else {
                return response()->json(['status' => false, 'message' => 'Invalid profile photo'], 400);
            }
        }

        $user->save();

        return response()->json(['message' => 'Profile Updated', 'data' => $user], 201);
    }

}
