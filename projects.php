<?php
require '../db_connect.php'; // Corrected path

header("Content-Type: application/json");

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    http_response_code(401); // Unauthorized
    echo json_encode(['success' => false, 'message' => 'Authentication required.']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST': // Add a new project
        handleAddProject($conn);
        break;
    case 'DELETE': // Delete a project
        handleDeleteProject($conn);
        break;
    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
        break;
}

function handleAddProject($conn) {
    // Simplified for brevity - in a real app, add robust validation
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $project_link = $_POST['project_link'];

    // File upload handling remains similar but should return JSON responses
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = "uploads/" . basename($_FILES["image"]["name"]); // Use relative path for client
        $stmt = $conn->prepare("INSERT INTO projects (title, description, category, project_link, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $description, $category, $project_link, $image_path);
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Project added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database insert failed.']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'File upload failed.']);
    }
}

function handleDeleteProject($conn) {
    if (!isset($_GET['id'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Project ID is required.']);
        return;
    }
    $id_to_delete = $_GET['id'];

    // Get image path to delete the file
    $stmt = $conn->prepare("SELECT image_path FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    $stmt->execute();
    $result = $stmt->get_result();
    if($row = $result->fetch_assoc()){
        if(file_exists('../../' . $row['image_path'])){
            unlink('../../' . $row['image_path']);
        }
    }
    $stmt->close();

    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    $stmt->execute();
    echo json_encode(['success' => true, 'message' => 'Project deleted.']);
    $stmt->close();
}

$conn->close();