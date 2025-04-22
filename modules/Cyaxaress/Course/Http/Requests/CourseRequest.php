<?php

namespace Cyaxaress\Course\Http\Requests;

use Cyaxaress\Course\Models\Course;
use Cyaxaress\Course\Rules\ValidTeacher;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|min:3|max:190',
            'slug' => 'required|min:3|max:190|unique:courses,slug',
            'priority' => 'nullable|numeric',
            'price' => 'required|numeric|min:0|max:10000000',
            'percent' => 'required|numeric|min:0|max:100',
            'teacher_id' => ['sometimes', 'exists:users,id', new ValidTeacher()],
            'type' => ['required', Rule::in(Course::$types)],
            'status' => ['required', Rule::in(Course::$statuses)],
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|mimes:jpg,png,jpeg',
        ];

        if (request()->method === 'PATCH') {
            $rules['image'] = 'nullable|mimes:jpg,png,jpeg';
            $rules['slug'] = 'required|min:3|max:190|unique:courses,slug,'.request()->route('course');
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'price' => 'Price',
            'slug' => 'English Title',
            'priority' => 'Course Order',
            'percent' => 'Instructor Percentage',
            'teacher_id' => 'Instructor',
            'category_id' => 'Category',
            'status' => 'Status',
            'type' => 'Type',
            'body' => 'Description',
            'image' => 'Course Banner',
        ];
    }

    public function messages()
    {
        return [];
    }
}
