<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

$login_error = "";
$login_success = "";

// ✅ Include the shared DB connection file
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT password FROM super_admin WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
      $_SESSION['super_admin_logged_in'] = true;
      $login_success = "You have logged in successfully!";
      echo "<script>
        setTimeout(function() {
          window.location.href = 'index.php';
        }, 1000);
      </script>";
    } else {
      $login_error = "Invalid password.";
    }
  } else {
    $login_error = "No admin found with that email.";
  }

  $stmt->close();
  $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Super Admin Login - Xtreme Cricket League</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="shortcut icon" href="favicon.ico">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@7.2.96/css/materialdesignicons.min.css" rel="stylesheet" />
  <link href= "assets/css/auth.css" rel="stylesheet" />
</head>
<body>

<?php if (!empty($login_success)) : ?>
  <div id="loginSuccessAlert" 
       style="position:fixed;top:30px;right:30px;min-width:260px;z-index:1050;"
       class="alert alert-success d-flex align-items-center shadow fade show" 
       role="alert">
    <i class="mdi mdi-check-circle" style="font-size:1.8rem;color:#21ba45;margin-right:12px;"></i>
    <div><strong><?= htmlspecialchars($login_success) ?></strong></div>
  </div>
<?php endif; ?>

<div class="card card-login">
  <div class="card-header-silva d-flex justify-content-center  align-items-center px-3 py-2">
    <div class="brand-title text-white fw-bold fs-4 mb-0">Xtreme Cricket League</div>
  </div>

  <div class="login-body-silva">
    <?php if (!empty($login_error)) : ?>
      <div class="alert alert-danger text-center py-2 mb-3"><?= htmlspecialchars($login_error) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label for="emailaddress" class="form-label">Email address</label>
        <input type="email" class="form-control silva-input" id="emailaddress" name="email" required placeholder="Enter your email">
      </div>

      <div class="mb-3 position-relative">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control silva-input" id="password" name="password" required placeholder="Enter your password">
        <span id="togglePassword" style="position:absolute;top:70%;right:15px;transform:translateY(-50%);cursor:pointer;">
          <i id="eyeOpen" class="mdi mdi-eye eye-icon" style="display: none;"></i>
          <i id="eyeClosed" class="mdi mdi-eye-off eye-icon"></i>
        </span>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="rememberMe" checked>
          <label class="form-check-label" for="rememberMe">Remember me</label>
        </div>
        <a href="#" class="text-green fw-semibold text-decoration-none">Forgot password?</a>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-green">
          Login <i class="mdi mdi-arrow-right ms-2"></i>
        </button>
      </div>
    </form>
  </div>
</div>

<div class="footer-note">&copy; <?= date("Y") ?> Xtreme Cricket League</div>

<!-- JS for password toggle -->
<script>
  const password   = document.getElementById('password');
  const toggle     = document.getElementById('togglePassword');
  const eyeOpen    = document.getElementById('eyeOpen');
  const eyeClosed  = document.getElementById('eyeClosed');

  toggle.onclick = () => {
    const show = password.type === 'password';
    password.type = show ? 'text' : 'password';
    eyeOpen.style.display   = show ? '' : 'none';
    eyeClosed.style.display = show ? 'none' : '';
  };
</script>

</body>
</html>