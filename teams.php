<?php
// connect DB
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic -->
    <meta charset="utf-8">
    <title>Teams - Xtreme League</title>
    <meta name="keywords" content="Teams" />
    <meta name="description" content="Xtreme League Teams">
    <meta name="author" content="Your Name">

    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/responsive.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    
</head>
<body>

<!-- ===== HEADER ===== -->
<?php include 'header.php'; ?>

<!-- ===== NAVBAR ===== -->
<?php include 'navbar.php'; ?>

<!-- ===== PAGE HEADER ===== -->
<section class="section-title" style="background:url('img/slide/2.png') center center no-repeat; background-size:cover;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-left"><div>
                <h1>Teams List</h1>
                
                    <li><a href="index.php">Home</a></li>
                    <li ><a href= "team_lists.php">Teams</li>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== TEAMS LIST ===== -->
<section class="teams padding-top">
    <div class="container">

        <div class="row portfolioContainer">
            <?php
            // fetch teams
            $sql = "SELECT * FROM teams ORDER BY group_name, team_name";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
            ?>
                <!-- Item Team -->
                <div class="col-md-6 col-lg-4 col-xl-3 group-<?php echo strtolower($row['group_name']); ?>">
                    <div class="item-team">
                        <div class="head-team">
                            <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="team-photo">
                            <div class="overlay">
                                <a href="<?php echo htmlspecialchars($row['profile_link']); ?>">+</a>
                            </div>
                        </div>
                        <div class="info-team">
                            <span class="logo-team">
                                <img src="<?php echo htmlspecialchars($row['logo']); ?>" alt="team-logo">
                            </span>
                            <h4><?php echo htmlspecialchars($row['team_name']); ?></h4>
                            <span class="location-team">
                                <i class="fa fa-map-marker"></i>
                                <?php echo htmlspecialchars($row['stadium']); ?>
                            </span>
                            <span class="group-team">
                                <i class="fa fa-trophy"></i>
                                <?php echo htmlspecialchars($row['group_name']); ?>
                            </span>
                        </div>
                        <a href="<?php echo htmlspecialchars($row['profile_link']); ?>" class="btn">
                            Team Profile <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- End Item Team -->
            <?php
                endwhile;
            else:
                echo '<p class="text-center">No teams available.</p>';
            endif;
            ?>
        </div>

    </div>
</section>

<!-- ===== FOOTER ===== -->
<?php include 'footer.php'; ?>

<!-- ===== JS ===== -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/theme-scripts.js"></script>
<script src="assets/js/theme-main.js"></script>
</body>
</html>
