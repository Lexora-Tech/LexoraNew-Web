<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="css/plugins/bootstrap-grid.css">
    <link rel="stylesheet" href="css/plugins/fontawesome.min.css">
    <link rel="stylesheet" href="css/plugins/swiper.min.css">
    <link rel="stylesheet" href="css/style-stylish.css">
    <title>Lexora Tech | Template Showcase</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.png" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        /* --- PREMIUM CUSTOM STYLES --- */
        
        /* 1. Glassmorphism Filter Bar - XL VERSION */
        .glass-filter-container {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            
            /* Bigger Container Dimensions */
            border-radius: 80px; 
            padding: 25px 40px; 
            max-width: 1300px; 
            
            display: inline-flex;
            flex-wrap: wrap;
            gap: 15px; /* More breathing room between buttons */
            margin-bottom: 80px;
            justify-content: center;
        }

        .glass-btn {
            background: transparent;
            border: none;
            color: #999; /* Slightly lighter grey for better contrast on dark */
            
            /* Bigger Buttons */
            padding: 16px 35px; 
            font-size: 16px; 
            
            border-radius: 50px;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.4s ease;
            white-space: nowrap;
        }

        .glass-btn:hover {
            color: #fff;
            background: rgba(255,255,255,0.05);
            transform: translateY(-2px); /* Subtle lift effect */
        }

        .glass-btn.active {
            background: #fff;
            color: #000;
            box-shadow: 0 10px 25px rgba(255, 255, 255, 0.15); /* Stronger glow */
            font-weight: 600;
            transform: translateY(-2px);
        }

        /* 2. Browser Window Card Design */
        .browser-card {
            background: #111;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.27), box-shadow 0.4s ease;
            position: relative;
            height: 100%;
        }

        .browser-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* The "Browser Bar" at the top of the image */
        .browser-header {
            background: #1a1a1a;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .browser-dots {
            display: flex;
            gap: 6px;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }
        .dot-red { background: #ff5f56; }
        .dot-yellow { background: #ffbd2e; }
        .dot-green { background: #27c93f; }

        .browser-address {
            margin-left: 15px;
            background: #000;
            height: 6px;
            width: 60%;
            border-radius: 4px;
            opacity: 0.3;
        }

        /* Image Container */
        .browser-body {
            height: 250px;
            overflow: hidden;
            position: relative;
        }

        .browser-body img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .browser-card:hover .browser-body img {
            transform: scale(1.05);
        }

        /* Content Area */
        .card-content {
            padding: 30px;
        }

        .card-category {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #666;
            margin-bottom: 10px;
            display: block;
            font-weight: 600;
        }

        .card-title {
            font-family: 'Inter', sans-serif;
            font-size: 22px;
            color: #fff;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .card-desc {
            color: #888;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
            font-weight: 300;
        }

        /* Tech Tags */
        .tech-stack {
            display: flex;
            gap: 8px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .tech-tag {
            font-size: 11px;
            padding: 4px 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            color: #aaa;
            background: rgba(255, 255, 255, 0.02);
        }

        /* Launch Button */
        .launch-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 12px 0;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            color: #fff;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .launch-btn:hover {
            color: #2ed573; /* Green accent color */
        }

        .launch-icon {
            transform: rotate(-45deg);
            transition: transform 0.3s ease;
        }

        .browser-card:hover .launch-icon {
            transform: rotate(0deg) translateX(5px);
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

                    <div class="mil-hero-1 mil-sm-hero mil-up" id="top" style="padding-top: 160px; padding-bottom: 60px;">
                        <div class="container mil-relative">
                            <div class="row">
                                <div class="col-lg-8">
                                    <span class="mil-link mil-mb30" style="color: #666; letter-spacing: 2px; text-transform: uppercase;">Lexora Tech Portfolio</span>
                                    <h1 class="mil-display2 mil-mb30" style="font-family: 'Inter', sans-serif; letter-spacing: -2px;">Digital <span style="color: #555;">Solutions.</span></h1>
                                    <p style="color: #999; font-size: 18px; line-height: 1.6; max-width: 600px;">
                                        Enterprise-grade website templates designed for scalability, speed, and conversion. 
                                        Select a category to view the live interactive prototype.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mil-p-0-130">
                        <div class="container">
                            
                            <div class="mil-center mil-up">
                                <div class="glass-filter-container">
                                    <button class="glass-btn active" onclick="filterProjects('all')">All</button>
                                    <button class="glass-btn" onclick="filterProjects('tourism')">Hospitality</button>
                                    <button class="glass-btn" onclick="filterProjects('professional')">Medical</button>
                                    <button class="glass-btn" onclick="filterProjects('trades')">Automotive</button>
                                    <button class="glass-btn" onclick="filterProjects('lifestyle')">Lifestyle</button>
                                    <button class="glass-btn" onclick="filterProjects('ecommerce')">Retail</button>
                                    <button class="glass-btn" onclick="filterProjects('realestate')">Real Estate</button>
                                    <button class="glass-btn" onclick="filterProjects('education')">Education</button>
                                    <button class="glass-btn" onclick="filterProjects('corporate')">Corporate</button>
                                    <button class="glass-btn" onclick="filterProjects('dining')">Dining</button>
                                    <button class="glass-btn" onclick="filterProjects('fitness')">Fitness</button>
                                    <button class="glass-btn" onclick="filterProjects('nonprofit')">Non-Profit</button>
                                    <button class="glass-btn" onclick="filterProjects('creative')">Creative</button>
                                    <button class="glass-btn" onclick="filterProjects('travel')">Travel Agency</button>
                                </div>
                            </div>

                            <div class="row">
                                
                                <div class="col-lg-4 col-md-6 mil-mb60 project-item tourism mil-up">
                                    <a href="demos/tourism-villa/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Villa">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Hospitality</span>
                                                <h3 class="card-title">The Hillside Retreat</h3>
                                                <p class="card-desc">A zero-commission booking engine for luxury villas. Features virtual tours and local guide integration.</p>
                                                <div class="tech-stack"><span class="tech-tag">Booking Engine</span><span class="tech-tag">Map API</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item professional mil-up">
                                    <a href="demos/medical-pro/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Clinic">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Medical</span>
                                                <h3 class="card-title">Apex Dental Care</h3>
                                                <p class="card-desc">Patient management portal with appointment scheduling and automated reminders.</p>
                                                <div class="tech-stack"><span class="tech-tag">Secure Forms</span><span class="tech-tag">Profile Mgmt</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item trades mil-up">
                                    <a href="demos/auto-repair/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1486006920555-c77dcf18193c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Auto">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Automotive</span>
                                                <h3 class="card-title">AutoMaster Pro</h3>
                                                <p class="card-desc">Service catalog and emergency breakdown assistance system with geolocation.</p>
                                                <div class="tech-stack"><span class="tech-tag">Geolocation</span><span class="tech-tag">Service API</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item lifestyle mil-up">
                                    <a href="demos/salon-elite/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1600948836101-f9ffda59d250?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Salon">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Lifestyle</span>
                                                <h3 class="card-title">Luxe Salon & Spa</h3>
                                                <p class="card-desc">High-performance visual gallery with Instagram feed integration and pricing tiers.</p>
                                                <div class="tech-stack"><span class="tech-tag">Instagram API</span><span class="tech-tag">React</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item ecommerce mil-up">
                                    <a href="demos/kandy-bakes/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1555507036-ab1f4038808a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Bakery">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Retail</span>
                                                <h3 class="card-title">Artisan Bakery</h3>
                                                <p class="card-desc">Digital catalog mode with seamless WhatsApp ordering integration for local commerce.</p>
                                                <div class="tech-stack"><span class="tech-tag">WhatsApp API</span><span class="tech-tag">Catalog</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item realestate mil-up">
                                    <a href="demos/real-estate/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Modern House">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Real Estate</span>
                                                <h3 class="card-title">Skyline Properties</h3>
                                                <p class="card-desc">Property listing portal featuring 360° virtual tours, agent dashboards, and advanced map filtering.</p>
                                                <div class="tech-stack"><span class="tech-tag">Virtual Tour</span><span class="tech-tag">Map Search</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item education mil-up">
                                    <a href="demos/lms-edu/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Education">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Education</span>
                                                <h3 class="card-title">EduSphere LMS</h3>
                                                <p class="card-desc">Complete Learning Management System for tuition centers. Includes video hosting, quiz modules, and student progress tracking.</p>
                                                <div class="tech-stack"><span class="tech-tag">Video Streaming</span><span class="tech-tag">Student Portal</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item corporate mil-up">
                                    <a href="demos/finance-corp/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Corporate Office">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Corporate</span>
                                                <h3 class="card-title">NexGen Consulting</h3>
                                                <p class="card-desc">High-trust corporate profile with investor relation pages, secure client login areas, and financial data visualization.</p>
                                                <div class="tech-stack"><span class="tech-tag">Data Viz</span><span class="tech-tag">Secure Login</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item dining mil-up">
                                    <a href="demos/restaurant/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Restaurant Interior">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Food & Dining</span>
                                                <h3 class="card-title">The Urban Bistro</h3>
                                                <p class="card-desc">Interactive digital menu with table reservation system integration and event booking capabilities.</p>
                                                <div class="tech-stack"><span class="tech-tag">Reservations</span><span class="tech-tag">QR Menu</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item fitness mil-up">
                                    <a href="demos/fitness-gym/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Gym">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Fitness</span>
                                                <h3 class="card-title">IronPhysique Gym</h3>
                                                <p class="card-desc">Membership portal with recurring payments, class schedule calendar, and BMI calculator tools.</p>
                                                <div class="tech-stack"><span class="tech-tag">Membership</span><span class="tech-tag">Schedule API</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item nonprofit mil-up">
                                    <a href="demos/charity/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Charity">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Non-Profit</span>
                                                <h3 class="card-title">Hope Foundation</h3>
                                                <p class="card-desc">Trust-building design with transparent donation gateways, volunteer registration, and impact reports.</p>
                                                <div class="tech-stack"><span class="tech-tag">Donations</span><span class="tech-tag">Volunteer DB</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item creative mil-up">
                                    <a href="demos/photography/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1452587925148-ce544e77e70d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Photography">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Creative</span>
                                                <h3 class="card-title">Momentum Studios</h3>
                                                <p class="card-desc">Minimalist masonry gallery for photographers and agencies. Features client proofing area.</p>
                                                <div class="tech-stack"><span class="tech-tag">Masonry Grid</span><span class="tech-tag">Lightbox</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item travel mil-up">
                                    <a href="demos/travel-agency/index.html" target="_blank" class="browser-card-link">
                                        <div class="browser-card">
                                            <div class="browser-header">
                                                <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                                <div class="browser-address"></div>
                                            </div>
                                            <div class="browser-body">
                                                <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Travel">
                                            </div>
                                            <div class="card-content">
                                                <span class="card-category">Travel</span>
                                                <h3 class="card-title">Wanderlust Tours</h3>
                                                <p class="card-desc">Package booking system with itinerary builder, dynamic pricing, and destination guides.</p>
                                                <div class="tech-stack"><span class="tech-tag">Itinerary</span><span class="tech-tag">Payment GW</span></div>
                                                <div class="launch-btn">Launch Preview <i class="fas fa-arrow-right launch-icon"></i></div>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-lg-4 col-md-6 mil-mb60 project-item all mil-up">
                                    <div class="browser-card" style="opacity: 0.5;">
                                        <div class="browser-header">
                                            <div class="browser-dots"><div class="dot dot-red"></div><div class="dot dot-yellow"></div><div class="dot dot-green"></div></div>
                                            <div class="browser-address"></div>
                                        </div>
                                        <div class="browser-body" style="background: #222; display: flex; align-items: center; justify-content: center;">
                                            <span style="color: #444; font-weight: 600;">Coming Soon</span>
                                        </div>
                                        <div class="card-content">
                                            <span class="card-category">Enterprise</span>
                                            <h3 class="card-title">Custom Solution</h3>
                                            <p class="card-desc">We are currently engineering a new solution for the legal sector.</p>
                                        </div>
                                    </div>
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
            // UI Update
            const buttons = document.querySelectorAll('.glass-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Filtering Logic
            const items = document.querySelectorAll('.project-item');
            items.forEach(item => {
                if (category === 'all' || item.classList.contains(category)) {
                    item.style.display = 'block';
                    // Small GSAP animation for smooth reveal
                    gsap.fromTo(item, {opacity: 0, y: 20}, {opacity: 1, y: 0, duration: 0.4});
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Refresh ScrollTrigger
            setTimeout(() => {
                if(typeof ScrollTrigger !== 'undefined') ScrollTrigger.refresh();
            }, 500);
        }
    </script>

</body>
</html>