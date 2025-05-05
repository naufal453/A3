<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Notifications\LikeNotification;

class LikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $like = Like::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
        ]);

        // Notify the post owner if liker is not the owner
        $post = Post::find($request->post_id);
        if ($post && $post->user_id !== Auth::id()) {
            $post->user->notify(new LikeNotification(Auth::user(), $post));
        }

        $likesCount = Like::where('post_id', $request->post_id)->count();

        return response()->json(['success' => true, 'likes_count' => $likesCount]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $like = Like::where('user_id', Auth::id())
            ->where('post_id', $request->post_id)
            ->first();

        if ($like) {
            $like->delete();
        }

        $likesCount = Like::where('post_id', $request->post_id)->count();

        return response()->json(['success' => true, 'likes_count' => $likesCount]);
    }
}
