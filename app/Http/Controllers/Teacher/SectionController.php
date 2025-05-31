<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    /**
     * Store a new section.
     */
    public function store(Request $request, $courseId)
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
            'message' => 'Section created successfully!',
            'section' => $section->load('lessons')
        ]);
    }

    /**
     * Update a section.
     */
    public function update(Request $request, $courseId, $sectionId)
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
            'is_published' => 'nullable|boolean',
        ]);

        $section->title = $request->title;
        $section->description = $request->description;
        $section->is_published = (bool)$request->is_published;
        $section->save();

        return response()->json([
            'success' => true,
            'message' => 'Section updated successfully!',
            'section' => $section->load('lessons')
        ]);
    }

    /**
     * Delete a section.
     */
    public function destroy($courseId, $sectionId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $section = Section::where('id', $sectionId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Delete all lessons in this section
        foreach ($section->lessons as $lesson) {
            if ($lesson->content_file) {
                \Storage::disk('public')->delete($lesson->content_file);
            }
            if ($lesson->thumbnail) {
                \Storage::disk('public')->delete($lesson->thumbnail);
            }
        }

        $section->delete();

        return response()->json([
            'success' => true,
            'message' => 'Section deleted successfully!'
        ]);
    }

    /**
     * Update sections order.
     */
    public function updateOrder(Request $request, $courseId)
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
                'message' => 'Sections order updated successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update sections order.'
            ], 500);
        }
    }

    /**
     * Toggle section publish status.
     */
    public function togglePublish($courseId, $sectionId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $section = Section::where('id', $sectionId)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $section->is_published = !$section->is_published;
        $section->save();

        return response()->json([
            'success' => true,
            'message' => $section->is_published ? 'Section published!' : 'Section unpublished!',
            'is_published' => $section->is_published
        ]);
    }

    /**
     * Get section details.
     */
    public function show($courseId, $sectionId)
    {
        $course = Course::where('id', $courseId)
            ->where('creator_id', Auth::id())
            ->firstOrFail();

        $section = Section::where('id', $sectionId)
            ->where('course_id', $course->id)
            ->with(['lessons' => function($query) {
                $query->orderBy('order_index');
            }])
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'section' => $section
        ]);
    }
}
