<?php

namespace App\Http\Controllers;

use App\Models\FaceData;
use App\Models\User;
use App\Models\Quiz;
use App\Models\ExamSession;
use App\Services\FaceRecognitionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FaceRecognitionController extends Controller
{
    /**
     * The face recognition service instance.
     */
    protected $faceService;

    /**
     * Create a new controller instance.
     *
     * @param FaceRecognitionService $faceService
     * @return void
     */
    public function __construct(FaceRecognitionService $faceService)
    {
        $this->faceService = $faceService;
    }
    /**
     * Show the face registration page
     *
     * @return \Illuminate\View\View
     */
    public function showRegistration()
    {
        $user = Auth::user();
        $hasFaceRegistered = $user->hasFaceRegistered();

        return view('face-recognition.register', compact('hasFaceRegistered'));
    }

    /**
     * Show the modern face registration page
     *
     * @return \Illuminate\View\View
     */
    public function showModernRegistration()
    {
        $user = Auth::user();
        $hasFaceRegistered = $user->hasFaceRegistered();

        return view('face-recognition.modern-register', compact('hasFaceRegistered'));
    }

    /**
     * Show the debug face registration page
     *
     * @return \Illuminate\View\View
     */
    public function showDebugRegistration()
    {
        $user = Auth::user();
        $hasFaceRegistered = $user->hasFaceRegistered();

        return view('face-recognition.debug-register', compact('hasFaceRegistered'));
    }

    /**
     * Register a user's face
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerFace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'face_descriptor' => 'required|string',
            'face_image' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = Auth::user();

            // Parse the face descriptor
            $descriptorString = $request->face_descriptor;
            Log::info('Face descriptor from request (first 100 chars): ' . substr($descriptorString, 0, 100) . '...');

            // Try to decode the descriptor
            try {
                $faceDescriptor = json_decode($descriptorString, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('JSON decode error: ' . json_last_error_msg());
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid face descriptor format: ' . json_last_error_msg()
                    ], 422);
                }

                if (!is_array($faceDescriptor)) {
                    Log::error('Face descriptor is not an array');
                    return response()->json([
                        'success' => false,
                        'message' => 'Face descriptor must be an array'
                    ], 422);
                }

                Log::info('Decoded face descriptor (count): ' . count($faceDescriptor));
            } catch (\Exception $jsonEx) {
                Log::error('Exception decoding JSON: ' . $jsonEx->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Error decoding face descriptor: ' . $jsonEx->getMessage()
                ], 422);
            }

            // Process the request
            $result = $this->faceService->registerFace($user, $faceDescriptor, $request->face_image);

            return response()->json($result, $result['success'] ? 200 : 500);
        } catch (\Exception $e) {
            Log::error('Exception in registerFace controller: ' . $e->getMessage());
            Log::error('Exception trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Unexpected error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify a user's face
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyFace(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'face_descriptor' => 'required|json',
            'session_id' => 'nullable|integer|exists:exam_sessions,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $faceDescriptor = json_decode($request->face_descriptor, true);

        // Verify face
        $result = $this->faceService->verifyFace($user, $faceDescriptor);

        // If session_id is provided, record the verification check
        if ($request->has('session_id') && $request->session_id) {
            $sessionResult = $this->faceService->recordVerificationCheck(
                $request->session_id,
                $result['success']
            );

            // Merge session result with verification result
            $result['session'] = $sessionResult;
        }

        return response()->json($result, $result['success'] ? 200 : ($result['session']['session_terminated'] ?? false ? 403 : 401));
    }

    /**
     * Get the user's face data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFaceData()
    {
        try {
            $user = Auth::user();
            $faceData = $user->faceData;

            if (!$faceData) {
                return response()->json([
                    'success' => false,
                    'message' => 'No face data found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'face_descriptor' => $faceData->face_descriptor,
                    'face_image_url' => $faceData->face_image_path ? Storage::url($faceData->face_image_path) : null,
                    'is_verified' => $faceData->is_verified,
                    'last_verified_at' => $faceData->last_verified_at
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting face data: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to get face data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the exam verification page
     *
     * @param int $quizId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showExamVerification($quizId)
    {
        $user = Auth::user();
        $quiz = Quiz::findOrFail($quizId);

        // Check if user has registered face
        if (!$user->hasFaceRegistered()) {
            return redirect()->route('face.register')
                ->with('error', 'You need to register your face before taking a secure exam.');
        }

        return view('face-recognition.exam-verification', compact('quiz'));
    }

    /**
     * Start an exam session with face verification
     *
     * @param Request $request
     * @param int $quizId
     * @return \Illuminate\Http\JsonResponse
     */
    public function startExamSession(Request $request, $quizId)
    {
        $user = Auth::user();
        $result = $this->faceService->startExamSession($user, $quizId);

        return response()->json($result, $result['success'] ? 200 : 400);
    }

    /**
     * Show the exam monitoring page for proctors
     *
     * @return \Illuminate\View\View
     */
    public function showExamMonitoring()
    {
        // Only allow teachers and admins to access this page
        if (!Auth::user()->hasRole(['teacher', 'admin'])) {
            abort(403, 'Unauthorized');
        }

        $activeSessions = ExamSession::with(['user', 'quiz'])
            ->where('is_active', true)
            ->orderBy('started_at', 'desc')
            ->get();

        $terminatedSessions = ExamSession::with(['user', 'quiz'])
            ->where('is_active', false)
            ->whereNotNull('terminated_at')
            ->orderBy('terminated_at', 'desc')
            ->limit(20)
            ->get();

        return view('face-recognition.exam-monitoring', compact('activeSessions', 'terminatedSessions'));
    }

    /**
     * Terminate an exam session
     *
     * @param Request $request
     * @param int $sessionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function terminateSession(Request $request, $sessionId)
    {
        // Only allow teachers and admins to terminate sessions
        if (!Auth::user()->hasRole(['teacher', 'admin'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            $session = ExamSession::findOrFail($sessionId);

            // Check if session is already terminated
            if (!$session->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session is already terminated'
                ]);
            }

            // Terminate the session
            $session->is_active = false;
            $session->terminated_at = now();
            $session->termination_reason = $request->input('termination_reason', 'Terminated by proctor');
            $session->save();

            return response()->json([
                'success' => true,
                'message' => 'Session terminated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error terminating session: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to terminate session: ' . $e->getMessage()
            ], 500);
        }
    }
}
