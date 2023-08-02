<?php

namespace App\Http\Requests\Adverts;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends FormRequest
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
        $items = [];
        foreach ($this->category->allAttributes() as $attribute) {
            $rules = [ $attribute->required ? 'required' : 'nullable' ];
            if ($attribute->isInteger()) {
                $rules[] = 'integer';
            } elseif ($attribute->isFloat()) {
                $rules[] = 'numeric';
            } else {
                $rules[] = 'string';
            }
            if ($attribute->isSelect()) {
                $rules[] = Rule::in($attribute->variants);
            }
            $items['attribute.' . $attribute->id] = $rules;

        }
        return array_merge(
            [
                'title' => 'required|string',
                'content' => 'required|string',
                'address' => 'required|string'
            ],$items
        );
    }
}
