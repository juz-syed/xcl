<?php
// Optional: protect page if only logged-in users should access
// session_start();
// if (!isset($_SESSION['logged_in'])) {
//     header("Location: login.php");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registration Selection</title>
<style>
    /* Reset margins & padding */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    /* Full page background image */
    body {
        background: url('img/slide/3.jpg') no-repeat center center fixed;
        background-size: cover;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
    }

    /* Container for content */
    .container {
        background: rgba(0, 0, 0, 0.4); /* Transparent overlay */
        padding: 40px;
        border-radius: 15px;
        backdrop-filter: blur(5px); /* Glass effect */
    }

    /* Title styling */
    h1 {
        margin-bottom: 30px;
        font-size: 28px;
        font-weight: bold;
    }

    /* Transparent buttons */
    .btn {
        display: block;
        width: 250px;
        padding: 15px;
        margin: 10px auto;
        background: rgba(255, 255, 255, 0.1);
        border: 2px solid white;
        border-radius: 8px;
        color: white;
        font-size: 16px;
        text-decoration: none;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: 0.3s;
    }

    /* Hover effect */
    .btn:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.05);
    }
</style>
</head>
<body>

<div class="container">
    <h1>Choose Registration Type</h1>
    <a href="player_reg.php" class="btn">Player Registration</a>
    <a href="staff_reg.php" class="btn">Staff Registration</a>
    <a href="official_reg.php" class="btn">Official Staff Registration</a>
</div>

</body>
</html>