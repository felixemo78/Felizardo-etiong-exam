<?php

//  API key
$apiKey = 'AIzaSyCjYNZzc130xvDW6G-tyc13UASZ7rmmHJg';

//  YouTube channel Id
$channelId = 'UCWJ2lWNubArHWmf3FIHbfcQ';


$channelUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet&id=$channelId&key=$apiKey";

// Youtube playlist videos Id
$playlistId = 'PLlVlyGVtvuVl1eQSXtuTzL-5C7pDGvk54';
$playlistId2 = 'PLlVlyGVtvuVmVUb-8E2ATbb7SunLoM2md';


$videosUrl = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=${playlistId}&key=${apiKey}";
$videosUrl2 = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId=${playlistId}&key=${apiKey}";


// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "youtube_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$channelInfo = file_get_contents($channelUrl);
$channelInfo = json_decode($channelInfo, true);

if (isset($channelInfo['items'][0])) {

    $channelTitle = $conn->real_escape_string($channelInfo['items'][0]['snippet']['title']);
    $channelDescription = $conn->real_escape_string($channelInfo['items'][0]['snippet']['description']);
    $channelThumbnail = $conn->real_escape_string($channelInfo['items'][0]['snippet']['thumbnails']['default']['url']);

    $sql = "INSERT INTO youtube_channels (_picture,_name, _description) VALUES ('$channelThumbnail','$channelTitle', '$channelDescription')";

    if ($conn->query($sql) === true) {
        echo "Channel information saved to the database.\n\n";
    } else {
        echo "Error saving channel information: " . $conn->error . "\n";
    }


    $videosResponse = file_get_contents($videosUrl);
    $videos = json_decode($videosResponse, true);

    $videosResponse2 = file_get_contents($videosUrl2);
    $videos2 = json_decode($videosResponse2, true);


    if (isset($videos['items'])) {

        foreach ($videos['items'] as $video) {
            $videoTitle = $conn->real_escape_string($video['snippet']['title']);
            $videoDescription = $conn->real_escape_string($video['snippet']['description']);
            $videoId = $conn->real_escape_string($video['snippet']['resourceId']['videoId']);
            $videoThumbnail = $conn->real_escape_string($video['snippet']['thumbnails']['default']['url']);

            $sql = "INSERT INTO youtube_channel_videos (id,_videoLink, _title, _description, _thumbnail) VALUES ('','$videoId', '$videoTitle', '$videoDescription', '$videoThumbnail')";


            if ($conn->query($sql) === true) {
                echo "Video information saved to the database.\n";

            } else {
                echo "Error saving video information: " . $conn->error . "\n";
            }
        }

        foreach ($videos2['items'] as $video) {
            $videoTitle = $conn->real_escape_string($video['snippet']['title']);
            $videoDescription = $conn->real_escape_string($video['snippet']['description']);
            $videoId = $conn->real_escape_string($video['snippet']['resourceId']['videoId']);
            $videoThumbnail = $conn->real_escape_string($video['snippet']['thumbnails']['default']['url']);

            $sql = "INSERT INTO youtube_channel_videos (id,_videoLink, _title, _description, _thumbnail) VALUES ('','$videoId', '$videoTitle', '$videoDescription', '$videoThumbnail')";
            if ($conn->query($sql) === true) {
                echo "Video information saved to the database.\n";

            } else {
                echo "Error saving video information: " . $conn->error . "\n";
            }
        }
    } else {
        echo "No videos found for this channel.\n";
    }


    if (isset($videos['items'])) {

        foreach ($videos['items'] as $video) {
            $videoTitle = $conn->real_escape_string($video['snippet']['title']);
            $videoDescription = $conn->real_escape_string($video['snippet']['description']);
            $videoId = $conn->real_escape_string($video['id']);
            $videoThumbnail = $conn->real_escape_string($video['snippet']['thumbnails']['default']['url']);

            $sql = "INSERT INTO youtube_channel_videos (id,_videoLink, _title, _description, _thumbnail) VALUES ('','$videoId', '$videoTitle', '$videoDescription', '$videoThumbnail')";

            if ($conn->query($sql) === true) {
                echo "Video information saved to the database.\n";

            } else {
                echo "Error saving video information: " . $conn->error . "\n";
            }
        }
    } else {
        echo "No videos found for this channel.\n";
    }
} else {
    echo "Channel not found.\n";
}

// Close the database connection
$conn->close();