<?php

namespace Cyaxaress\Course\Http\Requests;

use Cyaxaress\Course\Rules\ValidSeason;
use Cyaxaress\Media\Services\MediaFileService;
use Illuminate\Foundation\Http\FormRequest;

class LessonRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required|min:3|max:190',
            'slug' => 'nullable|min:3|max:190',
            'number' => 'nullable|numeric',
            'time' => 'required|numeric|min:0|max:255',
            'season_id' => [new ValidSeason()],
            'is_free' => 'required|boolean',
            'lesson_file' => 'required|file|mimes:avi,mkv,mp4,zip,rar',
        ];

        if (request()->method === 'PATCH') {
            $rules['lesson_file'] = 'nullable|file|mimes:'.MediaFileService::getExtensions();
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'title' => 'Lesson Title',
            'slug' => 'Lesson English Title',
            'number' => 'Lesson Number',
            'time' => 'Lesson Duration',
            'season_id' => 'Chapter',
            'free' => 'Free',
            'lesson_file' => 'Lesson File',
            'body' => 'Lesson Description',
        ];
    }
}
