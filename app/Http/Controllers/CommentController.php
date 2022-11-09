<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comments;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'blog_id' => 'required',
                'user_id' => 'required',
                'comment_content' => 'required|min:5|max:250',
            ]);
            Comments::query()->create([
                'blog_id' => $data['blog_id'],
                'user_id' => $data['user_id'],
                'comment_content' => $data['comment_content']
            ]);

            $blog = Blog::query()
                ->select(['blogs.*', 'users.name'])
                ->join('users', 'users.id', 'blogs.user_id')
                ->where('blogs.id', $data['blog_id'])
                ->first();


            $comment = Comments::query()
                ->select(['comments.*', 'users.name', 'users.id as userId'])
                ->join('users', 'users.id', 'comments.user_id')
                ->join('blogs', 'blogs.id', 'comments.blog_id')
                ->where('comments.id', $blog)
                ->get();
           // dd($comment);
            //return redirect()->route('allBlogs');
            return redirect()->route('allblog.show', $data['blog_id']);
        }

        $blogs = Blog::query()->find($request['id']);

        return view('comments.index', compact('blogs'));
    }



}
