<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StorePostRequest;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Chapter;

class PostController extends BaseController
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    public function index(Request $request)
    {
        $sort = $request->get('sort', 'latest');
        $query = Post::withCount('likes')->where('is_archived', false);

        $posts = match($sort) {
            'oldest' => $query->orderBy('created_at', 'asc')->get(),
            'most_liked' => $query->orderBy('likes_count', 'desc')->get(),
            default => $query->orderBy('created_at', 'desc')->get(),
        };

        return view('home.index', compact('posts'));
    }

    public function create()
    {
        return view('home.index');
    }

    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $post->image_path = $this->imageUploadService->upload($request->file('image'));
        }

        $post->save();

        return $this->successResponse(
            'user.show',
            'Post created successfully',
            ['username' => auth()->user()->username]
        );
    }

    public function show($id)
    {
        $post = Post::with(['user'])->findOrFail($id);
        $chapters = Chapter::where('post_id', $id)->get();

        return view('home.post.detail', compact('post', 'chapters'));
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);
        return view('home.post.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post->update($validated);

        return $this->successResponse(
            'user.show',
            'Post updated successfully',
            ['username' => $post->user->username]
        );
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $this->authorize('delete', $post);

        $post->delete();

        return $this->successResponse(
            'user.show',
            'Post deleted successfully',
            ['username' => $post->user->username]
        );
    }
}
