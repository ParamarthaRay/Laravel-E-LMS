<div class="comment-main">
    <div class="ct-header">
        <h3>Comments (180)</h3>
        <p>Share your thoughts about this article</p>
    </div>
    <form action="{{ route("comments.store") }}" method="post">
        @csrf
        <input type="hidden" name="commentable_type" value="{{ get_class($commentable) }}">
        <input type="hidden" name="commentable_id" value="{{ $commentable->id }}">
        <div class="ct-row">
            <div class="ct-textarea">
                <x-text-area name="body" placeholder="Write a comment..."/>
            </div>
        </div>
        <div class="ct-row">
            <div class="send-comment">
                <button type="submit" class="btn i-t">Submit Comment</button>
            </div>
        </div>
    </form>
</div>
