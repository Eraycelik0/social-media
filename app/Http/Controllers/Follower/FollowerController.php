<?php

namespace App\Http\Controllers\Follower;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class FollowerController extends Controller
{
    public function followUser($followedId)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Kullanıcı oturumu açmamış.'], 401);
            }

            $validator = Validator::make(['to' => $followedId], [
                'to' => 'required|numeric|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Geçersiz takip edilen kullanıcı.'], 400);
            }

            // Takip işlemi
            $follower = new Follower([
                'from' => $user->id,
                'to' => $followedId,
                'status' => 1, // Takip ediliyor
            ]);
            $follower->save();

            return response()->json(['message' => 'Kullanıcıyı takip ediyorsunuz.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'İşlem sırasında bir hata oluştu.'], 500);
        }
    }

    public function sendFollowRequest($to)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Kullanıcı oturumu açmamış.'], 401);
            }

            $validator = Validator::make(['to' => $to], [
                'to' => 'required|numeric|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Geçersiz takip edilen kullanıcı.'], 400);
            }

            // Takip isteği gönderme
            $follower = new Follower([
                'from' => $user->id,
                'to' => $to,
                'status' => 0, // Takip isteği gönderildi
            ]);

            $follower->save();

            return response()->json(['message' => 'Takip isteği gönderildi.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'İşlem sırasında bir hata oluştu.'], 500);
        }
    }

    public function acceptFollowRequest($from)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Kullanıcı oturumu açmamış.'], 401);
            }

            $follower = Follower::where('from', $from)
                ->where('to',$user->id)
                ->where('status', 0) // Takip isteği gönderilmiş
                ->first();

            if (!$follower) {
                return response()->json(['error' => 'Takipçi isteği bulunamadı veya zaten kabul edildi.'], 404);
            }

            // Takipçi isteğini kabul etme
            $follower->status = 1; // Takip ediliyor
            $follower->save();

            return response()->json(['message' => 'Takipçi isteği kabul edildi.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'İşlem sırasında bir hata oluştu.'], 500);
        }
    }

    public function unfollowUser($to)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Kullanıcı oturumu açmamış.'], 401);
            }

            $validator = Validator::make(['to' => $to], [
                'to' => 'required|numeric|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Geçersiz takip edilen kullanıcı.'], 400);
            }

            // Takipten çıkarma
            Follower::where('from', $user->id)
                ->where('to', $to)
                ->delete();

            Follower::where('from', $to)
                ->where('to', $user->id)
                ->delete();

            return response()->json(['message' => 'Kullanıcıyı takipten çıkardınız.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'İşlem sırasında bir hata oluştu.'], 500);
        }
    }

}
