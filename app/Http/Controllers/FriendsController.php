<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\String\b;


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
//dd($onlyFriends);
//        $users = User::query()
//            ->select(['users.*', 'friends.status as status', 'friends.user_id as userID'])
//            ->leftJoin('friends', 'friends.friend_id', 'users.id')
//            ->where('friends.status', '!=', 'accepted')
//            ->where('users.id', '!=', Auth()->user()['id'])
//            ->get();

        $users = User::query()
            ->select(['users.*'])
//            ->leftJoin('friends', 'friends.friend_id', 'users.id')
            ->where('users.id', '!=', Auth()->user()['id'])
            ->get();

        $totalUsers = $users->count();
//            dd($totalUsers);
        $friends = Friend::query()
            ->select(['friends.*', 'users.name as name', 'users.profile as profile' . 'users.id as userID'])
            ->join('users', 'users.id', 'friends.user_id')
            ->where('friends.status', 'pending')
            ->where('friend_id', Auth()->user()['id'])
            ->get();
        $totalRequest = $friends->count();
//        dd($totalRequest);
//dd($friends);
        // dd($friends);
//        $authUserId = Auth::user()['id'];
        $requests = Friend::query()
            ->select(['friends.*',])
            ->where('status', 'pending')
            ->where('user_id', Auth()->user()['id'])
            ->get();
//        dd($requests);
        return view('friends.index', [
            'friends' => $friends,
            'users' => $users,
            'requests' => $requests,
            'onlyFriends' => $onlyFriends,
            'totalRequest' => $totalRequest,
            'totalUsers' => $totalUsers,
             ]);

    }

    public function profile(Request $request)
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
//            'total_friends' => $friends,
        ]);
    }

    public function add($id)
    {
        $equal = Friend::query()
            ->select(['friends.*'])
            ->where('friend_id', $id)
            ->where('user_id', Auth()->user()['id'])
            ->first();
        //  dd($equal);
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

    public function accept(Request $request)
    {
        //dd($request->post());
        $data = $request->validate([
            'status' => 'required',
            'user_id' => 'required',
            'friend_id' => 'required',
        ]);

        $friend = Friend::query()
            ->select(['friends.*', 'user_id'])
            ->join('users', 'users.id', 'friends.user_id')
            ->where('user_id', $data['user_id'])
            ->where('friend_id', $data['friend_id'])
            ->first();

        $friend->update(['status' => $data['status']]);
        $name = Auth::user()['name'];
        Notification::query()->create([
            'receiver_id' => $data['user_id'],
            'content' => $name . ' accepted your friend request',
            'url' => '/friends',
            'status' => 'pending',
        ]);
        return redirect()->route('friends.index');
    }

    public function reject(Request $request)
    {
        $data = $request->validate([
            'status' => 'required|min:1',
            'user_id' => 'required',
            'friend_id' => 'required',
        ]);
        $friend = Friend::query()
            ->select(['friends.*'])
            ->where('user_id', $data['user_id'])
            ->where('friend_id', $data['friend_id'])
            ->first();
//        dd($friend);
        $friend->update(['status' => $data['status']]);
//        dd($data);
        return redirect()->back();
    }
}
