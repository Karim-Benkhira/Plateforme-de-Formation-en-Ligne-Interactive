<?php

namespace App\Http\Controllers;

use App\Models\StudentPhoto;
use App\Models\Quiz;
use App\Services\FaceVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FaceVerificationController extends Controller
{
    protected $faceVerificationService;

    public function __construct(FaceVerificationService $faceVerificationService)
    {
        $this->faceVerificationService = $faceVerificationService;
    }

    /**
     * Show the photo upload page for students during registration
     */
    public function showPhotoUpload()
    {
        $user = Auth::user();
        
        // Only students need to upload photos
        if (!$user->hasRole('user')) {
            return redirect()->route('dashboard')->with('error', 'Photo upload is only required for students.');
        }

        $existingPhoto = $user->studentPhoto;
        
        return view('student.photo-upload', compact('existingPhoto'));
    }

    /**
     * Handle photo upload from students
     */
    public function uploadPhoto(Request $request)
    {
        // Handle both file upload and base64 capture
        if ($request->upload_method === 'capture') {
            $request->validate([
                'photo' => 'required|string', // Base64 string for captured photos
                'upload_method' => 'required|in:upload,capture'
            ]);
        } else {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg|max:5120', // 5MB max
                'upload_method' => 'required|in:upload,capture'
            ]);
        }

        $user = Auth::user();

        try {
            // Delete existing photo if any
            if ($user->studentPhoto) {
                $user->studentPhoto->deletePhoto();
                $user->studentPhoto->delete();
            }

            // Store the photo (either uploaded file or base64 capture)
            if ($request->upload_method === 'capture') {
                // Handle base64 captured image
                $imageData = $request->photo;

                // Remove data URL prefix if present
                if (strpos($imageData, 'data:image') === 0) {
                    $imageData = substr($imageData, strpos($imageData, ',') + 1);
                }

                // Decode base64
                $decodedImage = base64_decode($imageData);
                if ($decodedImage === false) {
                    return back()->with('error', 'Invalid image data.');
                }

                // Generate filename
                $filename = 'student_photos/' . $user->id . '_' . time() . '.jpg';

                // Store the image
                Storage::put('public/' . $filename, $decodedImage);
            } else {
                // Handle uploaded file
                $photo = $request->file('photo');
                $filename = 'student_photos/' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs('public', $filename);
            }

            // Process the photo for face recognition
            $result = $this->faceVerificationService->processStudentPhoto(
                storage_path('app/public/' . $filename),
                $user->id
            );

            if (!$result['success']) {
                // Delete the uploaded file if processing failed
                Storage::delete('public/' . $filename);
                return back()->with('error', $result['message']);
            }

            // Create student photo record
            StudentPhoto::create([
                'user_id' => $user->id,
                'photo_path' => $filename,
                'photo_hash' => $result['photo_hash'],
                'face_encoding' => $result['face_encoding'],
                'is_verified' => true,
                'verified_at' => now(),
                'upload_method' => $request->upload_method,
            ]);

            return redirect()->route('student.dashboard')
                ->with('success', 'Photo uploaded successfully! You can now take exams that require face verification.');

        } catch (\Exception $e) {
            Log::error('Photo upload failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to upload photo. Please try again.');
        }
    }

    /**
     * Show face verification page before exam
     */
    public function showExamVerification($quizId)
    {
        $user = Auth::user();
        $quiz = Quiz::findOrFail($quizId);

        // Check if quiz requires face verification
        if (!$quiz->requires_face_verification) {
            return redirect()->route('student.quiz', $quizId);
        }

        // Check if user has uploaded a photo
        if (!$user->hasStudentPhoto()) {
            return redirect()->route('face-verification.photo-upload')
                ->with('error', 'You need to upload a photo before taking this exam.');
        }

        return view('student.exam-verification', compact('quiz'));
    }

    /**
     * Verify face before exam access
     */
    public function verifyForExam(Request $request)
    {
        $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'captured_image' => 'required|string' // Base64 image data
        ]);

        $user = Auth::user();
        $quiz = Quiz::findOrFail($request->quiz_id);

        try {
            // Check if user has a registered photo
            if (!$user->hasStudentPhoto()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No registered photo found. Please upload a photo first.'
                ], 400);
            }

            // Process the captured image
            $result = $this->faceVerificationService->verifyFaceForExam(
                $request->captured_image,
                $user->studentPhoto
            );

            if ($result['success']) {
                // Generate a temporary token for exam access
                $examToken = Str::random(32);
                session(['exam_verified_' . $quiz->id => $examToken]);
                session(['exam_verified_at_' . $quiz->id => now()]);

                return response()->json([
                    'success' => true,
                    'message' => 'Face verification successful!',
                    'exam_token' => $examToken,
                    'redirect_url' => route('student.quiz', $quiz->id)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 401);
            }

        } catch (\Exception $e) {
            Log::error('Face verification failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Verification failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Delete student photo
     */
    public function deletePhoto()
    {
        $user = Auth::user();
        
        if ($user->studentPhoto) {
            $user->studentPhoto->deletePhoto();
            $user->studentPhoto->delete();
            
            return back()->with('success', 'Photo deleted successfully.');
        }
        
        return back()->with('error', 'No photo found to delete.');
    }

    /**
     * Test face verification service
     */
    public function testService()
    {
        $serviceInfo = $this->faceVerificationService->getServiceInfo();

        return response()->json([
            'service_info' => $serviceInfo,
            'timestamp' => now()->toISOString()
        ]);
    }
}
