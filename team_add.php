<?php
require 'db.php'; 
session_start();

// SHOW MESSAGE (flash)
function flashMessage() {
    if (!empty($_SESSION['msg'])) {
        echo '<div style="margin:15px 0;" class="alert alert-' . $_SESSION['msg_type'] . '">' . $_SESSION['msg'] . '</div>';
        unset($_SESSION['msg']);
        unset($_SESSION['msg_type']);
    }
}

$team_name = $group_name = $stadium = $profile_link = $logo = $photo = "";
$edit_id = null;

// ------------------- EDIT MODE -------------------
if (isset($_GET['edit'])) {
    $edit_id = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM teams WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $team = $result->fetch_assoc();
        $team_name   = $team['team_name'];
        $group_name  = $team['group_name'];
        $stadium     = $team['stadium'];
        $profile_link= $team['profile_link'];
        $logo        = $team['logo'];
        $photo       = $team['photo'];
    }
    $stmt->close();
}

// ------------------- ADD / UPDATE -------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $team_name   = $_POST['team_name'];
    $group_name  = $_POST['group_name'];
    $stadium     = $_POST['stadium'];
    $profile_link= $_POST['profile_link'];

    // Upload directories
    $logoDir  = "uploads/logos/";
    $photoDir = "uploads/photos/";
    if (!file_exists($logoDir)) mkdir($logoDir, 0777, true);
    if (!file_exists($photoDir)) mkdir($photoDir, 0777, true);

    $logoFile = "";
    $photoFile = "";

    // Handle logo upload
    if (!empty($_FILES["logo"]["name"])) {
        $logoFile = basename($_FILES["logo"]["name"]);
        move_uploaded_file($_FILES["logo"]["tmp_name"], $logoDir . $logoFile);
    }

    // Handle photo upload
    if (!empty($_FILES["photo"]["name"])) {
        $photoFile = basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $photoDir . $photoFile);
    }

    // ADD
    if (isset($_POST['add_team'])) {
        $sql = "INSERT INTO teams (team_name, group_name, stadium, logo, photo, profile_link)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $team_name, $group_name, $stadium, $logoFile, $photoFile, $profile_link);
        if ($stmt->execute()) {
            $_SESSION['msg'] = "✅ Team added successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "❌ Error: " . $stmt->error;
            $_SESSION['msg_type'] = "danger";
        }
        $stmt->close();
    }

    // UPDATE
    if (isset($_POST['update_team']) && isset($_POST['id'])) {
        $id = (int)$_POST['id'];

        // If no new upload, keep old
        if (empty($logoFile)) {
            $stmt = $conn->prepare("SELECT logo FROM teams WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $logoFile = $row['logo'];
            $stmt->close();
        }
        if (empty($photoFile)) {
            $stmt = $conn->prepare("SELECT photo FROM teams WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $photoFile = $row['photo'];
            $stmt->close();
        }

        $stmt = $conn->prepare("UPDATE teams SET team_name=?, group_name=?, stadium=?, logo=?, photo=?, profile_link=? WHERE id=?");
        $stmt->bind_param("ssssssi", $team_name, $group_name, $stadium, $logoFile, $photoFile, $profile_link, $id);
        if ($stmt->execute()) {
            $_SESSION['msg'] = "✅ Team updated successfully!";
            $_SESSION['msg_type'] = "success";
        } else {
            $_SESSION['msg'] = "❌ Error updating team.";
            $_SESSION['msg_type'] = "danger";
        }
        $stmt->close();
    }

    header("Location: team_add.php");
    exit;
}

// ------------------- DELETE -------------------
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM teams WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['msg'] = "✅ Team deleted successfully!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['msg'] = "❌ Error deleting team.";
        $_SESSION['msg_type'] = "danger";
    }
    $stmt->close();
    header("Location: team_add.php");
    exit;
}

// ------------------- FETCH ALL -------------------
$teams = $conn->query("SELECT * FROM teams ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Teams</title>
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
        <div class="col-md-8"><h1>Manage Teams</h1></div>
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
          <h4 class="panel-title"><?= $edit_id ? 'Edit Team' : 'Add New Team' ?></h4>
        </div>
        <div class="panel-body" style="padding: 20px; background: #fff;">
         <form method="POST" enctype="multipart/form-data">
            <?php if ($edit_id): ?>
              <input type="hidden" name="id" value="<?= $edit_id ?>">
            <?php endif; ?>
            <div class="row">
              <div class="col-md-6">
                <label>Team Name</label>
                <input type="text" class="form-control" name="team_name" required value="<?= htmlspecialchars($team_name) ?>">
              </div>
              <div class="col-md-6">
                <label>Group Name</label>
                <input type="text" class="form-control" name="group_name" required value="<?= htmlspecialchars($group_name) ?>">
              </div>
              <div class="col-md-6">
                <label>Stadium</label>
                <input type="text" class="form-control" name="stadium" value="<?= htmlspecialchars($stadium) ?>">
              </div>
              <div class="col-md-6">
                <label>Profile Link</label>
                <input type="text" class="form-control" name="profile_link" value="<?= htmlspecialchars($profile_link) ?>">
              </div>
              <div class="col-md-6">
                <label>Team Logo</label>
                <input type="file" class="form-control" name="logo">
              </div>
              <div class="col-md-6">
                <label>Team Photo</label>
                <input type="file" class="form-control" name="photo">
              </div>
              <div class="col-md-12 text-right" style="margin-top: 15px;">
                <button type="submit" name="<?= $edit_id ? 'update_team' : 'add_team' ?>" class="btn btn-primary">
                  <?= $edit_id ? 'Update Team' : 'Add Team' ?>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Table -->
      <div class="panel panel-default" style="margin-top: 30px;">
        <div class="panel-heading" style="background-color: #909593ff; color: white; padding: 15px;">
          <h4 class="panel-title">Team List</h4>
        </div>
        <div class="panel-body" style="padding: 20px; background: #fff;">
          <div class="table-responsive">
            <table id="teamsTable" class="table table-bordered table-striped">
              <thead style="background-color: #f0f0f0;">
                <tr>
                  <th>#</th>
                  <th>Team Name</th>
                  <th>Group</th>
                  <th>Stadium</th>
                  <th>Logo</th>
                  <th>Photo</th>
                  <th>Profile Link</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php $serial = 1; while($row = $teams->fetch_assoc()): ?>
                  <tr>
                    <td><?= $serial++ ?></td>
                    <td><?= htmlspecialchars($row['team_name']) ?></td>
                    <td><?= htmlspecialchars($row['group_name']) ?></td>
                    <td><?= htmlspecialchars($row['stadium']) ?></td>
                    <td>
                      <?php if ($row['logo']): ?>
                        <img src="uploads/logos/<?= htmlspecialchars($row['logo']) ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                      <?php else: ?>
                        <span>No Logo</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($row['photo']): ?>
                        <img src="uploads/photos/<?= htmlspecialchars($row['photo']) ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                      <?php else: ?>
                        <span>No Photo</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($row['profile_link']): ?>
                        <a href="<?= htmlspecialchars($row['profile_link']) ?>" target="_blank">View Profile</a>
                      <?php else: ?>
                        <span>-</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="team_add.php?edit=<?= $row['id'] ?>" class="btn btn-xs btn-info" title="Edit"><i class="fa fa-edit"></i></a>
                      <a href="team_add.php?delete=<?= $row['id'] ?>" class="btn btn-xs btn-danger" title="Delete" onclick="return confirm('Delete this team?');"><i class="fa fa-trash"></i></a>
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
    $('#teamsTable').DataTable({
      responsive: true,
      autoWidth: false,
      pageLength: 5,
      lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });
  });
</script>

</body>
</html>
