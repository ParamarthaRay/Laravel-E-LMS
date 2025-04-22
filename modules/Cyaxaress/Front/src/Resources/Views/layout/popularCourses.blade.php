<div class="box-filter">
    <div class="b-head">
        <h2>Recommended Courses</h2>
        <a href="all-courses.html">View All</a>
    </div>
    <div class="posts">
        @foreach($popularCourses as $courseItem)
            @include('Front::layout.singleCourseBox')
        @endforeach
    </div>
</div>
