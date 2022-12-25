<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Friend;
use App\Models\Like;
use App\Models\LikeComment;
use App\Models\LikeReply;
use App\Models\Notification;
use App\Models\Reply;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function create(Request $request): View|Factory|RedirectResponse|Application
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'user_id' => ['required', Rule::exists('users', 'id')],
                'blog_content' => 'required',
                'tags.*' => 'int|min:1|exists:users,id',
                'filename' => 'min:1',
                'filename.*' => 'image|mimes:jpg,jpeg,png',
            ]);
            $images = [];
            if ($request->hasFile('filename')) {
                foreach ($request->file('filename') as $image) {
                    $name = $image->getClientOriginalName();
                    $image->move(public_path() . '/images/', $name);
                    $images[] = ($name);

                }
                $blog = Blog::query()->create([
                    'user_id' => $data['user_id'],
                    'blog_content' => $data['blog_content'],
                    'images' => json_encode($images),
                ]);
            } else {
                $blog = Blog::query()->create([
                    'user_id' => $data['user_id'],
                    'blog_content' => $data['blog_content'],
                ]);
            }


//                $images = new Image();
//                $images->image = json_encode($data);
//                $images->save();
//               dd($data['tags']);

//           dd($blog['id']);

            $tagData = [];
            foreach ($data['tags'] ?? [] as $tags) {
                $tagData[] = [
                    'blog_owner' => $data['user_id'],
                    'blog_id' => $blog['id'],
                    'tagged_friend' => $tags,
                ];
            }

            Tag::query()->insert($tagData);

            $tag = Tag::query()
                ->select(['tags.*', 'users.name as name'])
                ->join('users', 'users.id', 'tags.tagged_friend')
                ->join('blogs', 'blogs.id', 'tags.blog_id')
                ->where('tags.blog_id', $blog['id'])
                ->get();
//            dd($tag);
            $totalTag = $tag->count();
//            dd($totalTag);
            $name = Auth::user()['name'];
            $taggedUser = [];
            if ($totalTag > 0) {
                foreach ($data['tags'] ?? [] as $t) {
                    $taggedUser[] = [
                        'receiver_id' => $t,
                        'content' => 'Your Friend ' . $name . ' tagged you in his post',
                        'url' => 'blogs/' . $blog['id'] . '/show',
                        'status' => 'pending',

                    ];
                }
                Notification::query()->insert($taggedUser);
            } else {
                $friends = Friend::query()
                    ->select(['friends.*', 'users.name as name'])
                    ->join('users', 'users.id', 'friends.user_id')
                    ->where('friends.user_id', Auth::user()['id'])
                    ->where('friends.status', 'accepted')
                    ->get();
//            dd($friends);
                $name = Auth::user()['name'];

//

                if (!empty($friends)) {
                    foreach ($friends as $f) {
                        Notification::query()->create([
                            'receiver_id' => $f['friend_id'],
                            'content' => 'Your Friend ' . $name . ' Create a new Blog',
                            'url' => 'blogs/' . $blog['id'] . '/show',
                            'status' => 'pending',
                        ]);
                    }
                }
            }

            return redirect()->route('blogs.index');
        }

//        if (Auth::user()?->name != 'Anas Maimalee'){
//            abort(Response::HTTP_FORBIDDEN);
//        }
        $friends = Friend::query()
            ->select(['friends.*', 'users.name as name', 'users.id as userId'])
            ->join('users', 'users.id', 'friends.friend_id')
            ->where('user_id', Auth::user()['id'])
            ->where('friends.status', 'accepted')
            ->get();
//dd($friends);
        return view('blogs.create', [
            'friends' => $friends,
        ]);

    }


    public function index(): Factory|View|Application
    {
        $blogs = Blog::query()->orderByDesc('id')
            ->where('user_id', Auth::user()['id'])
            ->paginate(10);
        //dd($blogs);

        return view('blogs.index', [
            'blogs' => $blogs,
        ]);

    }

    public function allBlogs(Request $request): Factory|View|Application
    {
//        $number =[];
//        for ($x = 1; $x<= 100; $x++){
//            if ($x % 3 ==0 && $x % 5==0 ){
//                $number[] = 'FizzBuzz';
//            }
//            elseif ($x % 3 == 0){
//                $number[]= 'Fizz';
//            }
//
//            else{
//                $number[] = $x;
//            }
//        }
//        dd($number);
        if ($request->isMethod('post')) {
            $tagged = $request->validate([
                'blog_id' => 'required',
            ]);

            $tags = Tag::query()
                ->select(['tags.*'])
                ->join('blogs', 'blogs.id', 'tags.blog_id')
                ->join('users', 'users.id', 'tags.tagged_friend')
                ->where('tags.blog_id', $tagged['blog_id'])
                ->get();
//            dd($tags);
            $data = $request->validate([
                'blog_id' => 'required',
                'user_id' => 'required',
                'blog_owner' => 'required',
//                'tags.*' => 'int|min:1',
            ]);
            $like = Like::query()
                ->where('user_id', Auth::user()['id'])
                ->where('blog_id', $data['blog_id'])
                ->first();
//            dd($like);
            if (empty($like)) {
                $blogLike = Like::query()->create([
                    'blog_id' => $data['blog_id'],
                    'user_id' => $data['user_id'],
                ]);
                $name = Auth::user()['name'];
                Notification::query()->create([
                    'receiver_id' => $data['blog_owner'],
                    'content' => $name . ' Like your post',
                    'url' => '/blogs/' . $data['blog_id'] . '/show',
                    'status' => 'pending',
                ]);
//                dd($blogLike);
                $name = Auth::user()['name'];
                $taggedUser = [];
                foreach ($tags['tagged_friend'] ?? [] as $t) {
                    if ($t != Auth::user()['id']) {
                        $taggedUser[] = [
                            'receiver_id' => ($t),
                            'content' => $name . ' Like a post you were tagged',
                            'url' => '/blogs/' . $data['blog_id'] . '/show',
                            'status' => 'pending',
                        ];
//                        dd($taggedUser);
                        Notification::query()->insert($taggedUser);
                    }
                }
            }

        }

        $blogs = Blog::query()
            ->select(['blogs.*', 'blogs.id as bId', 'users.name', 'users.profile as profile', 'users.id as userId'])
            ->join('users', 'users.id', 'blogs.user_id')
            ->selectSub(function (Builder $builder) {
                $builder->selectRaw('COUNT(likes_id)')
                    ->from('likes')
                    ->whereRaw('likes.blog_id = blogs.id');
            },'likes')
//            ->leftJoin('tags','tags.tagged_friend', 'friends.friend_id')
            ->whereIn('user_id', function (Builder $builder) {
                $builder->select('user_id')
                    ->from('friends')
                    ->where('friend_id', Auth::id())
                    ->where('status', 'accepted');
            })->orWhereIn('user_id', function (Builder $builder) {
                $builder->select('friend_id')
                    ->from('friends')
                    ->where('user_id', Auth::id())
                    ->where('status', 'accepted');
            })
            ->orderByDesc('id')
            ->get();


//dd($blogs);

        foreach ($blogs as $blog) {
            $decodedImages = json_decode($blog['images'], true) ?? [];
            $decodedImages = array_splice($decodedImages, 0, 4);
            $chunked = array_chunk($decodedImages, 2);
            $blog['image_chunks'] = $chunked;
        }

        return view('blogs.allBlogs', [
            'blogs' => $blogs,
//            'tags' => $tags,
//            'number' => $number,
        ]);


    }

    public function show(Request $request): Factory|View|Application
    {
        if ($request->isMethod('post')) {
            $data = $request->validate([
                'user_id' => ['required', Rule::exists('users', 'id')],
                'blog_id' => ['required', Rule::exists('blogs', 'id')],
                'comment_id' => ['required', Rule::exists('comments', 'id')],
                'reply_content' => 'required',
            ]);
//            dd($data);
            Reply::query()->create([
                'user_id' => $data['user_id'],
                'blog_id' => $data['blog_id'],
                'comment_id' => $data['comment_id'],
                'reply_content' => $data['reply_content'],
            ]);
        }

        $blog = Blog::query()->find($request['id']);
        $comment = Comment::query()
            ->select(['comments.*', 'users.name', 'users.profile as profile'])
            ->join('users', 'users.id', 'comments.user_id')
            ->join('blogs', 'blogs.id', 'comments.blog_id')
            ->where('comments.blog_id', $blog['id'])
            ->orderByDesc('id')
            ->get();
        $comm = $comment->count();

//         dd($comm);
        return view('blogs.show', compact('blog'), compact('comment', 'comm'));
    }

    public function allBlogsShow(Request $request): Factory|View|Application
    {

        if ($request->isMethod('post')) {
            $data = $request->validate([
                'user_id' => ['required', Rule::exists('users', 'id')],
                'blog_id' => ['required', Rule::exists('blogs', 'id')],
                'comment_id' => ['required', Rule::exists('comments', 'id')],
                'reply_content' => 'required',
                'comment_owner' => 'required',
            ]);
//            dd($data);

            Reply::query()->create([
                'user_id' => $data['user_id'],
                'blog_id' => $data['blog_id'],
                'comment_id' => $data['comment_id'],
                'reply_content' => $data['reply_content'],
            ]);
            if (Auth::user()['id'] != $data['comment_owner']) {
                $name = Auth::user()['name'];
                Notification::query()->create([
                    'receiver_id' => $data['user_id'],
                    'content' => $name . ' reply to a comment on your blog',
                    'url' => '/blogs/' . $data['blog_id'] . '/show',
                    'status' => 'pending',
                ]);
            }


            if (Auth::user()['id'] != $data['comment_owner']) {
                $name = Auth::user()['name'];
                Notification::query()->create([
                    'receiver_id' => $data['comment_owner'],
                    'content' => $name . ' reply to your comment',
                    'url' => '/blogs/' . $data['blog_id'] . '/show',
                    'status' => 'pending',
                ]);
            }
        }

//        dd(Auth::user()['id']);


        $blog = Blog::query()
            ->select(['blogs.*', 'users.name', 'users.id as userId', 'users.profile as profile'])
            ->join('users', 'users.id', 'blogs.user_id')
            ->where('blogs.id', $request['id'])
            ->first();

        $decodedImages = json_decode($blog['images'], true) ?? [];
        $decodedImages = array_splice($decodedImages, 0);
        $chunked = array_chunk($decodedImages, 2);
        $blog['image_chunks'] = $chunked;


        $comment = Comment::query()->orderByDesc('id')
            ->select(['comments.*', 'users.name', 'users.id as userId', 'users.profile as profile'])
            ->selectSub(function (Builder $builder) {
                $builder->selectRaw('COUNT(id)')
                    ->from('like_comments')
                    ->whereRaw('like_comments.comment_id = comments.id');
            }, 'total_likes')

            ->join('users', 'users.id', 'comments.user_id')
            ->join('blogs', 'blogs.id', 'comments.blog_id')
            ->where('comments.blog_id', $blog['id'])
            ->get();

//        dd($comment);
        $comm = $comment->count();
//dd($comm);
        $replies = Reply::query()
            ->select(['replies.*', 'users.name', 'users.profile as profile'])
            ->selectSub(function (Builder $builder){
                $builder->selectRaw('COUNT(id)')
                    ->from('like_replies')
                    ->whereRaw('like_replies.reply_id = replies.id');
            }, 'total_reply_likes' )
            ->join('users', 'users.id', 'replies.user_id')
            ->join('comments', 'comments.id', 'replies.comment_id')
            ->join('blogs', 'blogs.id', 'replies.blog_id')
            ->where('replies.blog_id', $blog['id'])
            ->get();
//        dd($replies);
        $tags = Tag::query()
            ->select(['tags.*'])
            ->where('tags.blog_id', $request['id'])
            ->get();
//        dd($tags);
        $likes = Like::query()
            ->where('blog_id', $blog['id'])
            ->count();

        $likesComment = LikeComment::query()
            ->select(['like_comments.*'])
            ->join('comments', 'comments.id', 'like_comments.comment_id')
            ->where('like_comments.blog_id', $blog['id'])
            ->get();
//        dd($likesComment);
        $likeComment = $likesComment->count();
//        dd($likeComment);
//        dd($likes);
//        $likeComment_id  = $likesComment['comment_id'];

        return view('blogs.allBlogShow', [
            'blog' => $blog,
            'comm' => $comm,
            'comment' => $comment,
            'reply' => $replies,
            'likes' => $likes,
            'tags' => $tags,
            'likesComment' => $likesComment,
            'likeComment' => $likeComment,
        ]);
    }

    public function edit(Request $request): Factory|View|Application|RedirectResponse
    {
        $blog = Blog::query()->find($request['id']);

//        dd($blog);
        if ($request->isMethod('post')) {
//            dd($request->post());
            $data = $request->validate([
                     'blog_content' => 'required',
            ]);

            $blog->update(['blog_content' => $data['blog_content']]);
//            dd($blog);
            return redirect()->route('blogs.index');
        }

        return \view('blogs.edit', compact('blog'));
    }

    public function destroy($id): RedirectResponse
    {
        $blog = Blog::query()->find($id);
        $blog->destroy($id);
        return redirect()->route('blogs.index');
    }
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect()->route('home');
    }


}
