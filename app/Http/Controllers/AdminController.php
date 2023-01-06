<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function users()
    {
        if (Auth::user()['role'] == 'admin') {
            $users = User::query()->orderByDesc('id')
                ->where('deleted_at', null)
                ->get();
            $trash = User::onlyTrashed()->get();

            //dd($trash);
            return view('users.all', compact('users', 'trash'));

        }
        echo 'only admin is allow to access this page';
    }
    public function destroyApi(int $id): RedirectResponse
    {
        $user = User::query()->find($id);
        $user->update(['deleted_at' => time()]);
        return redirect()->route('users.all');
    }

    public function recoverApi($id): RedirectResponse
    {
        $recover = User::onlyTrashed()->find($id);
        $recover->restore();
        return redirect()->route('users.all');
    }

    public function add(Request $request): View|Factory|RedirectResponse|Application
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required',
                'password' => 'required',
            ]);

            User::query()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'password' => Hash::make($data['password']),
            ]);

            return redirect()->route('users.all');
        }

        return view('users.add');
    }

    public function comment(): Factory|View|Application
    {
        $comment = Comment::query()
            ->select(['comments.*', 'users.name', 'blogs.id as blog_id'])
            ->join('blogs', 'blogs.id', 'comments.blog_id')
            ->join('users', 'users.id', 'comments.user_id')
            ->paginate('5');
        return view('comments.all', compact('comment'));
    }

    public function blog(): Factory|View|Application
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

        $blogs = Blog::query()
            ->where('user_id', $id)
            ->get();
        $likes = Like::query()
            ->where('user_id', $id)
            ->get();
        $totalLike = $likes->count();
//        dd($totalLike);
        $blogCount = $blogs->count();
        if ($blogCount == 0) {
            $blogCount = 'No blog Created yet';
        }
        $comment = Comment::query()
            ->where('user_id', $id)
            ->get();
        $totalComment = $comment->count();
        //dd($totalComment);
        return view('users.show', [
            'user' => $user,
            'blogCount' => $blogCount,
            'totalComment' => $totalComment,
            'totalLike' => $totalLike,
        ]);
    }
    public function editBlogUn(Request $request): Factory|View|Application|RedirectResponse
    {
        $blog = Blog::query()->find($request['id']);
        if ($request->isMethod('post')) {
//            dd($request->post());
            $data = $request->validate([
                'blog_content' => 'required',
            ]);
            $blog = Blog::query()->find($request['id']);
            $blog->update(['blog_content' => $data['blog_content']]);
//            dd($blog);
            return redirect()->route('admin.blogs');
        }

        return \view('blogs.edit', compact('blog'));

    }
    public function editUsers(Request $request): View|Factory|RedirectResponse|Application
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

    public function commentDestroy($id): RedirectResponse
    {
        $comment = Comment::query()->find($id);
        $comment->destroy($id);
        return redirect()->route('comment.all');
    }

    public function commentEdit(Request $request): Factory|View|Application|RedirectResponse
    {
        $comment = Comment::query()->find($request['id']);
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'comment_content' => 'required|min:5|max:1000',
            ]);
            $comment = Comment::query()->find($request['id']);
            $comment->update(['comment_content' => $data['comment_content']]);
            return redirect()->route('comment.all');

        }

        return \view('admin.edit-comment', [
            'comment' => $comment,
        ]);
    }
}
