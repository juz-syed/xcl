<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// This must be set at login: 'player', 'staff', or 'official'
$user_type = $_SESSION['registration_type'] ?? '';
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
    color: #000;
    transition: background-color 0.2s;
}
.sidebar ul li:hover:not(.disabled):not(.active) {
    background-color: #f0f0f0;
}
.sidebar ul li.disabled {
    color: #aaa;
    cursor: not-allowed;
    pointer-events: none;
}
.sidebar ul li.active {
    background-color: #92989eff; /* blue highlight */
    color: white;
    font-weight: bold;
    border-left: 5px solid #848d8dff;
}
</style>

<div class="sidebar" id="sidebar">
    <h2>Xtreme League</h2>
    <ul>
        <li class="<?php echo ($user_type === 'player') ? 'active' : 'disabled'; ?>"
            <?php if ($user_type === 'player') echo "onclick=\"location.href='player_reg.php'\""; ?>>
            Players Registration
        </li>
        
        <li class="<?php echo ($user_type === 'staff') ? 'active' : 'disabled'; ?>"
            <?php if ($user_type === 'staff') echo "onclick=\"location.href='staff_reg.php'\""; ?>>
            Staff Registration
        </li>
        
        <li class="<?php echo ($user_type === 'official') ? 'active' : 'disabled'; ?>"
            <?php if ($user_type === 'official') echo "onclick=\"location.href='official_reg.php'\""; ?>>
            Official Staff Registration
        </li>
        
        <li onclick="location.href='change_password.php'">Change Password</li>
        <li onclick="location.href='profile.php'">Profile</li>
        <li onclick="location.href='logout_form.php'">Logout</li>
    </ul>
</div>
