<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        return 
            [
                'name' =>'required|string',
                'email' =>'required|string|email|unique:users,id,'.$this->id,
                'status' =>'required',
                'role' =>'required',
            ];
        
    }
}
