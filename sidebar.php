<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
.sidebar {
    width: 250px;
    background-color: #ffffff;
    border-right: 1px solid #ddd;
    position: fixed;
    height: 100%;
    transition: width 0.3s;
}
.sidebar.collapsed {
    width: 60px;
}
.sidebar h2 {
    text-align: center;
    padding: 15px;
    margin: 0;
    border-bottom: 1px solid #ddd;
}
.sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sidebar ul li {
    padding: 12px 20px;
    cursor: pointer;
}
.sidebar ul li:hover {
    background-color: #f0f0f0;
}
</style>

<div class="sidebar" id="sidebar">
    <h2>Xtreme League</h2>
    <ul>
        <li onclick="location.href='player_reg.php'">Players Registration</li>
        <li onclick="location.href='staff_reg.php'">Staff Registration</li>
        <li onclick="location.href='official_reg.php'">Official Staff Registration</li>
        <li onclick="location.href='change_password.php'">Change Password</li>
        <li onclick="location.href='profile.php'">Profile</li>
        <li onclick="location.href='logout_form.php'">Logout</li>
    </ul>
</div>
