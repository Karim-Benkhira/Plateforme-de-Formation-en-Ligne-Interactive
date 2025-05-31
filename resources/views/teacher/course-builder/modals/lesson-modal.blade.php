<!-- Lesson Modal -->
<div id="lessonModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden" style="z-index: 9999;">
    <div class="bg-gray-900 rounded-lg p-6 w-full max-w-2xl mx-4 max-h-screen overflow-y-auto">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white" id="lessonModalTitle">Add Lesson</h3>
            <button onclick="closeLessonModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="lessonForm" enctype="multipart/form-data">
            <div class="space-y-4">
                <div>
                    <label class="block text-white font-medium mb-2">Lesson Title</label>
                    <input type="text" id="lessonTitle" required
                        class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg py-2 px-3 focus:outline-none focus:border-blue-500"
                        placeholder="e.g., Introduction to HTML">
                </div>

                <div>
                    <label class="block text-white font-medium mb-2">Description</label>
                    <textarea id="lessonDescription" rows="3"
                        class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg py-2 px-3 focus:outline-none focus:border-blue-500"
                        placeholder="Brief description of the lesson..."></textarea>
                </div>

                <div>
                    <label class="block text-white font-medium mb-2">Content Type</label>
                    <select id="contentType" onchange="toggleContentFields()"
                        class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg py-2 px-3 focus:outline-none focus:border-blue-500">
                        <option value="video">🎥 Video</option>
                        <option value="text">📄 Text</option>
                        <option value="pdf">📋 PDF</option>
                    </select>
                </div>

                <div id="videoFields">
                    <!-- Video Source Options -->
                    <div class="mb-4">
                        <label class="block text-white font-medium mb-2">Video Source</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" id="urlSourceBtn" onclick="switchVideoSource('url')"
                                class="video-source-btn active bg-blue-600 text-white py-2 px-4 rounded-lg text-sm">
                                🌐 Online URL
                            </button>
                            <button type="button" id="uploadSourceBtn" onclick="switchVideoSource('upload')"
                                class="video-source-btn bg-gray-700 text-gray-300 py-2 px-4 rounded-lg text-sm">
                                📁 Upload File
                            </button>
                        </div>
                    </div>

                    <!-- URL Input -->
                    <div id="urlVideoInput">
                        <label class="block text-white font-medium mb-2">Video URL (YouTube, Vimeo, etc.)</label>
                        <input type="url" id="contentUrl"
                            class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg py-2 px-3 focus:outline-none focus:border-blue-500"
                            placeholder="https://www.youtube.com/watch?v=...">
                        <p class="text-gray-400 text-sm mt-1">Supports YouTube, Vimeo, and direct video links</p>
                    </div>

                    <!-- File Upload -->
                    <div id="uploadVideoInput" style="display: none;">
                        <label class="block text-white font-medium mb-2">Upload Video File</label>
                        <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center">
                            <input type="file" id="videoFile" accept=".mp4,.avi,.mov,.mkv,.webm"
                                class="hidden" onchange="handleVideoFileSelect(this)">
                            <div id="uploadArea" onclick="document.getElementById('videoFile').click()" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <p class="text-white mb-1">Click to upload video</p>
                                <p class="text-gray-400 text-sm">MP4, AVI, MOV, MKV, WebM (Max: 500MB)</p>
                            </div>
                            <div id="uploadProgress" style="display: none;" class="mt-4">
                                <div class="bg-gray-700 rounded-full h-2">
                                    <div id="progressBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <p id="progressText" class="text-gray-400 text-sm mt-1">Uploading...</p>
                            </div>
                            <div id="uploadSuccess" style="display: none;" class="text-green-400 mt-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                <span id="uploadedFileName"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="fileFields" style="display: none;">
                    <label class="block text-white font-medium mb-2">Upload File (PDF, Documents)</label>
                    <input type="file" id="contentFile"
                        class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg py-2 px-3 focus:outline-none focus:border-blue-500"
                        accept=".pdf,.doc,.docx,.ppt,.pptx">
                </div>

                <div id="textFields" style="display: none;">
                    <label class="block text-white font-medium mb-2">Text Content</label>
                    <textarea id="contentText" rows="6"
                        class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg py-2 px-3 focus:outline-none focus:border-blue-500"
                        placeholder="Enter your lesson content here..."></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-white font-medium mb-2">Duration (minutes)</label>
                        <input type="number" id="duration" min="1"
                            class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg py-2 px-3 focus:outline-none focus:border-blue-500"
                            placeholder="e.g., 15">
                    </div>
                    <div class="flex items-center mt-8">
                        <input type="checkbox" id="isFree" class="mr-2 w-4 h-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500">
                        <label for="isFree" class="text-white">Free Preview</label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="closeLessonModal()"
                    class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <span id="lessonSubmitText">Create Lesson</span>
                </button>
            </div>
        </form>
    </div>
</div>




