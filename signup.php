<?php
require 'db.php';
session_start();

// Create CSRF token if not exists
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$successMessage = "";
$errorMessage   = "";
$name = $email = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $csrf     = $_POST['csrf_token'] ?? '';

    // CSRF check
    if (!hash_equals($_SESSION['csrf_token'], $csrf)) {
        $errorMessage = "Security check failed. Please try again.";
    }
    elseif (empty($name) || empty($email) || empty($password)) {
        $errorMessage = "All fields are required!";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format!";
    }
    elseif (strlen($password) < 6) {
        $errorMessage = "Password must be at least 6 characters!";
    }
    elseif (!isset($_FILES['profile_photo']) || $_FILES['profile_photo']['error'] !== UPLOAD_ERR_OK) {
        $errorMessage = "Please upload a profile photo!";
    }
    else {
        // Handle image upload
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($_FILES['profile_photo']['type'], $allowedTypes)) {
            $errorMessage = "Only JPG and PNG images are allowed!";
        } else {
            $uploadDir = "uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileName = time() . "_" . basename($_FILES['profile_photo']['name']);
            $targetFile = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
                // Hash password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Insert into database with photo path
                $stmt = $conn->prepare("INSERT INTO users (name, email, password, profile_photo) VALUES (?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $targetFile);
                    if ($stmt->execute()) {
                        $successMessage = "Signup successful! Redirecting to login...";
                        $name = $email = ""; // reset fields
                    } else {
                        $errorMessage = "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $errorMessage = "Database error: " . $conn->error;
                }
            } else {
                $errorMessage = "Error uploading profile photo!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            height: 100vh;
            background: url('background.jpg') no-repeat center center/cover;
            position: relative;
            font-family: 'Poppins', sans-serif;
        }
        body::after {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: #eff3f7ff, #eff3f7ff;
        }
        .card {
            position: relative;
            z-index: 1;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0px 8px 30px rgba(0,0,0,0.3);
            padding: 30px;
            width: 350px;
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }
        h2 {
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-custom {
            background: linear-gradient(90deg, #424344ff, #424344ff);
            color: white;
            border-radius: 25px;
            padding: 10px 20px;
            border: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background: linear-gradient(90deg,  #424344ff, #424344ff);
            transform: scale(1.05);
        }
        label { font-weight: 600; color: #333; }
        .alert { padding: 8px; font-size: 14px; opacity: 0; transform: translateY(-10px); transition: opacity 0.5s, transform 0.5s; }
        .alert.show { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
<div class="card">
    <h2>Sign Up</h2>

    <?php if ($successMessage): ?>
        <div class="alert alert-success text-center show"><?= htmlspecialchars($successMessage) ?></div>
        <script>
            setTimeout(() => window.location.href = 'login_form.php', 3000);
        </script>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger text-center show"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
        </div>

        <div class="mb-3">
            <label>Profile Photo</label>
            <input type="file" name="profile_photo" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-custom w-100 mb-3">Sign Up</button>
        <div class="text-center">
            <a href="login_form.php">Already have an account? Login</a>
        </div>
    </form>
</div>
<script>
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => alert.classList.remove('show'));
}, 5000);
</script>
</body>
</html>
