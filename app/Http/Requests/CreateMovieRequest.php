<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMovieRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      "title" => 'required|string',
      "director" => 'required|string',
      "image_url" => 'required|string',
      'duration' => 'required|integer|min:0',
      'release_date' => 'required|date_format:Y-m-d',
      'genre' => 'required|string|in:' . implode(',', ['sci-fi', 'documentary', 'action'])
    ];
  }
}
