<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller{
    public function store(CommentRequest $request)
    {
        $comment = new Comment();
        $comment->content = strip_tags($request->content); // Sanitize input
        $comment->user_id = Auth::id();
        $comment->post_id = $request->post_id;
        $comment->save();

        // Notify the post owner if commenter is not the owner
        // $post = Post::find($request->post_id);
        // if ($post && $post->user_id !== Auth::id()) {
        //     $post->user->notify(new CommentNotification(Auth::user(), $post, $comment->content));
        // }

        // Redirect back to the post page (no JSON)
        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function destroy(Request $request){
        $comment = Comment::find($request->id);
        if($comment->user_id == Auth::id()){
            $comment->delete();
        }
        return redirect()->back();
    }
}
