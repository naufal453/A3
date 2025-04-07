<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Chapter;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the sorting parameter from the request
        $sort = $request->get('sort', 'latest'); // Default is 'latest'

        if ($sort == 'oldest') {
            $posts = Post::withCount('likes')->orderBy('created_at', 'asc')->get();
        } elseif ($sort == 'most_liked') {
            $posts = Post::withCount('likes')->orderBy('likes_count', 'desc')->get();
        } else {
            $posts = Post::withCount('likes')->orderBy('created_at', 'desc')->get();
        }

        return view('home.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('home.index'); // This is redundant since the modal is part of the index view
    }

    /**
     * Store a newly created resource in storage.
     */
    protected $imageUploadService;

        public function __construct(ImageUploadService $imageUploadService)
        {
            $this->imageUploadService = $imageUploadService;
        }

        public function store(Request $request)
        {
            $post = new Post();
            $post->title = $request->title;
            $post->description = $request->description;
            $post->user_id = Auth::id();

            if ($request->hasFile('image')) {
                $post->image_path = $this->imageUploadService->upload($request->file('image'));
            }

            $post->save();

            return redirect()->route('user.show', ['username' => Auth::user()->username])
                             ->with('success', 'Post created successfully.');
        }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        $chapters = Chapter::where('post_id', $id)->get(); // Ambil chapter terkait post

        return view('home.post.detail', compact('post', 'chapters'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Authorization check
        if ($post->user_id != Auth::id()) {
            return redirect()->route('user.show', ['username' => Auth::user()->username])
                             ->with('error', 'Unauthorized action.');
        }

        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $post->update($validated);

        return redirect()->route('user.show', ['username' => $post->user->username])
                         ->with('flash_message', 'Post Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Authorization check
        if ($post->user_id != Auth::id()) {
            return redirect()->route('user.show', ['username' => Auth::user()->username])
                             ->with('error', 'Unauthorized action.');
        }

        $post->delete();

        return redirect()->route('user.show', ['username' => $post->user->username])
                         ->with('flash_message', 'Post Deleted!');
    }
}
