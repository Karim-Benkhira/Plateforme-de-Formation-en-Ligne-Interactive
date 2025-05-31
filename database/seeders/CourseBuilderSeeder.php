<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\User;
use App\Models\Category;

class CourseBuilderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Find a teacher user
        $teacher = User::where('role', 'teacher')->first();
        if (!$teacher) {
            $this->command->error('No teacher found. Please create a teacher user first.');
            return;
        }

        // Find a category
        $category = Category::first();
        if (!$category) {
            $this->command->error('No category found. Please create a category first.');
            return;
        }

        // Create a sample course
        $course = Course::create([
            'title' => 'Complete Web Development Bootcamp',
            'description' => 'Learn web development from scratch with HTML, CSS, JavaScript, and more.',
            'creator_id' => $teacher->id,
            'category_id' => $category->id,
            'level' => 'beginner',
            'is_published' => false,
            'score' => 100,
        ]);

        // Create sections
        $section1 = Section::create([
            'course_id' => $course->id,
            'title' => 'Introduction to Web Development',
            'description' => 'Get started with the basics of web development',
            'order_index' => 1,
            'is_published' => true,
        ]);

        $section2 = Section::create([
            'course_id' => $course->id,
            'title' => 'HTML Fundamentals',
            'description' => 'Learn the building blocks of web pages',
            'order_index' => 2,
            'is_published' => true,
        ]);

        $section3 = Section::create([
            'course_id' => $course->id,
            'title' => 'CSS Styling',
            'description' => 'Make your websites beautiful with CSS',
            'order_index' => 3,
            'is_published' => false,
        ]);

        // Create lessons for section 1
        Lesson::create([
            'section_id' => $section1->id,
            'title' => 'Welcome to the Course',
            'description' => 'Introduction and course overview',
            'content_type' => 'video',
            'content_url' => 'https://www.youtube.com/watch?v=UB1O30fR-EE',
            'video_provider' => 'youtube',
            'video_id' => 'UB1O30fR-EE',
            'duration' => 5,
            'order_index' => 1,
            'is_published' => true,
            'is_free' => true,
        ]);

        Lesson::create([
            'section_id' => $section1->id,
            'title' => 'What is Web Development?',
            'description' => 'Understanding the basics of web development',
            'content_type' => 'text',
            'content_text' => 'Web development is the process of creating websites and web applications. It involves both front-end (client-side) and back-end (server-side) development.',
            'duration' => 10,
            'order_index' => 2,
            'is_published' => true,
            'is_free' => true,
        ]);

        // Create lessons for section 2
        Lesson::create([
            'section_id' => $section2->id,
            'title' => 'HTML Basics',
            'description' => 'Learn the fundamental HTML tags',
            'content_type' => 'video',
            'content_url' => 'https://www.youtube.com/watch?v=qz0aGYrrlhU',
            'video_provider' => 'youtube',
            'video_id' => 'qz0aGYrrlhU',
            'duration' => 20,
            'order_index' => 1,
            'is_published' => true,
            'is_free' => false,
        ]);

        Lesson::create([
            'section_id' => $section2->id,
            'title' => 'HTML Forms',
            'description' => 'Creating interactive forms with HTML',
            'content_type' => 'video',
            'content_url' => 'https://vimeo.com/123456789',
            'video_provider' => 'vimeo',
            'video_id' => '123456789',
            'duration' => 25,
            'order_index' => 2,
            'is_published' => true,
            'is_free' => false,
        ]);

        // Create lessons for section 3
        Lesson::create([
            'section_id' => $section3->id,
            'title' => 'CSS Introduction',
            'description' => 'Getting started with CSS styling',
            'content_type' => 'text',
            'content_text' => 'CSS (Cascading Style Sheets) is used to style and layout web pages. It controls the visual presentation of HTML elements.',
            'duration' => 15,
            'order_index' => 1,
            'is_published' => false,
            'is_free' => false,
        ]);

        $this->command->info('Course Builder sample data created successfully!');
        $this->command->info("Course ID: {$course->id}");
        $this->command->info("Course URL: /teacher/course-builder/{$course->id}/edit");
    }
}
