<!-- Add Team Modal -->
<div id="addTeamModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3">
        <div class="modal-header flex justify-between p-4 border-b">
            <h5 class="text-lg font-bold">Add Team</h5>
            <button type="button" class="text-gray-500 hover:text-gray-700" onclick="hideModal('addTeamModal')">×</button>
        </div>
        <div class="modal-body p-4">
            <form id="addTeamForm">
                <div class="mb-4">
                    <label for="team_name" class="block mb-2 text-sm font-medium text-gray-700">Team Name</label>
                    <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="team_name" name="name" required>
                </div>
                <div class="mb-4">
                    <label for="team_rating" class="block mb-2 text-sm font-medium text-gray-700">Rating</label>
                    <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="team_rating" name="rating" required>
                </div>
                <div class="mb-4">
                    <label for="team_flag_url" class="block mb-2 text-sm font-medium text-gray-700">Flag URL</label>
                    <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="team_flag_url" name="flag_url" required>
                </div>
                <button type="button" onclick="addTeam()" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Add Team</button>
            </form>
        </div>
    </div>
</div>

<!-- Update Team Modal -->
<div id="updateTeamModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3">
        <div class="modal-header flex justify-between p-4 border-b">
            <h5 class="text-lg font-bold">Update Team</h5>
            <button type="button" class="text-gray-500 hover:text-gray-700" onclick="hideModal('updateTeamModal')">×</button>
        </div>
        <div class="modal-body p-4">
            <form id="updateTeamForm">
                <input type="hidden" id="update_team_id" name="id">
                <div class="mb-4">
                    <label for="update_team_name" class="block mb-2 text-sm font-medium text-gray-700">Team Name</label>
                    <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_team_name" name="name" required>
                </div>
                <div class="mb-4">
                    <label for="update_team_rating" class="block mb-2 text-sm font-medium text-gray-700">Rating</label>
                    <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_team_rating" name="rating" required>
                </div>
                <div class="mb-4">
                    <label for="update_team_flag_url" class="block mb-2 text-sm font-medium text-gray-700">Flag URL</label>
                    <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_team_flag_url" name="flag_url" required>
                </div>
                <button type="button" onclick="updateTeam()" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Update Team</button>
            </form>
        </div>
    </div>
</div>