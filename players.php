<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Basic -->
        <meta charset="utf-8">
        <title>SportsCup - Bootstrap 4 Theme for Sports</title>
        <meta name="keywords" content="HTML5 Template" />
        <meta name="description" content="SportsCup - Bootstrap 4 Theme for Sports">
        <meta name="author" content="iwthemes.com">

        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Theme CSS -->
        <link href="assets/css/main.css" rel="stylesheet" media="screen">

        <!-- Favicons -->
        <link rel="shortcut icon" href="img/icons/favicon.ico">
        <link rel="apple-touch-icon" href="img/icons/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="img/icons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="img/icons/apple-touch-icon-114x114.png">
    </head>

    <body>
      <?php require ('db.php'); 
      require ('header.php'); 
      require('navbar.php');
      ?>
        <!-- layout-->
        <div id="layout">

            <!-- End mainmenu-->
            <!-- End Mobile Nav-->

            <!-- Section Title -->
            <div class="section-title" style="background:url(img/slide/1.jpg)">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <h1>Players List</h1>
                        </div>

                        <div class="col-md-4">
                            <div class="breadcrumbs">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li>Inner Page</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Title -->

            <!-- Section Area - Content Central -->
            <section class="content-info">

                <!-- Nav Filters -->
                <div class="portfolioFilter">
                    <div class="container">
                        <h5><i class="fa fa-filter" aria-hidden="true"></i>Filter By:</h5>
                        <a href="#" data-filter="*" class="current">Show All</a>
                        <a href="#" data-filter=".forward">Forward</a>
                        <a href="#" data-filter=".defender">Defender</a>
                        <a href="#" data-filter=".midfielder">Midfielder</a>
                        <a href="#" data-filter=".goalkeeper">Goalkeeper</a>
                    </div>
                </div>
                <!-- End Nav Filters -->

                <div class="container padding-top">
               <div class="row portfolioContainer" style="display: flex; flex-wrap: wrap; gap: 20px;">
        <?php
       

        $query = "SELECT * FROM players";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()):
        ?>
        <!-- Start Player Item -->
        <div class="col-xl-3 col-lg-4 col-md-6 <?= strtolower($row['position']) ?>" style="display: flex;">
            <div class="item-player">
                <div class="head-player">
                    <img src="img/players/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['team']) ?>">
                    <div class="overlay"><a href="single-player.php?id=<?= $row['id'] ?>">+</a></div>
                </div>
                <div class="info-player">
                    <span class="number-player"><?= $row['jersey_number'] ?></span>
                    <h4>
                        <?= $row['name'] ?>
                        <span><?= $row['position'] ?></span>
                    </h4>
                    <ul>
                        <li>
                            <strong>NATIONALITY</strong>
                            <span><img src="img/clubs-logos/colombia.png" alt=""> <?= $row['nationality'] ?></span>
                        </li>
                        <li><strong>MATCHES:</strong> <span><?= $row['matches'] ?></span></li>
                        <li><strong>AGE:</strong> <span><?= $row['age'] ?></span></li>
                    </ul>
                </div>
                <a href="single-player.php?id=<?= $row['id'] ?>" class="btn">
                    View Player <i class="fa fa-angle-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
        <!-- End Player Item -->
        <?php endwhile; ?>
    </div>
</div>

                <!-- Newsletter -->
                <div class="section-newsletter">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h2>Enter your e-mail and <span class="text-resalt">subscribe</span> to our newsletter.</h2>
                                    <p>Duis non lorem porta,  eros sit amet, tempor sem. Donec nunc arcu, semper a tempus et, consequat.</p>
                                </div>
                                <form id="newsletterForm" action="php/mailchip/newsletter-subscribe.php">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                                <input class="form-control" placeholder="Your Name" name="name"  type="text" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <i class="fa fa-envelope"></i>
                                                </span>
                                                <input class="form-control" placeholder="Your  Email" name="email"  type="email" required="required">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" type="submit" name="subscribe" >SIGN UP</button>
                                                 </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div id="result-newsletter"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Newsletter -->
            </section>
            <!-- End Section Area -  Content Central -->

            <div class="instagram-btn">
                <div class="btn-instagram">
                    <i class="fa fa-instagram"></i>
                    FOLLOW
                    <a href="https://www.instagram.com/fifaworldcup/" target="_blank">&#64;fifaworldcup</a>
                </div>
            </div>

            <div class="content-instagram">
                <div id="instafeed"></div>
            </div>
        <?php require ('footer.php'); ?>           
        </div>
        <!-- End layout-->

        <!-- ======================= JQuery libs =========================== -->
        <!-- jQuery local-->
        <script type="text/javascript" src="assets/js/jquery.js"></script>
        <!-- popper.js-->
        <script type="text/javascript" src="assets/js/popper.min.js"></script>
        <!-- bootstrap.min.js-->
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <!-- required-scripts.js-->
        <script type="text/javascript" src="assets/js/theme-scripts.js"></script>
        <!-- theme-main.js-->
        <script type="text/javascript" src="assets/js/theme-main.js"></script>
        <!-- ======================= End JQuery libs =========================== -->

    </body>
</html>
