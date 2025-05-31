<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseBuilderController extends Controller
{
    /**
     * Show the course builder dashboard.
     */
    public function index()
    {
        $courses = Course::where('creator_id', Auth::id())
            ->with(['category', 'sections.lessons'])
            ->withCount(['sections', 'lessons'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('teacher.course-builder.index', compact('courses'));
    }

    /**
     * Show the form to create a new course.
     */
    public function create()
    {
        $categories = Category::all();
        return view('teacher.course-builder.create', compact('categories'));
    }

    /**
     * Store a new course.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'level' => 'required|string|in:beginner,intermediate,advanced',
            'image' => 'nullable|image|max:2048',
            'is_published' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $course = new Course();
            $course->title = $request->title;
            $course->description = $request->description;
            $course->creator_id = Auth::id();
            $course->category_id = $request->category_id;
            $course->level = $request->level;
            $course->is_published = (bool)$request->is_published;
            $course->score = 100; // Default score

            // Handle image upload
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('course-images', 'public');
                $course->image = $path;
            }

            $course->save();

            DB::commit();

            return redirect()->route('teacher.course-builder.edit', $course->id)
                ->with('success', 'Course created successfully! Now add sections and lessons.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to create course. Please try again.']);
        }
    }

    /**
     * Show the course builder for editing.
     */
    public function edit($id)
    {
        $course = Course::where('id', $id)
            ->where('creator_id', Auth::id())
            ->with(['category', 'sections.lessons' => function($query) {
                $query->orderBy('order_index');
            }])
            ->firstOrFail();

        $categories = Category::all();

        return view('teacher.course-builder.edit', compact('course', 'categories'));
    }



    /**
     * Update course basic information.
     */
    public function update(Request $request, $id)
    {
        try {
            $course = Course::where('id', $id)
                ->where('creator_id', Auth::id())
                ->firstOrFail();

            // Check if this is a toggle publish request
            if ($request->has('toggle_publish')) {
                $course->is_published = !$course->is_published;
                $course->save();

                return response()->json([
                    'success' => true,
                    'message' => $course->is_published ? 'Course published successfully!' : 'Course unpublished successfully!',
                    'is_published' => $course->is_published
                ]);
            }

            // Regular update validation
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'level' => 'required|string|in:beginner,intermediate,advanced',
                'image' => 'nullable|image|max:2048',
                'is_published' => 'nullable|boolean',
            ]);

            $course->title = $request->title;
            $course->description = $request->description;
            $course->category_id = $request->category_id;
            $course->level = $request->level;
            $course->is_published = (bool)$request->is_published;

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($course->image) {
                    Storage::disk('public')->delete($course->image);
                }

                $path = $request->file('image')->store('course-images', 'public');
                $course->image = $path;
            }

            $course->save();

            return back()->with('success', 'Course updated successfully!');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating course: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a course.
     */
    public function destroy($id)
    {
        $course = Course::where('id', $id)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        // Delete course image
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }

        $course->delete();

        return redirect()->route('teacher.course-builder.index')
            ->with('success', 'Course deleted successfully!');
    }

    /**
     * Add a new section to the course.
     */
    public function addSection(Request $request, $courseId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $maxOrder = $course->sections()->max('order_index') ?? 0;

        $section = new Section();
        $section->course_id = $course->id;
        $section->title = $request->title;
        $section->description = $request->description;
        $section->order_index = $maxOrder + 1;
        $section->is_published = false;
        $section->save();

        return response()->json([
            'success' => true,
            'message' => 'Section added successfully!',
            'section' => $section->load('lessons')
        ]);
    }

    /**
     * Update section order.
     */
    public function updateSectionOrder(Request $request, $courseId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $request->validate([
            'sections' => 'required|array',
            'sections.*.id' => 'required|exists:sections,id',
            'sections.*.order_index' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->sections as $sectionData) {
                Section::where('id', $sectionData['id'])
                    ->where('course_id', $course->id)
                    ->update(['order_index' => $sectionData['order_index']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Section order updated successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update section order.'
            ], 500);
        }
    }

    /**
     * Get course statistics.
     */
    public function getStats($id)
    {
        $course = Course::where('id', $id)
            ->where('creator_id', Auth::id())
            ->with(['sections.lessons'])
            ->firstOrFail();

        $stats = [
            'total_sections' => $course->sections->count(),
            'total_lessons' => $course->lessons()->count(),
            'total_duration' => $course->total_duration,
            'published_lessons' => $course->publishedLessons()->count(),
            'draft_lessons' => $course->lessons()->where('is_published', false)->count(),
            'completion_percentage' => $course->is_complete ? 100 : 0,
        ];

        return response()->json($stats);
    }
}
