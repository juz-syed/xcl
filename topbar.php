<!DOCTYPE html>
<html>
<head>
<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
    }
    /* Topbar styles */
    .topbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #8bb3a2;
        padding: 10px 20px;
    }
    .search-bar input {
        padding: 5px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    .profile {
        position: relative;
        display: flex;
        align-items: center;
        cursor: pointer;
    }
    .profile img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-left: 8px;
    }
    .dropdown {
        position: absolute;
        right: 0;
        top: 40px;
        background: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        display: none;
        flex-direction: column;
        min-width: 150px;
        box-shadow: 0px 2px 8px rgba(0,0,0,0.2);
    }
    .dropdown a {
        padding: 10px;
        text-decoration: none;
        color: black;
    }
    .dropdown a:hover {
        background-color: #f0f0f0;
    }
</style>
</head>
<body>

<!-- Topbar -->
<div class="topbar" id="topbar">
    <span class="toggle-btn" onclick="toggleSidebar()">&#9776;</span>
    
    <!-- Search Bar -->
    <div style="flex:1; display:flex; justify-content:center;">
        <input type="text" placeholder="Search...">
    </div>
    
    <!-- Profile Section -->
    <div>
        <span>Super Admin</span>
        <img src="user.jpg" alt="user" 
             style="width:30px; height:30px; border-radius:50%; margin-left:10px;">
    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
}
</script>


</body>
</html>
