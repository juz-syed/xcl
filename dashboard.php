<?php require ('sidebar.php'); ?>

<div class="content" id="content">
    <h1>Good Morning, Super Admin</h1>
    <p>Welcome to sabana dashboard!</p>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
    document.getElementById('topbar').classList.toggle('collapsed');
    document.getElementById('content').classList.toggle('collapsed');
}
</script>
</body>
</html>
