<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChapterRequest;
use App\Models\Chapter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Store a newly created chapter.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
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

        if ($chapter && $chapter->user_id == Auth::id()) {
            $chapter->delete();
        }

        return redirect()->back()->with('success', 'Chapter deleted successfully.');
    }
}
