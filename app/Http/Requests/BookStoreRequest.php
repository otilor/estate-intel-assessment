<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'isbn' => 'required|string',
            'authors' => 'required|array',
            'authors.*' => 'required|string|distinct',
            'country' => 'required|string',
            'number_of_pages' => 'required|integer',
            'publisher' => 'required|string',
            'release_date' => 'required|date',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'isbn.required' => 'ISBN is required',
            'authors.required' => 'Authors are required',
            'authors.*.required' => 'Authors are required',
            'authors.*.distinct' => 'Authors must be unique',
            'country.required' => 'Country is required',
            'number_of_pages.required' => 'Number of pages is required',
            'number_of_pages.integer' => 'Number of pages must be an integer',
            'publisher.required' => 'Publisher is required',
            'release_date.required' => 'Release date is required',
            'release_date.date' => 'Release date must be a date',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }
}
