

document.addEventListener('DOMContentLoaded', function() {
    loadDashboardStats();
    loadPlayers();
    loadTeamsOptions();
    loadNationalitiesOptions();

    
    initializeCharts();
});


function showModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
}

function hideModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}


document.querySelector('[data-modal-toggle="addPlayerModal"]').addEventListener('click', function() {
    showModal('addPlayerModal');
});


function loadDashboardStats() {
    fetch('api/stats.php')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalPlayers').textContent = data.totalPlayers;
            document.getElementById('totalTeams').textContent = data.totalTeams;
        })
        .catch(error => console.error('Error loading dashboard stats:', error));
}


function initializeCharts() {
    
    fetch('api/nationality-stats.php')
        .then(response => response.json())
        .then(data => {
            const nationalityCtx = document.getElementById('nationalityChart').getContext('2d');
            new Chart(nationalityCtx, {
                type: 'pie',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        backgroundColor: generateColors(data.labels.length)
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error loading nationality stats:', error));

    
    fetch('api/team-performance.php')
        .then(response => response.json())
        .then(data => {
            const performanceCtx = document.getElementById('performanceChart').getContext('2d');
            new Chart(performanceCtx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Team Rating',
                        data: data.values,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error loading team performance data:', error));
}


function generateColors(count) {
    const colors = [];
    for (let i = 0; i < count; i++) {
        colors.push(`hsl(${(i * 360) / count}, 70%, 50%)`);
    }
    return colors;
}


function createEntity(type, data) {
    return fetch(`api/${type}.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json());
}

function updateEntity(type, id, data) {
    return fetch(`api/${type}.php?id=${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json());
}

function deleteEntity(type, id) {
    if (confirm(document.querySelector('[data-lang="confirm_delete"]').textContent)) {
        return fetch(`api/${type}.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json());
    }
}


function loadPlayers() {
    fetch('api/get_players.php')
        .then(response => response.json())
        .then(players => {
            const tbody = document.querySelector('.overflow-x-auto table tbody');
            tbody.innerHTML = ''; 

            players.forEach(player => {
                let row = document.createElement('tr');
                row.className = 'hover:bg-gray-100';
                row.innerHTML = `
                    <td class='px-4 py-2'>${player.first_name}</td>
                    <td class='px-4 py-2'>${player.last_name}</td>
                    <td class='px-4 py-2'>${player.nationality_name}</td>
                    <td class='px-4 py-2'>${player.team_name}</td>
                    <td class='px-4 py-2'>${player.position}</td>
                    <td class='px-4 py-2'>${player.rating}</td>
                    <td class='px-4 py-2'>
                        <button class='px-2 py-1 text-white bg-green-600 rounded-md hover:bg-green-700' onclick='openUpdateModal(${JSON.stringify(player)})'>Update</button>
                        <button class='px-2 py-1 text-white bg-red-600 rounded-md hover:bg-red-700' onclick='deletePlayer(${player.id})'>Delete</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
        })
        .catch(error => console.error('Error loading players:', error));
}


function loadTeamsOptions() {
    fetch('api/get_teams.php')
        .then(response => response.json())
        .then(teams => {
            const teamSelects = document.querySelectorAll('[name="team_id"]'); 
            teamSelects.forEach(select => {
                select.innerHTML = '<option value="">Select Team</option>'; 
                teams.forEach(team => {
                    const option = new Option(team.name, team.id);
                    select.add(option);
                });
            });
        })
        .catch(error => console.error('Error loading teams:', error));
}


function loadNationalitiesOptions() {
    fetch('api/get_nationalities.php')
        .then(response => response.json())
        .then(nationalities => {
            const nationalitySelects = document.querySelectorAll('[name="nationality_id"]'); 
            nationalitySelects.forEach(select => {
                select.innerHTML = '<option value="">Select Nationality</option>'; 
                nationalities.forEach(nationality => {
                    const option = new Option(nationality.name, nationality.id);
                    select.add(option);
                });
            });
        })
        .catch(error => console.error('Error loading nationalities:', error));
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
            Swal.fire('Success!', 'Player added successfully!', 'success')
                .then(() => {
                    hideModal('addPlayerModal');
                    loadPlayers(); 
                });
        } else {
            Swal.fire('Error!', 'Failed to add player: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred while trying to add the player.', 'error');
    });
}


function openUpdateModal(player) {
    document.getElementById('player_id').value = player.id;
    document.getElementById('update_first_name').value = player.first_name;
    document.getElementById('update_last_name').value = player.last_name;
    document.getElementById('update_nationality_id').value = player.nationality_id;
    document.getElementById('update_team_id').value = player.team_id;
    document.getElementById('update_position').value = player.position;
    document.getElementById('update_rating').value = player.rating;
    document.getElementById('update_pace').value = player.pace;
    document.getElementById('update_shooting').value = player.shooting;
    document.getElementById('update_passing').value = player.passing;
    document.getElementById('update_dribbling').value = player.dribbling;
    document.getElementById('update_defending').value = player.defending;
    document.getElementById('update_physical').value = player.physical;

    showModal('updatePlayerModal');
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
            Swal.fire('Success!', 'Player updated successfully!', 'success')
                .then(() => {
                    hideModal('updatePlayerModal');
                    loadPlayers(); 
                });
        } else {
            Swal.fire('Error!', 'Failed to update player: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred while trying to update the player.', 'error');
    });
}


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
                    Swal.fire('Deleted!', 'Player deleted successfully!', 'success')
                        .then(() => {
                            loadPlayers();
                        });
                } else {
                    Swal.fire('Error!', 'Failed to delete player: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while trying to delete the player.', 'error');
            });
        }
    });
}