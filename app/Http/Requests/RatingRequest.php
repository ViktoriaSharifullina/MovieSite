<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'movie_tmdb_id' => 'required|integer',
            'rating_value' => 'required|integer|between:0,10',
        ];
    }
}
