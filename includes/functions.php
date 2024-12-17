<?php

function getTotalPlayers($conn) {
    $query = "SELECT COUNT(*) as total FROM players";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}


function getTotalTeams($conn) {
    $query = "SELECT COUNT(*) as total FROM teams";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}


function getNationalityDistribution($conn) {
    $query = "SELECT n.name, COUNT(p.id) as count
              FROM nationalities n
              LEFT JOIN players p ON n.id = p.nationality_id
              GROUP BY n.id, n.name";
    $result = mysqli_query($conn, $query);
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}


function getTeamPerformance($conn) {
    $query = "SELECT name, rating FROM teams ORDER BY rating DESC";
    $result = mysqli_query($conn, $query);
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function getPlayersWithDetails($conn) {
    $query = "SELECT p.*, n.name as nationality_name, t.name as team_name 
              FROM players p 
              JOIN nationalities n ON p.nationality_id = n.id 
              JOIN teams t ON p.team_id = t.id";
    $result = mysqli_query($conn, $query);
    $players = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $players;
}

function getTeams($conn) {
    $query = "SELECT id, name FROM teams";
    $result = mysqli_query($conn, $query);
    $teams = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $teams;
}

function getNationalities($conn) {
    $query = "SELECT id, name FROM nationalities";
    $result = mysqli_query($conn, $query);
    $nationalities = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $nationalities;
}


function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, strip_tags(trim($input)));
}
?>
