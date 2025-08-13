<?php
require 'db.php';

$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        $errorMessage = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format!";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare insert
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $name, $email, $hashedPassword);
            if ($stmt->execute()) {
                $successMessage = "Signup successful! Redirecting to login...";
            } else {
                $errorMessage = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errorMessage = "Database error: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
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
    <script>
        function redirectAfterDelay(url, seconds) {
            setTimeout(function() {
                window.location.href = url;
            }, seconds * 1000);
        }
    </script>
</head>
<body>
    <div class="card">
        <h2>Sign Up</h2>

        <?php if ($successMessage): ?>
            <div class="alert alert-success text-center"><?= $successMessage ?></div>
            <script>redirectAfterDelay('login_form.php', 5);</script>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="alert alert-danger text-center"><?= $errorMessage ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
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
</body>
</html>
