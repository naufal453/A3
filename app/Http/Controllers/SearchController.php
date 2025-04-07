<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Search logic (adjust fields as needed)
        $results = Post::where('title', 'like', "%{$query}%")
                       ->orWhere('description', 'like', "%{$query}%")
                       ->get();

        return view('home.search', compact('results'));
    }
}
