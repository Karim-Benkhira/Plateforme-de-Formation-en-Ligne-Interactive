<!-- Section Modal -->
<div id="sectionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden" style="z-index: 9999;">
    <div class="bg-gray-900 rounded-lg p-6 w-full max-w-md mx-4">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white" id="sectionModalTitle">Add Section</h3>
            <button onclick="closeSectionModal()" class="text-gray-400 hover:text-white">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="sectionForm">
            <div class="space-y-4">
                <div>
                    <label class="block text-white font-medium mb-2">Section Title</label>
                    <input type="text" id="sectionTitle" required
                        class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg py-2 px-3 focus:outline-none focus:border-blue-500"
                        placeholder="e.g., Introduction to the Course">
                </div>

                <div>
                    <label class="block text-white font-medium mb-2">Description (Optional)</label>
                    <textarea id="sectionDescription" rows="3"
                        class="w-full bg-gray-800 text-white border border-gray-700 rounded-lg py-2 px-3 focus:outline-none focus:border-blue-500"
                        placeholder="Brief description of what this section covers..."></textarea>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="closeSectionModal()"
                    class="px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <span id="sectionSubmitText">Create Section</span>
                </button>
            </div>
        </form>
    </div>
</div>


