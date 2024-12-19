<!-- Add Nationality Modal -->
<div id="addNationalityModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3">
        <div class="modal-header flex justify-between p-4 border-b">
            <h5 class="text-lg font-bold">Add Nationality</h5>
            <button type="button" class="text-gray-500 hover:text-gray-700" onclick="hideModal('addNationalityModal')">×</button>
        </div>
        <div class="modal-body p-4">
            <form id="addNationalityForm">
                <div class="mb-4">
                    <label for="nationality_name" class="block mb-2 text-sm font-medium text-gray-700">Nationality Name</label>
                    <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="nationality_name" name="name" required>
                </div>
                <div class="mb-4">
                    <label for="nationality_code" class="block mb-2 text-sm font-medium text-gray-700">Country Code</label>
                    <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="nationality_code" name="code" required>
                </div>
                <div class="mb-4">
                    <label for="nationality_flag_url" class="block mb-2 text-sm font-medium text-gray-700">Flag URL</label>
                    <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="nationality_flag_url" name="flag_url" required>
                </div>
                <button type="button" onclick="addNationality()" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Add Nationality</button>
            </form>
        </div>
    </div>
</div>

<!-- Update Nationality Modal -->
<div id="updateNationalityModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3">
        <div class="modal-header flex justify-between p-4 border-b">
            <h5 class="text-lg font-bold">Update Nationality</h5>
            <button type="button" class="text-gray-500 hover:text-gray-700" onclick="hideModal('updateNationalityModal')">×</button>
        </div>
        <div class="modal-body p-4">
            <form id="updateNationalityForm">
                <input type="hidden" id="update_nationality_id" name="id">
                <div class="mb-4">
                    <label for="update_nationality_name" class="block mb-2 text-sm font-medium text-gray-700">Nationality Name</label>
                    <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_nationality_name" name="name" required>
                </div>
                <div class="mb-4">
                    <label for="update_nationality_code" class="block mb-2 text-sm font-medium text-gray-700">Country Code</label>
                    <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_nationality_code" name="code" required>
                </div>
                <div class="mb-4">
                    <label for="update_nationality_flag_url" class="block mb-2 text-sm font-medium text-gray-700">Flag URL</label>
                    <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_nationality_flag_url" name="flag_url" required>
                </div>
                <button type="button" onclick="updateNationality()" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Update Nationality</button>
            </form>
        </div>
    </div>
</div>