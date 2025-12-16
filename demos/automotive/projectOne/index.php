<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redline Automotive | Performance & Repair</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Rajdhani:wght@500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- 1. DESIGN SYSTEM --- */
        :root {
            /* Palette */
            --bg-body: #0a0a0a;
            /* Carbon Black */
            --bg-surface: #121212;
            /* Dark Grey */
            --bg-card: #1a1a1a;
            /* Lighter Grey */
            --bg-glass: rgba(10, 10, 10, 0.85);

            --text-main: #ffffff;
            --text-muted: #a3a3a3;

            --primary: #ef4444;
            /* Velocity Red */
            --primary-dark: #dc2626;
            --accent: #f5f5f5;
            /* Silver/Chrome */

            --border: 1px solid rgba(255, 255, 255, 0.1);

            /* Gradients */
            --gradient-red: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            --gradient-dark: linear-gradient(180deg, rgba(10, 10, 10, 0) 0%, #0a0a0a 100%);

            /* Typography */
            --font-head: 'Rajdhani', sans-serif;
            --font-body: 'Inter', sans-serif;

            /* Effects */
            --shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
            --ease: cubic-bezier(0.22, 1, 0.36, 1);
        }

        /* --- 2. RESET --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: var(--font-body);
            line-height: 1.6;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: var(--font-head);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.1;
        }

        h1 {
            font-size: clamp(3rem, 8vw, 6rem);
        }

        h2 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            margin-bottom: 20px;
        }

        p {
            color: var(--text-muted);
            margin-bottom: 24px;
            font-size: 1rem;
            max-width: 600px;
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: 0.3s;
        }

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        ul {
            list-style: none;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .text-center {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .text-red {
            color: var(--primary);
        }

        /* --- 3. COMPONENTS --- */

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 36px;
            font-family: var(--font-head);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s var(--ease);
            border: none;
            font-size: 1rem;
            clip-path: polygon(15px 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%, 0 15px);
            /* Tech Shape */
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(239, 68, 68, 0.4);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(255, 255, 255, 0.05);
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            background: rgba(239, 68, 68, 0.1);
            color: var(--primary);
            border: 1px solid rgba(239, 68, 68, 0.3);
            font-family: var(--font-head);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        /* --- 4. NAVIGATION --- */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(10, 10, 10, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 20px 0;
        }

        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-family: var(--font-head);
            font-size: 1.8rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 10px;
            font-style: italic;
        }

        .brand span {
            color: var(--primary);
        }

        .nav-menu {
            display: flex;
            gap: 40px;
        }

        .nav-link {
            font-family: var(--font-head);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .nav-link:hover {
            opacity: 1;
            color: var(--primary);
        }

        /* --- 5. HERO SECTION --- */
        .hero {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            padding-top: 80px;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.6;
            filter: contrast(1.1) brightness(0.8);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, #0a0a0a 10%, transparent 80%), linear-gradient(to top, #0a0a0a 0%, transparent 50%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            padding-left: 20px;
            border-left: 4px solid var(--primary);
            margin-left: 20px;
        }

        .stat-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 2;
            background: rgba(26, 26, 26, 0.9);
            border-top: var(--border);
            padding: 30px 0;
            backdrop-filter: blur(10px);
        }

        .stat-grid {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-num {
            font-family: var(--font-head);
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* --- 6. SERVICES (CARD GRID) --- */
        .section-padding {
            padding: 120px 0;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .service-card {
            background: var(--bg-surface);
            border: var(--border);
            padding: 40px;
            position: relative;
            overflow: hidden;
            transition: 0.4s var(--ease);
            group: service;
            clip-path: polygon(20px 0, 100% 0, 100% 100%, 0 100%, 0 20px);
        }

        .service-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary);
            background: var(--bg-card);
        }

        .service-icon {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 20px;
            display: inline-block;
            padding: 15px;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 4px;
        }

        .service-card h3 {
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        /* Subtle grid pattern background for card */
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background-image: radial-gradient(var(--primary) 1px, transparent 1px);
            background-size: 10px 10px;
            opacity: 0.1;
        }

        /* --- 7. FEATURED PROJECT (Parallax) --- */
        .project-section {
            position: relative;
            padding: 150px 0;
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .project-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
        }

        .project-card {
            position: relative;
            z-index: 2;
            background: rgba(18, 18, 18, 0.9);
            padding: 60px;
            border: var(--border);
            max-width: 800px;
            text-align: center;
            backdrop-filter: blur(20px);
        }

        /* --- 8. BOOKING FORM --- */
        .booking-section {
            background: var(--bg-surface);
            position: relative;
        }

        .booking-container {
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 0;
            border: var(--border);
        }

        .booking-info {
            padding: 80px 60px;
            background: var(--bg-card);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .booking-form-wrapper {
            padding: 80px 60px;
            background: #0f0f0f;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-family: var(--font-head);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            margin-bottom: 10px;
            color: var(--text-muted);
        }

        .form-input {
            width: 100%;
            background: transparent;
            border: 1px solid #333;
            padding: 15px;
            color: white;
            font-family: var(--font-body);
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        .form-input:focus {
            border-color: var(--primary);
            background: rgba(239, 68, 68, 0.05);
        }

        select option {
            background: #000;
        }

        /* --- 9. FOOTER --- */
        .footer {
            border-top: var(--border);
            padding: 80px 0 30px;
            margin-top: 0;
            background: #050505;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer h4 {
            color: white;
            margin-bottom: 25px;
            font-size: 1.1rem;
        }

        .footer a {
            display: block;
            margin-bottom: 15px;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .footer a:hover {
            color: var(--primary);
            padding-left: 5px;
        }

        .copyright {
            border-top: var(--border);
            padding-top: 30px;
            text-align: center;
            color: #555;
            font-size: 0.85rem;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .hero {
                padding-top: 100px;
                text-align: center;
                justify-content: center;
            }

            .hero-content {
                border-left: none;
                padding-left: 0;
                margin-left: 0;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .hero-overlay {
                background: rgba(0, 0, 0, 0.7);
            }

            .stat-bar {
                position: relative;
                margin-top: 0;
                background: var(--bg-surface);
            }

            .nav-menu {
                display: none;
            }

            .booking-container {
                grid-template-columns: 1fr;
            }

            .booking-info,
            .booking-form-wrapper {
                padding: 40px 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="container nav-wrapper">
            <a href="#" class="brand">
                <i class="fas fa-tachometer-alt"></i> REDLINE<span>.</span>
            </a>

            <div class="nav-menu">
                <a href="#services" class="nav-link">Services</a>
                <a href="#performance" class="nav-link">Tuning</a>
                <a href="#booking" class="nav-link">Schedule</a>
                <a href="#contact" class="nav-link">Contact</a>
            </div>

            <a href="#booking" class="btn btn-primary">Book Service <i class="fas fa-wrench"></i></a>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-bg">
            <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                alt="Sports Car"
                onerror="this.src='https://placehold.co/1920x1080/1a1a1a/ffffff?text=Redline+Auto'">
        </div>
        <div class="hero-overlay"></div>

        <div class="container" style="position: relative; z-index: 3; width: 100%;">
            <div class="hero-content">
                <div class="badge"><i class="fas fa-bolt"></i> Authorized Performance Center</div>
                <h1>Precision Engineering.<br><span class="text-red">Unmatched Speed.</span></h1>
                <p>From routine maintenance to track-day tuning, we keep your machine running at its absolute peak. Certified mechanics, premium parts, zero compromises.</p>
                <div style="display: flex; gap: 20px; margin-top: 30px;">
                    <a href="#booking" class="btn btn-primary">Schedule Service</a>
                    <a href="#services" class="btn btn-outline">View Modifications</a>
                </div>
            </div>
        </div>

        <div class="stat-bar">
            <div class="container stat-grid">
                <div class="stat-item">
                    <div class="stat-num text-red">15+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num text-red">5k+</div>
                    <div class="stat-label">Cars Serviced</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num text-red">100%</div>
                    <div class="stat-label">Warranty</div>
                </div>
                <div class="stat-item">
                    <div class="stat-num text-red">ASE</div>
                    <div class="stat-label">Certified Pros</div>
                </div>
            </div>
        </div>
    </header>

    <section id="services" class="section-padding">
        <div class="container">
            <div class="text-center" style="margin-bottom: 80px;">
                <span class="badge">Our Expertise</span>
                <h2>Complete Auto Care</h2>
                <p>We handle everything from imports to domestics with dealer-level diagnostics.</p>
            </div>

            <div class="grid-3">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-car-crash"></i></div>
                    <h3>Collision Repair</h3>
                    <p>Frame straightening, dent removal, and color-match painting to restore factory finish.</p>
                    <a href="#booking" class="text-red" style="font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Get Quote &rarr;</a>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-oil-can"></i></div>
                    <h3>Maintenance</h3>
                    <p>Synthetic oil changes, brake service, fluid flushes, and 30/60/90k mile factory service.</p>
                    <a href="#booking" class="text-red" style="font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Book Now &rarr;</a>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-microchip"></i></div>
                    <h3>Diagnostics</h3>
                    <p>Check engine light analysis using OEM scanners to pinpoint electrical and mechanical issues.</p>
                    <a href="#booking" class="text-red" style="font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Scan Now &rarr;</a>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-tachometer-alt"></i></div>
                    <h3>Performance Tuning</h3>
                    <p>ECU remapping, turbo installations, exhaust systems, and suspension upgrades for track use.</p>
                    <a href="#booking" class="text-red" style="font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Tune Up &rarr;</a>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-snowflake"></i></div>
                    <h3>A/C & Heating</h3>
                    <p>Leak detection, compressor replacement, and recharging to keep you comfortable year-round.</p>
                    <a href="#booking" class="text-red" style="font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Fix A/C &rarr;</a>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-cogs"></i></div>
                    <h3>Transmission</h3>
                    <p>Fluid changes, clutch replacement, and full rebuilds for automatic and manual gearboxes.</p>
                    <a href="#booking" class="text-red" style="font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Check Gearbox &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <section class="project-section" style="background-image: url('https://images.unsplash.com/photo-1486006920555-c77dcf18193c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');">
        <div class="project-overlay"></div>
        <div class="container" style="position: relative; z-index: 2; display: flex; justify-content: flex-end;">
            <div class="project-card">
                <span class="badge" style="border-color: rgba(255,255,255,0.2); color: #fff;">Featured Project</span>
                <h2>GT-R Track Build</h2>
                <p>Full suspension overhaul, Stage 2 tune, and custom titanium exhaust fabrication. We turned a stock daily driver into a weekend track weapon.</p>
                <div style="display: flex; gap: 20px; justify-content: center; margin-top: 30px;">
                    <div>
                        <h4 class="text-red">750HP</h4>
                        <span style="font-size: 0.8rem; color: #aaa;">Output</span>
                    </div>
                    <div style="width: 1px; background: #333;"></div>
                    <div>
                        <h4 class="text-red">2.8s</h4>
                        <span style="font-size: 0.8rem; color: #aaa;">0-60 MPH</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="booking" class="booking-section">
        <div class="container">
            <div class="booking-container">
                <div class="booking-info">
                    <span class="badge">Appointments</span>
                    <h2>Book Your Service</h2>
                    <p>Skip the wait. Schedule your drop-off time online. We'll diagnose the issue and send a digital quote to your phone.</p>

                    <div style="margin-top: 40px;">
                        <div style="margin-bottom: 20px; display: flex; gap: 15px;">
                            <i class="fas fa-map-marker-alt text-red" style="font-size: 1.5rem; margin-top: 5px;"></i>
                            <div>
                                <h4 style="margin-bottom: 5px;">Location</h4>
                                <p style="margin: 0; font-size: 0.9rem;">88 Speedway Blvd, Unit 4<br>Detroit, MI 48201</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <i class="fas fa-clock text-red" style="font-size: 1.5rem; margin-top: 5px;"></i>
                            <div>
                                <h4 style="margin-bottom: 5px;">Hours</h4>
                                <p style="margin: 0; font-size: 0.9rem;">Mon-Fri: 8am - 6pm<br>Sat: 9am - 3pm</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="booking-form-wrapper">
                    <form id="serviceForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Vehicle Make</label>
                                <input type="text" class="form-input" placeholder="e.g. Ford" required>
                            </div>
                            <div class="form-group">
                                <label>Vehicle Model</label>
                                <input type="text" class="form-input" placeholder="e.g. Mustang" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Service Type</label>
                                <select class="form-input">
                                    <option>Oil Change & Filter</option>
                                    <option>Brake Service</option>
                                    <option>Check Engine Light</option>
                                    <option>Tires / Alignment</option>
                                    <option>Performance Mod</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Preferred Date</label>
                                <input type="date" class="form-input" required>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 30px;">
                            <label>Contact Info</label>
                            <input type="text" class="form-input" placeholder="Your Name or Phone" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Confirm Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid" style="display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr; gap: 40px; margin-bottom: 60px;">
                <div>
                    <a href="#" class="brand" style="margin-bottom: 20px;">REDLINE<span>.</span></a>
                    <p style="font-size: 0.9rem;">Your trusted partner for automotive excellence. We treat every car like it's our own.</p>
                    <div style="display: flex; gap: 15px; margin-top: 20px;">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div>
                    <h4 style="color: white; margin-bottom: 20px;">Services</h4>
                    <a href="#" style="display: block; margin-bottom: 10px; color: var(--text-muted);">Repair</a>
                    <a href="#" style="display: block; margin-bottom: 10px; color: var(--text-muted);">Maintenance</a>
                    <a href="#" style="display: block; margin-bottom: 10px; color: var(--text-muted);">Performance</a>
                    <a href="#" style="display: block; margin-bottom: 10px; color: var(--text-muted);">Tires</a>
                </div>
                <div>
                    <h4 style="color: white; margin-bottom: 20px;">Company</h4>
                    <a href="#" style="display: block; margin-bottom: 10px; color: var(--text-muted);">About Us</a>
                    <a href="#" style="display: block; margin-bottom: 10px; color: var(--text-muted);">Careers</a>
                    <a href="#" style="display: block; margin-bottom: 10px; color: var(--text-muted);">Reviews</a>
                    <a href="#" style="display: block; margin-bottom: 10px; color: var(--text-muted);">Privacy</a>
                </div>
                <div>
                    <h4 style="color: white; margin-bottom: 20px;">Contact</h4>
                    <p style="margin-bottom: 10px; color: var(--text-muted);"><i class="fas fa-phone text-red"></i> (555) 123-4567</p>
                    <p style="color: var(--text-muted);"><i class="fas fa-envelope text-red"></i> service@redline.com</p>
                </div>
            </div>
            <div class="text-center copyright" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 30px; font-size: 0.8rem; color: #555;">
                &copy; <?php echo date("Y"); ?> Redline Automotive. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // 1. Form Animation
            const form = document.getElementById('serviceForm');
            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const btn = form.querySelector('button');
                    const originalText = btn.innerHTML;

                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    btn.style.opacity = '0.8';

                    setTimeout(() => {
                        btn.innerHTML = '<i class="fas fa-check"></i> Requested';
                        btn.style.background = '#10b981'; // Green
                        form.reset();

                        setTimeout(() => {
                            btn.innerHTML = originalText;
                            btn.style.background = '';
                            btn.style.opacity = '1';
                        }, 3000);
                    }, 1500);
                });
            }

            // 2. Navbar Scroll Effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.style.padding = '10px 0';
                    navbar.style.background = 'rgba(10, 10, 10, 0.95)';
                } else {
                    navbar.style.padding = '20px 0';
                    navbar.style.background = 'rgba(10, 10, 10, 0.9)';
                }
            });

            // 3. Scroll Reveal
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.service-card, .project-card, .booking-container').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'all 0.6s ease-out';
                observer.observe(el);
            });
        });
    </script>
</body>

</html>