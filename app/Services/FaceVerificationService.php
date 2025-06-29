<?php

namespace App\Services;

use App\Models\StudentPhoto;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FaceVerificationService
{
    /**
     * Path to the Python face recognition script
     */
    private string $pythonScriptPath;

    public function __construct()
    {
        $this->pythonScriptPath = base_path('scripts/face_recognition.py');
    }

    /**
     * Process student photo for registration
     *
     * @param string $imagePath Full path to the uploaded image
     * @param int $userId User ID for logging
     * @return array
     */
    public function processStudentPhoto(string $imagePath, int $userId): array
    {
        try {
            Log::info("Processing student photo for user {$userId}: {$imagePath}");

            // Add detailed debugging
            Log::info("FaceVerificationService debug - Checking path: {$imagePath}");
            Log::info("FaceVerificationService debug - File exists: " . (file_exists($imagePath) ? 'Yes' : 'No'));
            Log::info("FaceVerificationService debug - Directory exists: " . (file_exists(dirname($imagePath)) ? 'Yes' : 'No'));

            if (file_exists($imagePath)) {
                Log::info("FaceVerificationService debug - File size: " . filesize($imagePath) . " bytes");
                Log::info("FaceVerificationService debug - File permissions: " . substr(sprintf('%o', fileperms($imagePath)), -4));
            }

            // Verify the image file exists
            if (!file_exists($imagePath)) {
                Log::error("FaceVerificationService - Image file not found at: {$imagePath}");
                return [
                    'success' => false,
                    'message' => 'Image file not found'
                ];
            }

            // Call Python script to process the photo
            $process = new Process([
                'python3',
                $this->pythonScriptPath,
                'process_photo',
                $imagePath
            ]);

            $process->setTimeout(30); // 30 seconds timeout
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error("Face processing failed for user {$userId}: " . $process->getErrorOutput());

                // In development, provide a fallback to allow photo upload
                if (app()->environment(['local', 'development'])) {
                    Log::info("Using fallback face processing for development environment");
                    return [
                        'success' => true,
                        'face_encoding' => array_fill(0, 128, 0.0), // Dummy encoding
                        'photo_hash' => md5_file($imagePath),
                        'message' => 'Photo processed with fallback (development mode)'
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Face processing failed: ' . $process->getErrorOutput()
                ];
            }

            $output = $process->getOutput();
            $result = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("Invalid JSON response from face processing script: {$output}");

                // In development, provide a fallback
                if (app()->environment(['local', 'development'])) {
                    Log::info("Using fallback due to invalid JSON response in development");
                    return [
                        'success' => true,
                        'face_encoding' => array_fill(0, 128, 0.0), // Dummy encoding
                        'photo_hash' => md5_file($imagePath),
                        'message' => 'Photo processed with fallback (development mode)'
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Invalid response from face processing'
                ];
            }

            if (!$result['success']) {
                Log::warning("Face processing unsuccessful for user {$userId}: " . $result['message']);

                // In development, provide a fallback for failed face detection
                if (app()->environment(['local', 'development'])) {
                    Log::info("Using fallback due to face processing failure in development");
                    return [
                        'success' => true,
                        'face_encoding' => array_fill(0, 128, 0.0), // Dummy encoding
                        'photo_hash' => md5_file($imagePath),
                        'message' => 'Photo processed with fallback (development mode)'
                    ];
                }
            } else {
                Log::info("Face processing successful for user {$userId}");
            }

            return $result;

        } catch (ProcessFailedException $e) {
            Log::error("Process failed for user {$userId}: " . $e->getMessage());

            // In development, provide a fallback
            if (app()->environment(['local', 'development'])) {
                Log::info("Using fallback due to process failure in development");
                return [
                    'success' => true,
                    'face_encoding' => array_fill(0, 128, 0.0), // Dummy encoding
                    'photo_hash' => md5_file($imagePath),
                    'message' => 'Photo processed with fallback (development mode)'
                ];
            }

            return [
                'success' => false,
                'message' => 'Face processing service unavailable'
            ];
        } catch (\Exception $e) {
            Log::error("Unexpected error processing photo for user {$userId}: " . $e->getMessage());

            // In development, provide a fallback
            if (app()->environment(['local', 'development'])) {
                Log::info("Using fallback due to unexpected error in development");
                return [
                    'success' => true,
                    'face_encoding' => array_fill(0, 128, 0.0), // Dummy encoding
                    'photo_hash' => md5_file($imagePath),
                    'message' => 'Photo processed with fallback (development mode)'
                ];
            }

            return [
                'success' => false,
                'message' => 'An unexpected error occurred'
            ];
        }
    }

    /**
     * Verify face for exam access
     *
     * @param string $capturedImageBase64 Base64 encoded captured image
     * @param StudentPhoto $studentPhoto Stored student photo record
     * @return array
     */
    public function verifyFaceForExam(string $capturedImageBase64, StudentPhoto $studentPhoto): array
    {
        try {
            Log::info("Verifying face for exam access for user {$studentPhoto->user_id}");

            // Check if student photo has face encoding
            if (!$studentPhoto->hasFaceEncoding()) {
                return [
                    'success' => false,
                    'message' => 'No face encoding found for comparison'
                ];
            }

            // Prepare stored encoding as JSON
            $storedEncoding = json_encode($studentPhoto->face_encoding);

            // Call Python script to verify the face
            $process = new Process([
                'python3',
                $this->pythonScriptPath,
                'verify_face',
                $capturedImageBase64,
                $storedEncoding
            ]);

            $process->setTimeout(30); // 30 seconds timeout
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error("Face verification failed for user {$studentPhoto->user_id}: " . $process->getErrorOutput());
                return [
                    'success' => false,
                    'message' => 'Face verification service error'
                ];
            }

            $output = $process->getOutput();
            $result = json_decode($output, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error("Invalid JSON response from face verification script: {$output}");
                return [
                    'success' => false,
                    'message' => 'Invalid response from verification service'
                ];
            }

            // Log the verification result
            if ($result['success']) {
                Log::info("Face verification successful for user {$studentPhoto->user_id} with confidence: " . ($result['confidence'] ?? 'unknown'));
            } else {
                Log::warning("Face verification failed for user {$studentPhoto->user_id}: " . $result['message']);
            }

            return $result;

        } catch (ProcessFailedException $e) {
            Log::error("Process failed for user {$studentPhoto->user_id}: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Face verification service unavailable'
            ];
        } catch (\Exception $e) {
            Log::error("Unexpected error verifying face for user {$studentPhoto->user_id}: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An unexpected error occurred during verification'
            ];
        }
    }

    /**
     * Test if the face recognition service is available
     *
     * @return array
     */
    public function testService(): array
    {
        try {
            // Test if Python script is accessible
            if (!file_exists($this->pythonScriptPath)) {
                return [
                    'success' => false,
                    'message' => 'Face recognition script not found'
                ];
            }

            // Test Python and required libraries
            $process = new Process(['python3', '-c', 'import face_recognition, cv2, numpy; print("OK")']);
            $process->setTimeout(10);
            $process->run();

            if (!$process->isSuccessful()) {
                return [
                    'success' => false,
                    'message' => 'Required Python libraries not available: ' . $process->getErrorOutput()
                ];
            }

            $output = trim($process->getOutput());
            if ($output !== 'OK') {
                return [
                    'success' => false,
                    'message' => 'Python libraries test failed'
                ];
            }

            return [
                'success' => true,
                'message' => 'Face recognition service is available'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Service test failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get service status and information
     *
     * @return array
     */
    public function getServiceInfo(): array
    {
        $testResult = $this->testService();
        
        return [
            'service_available' => $testResult['success'],
            'script_path' => $this->pythonScriptPath,
            'script_exists' => file_exists($this->pythonScriptPath),
            'test_message' => $testResult['message']
        ];
    }
}
