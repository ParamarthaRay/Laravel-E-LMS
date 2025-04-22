<?php

namespace Cyaxaress\Discount\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        $rules = [
            'code' => 'nullable|max:50|unique:discounts,code',
            'percent' => 'required|numeric|min:1|max:100',
            'usage_limitation' => 'nullable|numeric|min:0|max:1000000000',
            'expire_at' => 'nullable|date|after:today',
            'courses' => 'nullable|array',
            'type' => 'required',
        ];

        if ($this->getMethod() === 'PATCH') {
            $rules['code'] = 'nullable|max:50|unique:discounts,code,'.$this->route('discount')->id;
        }

        return $rules;
    }
}
