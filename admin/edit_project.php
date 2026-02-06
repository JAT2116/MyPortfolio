<?php
require '../db_connect.php';

$error_message = '';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../pages/login.html");
    exit;
}

$project_id = $_GET['id'] ?? null;
if (!$project_id) {
    header("Location: admin.php");
    exit;
}

// Handle form submission for update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_project'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $project_link = $_POST['project_link'];
    $current_image_path = $_POST['current_image_path'];
    $current_document_path = $_POST['current_document_path'];
    $image_path = $current_image_path;
    $document_path = $current_document_path;

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        $new_target_file = $target_dir . uniqid() . '-' . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($new_target_file, PATHINFO_EXTENSION));
        
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if(in_array($imageFileType, $allowed_extensions)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $new_target_file)) {
                // New file uploaded successfully, update image_path and delete old image
                $image_path = "uploads/" . basename($new_target_file);
                
                if ($current_image_path && file_exists('../' . $current_image_path)) {
                    unlink('../' . $current_image_path);
                }
            } else {
                $error_message = "Sorry, there was an error uploading your new file.";
            }
        } else {
            $error_message = "Wrong Picture Format: Please input PNG, JPG, JPEG or GIF format";
        }
    }

    // Handle document upload if category is thesis
    if (empty($error_message) && $category === 'thesis' && isset($_FILES['document_file']) && $_FILES['document_file']['error'] == 0) {
        $doc_target_dir = "../uploads/documents/"; // Set path to documents folder
        if (!is_dir($doc_target_dir)) {
            mkdir($doc_target_dir, 0755, true);
        }
        $doc_target_file = $doc_target_dir . uniqid() . '-doc-' . basename($_FILES["document_file"]["name"]);
        $doc_file_type = strtolower(pathinfo($doc_target_file, PATHINFO_EXTENSION));
        $allowed_doc_extensions = ['pdf', 'doc', 'docx'];

        if (in_array($doc_file_type, $allowed_doc_extensions)) {
            if (move_uploaded_file($_FILES["document_file"]["tmp_name"], $doc_target_file)) {
                $document_path = "uploads/documents/" . basename($doc_target_file);
                if ($current_document_path && file_exists('../' . $current_document_path)) {
                    unlink('../' . $current_document_path);
                }
            } else {
                $error_message = "Sorry, there was an error uploading your new document file.";
            }
        } else {
            $error_message = "Wrong Document Format: Please input PDF, DOC or DOCX format";
        }
    }

    // Update the database
    if (empty($error_message)) {
        $stmt = $conn->prepare("UPDATE projects SET title = ?, description = ?, category = ?, project_link = ?, document_path = ?, image_path = ? WHERE id = ?");
        if ($stmt === false) {
            $error_message = "Failed to update project! Database Error: " . $conn->error;
        } else {
            $stmt->bind_param("ssssssi", $title, $description, $category, $project_link, $document_path, $image_path, $project_id);
            $stmt->execute();
            $stmt->close();
            header("Location: admin.php");
            exit;
        }
    }
}


// Fetch existing project data for the form
$stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();
$stmt->close();

if (!$project) {
    header("Location: admin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Project - Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="admin-page">

    <header>
        <div class="logo">Admin<span>Panel</span></div>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navlist">
            <li><a href="admin.php">Back to Dashboard</a></li>
            <li><a href="../pages/logout.php">Logout</a></li>
        </ul>
    </header>

    <?php if (!empty($error_message)): ?>
    <div class="error-overlay" id="errorOverlay">
        <div class="error-box">
            <h3>Error</h3>
            <p><?php echo htmlspecialchars($error_message); ?></p>
            <button onclick="document.getElementById('errorOverlay').style.display='none'">Close</button>
        </div>
    </div>
    <?php endif; ?>

    <section class="contact">
        <div class="main-text">
            <span>Edit Project</span>
            <h2>Update '<?php echo htmlspecialchars($project['title']); ?>'</h2>
        </div>

        <form action="edit_project.php?id=<?php echo $project['id']; ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="current_image_path" value="<?php echo htmlspecialchars($project['image_path']); ?>">
            <input type="hidden" name="current_document_path" value="<?php echo htmlspecialchars($project['document_path'] ?? ''); ?>">
            
            <label for="title" style="display: block; text-align: left; margin-bottom: .8rem;">Project Title:</label>
            <input type="text" id="title" name="title" placeholder="Project Title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
            
            <label for="description" style="display: block; text-align: left; margin-bottom: .8rem;">Project Description:</label>
            <textarea id="description" name="description" placeholder="Project Description" required><?php echo htmlspecialchars($project['description']); ?></textarea>
            
            <label for="category" style="display: block; text-align: left; margin-bottom: .8rem;">Category:</label>
            <select name="category" id="category" required>
                <option value="web" <?php if($project['category'] == 'web') echo 'selected'; ?>>Web App</option>
                <option value="thesis" <?php if($project['category'] == 'thesis') echo 'selected'; ?>>Thesis</option>
                <option value="python" <?php if($project['category'] == 'python') echo 'selected'; ?>>Python</option>
                <option value="cpp_cs" <?php if($project['category'] == 'cpp_cs') echo 'selected'; ?>>C++/C#</option>
                <option value="vbnet" <?php if($project['category'] == 'vbnet') echo 'selected'; ?>>VB.Net</option>
            </select>
            
            <label for="project_link" style="display: block; text-align: left; margin-bottom: .8rem;">Project Link (URL):</label>
            <input type="text" id="project_link" name="project_link" placeholder="Project Link (URL)" value="<?php echo htmlspecialchars($project['project_link']); ?>">
            
            <div id="document_input_container" style="display: <?php echo ($project['category'] === 'thesis') ? 'block' : 'none'; ?>;">
                <label style="display: block; text-align: left; margin-bottom: .8rem;">Current Thesis Document:</label>
                <?php if (!empty($project['document_path'])): ?>
                    <div style="padding: 1rem 0;">
                        <a href="../<?php echo htmlspecialchars($project['document_path']); ?>" target="_blank" download style="color: var(--hover-color); text-decoration: none; display:flex; align-items:center; gap: 10px;">
                            <i class='bx bxs-file-doc' style="font-size: 2rem;"></i>
                            <span><?php echo basename($project['document_path']); ?></span>
                        </a>
                    </div>
                <?php else: ?>
                    <p style="text-align: left; font-size: 0.9rem; color: #bdbdbd; margin-bottom: 1rem;">No document uploaded.</p>
                <?php endif; ?>
                <label for="document_file" style="display: block; text-align: left; margin-bottom: .8rem;">Upload New Thesis Document (optional):</label>
                <input type="file" name="document_file" id="document_file_input" accept=".pdf, .doc, .docx">
                <p style="text-align: left; font-size: 0.8rem; color: #bdbdbd; margin-top: -0.5rem; margin-bottom: 1rem;">Leave blank to keep the current document.</p>
            </div>

            <label style="display: block; text-align: left; margin-bottom: .8rem;">Current Project Image:</label>
            <?php
                $file_path = $project['image_path'];
                $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
                $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $is_image = in_array($file_extension, $image_extensions);

                if ($is_image) {
            ?>
                <img src="../<?php echo htmlspecialchars($project['image_path']); ?>" alt="Current project image" width="100" style="margin-bottom: 1rem; border-radius: 5px; border: 1px solid var(--hover-color);">
            <?php
                } else {
            ?>
                <div style="padding: 1rem 0;">
                    <a href="../<?php echo htmlspecialchars($project['image_path']); ?>" target="_blank" download style="color: var(--hover-color); text-decoration: none; display:flex; align-items:center; gap: 10px;">
                        <i class='bx bxs-file-doc' style="font-size: 2rem;"></i>
                        <span><?php echo basename($project['image_path']); ?></span>
                    </a>
                </div>
            <?php
                }
            ?>
            
            <label for="image" style="display: block; text-align: left; margin-bottom: .8rem;">Upload New Project Image (optional):</label>
            <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png, .gif">
            <p style="text-align: left; font-size: 0.8rem; color: #bdbdbd; margin-top: -0.5rem; margin-bottom: 1rem;">Leave blank to keep the current image.</p>

            <div class="btn-box formBtn">
                <button type="submit" name="update_project" class="btn">Update Project</button>
            </div>
        </form>
    </section>

    <script src="../script.js"></script>
    <script>
        document.getElementById('category').addEventListener('change', function() {
            const documentInputContainer = document.getElementById('document_input_container');
            if (this.value === 'thesis') {
                documentInputContainer.style.display = 'block';
            } else {
                documentInputContainer.style.display = 'none';
            }
        });
    </script>

</body>
</html>
<?php $conn->close(); ?>