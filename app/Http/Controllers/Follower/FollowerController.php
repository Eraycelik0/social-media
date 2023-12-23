<?php

namespace App\Http\Controllers\Follower;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class FollowerController extends Controller
{
    public function followUser($username)
    {
        try {
            $user = User::where('username', $username)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            $follower = new Follower([
                'from' => Auth::user()->id,
                'to' => $user->id,
                'status' => 1,
            ]);
            $follower->save();

            return response()->json(['message' => 'You are following the user.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'An error occurred during the operation.'], 500);
        }
    }

    public function sendFollowRequest($username)
    {
        try {
            $user = User::where('username', $username)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            $follower = new Follower([
                'from' => Auth::user()->id,
                'to' => $user->id,
                'status' => 0, // Follow request sent
            ]);

            $follower->save();

            return response()->json(['message' => 'Follow request sent.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'An error occurred during the operation.'], 500);
        }
    }

    public function acceptFollowRequest($username)
    {
        try {
            $user = User::where('username', $username)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            $follower = Follower::where('from', $user->id)
                ->where('to', Auth::user()->id)
                ->where('status', 0) // Follow request sent
                ->first();

            if (!$follower) {
                return response()->json(['error' => 'Follow request not found or already accepted.'], 404);
            }

            $follower->status = 1;
            $follower->save();

            return response()->json(['message' => 'Follow request accepted.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'An error occurred during the operation.'], 500);
        }
    }

    public function unfollowUser($username)
    {
        try {
            $user = User::where('username', $username)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            Follower::where('from', Auth::user()->id)
                ->where('to', $user->id)
                ->delete();

            Follower::where('from', $user->id)
                ->where('to', Auth::user()->id)
                ->delete();

            return response()->json(['message' => 'You have unfollowed the user.']);
        } catch (QueryException $e) {
            return response()->json(['error' => 'An error occurred during the operation.'], 500);
        }
    }

    public function getFollowRequests()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'User is not authenticated.'], 401);
            }

            $followRequests = Follower::with('followerUser')
                ->where('status', 0)
                ->where('to', $user->id)
                ->get();

            return response()->json(['follow_requests' => $followRequests], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getFollowerList($username)
    {
        try {
            $user = User::where('username', $username)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            $followers = Follower::with('followerUser')->where('to', $user->id)->get();
            $followerCount = $followers->count();

            return response()->json([
                'follower_count' => $followerCount,
                'followers' => $followers
            ], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'An error occurred while fetching followers.'], 500);
        }
    }

    public function getFollowingList($username)
    {
        try {
            $user = User::where('username', $username)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            $following = Follower::with('user')->where('from', $user->id)->get();
            $followingCount = $following->count();

            return response()->json([
                'following_count' => $followingCount,
                'following' => $following
            ], 200);
        } catch (QueryException $e) {
            return response()->json(['error' => 'An error occurred while fetching following.'], 500);
        }
    }

}
