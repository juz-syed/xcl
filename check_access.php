<?php
session_start();
require 'db.php';

// Page must pass the required type
if (!isset($required_type)) {
    die("Access control error: required_type not set.");
}

// If not logged in, send them to the correct login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php?type={$required_type}");
    exit;
}

// Fetch user's registered type
$stmt = $conn->prepare("SELECT reg_type FROM users WHERE id=?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($reg_type);
$stmt->fetch();
$stmt->close();

// If type mismatch, deny access
if ($reg_type !== $required_type) {
    echo "<h2 style='color:red; text-align:center; margin-top:50px;'>
            Access Denied - You are registered as: " . htmlspecialchars($reg_type) . "
          </h2>";
    exit;
}
?>
