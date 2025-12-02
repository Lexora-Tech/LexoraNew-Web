<?php
include("includes/db.php");

// --- 1. CONFIGURATION & PAGINATION ---
$limit = 10; // Limit to 10 posts per page
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// --- 2. SEARCH LOGIC ---
$search_term = "";
$where_clause = "";

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_term = mysqli_real_escape_string($conn, $_GET['search']);
    $where_clause = "WHERE title LIKE '%$search_term%' OR heading LIKE '%$search_term%'";
}

// --- 3. FETCH TOTAL COUNT (For Pagination) ---
$count_sql = "SELECT COUNT(*) as total FROM blogs $where_clause";
$count_query = mysqli_query($conn, $count_sql);
$count_data = mysqli_fetch_assoc($count_query);
$total_records = $count_data['total'];
$total_pages = ceil($total_records / $limit);

// --- 4. FETCH LATEST BLOGS (With Limit) ---
// Used for the main grid
$latest_query = "SELECT * FROM blogs $where_clause ORDER BY created_at DESC LIMIT $offset, $limit";
$result_latest = mysqli_query($conn, $latest_query);

// --- 5. FETCH POPULAR BLOGS (For Slider) ---
// Used for the top slider (ordered by views)
$popular_query = "SELECT * FROM blogs ORDER BY views DESC LIMIT 8";
$result_popular = mysqli_query($conn, $popular_query);

// Helper for pagination links
function pageUrl($pageNum, $search) {
    $url = "?page=" . $pageNum;
    if (!empty($search)) {
        $url .= "&search=" . urlencode($search);
    }
    return $url;
}
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
    <title>Lexora Tech | Blog</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.png" />

    <style>
        /* Custom Search Bar Styles */
        .blog-search-form {
            position: relative;
            max-width: 500px;
            margin-top: 40px;
        }
        .blog-search-form input {
            width: 100%;
            padding: 15px 20px;
            padding-right: 60px;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 50px;
            background: rgba(255,255,255,0.8);
            backdrop-filter: blur(10px);
            font-size: 16px;
            transition: 0.3s;
            outline: none;
        }
        .blog-search-form input:focus {
            background: #fff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border-color: #ffb400;
        }
        .blog-search-form button {
            position: absolute;
            right: 5px;
            top: 5px;
            height: 46px;
            width: 46px;
            border-radius: 50%;
            border: none;
            background: #ffb400;
            color: #000;
            cursor: pointer;
            transition: 0.3s;
        }
        .blog-search-form button:hover {
            transform: scale(1.05);
        }
        
        /* Pagination Active State Override */
        .mil-blog-pagination ul li.mil-active a {
            background-color: #ffb400;
            color: #000;
            border-color: #ffb400;
        }
        
        /* Empty State */
        .no-results {
            text-align: center;
            padding: 60px 0;
            width: 100%;
            color: #999;
        }
    </style>

</head>

<body>

    <!-- wrapper -->
    <div id="smooth-wrapper" class="mil-page-wrapper">

        <!-- cursor -->
        <div class="mil-cursor-follower"></div>
        <!-- cursor end -->

        <!-- scroll progress -->
        <div class="mil-progress-track">
            <div class="mil-progress"></div>
        </div>
        <!-- scroll progress end -->

        <!-- fixed elements -->
        <?php include "header.php"; ?>
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
                                <h1 class="mil-display2 mil-rubber">Latest <span class="mil-a2">News</span></h1>
                                
                                <!-- Search Bar -->
                                
                            </div>
                        </div>
                    </div>
                    <!-- hero end -->

                    <!-- popular (Top Slider) -->
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

                                    <?php while ($row = mysqli_fetch_assoc($result_popular)) { ?>
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
                    <!-- popular end -->

                    <!-- blog grid (Latest with Pagination) -->
                    <div class="mil-p-0-100">
                        <div class="container">
                            <div class="row mil-aie mil-mb30">
                                <div class="col-md-6">
                                    <h2 class="mil-head1 mil-mb60 mil-up">
                                        <?php echo empty($search_term) ? 'Latest <span class="mil-a2">Publications</span>' : 'Search Results'; ?>
                                    </h2>
                                </div>
                            </div>
                            <div class="row">

                                <?php 
                                if (mysqli_num_rows($result_latest) > 0) {
                                    while ($row = mysqli_fetch_assoc($result_latest)) { 
                                ?>
                                    <!--  Start Latest Blog Post Card -->
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
                                    <!--  End Latest Blog Post Card -->
                                <?php 
                                    }
                                } else {
                                    echo '<div class="no-results mil-up"><h4 class="mil-head4">No articles found.</h4></div>';
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                    <!-- blog end -->

                    <!-- pagination -->
                    <?php if ($total_pages > 1): ?>
                    <div class="mil-p-0-160">
                        <div class="container">
                            <div class="mil-blog-pagination">
                                <ul>
                                    <!-- Previous Button -->
                                    <?php if ($page > 1): ?>
                                        <li><a href="<?= pageUrl($page - 1, $search_term) ?>"><i class="far fa-arrow-left"></i></a></li>
                                    <?php endif; ?>

                                    <!-- Page Numbers -->
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="<?= $i == $page ? 'mil-active' : '' ?>">
                                            <a href="<?= pageUrl($i, $search_term) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <!-- Next Button -->
                                    <?php if ($page < $total_pages): ?>
                                        <li><a href="<?= pageUrl($page + 1, $search_term) ?>"><i class="far fa-arrow-right"></i></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
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
                    <?php include "footer.php"; ?>
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
</body>

</html>