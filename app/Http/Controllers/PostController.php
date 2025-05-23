<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StorePostRequest;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Models\Chapter;
use App\Models\Genre;


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
        $genres = Genre::all(); // or however you fetch genres
        return view('home.post.add', compact('genres'));
    }

    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->id();
        $post->reference = $request->reference;
        $post->genre = $request->filled('genre_custom') ? $request->genre_custom : $request->genre_select;

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

        // If post is archived and either guest or not the owner, show 404
        if ($post->is_archived && (auth()->guest() || auth()->id() !== $post->user_id)) {
            abort(404);
        }

        return view('home.post.detail', compact('post', 'chapters'));
    }

    public function edit($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->view('errors.404', ['errorType' => 'post'], 404);
        }
        $this->authorize('update', $post);
        return view('home.post.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        //$iduser=Auth::users();
        //dd($id);
        $post = Post::find($id);
        if (!$post) {
            return response()->view('errors.404', ['errorType' => 'post'], 404);
        }
        //$this->authorize('update', $post);

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
        $post = Post::find($id);
        if (!$post) {
            return response()->view('errors.404', ['errorType' => 'post'], 404);
        }
        $this->authorize('delete', $post);

        $post->delete();

        return $this->successResponse(
            'user.show',
            'Post deleted successfully',
            ['username' => $post->user->username]
        );
    }


}
