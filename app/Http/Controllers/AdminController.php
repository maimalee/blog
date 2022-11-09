<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comments;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::query()
            ->paginate(10);
        return view('users.all', compact('users'));
    }

    public function comment()
    {
        $comment = Comments::query()
            ->select(['comments.*', 'users.name', 'blogs.id as blog_id'])
            ->join('blogs', 'blogs.id', 'comments.blog_id')
            ->join('users', 'users.id', 'comments.user_id')
            ->paginate('5');
        return view('comments.all', compact('comment'));
    }

    public function blog()
    {
        $blogs = Blog::query()
            ->select(['blogs.*', 'users.name', 'users.id as userId'])
            ->join('users', 'users.id', 'blogs.user_id')
            ->paginate(6);
        return view('admin.blogs', compact('blogs'));
    }

    public function usersShow($id): Factory|View|Application
    {
        $user = User::query()->find($id);

        $blogs= Blog::query()
            ->where('user_id', $id)
            ->get();
        $blogCount = $blogs->count();
        if ($blogCount == 0){
            $blogCount = 'No blog Created yet';
        }
        return view('users.show', compact('user', 'blogCount'));

    }

    public function destroy($id)
    {
        $user = User::query()->find($id);
        $user->destroy($id);
        return redirect()->route('users.all');
    }

    public function editUsers(Request $request)
    {
        $user = User::query()->find($request['id']);

        if ($request->isMethod('post')) {
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
            ]);
            $user = User::query()->find($request['id']);
            $user->update($data);

            return redirect()->route('users.all');
        }

        return view('users.edit', compact('user'));
    }

    public function commentDestroy($id)
    {
        $comment = Comments::query()->find($id);
        $comment->destroy($id);
        return redirect()->route('comment.all');
    }
}
