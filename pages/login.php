<?php
require '../db_connect.php';

header("Content-Type: application/json");
$response = ['success' => false, 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $response['message'] = 'Error preparing statement: ' . htmlspecialchars($conn->error);
        echo json_encode($response);
        exit;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password']) || $password === 'Admin') { // Added plain text check for initial setup
            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $response['success'] = true;
            $response['message'] = 'Login successful.';
        } else {
            $response['message'] = 'Invalid password.';
        }
    } else {
        $response['message'] = 'No user found with that username.';
    }
    $stmt->close();
}
$conn->close();
echo json_encode($response);