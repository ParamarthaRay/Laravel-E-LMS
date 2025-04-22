@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('courses.index') }}" title="Courses">Courses</a></li>
    <li><a href="{{ route('courses.details', $course->id) }}" title="{{ $course->title }}">{{ $course->title }}</a></li>
    <li><a href="#" title="Create Lesson">Create Lesson</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">Create New Lesson</p>
            <form action="{{ route('lessons.store', $course->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                <x-input name="title" placeholder="Lesson Title *" type="text" required/>
                <x-input type="text" name="slug" placeholder="Optional English Name of the Lesson" class="text-left" />
                <x-input type="number" name="time" placeholder="Session Duration *" class="text-left" required />
                <x-input type="number" name="number" placeholder="Session Number" class="text-left"/>

                @if(count($seasons))
                    <x-select name="season_id" required>
                        <option value="">Select Lesson Chapter *</option>
                        @foreach($seasons as $season)
                        <option value="{{ $season->id }}" @if($season->id == old('season_id')) selected @endif>{{ $season->title }}</option>
                        @endforeach
                    </x-select>
                @endif

                <div class="w-50">
                    <p class="box__title">Is this lesson free? *</p>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-1" name="is_free" value="0" type="radio" checked="">
                        <label for="lesson-upload-field-1">No</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-2" name="is_free" value="1" type="radio">
                        <label for="lesson-upload-field-2">Yes</label>
                    </div>
                </div>
                <x-file placeholder="Upload Lesson *" name="lesson_file" required />
                <x-text-area placeholder="Lesson Description" name="body" />
                <br>
                <button class="btn btn-webamooz_net">Create Lesson</button>
            </form>
        </div>
    </div>
@endsection
