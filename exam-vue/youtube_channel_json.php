<?php

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE"); // Allow the specified HTTP methods
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Allow the specified headers


// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "youtube_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the first table
$query1 = "SELECT * FROM youtube_channels";
$result1 = $conn->query($query1);
$table1_data = array();
while ($row = $result1->fetch_assoc()) {
    $table1_data[] = $row;
}

// Fetch data from the second table
$query2 = "SELECT * FROM youtube_channel_videos";
$result2 = $conn->query($query2);
$table2_data = array();
while ($row = $result2->fetch_assoc()) {
    $table2_data[] = $row;
}

//Combined two table
$combined_data = array(
    "youtube_channels" => $table1_data,
    "youtube_channel_videos" => $table2_data
);

//encode JSON Data
$json_data = json_encode($combined_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);


echo $json_data;