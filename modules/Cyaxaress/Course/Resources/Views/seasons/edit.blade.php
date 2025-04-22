@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('courses.details', $season->course_id) }}" title="{{ $season->course->title }}">{{ $season->course->title }}</a></li>
    <li><a href="#" title="Edit Chapter">Edit Chapter</a></li>
@endsection
@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
            <p class="box__title">Update Chapter</p>
            <form action="{{ route('seasons.update', $season->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <x-input type="text" name="title" placeholder="Chapter Title" class="text" value="{{ $season->title }}" required />
                <x-input type="text" name="number" placeholder="Chapter Number" class="text" value="{{ $season->number }}" />
                <br>
                <button class="btn btn-webamooz_net">Update Chapter</button>
            </form>
        </div>
    </div>
@endsection
