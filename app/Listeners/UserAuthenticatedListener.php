<?php

namespace App\Listeners;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Friend;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class UserAuthenticatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $notifications = Notification::query()
            ->where('receiver_id', $event->user['id'])
            ->where('status', 'pending')
            ->count();
//        $notifications = 2;

        $blog = Blog::query()
            ->where('user_id', $event->user['id'])
            ->count();
        //dd($blogs);

        $fBlogs = Blog::query()
            ->select(['blogs.*', 'users.name'])
            ->join('users', 'users.id', 'blogs.user_id')
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
            ->count();
        $friends = Friend::query()
            ->where('user_id', Auth::user()['id'])
            ->where('status', 'accepted')
            ->count();

        $users = User::query()
            ->count();
//        dd($users);

        $comment = Comment::query()
            ->count();

        $blogs = Blog::query()
            ->count();

        View::share('global', [
            'notifications' => $notifications,
            'singleUserBlogs' => $blog,
            'friendsBlogs' => $fBlogs,
            'TotalFriends' => $friends,
            'users' => $users,
            'comments' => $comment,
            'blogs' => $blogs,

        ]);
    }
}
