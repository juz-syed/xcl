<?php
require 'db.php'; // database connection

// Show success/error messages using ?msg=
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';

// Fetch teams with row numbering
$sql = "SELECT ROW_NUMBER() OVER (ORDER BY id DESC) AS ordered_number, id, logo, team_name, group_name, stadium, photo 
        FROM teams 
        ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Team List</title>
    <style>
        body { font-family: Arial, sans-serif; background: #eef2f7; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #44474bff; color: white; }
        tr:hover { background: #f1f1f1; }
        img { border-radius: 5px; }
        a.edit-btn, a.delete-btn {
            text-decoration: none; padding: 5px 10px; border-radius: 4px; margin: 2px;
        }
        a.edit-btn { background: #c7c5c0ff ; color: black; }
        a.edit-btn:hover { background: #5c5a5aff; }
        a.delete-btn { background: #da9b76ff; color: white; }
        a.delete-btn:hover { background: #df6959ff; }
        .btn-secondary {
            display: inline-block; margin-top: 10px; text-decoration: none;
            background: #28a745; color: white; padding: 8px 15px; border-radius: 4px;
        }
        .btn-secondary:hover { background: #218838; }

        /* Message styles */
        .alert {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .alert-success { background: #d8e2dbff; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Team List</h2>

        <!-- Success/Error Messages -->
        <?php if ($msg == 'added') { ?>
            <div class="alert alert-success">✅ Team added successfully!</div>
        <?php } elseif ($msg == 'updated') { ?>
            <div class="alert alert-success">✏️ Team updated successfully!</div>
        <?php } elseif ($msg == 'deleted') { ?>
            <div class="alert alert-success">🗑️ Team deleted successfully!</div>
        <?php } elseif ($msg == 'error') { ?>
            <div class="alert alert-error">❌ Something went wrong. Please try again.</div>
        <?php } ?>

        <table>
            <tr>
                <th>Order</th>
                <th>Logo</th>
                <th>Team Name</th>
                <th>Group</th>
                <th>Stadium</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <!-- Continuous numbers instead of raw ID -->
                <td><?php echo $row['ordered_number']; ?></td>
                <td><img src="<?php echo $row['logo']; ?>" width="50"></td>
                <td><?php echo htmlspecialchars($row['team_name']); ?></td>
                <td><?php echo htmlspecialchars($row['group_name']); ?></td>
                <td><?php echo htmlspecialchars($row['stadium']); ?></td>
                <td><img src="<?php echo $row['photo']; ?>" width="80"></td>
                <td>
                    <a href="team_edit.php?id=<?php echo $row['id']; ?>" class="edit-btn">✏️ Edit</a>
                    <a href="team_delete.php?id=<?php echo $row['id']; ?>" 
                       class="delete-btn"
                       onclick="return confirm('⚠️ Are you sure you want to delete this team?');">🗑️ Delete</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="team_add.php" class="btn-secondary">➕ Add New Team</a>
    </div>
</body>
</html>
