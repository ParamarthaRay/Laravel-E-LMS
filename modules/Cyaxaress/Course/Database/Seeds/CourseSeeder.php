<?php

namespace Cyaxaress\Course\Database\Seeds;

use Cyaxaress\Course\Models\Course;
use Cyaxaress\Media\Services\MediaFileService;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        auth()->loginUsingId(1);

        $courses = [
            [
                'title' => 'Modular Programming in Laravel',
                'slug' => 'modular-programming-in-laravel',
                'body' => 'Learn how to write modular and maintainable code in Laravel for real-world applications.',
                'category_id' => 2,
                'teacher_id' => 1,
                'price' => 5000000,
                'percent' => 50,
                'type' => 'cash',
                'status' => 'completed',
                'confirmation_status' => 'accepted',
                'image' => 'course-1-laravel.png',
            ],
            [
                'title' => 'ReactJS - Beginner to Advanced',
                'slug' => 'reactjs-complete-course',
                'body' => 'Master ReactJS from basics to advanced with hands-on projects.',
                'category_id' => 2,
                'teacher_id' => 2,
                'price' => 750000,
                'percent' => 50,
                'type' => 'cash',
                'status' => Course::STATUS_NOT_COMPLETED,
                'confirmation_status' => 'accepted',
                'image' => 'course-2-react.png',
            ],
            [
                'title' => 'PHP Full Stack Development',
                'slug' => 'php-fullstack',
                'body' => 'Complete PHP training covering frontend to backend development.',
                'category_id' => 2,
                'teacher_id' => 2,
                'price' => 890000,
                'percent' => 50,
                'type' => 'cash',
                'status' => Course::STATUS_NOT_COMPLETED,
                'confirmation_status' => 'accepted',
                'image' => 'course-3-php.png',
            ],
            [
                'title' => 'Angular Full Course',
                'slug' => 'angular-complete',
                'body' => 'Learn Angular from scratch and build dynamic web apps.',
                'category_id' => 2,
                'teacher_id' => 2,
                'price' => 0,
                'percent' => 50,
                'type' => 'free',
                'status' => Course::STATUS_NOT_COMPLETED,
                'confirmation_status' => 'accepted',
                'image' => 'course-4-angularjs.jpg',
            ],
            [
                'title' => 'Web Services and APIs',
                'slug' => 'web-services-api',
                'body' => 'Understand how to design and consume RESTful APIs.',
                'category_id' => 2,
                'teacher_id' => 2,
                'price' => 0,
                'percent' => 50,
                'type' => 'cash',
                'status' => Course::STATUS_LOCKED,
                'confirmation_status' => 'accepted',
                'image' => 'course-5-web-service.jpg',
            ],
            [
                'title' => 'Docker Essentials for Developers',
                'slug' => 'docker-course',
                'body' => 'A practical Docker guide for modern software deployment.',
                'category_id' => 2,
                'teacher_id' => 2,
                'price' => 1500000,
                'percent' => 50,
                'type' => 'cash',
                'status' => Course::STATUS_COMPLETED,
                'confirmation_status' => 'accepted',
                'image' => 'course-6-docker.png',
            ],
            [
                'title' => 'Game Development in Unity',
                'slug' => 'unity-game-dev',
                'body' => 'Build exciting 2D and 3D games using Unity Engine.',
                'category_id' => 2,
                'teacher_id' => 2,
                'price' => 1500000,
                'percent' => 50,
                'type' => 'cash',
                'status' => Course::STATUS_COMPLETED,
                'confirmation_status' => 'accepted',
                'image' => 'course-7-unity.png',
            ],
            [
                'title' => 'Caching with Redis',
                'slug' => 'redis-caching',
                'body' => 'Boost your application performance using Redis caching techniques.',
                'category_id' => 2,
                'teacher_id' => 2,
                'price' => 499000,
                'percent' => 50,
                'type' => 'cash',
                'status' => Course::STATUS_COMPLETED,
                'confirmation_status' => 'accepted',
                'image' => 'course-8-redis.png',
            ],
        ];

        foreach ($courses as $course) {
            Course::query()->create([
                'title' => $course['title'],
                'slug' => $course['slug'],
                'body' => $course['body'],
                'category_id' => $course['category_id'],
                'teacher_id' => $course['teacher_id'],
                'price' => $course['price'],
                'percent' => $course['percent'],
                'type' => $course['type'],
                'status' => $course['status'],
                'confirmation_status' => $course['confirmation_status'],
                'banner_id' => MediaFileService::publicUpload(
                    new UploadedFile(
                        storage_path('app/public/seeds/'.$course['image']),
                        $course['image']
                    )
                )->id,
            ]);
        }
    }
}
