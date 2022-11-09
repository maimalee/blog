<?php

namespace App\Http\Controllers;

use App\Models\Friends;
use App\Models\User;
use Illuminate\Http\Request;


class FriendsController extends Controller
{
    public function index()
    {
//        $users = User::query()->orderByDesc('id')
//            ->where('id', '!=', Auth()->user()['id'])
//            ->paginate(5);

        $users = User::query()->orderByDesc('id')
            ->select(['users.*', 'friends.status as status'])
            ->leftJoin('friends', 'friends.friend_id', 'users.id')
            ->where('id', '!=', Auth()->user()['id'])
            ->paginate(5);
        $friends = Friends::query()
            ->select(['friends.*', 'users.name as name', 'users.id as userID'])
            ->join('users', 'users.id', 'friends.user_id')
            ->where('friend_id', Auth()->user()['id'])
            ->get();
        // dd($friends);
        $request = Friends::query()
            ->select(['friends.*',])
            ->where('status', 'pending')
            ->where('user_id', Auth()->user()['id'])
            ->get();
        //dd($request);
        return view('friends.index', compact('friends', 'users', 'request'));

    }

    public function add($id)
    {
        $equal = Friends::query()
            ->select(['friends.*'])
            ->where('friend_id', $id)
            ->where('user_id', Auth()->user()['id'])
            ->first();
        //  dd($equal);
        if ($equal == null) {
            Friends::query()->create([
                'user_id' => Auth()->user()['id'],
                'friend_id' => $id,
                'status' => 'pending',
            ]);
            return redirect()->route('friends.index');
        }
        return back()
            ->with('message', 'You have already sent a request');

    }

    public function accept(Request $request)
    {
        dd($request->post());
        $data = $request->validate([
            'status' => 'required',
            'user_id' => 'required',
            'friend_id' => 'required',
        ]);

        $update = Friends::query()
            ->select(['friends.*'])
            ->where('user_id' , Auth()->user()['id'])
            ->where('friend_id', $data['friend_id'])
            ->first();
        dd($update);
        return redirect()->route('friends.index');
    }
}
