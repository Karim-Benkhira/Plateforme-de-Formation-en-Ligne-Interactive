<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Content;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function storeCourse(Request $request) {
        // Check if the request is coming from admin or teacher
        $isAdmin = auth()->user()->role === 'admin';

        if ($isAdmin) {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'score' => 'required|integer|min:1',
                'category' => 'required|exists:categories,id',
                'content_type' => 'required|string',
                'pdf_file' => 'nullable|file|mimes:pdf|max:2048',
                'youtube_link' => 'nullable|url',
            ]);

            $user = auth()->id();

            $course = new Course();
            $course->title = $request->title;
            $course->description = $request->description;
            $course->score = $request->score;
            $course->creator_id = $user;
            $course->category_id = $request->category;
            $course->level = 'beginner'; // Default value for admin
            $course->is_published = true; // Default value for admin
            $course->save();

            $content = new Content();
            $content->course_id = $course->id;

            if ($request->content_type === 'pdf' && $request->hasFile('pdf_file')) {
                $path = $request->file('pdf_file')->store('pdfs', 'public');
                $content->type = 'pdf';
                $content->file = $path;
            } elseif ($request->content_type === 'youtube') {
                $content->type = 'youtube';
                $content->file = $request->youtube_link;
            }

            $content->save();
        } else {
            // Teacher validation
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'level' => 'required|string|in:beginner,intermediate,advanced',
                'content' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'is_published' => 'nullable|boolean',
                'score' => 'required|integer',
            ]);

            $user = auth()->id();

            $course = new Course();
            $course->title = $request->title;
            $course->description = $request->description;
            $course->creator_id = $user;
            $course->category_id = $request->category_id;
            $course->level = $request->level;
            $course->is_published = $request->has('is_published');
            $course->score = $request->score;

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('course-images', 'public');
                $course->image = $path;
            }

            $course->save();

            // Handle course content if provided
            if ($request->filled('content')) {
                $content = new Content();
                $content->course_id = $course->id;
                $content->type = 'text';
                $content->content = $request->content;
                $content->save();
            }
        }

        // Determine the redirect route based on user role
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.courses' : 'teacher.courses';

        return redirect()->route($redirectRoute)->with('success', 'Course created successfully.');
    }

    public function editCourse($id) {
        $course = Course::with('contents')->findOrFail($id);
        $categories = Category::all();

        // Determine the view based on user role
        $view = auth()->user()->role === 'admin' ? 'admin.editCourse' : 'teacher.editCourse';

        return view($view, compact('course', 'categories'));
    }

    public function updateCourse(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'level' => 'required|string|in:beginner,intermediate,advanced',
            'content' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $course = Course::findOrFail($id);
        $course->title = $request->title;
        $course->description = $request->description;
        $course->category_id = $request->category_id;
        $course->level = $request->level;
        $course->is_published = $request->has('is_published');

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('course-images', 'public');
            $course->image = $path;
        }

        $course->save();

        // Handle course content if provided
        if ($request->filled('content')) {
            $content = $course->contents->first();

            if ($content) {
                $content->content = $request->content;
                $content->save();
            } else {
                $content = new Content();
                $content->course_id = $course->id;
                $content->type = 'text';
                $content->content = $request->content;
                $content->save();
            }
        }

        // Determine the redirect route based on user role
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.courses' : 'teacher.courses';

        return redirect()->route($redirectRoute)->with('success', 'Course updated successfully.');
    }

    public function deleteCourse($id) {
        $course = Course::findOrFail($id);
        $course->delete();

        // Determine the redirect route based on user role
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.courses' : 'teacher.courses';

        return redirect()->route($redirectRoute)->with('success', 'Course deleted successfully.');
    }

}
