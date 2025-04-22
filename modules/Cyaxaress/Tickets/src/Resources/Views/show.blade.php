@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('tickets.index') }}" title="Tickets">Tickets</a></li>
    <li><a href="#" title="View Ticket">View Ticket</a></li>
@endsection
@section('content')
    <div class="show-comment">
        <div class="ct__header">
            <div class="comment-info">
                <a class="back" href="{{ route("tickets.index") }}"></a>
                <div>
                    <p class="comment-name"><a href="">{{ $ticket->title }}</a></p>
                </div>
            </div>
        </div>
        @foreach($ticket->replies as $reply)
            <div class="transition-comment {{ $reply->user_id == $ticket->user_id ? "" : "is-answer" }}">
                <div class="transition-comment-header">
               <span>
                    <img src="{{ $reply->user->thumb}}" class="logo-pic">
               </span>
                    <span class="nav-comment-status">
                    <p class="username">User: {{ $reply->user->name }}</p>
                    <p class="comment-date">{{ $reply->created_at }}</p></span>
                    <div>

                    </div>
                </div>
                <div class="transition-comment-body">
                    <pre>{!! $reply->body !!}
                        <div class="border-top margin-top-6">
                            @if($reply->media_id)
                                <a href="{{ $reply->attachmentLink() }}" class="text-success">Download Attachment</a>
                            @endif
                        </div>
                    </pre>

                </div>
            </div>
        @endforeach
    </div>
    <div class="answer-comment">
        <p class="p-answer-comment">Send Reply</p>
        <form action="{{ route("tickets.reply", $ticket->id) }}" method="post" enctype="multipart/form-data"
              class="padding-30">
            @csrf
            <x-text-area placeholder="Reply text" name="body" class="text" required/>
            <x-file name="attachment" placeholder="Upload Attachment"/>
            <button class="btn btn-webamooz_net">Send Reply</button>
        </form>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v=12"></script>
@endsection
