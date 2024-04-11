<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'movie_tmdb_id' => 'required|integer',
            'media_type' => 'required|in:movie,tv',
            'comment' => 'required|string|max:5000',
        ];
    }
}
