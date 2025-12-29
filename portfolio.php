<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $pageTitle = "Lexora Tech | Portfolio";
    $pageDesc = "A showcase of our selected works including high-performance web applications, POS systems, and digital experiences.";
    include "includes/head.php";
    $extraCss = '<link rel="stylesheet" href="css/portfolio.css">'; 
    ?>
</head>
<body>

    <div id="smooth-wrapper" class="mil-page-wrapper">
        <div class="mil-cursor-follower"></div>
        <div class="mil-progress-track"><div class="mil-progress"></div></div>

        <?php include "header.php"; ?>

        <div class="mil-transition-fade" id="swup">
            <div class="mil-transition-frame">

            <link rel="stylesheet" href="css/portfolio.css">

                <div id="smooth-content" class="mil-content">

                    <div class="mil-hero-1 mil-sm-hero mil-stl mil-up" id="top">
                        <div class="mil-overlay"></div>
                        <div class="container mil-hero-main mil-relative mil-aic">
                            <div class="mil-hero-text">
                                <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="#.">Portfolio</a></li>
                                </ul>
                                <h1 class="mil-display2 mil-rubber">Selected <span class="mil-a2">Works</span></h1>
                                <p class="mil-mt30" style="color: #888; max-width: 500px;">A showcase of high-performance web applications, POS systems, and digital experiences.</p>
                            </div>
                        </div>
                    </div>
                    <div class="mil-p-0-130">
                        <div class="container">
                            
                            <div class="filter-menu mil-up">
                                <button class="filter-btn active" onclick="filterProjects('all')">All Projects</button>
                                <button class="filter-btn" onclick="filterProjects('web')">Web Dev</button>
                                <button class="filter-btn" onclick="filterProjects('pos')">POS Systems</button>
                                <button class="filter-btn" onclick="filterProjects('app')">Mobile Apps</button>
                                <button class="filter-btn" onclick="filterProjects('design')">UI/UX</button>
                            </div>

                            <div class="row">
                                
                                <div class="col-md-6 project-item web">
                                    <div class="mil-work-card mil-stl mil-mb30">
                                        <div class="mil-cover mil-port mil-up">
                                            <div class="mil-hover-frame">
                                                <img src="img/works/1/cl1.png" alt="cover" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                            </div>
                                        </div>
                                        <div class="mil-hover-overlay">
                                            <a href="project1.php" class="mil-descr">
                                                <div class="mil-text-frame">
                                                    <h4 class="mil-head4 mil-mb15">Missed Lesson Project</h4>
                                                    <p style="color:#ccc; font-size:14px;">An automated system for managing student attendance and lessons.</p>
                                                    <div class="tech-badge-container">
                                                        <span class="tech-badge">PHP</span>
                                                        <span class="tech-badge">MySQL</span>
                                                        <span class="tech-badge">Bootstrap</span>
                                                    </div>
                                                </div>
                                                <div class="mil-stylized-btn mil-a1">
                                                    <i class="fal fa-arrow-up"></i>
                                                    <span>View Case</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 project-item web">
                                    <div class="mil-work-card mil-stl mil-mb30">
                                        <div class="mil-cover mil-land mil-up">
                                            <div class="mil-hover-frame">
                                                <img src="img/works/4/c2.png" alt="cover" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                            </div>
                                        </div>
                                        <div class="mil-hover-overlay">
                                            <a href="project2.php" class="mil-descr">
                                                <div class="mil-text-frame">
                                                    <h4 class="mil-head4 mil-mb15">EAP Service Platform</h4>
                                                    <p style="color:#ccc; font-size:14px;">Sri Lanka's First Employee Assistance Program platform.</p>
                                                    <div class="tech-badge-container">
                                                        <span class="tech-badge">Laravel</span>
                                                        <span class="tech-badge">Vue.js</span>
                                                        <span class="tech-badge">AWS</span>
                                                    </div>
                                                </div>
                                                <div class="mil-stylized-btn mil-a1">
                                                    <i class="fal fa-arrow-up"></i>
                                                    <span>View Case</span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mil-p-0-160">
                        <div class="container">
                            <div class="cta-card mil-up">
                                <div class="cta-content">
                                    <h2 class="cta-title">Have a vision?<br>Let’s build <span class="cta-highlight">something great.</span></h2>
                                    <p class="cta-desc">
                                        From custom web platforms to complex POS systems, I engineer solutions that scale. 
                                        Ready to turn your idea into a high-performance reality?
                                    </p>
                                    <a href="contact.php" class="cta-btn-modern">
                                        Start A Project <i class="fas fa-arrow-right"></i>
                                    </a>
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
        function filterProjects(category) {
            // Update active button state
            const buttons = document.querySelectorAll('.filter-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Filter items
            const items = document.querySelectorAll('.project-item');
            items.forEach(item => {
                if (category === 'all' || item.classList.contains(category)) {
                    item.classList.remove('hide');
                    item.classList.add('show');
                    setTimeout(() => {
                        item.style.display = 'block';
                    }, 10);
                } else {
                    item.classList.remove('show');
                    item.classList.add('hide');
                    setTimeout(() => {
                        item.style.display = 'none';
                    }, 400);
                }
            });
            
            // Refresh ScrollTrigger to fix spacing
            setTimeout(() => {
                if(typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh();
            }, 500);
        }
    </script>

</body>
</html>