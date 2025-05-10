<?php

namespace App\Services;

use App\Models\FaceData;
use App\Models\User;
use App\Models\ExamSession;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class FaceRecognitionService
{
    /**
     * Register a user's face
     *
     * @param User $user
     * @param array $faceDescriptor
     * @param string $faceImage Base64 encoded image
     * @return array
     */
    public function registerFace(User $user, array $faceDescriptor, string $faceImage): array
    {
        try {
            // Log the face descriptor for debugging
            Log::info('Face descriptor received: ' . json_encode($faceDescriptor));

            // Save the face image (base64 encoded)
            $image = $faceImage;
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'face_' . $user->id . '_' . time() . '.png';
            $imagePath = 'faces/' . $imageName;

            // Make sure the directory exists
            if (!Storage::disk('public')->exists('faces')) {
                Storage::disk('public')->makeDirectory('faces');
            }

            // Save the image
            $imageResult = Storage::disk('public')->put($imagePath, base64_decode($image));
            if (!$imageResult) {
                Log::error('Failed to save face image to storage');
                return [
                    'success' => false,
                    'message' => 'Failed to save face image'
                ];
            }

            // Ensure the face descriptor is in the correct format
            // Make sure it's a simple array of floats
            $cleanDescriptor = [];
            foreach ($faceDescriptor as $value) {
                $cleanDescriptor[] = (float) $value;
            }

            // Save or update face data
            try {
                $faceData = FaceData::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'face_descriptor' => $cleanDescriptor,
                        'face_image_path' => $imagePath,
                        'is_verified' => true,
                        'last_verified_at' => now(),
                    ]
                );

                Log::info('Face data saved successfully for user ID: ' . $user->id);
            } catch (Exception $dbException) {
                Log::error('Database error saving face data: ' . $dbException->getMessage());
                Log::error('Database exception trace: ' . $dbException->getTraceAsString());

                return [
                    'success' => false,
                    'message' => 'Database error: ' . $dbException->getMessage()
                ];
            }

            return [
                'success' => true,
                'message' => 'Face registered successfully',
                'data' => [
                    'face_image_url' => Storage::url($imagePath)
                ]
            ];
        } catch (Exception $e) {
            Log::error('Error registering face: ' . $e->getMessage());
            Log::error('Exception trace: ' . $e->getTraceAsString());

            return [
                'success' => false,
                'message' => 'Failed to register face: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify a user's face against their registered face
     *
     * @param User $user
     * @param array $faceDescriptor
     * @return array
     */
    public function verifyFace(User $user, array $faceDescriptor): array
    {
        try {
            $faceData = $user->faceData;

            if (!$faceData || !$faceData->face_descriptor) {
                return [
                    'success' => false,
                    'message' => 'No registered face found for verification'
                ];
            }

            $registeredDescriptor = $faceData->face_descriptor;

            // Calculate similarity between the two face descriptors
            $similarity = $this->calculateSimilarity($faceDescriptor, $registeredDescriptor);
            $threshold = 0.6; // Threshold for face matching (lower is stricter)

            $isMatch = $similarity >= $threshold;
            $confidence = $similarity;

            if ($isMatch) {
                // Update verification status
                $faceData->is_verified = true;
                $faceData->last_verified_at = now();
                $faceData->save();

                return [
                    'success' => true,
                    'message' => 'Face verification successful',
                    'data' => [
                        'confidence' => $confidence,
                        'verified_at' => $faceData->last_verified_at
                    ]
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Face verification failed',
                    'data' => [
                        'confidence' => $confidence
                    ]
                ];
            }
        } catch (Exception $e) {
            Log::error('Error verifying face: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to verify face: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Calculate similarity between two face descriptors
     *
     * @param array $descriptor1
     * @param array $descriptor2
     * @return float Similarity score (0-1, higher is more similar)
     */
    protected function calculateSimilarity(array $descriptor1, array $descriptor2): float
    {
        // Ensure both descriptors have the same length
        if (count($descriptor1) !== count($descriptor2)) {
            return 0;
        }

        // Calculate Euclidean distance
        $sum = 0;
        for ($i = 0; $i < count($descriptor1); $i++) {
            $diff = $descriptor1[$i] - $descriptor2[$i];
            $sum += $diff * $diff;
        }
        $distance = sqrt($sum);

        // Convert distance to similarity (0-1)
        // Typical face recognition distance threshold is around 0.6
        // Distance of 0 means perfect match (similarity 1)
        // Distance of 1.4 or more means no match (similarity 0)
        $maxDistance = 1.4;
        $similarity = max(0, 1 - ($distance / $maxDistance));

        return $similarity;
    }

    /**
     * Start an exam session with face verification
     *
     * @param User $user
     * @param int $quizId
     * @return array
     */
    public function startExamSession(User $user, int $quizId): array
    {
        try {
            // Check if user has registered face
            if (!$user->hasFaceRegistered()) {
                return [
                    'success' => false,
                    'message' => 'You need to register your face before taking a secure exam',
                    'redirect' => route('face.register')
                ];
            }

            // Create or update exam session
            $examSession = ExamSession::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'quiz_id' => $quizId,
                    'is_active' => true
                ],
                [
                    'started_at' => now(),
                    'last_verified_at' => now(),
                    'verification_count' => 1,
                    'failed_verifications' => 0
                ]
            );

            return [
                'success' => true,
                'message' => 'Exam session started successfully',
                'data' => [
                    'session_id' => $examSession->id,
                    'started_at' => $examSession->started_at
                ]
            ];
        } catch (Exception $e) {
            Log::error('Error starting exam session: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to start exam session: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Record a verification check during an exam
     *
     * @param int $sessionId
     * @param bool $isVerified
     * @return array
     */
    public function recordVerificationCheck(int $sessionId, bool $isVerified): array
    {
        try {
            $examSession = ExamSession::findOrFail($sessionId);

            // Update verification count
            $examSession->verification_count += 1;

            if (!$isVerified) {
                $examSession->failed_verifications += 1;
            }

            $examSession->last_verified_at = now();
            $examSession->save();

            // Check if too many failed verifications
            $maxFailures = 3; // Maximum allowed failed verifications

            if ($examSession->failed_verifications >= $maxFailures) {
                $examSession->is_active = false;
                $examSession->terminated_at = now();
                $examSession->termination_reason = 'Too many failed verifications';
                $examSession->save();

                return [
                    'success' => false,
                    'message' => 'Exam session terminated due to too many failed verifications',
                    'data' => [
                        'session_terminated' => true,
                        'failed_verifications' => $examSession->failed_verifications
                    ]
                ];
            }

            return [
                'success' => true,
                'message' => 'Verification check recorded',
                'data' => [
                    'verification_count' => $examSession->verification_count,
                    'failed_verifications' => $examSession->failed_verifications
                ]
            ];
        } catch (Exception $e) {
            Log::error('Error recording verification check: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to record verification check: ' . $e->getMessage()
            ];
        }
    }
}
