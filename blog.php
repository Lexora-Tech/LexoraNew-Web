<?php
include("includes/db.php");
$result = mysqli_query($conn, "SELECT * FROM blogs ORDER BY created_at ASC LIMIT 8");
$result2 = mysqli_query($conn, "SELECT * FROM blogs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- grid css -->
    <link rel="stylesheet" href="css/plugins/bootstrap-grid.css">
    <!-- font awesome css -->
    <link rel="stylesheet" href="css/plugins/fontawesome.min.css">
    <!-- swiper css -->
    <link rel="stylesheet" href="css/plugins/swiper.min.css">
    <!-- okai css -->
    <link rel="stylesheet" href="css/style-stylish.css">
    <!-- page title -->
    <title>LexoraTech | Blog</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.png" />

</head>

<body>

    <!-- wrapper -->
    <div id="smooth-wrapper" class="mil-page-wrapper">

        <!-- cursor -->
        <div class="mil-cursor-follower"></div>
        <!-- cursor end -->

        <!-- preloader -->
        <!--  <div class="mil-preloader">
            <div class="mil-preloader-animation">
                <div class="mil-pos-abs mil-animation-1">
                    <p class="mil-head1 mil-m1">Pioneering</p>
                    <p class="mil-head1 mil-a2">Creative</p>
                    <p class="mil-head1 mil-m1">Excellence</p>
                </div>
                <div class="mil-pos-abs mil-animation-2">
                    <div class="mil-reveal-frame">
                        <p class="mil-reveal-box"></p>
                        <p class="mil-head1 mil-m1">LexoraTech.com</p>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- preloader end -->

        <!-- scroll progress -->
        <div class="mil-progress-track">
            <div class="mil-progress"></div>
        </div>
        <!-- scroll progress end -->

        <!-- fixed elements -->
        <?php
        include "header.php";
        ?>
        <!-- fixed elements end -->

        <!-- page transition -->
        <div class="mil-transition-fade" id="swup">
            <div class="mil-transition-frame">

                <!-- content -->
                <div id="smooth-content" class="mil-content">

                    <!-- hero -->
                    <div class="mil-hero-1 mil-sm-hero mil-stl mil-up" id="top">
                        <div class="mil-overlay"></div>
                        <div class="container mil-hero-main mil-relative mil-aic">
                            <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
                                <div class="mil-text-pad"></div>
                                <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                                    <li>
                                        <a href="index.php">Home</a>
                                    </li>
                                    <li>
                                        <a href="#.">Blog</a>
                                    </li>
                                </ul>
                                <h1 class="mil-display2 mil-rubber">Blog</h1>
                            </div>
                        </div>
                    </div>
                    <!-- hero end -->

                    <!-- popular -->
                    <div class="mil-p-0-160">
                        <div class="container">
                            <div class="row mil-aie mil-mb30">
                                <div class="col-md-6">
                                    <h2 class="mil-head1 mil-mb60 mil-up">Popular <span class="mil-a2">Publications</span></h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="mil-nl-nav mil-up mil-mb60">
                                        <div class="mil-slider-btn mil-nl-prev mil-c-gone"></div>
                                        <div class="mil-slider-btn mil-nl-next mil-c-gone"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="swiper-container mil-blog-slider">
                                <div class="swiper-wrapper mil-c-swipe mil-c-light">

                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <!-- Start Swiper -->
                                        <div class="swiper-slide">
                                            <div class="mil-blog-card">
                                                <div class="mil-cover mil-up">
                                                    <div class="mil-hover-frame">
                                                        <img src="uploads/<?= $row['cover_image']; ?>" alt="cover" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                                    </div>
                                                    <div class="mil-badges">

                                                        <div class="mil-date"><?= date("M d, Y", strtotime($row['created_at'])) ?></div>
                                                    </div>
                                                </div>
                                                <a href="publication.php?id=<?= $row['id']; ?>" class="mil-descr mil-c-gone">
                                                    <div class="mil-text-frame">
                                                        <h4 class="mil-head4 mil-max-2row-text mil-mb20 mil-up"><?= $row['title']; ?></h4>
                                                        <p class="mil-text-md mil-max-2row-text mil-up"><?= $row['heading']; ?></p>
                                                    </div>
                                                    <div class="mil-up mil-768-gone">
                                                        <div class="mil-stylized-btn">
                                                            <i class="fal fa-arrow-up"></i>
                                                            <span>Read more</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <!--  End Swiper -->
                                    <?php } ?>


                                </div>
                            </div>

                        </div>
                        <!-- popular end -->

                        <!-- blog -->
                        <div class="mil-p-0-100">
                            <div class="container">
                                <div class="row mil-aie mil-mb30">
                                    <div class="col-md-6">
                                        <h2 class="mil-head1 mil-mb60 mil-up">Latest <span class="mil-a2">Publications</span></h2>
                                    </div>
                                </div>
                                <div class="row">

                                    <?php while ($row = mysqli_fetch_assoc($result2)) { ?>
                                        <!--  Start Latest Blog Posts -->
                                        <div class="col-lg-12">
                                            <div class="mil-blog-card mil-type-2 mil-mb60">
                                                <div class="mil-cover mil-up">
                                                    <div class="mil-hover-frame">
                                                        <img src="uploads/<?= $row['cover_image']; ?>" alt="cover" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                                    </div>
                                                    <div class="mil-badges">

                                                        <div class="mil-date"><?= date("M d, Y", strtotime($row['created_at'])) ?></div>
                                                    </div>
                                                </div>
                                                <a href="publication.php?id=<?= $row['id']; ?>" class="mil-descr mil-c-gone">
                                                    <div class="mil-text-frame">
                                                        <h4 class="mil-head3 mil-max-2row-text mil-mb30 mil-up"><?= $row['title']; ?></h4>
                                                        <p class="mil-text-md mil-max-2row-text mil-mb40 mil-up"><?= $row['heading']; ?></p>
                                                        <div class="mil-up">
                                                            <div class="mil-btn mil-a2 mil-c-gone">Read more</div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <!--  End Latest Blog Posts  -->
                                    <?php } ?>


                                </div>
                            </div>
                        </div>
                        <!-- blog end -->

                        <!-- pagination -->
                        <div class="mil-p-0-160">
                            <div class="container">
                                <div class="mil-blog-pagination">
                                    <ul>
                                        <li><a href="#."><i class="far fa-arrow-left"></i></a></li>
                                        <li class="mil-active"><a href="#.">1</a></li>
                                        <li><a href="#.">2</a></li>
                                        <li><a href="#.">...</a></li>
                                        <li><a href="#."><i class="far fa-arrow-right"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- pagination end -->

                        <!-- subscribe -->
                        <div class="container">
                            <div class="mil-half-container mil-stl mil-reverse mil-up">
                                <div class="mil-text-box mil-g-m4 mil-p-160-160">
                                    <p class="mil-stylized mil-m2 mil-mb60 mil-up">Newsletter</p>
                                    <h2 class="mil-display3 mil-rubber mil-mb60 mil-up">Subscribe <span class="mil-a2">our</span> <br>newsletter</h2>
                                    <form class="mil-subscribe-form mil-up mil-c-gone">
                                        <input type="text" placeholder="Enter your email">
                                        <button type="submit"><i class="fal fa-arrow-right"></i></button>
                                    </form>
                                </div>
                                <div class="mil-image-box">
                                    <div class="mil-image-frame">
                                        <img src="img/home-4/2.jpg" alt="img" class="mil-scale-img" data-value-1="1.20" data-value-2="1">
                                        <div class="mil-overlay"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mil-aic mil-jcb mil-no-g">
                                <div class="col-lg-6">
                                    <div class="mil-button-pad mil-a1 mil-jst" style="display: block"></div>
                                </div>
                                <div class="col-lg-6 mil-992-gone">
                                    <div class="mil-text-pad">
                                        <p class="mil-text-sm mil-up">By clicking the submit button, you agree to the <br><a href="contact.php" class="mil-text-link mil-a2 mil-c-gone">rules for processing personal data</a>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- subscribe end -->

                        <!-- footer -->
                        <?php
                        include "footer.php";
                        ?>
                        <!-- footer end -->

                    </div>
                    <!-- content -->

                </div>
            </div>
            <!-- page transition -->

        </div>
        <!-- wrapper end -->

        <!-- swup js -->
        <script src="js/plugins/swup.min.js"></script>
        <!-- gsap js -->
        <script src="js/plugins/gsap.min.js"></script>
        <!-- scroll smoother -->
        <script src="js/plugins/ScrollSmoother.min.js"></script>
        <!-- scroll trigger js -->
        <script src="js/plugins/ScrollTrigger.min.js"></script>
        <!-- scroll to js -->
        <script src="js/plugins/ScrollTo.min.js"></script>
        <!-- swiper js -->
        <script src="js/plugins/swiper.min.js"></script>
        <!-- parallax js -->
        <script src="js/plugins/parallax.js"></script>

        <!-- LexoraTech js -->
        <script src="js/main.js"></script>

</body>

</html>