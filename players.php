<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/language.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

$players = mysqli_query($conn, "SELECT p.*, n.name as nationality_name, t.name as team_name 
                                FROM players p 
                                JOIN nationalities n ON p.nationality_id = n.id 
                                JOIN teams t ON p.team_id = t.id"
                        );

$positions = [
    'GK' => 'Goalkeeper',
    'LB' => 'Left Back',
    'CB' => 'Center Back',
    'RB' => 'Right Back',
    'LWB' => 'Left Wing Back',
    'RWB' => 'Right Wing Back',
    'CDM' => 'Central Defensive Midfielder',
    'CM' => 'Central Midfielder',
    'CAM' => 'Central Attacking Midfielder',
    'LM' => 'Left Midfielder',
    'RM' => 'Right Midfielder',
    'LW' => 'Left Winger',
    'RW' => 'Right Winger',
    'CF' => 'Center Forward',
    'ST' => 'Striker'
];

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang']; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Players</title>
    <!-- Tailwind CSS -->
    <link href="https:
       <!-- SweetAlert2 -->
    <script src="https:
       <!-- Font Awesome -->
    <link rel="stylesheet" href="https:
    <style>
        body {
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="flex">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Manage Players</h1>
                    <div class="flex items-center space-x-4">
                        <!-- Logout Button -->
                        <a href="?logout=true" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700">Logout</a>
                   </div>
             </div>
            <div class="mt-4 mb-6">
                <button class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700" data-modal-toggle="addPlayerModal">Add Player</button>

        <!-- Add Player Modal -->
        <div id="addPlayerModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/3">
                <div class="modal-header flex justify-between p-4 border-b">
                    <h5 class="text-lg font-bold">Add Player</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700" onclick="document.getElementById('addPlayerModal').style.display='none'">×</button>
                </div>
                <div class="modal-body p-4">
                    <form id="addPlayerForm">
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
                                    <?php
                                    $nationalities = mysqli_query($conn, "SELECT * FROM nationalities");
                                    while ($row = mysqli_fetch_assoc($nationalities)) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <label for="team_id" class="block mb-2 text-sm font-medium text-gray-700">Team</label>
                                <select class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="team_id" name="team_id" required>
                                    <option value="">Select Team</option>
                                    <?php
                                    $teams = mysqli_query($conn, "SELECT * FROM teams");
                                    while ($row = mysqli_fetch_assoc($teams)) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                    ?>
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
                                            <?php
                                            $nationalities = mysqli_query($conn, "SELECT * FROM nationalities");
                                            while ($row = mysqli_fetch_assoc($nationalities)) {
                                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="update_team_id" class="block mb-2 text-sm font-medium text-gray-700">Team</label>
                                        <select class="block w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" id="update_team_id" name="team_id" required>
                                            <option value="">Select Team</option>
                                            <?php
                                            $teams = mysqli_query($conn, "SELECT * FROM teams");
                                            while ($row = mysqli_fetch_assoc($teams)) {
                                                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                            }
                                            ?>
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
            </div>

            <!-- Player Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="px-4 py-2">First Name</th>
                            <th class="px-4 py-2">Last Name</th>
                            <th class="px-4 py-2">Nationality</th>
                            <th class="px-4 py-2">Team</th>
                            <th class="px-4 py-2">Position</th>
                            <th class="px-4 py-2">Rating</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($players)) {
                            echo "<tr class='hover:bg-gray-100'>";
                            echo "<td class='px-4 py-2'>" . $row['first_name'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['last_name'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['nationality_name'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['team_name'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['position'] . "</td>";
                            echo "<td class='px-4 py-2'>" . $row['rating'] . "</td>";
                            echo "<td class='px-4 py-2'>
                                    <button class='px-2 py-1 text-white bg-green-600 rounded-md hover:bg-green-700' onclick='openUpdateModal(" . $row['id'] . ", \"" . htmlspecialchars($row['first_name']) . "\", \"" . htmlspecialchars($row['last_name']) . "\", " . $row['nationality_id'] . ", " . $row['team_id'] . ", \"" . htmlspecialchars($row['position']) . "\", " . $row['rating'] . ", " . $row['pace'] . ", " . $row['shooting'] . ", " . $row['passing'] . ", " . $row['dribbling'] . ", " . $row['defending'] . ", " . $row['physical'] . ")'>Update</button>
                                    <button class='px-2 py-1 text-white bg-red-600 rounded-md hover:bg-red-700' onclick='deletePlayer(" . $row['id'] . ")'>Delete</button>
                                  </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Tailwind CSS Bundle -->
    <script src="https:

    <script src="assets/js/dashboard.js"></script>

     <script>
        function deletePlayer(playerId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('api/delete_player.php?id=' + playerId, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire(
                            'Deleted!',
                            'Player deleted successfully!',
                            'success'
                        ).then(() => {
                            location.reload();
                        });

                    } else {
                        Swal.fire(
                            'Error!',
                            'Failed to delete player: ' + (data.message || 'Unknown error'),
                            'error'
                        );
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error!',
                        'An error occurred while trying to delete the player.',
                        'error'
                    );
                });
            }
        })
    }


    function openUpdateModal(id, firstName, lastName, nationalityId, teamId, position, rating, pace, shooting, passing, dribbling, defending, physical) {
        document.getElementById('player_id').value = id;
        document.getElementById('update_first_name').value = firstName;
        document.getElementById('update_last_name').value = lastName;
        document.getElementById('update_nationality_id').value = nationalityId;
        document.getElementById('update_team_id').value = teamId;
        document.getElementById('update_position').value = position;
        document.getElementById('update_rating').value = rating;
        document.getElementById('update_pace').value = pace;
        document.getElementById('update_shooting').value = shooting;
        document.getElementById('update_passing').value = passing;
        document.getElementById('update_dribbling').value = dribbling;
        document.getElementById('update_defending').value = defending;
        document.getElementById('update_physical').value = physical;

        document.getElementById('updatePlayerModal').style.display = 'flex';
    }


    function updatePlayer() {
    const formData = new FormData(document.getElementById('updatePlayerForm'));

    fetch('api/update_player.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire(
                'Success!',
                'Player updated successfully!',
                'success'
            ).then(() => {
                document.getElementById('updatePlayerModal').style.display = 'none';
                 location.reload();
            });


        } else {
                Swal.fire(
                'Error!',
                'Failed to update player: ' + (data.message || 'Unknown error'),
                'error'
            );
        }
    })
    .catch(error => {
        console.error('Error:', error);
             Swal.fire(
                'Error!',
                'An error occurred while trying to update the player.',
                'error'
            );
        });
    }


    function addPlayer() {
        const formData = new FormData(document.getElementById('addPlayerForm'));

         fetch('api/add_player.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
         .then(data => {
             if (data.success) {
                 Swal.fire(
                        'Success!',
                        'Player added successfully!',
                        'success'
                     ).then(() => {
                       document.getElementById('addPlayerModal').style.display = 'none';
                        location.reload();
                     });

            } else {
                   Swal.fire(
                    'Error!',
                    'Failed to add player: ' + (data.message || 'Unknown error'),
                    'error'
                    );
            }
        })
        .catch(error => {
             console.error('Error:', error);
               Swal.fire(
                    'Error!',
                    'An error occurred while trying to add the player.',
                    'error'
                 );
         });
    }

    </script>
</body>
</html>