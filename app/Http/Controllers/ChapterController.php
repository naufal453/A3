<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterRequest;
use App\Models\Chapter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ChapterController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created chapter.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    // Hilangkan tag HTML kosong
                    $plain = trim(strip_tags($value));
                    if ($plain === '') {
                        $fail('The chapter content field is required.');
                    }
                },
            ],
            'post_id' => 'required|exists:posts,id',
        ]);

        $chapter = new Chapter();
        $chapter->title = $request->title;
        $chapter->content = $request->content;
        $chapter->post_id = $request->post_id;
        $chapter->user_id = Auth::id();
        $chapter->save();

        return redirect()->back()->with('success', 'Chapter added successfully.');
    }

    public function show($id)
    {
        $chapter = Chapter::findOrFail($id);
        $post = $chapter->post;
        return view('chapters.show', compact('chapter', 'post'));
    }

    /**
     * Update the specified chapter.
     */
    public function update(ChapterRequest $request, $id)
    {
        $chapter = Chapter::findOrFail($id);
        dd($request->all());
        // Authorization check
        if ($chapter->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // The validated data is automatically available via $request->validated()
        $validated = $request->validated();

        // Update the chapter
        $chapter->update($validated);

        return redirect()->back()->with('success', 'Chapter updated successfully.');
    }

    /**
     * Delete the specified chapter.
     */
    public function destroy($id)
    {
        $chapter = Chapter::find($id);

        // Check if chapter exists
        if (!$chapter) {
            abort(404);
        }

        // Check if user is authorized to delete this chapter
        if ($chapter->user_id !== Auth::id()) {
            abort(403);
        }

        $chapter->delete();

        return redirect()->back()->with('success', 'Chapter deleted successfully.');
    }
}
