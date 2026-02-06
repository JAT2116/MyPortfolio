<?php
require 'db_connect.php';

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    $info_result = $conn->query("SELECT info_key, info_value FROM site_info");
    $site_info = [];
    if ($info_result) {
        while($row = $info_result->fetch_assoc()){
            $site_info[$row['info_key']] = $row['info_value'];
        }
    }
    echo json_encode(['success' => true, 'data' => $site_info]);
}

if ($method == "POST") {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        http_response_code(401); // Unauthorized
        echo json_encode(['success' => false, 'message' => 'Authentication required.']);
        exit;
    }

    $info_to_update = [
        'about_me' => $_POST['about_me'],
        'email' => $_POST['email'],
        'facebook' => $_POST['facebook']
    ];

    $stmt = $conn->prepare("UPDATE site_info SET info_value = ? WHERE info_key = ?");

    foreach ($info_to_update as $key => $value) {
        $stmt->bind_param("ss", $value, $key);
        $stmt->execute();
    }

    $stmt->close();
    echo json_encode(['success' => true, 'message' => 'Site info updated successfully.']);
}

$conn->close();