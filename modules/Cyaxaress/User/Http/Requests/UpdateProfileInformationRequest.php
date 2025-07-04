<?php

namespace Cyaxaress\User\Http\Requests;

use Cyaxaress\RolePermissions\Models\Permission;
use Cyaxaress\User\Rules\ValidPassword;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileInformationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:190',
            'email' => 'required|email|min:3|max:190|unique:users,email,'.auth()->id(),
            'username' => 'nullable|min:3|max:190|unique:users,username,'.auth()->id(),
            'mobile' => 'nullable|unique:users,mobile,'.request()->route('user'),
            'password' => ['nullable', new ValidPassword()],
        ];

        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)) {
            $rules += [
                'card_number' => 'required|string|size:16',
                'shaba' => 'required|size:24',
                'headline' => 'required|min:3|max:60',
                'bio' => 'required',
            ];
            $rules['username'] = 'required|min:3|max:190|unique:users,username,'.auth()->id();
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'shaba' => 'Bank Shaba Number',  // "شماره شبای بانکی" → "Bank Shaba Number"
            'card_number' => 'Bank Card Number',  // "شماره کارت بانکی" → "Bank Card Number"
            'username' => 'Username',  // "نام کاربری" → "Username"
            'headline' => 'Headline',  // "عنوان" → "Headline"
            'bio' => 'Bio',  // "بیو" → "Bio"
            'password' => 'New Password',  // "رمز عبور جدید" → "New Password"
            'mobile' => 'Mobile',  // "موبایل" → "Mobile"
        ];
    }
}
