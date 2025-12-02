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
    <title>Lexora Tech | Projects</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.png" />

    <style>
        /* --- MODERN PROJECT FILTERS --- */
        .filter-menu {
            display: flex;
            gap: 15px;
            margin-bottom: 60px;
            flex-wrap: wrap;
        }
        .filter-btn {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.1);
            color: #888;
            padding: 10px 25px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .filter-btn:hover, .filter-btn.active {
            background: #ffb400; /* Main Theme Yellow/Gold */
            color: #000;
            border-color: #ffb400;
        }

        /* --- TECH STACK BADGES --- */
        .tech-badge-container {
            display: flex;
            gap: 8px;
            margin-top: 15px;
            flex-wrap: wrap;
        }
        .tech-badge {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(5px);
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 10px;
            color: #fff;
            text-transform: uppercase;
            font-weight: 700;
            border: 1px solid rgba(255,255,255,0.1);
        }

        /* --- PROJECT CARD TWEAKS --- */
        .mil-work-card {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
        }
        .mil-work-card .mil-cover {
            border-radius: 15px;
        }
        
        /* Hide items when filtering */
        .project-item { transition: all 0.4s ease; }
        .project-item.hide { display: none; }
        .project-item.show { animation: fadeIn 0.5s ease; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- MODERN CALL TO ACTION (CTA) - ORANGE EDITION --- */
        .cta-card {
            background: linear-gradient(145deg, #111 0%, #0a0a0a 100%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 24px;
            padding: 80px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Ambient Glow Background (Updated to Orange) */
        .cta-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            /* Changed to Orange Glow */
            background: radial-gradient(circle, rgba(255, 102, 0, 0.12) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        .cta-content { position: relative; z-index: 1; }
        
        .cta-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 25px;
        }
        /* Highlight Text (Updated to Orange) */
        .cta-highlight { color: #ff6600; } 
        
        .cta-desc {
            color: #999;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 45px auto;
            line-height: 1.6;
        }

        /* Button (Updated to Orange) */
        .cta-btn-modern {
            padding: 18px 45px;
            background: #ff6600; /* Vibrant Orange */
            color: #fff; /* White text looks better on orange */
            font-weight: 700;
            font-size: 16px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(255, 102, 0, 0.25); /* Orange Shadow */
        }
        .cta-btn-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(255, 102, 0, 0.4);
            background: #e65c00; /* Darker Orange on Hover */
            color: #fff;
        }

        @media (max-width: 768px) {
            .cta-title { font-size: 2.2rem; }
            .cta-card { padding: 50px 20px; }
        }
    </style>

</head>

<body>

    <div id="smooth-wrapper" class="mil-page-wrapper">
        <div class="mil-cursor-follower"></div>
        <div class="mil-progress-track"><div class="mil-progress"></div></div>

        <?php include "header.php"; ?>

        <div class="mil-transition-fade" id="swup">
            <div class="mil-transition-frame">
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