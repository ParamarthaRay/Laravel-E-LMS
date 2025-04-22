@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('courses.index') }}" title="Courses">Courses</a></li>
    <li><a href="#" title="Create Course">Create Course</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">Create Course</p>
            <form action="{{ route('courses.store') }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                <x-input name="title" placeholder="Course Title" type="text" required/>
                <x-input type="text" name="slug" placeholder="Course Slug" class="text-left" required />

                <div class="d-flex multi-text">
                    <x-input type="text" class="text-left mlg-15" name="priority" placeholder="Course Priority" />
                    <x-input type="text" placeholder="Course Price" name="price" class="text-left" required />
                    <x-input type="number" placeholder="Instructor Percentage" name="percent" class="text-left" required />
                </div>
                @if(hasPermissionTo(Cyaxaress\RolePermissions\Models\Permission::PERMISSION_MANAGE_COURSES))
                <x-select name="teacher_id" required>
                    <option value="">Select Instructor</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @if($teacher->id == old('teacher_id')) selected @endif>{{ $teacher->name }}</option>
                    @endforeach
                </x-select>
                @endif

                <x-tag-select name="tags"/>

                <x-select name="type" required>
                    <option value="">Course Type</option>
                    @foreach(\Cyaxaress\Course\Models\Course::$types as $type)
                        <option value="{{ $type }}"
                                @if($type == old('type')) selected @endif
                        >@lang($type)</option>
                    @endforeach
                </x-select>

                <x-select name="status" required>
                    <option value="">Course Status</option>
                    @foreach(\Cyaxaress\Course\Models\Course::$statuses as $status)
                        <option value="{{ $status }}"
                                @if($status == old('status')) selected @endif
                        >@lang($status)</option>
                    @endforeach
                </x-select>

                <x-select name="category_id" required>
                    <option value="">Category</option>
                    @foreach($categories  as $category)
                        <option value="{{ $category->id }}"
                                @if($category->id == old('category_id')) selected @endif
                        >{{ $category->title }}</option>
                    @endforeach
                </x-select>

                <x-file placeholder="Upload Course Banner" name="image" required />
                <x-text-area placeholder="Course Description" name="body" />
                <br>
                <button class="btn btn-webamooz_net">Create Course</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v=12"></script>
@endsection
