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
    <title>Lexora Tech | Missed Lesson Project</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.png" />
    <style>
        :root {
            /* Professional Neon Orange Accent */
            --accent: #ff5500;
            --accent-glow: rgba(255, 85, 0, 0.4);
            --bg-dark: #020204;
            /* Deeper black base */

            /* Darker, sleeker glass variables for professional look */
            --glass-bg: rgba(0, 0, 0, 0.2);
            /* Darker tint */
            --glass-border: rgba(255, 255, 255, 0.05);
            --glass-shine: rgba(255, 255, 255, 0.02);
            --text-muted: #9a9aae;
        }

        /* --- 1. DEEP DARK MODERN BACKGROUND --- */
        body {
            background-color: var(--bg-dark);
            color: #fff;
            font-family: 'Inter', sans-serif;
            /* Subtler, deeper mesh gradient for professional feel */
            background-image:
                radial-gradient(at 70% 20%, rgba(255, 85, 0, 0.08) 0px, transparent 60%),
                radial-gradient(at 20% 40%, rgba(30, 30, 90, 0.15) 0px, transparent 60%),
                radial-gradient(at 50% 80%, rgba(255, 85, 0, 0.05) 0px, transparent 60%);
            background-attachment: fixed;
            overflow-x: hidden;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* --- 2. REFINED DARK GLASS CARD --- */
        .glass-card {
            background: var(--glass-bg);
            /* High blur for premium feel */
            backdrop-filter: blur(30px) saturate(120%);
            -webkit-backdrop-filter: blur(30px) saturate(120%);
            border: 1px solid var(--glass-border);
            box-shadow:
                0 20px 40px rgba(0, 0, 0, 0.3),
                inset 0 1px 1px var(--glass-shine);
            border-radius: 24px;
            padding: 40px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            box-shadow:
                0 30px 60px rgba(0, 0, 0, 0.4),
                inset 0 1px 1px rgba(255, 255, 255, 0.08);
        }

        /* --- 3. HERO SECTION --- */
        .modern-split-hero {
            padding-top: 200px;
            padding-bottom: 120px;
            position: relative;
        }

        .hero-badge-group {
            display: flex;
            gap: 12px;
            margin-bottom: 35px;
        }

        .hero-badge {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 10px 20px;
            border-radius: 100px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            color: #fff;
            transition: 0.3s;
            backdrop-filter: blur(10px);
        }

        .hero-badge:hover {
            background: var(--accent);
            border-color: var(--accent);
            box-shadow: 0 5px 20px var(--accent-glow);
            transform: translateY(-2px);
        }

        .hero-title-gradient {
            font-size: 4.8rem;
            line-height: 1.05;
            font-weight: 900;
            letter-spacing: -2px;
            margin-bottom: 30px;
            /* Refined gradient */
            background: linear-gradient(135deg, #ffffff 0%, #b0b0b0 50%, #ff5500 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            color: var(--text-muted);
            font-size: 1.25rem;
            line-height: 1.7;
            max-width: 550px;
            font-weight: 400;
        }

        /* --- 4. SIDEBAR & TECH --- */
        .sticky-sidebar {
            position: sticky;
            top: 130px;
            z-index: 10;
        }

        .meta-item {
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            color: var(--accent);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-weight: 800;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .meta-value {
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.4;
        }

        .tech-stack-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .tech-pill {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--glass-border);
            color: var(--text-muted);
            padding: 8px 16px;
            border-radius: 100px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .tech-pill:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
            box-shadow: 0 5px 15px var(--accent-glow);
            transform: translateY(-2px);
        }

        .live-btn {
            background: var(--accent);
            color: #fff;
            padding: 18px;
            border-radius: 16px;
            font-weight: 800;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 13px;
            box-shadow: 0 10px 30px -5px var(--accent-glow);
        }

        .live-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 50px -10px var(--accent-glow);
            background: #ff661a;
            color: #fff;
        }

        /* --- 5. BROWSER MOCKUP --- */
        .case-study-text h3 {
            font-size: 2.5rem;
            margin-bottom: 25px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .case-study-text h4 {
            font-size: 1.6rem;
            margin-bottom: 20px;
            color: #fff;
            font-weight: 700;
        }

        .case-study-text p {
            color: var(--text-muted);
            font-size: 1.15rem;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .browser-mockup {
            border-radius: 16px;
            background: #121214;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            border: 1px solid var(--glass-border);
            margin-bottom: 30px;
            transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            z-index: 2;
        }

        /* Bloom effect */
        .browser-mockup::after {
            content: '';
            position: absolute;
            z-index: -1;
            top: 50%;
            left: 50%;
            width: 90%;
            height: 80%;
            transform: translate(-50%, -30%);
            background: var(--accent);
            filter: blur(80px);
            opacity: 0.1;
            transition: opacity 0.5s;
        }

        .browser-mockup:hover {
            transform: translateY(-8px);
        }

        .browser-mockup:hover::after {
            opacity: 0.2;
        }

        .browser-header {
            background: #1c1c1f;
            padding: 14px 18px;
            display: flex;
            gap: 8px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        .dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
        }

        .dot.red {
            background: #ff5f56;
        }

        .dot.yellow {
            background: #ffbd2e;
        }

        .dot.green {
            background: #27c93f;
        }

        .browser-body img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
        }

        /* --- 6. STATS --- */
        .stats-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin: 60px 0;
            padding: 20px 0;
            border-top: 1px solid var(--glass-border);
            border-bottom: 1px solid var(--glass-border);
        }

        .stat-card {
            text-align: left;
            flex: 1;
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: -2px;
            background: linear-gradient(to bottom right, #fff, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: block;
            margin-bottom: 5px;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            font-weight: 700;
        }

        /* --- 7. SWIPER GALLERY (UPDATED) --- */
        .project-slider {
            padding: 100px 0;
            width: 100%;
            position: relative;
        }

        .swiper-container {
            width: 100%;
            padding-top: 60px;
            padding-bottom: 60px;
        }

        .swiper-slide {
            width: 65%;
            height: 450px;
            /* Inactive slides are darker */
            opacity: 0.4;
            filter: brightness(0.7);
            transition: all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            transform: scale(0.85) translateY(30px);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid transparent;
            position: relative;
        }

        .swiper-slide-active {
            opacity: 1;
            filter: brightness(1);
            transform: scale(1) translateY(0);
            z-index: 10;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .slide-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Swiper Pagination Dots Styling */
        .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.3;
        }

        .swiper-pagination-bullet-active {
            background: var(--accent);
            opacity: 1;
        }

        /* --- 8. FOOTER & TESTIMONIAL --- */
        .testimonial-card {
            position: relative;
            margin-top: 80px;
        }

        .quote-icon {
            font-size: 50px;
            color: var(--accent);
            opacity: 0.2;
            position: absolute;
            top: 30px;
            left: 30px;
        }

        .testimonial-text {
            font-size: 1.2rem;
            font-style: italic;
            color: #eee;
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
            line-height: 1.6;
            font-weight: 500;
        }

        @media (max-width: 992px) {
            .modern-split-hero {
                padding-top: 140px;
                text-align: center;
            }

            .hero-badge-group {
                justify-content: center;
            }

            .hero-title-gradient {
                font-size: 3.5rem;
            }

            .hero-desc {
                margin: 0 auto;
            }

            .stats-container {
                flex-direction: column;
                gap: 40px;
                text-align: center;
            }

            .stat-card {
                text-align: center;
            }

            .tech-stack-grid {
                justify-content: center;
            }

            .swiper-slide {
                width: 85%;
                height: 300px;
            }

            .modern-next-project {
                padding: 80px 0 !important;
            }

            .np-big-title {
                font-size: 2.5rem !important;
            }
        }

        /* --- 9. MODERN SMALLER NEXT PROJECT REVEAL --- */
        .modern-next-project {
            position: relative;
            display: block;
            text-decoration: none;
            overflow: hidden;
            /* REDUCED PADDING FOR SMALLER HEIGHT */
            padding: 100px 0;
            background: #000;
            border-top: 1px solid var(--glass-border);
            cursor: pointer;
        }

        /* The Background Image Layer */
        .np-bg-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Placeholder image for next project */
            background-image: url('./img/works/nextProject/01.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.2;
            /* Dim initially */
            filter: grayscale(100%) blur(5px);
            /* Black & White + Blur */
            transition: all 0.8s cubic-bezier(0.19, 1, 0.22, 1);
            transform: scale(1.05);
            z-index: 0;
        }

        .modern-next-project:hover .np-bg-layer {
            opacity: 0.5;
            filter: grayscale(0%) blur(0px);
            transform: scale(1.0);
        }

        /* Content Layer */
        .np-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .np-subtitle {
            display: inline-block;
            color: var(--accent);
            font-size: 11px;
            /* Smaller font */
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 15px;
            /* Less margin */
            padding: 6px 14px;
            border: 1px solid rgba(255, 85, 0, 0.3);
            border-radius: 50px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            transition: 0.3s;
        }

        .modern-next-project:hover .np-subtitle {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
        }

        .np-big-title {
            /* SIGNIFICANTLY SMALLER TITLE */
            font-size: 3.5rem;
            font-weight: 900;
            color: #fff;
            margin: 0;
            line-height: 1.1;
            letter-spacing: -1px;
            -webkit-text-stroke: 1px rgba(255, 255, 255, 0.1);
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: transform 0.4s ease, letter-spacing 0.4s ease;
        }

        .modern-next-project:hover .np-big-title {
            transform: scale(1.02);
            letter-spacing: 0px;
        }

        /* The Magnetic Circle Button - SMALLER */
        .np-arrow-circle {
            width: 60px;
            /* Reduced from 90px */
            height: 60px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 30px auto 0;
            /* Reduced margin */
            font-size: 20px;
            /* Smaller Icon */
            color: #fff;
            transition: all 0.5s cubic-bezier(0.25, 1, 0.5, 1);
            background: rgba(255, 255, 255, 0.02);
            position: relative;
        }

        .modern-next-project:hover .np-arrow-circle {
            background: var(--accent);
            border-color: var(--accent);
            transform: translateY(5px) scale(1.1);
            box-shadow: 0 0 40px var(--accent-glow);
        }

        .np-arrow-circle i {
            transition: transform 0.4s;
        }

        .modern-next-project:hover .np-arrow-circle i {
            transform: rotate(-45deg);
        }
    </style>

</head>

<body>

    <div id="smooth-wrapper" class="mil-page-wrapper">
        <div class="mil-cursor-follower"></div>
        <div class="mil-progress-track">
            <div class="mil-progress"></div>
        </div>

        <?php include "header.php"; ?>

        <div class="mil-transition-fade" id="swup">
            <div class="mil-transition-frame">
                <div id="smooth-content" class="mil-content">

                    <section class="modern-split-hero mil-up">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-6 mb-5 mb-lg-0">
                                    <div class="hero-badge-group">
                                        <div class="hero-badge">Web Development</div>
                                        <div class="hero-badge">Education Tech</div>
                                    </div>
                                    <h1 class="hero-title-gradient">Missed Lesson<br>System</h1>
                                    <p class="hero-desc">
                                        A centralized digital platform engineered to ensure educational continuity and safety for children in Sri Lanka.
                                        Transforming manual processes into a secure, high-speed digital ecosystem.
                                    </p>
                                </div>
                                <div class="col-lg-6">
                                    <div class="browser-mockup mil-up">
                                        <div class="browser-header">
                                            <div class="dot red"></div>
                                            <div class="dot yellow"></div>
                                            <div class="dot green"></div>
                                        </div>
                                        <div class="browser-body">
                                            <img src="img/works/1/cl1.png" alt="Magaharunupaadama Dashboard main screen">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="mil-p-0-100" style="padding-top: 20px;">
                        <div class="container">
                            <div class="row flex-sm-row-reverse">

                                <div class="col-lg-4">
                                    <div class="sticky-sidebar mil-up">
                                        <div class="glass-card">
                                            <div class="meta-item">
                                                <span class="meta-label">Client</span>
                                                <div class="meta-value">Mr. Chathuranga Rajapaksha</div>
                                            </div>
                                            <div class="meta-item">
                                                <span class="meta-label">Timeline</span>
                                                <div class="meta-value">Jan 25 - Feb 05, 2025</div>
                                            </div>
                                            <div class="meta-item">
                                                <span class="meta-label">Role</span>
                                                <div class="meta-value">Full-Stack Architect</div>
                                            </div>
                                            <div class="meta-item">
                                                <span class="meta-label">Tech Stack</span>
                                                <div class="tech-stack-grid">
                                                    <div class="tech-pill">PHP 8</div>
                                                    <div class="tech-pill">MySQL</div>
                                                    <div class="tech-pill">Bootstrap 5</div>
                                                    <div class="tech-pill">jQuery</div>
                                                    <div class="tech-pill">HTML5</div>
                                                    <div class="tech-pill">CSS3</div>
                                                </div>
                                            </div>

                                            <div style="margin-top: 40px; border-top: 1px solid var(--glass-border); padding-top: 30px;">
                                                <a href="https://magaharunupaadama.com" target="_blank" class="live-btn">
                                                    Launch Project <i class="fas fa-rocket"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 case-study-text">

                                    <div class="mil-mb60 mil-up">
                                        <h3>Safe Future For <span style="color:var(--accent);">Children</span></h3>
                                        <p>
                                            Magaharunupaadama is a child-focused initiative dedicated to creating a safe future for children in Sri Lanka.
                                            Prior to this project, the client relied on fragmented communication channels. We consolidated their mission into a robust web platform.
                                        </p>
                                    </div>

                                    <div class="stats-container mil-up">
                                        <div class="stat-card">
                                            <span class="stat-number">100%</span>
                                            <span class="stat-label">Digitized Workflow</span>
                                        </div>
                                        <div class="stat-card">
                                            <span class="stat-number">24/7</span>
                                            <span class="stat-label">System Uptime</span>
                                        </div>
                                        <div class="stat-card">
                                            <span class="stat-number">SSL</span>
                                            <span class="stat-label">Secured Platform</span>
                                        </div>
                                    </div>

                                    <div class="mil-mb60 mil-up">
                                        <h4>The Solution</h4>
                                        <p>
                                            We engineered a custom PHP-based platform serving as a secure digital hub. The system features a custom Content Management System (CMS) allowing non-technical staff to update safety guidelines in real-time.
                                        </p>
                                    </div>

                                    <div class="mil-mb60 mil-up">
                                        <div class="browser-mockup">
                                            <div class="browser-header">
                                                <div class="dot red"></div>
                                                <div class="dot yellow"></div>
                                                <div class="dot green"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1000&auto=format&fit=crop" alt="Mobile Learning Interface">
                                            </div>
                                        </div>
                                        <p class="text-center" style="font-size: 0.9rem; margin-top: -20px; color: var(--text-muted);">Fully responsive design optimized for mobile learning.</p>
                                    </div>

                                    <div class="mil-mb60 mil-up">
                                        <h4>Development Journey</h4>
                                        <p>
                                            Using pure PHP and MySQL, we built a lightweight application without the bloat of heavy frameworks, ensuring specific customization for the Sri Lankan educational context.
                                        </p>
                                    </div>

                                    <div class="glass-card testimonial-card mil-up">
                                        <i class="fas fa-quote-left quote-icon"></i>
                                        <p class="testimonial-text">
                                            "This platform has completely transformed how we share resources. It is fast, secure, and exactly what we needed to reach more students effectively."
                                        </p>
                                        <div style="display: flex; align-items: center; gap: 15px;">
                                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #333, #555); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #fff; border: 2px solid var(--accent);">CR</div>
                                            <div>
                                                <strong style="display:block; color:#fff; font-size: 1.1rem;">Chathuranga Rajapaksha</strong>
                                                <span style="font-size:0.85rem; color:var(--text-muted); letter-spacing: 1px;">Founder, Magaharunupaadama</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="project-slider mil-up">
                        <div class="container">
                            <h4 style="text-align: center; margin-bottom: 50px; color: #fff; font-size: 2rem;">Project Gallery</h4>
                        </div>
                        <div class="swiper-container mySwiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="./img/works/1/01.jpg" class="slide-img" alt="System Analytics Dashboard UI">
                                </div>
                                <div class="swiper-slide">
                                    <img src="./img/works/1/02.jpg" class="slide-img" alt="Professional team collaborating on digital platform">
                                </div>
                                <div class="swiper-slide">
                                    <img src="./img/works/1/03.jpg" class="slide-img" alt="Modern workspace displaying data">
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                    <a href="project2.php" class="modern-next-project mil-up">
                        <div class="np-bg-layer"></div>

                        <div class="container np-content">
                            <span class="np-subtitle">Next Case Study</span>
                            <h2 class="np-big-title">EAP Service<br>Platform</h2>

                            <div class="np-arrow-circle">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>

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
            var swiper = new Swiper(".mySwiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 35,
                    stretch: 0,
                    depth: 120,
                    modifier: 1,
                    slideShadows: true,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                initialSlide: 1,
                loop: true,
                speed: 700
            });
        });
    </script>

</body>

</html>