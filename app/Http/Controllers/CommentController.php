<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function comment(Request $request)
    {

        if ($request->isMethod('post')) {
//            dd($request->post());
            $data = $request->validate([
                'blog_id' => 'required',
                'user_id' => 'required',
                'blogOwner' => 'required',
                'comment_content' => 'required|min:5|max:250',
                'tags.*' => 'int|min:1',
            ]);
//            dd($data);
            Comment::query()->create([
                'blog_id' => $data['blog_id'],
                'user_id' => $data['user_id'],
                'comment_content' => $data['comment_content']
            ]);
            $name = Auth::user()['name'];
            $taggedUser = [];
            foreach ($data['tags'] ?? [] as $t) {
                if ($t != Auth::user()['id']) {
                    $taggedUser[] = [
                        'receiver_id' => ($t),
                        'content' => $name . ' comment on a post you were tagged',
                        'url' => '/blogs/' . $data['blog_id'] . '/show',
                        'status' => 'pending',
                    ];
                    Notification::query()->insert($taggedUser);
                }
            }
            if (Auth::user()['id'] != $data['blogOwner']) {
                Notification::query()->create([
                    'content' => $name . " Commented on your post",
                    'status' => 'pending',
                    'url' => '/blogs/' . $data['blog_id'],
                    'receiver_id' => $data['blogOwner'],
                ]);
            }
            $blog = Blog::query()
                ->select(['blogs.*', 'users.name', 'blogs.user_id'])
                ->join('users', 'users.id', 'blogs.user_id')
                ->where('blogs.id', $data['blog_id'])
                ->first();
            Comment::query()
                ->select(['comments.*', 'users.name', 'users.id as userId'])
                ->join('users', 'users.id', 'comments.user_id')
                ->join('blogs', 'blogs.id', 'comments.blog_id')
                ->where('comments.id', $blog)
                ->get();
            //return redirect()->route('allBlogs');
            return redirect()->route('allblog.show', $data['blog_id']);
        }
        $blogs = Blog::query()->find($request['id']);
        $tags = Tag::query()
            ->where('blog_id', $request['id'])
            ->get();
        return view('comments.index', [
            'blogs' => $blogs,
            'tags' => $tags,
        ]);
    }
}
