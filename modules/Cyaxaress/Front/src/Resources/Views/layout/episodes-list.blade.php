<div class="episodes-list">
    <div class="episodes-list--title">
        Episode List for <strong>{{ $course->title }}</strong>

        @can("download", $course)
        <span>
            <a href="{{ route('courses.downloadLinks', $course->id) }}">Download All Links</a>
        </span>
        @endcan
    </div>

    <div class="episodes-list-section">
        @forelse($lessons as $lesson)
            @if($lesson->course_id === $course->id)
                <div class="episodes-list-item @cannot('download', $lesson) lock @endcannot">
                    <div class="section-right">
                        <span class="episodes-list-number">{{ $lesson->number }}</span>
                        <div class="episodes-list-title">
                        <a href="{{ route('lessons.show', $lesson->id) }}">{{ $lesson->title }}</a>

                        </div>
                    </div>

                    <div class="section-left">
                        <div class="episodes-list-details">
                            <span class="detail-type">@lang($lesson->type)</span>
                            <span class="detail-time">{{ $lesson->time }} minutes</span>

                            @can("download", $lesson)
                            <a class="detail-download" href="{{ $lesson->downloadLink() }}">
                                <i class="icon-download"></i>
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <p>No episodes available for this course.</p>
        @endforelse
    </div>
</div>
