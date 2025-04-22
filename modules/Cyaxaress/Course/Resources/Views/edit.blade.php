@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('courses.index') }}" title="Courses">Courses</a></li>
    <li><a href="#" title="Edit Course">Edit Course</a></li>
@endsection

@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">Update Course</p>
            <form action="{{ route('courses.update', $course->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <x-input name="title" placeholder="Course Title" type="text" value="{{ $course->title }}" required/>
                <x-input type="text" name="slug" placeholder="Course English Name" value="{{ $course->slug }}" class="text-left" required />

                <div class="d-flex multi-text">
                    <x-input type="text" class="text-left mlg-15" name="priority"
                             value="{{ $course->priority }}" placeholder="Course Row" />

                    <x-input type="text" placeholder="Course Price" name="price" class="text-left"
                             value="{{ $course->price }}" required />

                    <x-input type="number" placeholder="Teacher Percentage" name="percent" class="text-left"
                             value="{{ $course->percent }}" required />
                </div>
                <x-select name="teacher_id" required>
                    <option value="">Select Course Teacher</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @if($teacher->id == $course->teacher_id) selected @endif>{{ $teacher->name }}</option>
                    @endforeach
                </x-select>

                <x-tag-select name="tags"/>

                <x-select name="type" required>
                    <option value="">Course Type</option>
                    @foreach(\Cyaxaress\Course\Models\Course::$types as $type)
                        <option value="{{ $type }}"
                                @if($type == $course->type) selected @endif
                        >@lang($type)</option>
                    @endforeach
                </x-select>

                <x-select name="status" required>
                    <option value="">Course Status</option>
                    @foreach(\Cyaxaress\Course\Models\Course::$statuses as $status)
                        <option value="{{ $status }}"
                                @if($status == $course->status) selected @endif
                        >@lang($status)</option>
                    @endforeach
                </x-select>

                <x-select name="category_id" required>
                    <option value="">Category</option>
                    @foreach($categories  as $category)
                        <option value="{{ $category->id }}"
                                @if($category->id == $course->category_id) selected @endif
                        >{{ $category->title }}</option>
                    @endforeach
                </x-select>

                <x-file placeholder="Upload Course Banner" name="image" :value="$course->banner"/>
                <x-text-area placeholder="Course Description" name="body" value="{{ $course->body }}" />
                <br>
                <button class="btn btn-webamooz_net">Update Course</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v=12"></script>
@endsection
