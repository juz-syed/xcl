<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit;
}

$error = '';
$success = '';

// CSRF token
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
        $error = "Something went wrong. Please try again.";
    } else {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if ($current_password === '' || $new_password === '' || $confirm_password === '') {
            $error = "All fields are required.";
        } elseif ($new_password !== $confirm_password) {
            $error = "New password and confirmation do not match.";
        } else {
            $stmt = $conn->prepare("SELECT password FROM users WHERE id = ? LIMIT 1");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $stmt->bind_result($hashed_password);
            if ($stmt->fetch() && password_verify($current_password, $hashed_password)) {
                $stmt->close();

                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->bind_param("si", $new_hashed_password, $_SESSION['user_id']);
                if ($stmt->execute()) {
                    $success = "Password changed successfully.";
                } else {
                    $error = "Error updating password.";
                }
                $stmt->close();
            } else {
                $error = "Current password is incorrect.";
                $stmt->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Change Password</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .card {
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.95);
        box-shadow: 0 8px 30px rgba(0,0,0,0.2);
        padding: 30px;
        width: 360px;
        animation: fadeIn 0.6s ease-in-out;
        border: 0;
    }
    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(-12px);}
        to   {opacity: 1; transform: translateY(0);}
    }
    h2 {
        font-weight: 700;
        color: #222;
        margin-bottom: 16px;
        text-align: center;
    }
    .btn-custom {
        background: linear-gradient(90deg, #4facfe, #00f2fe);
        color: #fff;
        border-radius: 25px;
        padding: 10px 20px;
        border: none;
        font-weight: 600;
        transition: transform .2s ease, filter .2s ease;
    }
    .btn-custom:hover { transform: translateY(-1px); filter: brightness(1.04); }
    label { font-weight: 600; color: #333; margin-bottom: 6px; }
    .form-control { border-radius: 12px; padding: 10px 12px; }
    .alert { padding: 10px; font-size: 14px; border-radius: 10px; }
    .muted { color: #666; font-size: 14px; }
    a { text-decoration: none; }
    a:hover { text-decoration: underline; }
</style>
</head>
<body>

<div class="card">
    <h2>Change Password</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <form method="POST" autocomplete="off" novalidate>
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['csrf'], ENT_QUOTES, 'UTF-8'); ?>">

        <div class="mb-3">
            <label for="current_password">Current Password</label>
            <input
                type="password"
                id="current_password"
                name="current_password"
                class="form-control"
                placeholder="Enter current password"
                required
            >
        </div>

        <div class="mb-3">
            <label for="new_password">New Password</label>
            <input
                type="password"
                id="new_password"
                name="new_password"
                class="form-control"
                placeholder="Enter new password"
                required
            >
        </div>

        <div class="mb-3">
            <label for="confirm_password">Confirm New Password</label>
            <input
                type="password"
                id="confirm_password"
                name="confirm_password"
                class="form-control"
                placeholder="Confirm new password"
                required
            >
        </div>

        <button type="submit" class="btn btn-custom w-100 mb-3">Change Password</button>
        <div class="text-center muted">
            <a href="login_form.php">Back </a>
        </div>
    </form>
</div>

</body>
</html>
