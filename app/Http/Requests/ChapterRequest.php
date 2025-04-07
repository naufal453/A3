<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request. Add custom logic if needed.
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'post_id' => 'required|exists:posts,id',
        ];
    }
}