<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FriendsController extends Controller
{
    public function index()
    {
        $onlyFriends = Friend::query()
            ->select(['friends.*', 'users.name as name', 'users.profile as profile'])
            ->where('user_id', Auth()->user()['id'])
            ->join('users', 'users.id', 'friends.friend_id')
            ->where('friends.status', 'accepted')
            ->get();

        $users = User::query()
            ->select(['users.*'])
            ->where('users.id', '!=', Auth()->user()['id'])
            ->where('users.role', '!=', 'admin')
            ->get();

        $totalUsers = $users->count();
        $friends = Friend::query()
            ->select(['friends.*', 'users.name as name', 'users.profile as profile', 'users.id as userID'])
            ->join('users', 'users.id', 'friends.user_id')
            ->where('friends.status', 'pending')
            ->where('friend_id', Auth()->user()['id'])
            ->get();
        $totalRequest = $friends->count();

        $requests = Friend::query()
            ->select(['friends.*',])
            ->where('status', 'pending')
            ->where('user_id', Auth()->user()['id'])
            ->get();

        return view('friends.index', [
            'friends' => $friends,
            'users' => $users,
            'requests' => $requests,
            'onlyFriends' => $onlyFriends,
            'totalRequest' => $totalRequest,
            'totalUsers' => $totalUsers,
             ]);
    }
    public function profile(Request $request): Factory|View|Application
    {
        $user = Friend::query()
            ->select(['friends.*', 'users.profile as profile', 'users.name as name', 'users.id as uId'])
            ->selectSub(function (Builder $builder){
                $builder->selectRaw('COUNT(id)')
                    ->from('users')
                    ->whereRaw('users.id = friends.user_id');
            }, 'total_friends')
            ->join('users', 'users.id', 'friends.friend_id')
            ->where('friends.friend_id', $request['id'])
            ->first();

        $blog = Blog::query()->orderByDesc('id')
            ->select(['blogs.*'])
            ->where('user_id', $request['id'])
            ->get();

        return view('friends.profile', [
            'friend' => $user,
            'blogs' => $blog,
        ]);
    }
    public function add($id): RedirectResponse
    {
        $equal = Friend::query()
            ->select(['friends.*'])
            ->where('friend_id', $id)
            ->where('user_id', Auth()->user()['id'])
            ->first();
        if ($equal == null) {
            Friend::query()->create([
                'user_id' => Auth()->user()['id'],
                'friend_id' => $id,
                'status' => 'pending',
            ]);
            $userName = Auth::user()['name'];
            Notification::query()->create([
                'receiver_id' => $id,
                'content' => "$userName sent you a friend request",
                'url' => '/friends',
                'status' => 'pending',
            ]);
            return redirect()->route('friends.index');
        }
        return back()
            ->with('message', 'You have already sent a request');
    }
    public function acceptApi(int $id): RedirectResponse
    {
        $user_id = Auth::user()['id'];
        $friend = Friend::query()
            ->where('user_id', $id)
            ->where('friend_id', $user_id)
            ->where('status', 'pending')
            ->first();
        Log::debug($friend);
        $friend->update(['status' => 'accepted']);
        $name = Auth::user()['name'];
        Notification::query()->create([
            'receiver_id' => $id,
            'content' => $name . ' accepted your friend request',
            'url' => '/friends',
            'status' => 'pending',
        ]);
        return redirect()->back();
    }

    public function rejectApi(int $id): RedirectResponse
    {
        $user_id = Auth::user()['id'];
        $friend = Friend::query()
            ->where('user_id', $id)
            ->where('friend_id', $user_id)
            ->first();
        $friend->update(['status' =>'rejected']);
        return redirect()->back();
    }
}
