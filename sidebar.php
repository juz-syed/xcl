<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        display: flex;
        height: 100vh;
    }
    /* Sidebar */
    .sidebar {
        width: 250px;
        background-color: #ffffff;
        border-right: 1px solid #ddd;
        transition: width 0.3s;
        overflow-x: hidden;
        position: fixed;
        height: 100%;
    }
    .sidebar.collapsed {
        width: 60px;
    }
    .sidebar h2 {
        font-size: 18px;
        padding: 15px;
        margin: 0;
        background: #fff;
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
        color: #333;
        display: flex;
        align-items: center;
    }
    .sidebar ul li:hover {
        background-color: #f0f0f0;
    }
    .sidebar ul li i {
        margin-right: 10px;
    }
    /* Topbar */
    .topbar {
        height: 60px;
        background-color: #98c1b1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 20px;
        position: fixed;
        left: 250px;
        right: 0;
        transition: left 0.3s;
    }
    .collapsed + .topbar {
        left: 60px;
    }
    .topbar input {
        padding: 5px;
        border: none;
        border-radius: 4px;
        width: 200px;
    }
    /* Main content */
    .content {
        margin-top: 60px;
        padding: 20px;
        margin-left: 250px;
        flex: 1;
        transition: margin-left 0.3s;
    }
    .collapsed + .topbar + .content {
        margin-left: 60px;
    }
    /* Toggle button */
    .toggle-btn {
        cursor: pointer;
        font-size: 20px;
    }
</style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <h2>Xtreme League</h2>
    <ul>
        <li onclick="location.href='player_reg.php'">Players Registration</li>
        <li onclick="location.href='staff_reg.php'">Staff Registration</li>
        <li onclick="location.href='Official_reg.php'">Official Staff Registration</li>
    </ul>
</div>

<div class="topbar" id="topbar">
    <span class="toggle-btn" onclick="toggleSidebar()">&#9776;</span>
    <div style="flex:1; display:flex; justify-content:center;">
        <input type="text" placeholder="Search...">
    </div>
    <div>
        <span>Super Admin</span>
        <img src="user.jpg" alt="user" style="width:30px; height:30px; border-radius:50%; margin-left:10px;">
    </div>
</div>