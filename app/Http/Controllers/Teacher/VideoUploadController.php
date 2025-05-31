<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VideoUploadController extends Controller
{
    /**
     * Upload video file
     */
    public function uploadVideo(Request $request)
    {
        try {
            $request->validate([
                'video' => 'required|file|mimes:mp4,avi,mov,mkv,webm|max:512000', // 500MB max
            ]);

            $file = $request->file('video');

            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Store in videos directory
            $path = $file->storeAs('videos', $filename, 'public');

            // Get file info
            $fileSize = $file->getSize();
            $originalName = $file->getClientOriginalName();

            return response()->json([
                'success' => true,
                'message' => 'Video uploaded successfully',
                'file_path' => Storage::url($path),
                'file_name' => $filename,
                'original_name' => $originalName,
                'file_size' => $fileSize,
                'storage_path' => $path
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete uploaded video
     */
    public function deleteVideo(Request $request)
    {
        try {
            $request->validate([
                'file_path' => 'required|string'
            ]);

            $filePath = str_replace('/storage/', '', $request->file_path);

            if (Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);

                return response()->json([
                    'success' => true,
                    'message' => 'Video deleted successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get video info
     */
    public function getVideoInfo(Request $request)
    {
        try {
            $request->validate([
                'file_path' => 'required|string'
            ]);

            $filePath = str_replace('/storage/', '', $request->file_path);

            if (Storage::disk('public')->exists($filePath)) {
                $fullPath = Storage::disk('public')->path($filePath);
                $fileSize = Storage::disk('public')->size($filePath);

                return response()->json([
                    'success' => true,
                    'file_exists' => true,
                    'file_size' => $fileSize,
                    'file_url' => Storage::url($filePath)
                ]);
            }

            return response()->json([
                'success' => false,
                'file_exists' => false,
                'message' => 'File not found'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking file: ' . $e->getMessage()
            ], 500);
        }
    }
}
