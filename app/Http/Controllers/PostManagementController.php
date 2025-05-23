<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostManagementController extends BaseController
{
    public function savePost($id)
    {
        $post = Post::findOrFail($id);
        auth()->user()->savedPosts()->syncWithoutDetaching([$post->id]);
        return back()->with('Post removed from saved', ['id' => $id]);
    }

    public function unsavePost($id)
    {
        $post = Post::findOrFail($id);
        auth()->user()->savedPosts()->detach($post->id);
        return back()->with('Post removed from saved', ['id' => $id]);
    }

    public function archivePost($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('archive', $post);
        $post->update(['is_archived' => true]);
        return back()->with('success', 'Post archived successfully');
    }

    public function unarchivePost($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('archive', $post);
        $post->update(['is_archived' => false]);
        return back()->with('success', 'Post unarchived successfully');
    }

    public function savedPosts()
    {
        $posts = auth()->user()->savedPosts()->paginate(10);
        return view('posts.saved', compact('posts'));
    }

    public function archivedPosts()
    {

        $posts = auth()->user()->posts()
            ->with(['chapters', 'likes', 'comments'])
            ->where('is_archived', true)
            ->paginate(10);
        return view('posts.archived', compact('posts'));
    }
}
