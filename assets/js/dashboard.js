

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


async function createEntity(type, data) {
    const response = await fetch(`api/${type}.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return response.json();
}

async function updateEntity(type, id, data) {
    const response = await fetch(`api/${type}.php?id=${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    return response.json();
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
                    <tr class="table-row-hover border-b align-center text-center">
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden">
                                    ${player.flag_url ? 
                                        `<img src="${player.flag_url}" alt="${player.name}" class="w-full h-full object-cover">` :
                                        `<i class="fas fa-user text-gray-400 text-xl"></i>`
                                    }
                                </div>
                            </div>
                        </td>
                    </tr>
                    <td class="px-6 py-4 text-center">${player.first_name}</td>
                    <td class="px-6 py-4 text-center">${player.last_name}</td>
                    <td class="px-6 py-4 text-center">${player.nationality_name}</td>
                    <td class="px-6 py-4 text-center">${player.team_name}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            ${player.position}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-medium">
                            ${player.rating}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick='openUpdateModal(${JSON.stringify(player)})' 
                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-full transition-colors">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick='deletePlayer(${player.id})'
                                    class="p-2 text-red-600 hover:bg-red-50 rounded-full transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
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
    document.getElementById('update_flag_url').value = player.flag_url;
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


function loadTeams() {
    fetch('api/get_teams.php')
        .then(response => response.json())
        .then(teams => {
            const teamsContainer = document.getElementById('teams-container');
            teamsContainer.innerHTML = ''; 

            teams.forEach(team => {
                let card = document.createElement('div');
                card.className = 'stats-card rounded-xl shadow-lg overflow-hidden transition-all hover:translate-y-[-5px]';
                card.innerHTML = `
                  <div class="gradient-blue p-6 flex flex-col items-center">
                    ${team.flag_url 
                      ? `<div class="relative w-24 h-24 mb-4">
                           <img src="${team.flag_url}" 
                                alt="${team.name} Logo" 
                                class="w-full h-full object-contain drop-shadow-[0_0_8px_rgba(255,255,255,0.5)] filter brightness-110"
                           >
                         </div>` 
                      : `<div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-4 shadow-[0_0_15px_rgba(255,255,255,0.2)]">
                           <span class="text-4xl text-white font-bold">${team.name.charAt(0)}</span>
                         </div>`
                    }
                    <h2 class="text-xl font-bold text-white mb-2">${team.name}</h2>
                    <div class="flex items-center space-x-2 mb-4">
                      <span class="text-sm font-medium text-white/80">Rating</span>
                      <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold">${team.rating}</span>
                    </div>
                    <div class="flex space-x-3 w-full">
                      <button onclick='openUpdateTeamModal(${JSON.stringify(team)})' 
                              class="flex-1 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-indigo-700 bg-white rounded-lg hover:bg-indigo-50 transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Update
                      </button>
                      <button onclick='deleteTeam(${team.id})' 
                              class="flex-1 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-500/80 backdrop-blur-sm rounded-lg hover:bg-red-600 transition-colors">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Delete
                      </button>
                    </div>
                  </div>
                `;
                teamsContainer.appendChild(card);
            });
        })
        .catch(error => console.error('Error loading teams:', error));
}


function addTeam() {
    const formData = new FormData(document.getElementById('addTeamForm'));
    fetch('api/add_team.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Success!', 'Team added successfully!', 'success')
                .then(() => {
                    hideModal('addTeamModal');
                    loadTeams();
                });
        } else {
            Swal.fire('Error!', 'Failed to add team: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred while trying to add the team.', 'error');
    });
}


function openUpdateTeamModal(team) {
    document.getElementById('update_team_id').value = team.id;
    document.getElementById('update_team_name').value = team.name;
    document.getElementById('update_team_rating').value = team.rating;
    document.getElementById('update_team_flag_url').value = team.flag_url;

    showModal('updateTeamModal');
}


function updateTeam() {
    const formData = new FormData(document.getElementById('updateTeamForm'));

    
    formData.append('id', document.getElementById('update_team_id').value);

    fetch('api/update_team.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Success!', 'Team updated successfully!', 'success')
                .then(() => {
                    hideModal('updateTeamModal');
                    loadTeams();
                });
        } else {
            Swal.fire('Error!', 'Failed to update team: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred while trying to update the team.', 'error');
    });
}

function deleteTeam(teamId) {
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
            fetch('api/delete_team.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + teamId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', 'Team deleted successfully!', 'success')
                        .then(() => {
                            loadTeams();
                        });
                } else {
                    Swal.fire('Error!', 'Failed to delete team: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while trying to delete the team.', 'error');
            });
        }
    });
}

function loadNationalities() {
    fetch('api/get_nationalities.php')
        .then(response => response.json())
        .then(nationalities => {
            const nationalitiesContainer = document.getElementById('nationalities-container');
            nationalitiesContainer.innerHTML = ''; 

            nationalities.forEach(nationality => {
                let card = document.createElement('div');
                card.className = 'stats-card rounded-xl shadow-lg overflow-hidden transition-all hover:translate-y-[-5px]';
                card.innerHTML = `
                  <div class="gradient-blue p-6 flex flex-col items-center">
                    ${nationality.flag_url 
                      ? `<div class="relative w-24 h-24 mb-4">
                           <img src="${nationality.flag_url}" 
                                alt="${nationality.name} Flag" 
                                class="w-full h-full object-contain drop-shadow-[0_0_8px_rgba(255,255,255,0.5)] filter brightness-110"
                           >
                         </div>` 
                      : `<div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mb-4 shadow-[0_0_15px_rgba(255,255,255,0.2)]">
                           <span class="text-4xl text-white font-bold">${nationality.name.charAt(0)}</span>
                         </div>`
                    }
                    <h2 class="text-xl font-bold text-white mb-2">${nationality.name}</h2>
                    <div class="flex items-center space-x-2 mb-4">
                      <span class="text-sm font-medium text-white/80">Code</span>
                      <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white rounded-full font-semibold">${nationality.code}</span>
                    </div>
                    <div class="flex space-x-3 w-full">
                      <button onclick='openUpdateNationalityModal(${JSON.stringify(nationality)})' 
                              class="flex-1 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-indigo-700 bg-white rounded-lg hover:bg-indigo-50 transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Update
                      </button>
                      <button onclick='deleteNationality(${nationality.id})' 
                              class="flex-1 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-500/80 backdrop-blur-sm rounded-lg hover:bg-red-600 transition-colors">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Delete
                      </button>
                    </div>
                  </div>
                `;
                nationalitiesContainer.appendChild(card);
            });
        })
        .catch(error => console.error('Error loading nationalities:', error));
}

function addNationality() {
    const formData = new FormData(document.getElementById('addNationalityForm'));
    fetch('api/add_nationality.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Success!', 'Nationality added successfully!', 'success')
                .then(() => {
                    hideModal('addNationalityModal');
                    loadNationalities();
                });
        } else {
            Swal.fire('Error!', 'Failed to add nationality: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred while trying to add the nationality.', 'error');
    });
}


function openUpdateNationalityModal(nationality) {
    document.getElementById('update_nationality_id').value = nationality.id;
    document.getElementById('update_nationality_name').value = nationality.name;
    document.getElementById('update_nationality_code').value = nationality.code;
    document.getElementById('update_nationality_flag_url').value = nationality.flag_url;

    showModal('updateNationalityModal');
}


function updateNationality() {
    const formData = new FormData(document.getElementById('updateNationalityForm'));

    
    formData.append('id', document.getElementById('update_nationality_id').value);

    fetch('api/update_nationality.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Success!', 'Nationality updated successfully!', 'success')
                .then(() => {
                    hideModal('updateNationalityModal');
                    loadNationalities();
                });
        } else {
            Swal.fire('Error!', 'Failed to update nationality: ' + (data.message || 'Unknown error'), 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred while trying to update the nationality.', 'error');
    });
}


function deleteNationality(nationalityId) {
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
            fetch('api/delete_nationality.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + nationalityId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', 'Nationality deleted successfully!', 'success')
                        .then(() => {
                            loadNationalities();
                        });
                } else {
                    Swal.fire('Error!', 'Failed to delete nationality: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred while trying to delete the nationality.', 'error');
            });
        }
    });
}