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
                'content_type' => 'required|string|in:text,pdf,video,youtube',
                'content' => 'nullable|string',
                'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
                'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:102400',
                'youtube_link' => 'nullable|url',
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
            $course->is_published = (bool)$request->is_published;
            $course->score = $request->score;

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('course-images', 'public');
                $course->image = $path;
            }

            $course->save();

            // Handle course content based on content type
            $content = new Content();
            $content->course_id = $course->id;

            switch ($request->content_type) {
                case 'text':
                    if ($request->filled('content')) {
                        $content->type = 'text';
                        $content->content = $request->content;
                    }
                    break;

                case 'pdf':
                    if ($request->hasFile('pdf_file')) {
                        $path = $request->file('pdf_file')->store('course-pdfs', 'public');
                        $content->type = 'pdf';
                        $content->file = $path;
                    }
                    break;

                case 'video':
                    if ($request->hasFile('video_file')) {
                        $path = $request->file('video_file')->store('course-videos', 'public');
                        $content->type = 'video';
                        $content->file = $path;
                    }
                    break;

                case 'youtube':
                    if ($request->filled('youtube_link')) {
                        $content->type = 'youtube';
                        $content->file = $request->youtube_link;
                    }
                    break;
            }

            $content->save();
        }

        // Determine the redirect route based on user role
        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.courses' : 'teacher.courses';

        return redirect()->route($redirectRoute)->with('success', 'Course created successfully.');
    }

    public function editCourse($id) {
        $course = Course::with('contents')->findOrFail($id);
        $categories = Category::all();

        // Determine the view based on user role
        if (auth()->user()->role === 'admin') {
            return view('admin.editCourse-new', compact('course', 'categories'));
        } else {
            return view('teacher.editCourse', compact('course', 'categories'));
        }
    }

    public function updateCourse(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'level' => 'required|string|in:beginner,intermediate,advanced',
            'content_type' => 'required|string|in:text,pdf,video,youtube',
            'content' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:102400',
            'youtube_link' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        $course = Course::findOrFail($id);
        $course->title = $request->title;
        $course->description = $request->description;
        $course->category_id = $request->category_id;
        $course->level = $request->level;
        $course->is_published = (bool)$request->is_published;

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('course-images', 'public');
            $course->image = $path;
        }

        $course->save();

        // Get existing content or create new one
        $content = $course->contents->first();
        if (!$content) {
            $content = new Content();
            $content->course_id = $course->id;
        }

        // Update content based on content type
        switch ($request->content_type) {
            case 'text':
                if ($request->filled('content')) {
                    $content->type = 'text';
                    $content->content = $request->content;
                    // Clear file field if changing from another type
                    if ($content->file) {
                        $content->file = null;
                    }
                }
                break;

            case 'pdf':
                if ($request->hasFile('pdf_file')) {
                    $path = $request->file('pdf_file')->store('course-pdfs', 'public');
                    $content->type = 'pdf';
                    $content->file = $path;
                    // Clear content field if changing from text
                    if ($content->content) {
                        $content->content = null;
                    }
                }
                break;

            case 'video':
                if ($request->hasFile('video_file')) {
                    $path = $request->file('video_file')->store('course-videos', 'public');
                    $content->type = 'video';
                    $content->file = $path;
                    // Clear content field if changing from text
                    if ($content->content) {
                        $content->content = null;
                    }
                }
                break;

            case 'youtube':
                if ($request->filled('youtube_link')) {
                    $content->type = 'youtube';

                    // Process YouTube URL to ensure it's in the correct format
                    $youtubeUrl = $request->youtube_link;

                    // Store the original YouTube URL (not the embed version)
                    // The view will handle converting it to embed format
                    $content->file = $youtubeUrl;

                    // Clear content field if changing from text
                    if ($content->content) {
                        $content->content = null;
                    }
                }
                break;
        }

        // Always update the content type even if no new file is uploaded
        $content->type = $request->content_type;
        $content->save();

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
