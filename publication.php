<?php
include("includes/db.php");

// 1. Get the Blog ID
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 2. INCREMENT VIEW COUNT
$update_views_sql = "UPDATE blogs SET views = views + 1 WHERE id = $id";
mysqli_query($conn, $update_views_sql);

// 3. Fetch Blog Details
$result = mysqli_query($conn, "SELECT * FROM blogs WHERE id=$id");
$blog = mysqli_fetch_assoc($result);

// Redirect if blog not found
if (!$blog) { header("Location: blog.php"); exit(); }

// 4. Fetch Similar Blogs
$result3 = mysqli_query($conn, "SELECT * FROM blogs WHERE id != $id ORDER BY created_at DESC LIMIT 6");

// --- HELPER: CURRENT URL FOR SHARING ---
$current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$share_title = urlencode($blog['title']);
$share_url = urlencode($current_url);

// --- HELPER: ESTIMATE READ TIME ---
function estimateReadTime($text) {
    $word_count = str_word_count(strip_tags($text));
    $minutes = floor($word_count / 200);
    return max(1, $minutes) . ' min read';
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/plugins/bootstrap-grid.css">
    <link rel="stylesheet" href="css/plugins/fontawesome.min.css">
    <link rel="stylesheet" href="css/plugins/swiper.min.css">
    <link rel="stylesheet" href="css/style-stylish.css">
    
    <title>Lexora Tech | <?= $blog['title']; ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.png" />

   <style>
     /* --- 1. DARK MODE BASE --- */
 body { background-color: #000; color: #ccc; }
   </style>

</head>

<body>

    <div class="read-progress-container">
        <div class="read-progress-bar" id="myBar"></div>
    </div>

    <div id="smooth-wrapper" class="mil-page-wrapper">
        <div class="mil-cursor-follower"></div>
        <div class="mil-progress-track"><div class="mil-progress"></div></div>

        <?php include "header.php"; ?>

        <div class="mil-transition-fade" id="swup">
            <div class="mil-transition-frame">

            <link rel="stylesheet" href="css/publication.css">

                <div id="smooth-content" class="mil-content">

                    <div class="blog-hero mil-up">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-10">
                                    <div class="text-center">
                                        <div class="blog-meta-badge">Article</div>
                                        <h1 class="blog-title-main"><?= $blog['title']; ?></h1>
                                        
                                        <div class="blog-info-row justify-content-center">
                                            <span><i class="far fa-calendar"></i> <?= date("M d, Y", strtotime($blog['created_at'])) ?></span>
                                            <span><i class="far fa-clock"></i> <?= estimateReadTime($blog['p1'] . $blog['p2']); ?></span>
                                            <span><i class="far fa-eye"></i> <?= $blog['views']; ?> Views</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mil-scale-img" data-value-1="1.1" data-value-2="1">
                                        <img src="uploads/<?= $blog['cover_image']; ?>" alt="<?= $blog['title']; ?>" class="main-cover-img">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mil-p-0-100">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 content-wrapper">
                                    
                                    <p class="blog-text-lead mil-up"><?= $blog['headingbrief']; ?></p>

                                    <div class="mil-mb60 mil-up">
                                        <h3 class="mil-mb30" style="color: #fff;"><?= $blog['heading']; ?></h3>
                                        <p><?= $blog['p1']; ?></p>
                                    </div>

                                    <div class="row mil-mb60 mil-up">
                                        <div class="col-md-6">
                                            <img src="uploads/<?= $blog['image1']; ?>" alt="Detail 1" class="content-image">
                                        </div>
                                        <div class="col-md-6">
                                            <img src="uploads/<?= $blog['image2']; ?>" alt="Detail 2" class="content-image">
                                        </div>
                                    </div>

                                    <div class="mil-mb60 mil-up">
                                        <p><?= $blog['p2']; ?></p>
                                    </div>

                                    <div class="conclusion-box mil-up">
                                        <h4 class="conclusion-title">Conclusion</h4>
                                        <p class="mil-mb0"><?= $blog['conclusion']; ?></p>
                                    </div>

                                    <div class="mil-mt60 mil-up share-wrapper-responsive" style="border-top: 1px solid #222; padding-top: 30px; display: flex; justify-content: space-between; align-items: center;">
                                        
                                        <a href="blog.php" class="mil-link mil-a2"><i class="fas fa-arrow-left"></i> Back To Blog</a>
                                        
                                        <div class="share-container">
                                            <span style="color: #666; font-size: 14px; margin-right: 10px;">Share:</span>
                                            
                                            <a href="https://api.whatsapp.com/send?text=<?= $share_title . ' ' . $share_url ?>" target="_blank" class="share-btn">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                            
                                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?= $share_url ?>" target="_blank" class="share-btn">
                                                <i class="fab fa-facebook-f"></i>
                                            </a>
                                            
                                            <a href="https://twitter.com/intent/tweet?text=<?= $share_title ?>&url=<?= $share_url ?>" target="_blank" class="share-btn">
                                                <i class="fab fa-twitter"></i>
                                            </a>
                                            
                                            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= $share_url ?>&title=<?= $share_title ?>" target="_blank" class="share-btn">
                                                <i class="fab fa-linkedin-in"></i>
                                            </a>

                                            <button onclick="copyLink()" class="share-btn copy-btn" id="copyBtn">
                                                <i class="fas fa-link"></i>
                                            </button>
                                        </div>
                                    </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="mil-p-0-160" style="background: #0b0b0b; padding-top: 100px;">
                        <div class="container">
                            <div class="row mil-aie mil-mb60">
                                <div class="col-md-6">
                                    <h2 class="mil-head1 mil-up" style="color: #fff;">Similar <span class="mil-a2">Reads</span></h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="mil-nl-nav mil-up">
                                        <div class="mil-slider-btn mil-nl-prev" style="border-color: #333;"></div>
                                        <div class="mil-slider-btn mil-nl-next" style="border-color: #333;"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="swiper-container mil-blog-slider">
                                <div class="swiper-wrapper mil-c-swipe mil-c-light">
                                    <?php while ($row = mysqli_fetch_assoc($result3)) { ?>
                                        <div class="swiper-slide">
                                            <a href="publication.php?id=<?= $row['id']; ?>" class="lexora-card">
                                                <div class="card-img-wrap">
                                                    <img src="uploads/<?= $row['cover_image']; ?>" alt="cover">
                                                </div>
                                                <div class="card-body-modern">
                                                    <div class="card-meta-modern">
                                                        <span style="color: #ffb400;">Article</span> 
                                                        <span>•</span>
                                                        <span><?= estimateReadTime($row['heading']); ?></span>
                                                    </div>
                                                    
                                                    <h4 class="card-title-modern"><?= $row['title']; ?></h4>
                                                    
                                                    <div class="card-read-link">
                                                        Read Article <i class="fas fa-arrow-right" style="transform: rotate(-45deg); color: #ffb400;"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

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
                    </div>

                    <?php include "footer.php"; ?>

                </div>
            </div>
        </div>
    </div>

    <script src="js/plugins/swup.min.js"></script>
    <script src="js/plugins/gsap.min.js"></script>
    <script src="js/plugins/ScrollSmoother.min.js"></script>
    <script src="js/plugins/ScrollTrigger.min.js"></script>
    <script src="js/plugins/ScrollTo.min.js"></script>
    <script src="js/plugins/swiper.min.js"></script>
    <script src="js/plugins/parallax.js"></script>
    <script src="js/main.js"></script>

    <script>
        // Progress Bar
        window.onscroll = function() {myFunction()};
        function myFunction() {
            var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrolled = (winScroll / height) * 100;
            document.getElementById("myBar").style.width = scrolled + "%";
        }

        // Copy Link Function
        function copyLink() {
            var dummy = document.createElement('input');
            document.body.appendChild(dummy);
            dummy.value = window.location.href;
            dummy.select();
            document.execCommand('copy');
            document.body.removeChild(dummy);
            
            var btn = document.getElementById("copyBtn");
            btn.classList.add("copied");
            
            setTimeout(function() {
                btn.classList.remove("copied");
            }, 2000);
        }
    </script>
</body>
</html>