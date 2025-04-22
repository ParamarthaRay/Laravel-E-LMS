@extends('layouts.app')

@section('title', $lesson->title)

@section('content')
<div class="lesson-show-container">
    <div class="lesson-header">
        <h1>{{ $lesson->number }}. {{ $lesson->title }}</h1>
        <p><strong>Type:</strong> @lang($lesson->type) | <strong>Duration:</strong> {{ $lesson->time }} minutes</p>
    </div>

    <div class="lesson-video">
        @if($lesson->video_url)
            <video width="100%" height="auto" controls>
                <source src="{{ $lesson->video_url }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @else
            <p>Video not available.</p>
        @endif
    </div>

    <div class="lesson-description mt-4">
        <h4>Description</h4>
        <p>{!! nl2br(e($lesson->body)) !!}</p>
    </div>

    @can('download', $lesson)
    <div class="lesson-download mt-3">
        <a href="{{ $lesson->downloadLink() }}" class="btn btn-primary">
            <i class="fa fa-download"></i> Download Video
        </a>
    </div>
    @endcan
</div>
@endsection

@push('styles')
<style>
.lesson-show-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}
.lesson-header {
    margin-bottom: 20px;
}
.lesson-video {
    margin-bottom: 20px;
}
.lesson-description {
    font-size: 1rem;
    line-height: 1.6;
}
.lesson-download a {
    text-decoration: none;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border-radius: 6px;
}
.lesson-download a:hover {
    background-color: #0056b3;
}
</style>
@endpush
