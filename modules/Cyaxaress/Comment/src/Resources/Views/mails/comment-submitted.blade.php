@component('mail::message')
# A new comment has been posted for the course "{{ $comment->commentable->title }}".
Dear instructor, a new comment has been posted for the course "{{ $comment->commentable->title }}" on Raj_Hub. Please respond promptly with an appropriate reply.
@component('mail::panel')
@component('mail::button', ['url' => $comment->commentable->path()])
View Course
@endcomponent
@endcomponent

Thank you, {{ config('app.name') }}
@endcomponent
