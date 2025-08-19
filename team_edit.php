<?php
require 'db.php'; // database connection

// Check if id is passed
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("❌ Invalid team ID.");
}
$id = intval($_GET['id']);

// Fetch team data
$sql = "SELECT * FROM teams WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$team = $result->fetch_assoc();

if (!$team) {
    die("❌ Team not found.");
}

// Update team if form submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team_name   = $_POST['team_name'];
    $group_name  = $_POST['group_name'];
    $stadium     = $_POST['stadium'];
    $profile_link= $_POST['profile_link'];

    // Keep old files
    $logoFile  = $team['logo'];
    $photoFile = $team['photo'];

    // Upload directories
    $logoDir  = "uploads/logos/";
    $photoDir = "uploads/photos/";
    if (!file_exists($logoDir)) mkdir($logoDir, 0777, true);
    if (!file_exists($photoDir)) mkdir($photoDir, 0777, true);

    // Update logo if new uploaded
    if (!empty($_FILES["logo"]["name"])) {
        $logoFile = $logoDir . basename($_FILES["logo"]["name"]);
        move_uploaded_file($_FILES["logo"]["tmp_name"], $logoFile);
    }

    // Update photo if new uploaded
    if (!empty($_FILES["photo"]["name"])) {
        $photoFile = $photoDir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photoFile);
    }

    // Update DB
    $sql = "UPDATE teams SET team_name=?, group_name=?, stadium=?, logo=?, photo=?, profile_link=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $team_name, $group_name, $stadium, $logoFile, $photoFile, $profile_link, $id);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>✅ Team updated successfully!</p>";
        // Refresh team data after update
        $team['team_name']   = $team_name;
        $team['group_name']  = $group_name;
        $team['stadium']     = $stadium;
        $team['logo']        = $logoFile;
        $team['photo']       = $photoFile;
        $team['profile_link']= $profile_link;
    } else {
        echo "<p style='color:red;'>❌ Error: " . $stmt->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Team</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; color: #333; }
        label { font-weight: bold; }
        input[type="text"], input[type="file"] {
            width: 100%; padding: 8px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px;
        }
        img { margin: 10px 0; border-radius: 5px; }
        button {
            background: #ffc107; color: black; border: none; padding: 10px 20px;
            border-radius: 4px; cursor: pointer; font-size: 16px;
        }
        button:hover { background: #e0a800; }
        .btn-secondary {
            display: inline-block; margin-top: 10px; text-decoration: none;
            background: #007bff; color: white; padding: 8px 15px; border-radius: 4px;
        }
        .btn-secondary:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Team</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>Team Name:</label>
            <input type="text" name="team_name" value="<?php echo htmlspecialchars($team['team_name']); ?>" required>

            <label>Group Name:</label>
            <input type="text" name="group_name" value="<?php echo htmlspecialchars($team['group_name']); ?>" required>

            <label>Stadium:</label>
            <input type="text" name="stadium" value="<?php echo htmlspecialchars($team['stadium']); ?>">

            <label>Profile Link:</label>
            <input type="text" name="profile_link" value="<?php echo htmlspecialchars($team['profile_link']); ?>">

            <label>Current Logo:</label><br>
            <img src="<?php echo $team['logo']; ?>" width="80"><br>
            <input type="file" name="logo">

            <label>Current Photo:</label><br>
            <img src="<?php echo $team['photo']; ?>" width="120"><br>
            <input type="file" name="photo">

            <button type="submit">Update Team</button>
        </form>

        <a href="team_lists.php" class="btn-secondary">📋 Back to Team List</a>
    </div>
</body>
</html>
