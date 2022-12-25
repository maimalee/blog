<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Like;
use App\Models\LikeComment;
use App\Models\LikeReply;
use App\Models\Notification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class LikesController extends Controller
{

    public function likeBlogApi(int $id, Request $request): JsonResponse
    {
        $userId = $request->get('userId');
        $blog = Blog::query()->find($id);

        if (null == $blog) {
            throw new ModelNotFoundException('Such blog does not exists');
        }

        $existing = Like::query()
            ->select('likes_id')
            ->where('user_id', $userId)
            ->where('blog_id', $id)
            ->first();

        if ($existing) {
            $existing->delete();

            return response()->json([
                'success' => true,
                'decrement' => true
            ]);
        } else {
            Like::query()->create([
                'blog_id' => $id,
                'user_id' => $userId,
            ]);
        }

        return response()->json([
            'success' => true,
            'increment' => true
        ]);
    }

    public function likeBlogComment(int $bid, int $cid, Request $request): JsonResponse
    {
        $userId = $request->get('userId');
        $blog = Blog::query()->find($bid);

        if (null == $blog) {
            throw new ModelNotFoundException('such blog does not exist');
        }

        $existing = LikeComment::query()
            ->where('comment_id', $cid)
            ->where('blog_id', $bid)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success' => true,
                'decrement' => true,
            ]);
        } else {
            LikeComment::query()->create([
                'comment_id' => $cid,
                'user_id' => $userId,
                'blog_id' => $bid,
            ]);
        }

        return response()->json([
            'success' => true,
            'increment' => true,
        ]);
    }

    public function likeBlogReply(int $bid, $cid, $rid, Request $request): JsonResponse
    {
//        Log::debug($cid);
        $userId = $request->get('userId');
        $blog = Blog::query()->find($bid);
        if (null == $blog) {
            throw new ModelNotFoundException('such blog does not exist');
        }

        $existing = LikeReply::query()
            ->where('blog_id', $bid)
            ->where('user_id', $userId)
            ->where('comment_id', $cid)
            ->where('reply_id', $rid)
            ->first();
        if ($existing){
            $existing->delete();
            return response()->json([
                'success' => true,
                'decrement' => true,
            ]);
        }
        else{
            LikeReply::query()->create([
                'blog_id' => $bid,
                'user_id' => $userId,
                'comment_id' =>$cid,
                'reply_id' =>$rid,
            ]);
        }
        return response()->json([
            'success' => true,
            'increment' => true,
        ]);
    }
}
