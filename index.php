<?php
session_start();
if (!isset($_SESSION['super_admin_logged_in'])) {
  header("Location: Auth.php");
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Basic -->
        <meta charset="utf-8">
        <title>Xtreme Cricket League</title>
        <meta name="keywords" content="HTML5 Template" />
        <meta name="description" content="Xtreme Cricket League">
        <meta name="author" content="orkasports.com">

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
<?php require ('header.php');
      require ('navbar.php'); ?>
        <!-- layout-->
        <div id="layout">

            <!-- End Header-->

           
            
            <!-- End Mobile Nav-->

            <!-- section-hero-posts-->
            <div class="hero-header">
                <!-- Hero Slider-->
                <div id="hero-slider" class="hero-slider">

                    <!-- Item Slide-->
                    <div class="item-slider" style="background:url(img/slide/1.png);">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <div class="info-slider">
                                        <h1>Welcome to the Xtreme Cricket League</h1>
                                        <p>A global 20-over revolution—where speed, strategy, and national pride collide.</p>
                                        <a href="#" class="btn-iw outline">Read More <i class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Item Slide-->

                    <!-- Item Slide-->
                    <div class="item-slider" style="background:url(img/slide/2.png);">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <div class="info-slider">
                                        <h1>One Nation. One Team. One Dream.</h1>
                                        <p>Every franchise represents a country. Every match ignites global competition.</p>
                                        <a href="#" class="btn-iw outline">Read More <i class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Item Slide-->

                    <!-- Item Slide-->
                    <div class="item-slider" style="background:url(img/slide/3.jpg);">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <div class="info-slider">
                                        <h1>Cricket, Reimagined for the Digital Age</h1>
                                        <p>Fast-paced. Feature-packed. Designed for fans, streamed for the world.</p>
                                        <a href="#" class="btn-iw outline">Read More <i class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Item Slide-->

                </div>
                <!-- End Hero Slider-->
            </div>
            <!-- End section-hero-posts-->

             <!-- Section Area - Content Central -->
            <section class="content-info">
                <!-- Dark Home -->
                <div class="dark-home">
                   <div class="container">
                        <div class="row">
                            <!-- Left Content - Tabs and Carousel -->
                            <div class="col-xl-9 col-md-12">
                                <!-- Nav Tabs -->
                                <ul class="nav nav-tabs" id="myTab">
                                   <li class="active"><a href="#statistics" data-toggle="tab">STATISTICS</a></li>
                                   <li><a href="#description" data-toggle="tab">DESCRIPTION</a></li>
                                </ul>
                                <!-- End Nav Tabs -->

                                <!-- Content Tabs -->
                                <div class="tab-content">
                                    <!-- Tab Theree - statistics -->
                                    <div class="tab-pane active" id="statistics">
                                        <div class="row">
                                           <!-- Club Ranking -->
                                           <div class="col-lg-4">
                                               <div class="club-ranking">
                                                    <h5><a href="group-list.html">Club Ranking</a></h5>
                                                    <div class="info-ranking">
                                                        <ul>
                                                            <li>
                                                              <span class="position">
                                                                  1
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/clubs-logos/Delhi-Dareguns-flag.png" alt="">
                                                                    Delhi Dareguns
                                                                </a>
                                                                <span class="points">
                                                                    00
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  2
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/clubs-logos/Lahore-zalqars-flag.png" alt="">
                                                                    Lahore Zalqars
                                                                </a>
                                                                <span class="points">
                                                                    00
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  3
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/clubs-logos/Dhaka-ripsters-flag.png" alt="">
                                                                    Dhaka Ripsters
                                                                </a>
                                                                <span class="points">
                                                                    00
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  4
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/clubs-logos/kandy-voltras-flag.png" alt="">
                                                                    Kandy Voltras
                                                                </a>
                                                                <span class="points">
                                                                  00
                                                               </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  5
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/clubs-logos/London-griffars-flag.png" alt="">
                                                                    London Griffars
                                                                </a>
                                                                <span class="points">
                                                                    00
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  6
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/clubs-logos/Australia.png" alt="">
                                                                    Sydney Blazors
                                                                </a>
                                                                <span class="points">
                                                                    00
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  7
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/clubs-logos/South-Africa.png" alt="">
                                                                    Cape Vynox
                                                                </a>
                                                                <span class="points">
                                                                    00
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  8
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/clubs-logos/UAE.png" alt="">
                                                                     Dubai Dunehawks
                                                                </a>
                                                                <span class="points">
                                                                    00
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                               </div>
                                            </div>
                                           <!-- End Club Ranking -->

                                            <!-- recent-results -->
                                            <div class="col-lg-5">
                                               <div class="recent-results">
                                                    <h5><a href="group-list.html">Recent Result</a></h5>
                                                    <div class="info-results">
                                                        <ul>
                                                            <li>
                                                                <span class="head">
                                                                    Delhi Dareguns Vs Lahore Zalqars <span class="date">27 Jun 2017</span>
                                                                </span>

                                                                <div class="goals-result">
                                                                    <a href="single-team.php">
                                                                        <img src="img/clubs-logos/India.png" alt="">
                                                                        Delhi Dareguns
                                                                    </a>

                                                                    <span class="goals">
                                                                        <b>0</b> - <b>0</b>
                                                                    </span>

                                                                    <a href="single-team.php">
                                                                        <img src="img/clubs-logos/pakistan.png" alt="">
                                                                        Lahore Zalqars
                                                                    </a>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <span class="head">
                                                                    Rusia Vs Colombia <span class="date">30 Jun 2017</span>
                                                                </span>

                                                                <div class="goals-result">
                                                                    <a href="single-team.php">
                                                                        <img src="img/clubs-logos/rusia.png" alt="">
                                                                        Rusia
                                                                    </a>

                                                                    <span class="goals">
                                                                        <b>0</b> - <b>0</b>
                                                                    </span>

                                                                    <a href="single-team.php">
                                                                        <img src="img/clubs-logos/colombia.png" alt="">
                                                                         Colombia
                                                                    </a>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <span class="head">
                                                                    Uruguay Vs Portugal <span class="date">31 Jun 2017</span>
                                                                </span>

                                                                <div class="goals-result">
                                                                    <a href="single-team.php">
                                                                        <img src="img/clubs-logos/uru.png" alt="">
                                                                        Uruguay
                                                                    </a>

                                                                    <span class="goals">
                                                                        <b>0</b> - <b>0</b>
                                                                    </span>

                                                                    <a href="single-team.php">
                                                                        <img src="img/clubs-logos/por.png" alt="">
                                                                         Portugal
                                                                    </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                               </div>
                                            </div>
                                            <!-- end recent-results -->

                                            <!-- Top player -->
                                            <div class="col-lg-3">
                                               <div class="player-ranking">
                                                    <h5><a href="group-list.html">Top player</a></h5>
                                                    <div class="info-player">
                                                        <ul>
                                                            <li>
                                                              <span class="position">
                                                                  1
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/players/1.jpg" alt="">
                                                                    Cristiano R.
                                                                </a>
                                                                <span class="points">
                                                                    90
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  2
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/players/2.jpg" alt="">
                                                                    Lionel Messi
                                                                </a>
                                                                <span class="points">
                                                                    88
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  3
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/players/3.jpg" alt="">
                                                                    Neymar
                                                                </a>
                                                                <span class="points">
                                                                    86
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  4
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/players/4.jpg" alt="">
                                                                    Luis Suárez
                                                                </a>
                                                                <span class="points">
                                                                  80
                                                               </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  5
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/players/5.jpg" alt="">
                                                                    Gareth Bale
                                                                </a>
                                                                <span class="points">
                                                                    76
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  6
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/players/6.jpg" alt="">
                                                                    Sergio Agüero
                                                                </a>
                                                                <span class="points">
                                                                    74
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  7
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/players/2.jpg" alt="">
                                                                    Jamez R.
                                                                </a>
                                                                <span class="points">
                                                                    70
                                                                </span>
                                                            </li>

                                                            <li>
                                                              <span class="position">
                                                                  8
                                                              </span>
                                                               <a href="single-team.php">
                                                                    <img src="img/players/1.jpg" alt="">
                                                                     Falcao Garcia
                                                                </a>
                                                                <span class="points">
                                                                    65
                                                                </span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                               </div>
                                            </div>
                                            <!-- End Top player -->
                                        </div>
                                    </div>
                                    <!-- Tab Theree - statistics -->

                                    <!-- Tab Two - Destinations -->
                                    <div class="tab-pane" id="description">
                                       <div class="info-general">
                                            <div class="row">
                                               <div class="col-md-4">
                                                  <img src="img/locations/Xtreme-Cricket-League-min.png" alt="Xtreme Cricket League">
                                               </div>

                                               <div class="col-md-8">
                                                   <h3>Xtreme Cricket League</h3>
                                                   <p class="lead">Xtreme Cricket League (XCL) is a revolutionary 20-over global cricket format designed for a fast-paced, high-impact viewing experience tailored to the digital age. Created by <a href="https://sandipsuhag.com" target="_blank">Sandip Suhag</a> and owned by <a href="https://orkasports.com" target="_blank">Orka Sports Ltd</a>, XCL represents a bold new era in cricket—where innovation meets international pride.</p>
<p class="lead">In XCL, each franchise represents a single country, with local ownership ensuring a deep connection to national identity and fan engagement. The league enforces a unique team structure of 8 active players on the field and 4 rolling substitutes, blending traditional cricket with dynamic, tactical flexibility. With just 75 minutes per match and 5 innovative match phases—like Powerplay X and The Ultimate Chase—XCL introduces thrilling rules like the Captain’s Joker Card, Bowler’s Breaker, and Xtreme Super Over to keep fans at the edge of their seats.</p>
                                               </div>

                                               <div class="col-md-12">
                                                   <p>Backed by Orka Sports Ltd, a company dedicated to sports innovation and athlete empowerment, XCL is more than just a cricket league—it's a movement to globalize and modernize the sport while preserving its competitive spirit and cultural roots.</p>
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Tab Two - Destinations -->
                                </div>
                                <!-- Content Tabs -->
                            </div>
                            <!-- Left Content - Tabs and Carousel -->

                            <!-- Right Content - Content Counter -->
                            <div class="col-xl-3 col-md-12">
                                <div class="counter-home-wraper">
                                    <div class="title-color text-center">
                                        <h4>Xtreme Cricket League</h4>
                                    </div>

                                    <div class="content-counter content-counter-home">
                                        <p class="text-center">
                                            <i class="fa fa-clock-o"></i>
                                            Countdown Till Start
                                        </p>
                                        <div id="event-one" class="counter"></div>
                                        <ul class="post-options">
                                            <li><i class="fa fa-calendar"></i>07 February, 2026</li>
                                            <li><i class="fa fa-clock-o"></i>Kick-of, 05:00 PM</li>
                                        </ul>

                                        <div class="list-groups">
                                            <div class="row align-items-center">

                                                <div class="col-md-12">
                                                    <p>GROUP A, Luzhniki Stadium Moscow</p>
                                                </div>

                                                <div class="col-md-5">
                                                    <img src="img/clubs-logos/rusia.png" alt="">
                                                    <span>RUSSIA</span>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="vs">Vs</div>
                                                </div>

                                                <div class="col-md-5">
                                                    <img src="img/clubs-logos/arabia.png" alt="">
                                                    <span>SAUDI ARABIA</span>
                                                </div>
                                            </div>
                                        </div>

                                        <a class="btn btn-primary" href="#">
                                            PURCHASE
                                            <i class="fa fa-trophy"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- Content Counter -->
                            </div>
                            <!-- End Right Content - Content Counter -->
                        </div>
                    </div>
                </div>
                <!-- Dark Home -->

                <div class="container paddings">
                    <div class="container">

                        <div class="row no-line-height">
                              <div class="col-md-12">
                                  <h3 class="clear-title">Club Teams</h3>
                              </div>
                        </div>


<style>
    .location-team a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s;
    }

    .location-team a:hover {
        color: #007bff; /* Change this to your preferred hover color */
    }
</style>
                        <div class="row">
                           <!-- Item Team Group A-->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="item-team">
                                    <div class="head-team">
                                        <img src="img/clubs-logos/Delhi-Dareguns-flag.png" alt="location-team">
                                        <div class="overlay"><a href="single-team.php">+</a></div>
                                    </div>
                                    <div class="info-team">
                                        <span class="logo-team">
                                            <img src="img/clubs-logos/Delhi-Dareguns-logo.png" alt="logo-team">
                                        </span>
                                        <h4>Delhi Dareguns</h4>
                                        <span class="location-team">
                                            <a href="#">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Stadium
                                            </a>
                                        </span>
                                        <span class="group-team">
                                            <i class="fa fa-trophy" aria-hidden="true"></i>
                                            Group A
                                        </span>
                                    </div>
                                    <a href="single-team.php" class="btn">Team Profile <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <!-- End Item Team Group A-->

                            <!-- Item Team Group A-->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="item-team">
                                    <div class="head-team">
                                        <img src="img/clubs-logos/Lahore-zalqars-flag.png" alt="location-team">
                                        <div class="overlay"><a href="single-team.php">+</a></div>
                                    </div>
                                    <div class="info-team">
                                        <span class="logo-team">
                                            <img src="img/clubs-logos/Lahore-zalqars-logo.png" alt="logo-team">
                                        </span>
                                        <h4>Lahore Zalqars</h4>
                                        <span class="location-team">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Stadium
                                        </span>
                                        <span class="group-team">
                                            <i class="fa fa-user" aria-hidden="true"></i>
                                            Owner
                                        </span>
                                    </div>
                                    <a href="single-team.php" class="btn">Team Profile <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <!-- End Item Team Group A-->

                            <!-- Item Team Group A-->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="item-team">
                                    <div class="head-team">
                                        <img src="img/clubs-logos/Dhaka-ripsters-flag.png" alt="location-team">
                                        <div class="overlay"><a href="single-team.php">+</a></div>
                                    </div>
                                    <div class="info-team">
                                        <span class="logo-team">
                                            <img src="img/clubs-logos/Dhaka-ripsters-logo.png" alt="logo-team">
                                        </span>
                                        <h4>Dhaka Ripsters</h4>
                                        <span class="location-team">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Stadium
                                        </span>
                                        <span class="group-team">
                                            <i class="fa fa-trophy" aria-hidden="true"></i>
                                            Group A
                                        </span>
                                    </div>
                                    <a href="single-team.php" class="btn">Team Profile <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <!-- End Item Team Group A-->

                            <!-- Item Team Group A-->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="item-team">
                                    <div class="head-team">
                                        <img src="img/clubs-logos/kandy-voltras-flag.png" alt="location-team">
                                        <div class="overlay"><a href="single-news.html">+</a></div>
                                    </div>
                                    <div class="info-team">
                                        <span class="logo-team">
                                            <img src="img/clubs-logos/kandy-voltras-logo.png" alt="logo-team">
                                        </span>
                                        <h4>Kandy Voltras</h4>
                                        <span class="location-team">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Stadium
                                        </span>
                                        <span class="group-team">
                                            <i class="fa fa-trophy" aria-hidden="true"></i>
                                            Group A
                                        </span>
                                    </div>
                                    <a href="single-team.php" class="btn">Team Profile <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <!-- End Item Team Group A-->

                            <!-- Item Team Group A-->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="item-team">
                                    <div class="head-team">
                                        <img src="img/clubs-logos/London-griffars-flag.png" alt="location-team">
                                        <div class="overlay"><a href="single-news.html">+</a></div>
                                    </div>
                                    <div class="info-team">
                                        <span class="logo-team">
                                            <img src="img/clubs-logos/London-griffars-logo.png" alt="logo-team">
                                        </span>
                                        <h4>London Griffars</h4>
                                        <span class="location-team">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Stadium
                                        </span>
                                        <span class="group-team">
                                            <i class="fa fa-trophy" aria-hidden="true"></i>
                                            Group A
                                        </span>
                                    </div>
                                    <a href="single-team.php" class="btn">Team Profile <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <!-- End Item Team Group A-->

                            <!-- Item Team Group A-->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="item-team">
                                    <div class="head-team">
                                        <img src="img/clubs-logos/Sydney-Blazors-flag.png" alt="location-team">
                                        <div class="overlay"><a href="single-news.html">+</a></div>
                                    </div>
                                    <div class="info-team">
                                        <span class="logo-team">
                                            <img src="img/clubs-logos/Sydney-Blazors-logo.png" alt="logo-team">
                                        </span>
                                        <h4>Sydney Blazors</h4>
                                        <span class="location-team">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Stadium
                                        </span>
                                        <span class="group-team">
                                            <i class="fa fa-trophy" aria-hidden="true"></i>
                                            Group A
                                        </span>
                                    </div>
                                    <a href="single-team.php" class="btn">Team Profile <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <!-- End Item Team Group A-->

                            <!-- Item Team Group A-->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="item-team">
                                    <div class="head-team">
                                        <img src="img/clubs-logos/Cape-Vynox-flag.png" alt="location-team">
                                        <div class="overlay"><a href="single-news.html">+</a></div>
                                    </div>
                                    <div class="info-team">
                                        <span class="logo-team">
                                            <img src="img/clubs-logos/Cape-Vynox-logo.png" alt="logo-team">
                                        </span>
                                        <h4>Cape Vynox</h4>
                                        <span class="location-team">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Stadium
                                        </span>
                                        <span class="group-team">
                                            <i class="fa fa-trophy" aria-hidden="true"></i>
                                            Group A
                                        </span>
                                    </div>
                                    <a href="single-team.php" class="btn">Team Profile <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <!-- End Item Team Group A-->

                            <!-- Item Team Group A-->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <div class="item-team">
                                    <div class="head-team">
                                        <img src="img/clubs-logos/Dubai-Dunehawks-flag.png" alt="location-team">
                                        <div class="overlay"><a href="single-news.html">+</a></div>
                                    </div>
                                    <div class="info-team">
                                        <span class="logo-team">
                                            <img src="img/clubs-logos/Dubai-Dunehawks-logo.png" alt="logo-team">
                                        </span>
                                        <h4>Dubai Dunehawks</h4>
                                        <span class="location-team">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            Stadium
                                        </span>
                                        <span class="group-team">
                                            <i class="fa fa-trophy" aria-hidden="true"></i>
                                            Group A
                                        </span>
                                    </div>
                                    <a href="single-team.php" class="btn">Team Profile <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                </div>
                            </div>
                            <!-- End Item Team Group A-->
                        </div>
                    </div>
                </div>
                <!-- End White Section -->



                <div class="dark-section paddings-big">
                   <div class="scale">
                       <div class="skewmask-block"></div>
                   </div>

                    <div class="container">
                        <div class="row">
                           <div class="col-lg-5 padding-top">
                               <h2>Xtreme Cricket League</h2>
                               <p class="lead">Xtreme Cricket League (XCL) is a revolutionary 20-over global cricket format designed for a fast-paced, high-impact viewing experience tailored to the digital age. Owned by Orka Sports Ltd, XCL represents a bold new era in cricket—where innovation meets international pride.</p>

                               <div class="row">
                                   <div class="col-6">
                                       <ul class="list-style">
                                           <li><a href="#"><i class="fa fa-angle-right"></i>Qualifiers</a></li>
                                           <li><a href="#"><i class="fa fa-angle-right"></i> Statistics</a></li>
                                           <li><a href="#"><i class="fa fa-angle-right"></i> Teams</a></li>
                                           <li><a href="#"><i class="fa fa-angle-right"></i> Qualifiers</a></li>
                                           <li><a href="#"><i class="fa fa-angle-right"></i> Ticketing</a></li>
                                       </ul>
                                   </div>

                                   <div class="col-6">
                                       <ul class="list-style">
                                           <li><a href="#"><i class="fa fa-angle-right"></i> Volunteers</a></li>
                                           <li><a href="#"><i class="fa fa-angle-right"></i> Committees</a></li>
                                           <li><a href="#"><i class="fa fa-angle-right"></i> Official Documents</a></li>
                                           <li><a href="#"><i class="fa fa-angle-right"></i> Terms Of Service</a></li>
                                           <li><a href="#"><i class="fa fa-angle-right"></i> Organisation</a></li>
                                       </ul>
                                   </div>
                               </div>
                           </div>

                           <div class="col-lg-7">
                               <div class="row">
                                    <div class="col-md-6 col-xl-4">
                                        <a href="single-team.php">
                                            <div class="item-boxed-img small" style="background: url(img/players/1.png);">
                                                <h4>Teams</h4>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-md-6 col-xl-4">
                                        <a href="page-about.html">
                                            <div class="item-boxed-img small" style="background: url(img/players/2.png);">
                                                <h4>Fixtures & Results</h4>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-md-6 col-xl-4">
                                        <a href="services.html">
                                            <div class="item-boxed-img small" style="background: url(img/players/3.png);">
                                                <h4>Points Table</h4>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-xl-4">
                                        <a href="single-team.php">
                                            <div class="item-boxed-img small" style="background: url(img/players/4.png);">
                                                <h4>Players & Stats</h4>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-md-6 col-xl-4">
                                        <a href="page-about.html">
                                            <div class="item-boxed-img small" style="background: url(img/players/5.png);">
                                                <h4>News & Media</h4>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-md-6 col-xl-4">
                                        <a href="services.html">
                                            <div class="item-boxed-img small" style="background: url(img/players/6.png);">
                                                <h4>Fan Zone</h4>
                                            </div>
                                        </a>
                                    </div>
                               </div>
                           </div>
                        </div>
                    </div>
                </div>

                <!-- Parallax Section - Testimonials -->
                <div class="parallax-section parallax-total" style="background:url(img/slide/3.jpg);">
                   <div class="scale-bottom">
                        <div class="skewmask-block"></div>
                    </div>

                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="text-center padding-bottom">
                                    <h2>We have earned the trust of <span class="text-resalt">25,869</span> Club Members.</h2>
                                    <p>Duis non lorem porta,  eros sit amet, tempor sem. semper a tempus et.</p>
                                </div>

                                <ul class="testimonials testimonials-carousel">
                                    <li>
                                        <blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum pellentesque!.</p>
                                        <img src="img/testimonials/1.jpg" alt="">
                                        <strong>Federic Gordon</strong><a href="#">@iwthemes</a></blockquote>
                                    </li>
                                    <li>
                                        <blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum pellentesque!.</p>
                                        <img src="img/testimonials/2.jpg" alt="">
                                        <strong>Federic Gordon</strong><a href="#">@iwthemes</a></blockquote>
                                    </li>
                                    <li>
                                        <blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum pellentesque!.</p>
                                        <img src="img/testimonials/3.jpg" alt="">
                                        <strong>Federic Gordon</strong><a href="#">@iwthemes</a></blockquote>
                                    </li>
                                    <li>
                                        <blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque rutrum pellentesque!.</p>
                                        <img src="img/testimonials/4.jpg" alt="">
                                        <strong>Federic Gordon</strong><a href="#">@iwthemes</a></blockquote>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Gray Section - Testimonials -->

                <!-- Content Central -->
                <div class="container padding-top">
                    <!--Items Club News -->
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="clear-title">Latest News</h3>
                        </div>

                        <!--Item Club News -->
                        <div class="col-lg-6 col-xl-3">
                             <!-- Widget Text-->
                             <div class="panel-box">
                                 <div class="titles no-margin">
                                     <h4><a href="#">World football's dates.</a></h4>
                                 </div>
                                 <a href="#"><img src="img/blog/1.jpg" alt=""></a>
                                 <div class="row">
                                     <div class="info-panel">
                                         <p>Fans from all around the world can apply for 2018 FIFA World Cup™ tickets as the first window of sales.</p>
                                     </div>
                                 </div>
                             </div>
                             <!-- End Widget Text-->
                        </div>
                        <!--End Item Club News -->

                        <!--Item Club News -->
                        <div class="col-lg-6 col-xl-3">
                            <!-- Widget Text-->
                            <div class="panel-box">
                                <div class="titles no-margin">
                                    <h4><a href="#">Mbappe’s year to remember</a></h4>
                                </div>
                                <a href="#"><img src="img/blog/2.jpg" alt=""></a>
                                <div class="row">
                                    <div class="info-panel">
                                        <p>Tickets may be purchased online by using Visa payment cards or Visa Checkout. Visa is the official.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Widget Text-->
                        </div>
                        <!--End Item Club News -->

                        <!--Item Club News -->
                        <div class="col-lg-6 col-xl-3">
                             <!-- Widget Text-->
                             <div class="panel-box">
                                 <div class="titles no-margin">
                                     <h4><a href="#">World football's dates.</a></h4>
                                 </div>
                                 <a href="#"><img src="img/blog/1.jpg" alt=""></a>
                                 <div class="row">
                                     <div class="info-panel">
                                         <p>Fans from all around the world can apply for 2018 FIFA World Cup™ tickets as the first window of sales.</p>
                                     </div>
                                 </div>
                             </div>
                             <!-- End Widget Text-->
                        </div>
                        <!--End Item Club News -->

                        <!--Item Club News -->
                        <div class="col-lg-6 col-xl-3">
                            <!-- Widget Text-->
                            <div class="panel-box">
                                <div class="titles no-margin">
                                    <h4><a href="#">Mbappe’s year to remember</a></h4>
                                </div>
                                <a href="#"><img src="img/blog/2.jpg" alt=""></a>
                                <div class="row">
                                    <div class="info-panel">
                                        <p>Tickets may be purchased online by using Visa payment cards or Visa Checkout. Visa is the official.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- End Widget Text-->
                        </div>
                        <!--End Item Club News -->
                        

                      </div>
                      <!--End Items Club News -->
                        

                      <!--Sponsors CLub -->
                      <div class="row no-line-height">
                          <div class="col-md-12">
                              <h3 class="clear-title">Sponsors</h3>
                          </div>
                      </div>
                      <!--End Sponsors CLub -->
                      <ul class="sponsors-carousel">
                         <li><a href="#"><img src="img/sponsors/1.png" alt=""></a></li>
                         <li><a href="#"><img src="img/sponsors/2.png" alt=""></a></li>
                         <li><a href="#"><img src="img/sponsors/3.png" alt=""></a></li>
                         <li><a href="#"><img src="img/sponsors/4.png" alt=""></a></li>
                         <li><a href="#"><img src="img/sponsors/5.png" alt=""></a></li>
                         <li><a href="#"><img src="img/sponsors/3.png" alt=""></a></li>
                      </ul>
                </div>
                <!-- End Content Central -->

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
                    <a href="https://www.instagram.com/xclt_20/" target="_blank">&#64;Xtreme Cricket League</a>
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