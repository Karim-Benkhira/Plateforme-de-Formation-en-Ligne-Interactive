<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get teacher IDs
        $teacher1 = User::where('email', 'teacher1@example.com')->first();
        $teacher2 = User::where('email', 'teacher2@example.com')->first();

        // Create courses
        $course1 = Course::create([
            'title' => 'Introduction to Programming',
            'description' => 'Learn the basics of programming with this introductory course. Perfect for beginners.',
            'teacher_id' => $teacher1->id,
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
            'status' => 'active',
        ]);

        $course2 = Course::create([
            'title' => 'Advanced Mathematics',
            'description' => 'Dive deep into advanced mathematical concepts including calculus and linear algebra.',
            'teacher_id' => $teacher2->id,
            'start_date' => now(),
            'end_date' => now()->addMonths(4),
            'status' => 'active',
        ]);

        $course3 = Course::create([
            'title' => 'Web Development Fundamentals',
            'description' => 'Learn HTML, CSS, and JavaScript to build modern websites.',
            'teacher_id' => $teacher1->id,
            'start_date' => now()->addDays(30),
            'end_date' => now()->addMonths(5),
            'status' => 'upcoming',
        ]);

        // Create modules for Course 1
        $module1 = Module::create([
            'title' => 'Getting Started with Programming',
            'description' => 'Introduction to programming concepts and tools.',
            'course_id' => $course1->id,
            'order' => 1,
        ]);

        $module2 = Module::create([
            'title' => 'Variables and Data Types',
            'description' => 'Understanding variables, data types, and basic operations.',
            'course_id' => $course1->id,
            'order' => 2,
        ]);

        $module3 = Module::create([
            'title' => 'Control Structures',
            'description' => 'Learn about conditional statements and loops.',
            'course_id' => $course1->id,
            'order' => 3,
        ]);

        // Create lessons for Module 1
        $lesson1 = Lesson::create([
            'title' => 'What is Programming?',
            'content' => 'Programming is the process of creating a set of instructions that tell a computer how to perform a task.',
            'module_id' => $module1->id,
            'content_type' => 'text',
            'order' => 1,
        ]);

        $lesson2 = Lesson::create([
            'title' => 'Setting Up Your Development Environment',
            'content' => 'In this lesson, you will learn how to set up your development environment for programming.',
            'module_id' => $module1->id,
            'content_type' => 'text',
            'order' => 2,
        ]);

        // Create a quiz for Lesson 1
        $quiz1 = Quiz::create([
            'title' => 'Programming Basics Quiz',
            'description' => 'Test your knowledge of basic programming concepts.',
            'lesson_id' => $lesson1->id,
            'duration' => 15,
            'type' => 'practice',
            'status' => 'open',
        ]);

        // Create questions for Quiz 1
        $question1 = Question::create([
            'question_text' => 'What is programming?',
            'quiz_id' => $quiz1->id,
            'type' => 'multiple_choice',
            'points' => 1.0,
        ]);

        // Create options for Question 1
        Option::create([
            'option_text' => 'The process of creating instructions for a computer',
            'question_id' => $question1->id,
            'is_correct' => true,
        ]);

        Option::create([
            'option_text' => 'The study of computer hardware',
            'question_id' => $question1->id,
            'is_correct' => false,
        ]);

        Option::create([
            'option_text' => 'The design of user interfaces',
            'question_id' => $question1->id,
            'is_correct' => false,
        ]);

        Option::create([
            'option_text' => 'The management of databases',
            'question_id' => $question1->id,
            'is_correct' => false,
        ]);

        $question2 = Question::create([
            'question_text' => 'Which of the following is a programming language?',
            'quiz_id' => $quiz1->id,
            'type' => 'multiple_choice',
            'points' => 1.0,
        ]);

        // Create options for Question 2
        Option::create([
            'option_text' => 'HTML',
            'question_id' => $question2->id,
            'is_correct' => false,
        ]);

        Option::create([
            'option_text' => 'Python',
            'question_id' => $question2->id,
            'is_correct' => true,
        ]);

        Option::create([
            'option_text' => 'Microsoft Word',
            'question_id' => $question2->id,
            'is_correct' => false,
        ]);

        Option::create([
            'option_text' => 'Photoshop',
            'question_id' => $question2->id,
            'is_correct' => false,
        ]);

        // Enroll students in courses
        $students = User::where('role', 'student')->get();

        foreach ($students as $index => $student) {
            // Enroll all students in Course 1
            Enrollment::create([
                'user_id' => $student->id,
                'course_id' => $course1->id,
                'status' => 'active',
            ]);

            // Enroll some students in Course 2
            if ($index % 2 == 0) {
                Enrollment::create([
                    'user_id' => $student->id,
                    'course_id' => $course2->id,
                    'status' => 'active',
                ]);
            }

            // Enroll some students in Course 3
            if ($index % 3 == 0) {
                Enrollment::create([
                    'user_id' => $student->id,
                    'course_id' => $course3->id,
                    'status' => 'active',
                ]);
            }
        }
    }
}
