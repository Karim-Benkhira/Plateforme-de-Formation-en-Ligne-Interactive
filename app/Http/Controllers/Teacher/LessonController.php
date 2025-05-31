<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * Store a new lesson.
     */
    public function store(Request $request, $courseId, $sectionId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $section = Section::where('id', $sectionId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content_type' => 'required|in:video,text,pdf',
            'content_url' => 'nullable|url',
            'content_file' => 'nullable|file|max:102400', // 100MB
            'content_text' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'is_free' => 'nullable|boolean',
        ]);

        $maxOrder = $section->lessons()->max('order_index') ?? 0;

        $lesson = new Lesson();
        $lesson->section_id = $section->id;
        $lesson->title = $request->title;
        $lesson->description = $request->description;
        $lesson->content_type = $request->content_type;
        $lesson->duration = $request->duration;
        $lesson->order_index = $maxOrder + 1;
        $lesson->is_published = false;
        $lesson->is_free = (bool)$request->is_free;

        // Handle different content types
        if ($request->content_type === 'video' && $request->content_url) {
            $lesson->content_url = $request->content_url;

            // Extract video provider and ID
            if (strpos($request->content_url, 'youtube.com') !== false || strpos($request->content_url, 'youtu.be') !== false) {
                $lesson->video_provider = 'youtube';
                $lesson->video_id = Lesson::extractVideoId($request->content_url, 'youtube');
            } elseif (strpos($request->content_url, 'vimeo.com') !== false) {
                $lesson->video_provider = 'vimeo';
                $lesson->video_id = Lesson::extractVideoId($request->content_url, 'vimeo');
            }
        }

        if ($request->hasFile('content_file')) {
            $path = $request->file('content_file')->store('lessons', 'public');
            $lesson->content_file = $path;

            if ($request->content_type === 'video') {
                $lesson->video_provider = 'local';
            }
        }

        if ($request->content_type === 'text' && $request->content_text) {
            $lesson->content_text = $request->content_text;
        }

        $lesson->save();

        return response()->json([
            'success' => true,
            'message' => 'Lesson created successfully!',
            'lesson' => $lesson
        ]);
    }

    /**
     * Update a lesson.
     */
    public function update(Request $request, $courseId, $sectionId, $lessonId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $section = Section::where('id', $sectionId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $lesson = Lesson::where('id', $lessonId)
            ->where('section_id', $section->id)
            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content_type' => 'required|in:video,text,pdf',
            'content_url' => 'nullable|url',
            'content_file' => 'nullable|file|max:102400',
            'content_text' => 'nullable|string',
            'duration' => 'nullable|integer|min:1',
            'is_free' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);

        $lesson->title = $request->title;
        $lesson->description = $request->description;
        $lesson->content_type = $request->content_type;
        $lesson->duration = $request->duration;
        $lesson->is_free = (bool)$request->is_free;
        $lesson->is_published = (bool)$request->is_published;

        // Handle content updates
        if ($request->content_type === 'video' && $request->content_url) {
            $lesson->content_url = $request->content_url;

            // Extract video provider and ID
            if (strpos($request->content_url, 'youtube.com') !== false || strpos($request->content_url, 'youtu.be') !== false) {
                $lesson->video_provider = 'youtube';
                $lesson->video_id = Lesson::extractVideoId($request->content_url, 'youtube');
            } elseif (strpos($request->content_url, 'vimeo.com') !== false) {
                $lesson->video_provider = 'vimeo';
                $lesson->video_id = Lesson::extractVideoId($request->content_url, 'vimeo');
            }
        }

        if ($request->hasFile('content_file')) {
            // Delete old file
            if ($lesson->content_file) {
                Storage::disk('public')->delete($lesson->content_file);
            }

            $path = $request->file('content_file')->store('lessons', 'public');
            $lesson->content_file = $path;

            if ($request->content_type === 'video') {
                $lesson->video_provider = 'local';
            }
        }

        if ($request->content_type === 'text' && $request->content_text) {
            $lesson->content_text = $request->content_text;
        }

        $lesson->save();

        return response()->json([
            'success' => true,
            'message' => 'Lesson updated successfully!',
            'lesson' => $lesson
        ]);
    }

    /**
     * Delete a lesson.
     */
    public function destroy($courseId, $sectionId, $lessonId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $section = Section::where('id', $sectionId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $lesson = Lesson::where('id', $lessonId)
            ->where('section_id', $section->id)
            ->firstOrFail();

        // Delete associated files
        if ($lesson->content_file) {
            Storage::disk('public')->delete($lesson->content_file);
        }
        if ($lesson->thumbnail) {
            Storage::disk('public')->delete($lesson->thumbnail);
        }

        $lesson->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lesson deleted successfully!'
        ]);
    }

    /**
     * Update lessons order.
     */
    public function updateOrder(Request $request, $courseId, $sectionId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $section = Section::where('id', $sectionId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $request->validate([
            'lessons' => 'required|array',
            'lessons.*.id' => 'required|exists:lessons,id',
            'lessons.*.order_index' => 'required|integer|min:0',
        ]);

        foreach ($request->lessons as $lessonData) {
            Lesson::where('id', $lessonData['id'])
                ->where('section_id', $section->id)
                ->update(['order_index' => $lessonData['order_index']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lessons order updated successfully!'
        ]);
    }

    /**
     * Toggle lesson publish status.
     */
    public function togglePublish($courseId, $sectionId, $lessonId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $section = Section::where('id', $sectionId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $lesson = Lesson::where('id', $lessonId)
            ->where('section_id', $section->id)
            ->firstOrFail();

        $lesson->is_published = !$lesson->is_published;
        $lesson->save();

        return response()->json([
            'success' => true,
            'message' => $lesson->is_published ? 'Lesson published!' : 'Lesson unpublished!',
            'is_published' => $lesson->is_published
        ]);
    }

    /**
     * Get lesson details.
     */
    public function show($courseId, $sectionId, $lessonId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $section = Section::where('id', $sectionId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $lesson = Lesson::where('id', $lessonId)
            ->where('section_id', $section->id)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'lesson' => $lesson
        ]);
    }
}
