#!/usr/bin/env python3
"""
Face Recognition Script for Laravel Application
Handles face encoding and verification using face_recognition library
"""

import sys
import json
import base64
import cv2
import numpy as np
import face_recognition
from PIL import Image
import io
import hashlib
import os

def log_error(message):
    """Log error messages to stderr"""
    print(f"ERROR: {message}", file=sys.stderr)

def log_info(message):
    """Log info messages to stderr"""
    print(f"INFO: {message}", file=sys.stderr)

def decode_base64_image(base64_string):
    """Decode base64 image string to numpy array"""
    try:
        # Remove data URL prefix if present
        if base64_string.startswith('data:image'):
            base64_string = base64_string.split(',')[1]
        
        # Decode base64
        image_data = base64.b64decode(base64_string)
        
        # Convert to PIL Image
        image = Image.open(io.BytesIO(image_data))
        
        # Convert to RGB if necessary
        if image.mode != 'RGB':
            image = image.convert('RGB')
        
        # Convert to numpy array
        return np.array(image)
    
    except Exception as e:
        log_error(f"Failed to decode base64 image: {str(e)}")
        return None

def load_image_from_path(image_path):
    """Load image from file path"""
    try:
        if not os.path.exists(image_path):
            log_error(f"Image file not found: {image_path}")
            return None
        
        image = face_recognition.load_image_file(image_path)
        return image
    
    except Exception as e:
        log_error(f"Failed to load image from path: {str(e)}")
        return None

def extract_face_encoding(image):
    """Extract face encoding from image"""
    try:
        # Find face locations
        face_locations = face_recognition.face_locations(image)
        
        if len(face_locations) == 0:
            return None, "No face detected in the image"
        
        if len(face_locations) > 1:
            return None, "Multiple faces detected. Please ensure only one face is visible"
        
        # Get face encodings
        face_encodings = face_recognition.face_encodings(image, face_locations)
        
        if len(face_encodings) == 0:
            return None, "Could not generate face encoding"
        
        return face_encodings[0].tolist(), "Success"
    
    except Exception as e:
        log_error(f"Failed to extract face encoding: {str(e)}")
        return None, f"Face encoding failed: {str(e)}"

def compare_faces(known_encoding, unknown_encoding, tolerance=0.6):
    """Compare two face encodings"""
    try:
        # Convert lists back to numpy arrays
        known_encoding = np.array(known_encoding)
        unknown_encoding = np.array(unknown_encoding)
        
        # Calculate face distance
        distance = face_recognition.face_distance([known_encoding], unknown_encoding)[0]
        
        # Check if faces match
        is_match = distance <= tolerance
        
        # Calculate confidence (inverse of distance, normalized)
        confidence = max(0, (1 - distance) * 100)
        
        return {
            'is_match': bool(is_match),
            'confidence': float(confidence),
            'distance': float(distance)
        }
    
    except Exception as e:
        log_error(f"Failed to compare faces: {str(e)}")
        return {
            'is_match': False,
            'confidence': 0.0,
            'distance': 1.0,
            'error': str(e)
        }

def process_student_photo(image_path):
    """Process student photo for registration"""
    try:
        log_info(f"Processing student photo: {image_path}")
        
        # Load image
        image = load_image_from_path(image_path)
        if image is None:
            return {
                'success': False,
                'message': 'Failed to load image'
            }
        
        # Extract face encoding
        encoding, message = extract_face_encoding(image)
        if encoding is None:
            return {
                'success': False,
                'message': message
            }
        
        # Generate photo hash
        with open(image_path, 'rb') as f:
            photo_hash = hashlib.md5(f.read()).hexdigest()
        
        return {
            'success': True,
            'face_encoding': encoding,
            'photo_hash': photo_hash,
            'message': 'Face processed successfully'
        }
    
    except Exception as e:
        log_error(f"Failed to process student photo: {str(e)}")
        return {
            'success': False,
            'message': f'Processing failed: {str(e)}'
        }

def verify_face_for_exam(captured_image_b64, stored_encoding):
    """Verify captured face against stored encoding"""
    try:
        log_info("Verifying face for exam")
        
        # Decode captured image
        captured_image = decode_base64_image(captured_image_b64)
        if captured_image is None:
            return {
                'success': False,
                'message': 'Failed to decode captured image'
            }
        
        # Extract face encoding from captured image
        captured_encoding, message = extract_face_encoding(captured_image)
        if captured_encoding is None:
            return {
                'success': False,
                'message': message
            }
        
        # Compare faces
        comparison_result = compare_faces(stored_encoding, captured_encoding)
        
        if 'error' in comparison_result:
            return {
                'success': False,
                'message': f'Comparison failed: {comparison_result["error"]}'
            }
        
        # Determine if verification passed
        min_confidence = 70.0  # Minimum confidence threshold
        
        if comparison_result['is_match'] and comparison_result['confidence'] >= min_confidence:
            return {
                'success': True,
                'message': 'Face verification successful',
                'confidence': comparison_result['confidence']
            }
        else:
            return {
                'success': False,
                'message': f'Face verification failed. Confidence: {comparison_result["confidence"]:.1f}%',
                'confidence': comparison_result['confidence']
            }
    
    except Exception as e:
        log_error(f"Failed to verify face: {str(e)}")
        return {
            'success': False,
            'message': f'Verification failed: {str(e)}'
        }

def main():
    """Main function to handle command line arguments"""
    if len(sys.argv) < 2:
        print(json.dumps({
            'success': False,
            'message': 'No command specified'
        }))
        sys.exit(1)
    
    command = sys.argv[1]
    
    try:
        if command == 'process_photo':
            if len(sys.argv) < 3:
                result = {'success': False, 'message': 'Image path required'}
            else:
                image_path = sys.argv[2]
                result = process_student_photo(image_path)
        
        elif command == 'verify_face':
            if len(sys.argv) < 4:
                result = {'success': False, 'message': 'Captured image and stored encoding required'}
            else:
                captured_image_b64 = sys.argv[2]
                stored_encoding = json.loads(sys.argv[3])
                result = verify_face_for_exam(captured_image_b64, stored_encoding)
        
        else:
            result = {'success': False, 'message': f'Unknown command: {command}'}
        
        print(json.dumps(result))
    
    except Exception as e:
        log_error(f"Main function error: {str(e)}")
        print(json.dumps({
            'success': False,
            'message': f'Script error: {str(e)}'
        }))
        sys.exit(1)

if __name__ == '__main__':
    main()
