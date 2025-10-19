<?php
include("includes/db.php");
$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM blogs WHERE id=$id");
$blog = mysqli_fetch_assoc($result);
$result3 = mysqli_query($conn, "SELECT * FROM blogs ORDER BY created_at ASC LIMIT 8");
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
    <title>Lexora Tech | Publication</title>
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
                        <p class="mil-head1 mil-m1">Lexora Tech.com</p>
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
                                        <a href="blog.php">Blog</a>
                                    </li>
                                    <li>
                                        <a href="#.">publication</a>
                                    </li>
                                </ul>
                                <!-- Title -->
                                <h1 class="mil-display3 mil-rubber"><?= $blog['title']; ?></h1>
                                <!-- Title -->
                            </div>
                        </div>
                    </div>
                    <!-- hero end -->

                    <!-- publication -->
                    <div class="mil-p-0-160">
                        <div class="container">
                            <div class="row mil-jcc mil-aic">
                                <div class="col-lg-12 mil-mb160">
                                    <div class="mil-project-img mil-land mil-up">
                                        <!-- cover img -->
                                        <img src="uploads/<?= $blog['cover_image']; ?>" alt="project" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                        <!-- cover img  -->
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <!-- Heading -->
                                    <p class="mil-text-xl mil-m1 mil-mb60 mil-up"><?= $blog['heading']; ?></p>
                                    <!-- Heading -->

                                    <!-- Heading Brief -->
                                    <p class="mil-text-xl mil-mb90 mil-up"><?= $blog['headingbrief']; ?></p>
                                    <!-- Heading Brief -->
                                    <div class="row mil-mb60">
                                        <div class="col-lg-6">
                                            <div class="mil-project-img mil-land mil-up mil-mb30">
                                                <img src="uploads/<?= $blog['image1']; ?>" alt="project" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mil-project-img mil-land mil-up mil-mb30">
                                                <img src="uploads/<?= $blog['image2']; ?>" alt="project" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 	Paragraph One -->
                                    <p class="mil-text-xl mil-mb30 mil-up"><?= $blog['p1']; ?></p>
                                    <!-- 	Paragraph One -->

                                    <!-- Paragraph Two -->
                                    <p class="mil-text-xl mil-mb90 mil-up"><?= $blog['p2']; ?></p>
                                    <!-- Paragraph Two -->


                                    <h3 class="mil-head4 mil-mb30 mil-up">Conclusion</h3>
                                    <!-- Conclusion -->
                                    <p class="mil-text-xl mil-up"><?= $blog['conclusion']; ?></p>
                                    <!--   Conclusion -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- publication end -->

                    <!-- blog -->
                    <div class="mil-p-0-160">
                        <div class="container">
                            <div class="row mil-aie mil-mb30">
                                <div class="col-md-6">
                                    <h2 class="mil-head1 mil-mb60 mil-up">Similar <span class="mil-a2">Publications</span></h2>
                                </div>
                                <div class="col-md-6">
                                    <p class="mil-stylized mil-m1 mil-tar mil-768-tal mil-mb60 mil-up"><a href="blog.php" class="mil-arrow-link mil-c-gone">View all publications</a></p>
                                </div>
                            </div>
                            <div class="swiper-container mil-blog-slider">
                                <div class="swiper-wrapper mil-c-swipe mil-c-light">

                                    <?php while ($row = mysqli_fetch_assoc($result3)) { ?>
                                        <!-- card -->
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
                                        <!-- card -->
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- blog end -->

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

    <!-- Lexora Tech js -->
    <script src="js/main.js"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3130344952697641"
        crossorigin="anonymous"></script>
</body>

</html>