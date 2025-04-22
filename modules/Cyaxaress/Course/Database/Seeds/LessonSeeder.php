<?php

namespace Cyaxaress\Course\Database\Seeds;

use Cyaxaress\Course\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run()
    {
        // Sample lessons to seed
        $lessons = [
            [
                'title' => 'Introduction to Course',
                'slug' => 'introduction-to-course',
                'number' => 1,
                'time' => 15,
                'free' => 1,
                'season_id' => 1,
                'course_id' => 1,
                'user_id' => 1,
                'body' => 'This is an introductory lesson.',
                'confirmation_status' => Lesson::CONFIRMATION_STATUS_ACCEPTED,
                'status' => Lesson::STATUS_OPENED,
                'media_id' => null,
            ],
            [
                'title' => 'Lesson Two: Advanced Topics',
                'slug' => 'lesson-two-advanced-topics',
                'number' => 2,
                'time' => 30,
                'free' => 0,
                'season_id' => 1,
                'course_id' => 1,
                'user_id' => 1,
                'body' => 'This lesson covers advanced topics.',
                'confirmation_status' => Lesson::CONFIRMATION_STATUS_ACCEPTED,
                'status' => Lesson::STATUS_OPENED,
                'media_id' => null,
            ],
        ];

        foreach ($lessons as $lesson) {
            Lesson::create($lesson);
        }
    }
}
