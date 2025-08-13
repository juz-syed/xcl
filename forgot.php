<?php 
include 'db.php'; 
session_start();

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email       = trim($_POST['email']);
    $newPassword = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $error = "Email not found";
    } else {
        if ($newPassword !== $confirmPass) {
            $error = "Passwords do not match";
        } else {
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password=? WHERE email=?");
            $update->bind_param("ss", $hashed, $email);
            if ($update->execute()) {
                $success = "Password updated successfully. Redirecting to login...";
                header("refresh:3;url=login_form.php");
            } else {
                $error = "Error updating password: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        font-family: 'Poppins', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .card {
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
        background: linear-gradient(90deg, #4facfe, #00f2fe);
        color: white;
        border-radius: 25px;
        padding: 10px 20px;
        border: none;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    .btn-custom:hover {
        background: linear-gradient(90deg, #00c6ff, #4facfe);
        transform: scale(1.05);
    }
    label {
        font-weight: 600;
        color: #333;
    }
    .alert {
        padding: 8px;
        font-size: 14px;
    }
    .form-control {
        border-radius: 10px;
        padding: 10px;
    }
</style>
</head>
<body>
<div class="card">
    <h2>Forgot Password</h2>
    <?php 
        if(!empty($error)) echo "<div class='alert alert-danger text-center'>$error</div>"; 
        if(!empty($success)) echo "<div class='alert alert-success text-center'>$success</div>"; 
    ?>

    <form method="POST" autocomplete="off">
        <!-- Hidden dummy fields to help prevent autofill -->
        <input type="text" style="display:none">
        <input type="password" style="display:none">

        <div class="mb-3">
            <label for="email">Registered Email ID</label>
            <input type="email" id="email" name="email" class="form-control" 
                   placeholder="Enter your registered email" autocomplete="off" required>
        </div>

        <div class="mb-3">
            <label for="new_password">New Password</label>
            <input type="password" id="new_password" name="new_password" class="form-control" 
                   placeholder="Enter new password" autocomplete="off" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="form-control" 
                   placeholder="Re-enter new password" autocomplete="off" required>
        </div>

        <button type="submit" class="btn btn-custom w-100 mb-3">Update Password</button>
        <div class="text-center">
            <a href="login_form.php">Back to Login</a>
        </div>
    </form>
</div>
</body>
</html>
