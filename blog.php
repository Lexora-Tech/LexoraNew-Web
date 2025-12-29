<?php

include("includes/db.php");

// --- 1. CONFIGURATION ---
$limit = 9; 
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// --- 2. SEARCH LOGIC ---
$search_term = "";
$where_clause = "";
$is_search_active = false; // Flag to control layout order

if (isset($_GET['search']) && trim($_GET['search']) !== '') {
    $search_term = mysqli_real_escape_string($conn, trim($_GET['search']));
    $where_clause = "WHERE title LIKE '%$search_term%' OR heading LIKE '%$search_term%'";
    $is_search_active = true;
}

// --- 3. FETCH DATA ---
$count_sql = "SELECT COUNT(*) as total FROM blogs $where_clause";
$count_query = mysqli_query($conn, $count_sql);
$count_data = mysqli_fetch_assoc($count_query);
$total_records = $count_data['total'];
$total_pages = ceil($total_records / $limit);

$latest_query = "SELECT * FROM blogs $where_clause ORDER BY created_at DESC LIMIT $offset, $limit";
$result_latest = mysqli_query($conn, $latest_query);

$popular_query = "SELECT * FROM blogs ORDER BY views DESC LIMIT 10";
$result_popular = mysqli_query($conn, $popular_query);

function estimateReadTime($text) {
    $word_count = str_word_count(strip_tags($text));
    return max(1, floor($word_count / 200)) . ' min read';
}

function pageUrl($pageNum, $search) {
    $url = "?page=" . $pageNum;
    if (!empty($search)) { $url .= "&search=" . urlencode($search); }
    return $url;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $pageTitle = "Lexora Tech | Insights & News";
    $pageDesc = "Stay updated with the latest insights, news, and tutorials from Lexora Tech. Explore our blog for tech trends and digital solutions.";
    // This moves your blog CSS into the head for faster loading
    $extraCss = '<link rel="stylesheet" href="css/blog.css">'; 
    include "includes/head.php";
    ?>
</head>
<body>

    <div id="smooth-wrapper" class="mil-page-wrapper">
        <div class="mil-cursor-follower"></div>
        <div class="mil-progress-track"><div class="mil-progress"></div></div>

        <?php include "header.php"; ?>

        <div class="mil-transition-fade" id="swup">
            <div class="mil-transition-frame">

            <link rel="stylesheet" href="css/blog.css">

                <div id="smooth-content" class="mil-content">

                    <div class="mil-hero-1 mil-sm-hero mil-stl mil-up" id="top">
                        <div class="mil-overlay"></div>
                        <div class="container mil-hero-main mil-relative mil-aic">
                            <div class="mil-hero-text">
                                <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="#.">Blog</a></li>
                                </ul>
                                <h1 class="mil-display2 mil-rubber">Latest <span class="mil-a2">Insights</span></h1>
                                
                                <div class="search-trigger-wrapper" id="searchTriggerWrapper">
                                    <div class="glass-trigger-btn" id="searchTriggerBtn">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>

                                <div class="hero-search-container" id="searchContainer">
                                    <form id="searchForm" action="" method="GET" style="position: relative;">
                                        <input type="text" id="searchInput" class="glass-search-input" name="search" placeholder="Search articles, news, tutorials..." value="<?php echo htmlspecialchars($search_term); ?>" autocomplete="off">
                                        
                                        <button type="button" class="glass-close-btn" id="closeSearchBtn">
                                            <i class="fas fa-times"></i>
                                        </button>

                                        <button type="submit" class="glass-search-btn"><i class="fas fa-search"></i></button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="sections-wrapper <?php echo $is_search_active ? 'results-first' : ''; ?>" id="sectionsWrapper">
                        
                        <div class="mil-p-0-160" id="trending-section" style="background: #000; padding-top: 100px;">
                            <div class="container">
                                <div class="row mil-aie mil-mb30">
                                    <div class="col-md-6">
                                        <h2 class="mil-head1 mil-mb60 mil-up mil-light-heading">Trending <span class="mil-a2">Now</span></h2>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mil-nl-nav mil-up mil-mb60">
                                            <div class="mil-slider-btn mil-nl-prev mil-c-gone" style="border-color: #333;"></div>
                                            <div class="mil-slider-btn mil-nl-next mil-c-gone" style="border-color: #333;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-container mil-blog-slider">
                                    <div class="swiper-wrapper mil-c-swipe mil-c-light">
                                        <?php while ($row = mysqli_fetch_assoc($result_popular)) { ?>
                                            <div class="swiper-slide">
                                                <a href="publication.php?id=<?= $row['id']; ?>" class="lexora-card">
                                                    <div class="card-img-wrap">
                                                        <img src="uploads/<?= $row['cover_image']; ?>" alt="cover">
                                                    </div>
                                                    <div class="card-body-modern" style="padding: 20px;">
                                                         <div class="card-meta-modern">
                                                            <span class="meta-highlight"><i class="far fa-calendar"></i></span> 
                                                            <?= date("M d, Y", strtotime($row['created_at'])) ?>
                                                        </div>
                                                        <h4 class="card-title-modern" style="font-size: 18px; margin-bottom:0;"><?= $row['title']; ?></h4>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mil-blog-grid-section" id="grid-section">
                            <div class="container">
                                <div class="row mil-aie mil-mb40">
                                    <div class="col-md-12">
                                        <h2 class="mil-head3 mil-up mil-light-heading" id="resultsHeading">
                                            <?php echo empty($search_term) ? 'Recent Articles' : 'Search Results for: "' . $search_term . '"'; ?>
                                        </h2>
                                    </div>
                                </div>
                                
                                <div class="row" id="blogGridContainer">
                                    <?php 
                                    if (mysqli_num_rows($result_latest) > 0) {
                                        while ($row = mysqli_fetch_assoc($result_latest)) { 
                                    ?>
                                        <div class="col-lg-4 col-md-6 mil-mb40">
                                            <div class="lexora-card">
                                                <div class="card-img-wrap">
                                                    <img src="uploads/<?= $row['cover_image']; ?>" alt="cover">
                                                </div>
                                                
                                                <div class="card-body-modern">
                                                    <div class="card-meta-modern">
                                                        <span class="meta-highlight">Blog</span> 
                                                        <span>•</span> 
                                                        <span><?= estimateReadTime($row['heading']); ?></span>
                                                    </div>
                                                    <a href="publication.php?id=<?= $row['id']; ?>">
                                                        <h4 class="card-title-modern"><?= $row['title']; ?></h4>
                                                    </a>
                                                    <p class="card-excerpt-modern"><?= substr(strip_tags($row['heading']), 0, 110); ?>...</p>
                                                    <a href="publication.php?id=<?= $row['id']; ?>" class="card-link-modern">
                                                        Read Article <i class="fas fa-arrow-right" style="transform: rotate(-45deg);"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php 
                                        }
                                    } else {
                                        echo '<div class="col-12 no-results" style="padding: 100px 0; text-align:center; color: #666;"><h4 class="mil-head4 mil-light-heading">No articles found.</h4></div>';
                                    }
                                    ?>
                                </div>

                                <div id="searchLoader" class="search-loader">
                                    <i class="fas fa-spinner fa-spin fa-2x"></i>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="mil-blog-grid-section" style="padding-top: 0; padding-bottom: 20px;">
                        <div class="container">
                            <div class="mil-blog-pagination" id="paginationContainer">
                                <?php if ($total_pages > 1): ?>
                                <ul>
                                    <?php if ($page > 1): ?>
                                        <li><a href="<?= pageUrl($page - 1, $search_term) ?>"><i class="fas fa-chevron-left"></i></a></li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="<?= $i == $page ? 'mil-active' : '' ?>">
                                            <a href="<?= pageUrl($i, $search_term) ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <li><a href="<?= pageUrl($page + 1, $search_term) ?>"><i class="fas fa-chevron-right"></i></a></li>
                                    <?php endif; ?>
                                </ul>
                                <?php endif; ?>
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
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        
        const triggerBtn = document.getElementById('searchTriggerBtn');
        const triggerWrapper = document.getElementById('searchTriggerWrapper');
        const searchContainer = document.getElementById('searchContainer');
        const closeSearchBtn = document.getElementById('closeSearchBtn');

        const gridContainer = document.getElementById('blogGridContainer');
        const heading = document.getElementById('resultsHeading');
        const paginationContainer = document.getElementById('paginationContainer');
        const loader = document.getElementById('searchLoader');
        const sectionsWrapper = document.getElementById('sectionsWrapper'); // New Wrapper
        
        let timeout = null;

        if(triggerBtn && searchContainer) {
            triggerBtn.addEventListener('click', function() {
                triggerWrapper.style.display = 'none';
                searchContainer.classList.add('active');
                setTimeout(() => searchInput.focus(), 100);
            });
        }

        if(closeSearchBtn) {
            closeSearchBtn.addEventListener('click', function() {
                searchContainer.classList.remove('active');
                
                if (searchInput.value.trim() !== '') {
                    searchInput.value = '';
                    performSearch(''); // Reset to Recent Blogs
                }

                setTimeout(() => {
                    triggerWrapper.style.display = 'flex';
                }, 300);
            });
        }

        const urlParams = new URLSearchParams(window.location.search);
        if(urlParams.has('search') && urlParams.get('search').trim() !== '') {
            triggerWrapper.style.display = 'none';
            searchContainer.classList.add('active');
        }

        const performSearch = (query) => {
            loader.style.display = 'block';
            gridContainer.style.opacity = '0.3'; 

            if (query.trim() !== '') {
                sectionsWrapper.classList.add('results-first');
            } else {
                sectionsWrapper.classList.remove('results-first');
            }

            const timestamp = new Date().getTime();
            const fetchUrl = `?search=${encodeURIComponent(query)}&t=${timestamp}`;

            fetch(fetchUrl)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    const newGrid = doc.getElementById('blogGridContainer');
                    if (newGrid) gridContainer.innerHTML = newGrid.innerHTML;

                    const newHeading = doc.getElementById('resultsHeading');
                    if (newHeading) heading.innerHTML = newHeading.innerHTML;

                    const newPagination = doc.getElementById('paginationContainer');
                    if (newPagination) paginationContainer.innerHTML = newPagination.innerHTML;
                    else paginationContainer.innerHTML = '';

                    const newUrl = query ? `?search=${encodeURIComponent(query)}` : window.location.pathname;
                    window.history.pushState({path: newUrl}, '', newUrl);

                    setTimeout(() => {
                        if (typeof ScrollTrigger !== 'undefined') {
                            ScrollTrigger.refresh();
                        }
                    }, 100); 
                })
                .catch(err => console.error('Search failed', err))
                .finally(() => {
                    loader.style.display = 'none';
                    gridContainer.style.opacity = '1';
                });
        };

        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            const query = this.value;
            timeout = setTimeout(() => {
                performSearch(query);
            }, 500);
        });

        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            performSearch(searchInput.value);
        });
    });
    </script>

</body>
</html>