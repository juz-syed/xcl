<?php
require 'db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = "";
$success = "";

// Create CSRF token if not exists
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // CSRF token check
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
        $error = "Something went wrong. Please try again.";
    } else {
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        // Validate inputs
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
            $error = "Invalid email or password.";
        } else {
            // Query user
            $stmt = $conn->prepare("SELECT id, full_name, profile_photo, password FROM users WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($id, $full_name, $profile_photo, $hashed_password);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    session_regenerate_id(true); // secure session
                    $_SESSION['user_id'] = $id;
                    $_SESSION['full_name'] = $full_name;
                    $_SESSION['profile_photo'] = $profile_photo ?: "default.jpg"; // fallback

                    // Show success message on the same page
                    $success = "Login successful! ";
                    echo "<script>
                        setTimeout(function(){
                            window.location.href = 'registration.php';
                        }, 3000);
                    </script>";
                } else {
                    $error = "Invalid email or password.";
                }
            } else {
                $error = "Invalid email or password.";
            }
            $stmt->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<style>
    body {
        margin: 0;
        padding: 0;
        height: 100vh;
        background: linear-gradient(135deg, #eff3f7ff, #eff3f7ff);
        font-family: 'Poppins', sans-serif;
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
        background: linear-gradient(90deg, #424344ff, #424344ff);
        color: #fff;
        border-radius: 25px;
        padding: 10px 20px;
        border: none;
        font-weight: 600;
        transition: transform .2s ease, filter .2s ease;
    }
    .btn-custom:hover {
        background: linear-gradient(90deg,  #424344ff, #424344ff);
        transform: scale(1.05);
    }
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
    <h2>Login</h2>

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

    <form method="POST" autocomplete="on" novalidate>
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['csrf'], ENT_QUOTES, 'UTF-8'); ?>">

        <div class="mb-3">
            <label for="email">Email ID</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                placeholder="you@gmail.com"
                autocomplete="username"
                required
            >
        </div>

        <div class="mb-3">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                placeholder="Enter your password"
                autocomplete="current-password"
                required
            >
        </div>

        <button type="submit" class="btn btn-custom w-100 mb-3">Login</button>
        <div class="text-center muted">
            <a href="signup.php">Sign up</a> · <a href="forgot.php">Forgot password?</a>
        </div>
    </form>
</div>

</body>
</html>
