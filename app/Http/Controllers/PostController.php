<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StorePostRequest;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Chapter;
use App\Models\Genre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class PostController extends BaseController
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $imageUploadService)
    {
        $this->imageUploadService = $imageUploadService;
    }

    // Tampilkan daftar postingan
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'latest');
        $query = Post::withCount('likes')->where('is_archived', false);

        $posts = match ($sort) {
            'oldest' => $query->orderBy('created_at', 'asc')->get(),
            'most_liked' => $query->orderBy('likes_count', 'desc')->get(),
            default => $query->orderBy('created_at', 'desc')->get(),
        };

        return view('home.index', compact('posts'));
    }

    // Form tambah postingan
    public function create()
    {
        $genres = Genre::all();
        return view('home.post.add', compact('genres'));
    }

    // Simpan postingan baru
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

    // Detail postingan
    public function show($id)
    {
        $post = Post::with('user')->find($id);
        if (!$post) {
            return response()->view('errors.404', ['errorType' => 'post'], 404);
        }

        try {
            $this->authorize('view', $post);
        } catch (AuthorizationException $e) {
            // Pengunjung tidak berhak melihat post ini
            return response()->view('errors.404', ['errorType' => 'post'], 404);
        }

        $chapters = Chapter::where('post_id', $id)->get();

        return view('home.post.detail', compact('post', 'chapters'));
    }

    // Form edit
    public function edit($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->view('errors.404', ['errorType' => 'post'], 404);
        }

        $this->authorize('update', $post);
        return view('home.post.edit', compact('post'));
    }

    // Update data postingan
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->view('errors.404', ['errorType' => 'post'], 404);
        }

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

    // Hapus postingan
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

    public function like($id)
    {
        $post = Post::findOrFail($id);
        $user = auth()->user();

        // Prevent duplicate likes
        if (!$post->likes->contains('user_id', $user->id)) {
            $post->likes()->create(['user_id' => $user->id]);
        }

        return back();
    }

    public function unlike($id)
    {
        $post = Post::findOrFail($id);
        $user = auth()->user();

        $post->likes()->where('user_id', $user->id)->delete();

        return back();
    }
}
