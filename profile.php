<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch logged-in user's info
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, profile_photo FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email, $profile_photo);
$stmt->fetch();
$stmt->close();

// Fallback if photo missing
if (!$profile_photo || !file_exists($profile_photo)) {
    $profile_photo = "uploads/default.jpg";
}

// Handle profile update
$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
        $errorMessage = "Invalid request. Please try again.";
    } else {
        $newName = trim($_POST['name']);
        $newEmail = trim($_POST['email']);

        // Email uniqueness check
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=? AND id<>?");
        $stmt->bind_param("si", $newEmail, $user_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errorMessage = "Email is already taken.";
        }
        $stmt->close();

        // Profile photo update
        if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $fileType = mime_content_type($_FILES['profile_photo']['tmp_name']);
            $fileSize = $_FILES['profile_photo']['size'];

            if (!in_array($fileType, $allowedTypes)) {
                $errorMessage = "Invalid file type. Only JPG/PNG allowed.";
            } elseif ($fileSize > 2*1024*1024) {
                $errorMessage = "File too large. Max 2MB.";
            } else {
                $uploadDir = "uploads/";
                $fileName = time() . "_" . basename($_FILES['profile_photo']['name']);
                $targetFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
                    $profile_photo = $targetFile;
                }
            }
        }

        if (!$errorMessage) {
            $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, profile_photo = ? WHERE id = ?");
            $stmt->bind_param("sssi", $newName, $newEmail, $profile_photo, $user_id);
            if ($stmt->execute()) {
                $successMessage = "Profile updated successfully!";
                $name = $newName;
                $email = $newEmail;
            } else {
                $errorMessage = "Failed to update profile.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
body {margin:0; padding:0; height:100vh; background:linear-gradient(135deg,#eff3f7ff,#eff3f7ff); font-family:'Poppins',sans-serif; display:flex; justify-content:center; align-items:center;}
.card {border-radius:15px; background:rgba(255,255,255,0.95); box-shadow:0 8px 30px rgba(0,0,0,0.2); padding:30px; width:360px; animation:fadeIn 0.6s ease-in-out; border:0;}
@keyframes fadeIn {from {opacity:0; transform:translateY(-12px);} to {opacity:1; transform:translateY(0);}}
h3 {font-weight:700; color:#222; margin-bottom:16px; text-align:center;}
.profile-img {position:relative; width:100px; height:100px; margin:auto;}
.profile-img img {width:100px; height:100px; border-radius:50%; object-fit:cover;}
.profile-img label {position:absolute; bottom:0; right:0; background:#424344ff; width:28px; height:28px; border-radius:50%; display:flex; justify-content:center; align-items:center; cursor:pointer; color:white; font-size:16px; transition:transform 0.2s ease, filter 0.2s ease;}
.profile-img label:hover {transform:scale(1.1);}
.form-control {border-radius:12px; padding:10px 12px; margin-bottom:15px;}
label {font-weight:600; color:#333; margin-bottom:6px;}
.btn-custom {background:linear-gradient(90deg,#424344ff,#424344ff); color:#fff; border-radius:25px; padding:10px 20px; border:none; font-weight:600; width:100%; transition:transform .2s ease, filter .2s ease;}
.btn-custom:hover {transform:scale(1.05);}
.alert {padding:10px; font-size:14px; border-radius:10px;}
.muted {color:#666; font-size:14px;}
a {text-decoration:none;}
a:hover {text-decoration:underline;}
</style>
</head>
<body>

<div class="card">
    <h3>Profile</h3>

    <?php if($successMessage): ?>
        <div class="alert alert-success text-center" id="successAlert"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>
    <?php if($errorMessage): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($errorMessage) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <div class="profile-img mb-3">
            <img src="<?= htmlspecialchars($profile_photo) ?>" alt="<?= htmlspecialchars($name) ?>" id="profilePreview">
            <label for="profile_photo">&#128247;</label>
            <input type="file" id="profile_photo" name="profile_photo" style="display:none;" accept="image/png,image/jpeg">
        </div>

        <label>Full Name</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>

        <label>Email Address</label>
        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>

        <button type="submit" class="btn btn-custom">Update</button>
    </form>
</div>

<script>
document.querySelector('.profile-img label').addEventListener('click', function() {
    document.getElementById('profile_photo').click();
});
document.getElementById('profile_photo').addEventListener('change', function(e){
    const [file] = e.target.files;
    if(file){ document.getElementById('profilePreview').src = URL.createObjectURL(file); }
});

// Auto-hide alerts and redirect after 3 seconds
setTimeout(() => {
    const alert = document.getElementById('successAlert');
    if(alert) {
        alert.remove();
        window.location.href = "registration.php"; // redirect after showing message
    }
}, 3000);
</script>

</body>
</html>
