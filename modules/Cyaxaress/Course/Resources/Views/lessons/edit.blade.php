@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('courses.index') }}" title="Courses">Courses</a></li>
    <li><a href="{{ route('courses.details', $course->id) }}" title="{{ $course->title }}">{{ $course->title }}</a></li>
    <li><a href="#" title="Update Lesson">Update Lesson</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">Update Lesson</p>
            <form action="{{ route('lessons.update', [$course->id, $lesson->id ]) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <x-input name="title" placeholder="Lesson Title *" type="text" value="{{ $lesson->title }}" required/>
                <x-input type="text" name="slug" placeholder="Optional English Name of the Lesson" class="text-left" value="{{ $lesson->slug }}" />
                <x-input type="number" name="time" placeholder="Session Duration *" class="text-left" value="{{ $lesson->time }}" required />
                <x-input type="number" name="number" placeholder="Session Number" class="text-left" value="{{ $lesson->number }}"/>

                @if(count($seasons))
                    <x-select name="season_id" required>
                        <option value="">Select Lesson Chapter *</option>
                        @foreach($seasons as $season)
                        <option value="{{ $season->id }}" @if($season->id == $lesson->season_id) selected @endif>{{ $season->title }}</option>
                        @endforeach
                    </x-select>
                @endif

                <div class="w-50">
                    <p class="box__title">Is this lesson free? *</p>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-1" name="is_free" value="0" type="radio" @if(! $lesson->is_free) checked="" @endif>
                        <label for="lesson-upload-field-1">No</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-2" name="is_free" value="1" type="radio" @if($lesson->is_free) checked="" @endif>
                        <label for="lesson-upload-field-2">Yes</label>
                    </div>
                </div>
                <x-file placeholder="Upload Lesson *" name="lesson_file" :value="$lesson->media" />
                <x-text-area placeholder="Lesson Description" name="body" value="{{ $lesson->body }}" />
                <br>
                <button class="btn btn-webamooz_net">Update Lesson</button>
            </form>
        </div>
    </div>
@endsection
