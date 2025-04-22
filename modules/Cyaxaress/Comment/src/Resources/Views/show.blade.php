@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('comments.index') }}" title="Comments">Comments</a></li>
@endsection

@section('content')
    <div class="main-content">
        <div class="show-comment">
            <div class="ct__header">
                <div class="comment-info">
                    <a class="back" href="{{ route("comments.index") }}"></a>
                    <div>
                        <p class="comment-name"><a href="">{{ $comment->commentable->title }}</a></p>
                    </div>
                </div>
            </div>

            {{-- Display the main comment --}}
            @include("Comments::comment", ["comment" => $comment, "isAnswer" => false])

            {{-- Display all replies --}}
            @foreach($comment->comments as $reply)
                @include("Comments::comment", ["comment" => $reply, "isAnswer" => true])
            @endforeach
        </div>

        <div class="answer-comment">
            <p class="p-answer-comment">Send a Reply</p>
            
            @if($comment->status == \Cyaxaress\Comment\Models\Comment::STATUS_APPROVED)
                <form action="{{ route("comments.store") }}" method="post">
                    @csrf
                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                    <input type="hidden" name="commentable_type" value="{{ get_class($comment->commentable) }}">
                    <input type="hidden" name="commentable_id" value="{{ $comment->commentable->id }}">
                    
                    <x-text-area name="body" placeholder="Write a comment..."/>
                    
                    <button type="submit" class="btn btn-webamooz_net">Submit Reply</button>
                </form>
            @else
                <p class="text-error">To reply to this comment, please approve it first.</p>
            @endif
        </div>
    </div>
@endsection
