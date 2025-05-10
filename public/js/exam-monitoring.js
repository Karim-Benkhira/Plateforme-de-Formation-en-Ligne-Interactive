/**
 * Exam Monitoring System
 * 
 * This script handles continuous face verification during secure exams.
 */

// Global variables
let examSessionId = null;
let verificationInterval = null;
let lastVerificationTime = null;
let verificationCount = 0;
let failedVerifications = 0;
let maxFailedVerifications = 3;
let verificationPeriod = 2 * 60 * 1000; // 2 minutes in milliseconds
let checkInterval = 10 * 1000; // Check every 10 seconds

// DOM elements
const videoEl = document.getElementById('face-video');
const canvasEl = document.getElementById('face-canvas');
const statusEl = document.getElementById('face-status');
const progressEl = document.getElementById('verification-progress');
const progressBarEl = document.getElementById('verification-progress-bar');

/**
 * Initialize the exam monitoring system
 */
async function initExamMonitoring() {
    // Get session ID from URL
    const urlParams = new URLSearchParams(window.location.search);
    examSessionId = urlParams.get('session_id');
    
    if (!examSessionId) {
        console.error('No exam session ID found');
        updateStatus('No exam session ID found. Please start the exam properly.', 'error');
        return false;
    }
    
    // Initialize face recognition
    const faceInitialized = await initFaceRecognition();
    if (!faceInitialized) {
        return false;
    }
    
    // Start video
    const videoStarted = await startVideo();
    if (!videoStarted) {
        return false;
    }
    
    // Start monitoring
    startMonitoring();
    
    return true;
}

/**
 * Start continuous monitoring
 */
function startMonitoring() {
    lastVerificationTime = new Date();
    updateStatus('Exam monitoring started. Please keep your face visible.', 'success');
    
    // Initial verification after a short delay
    setTimeout(performVerification, 5000);
    
    // Set up periodic verification checks
    verificationInterval = setInterval(checkVerification, checkInterval);
}

/**
 * Check if verification is needed
 */
function checkVerification() {
    // Calculate time since last verification
    const now = new Date();
    const timeSinceLastVerification = now - lastVerificationTime;
    
    // Update progress bar
    updateProgressBar(Math.max(0, 100 - (timeSinceLastVerification / verificationPeriod * 100)));
    
    // If it's time for a new verification
    if (timeSinceLastVerification >= verificationPeriod) {
        performVerification();
    }
}

/**
 * Perform face verification
 */
async function performVerification() {
    try {
        updateStatus('Verifying your identity...', 'info');
        
        // Capture face
        const descriptor = await captureFace();
        
        if (!descriptor) {
            handleFailedVerification('No face detected');
            return;
        }
        
        // Verify against registered face
        const result = await verifyFace(descriptor);
        
        if (result.success) {
            handleSuccessfulVerification(result);
        } else {
            handleFailedVerification(result.message);
        }
    } catch (error) {
        console.error('Error during verification:', error);
        handleFailedVerification('Error during verification: ' + error.message);
    }
}

/**
 * Verify a face against the registered face
 */
async function verifyFace(descriptor) {
    try {
        // Convert descriptor to array for sending to server
        const descriptorArray = Array.from(descriptor);
        
        // Send to server for verification
        const response = await fetch('/face-recognition/verify', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                face_descriptor: JSON.stringify(descriptorArray),
                session_id: examSessionId
            })
        });
        
        return await response.json();
    } catch (error) {
        console.error('Error verifying face:', error);
        return {
            success: false,
            message: 'Error verifying face: ' + error.message
        };
    }
}

/**
 * Handle successful verification
 */
function handleSuccessfulVerification(result) {
    verificationCount++;
    lastVerificationTime = new Date();
    updateStatus('Identity verified successfully', 'success');
    updateProgressBar(100);
    
    // Log verification details
    console.log(`Verification #${verificationCount} successful. Confidence: ${result.data.confidence.toFixed(2)}`);
}

/**
 * Handle failed verification
 */
function handleFailedVerification(message) {
    failedVerifications++;
    updateStatus(`Verification failed: ${message}. Attempt ${failedVerifications}/${maxFailedVerifications}`, 'error');
    
    // Check if too many failures
    if (failedVerifications >= maxFailedVerifications) {
        terminateExam();
    } else {
        // Try again after a short delay
        setTimeout(performVerification, 10000);
    }
}

/**
 * Terminate the exam due to too many failed verifications
 */
function terminateExam() {
    stopMonitoring();
    updateStatus('Exam terminated due to too many failed verifications', 'error');
    
    // Show alert and redirect
    alert('Your exam has been terminated due to too many failed identity verifications. Please contact your instructor.');
    window.location.href = '/dashboard';
}

/**
 * Stop monitoring
 */
function stopMonitoring() {
    if (verificationInterval) {
        clearInterval(verificationInterval);
        verificationInterval = null;
    }
    stopVideo();
}

/**
 * Update the status message
 */
function updateStatus(message, type = 'info') {
    if (!statusEl) return;
    
    statusEl.textContent = message;
    
    // Remove all status classes
    statusEl.classList.remove('text-blue-500', 'text-green-500', 'text-red-500', 'text-yellow-500');
    
    // Add appropriate class based on type
    switch (type) {
        case 'success':
            statusEl.classList.add('text-green-500');
            break;
        case 'error':
            statusEl.classList.add('text-red-500');
            break;
        case 'warning':
            statusEl.classList.add('text-yellow-500');
            break;
        default:
            statusEl.classList.add('text-blue-500');
    }
}

/**
 * Update the verification progress bar
 */
function updateProgressBar(percent) {
    if (!progressBarEl) return;
    
    progressBarEl.style.width = `${percent}%`;
    progressBarEl.setAttribute('aria-valuenow', percent);
    
    // Change color based on percentage
    progressBarEl.classList.remove('bg-green-500', 'bg-yellow-500', 'bg-red-500');
    
    if (percent > 60) {
        progressBarEl.classList.add('bg-green-500');
    } else if (percent > 30) {
        progressBarEl.classList.add('bg-yellow-500');
    } else {
        progressBarEl.classList.add('bg-red-500');
    }
}

// Initialize when the page loads
document.addEventListener('DOMContentLoaded', () => {
    // Only initialize on quiz pages
    if (window.location.pathname.includes('/student/quiz/')) {
        initExamMonitoring();
    }
});
