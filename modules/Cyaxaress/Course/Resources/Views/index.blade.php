@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('courses.index') }}" title="Courses">Courses</a></li>
@endsection

@section('content')
    <div class="tab__box">
        <div class="tab__items">
            <a class="tab__item is-active" href="courses.html">Course List</a>
            <a class="tab__item" href="approved.html">Approved Courses</a>
            <a class="tab__item" href="new-course.html">Unapproved Courses</a>
            <a href="{{ route('courses.create') }}" title="Create New Course">Create New Course</a>
        </div>
    </div>

    <div class="row no-gutters">
        <div class="col-12 margin-left-10 margin-bottom-15 border-radius-3">
            <p class="box__title">Courses</p>
            <div class="table__box">
                <table class="table">
                    <thead role="rowgroup">
                    <tr role="row" class="title-row">
                        <th>Row</th>
                        <th>ID</th>
                        <th>Banner</th>
                        <th>Title</th>
                        <th>Teacher</th>
                        <th>Price</th>
                        <th>Details</th>
                        <th>Teacher Percentage</th>
                        <th>Status</th>
                        <th>Confirmation Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($courses as $course)
                    <tr role="row" class="">
                        <td><a href="">{{ $course->priority }}</a></td>
                        <td><a href="">{{ $course->id }}</a></td>
                        <td width="80"><img src="{{ $course->banner->thumb }}" alt="" width="80"></td>
                        <td><a href="">{{ $course->title }}</a></td>
                        <td><a href="">{{ $course->teacher->name }}</a></td>
                        <td>{{ $course->price }} (₹)</td>
                        <td>
                            <a href="{{ route('courses.details', $course->id) }}">View</a>
                        </td>
                        <td>{{ $course->percent }}%</td>
                        <td class="status">@lang($course->status)</td>
                        <td class="confirmation_status">@lang($course->confirmation_status)</td>
                        <td>
                            @can(\Cyaxaress\RolePermissions\Models\Permission::PERMISSION_MANAGE_COURSES)
                                <a href="" onclick="deleteItem(event, '{{ route('courses.destroy', $course->id) }}')" class="item-delete mlg-15" title="Delete"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('courses.accept', $course->id) }}',
                                    'Are you sure you want to approve this item?' , 'Approved')"
                                   class="item-confirm mlg-15" title="Approve"></a>
                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('courses.reject', $course->id) }}',
                                    'Are you sure you want to reject this item?' ,'Rejected')"
                                   class="item-reject mlg-15" title="Reject"></a>

                                <a href="" onclick="updateConfirmationStatus(event, '{{ route('courses.lock', $course->id) }}',
                                    'Are you sure you want to lock this item?' , 'Locked', 'status')"
                                   class="item-lock mlg-15" title="Lock"></a>
                            @endcan

                            <a href="{{ route('courses.details', $course->id) }}" class="item-eye mlg-15" title="View"></a>
                            <a href="{{ route('courses.edit',  $course->id) }}" class="item-edit mlg-15 " title="Edit"></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                    {{ $courses->links() }}
                </table>
            </div>
        </div>
    </div>
@endsection
