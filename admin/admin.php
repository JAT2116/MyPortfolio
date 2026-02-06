<?php
require '../db_connect.php';

$error_message = '';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: ../pages/login.html");
    exit;
}

// Handle Project Deletion
if (isset($_GET['delete'])) {
    $id_to_delete = $_GET['delete'];

    // First, get the image path to delete the file
    $stmt = $conn->prepare("SELECT image_path, document_path FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 1){
        $row = $result->fetch_assoc();
        $image_file_to_delete = '../' . $row['image_path'];
        if(file_exists($image_file_to_delete)){
            unlink($image_file_to_delete); // Delete the image file
        }
        if (!empty($row['document_path']) && file_exists('../' . $row['document_path'])) {
            unlink('../' . $row['document_path']); // Delete the document file
        }
    }
    $stmt->close();

    // Then, delete the record from the database
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id_to_delete);
    $stmt->execute();
    $stmt->close();
    header("Location: admin.php"); // Redirect to avoid re-deletion on refresh
    exit;
}

// Handle Project Addition
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_project'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $project_link = $_POST['project_link'];
    $document_path = null;

    // File upload handling
    $target_dir = "../uploads/";
    // Add a unique prefix to avoid filename conflicts
    $target_file = $target_dir . uniqid() . '-' . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Handle document upload if category is thesis
    if ($category === 'thesis' && isset($_FILES['document_file']) && $_FILES['document_file']['error'] == 0) {
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
            } else {
                $error_message = "Sorry, there was an error uploading your document file.";
            }
        } else {
            $error_message = "Wrong Document Format: Please input PDF, DOC or DOCX format";
        }
    }

    // Check allowed file extensions
    if (empty($error_message)) {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if(in_array($imageFileType, $allowed_extensions)) {
            // Check if uploads directory exists, if not, create it.
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            if (!is_writable($target_dir)) {
                $error_message = "Error: The 'uploads' directory is not writable. Please check the folder permissions.";
            } else {

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) { // If file upload is successful
                    $image_path = "uploads/" . basename($target_file);
                    $stmt = $conn->prepare("INSERT INTO projects (title, description, category, project_link, document_path, image_path) VALUES (?, ?, ?, ?, ?, ?)");
                    if ($stmt === false) {
                        $error_message = "Failed to add project! Database Error: " . $conn->error;
                    } else {
                        $stmt->bind_param("ssssss", $title, $description, $category, $project_link, $document_path, $image_path);
                        $stmt->execute();
                        $stmt->close();
                        header("Location: admin.php"); // Redirect only on full success
                        exit;
                    }
                } else {
                    $error_message = "Sorry, there was an error uploading your file. The server could not move the file.";
                }
            }
        } else {
            $error_message = "Wrong Picture Format: Please input PNG, JPG, JPEG or GIF format";
        }
    }
}

// Handle Site Info Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_info'])) {
    $info_to_update = [
        'home_intro' => $_POST['home_intro'],
        'about_me' => $_POST['about_me'],
        'email' => $_POST['email'],
        'facebook' => $_POST['facebook'],
        'service_web_desc' => $_POST['service_web_desc'],
        'service_student_desc' => $_POST['service_student_desc'],
        'service_dev_desc' => $_POST['service_dev_desc'],
        'service_fullstack_desc' => $_POST['service_fullstack_desc']
    ];

    $stmt = $conn->prepare("INSERT INTO site_info (info_key, info_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE info_value = VALUES(info_value)");
    if ($stmt === false) {
        die("Error preparing statement: " . htmlspecialchars($conn->error));
    }

    foreach ($info_to_update as $key => $value) {
        $stmt->bind_param("ss", $key, $value);
        $stmt->execute();
    }

    $stmt->close();

    header("Location: admin.php");
    exit;
}

$projects_result = $conn->query("SELECT * FROM projects ORDER BY id DESC");
$info_result = $conn->query("SELECT * FROM site_info");
$site_info = [];
if ($info_result) {
    while($row = $info_result->fetch_assoc()){
        $site_info[$row['info_key']] = $row['info_value'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin JEHIEL</title>
    <link rel="icon" type="image/png" sizes="48×48" href="../admin/logo.png">
    <link rel="stylesheet" href="../style.css?v=<?php echo time(); ?>">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="admin-page">

    <header>
        <div class="logo">Admin<span>HIEL</span></div>
        <div class="bx bx-menu" id="menu-icon"></div>
        <ul class="navlist">
            <li><a href="../pages/index.php" target="_blank">View Site</a></li>
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
            <span>Admin Panel</span>
            <h2>Manage Your Content</h2>
        </div>

        <h3 style="font-size: var(--normal-font); text-align: center; margin-bottom: 2rem;">Add New Project</h3>
        <form action="admin.php" method="post" enctype="multipart/form-data" style="margin-bottom: 3rem;">
                <input type="text" name="title" placeholder="Project Title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>" required>
                <textarea name="description" placeholder="Project Description" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                <label for="category" style="display: block; text-align: left; margin-bottom: .8rem;">Category:</label>
                <select name="category" id="category" required>
                    <option value="" disabled selected>-- Select a Category --</option>
                    <option value="web" <?php echo (isset($_POST['category']) && $_POST['category'] == 'web') ? 'selected' : ''; ?>>Web App</option>
                    <option value="thesis" <?php echo (isset($_POST['category']) && $_POST['category'] == 'thesis') ? 'selected' : ''; ?>>Thesis</option>
                    <option value="python" <?php echo (isset($_POST['category']) && $_POST['category'] == 'python') ? 'selected' : ''; ?>>Python</option>
                    <option value="cpp_cs" <?php echo (isset($_POST['category']) && $_POST['category'] == 'cpp_cs') ? 'selected' : ''; ?>>C++/C#</option>
                    <option value="vbnet" <?php echo (isset($_POST['category']) && $_POST['category'] == 'vbnet') ? 'selected' : ''; ?>>VB.Net</option>
                </select>
                <div id="document_input_container" style="display: none;">
                    <label for="document_file" style="display: block; text-align: left; margin-bottom: .8rem;">Thesis Document (PDF, DOC, DOCX):</label>
                    <input type="file" name="document_file" id="document_file_input" accept=".pdf, .doc, .docx">
                </div>
                <input type="text" name="project_link" placeholder="Project Link (URL)" value="<?php echo isset($_POST['project_link']) ? htmlspecialchars($_POST['project_link']) : ''; ?>">
                <label for="image" style="display: block; text-align: left; margin-bottom: .8rem;">Project Image:</label>
                <input type="file" name="image" id="image" required accept=".jpg, .jpeg, .png, .gif">
                <div class="btn-box formBtn">
                    <button type="submit" name="add_project" class="btn">Add Project</button>
                </div>
            </form>

        <hr style="margin: 40px 0; border-color: var(--hover-color);">

        <h3 style="font-size: var(--normal-font); text-align: center; margin-top: 2rem; margin-bottom: 2rem;">Manage Site Information</h3>
        <form action="admin.php" method="post" style="margin-bottom: 3rem;">
                <label for="home_intro" style="display: block; text-align: left; margin-bottom: .8rem;">Home Introduction:</label>
                <textarea name="home_intro" placeholder="Home introduction text..." required><?php echo htmlspecialchars($site_info['home_intro'] ?? ''); ?></textarea>

                <label for="about_me" style="display: block; text-align: left; margin-bottom: .8rem;">About Me Section:</label>
                <textarea name="about_me" placeholder="About me text..." required><?php echo htmlspecialchars($site_info['about_me'] ?? ''); ?></textarea>
                
                <label for="email" style="display: block; text-align: left; margin-bottom: .8rem;">Email Address:</label>
                <input type="email" name="email" placeholder="Your Email" value="<?php echo htmlspecialchars($site_info['email'] ?? ''); ?>" required>
                
                <label for="facebook" style="display: block; text-align: left; margin-bottom: .8rem;">Facebook Name:</label>
                <input type="text" name="facebook" placeholder="Your Facebook" value="<?php echo htmlspecialchars($site_info['facebook'] ?? ''); ?>" required>

                <h4 style="margin-top: 1.5rem; margin-bottom: 1rem; text-align: left;">Services Section</h4>
                <label for="service_web_desc" style="display: block; text-align: left; margin-bottom: .8rem;">Web Designer Description:</label>
                <textarea name="service_web_desc" placeholder="Description for Web Designer" required><?php echo htmlspecialchars($site_info['service_web_desc'] ?? ''); ?></textarea>

                <label for="service_student_desc" style="display: block; text-align: left; margin-bottom: .8rem;">Student Description:</label>
                <textarea name="service_student_desc" placeholder="Description for Student" required><?php echo htmlspecialchars($site_info['service_student_desc'] ?? ''); ?></textarea>

                <label for="service_dev_desc" style="display: block; text-align: left; margin-bottom: .8rem;">Software Developer Description:</label>
                <textarea name="service_dev_desc" placeholder="Description for Software Developer" required><?php echo htmlspecialchars($site_info['service_dev_desc'] ?? ''); ?></textarea>

                <label for="service_fullstack_desc" style="display: block; text-align: left; margin-bottom: .8rem;">Frontend & Backend Developer Description:</label>
                <textarea name="service_fullstack_desc" placeholder="Description for Fullstack Developer" required><?php echo htmlspecialchars($site_info['service_fullstack_desc'] ?? ''); ?></textarea>

                <div class="btn-box formBtn">
                    <button type="submit" name="update_info" class="btn">Update Info</button>
                </div>
            </form>

        <hr style="margin: 40px 0; border-color: var(--hover-color);">

        <h3 style="font-size: var(--normal-font); text-align: center; margin-top: 2rem; margin-bottom: 2rem;">Existing Projects</h3>
        <div class="section-services">
            <?php if ($projects_result): ?>
                <?php while($project = $projects_result->fetch_assoc()): ?>
                    <div class="service-box" style="border: 2px solid var(--hover-color); box-shadow: var(--neon-box-shadow);">
                        <?php
                            $file_path = $project['image_path'];
                            $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
                            $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                            $is_image = in_array($file_extension, $image_extensions);

                            if ($is_image) {
                        ?>
                            <img src="../<?php echo htmlspecialchars($project['image_path']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" width="100" style="margin-bottom: 1rem; border-radius: 5px;">
                        <?php
                            } else {
                        ?>
                            <div style="padding: 1rem 0; text-align: center;">
                                <a href="../<?php echo htmlspecialchars($project['image_path']); ?>" target="_blank" download>
                                    <i class='bx bxs-file-doc' style="font-size: 4rem; color: var(--hover-color);"></i>
                                </a>
                            </div>
                        <?php
                            }
                        ?>
                        <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                        <p>Category: <?php echo htmlspecialchars($project['category']); ?></p>
                        <div class="btn-box service-btn" style="gap: 1rem;">
                            <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="btn">Edit</a>
                            <a href="admin.php?delete=<?php echo $project['id']; ?>" onclick="return confirm('Are you sure?')" class="btn" style="background-color: #c0392b;">Delete</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
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