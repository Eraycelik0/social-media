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

            $validator = Validator::make(['followed_id' => $followedId], [
                'followed_id' => 'required|numeric|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Geçersiz takip edilen kullanıcı.'], 400);
            }

            $follower = new Follower([
                'following_id' => $user->id,
                'followed_id' => $followedId,
                'follow_date' => now(),
            ]);
            $follower->save();

            return response()->json(['message' => 'Kullanıcıyı takip ediyorsunuz.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'İşlem sırasında bir hata oluştu.'], 500);
        }
    }

    public function sendFollowRequest($followedId)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Kullanıcı oturumu açmamış.'], 401);
            }

            $validator = Validator::make(['followed_id' => $followedId], [
                'followed_id' => 'required|numeric|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Geçersiz takip edilen kullanıcı.'], 400);
            }

            $follower = new Follower([
                'following_id' => $user->id,
                'followed_id' => $followedId,
                'follow_date' => null,
            ]);
            $follower->save();

            return response()->json(['message' => 'Takip isteği gönderildi.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'İşlem sırasında bir hata oluştu.'], 500);
        }
    }

    public function acceptFollowRequest($followerId)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Kullanıcı oturumu açmamış.'], 401);
            }

            $follower = Follower::where('id', $followerId)
                ->where('followed_id', $user->id)
                ->where('follow_date', null)
                ->first();

            if (!$follower) {
                return response()->json(['error' => 'Takipçi isteği bulunamadı veya zaten kabul edildi.'], 404);
            }

            $follower->follow_date = now();
            $follower->save();

            return response()->json(['message' => 'Takipçi isteği kabul edildi.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'İşlem sırasında bir hata oluştu.'], 500);
        }
    }

    public function unfollowUser($followedId)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'Kullanıcı oturumu açmamış.'], 401);
            }

            $validator = Validator::make(['followed_id' => $followedId], [
                'followed_id' => 'required|numeric|exists:users,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => 'Geçersiz takip edilen kullanıcı.'], 400);
            }

            Follower::where('following_id', $user->id)
                ->where('followed_id', $followedId)
                ->delete();

            return response()->json(['message' => 'Kullanıcıyı takipten çıkardınız.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'İşlem sırasında bir hata oluştu.'], 500);
        }
    }

}
