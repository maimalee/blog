<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comments;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'user_id' => 'required',
                'blog_title' => 'required|min:5|max:100',
                'blog_content' => 'required|min:20|max:250',
            ]);

            Blog::query()->create([
                'user_id' => $data['user_id'],
                'blog_title' => $data['blog_title'],
                'blog_content' => $data['blog_content'],
            ]);

            return redirect()->route('blogs.index');
        }
        return view('blogs.create');
    }


    public function index()
    {
        $blogs = Blog::query()->orderByDesc('id')
            ->where('user_id', Auth::user()['id'])
            ->paginate(3);
        //dd($blogs);

        return view('blogs.index', [
            'blogs' => $blogs,
        ]);

    }

    public function allBlogs(): Factory|View|Application
    {
        $blogs = Blog::query()->orderByDesc('id')
            ->select(['blogs.*', 'users.name'])
            ->join('users', 'users.id', 'blogs.user_id')
            ->paginate(10);
        return view('blogs.allBlogs', [
            'blogs' => $blogs,
        ]);
    }

    public function show(Request $request)
    {
        $blog = Blog::query()->find($request['id']);
        $comment = Comments::query()
            ->select(['comments.*', 'users.name', 'users.profile as profile'])
            ->join('users', 'users.id', 'comments.user_id')
            ->join('blogs', 'blogs.id', 'comments.blog_id')
            ->where('comments.id', $blog['id'])
            ->get();

        return view('blogs.show', compact('blog'), compact('comment'));
    }

    public function allBlogsShow(Request $request)
    {
        $blog = Blog::query()->orderByDesc('id')
            ->select(['blogs.*', 'users.name', 'users.id as userId'])
            ->join('users', 'users.id', 'blogs.user_id')
            ->where('blogs.id', $request['id'])
            ->first();

        $comment = Comments::query()->orderByDesc('id')
            ->select(['comments.*', 'users.name', 'users.profile as profile'])
            ->join('users', 'users.id', 'comments.user_id')
            ->join('blogs', 'blogs.id', 'comments.blog_id')
            ->where('comments.blog_id', $blog['id'])
            ->get();


        return view('blogs.allBlogShow', compact('blog'), compact('comment'));
    }

    public function edit(Request $request)
    {
        $blog = Blog::query()->find($request['id']);

        if ($request->isMethod('post')){
            $data= $request->validate([
                'blog_title' => 'required',
                'blog_content' => 'required',
            ]);

             $blog->update($data);
            return redirect()->route('blog.show', $blog['id']);
        }

        return \view('blogs.edit', compact('blog'));
    }

    public function destroy($id)
    {
        $blog = Blog::query()->find($id);
        $blog->destroy($id);
        return redirect()->route('blogs.index');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
