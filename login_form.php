<?php
require 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = '';
$success = '';

// Save registration type from registration.php (normalize to allowed values)
if (!empty($_GET['type'])) {
    $type = strtolower(trim($_GET['type']));
    if (in_array($type, ['player','staff','official'], true)) {
        $_SESSION['reg_type'] = $type; // chosen type from selection screen
    } else {
        unset($_SESSION['reg_type']);
    }
}

// CSRF token
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // CSRF check
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
        $error = "Something went wrong. Please try again.";
    } else {
        $email = strtolower(trim($_POST['email'] ?? ''));
        $password = $_POST['password'] ?? '';

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $error = "Invalid email or password.";
        } else {
            $stmt = $conn->prepare("SELECT id, full_name, profile_photo, password, reg_type 
                                    FROM users WHERE email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($id, $full_name, $profile_photo, $hashed_password, $existing_type);
                $stmt->fetch();

                if (password_verify($password, $hashed_password)) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $id;
                    $_SESSION['full_name'] = $full_name;
                    $_SESSION['profile_photo'] = $profile_photo ?: "default.jpg";

                    $chosen_type   = $_SESSION['reg_type'] ?? '';
                    $existing_type = $existing_type ? strtolower($existing_type) : '';

                    // If the user already has a reg_type and it conflicts with the chosen one, block
                    if ($existing_type && $chosen_type && $existing_type !== $chosen_type) {
                        // still set sidebar type so UI reflects their actual registered type
                        $_SESSION['registration_type'] = $existing_type;
                        $error = "You are already registered as {$existing_type}. You cannot register as another type.";
                    } else {
                        // If no reg_type in DB but user selected one, save it
                        if (!$existing_type && $chosen_type) {
                            $update = $conn->prepare("UPDATE users SET reg_type=? WHERE id=?");
                            $update->bind_param("si", $chosen_type, $id);
                            $update->execute();
                            $existing_type = $chosen_type;
                        }

                        // Set the session value the sidebar uses
                        $_SESSION['registration_type'] = $existing_type ?: '';

                        $success = "Login successful! Redirecting...";

                        // Decide redirect target
                        $redirectPage = 'registration.php';
                        if ($existing_type) {
                            if ($existing_type === 'player')   $redirectPage = 'player_reg.php';
                            if ($existing_type === 'staff')    $redirectPage = 'staff_reg.php';
                            if ($existing_type === 'official') $redirectPage = 'official_reg.php';
                        }

                        echo "<script>
                            setTimeout(function(){
                                window.location.href = '{$redirectPage}';
                            }, 2000);
                        </script>";
                    }
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
        min-height: 100vh;
        background: linear-gradient(135deg, #eff3f7, #eff3f7);
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
        border: none;
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
        background: #424344;
        color: #fff;
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: 600;
        transition: transform .2s ease;
    }
    .btn-custom:hover {
            background: linear-gradient(90deg,  #424344ff, #424344ff);
            transform: scale(1.05);
        }
    label { font-weight: 600; color: #333; margin-bottom: 6px; }
    .form-control { border-radius: 12px; padding: 10px 12px; }
    .alert { padding: 10px; font-size: 14px; border-radius: 10px; }
    .muted { color: #666; font-size: 14px; }
    .login-header {
    display: flex;
    align-items: center;
    justify-content: center; /* centers it horizontally */
    gap: 10px; /* space between icon & text */
    margin-bottom: 20px; /* space below header */
}

.login-icon {
    width: 40px;   /* adjust size */
    height: 40px;
}
.login-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: bold;
}

</style>
</head>
<body>

<div class="card">
    <h2>Login   </h2>



    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" id="msg-box">
            <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success" id="msg-box">
            <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <form method="POST" autocomplete="on" novalidate>
        <input type="hidden" name="csrf" value="<?php echo htmlspecialchars($_SESSION['csrf'], ENT_QUOTES, 'UTF-8'); ?>">

        <div class="mb-3">
            <label for="email">Email ID</label>
            <input type="email" id="email" name="email" class="form-control"
                   placeholder="you@gmail.com" autocomplete="username" required>
        </div>

      <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <div class="input-group">
        <input type="password" class="form-control" id="password" name="password" 
               placeholder="Enter your password" required>
        <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
            <!-- eye open -->
            <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-eye">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
            <!-- eye closed -->
            <svg id="eyeClosed" style="display:none;" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-eye-off">
                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.12 21.12 0 0 1 5.06-5.94"></path>
                <path d="M1 1l22 22"></path>
                <path d="M9.88 9.88A3 3 0 0 0 12 15c1.66 0 3-1.34 3-3 0-.52-.13-1-.35-1.42"></path>
            </svg>
        </span>
    </div>
</div>



        <button type="submit" class="btn btn-custom w-100 mb-3">Login</button>
        <div class="text-center muted">
            <a href="signup.php">Sign up</a> · <a href="forgot.php">Forgot password?</a>
        </div>
    </form>
</div>

<script>
    // Auto-hide alert after 5 seconds
    setTimeout(() => {
        const msgBox = document.getElementById('msg-box');
        if (msgBox) msgBox.style.display = 'none';
    }, 5000);
</script>
<script>
   const togglePassword = document.getElementById('togglePassword');
const passwordInput = document.getElementById('password');
const eyeOpen = document.getElementById('eyeOpen');
const eyeClosed = document.getElementById('eyeClosed');

togglePassword.addEventListener('click', () => {
    const type = passwordInput.type === 'password' ? 'text' : 'password';
    passwordInput.type = type;

    if (type === 'text') {
        eyeOpen.style.display = 'none';
        eyeClosed.style.display = 'block';
    } else {
        eyeOpen.style.display = 'block';
        eyeClosed.style.display = 'none';
    }
});
</script>



</body>
</html>
