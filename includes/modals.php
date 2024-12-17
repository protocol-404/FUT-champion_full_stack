<!-- Add Player Modal -->
<div id="addPlayerModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3">
        <div class="modal-header flex justify-between p-4 border-b">
            <h5 class="text-lg font-bold">Add Player</h5>
            <button type="button" class="text-gray-500 hover:text-gray-700" onclick="document.getElementById('addPlayerModal').style.display='none'">×</button>
        </div>
        <div class="modal-body p-4">
            <form id="addPlayerForm">
                <!-- Form fields (same as before) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="first_name" class="block mb-2 text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="first_name" name="first_name" required>
                    </div>
                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="last_name" name="last_name" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="nationality_id" class="block mb-2 text-sm font-medium text-gray-700">Nationality</label>
                        <select class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="nationality_id" name="nationality_id" required>
                            <option value="">Select Nationality</option>
                        </select>
                    </div>
                    <div>
                        <label for="team_id" class="block mb-2 text-sm font-medium text-gray-700">Team</label>
                        <select class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="team_id" name="team_id" required>
                            <option value="">Select Team</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="position" class="block mb-2 text-sm font-medium text-gray-700">Position</label>
                    <select class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="position" name="position" required>
                        <option value="">Select Position</option>
                        <?php foreach ($positions as $key => $value): ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="rating" class="block mb-2 text-sm font-medium text-gray-700">Rating</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="rating" name="rating" required>
                    </div>
                    <div>
                        <label for="pace" class="block mb-2 text-sm font-medium text-gray-700">Pace</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="pace" name="pace" required>
                    </div>
                    <div>
                        <label for="shooting" class="block mb-2 text-sm font-medium text-gray-700">Shooting</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="shooting" name="shooting" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="passing" class="block mb-2 text-sm font-medium text-gray-700">Passing</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="passing" name="passing" required>
                    </div>
                    <div>
                        <label for="dribbling" class="block mb-2 text-sm font-medium text-gray-700">Dribbling</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="dribbling" name="dribbling" required>
                    </div>
                    <div>
                        <label for="defending" class="block mb-2 text-sm font-medium text-gray-700">Defending</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="defending" name="defending" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="physical" class="block mb-2 text-sm font-medium text-gray-700">Physical</label>
                    <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="physical" name="physical" required>
                </div>
                <button type="button" onclick="addPlayer()" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Add Player</button>
            </form>
        </div>
    </div>
</div>

<!-- Update Player Modal -->
<div id="updatePlayerModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3">
        <div class="modal-header flex justify-between p-4 border-b">
            <h5 class="text-lg font-bold">Update Player</h5>
            <button type="button" class="text-gray-500 hover:text-gray-700" onclick="document.getElementById('updatePlayerModal').style.display='none'">×</button>
        </div>
        <div class="modal-body p-4">
            <form id="updatePlayerForm">
                <!-- Form fields (same as before) -->
                <input type="hidden" id="player_id" name="player_id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="update_first_name" class="block mb-2 text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_first_name" name="first_name" required>
                    </div>
                    <div>
                        <label for="update_last_name" class="block mb-2 text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_last_name" name="last_name" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="update_nationality_id" class="block mb-2 text-sm font-medium text-gray-700">Nationality</label>
                        <select class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_nationality_id" name="nationality_id" required>
                            <option value="">Select Nationality</option>
                        </select>
                    </div>
                    <div>
                        <label for="update_team_id" class="block mb-2 text-sm font-medium text-gray-700">Team</label>
                        <select class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_team_id" name="team_id" required>
                            <option value="">Select Team</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="update_position" class="block mb-2 text-sm font-medium text-gray-700">Position</label>
                    <select class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_position" name="position" required>
                        <option value="">Select Position</option>
                        <?php foreach ($positions as $key => $value): ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="update_rating" class="block mb-2 text-sm font-medium text-gray-700">Rating</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_rating" name="rating" required>
                    </div>
                    <div>
                        <label for="update_pace" class="block mb-2 text-sm font-medium text-gray-700">Pace</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_pace" name="pace" required>
                    </div>
                    <div>
                        <label for="update_shooting" class="block mb-2 text-sm font-medium text-gray-700">Shooting</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_shooting" name="shooting" required>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="update_passing" class="block mb-2 text-sm font-medium text-gray-700">Passing</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_passing" name="passing" required>
                    </div>
                    <div>
                        <label for="update_dribbling" class="block mb-2 text-sm font-medium text-gray-700">Dribbling</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_dribbling" name="dribbling" required>
                    </div>
                    <div>
                        <label for="update_defending" class="block mb-2 text-sm font-medium text-gray-700">Defending</label>
                        <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_defending" name="defending" required>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="update_physical" class="block mb-2 text-sm font-medium text-gray-700">Physical</label>
                    <input type="number" class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_physical" name="physical" required>
                </div>
                <button type="button" onclick="updatePlayer()" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Update Player</button>
            </form>
        </div>
    </div>
</div>