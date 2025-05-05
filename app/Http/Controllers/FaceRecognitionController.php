<?php

namespace App\Http\Controllers;

use App\Models\FaceRecognitionLog;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaceRecognitionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Register a user's face for recognition.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // Base64 encoded image
        ]);

        $user = auth()->user();

        // Decode the base64 image
        $image = $request->input('image');
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        // Save the image to storage
        $imageName = 'face_' . $user->id . '_' . time() . '.png';
        Storage::disk('public')->put('face_images/' . $imageName, base64_decode($image));

        // Update the user's profile image
        $user->update([
            'profile_image' => 'face_images/' . $imageName
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Face registered successfully'
        ]);
    }

    /**
     * Verify a user's face for an exam.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // Base64 encoded image
            'quiz_id' => 'required|exists:quizzes,id'
        ]);

        $user = auth()->user();
        $quizId = $request->input('quiz_id');
        $quiz = Quiz::findOrFail($quizId);

        // Decode the base64 image
        $image = $request->input('image');
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        // Save the verification image
        $imageName = 'verify_' . $user->id . '_' . $quizId . '_' . time() . '.png';
        Storage::disk('public')->put('verification_images/' . $imageName, base64_decode($image));

        // In a real application, here we would use a face recognition API or library
        // to compare the verification image with the user's registered face image
        // For this demo, we'll assume the verification is successful

        // For a real implementation, you would:
        // 1. Load the user's registered face image
        // 2. Use a face recognition library (like face-api.js on the frontend or a Python library on the backend)
        // 3. Compare the faces and get a confidence score
        // 4. Determine if the verification is successful based on the confidence score

        $isVerified = true; // In a real app, this would be the result of the face comparison

        // Log the verification attempt
        FaceRecognitionLog::create([
            'user_id' => $user->id,
            'quiz_id' => $quizId,
            'result' => $isVerified ? 'success' : 'failure',
            'verification_image' => 'verification_images/' . $imageName,
            'notes' => 'Verification ' . ($isVerified ? 'successful' : 'failed')
        ]);

        return response()->json([
            'success' => $isVerified,
            'message' => $isVerified ? 'Face verification successful' : 'Face verification failed',
            'redirect' => $isVerified ? route('student.quizzes.show', $quizId) : null
        ]);
    }
}
