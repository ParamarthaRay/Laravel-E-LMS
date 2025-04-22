<?php

namespace Cyaxaress\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Cyaxaress\Category\Repositories\CategoryRepo;
use Cyaxaress\Common\Responses\AjaxResponses;
use Cyaxaress\Course\Http\Requests\CourseRequest;
use Cyaxaress\Course\Models\Course;
use Cyaxaress\Course\Repositories\CourseRepo;
use Cyaxaress\Course\Repositories\LessonRepo;
use Cyaxaress\Media\Services\MediaFileService;
use Cyaxaress\Payment\Gateways\Gateway;
use Cyaxaress\Payment\Services\PaymentService;
use Cyaxaress\RolePermissions\Models\Permission;
use Cyaxaress\User\Repositories\UserRepo;

class CourseController extends Controller
{
    public function index(CourseRepo $courseRepo)
    {
        $this->authorize('index', Course::class);
        if (auth()->user()->hasAnyPermission([Permission::PERMISSION_MANAGE_COURSES, Permission::PERMISSION_SUPER_ADMIN])) {
            $courses = $courseRepo->paginate();
        } else {
            $courses = $courseRepo->getCoursesByTeacherId(auth()->id());
        }

        return view('Courses::index', compact('courses'));
    }

    public function create(UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $this->authorize('create', Course::class);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();

        return view('Courses::create', compact('teachers', 'categories'));
    }

    public function store(CourseRequest $request, CourseRepo $courseRepo)
    {
        $this->authorize('create', Course::class);
        $request->request->add(['banner_id' => MediaFileService::publicUpload($request->file('image'))->id]);
        $teacherId = $request->input('teacher_id', auth()->id());
        if (! hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) {
            $teacherId = auth()->id();
        }
        $courseRepo->store($request->merge([
            'teacher_id' => $teacherId,
        ]));

        return redirect()->route('courses.index');
    }

    public function edit($id, CourseRepo $courseRepo, UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $course = $courseRepo->findByid($id);
        $this->authorize('edit', $course);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();

        return view('Courses::edit', compact('course', 'teachers', 'categories'));
    }

    public function update($id, CourseRequest $request, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findByid($id);
        $this->authorize('edit', $course);
        if ($request->hasFile('image')) {
            $request->request->add(['banner_id' => MediaFileService::publicUpload($request->file('image'))->id]);
            if ($course->banner) {
                $course->banner->delete();
            }
        } else {
            $request->request->add(['banner_id' => $course->banner_id]);
        }
        $courseRepo->update($id, $request);

        return redirect(route('courses.index'));
    }

    public function details($id, CourseRepo $courseRepo, LessonRepo $lessonRepo)
    {

        $course = $courseRepo->findByid($id);

        $lessons = $course->lessons;

        $this->authorize('details', $course);

        return view('Courses::details', compact('course', 'lessons'));
    }

    public function downloadLinks($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findByid($id);
        $this->authorize('download', $course);

        return implode('<br>', $course->downloadLinks());
    }

    public function destroy($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findByid($id);
        $this->authorize('delete', $course);
        if ($course->banner) {
            $course->banner->delete();
        }
        $course->delete();

        return AjaxResponses::SuccessResponse();
    }

    public function accept($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function reject($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function lock($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateStatus($id, Course::STATUS_LOCKED)) {
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function buy($courseId, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findByid($courseId);

        if (! $this->courseCanBePurchased($course)) {
            return back();
        }

        if (! $this->authUserCanPurchaseCourse($course)) {
            return back();
        }

        [$amount, $discounts] = $course->getFinalPrice(request()->code, true);
        if ($amount <= 0) {
            $courseRepo->addStudentToCourse($course, auth()->id());
            newFeedback('Success', 'You have successfully enrolled in the course.');

            return redirect($course->path());
        }

        $payment = PaymentService::generate($amount, $course, auth()->user(), $course->teacher_id, $discounts);

        resolve(Gateway::class)->redirect($payment->invoice_id);
    }

    private function courseCanBePurchased(Course $course)
    {
        if ($course->type == Course::TYPE_FREE) {
            newFeedback('Failed Operation', 'Free courses cannot be purchased!', 'error');

            return false;
        }

        if ($course->status == Course::STATUS_LOCKED) {
            newFeedback('Failed Operation', 'This course is currently locked and not available for purchase!', 'error');

            return false;
        }

        if ($course->confirmation_status != Course::CONFIRMATION_STATUS_ACCEPTED) {
            newFeedback('Failed Operation', 'The selected course is not yet approved!', 'error');

            return false;
        }

        return true;
    }

    private function authUserCanPurchaseCourse(Course $course)
    {
        if (auth()->id() == $course->teacher_id) {
            newFeedback('Failed Operation', 'You are the instructor of this course.', 'error');

            return false;
        }

        if (auth()->user()->can('download', $course)) {
            newFeedback('Failed Operation', 'You already have access to this course.', 'error');

            return false;
        }

        return true;
    }
}
