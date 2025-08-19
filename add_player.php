<?php
session_start();
require 'db.php';

$name = $position = $nationality = $matches = $age = $jersey_number = $team = $image = "";
$edit_id = null;

// SHOW MESSAGE (flash)
function flashMessage() {
    if (!empty($_SESSION['msg'])) {
        echo '<div style="margin:15px 0;" class="alert alert-' . $_SESSION['msg_type'] . '">' . $_SESSION['msg'] . '</div>';
        unset($_SESSION['msg']);
        unset($_SESSION['msg_type']);
    }
}

// EDIT MODE – Prefill form values
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $edit_query = $conn->prepare("SELECT * FROM players WHERE id = ?");
    $edit_query->bind_param("i", $edit_id);
    $edit_query->execute();
    $result = $edit_query->get_result();
    if ($result->num_rows > 0) {
        $player = $result->fetch_assoc();
        $name = $player['name'];
        $position = $player['position'];
        $nationality = $player['nationality'];
        $matches = $player['matches'];
        $age = $player['age'];
        $jersey_number = $player['jersey_number'];
        $team = $player['team'];
        $image = $player['image'];
    }
    $edit_query->close();
}

// ADD or UPDATE
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $upload_dir = "img/players/";
    $image_name = "";

    // Handle file upload
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $target_file = $upload_dir . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }

    if (isset($_POST['add_player'])) {
        $stmt = $conn->prepare("INSERT INTO players (name, position, nationality, matches, age, jersey_number, team, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sssiiiss",
            $_POST['name'],
            $_POST['position'],
            $_POST['nationality'],
            $_POST['matches'],
            $_POST['age'],
            $_POST['jersey_number'],
            $_POST['team'],
            $image_name
        );
        if ($stmt->execute()) {
            $_SESSION['msg'] = "✅ Player added successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "❌ Error adding player.";
            $_SESSION['msg_type'] = "danger";
        }
        $stmt->close();
    }

    if (isset($_POST['update_player']) && isset($_POST['id'])) {
        // If no new image, retain old one
        if (empty($image_name)) {
            $stmt = $conn->prepare("SELECT image FROM players WHERE id = ?");
            $stmt->bind_param("i", $_POST['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $image_name = $row['image'];
            }
            $stmt->close();
        }

        $stmt = $conn->prepare("UPDATE players SET name=?, position=?, nationality=?, matches=?, age=?, jersey_number=?, team=?, image=? WHERE id=?");
        $stmt->bind_param(
            "sssiiissi",
            $_POST['name'],
            $_POST['position'],
            $_POST['nationality'],
            $_POST['matches'],
            $_POST['age'],
            $_POST['jersey_number'],
            $_POST['team'],
            $image_name,
            $_POST['id']
        );
        if ($stmt->execute()) {
            $_SESSION['msg'] = "✅ Player updated successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "❌ Error updating player.";
            $_SESSION['msg_type'] = "danger";
        }
        $stmt->close();
    }

    header("Location: add_player.php");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM players WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['msg'] = "✅ Player deleted successfully!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['msg'] = "❌ Error deleting player.";
        $_SESSION['msg_type'] = "danger";
    }
    $stmt->close();
    header("Location: add_player.php");
    exit;
}

// FETCH ALL
$players = $conn->query("SELECT * FROM players");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Player - Player Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="assets/css/main.css" rel="stylesheet" media="screen">
  <link rel="shortcut icon" href="img/icons/favicon.ico">
  <!-- Bootstrap + DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

<?php require('header.php'); require('navbar.php'); ?>

<div id="layout">
  <div class="section-title" style="background:url(img/slide/group.jpeg)">
    <div class="container">
      <div class="row">
        <div class="col-md-8"><h1>Manage Players</h1></div>
        <div class="col-md-4">
          <div class="breadcrumbs">
            <ul><li><a href="index.php">Home</a></li><li>Dashboard</li></ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content-info">
    <div class="container padding-top">

      <!-- Flash Messages -->
      <?php flashMessage(); ?>

      <!-- Form -->
      <div class="panel panel-default">
        <div class="panel-heading" style="background-color: #909593ff; color: white; padding: 15px;">
          <h4 class="panel-title"><?= $edit_id ? 'Edit Player' : 'Add New Player' ?></h4>
        </div>
        <div class="panel-body" style="padding: 20px; background: #fff;">
         <form method="POST" enctype="multipart/form-data">
            <?php if ($edit_id): ?>
              <input type="hidden" name="id" value="<?= $edit_id ?>">
            <?php endif; ?>
            <div class="row">
              <div class="col-md-4">
                <label>Player Name</label>
                <input type="text" class="form-control" name="name" required value="<?= htmlspecialchars($name) ?>">
              </div>
              <div class="col-md-4">
                <label>Position</label>
                <select name="position" class="form-control" required>
                  <option value="">-- Select Position --</option>
                  <option value="Forward" <?= $position === 'Forward' ? 'selected' : '' ?>>Forward</option>
                  <option value="Defender" <?= $position === 'Defender' ? 'selected' : '' ?>>Defender</option>
                  <option value="Midfielder" <?= $position === 'Midfielder' ? 'selected' : '' ?>>Midfielder</option>
                  <option value="Goalkeeper" <?= $position === 'Goalkeeper' ? 'selected' : '' ?>>Goalkeeper</option>
                </select>
              </div>
              <div class="col-md-4">
                <label>Nationality</label>
                <input type="text" class="form-control" name="nationality" required value="<?= htmlspecialchars($nationality) ?>">
              </div>
              <div class="col-md-2">
                <label>Matches</label>
                <input type="number" class="form-control" name="matches" required value="<?= htmlspecialchars($matches) ?>">
              </div>
              <div class="col-md-2">
                <label>Age</label>
                <input type="number" class="form-control" name="age" required value="<?= htmlspecialchars($age) ?>">
              </div>
              <div class="col-md-2">
                <label>Jersey No</label>
                <input type="number" class="form-control" name="jersey_number" required value="<?= htmlspecialchars($jersey_number) ?>">
              </div>
              <div class="col-md-3">
                <label>Team</label>
                <select name="team" class="form-control" required>
                    <option value="">-- Select Team --</option>
                    <?php
                    $teams_result = $conn->query("SELECT team_name FROM Teams ORDER BY team_name ASC");
                    while ($team_row = $teams_result->fetch_assoc()):
                        $selected = ($team_row['team_name'] === $team) ? 'selected' : '';
                    ?>
                        <option value="<?= htmlspecialchars($team_row['team_name']) ?>" <?= $selected ?>>
                            <?= htmlspecialchars($team_row['team_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
              </div>
              <div class="col-md-3">
                <label>Player Image</label>
                <input type="file" class="form-control" name="image">
                
              </div>
              <div class="col-md-12 text-right" style="margin-top: 15px;">
                <button type="submit" name="<?= $edit_id ? 'update_player' : 'add_player' ?>" class="btn btn-primary">
                  <?= $edit_id ? 'Update Player' : 'Add Player' ?>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Table -->
      <div class="panel panel-default" style="margin-top: 30px;">
        <div class="panel-heading" style="background-color: #909593ff; color: white; padding: 15px;">
          <h4 class="panel-title">Player List</h4>
        </div>
        <div class="panel-body" style="padding: 20px; background: #fff;">
          <div class="table-responsive">
            <table id="playersTable" class="table table-bordered table-striped">
              <thead style="background-color: #f0f0f0;">
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Nationality</th>
                  <th>Matches</th>
                  <th>Age</th>
                  <th>Jersey</th>
                  <th>Team</th>
                  <th>Image</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $serial = 1; while($row = $players->fetch_assoc()): ?>
                  <tr>
                    <td><?= $serial++ ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['position']) ?></td>
                    <td><?= htmlspecialchars($row['nationality']) ?></td>
                    <td><?= $row['matches'] ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['jersey_number'] ?></td>
                    <td><?= htmlspecialchars($row['team']) ?></td>
                    <td>
                      <?php if ($row['image']): ?>
                        <img src="img/players/<?= htmlspecialchars($row['image']) ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                      <?php else: ?>
                        <span>No Image</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="add_player.php?edit=<?= $row['id'] ?>" class="btn btn-xs btn-info" title="Edit"><i class="fa fa-edit"></i></a>
                      <a href="add_player.php?delete=<?= $row['id'] ?>" class="btn btn-xs btn-danger" title="Delete" onclick="return confirm('Delete this player?');"><i class="fa fa-trash"></i></a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
  </section>

<?php require('footer.php'); ?>
</div>

<script src="assets/js/jquery.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#playersTable').DataTable({
      responsive: true,
      autoWidth: false,
      pageLength: 5,
      lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });
  });
</script>

</body>
</html>
