<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
        $rules= [
            'title'=>'required|max:255',
            'body'=>'required|max:5000',
            'image'=>'required|image|mimes:jpg,png,jpeg|max:5000',
        ];
        if($this->isMethod("PUT")){
            $rules['image'] = 'nullable|image|mimes:jpg,png,jpeg|max:5000';
        }
        return $rules;
    }
}
