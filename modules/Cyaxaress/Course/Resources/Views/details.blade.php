@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('courses.index') }}" title="Courses">Courses</a></li>
    <li><a href="#" title="Course Details">Course Details</a></li>
@endsection

@section('content')
    <div class="row no-gutters">
        <div class="col-8 bg-white padding-30 margin-left-10 margin-bottom-15 border-radius-3">
            <div class="margin-bottom-20 flex-wrap font-size-14 d-flex bg-white padding-0">
                <p class="mlg-15">{{ $course->title }}</p>
                <a class="color-2b4a83" href="{{ route('lessons.create', $course->id) }}">Upload New Lesson</a>
            </div>
            @can(\Cyaxaress\RolePermissions\Models\Permission::PERMISSION_MANAGE_COURSES)
            <div class="d-flex item-center flex-wrap margin-bottom-15 operations__btns">
                <button class="btn all-confirm-btn" onclick="acceptAllLessons('{{ route('lessons.acceptAll', $course->id) }}')">Approve All Lessons</button>
                <button type="submit" class="btn confirm-btn">Approve Lessons</button>
                <button class="btn reject-btn" onclick="rejectMultiple('{{ route('lessons.rejectMultiple', $course->id) }}')">Reject Lessons</button>
                <button class="btn delete-btn" onclick="deleteMultiple('{{ route('lessons.destroyMultiple', $course->id) }}')">Delete Lessons</button>
            </div>
            @endcan
            <div class="table__box">
            <form action="{{ route('lessons.acceptMultiple', $course->id) }}" method="POST" id="multiple-action-form">
            @csrf
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th style="padding: 13px 30px;">
                            <label class="ui-checkbox">
                                <input type="checkbox" class="checkedAll">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                        <th>Number</th>
                        <th>Lesson Title</th>
                        <th>Season Title</th>
                        <th>Lesson Duration</th>
                        <th>Confirmation Status</th>
                        <th>Access Level</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lessons as $lesson)
                        <tr role="row" class="" data-row-id="{{ $lesson->id }}">
                        <td>
                            <label class="ui-checkbox">
                                <input type="checkbox" class="sub-checkbox" data-id="{{ $lesson->id }}">
                                <span class="checkmark"></span>
                            </label>
                        </td>
                        <td><a href="">{{ $lesson->number }}</a></td>
                        <td><a href="">{{ $lesson->title}}</a></td>
                        <td>{{ $lesson->season ? $lesson->season->title : '-' }}</td>
                        <td>{{ $lesson->time }} minutes</td>
                        <td class="confirmation_status">
                                <span class="{{ $lesson->getConfirmationStatusCssClass() }}">
                                    @lang($lesson->confirmation_status)
                                </span>
                        </td>
                        <td class="status">
                            @if($lesson->status == \Cyaxaress\Course\Models\Lesson::STATUS_OPENED)
                                {{ $lesson->free ? 'Everyone' : 'Participants'}}
                            @else
                                <span>Locked</span>
                            @endif
                        </td>
                        <td>
                            @can(\Cyaxaress\RolePermissions\Models\Permission::PERMISSION_MANAGE_COURSES)
                                <a href=""  onclick="deleteItem(event, '{{ route('lessons.destroy',[$course->id ,$lesson->id]) }}')"
                                   class="item-delete mlg-15" title="Delete"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('lessons.accept', $lesson->id) }}',
                                    'Are you sure you want to approve this item?', 'Approved')"
                                   class="item-confirm mlg-15" title="Approve"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('lessons.reject', $lesson->id) }}',
                                    'Are you sure you want to reject this item?', 'Rejected')"
                                   class="item-reject mlg-15" title="Reject"></a>
                                @if($lesson->status == \Cyaxaress\Course\Models\Lesson::STATUS_OPENED)
                                    <a href="" onclick="updateConfirmationStatus(event, '{{ route('lessons.lock', $lesson->id) }}',
                                        'Are you sure you want to lock this item?', 'Locked', 'status')"
                                       class="item-lock text-error mlg-15" title="Lock"></a>
                                @else
                                    <a href="" onclick="updateConfirmationStatus(event, '{{ route('lessons.unlock', $lesson->id) }}',
                                        'Are you sure you want to unlock this item?', 'Unlocked', 'status')"
                                       class="item-lock mlg-15 text-success" title="Unlock"></a>
                                @endif
                            @endcan
                            <a href="{{ route('lessons.edit', [$course->id, $lesson->id]) }}" class="item-edit " title="Edit"></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-4">
            @include('Courses::seasons.index')

            <div class="col-12 bg-white margin-bottom-15 border-radius-3">
                <p class="box__title">Add Student to Course</p>
                <form action="" method="post" class="padding-30">
                    <select name="" id="">
                        <option value="0">Select User</option>
                        <option value="1">ayushnigko3@gmail.com</option>
                        <option value="2">sayad@gamil.com</option>
                    </select>
                    <div class="dropdown-select wide" tabindex="0"><span class="current">ayushniko3@gmail.com</span><div class="list"><div class="dd-search"><input id="txtSearchValue" autocomplete="off" onkeyup="filter()" class="dd-searchbox" type="text"></div><ul><li class="option" data-value="0" data-display-text="">Select User</li><li class="option selected" data-value="1" data-display-text="">ayushniko3@gmail.com</li><li class="option " data-value="2" data-display-text="">sayad@gamil.com</li></ul></div></div>
                    <input type="text" placeholder="Course Fee" class="text">
                    <p class="box__title">Should Teacher's Commission be Registered?</p>
                    <div class="notificationGroup">
                        <input id="course-detial-field-1" name="course-detial-field" type="radio" checked="">
                        <label for="course-detial-field-1">Yes</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="course-detial-field-2" name="course-detial-field" type="radio">
                        <label for="course-detial-field-2">No</label>
                    </div>
                    <button class="btn btn-webamooz_net">Add Student</button>
                </form>
                <div class="table__box padding-30">
                    <table class="table">
                        <thead role="rowgroup">
                        <tr role="row" class="title-row">
                            <th class="p-r-90">ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Amount (₹)</th>
                            <th>Your Earnings</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr role="row" class="">
                            <td><a href="">1</a></td>
                            <td><a href="">Ayush Das</a></td>
                            <td><a href="">Ayushniko3@gmail.com</a></td>
                            <td><a href="">40000</a></td>
                            <td><a href="">20000</a></td>
                            <td>
                                <a href="" class="item-delete mlg-15" title="Delete"></a>
                                <a href="" class="item-edit " title="Edit"></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        @include('Common::layouts.feedbacks')
    </script>
@endsection
