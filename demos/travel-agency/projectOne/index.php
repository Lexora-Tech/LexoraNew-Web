<?php
// Simple PHP logic for dynamic date
$year = date("Y");
$agencyName = "Voyageur";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $agencyName; ?> | Premium Travel Agency</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">

    <style>
        /* --- CSS VARIABLES & RESET --- */
        :root {
            --bg-color: #0f1014;
            --text-color: #f0f0f0;
            --accent: #d9a456; /* Gold/Luxury */
            --glass: rgba(255, 255, 255, 0.05);
            --border: rgba(255, 255, 255, 0.1);
            --font-main: 'Outfit', sans-serif;
            --font-serif: 'Playfair Display', serif;
            --ease: cubic-bezier(0.23, 1, 0.32, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html { scroll-behavior: smooth; }
        
        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: var(--font-main);
            overflow-x: hidden;
            line-height: 1.6;
        }

        a { text-decoration: none; color: inherit; transition: color 0.3s ease; }
        ul { list-style: none; }
        img { width: 100%; display: block; object-fit: cover; }

        /* --- PRELOADER --- */
        #preloader {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: #000;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: transform 0.8s var(--ease);
        }
        
        .loader-text {
            font-family: var(--font-serif);
            font-size: 2.5rem;
            color: var(--accent);
            opacity: 0;
            animation: breathe 2s infinite ease-in-out;
        }

        .loader-bar {
            position: absolute;
            bottom: 0; left: 0; height: 4px; background: var(--accent);
            width: 0%;
            transition: width 0.5s ease;
        }

        @keyframes breathe { 0%, 100% { opacity: 0.3; } 50% { opacity: 1; } }

        /* --- UTILITIES --- */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .reveal {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s var(--ease);
        }
        
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- HEADER --- */
        header {
            position: fixed;
            top: 0; left: 0; width: 100%;
            padding: 1.5rem 0;
            z-index: 100;
            transition: background 0.3s ease, padding 0.3s ease;
            mix-blend-mode: difference;
        }

        header.scrolled {
            background: rgba(15, 16, 20, 0.9);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            mix-blend-mode: normal;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: var(--font-serif);
            font-size: 1.8rem;
            font-weight: 600;
            color: #fff;
        }

        .nav-links {
            display: flex;
            gap: 3rem;
        }

        .nav-links a {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px; left: 0; width: 0; height: 1px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after { width: 100%; }

        .hamburger { display: none; cursor: pointer; }

        /* --- HERO --- */
        .hero {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            /* High quality travel image */
            background: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
            filter: brightness(0.6);
            transform: scale(1.1);
            transition: transform 10s ease; /* Parallax feel */
        }
        
        .hero:hover .hero-bg { transform: scale(1); }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }

        h1 {
            font-family: var(--font-serif);
            font-size: 5rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s var(--ease) forwards 0.8s;
        }

        .subtitle {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s var(--ease) forwards 1s;
        }

        .btn {
            display: inline-block;
            padding: 1rem 2.5rem;
            border: 1px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.05);
            color: #fff;
            backdrop-filter: blur(5px);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            opacity: 0;
            animation: fadeIn 1s ease forwards 1.2s;
        }

        .btn:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #000;
        }

        @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { to { opacity: 1; } }

        /* --- DESTINATIONS --- */
        .section { padding: 8rem 0; }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 3rem;
            font-family: var(--font-serif);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .card {
            position: relative;
            height: 450px;
            overflow: hidden;
            border-radius: 4px;
            cursor: pointer;
        }

        .card img {
            height: 100%;
            transition: transform 0.6s var(--ease);
        }

        .card:hover img { transform: scale(1.1); }

        .card-info {
            position: absolute;
            bottom: 0; left: 0; width: 100%;
            padding: 2rem;
            background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
            transform: translateY(20px);
            opacity: 0.8;
            transition: all 0.4s ease;
        }

        .card:hover .card-info {
            transform: translateY(0);
            opacity: 1;
        }

        .card-title {
            font-family: var(--font-serif);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }

        .card-sub {
            color: var(--accent);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* --- SERVICES (Glassmorphism) --- */
        .services {
            background: #15161a;
        }

        .service-item {
            padding: 3rem;
            background: var(--glass);
            border: 1px solid var(--border);
            transition: background 0.3s ease;
        }

        .service-item:hover {
            background: rgba(255,255,255,0.08);
            border-color: var(--accent);
        }

        .service-icon {
            font-size: 2rem;
            color: var(--accent);
            margin-bottom: 1.5rem;
        }

        .service-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .service-desc {
            color: #aaa;
            font-size: 0.95rem;
        }

        /* --- FOOTER --- */
        footer {
            padding: 4rem 0;
            border-top: 1px solid var(--border);
            text-align: center;
            color: #777;
        }

        .footer-logo {
            font-family: var(--font-serif);
            font-size: 2rem;
            color: #fff;
            margin-bottom: 1rem;
            display: inline-block;
        }

        /* --- MOBILE RESPONSIVENESS --- */
        @media (max-width: 768px) {
            h1 { font-size: 3rem; }
            .nav-links {
                position: fixed;
                top: 0; right: 0;
                height: 100vh; width: 70%;
                background: #0f1014;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                transform: translateX(100%);
                transition: transform 0.4s var(--ease);
                z-index: 99;
            }
            .nav-links.active { transform: translateX(0); }
            .hamburger { display: block; z-index: 101; color: #fff; font-size: 1.5rem; }
            .section-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
        }
    </style>
</head>
<body>

    <div id="preloader">
        <div class="loader-text"><?php echo $agencyName; ?></div>
        <div class="loader-bar" id="loaderBar"></div>
    </div>

    <header id="header">
        <div class="container">
            <nav>
                <a href="#" class="logo"><?php echo $agencyName; ?>.</a>
                <div class="hamburger" onclick="toggleMenu()">☰</div>
                <ul class="nav-links" id="navLinks">
                    <li><a href="#destinations" onclick="toggleMenu()">Destinations</a></li>
                    <li><a href="#experience" onclick="toggleMenu()">Experience</a></li>
                    <li><a href="#contact" onclick="toggleMenu()">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <h1>The World Awaits.</h1>
            <p class="subtitle">Experience luxury travel curated for the modern explorer.</p>
            <a href="#destinations" class="btn">Start Your Journey</a>
        </div>
    </section>

    <section id="destinations" class="section">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title">Curated Locations</h2>
                <p style="color: #aaa;">Handpicked for the discerning traveler.</p>
            </div>
            
            <div class="grid">
                <div class="card reveal">
                    <img src="https://images.unsplash.com/photo-1499678329028-101435549a4e?q=80&w=2070&auto=format&fit=crop" alt="Italy">
                    <div class="card-info">
                        <div class="card-sub">Europe</div>
                        <h3 class="card-title">Amalfi Coast</h3>
                    </div>
                </div>
                <div class="card reveal">
                    <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=2038&auto=format&fit=crop" alt="Bali">
                    <div class="card-info">
                        <div class="card-sub">Indonesia</div>
                        <h3 class="card-title">Bali Retreat</h3>
                    </div>
                </div>
                <div class="card reveal">
                    <img src="https://images.unsplash.com/photo-1518684079-3c830dcef090?q=80&w=2069&auto=format&fit=crop" alt="Dubai">
                    <div class="card-info">
                        <div class="card-sub">UAE</div>
                        <h3 class="card-title">Dubai Skyline</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="experience" class="section services">
        <div class="container">
            <div class="section-header reveal">
                <h2 class="section-title">Why <?php echo $agencyName; ?>?</h2>
            </div>
            <div class="grid">
                <div class="service-item reveal">
                    <div class="service-icon">✦</div>
                    <h3 class="service-title">Luxury Concierge</h3>
                    <p class="service-desc">24/7 support for reservations, private jets, and exclusive access.</p>
                </div>
                <div class="service-item reveal">
                    <div class="service-icon">∞</div>
                    <h3 class="service-title">Tailored Itineraries</h3>
                    <p class="service-desc">Every trip is customized to your specific tastes and desires.</p>
                </div>
                <div class="service-item reveal">
                    <div class="service-icon">★</div>
                    <h3 class="service-title">VIP Treatment</h3>
                    <p class="service-desc">Upgrades, private tours, and hidden gems strictly for our members.</p>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact">
        <div class="container">
            <a href="#" class="footer-logo"><?php echo $agencyName; ?>.</a>
            <p>123 Luxury Ave, New York, NY 10012</p>
            <p>hello@<?php echo strtolower($agencyName); ?>.com</p>
            <br>
            <p style="font-size: 0.8rem; opacity: 0.5;">&copy; <?php echo $year; ?> <?php echo $agencyName; ?> Agency. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        // 1. Preloader Logic
        window.addEventListener('load', () => {
            const bar = document.getElementById('loaderBar');
            const preloader = document.getElementById('preloader');
            
            // Simulate loading progress
            let width = 0;
            const interval = setInterval(() => {
                if (width >= 100) {
                    clearInterval(interval);
                    // Hide Preloader (Slide Up)
                    preloader.style.transform = 'translateY(-100%)';
                } else {
                    width += 2; 
                    bar.style.width = width + '%';
                }
            }, 15); // Adjust speed here
        });

        // 2. Scroll Animations (Intersection Observer)
        const observerOptions = {
            threshold: 0.1,
            rootMargin: "0px 0px -50px 0px"
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => {
            observer.observe(el);
        });

        // 3. Header Scroll Effect
        window.addEventListener('scroll', () => {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // 4. Mobile Menu Toggle
        function toggleMenu() {
            const nav = document.getElementById('navLinks');
            nav.classList.toggle('active');
            
            // Toggle hamburger icon text
            const btn = document.querySelector('.hamburger');
            btn.innerHTML = nav.classList.contains('active') ? '✕' : '☰';
        }
    </script>
</body>
</html>