<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller{
    public function store(CommentRequest $request)
    {
        $comment = new Comment();
        $comment->content = strip_tags($request->content); // Sanitize input
        $comment->user_id = Auth::id();
        $comment->post_id = $request->post_id;
        $comment->save();

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => e($comment->content), // Escape output
                'created_at' => $comment->created_at->format('d M Y, H:i'),
                'user' => [
                    'id' => $comment->user_id,
                    'username' => Auth::user()->username,
                ],
            ],
            'auth_user_id' => Auth::id(),
        ]);
    }

    public function destroy(Request $request){
        $comment = Comment::find($request->id);
        if($comment->user_id == Auth::id()){
            $comment->delete();
        }
        return redirect()->back();
    }
}