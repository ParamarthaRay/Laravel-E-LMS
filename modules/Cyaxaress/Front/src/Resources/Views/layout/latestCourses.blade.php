<div class="box-filter">
    <div class="b-head">
        <h2>Latest Courses</h2>
        <a href="all-courses.html">View All</a>
    </div>
    <div class="posts">
        @foreach($latestCourses as $courseItem)
            @include('Front::layout.singleCourseBox')
        @endforeach
    </div>
</div>
