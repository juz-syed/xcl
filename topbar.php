<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}

// Fetch logged-in user's info
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, profile_photo FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $profile_photo);
$stmt->fetch();
$stmt->close();

// Fallback if photo missing
if (!$profile_photo || !file_exists($profile_photo)) {
    $profile_photo = "uploads/default.jpg";
}
?>
<div class="topbar" style="display:flex; justify-content:flex-end; align-items:center; background-color:#8bb3a2; padding:10px 20px; color:white;">
    <div class="profile" style="display:flex; align-items:center;">
        <span style="font-weight:600; margin-right:8px;"><?= htmlspecialchars($name) ?></span>
        <img src="<?= htmlspecialchars($profile_photo) ?>" alt="Profile Photo" style="width:35px; height:35px; border-radius:50%; border:2px solid white; object-fit:cover;">
    </div>
</div>
