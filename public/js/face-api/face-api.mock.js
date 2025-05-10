/**
 * face-api.js (MOCK VERSION)
 * JavaScript API for face detection and face recognition in the browser with tensorflow.js
 * @version v0.22.2
 * @author Vincent Mühler
 * @copyright Vincent Mühler 2020
 * @license MIT
 * @link https://github.com/justadudewhohacks/face-api.js
 */

// This is a mock version of face-api.js for testing purposes
console.log('Face API MOCK loaded successfully');

// Simulated face-api.js functionality
window.faceapi = {
  nets: {
    tinyFaceDetector: {
      loadFromUri: async (uri) => {
        console.log('Loading Tiny Face Detector model from', uri);
        return Promise.resolve();
      }
    }
  },
  
  // TinyFaceDetectorOptions class
  TinyFaceDetectorOptions: class {
    constructor(options = {}) {
      this.inputSize = options.inputSize || 416;
      this.scoreThreshold = options.scoreThreshold || 0.5;
    }
  },
  
  // Detection functions
  detectSingleFace: (input, options) => {
    console.log('Detecting single face with options:', options);
    
    // Create a simulated detection with box coordinates
    return {
      box: {
        x: 100,
        y: 100,
        width: 200,
        height: 200
      },
      score: 0.95,
      imageWidth: input.videoWidth || 640,
      imageHeight: input.videoHeight || 480
    };
  },
  
  // Other utility functions
  createMatcher: (labeledDescriptors, distanceThreshold) => {
    return {
      findBestMatch: (descriptor) => {
        return {
          label: 'Simulated Match',
          distance: 0.4
        };
      }
    };
  },
  
  LabeledFaceDescriptors: class {
    constructor(label, descriptors) {
      this.label = label;
      this.descriptors = descriptors;
    }
  },
  
  euclideanDistance: (desc1, desc2) => {
    return 0.5; // Simulated distance
  }
};
