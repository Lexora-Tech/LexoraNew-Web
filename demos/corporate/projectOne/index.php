<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS | Strategic Solutions</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- 1. DESIGN SYSTEM --- */
        :root {
            /* Light Mode */
            --bg-body: #ffffff;
            --bg-surface: #f8fafc;
            /* Slate 50 */
            --bg-card: #ffffff;

            --text-main: #0f172a;
            --text-muted: #64748b;

            --primary: #2563eb;
            /* Royal Blue */
            --primary-dark: #1d4ed8;

            --border: #e2e8f0;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);

            --font-head: 'Outfit', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        /* Dark Mode */
        [data-theme="dark"] {
            --bg-body: #020617;
            /* Slate 950 */
            --bg-surface: #0f172a;
            /* Slate 900 */
            --bg-card: #1e293b;
            /* Slate 800 */

            --text-main: #f8fafc;
            --text-muted: #94a3b8;

            --primary: #3b82f6;
            --primary-dark: #60a5fa;

            --border: #334155;
            --shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5);
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
            font-family: var(--font-body);
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            transition: background-color 0.3s, color 0.3s;
            overflow-x: hidden;
        }

        /* Typography */
        h1,
        h2,
        h3,
        h4 {
            font-family: var(--font-head);
            font-weight: 700;
            line-height: 1.1;
            color: var(--text-main);
        }

        h1 {
            font-size: clamp(3rem, 6vw, 5rem);
            letter-spacing: -1px;
        }

        h2 {
            font-size: clamp(2rem, 4vw, 3.5rem);
            margin-bottom: 15px;
        }

        p {
            color: var(--text-muted);
            margin-bottom: 24px;
            font-size: 1.05rem;
            max-width: 650px;
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
            background: var(--bg-surface);
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .section-padding {
            padding: 120px 0;
        }

        .text-center {
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* --- 3. COMPONENTS --- */

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: 0.3s;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        .btn-outline {
            border-color: var(--border);
            color: var(--text-main);
            background: transparent;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: rgba(37, 99, 235, 0.05);
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            background: rgba(37, 99, 235, 0.1);
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 50px;
            margin-bottom: 20px;
        }

        /* --- 4. NAVIGATION --- */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 20px 0;
            transition: 0.3s;
            background: rgba(255, 255, 255, 0.01);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        [data-theme="light"] .navbar.scrolled {
            background: rgba(255, 255, 255, 0.9);
            border-bottom: 1px solid var(--border);
        }

        [data-theme="dark"] .navbar.scrolled {
            background: rgba(2, 6, 23, 0.9);
            border-bottom: 1px solid var(--border);
        }

        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: var(--font-head);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logo-box {
            width: 32px;
            height: 32px;
            background: var(--primary);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .nav-link:hover {
            color: var(--primary);
        }

        /* Theme Toggle */
        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-main);
            background: var(--bg-card);
            transition: 0.3s;
        }

        .theme-toggle:hover {
            color: var(--primary);
            border-color: var(--primary);
        }

        /* --- 5. HERO --- */
        .hero {
            padding-top: 160px;
            padding-bottom: 100px;
            position: relative;
            overflow: hidden;
            background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.1), transparent 40%),
                radial-gradient(circle at bottom left, rgba(14, 165, 233, 0.1), transparent 40%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .hero-img-container {
            position: relative;
            height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-hover);
        }

        .hero-overlay-card {
            position: absolute;
            bottom: 30px;
            left: -30px;
            background: var(--bg-card);
            padding: 25px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            display: flex;
            gap: 15px;
            align-items: center;
            width: 280px;
            z-index: 2;
            animation: float 6s ease-in-out infinite;
        }

        .chart-icon {
            width: 50px;
            height: 50px;
            background: #dbeafe;
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        [data-theme="dark"] .chart-icon {
            background: rgba(37, 99, 235, 0.2);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        /* --- 6. STATS (Grid) --- */
        .stats-section {
            padding: 60px 0;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .stat-item p {
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
        }

        /* --- 7. SERVICES (Bento Grid) --- */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: 300px 300px;
            gap: 24px;
        }

        .bento-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: 0.3s;
            position: relative;
            overflow: hidden;
        }

        .bento-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary);
        }

        .card-lg {
            grid-column: span 2;
        }

        .card-tall {
            grid-row: span 2;
        }

        .bento-icon {
            width: 50px;
            height: 50px;
            background: var(--bg-surface);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .bento-link {
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 5px;
            font-weight: 600;
            color: var(--primary);
            font-size: 0.9rem;
        }

        /* --- 8. PROJECTS (Tabs) --- */
        .tabs-nav {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .tab-btn {
            padding: 10px 24px;
            border-radius: 50px;
            border: 1px solid var(--border);
            background: var(--bg-card);
            color: var(--text-muted);
            cursor: pointer;
            transition: 0.3s;
            font-weight: 500;
        }

        .tab-btn.active,
        .tab-btn:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .projects-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .project-card {
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            height: 300px;
            group: project;
        }

        .project-img {
            width: 100%;
            height: 100%;
            transition: 0.5s;
        }

        .project-card:hover .project-img {
            transform: scale(1.1);
        }

        .project-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 30px;
            color: #fff;
            opacity: 0;
            transition: 0.3s;
        }

        .project-card:hover .project-overlay {
            opacity: 1;
        }

        /* --- 9. CONTACT --- */
        .contact-section {
            background: var(--bg-surface);
        }

        .form-box {
            background: var(--bg-card);
            padding: 50px;
            border-radius: 24px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .input-field {
            width: 100%;
            padding: 12px;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text-main);
            outline: none;
            transition: 0.3s;
        }

        .input-field:focus {
            border-color: var(--primary);
            background: var(--bg-card);
        }

        /* --- 10. TOAST NOTIFICATION --- */
        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--bg-card);
            color: var(--text-main);
            padding: 15px 25px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            opacity: 0;
            transition: 0.4s;
            z-index: 9999;
            border: 1px solid var(--border);
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* --- 11. FOOTER (UPDATED) --- */
        .footer {
            background: var(--bg-surface);
            /* Matches theme */
            color: var(--text-main);
            padding: 80px 0 30px;
            margin-top: 100px;
            border-top: 1px solid var(--border);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .footer h4 {
            color: var(--text-main);
            margin-bottom: 20px;
            font-weight: 700;
        }

        .footer a {
            color: var(--text-muted);
            display: block;
            margin-bottom: 12px;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .footer a:hover {
            color: var(--primary);
        }

        .copyright {
            border-top: 1px solid var(--border);
            padding-top: 30px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        /* --- UTILS --- */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: 1s ease;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .hidden {
            display: none;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 900px) {
            .hero-grid {
                grid-template-columns: 1fr;
            }

            .hero-img-container {
                order: -1;
                height: 300px;
            }

            .bento-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
            }

            .card-lg,
            .card-tall {
                grid-column: span 1;
                grid-row: span 1;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 3rem;
            }
        }
    </style>
</head>

<body>

    <div id="toast" class="toast">
        <i class="fas fa-check-circle" style="color: #4ade80;"></i>
        <span id="toastMsg">Success</span>
    </div>

    <nav class="navbar">
        <div class="container nav-wrapper">
            <a href="#" class="logo">
                <div class="logo-box"><i class="fas fa-layer-group"></i></div>
                NEXUS
            </a>
            <div class="nav-menu">
                <a href="#home" class="nav-link">Home</a>
                <a href="#services" class="nav-link">Services</a>
                <a href="#projects" class="nav-link">Work</a>
                <a href="#about" class="nav-link">Company</a>
            </div>
            <div style="display:flex; align-items:center; gap:15px;">
                <div class="theme-toggle" id="themeBtn"><i class="fas fa-moon"></i></div>
                <a href="#contact" class="btn btn-primary">Get in Touch</a>
            </div>
        </div>
    </nav>

    <header id="home" class="hero">
        <div class="container hero-grid">
            <div class="hero-content reveal">
                <span class="badge">Global Consultancy Firm</span>
                <h1>Strategic Growth for the <span style="color: var(--primary);">Digital Age.</span></h1>
                <p>We help ambitious organizations transform, scale, and lead in a rapidly evolving market environment through data-driven strategies.</p>
                <div style="display: flex; gap: 15px;">
                    <a href="#services" class="btn btn-primary">Our Solutions</a>
                    <a href="#projects" class="btn btn-outline">View Case Studies</a>
                </div>
            </div>

            <div class="hero-img-container reveal">
                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                    alt="Corporate Skyscraper"
                    onerror="this.src='https://placehold.co/800x600/0f172a/ffffff?text=Corporate+HQ'">

                <div class="hero-overlay-card">
                    <div class="chart-icon"><i class="fas fa-chart-line"></i></div>
                    <div>
                        <h4 style="margin: 0; font-size: 1.1rem;">+145% Growth</h4>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">Client Year-on-Year</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="stats-section">
        <div class="container stats-grid">
            <div class="stat-item">
                <h3 class="counter" data-target="25">0</h3>
                <p>Years Experience</p>
            </div>
            <div class="stat-item">
                <h3 class="counter" data-target="500">0</h3>
                <p>Projects Delivered</p>
            </div>
            <div class="stat-item">
                <h3><span class="counter" data-target="10">0</span>B+</h3>
                <p>Capital Managed</p>
            </div>
            <div class="stat-item">
                <h3 class="counter" data-target="50">0</h3>
                <p>Global Offices</p>
            </div>
        </div>
    </section>

    <section id="services" class="section-padding">
        <div class="container">
            <div class="text-center reveal" style="margin-bottom: 60px;">
                <span class="badge">What We Do</span>
                <h2>Holistic Business Solutions</h2>
            </div>

            <div class="bento-grid">
                <div class="bento-card card-lg reveal">
                    <div class="bento-icon"><i class="fas fa-chess"></i></div>
                    <h3>Strategic Consulting</h3>
                    <p>We redefine business models to unlock new value streams and drive sustainable competitive advantage.</p>
                    <a href="#" class="bento-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="bento-card reveal">
                    <div class="bento-icon"><i class="fas fa-coins"></i></div>
                    <h3>Financial Advisory</h3>
                    <p>Mergers, acquisitions, and capital allocation strategies.</p>
                    <a href="#" class="bento-link">Explore <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="bento-card reveal">
                    <div class="bento-icon"><i class="fas fa-laptop-code"></i></div>
                    <h3>Digital Transformation</h3>
                    <p>Modernizing legacy systems with Cloud and AI integration.</p>
                    <a href="#" class="bento-link">Explore <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="bento-card card-lg reveal">
                    <div class="bento-icon"><i class="fas fa-chart-pie"></i></div>
                    <h3>Market Intelligence</h3>
                    <p>Deep-dive analytics and consumer insights to predict market shifts before they happen.</p>
                    <a href="#" class="bento-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section id="projects" class="section-padding" style="background: var(--bg-surface);">
        <div class="container">
            <div class="text-center reveal" style="margin-bottom: 40px;">
                <h2>Featured Case Studies</h2>
            </div>

            <div class="tabs-nav reveal">
                <button class="tab-btn active" onclick="filterProjects('all')">All</button>
                <button class="tab-btn" onclick="filterProjects('finance')">Finance</button>
                <button class="tab-btn" onclick="filterProjects('tech')">Technology</button>
                <button class="tab-btn" onclick="filterProjects('energy')">Energy</button>
            </div>

            <div id="projectGrid" class="projects-grid">
            </div>
        </div>
    </section>

    <section id="contact" class="section-padding">
        <div class="container">
            <div class="form-box reveal">
                <div class="text-center" style="margin-bottom: 40px;">
                    <h2>Start a Conversation</h2>
                    <p>Reach out to our experts to discuss your specific needs.</p>
                </div>

                <form id="contactForm">
                    <div class="form-grid">
                        <div class="input-group">
                            <label>First Name</label>
                            <input type="text" class="input-field" required>
                        </div>
                        <div class="input-group">
                            <label>Last Name</label>
                            <input type="text" class="input-field" required>
                        </div>
                    </div>
                    <div class="input-group" style="margin-bottom: 20px;">
                        <label>Business Email</label>
                        <input type="email" class="input-field" required>
                    </div>
                    <div class="input-group" style="margin-bottom: 20px;">
                        <label>Subject</label>
                        <select class="input-field">
                            <option>Strategic Consulting</option>
                            <option>Financial Advisory</option>
                            <option>Partnership Inquiry</option>
                        </select>
                    </div>
                    <div class="input-group" style="margin-bottom: 30px;">
                        <label>Message</label>
                        <textarea class="input-field" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="#" class="logo" style="margin-bottom: 20px; color: var(--text-main);">
                        <div class="logo-box"><i class="fas fa-layer-group"></i></div>
                        NEXUS
                    </a>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Delivering excellence in strategic consulting since 2010.</p>
                </div>
                <div>
                    <h4>Services</h4>
                    <a href="#">Strategy</a>
                    <a href="#">Analytics</a>
                    <a href="#">Digital</a>
                    <a href="#">Operations</a>
                </div>
                <div>
                    <h4>Company</h4>
                    <a href="#">About Us</a>
                    <a href="#">Careers</a>
                    <a href="#">Insights</a>
                    <a href="#">Press</a>
                </div>
                <div>
                    <h4>Connect</h4>
                    <a href="#">LinkedIn</a>
                    <a href="#">Twitter</a>
                    <a href="#">Facebook</a>
                </div>
            </div>
            <div class="copyright">
                &copy; <?php echo date("Y"); ?> Nexus Strategic. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // --- 1. THEME TOGGLE ---
        const themeBtn = document.getElementById('themeBtn');
        const html = document.documentElement;

        // Check LocalStorage
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        updateIcon(savedTheme);

        themeBtn.addEventListener('click', () => {
            const current = html.getAttribute('data-theme');
            const next = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateIcon(next);
        });

        function updateIcon(theme) {
            themeBtn.innerHTML = theme === 'light' ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';
        }

        // --- 2. PROJECT DATA ---
        const projects = [{
                title: "Fintech Expansion",
                cat: "finance",
                img: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
            },
            {
                title: "AI Integration",
                cat: "tech",
                img: "https://images.unsplash.com/photo-1518770660439-4636190af475?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
            },
            {
                title: "Renewable Grid",
                cat: "energy",
                img: "https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
            },
            {
                title: "Global Banking",
                cat: "finance",
                img: "https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
            },
            {
                title: "Cloud Migration",
                cat: "tech",
                img: "https://images.unsplash.com/photo-1451187580459-43490279c0fa?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
            },
            {
                title: "Oil Sector Reform",
                cat: "energy",
                img: "https://images.unsplash.com/photo-1516937941344-00b4e0337589?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
            }
        ];

        // --- 3. FILTER PROJECTS ---
        const grid = document.getElementById('projectGrid');
        const buttons = document.querySelectorAll('.tab-btn');

        function renderProjects(data) {
            grid.innerHTML = '';
            data.forEach(p => {
                const card = document.createElement('div');
                card.className = 'project-card reveal';
                card.innerHTML = `
                    <img src="${p.img}" class="project-img" alt="${p.title}" onerror="this.src='https://placehold.co/600x400/1e293b/fff?text=Project'">
                    <div class="project-overlay">
                        <span style="text-transform:uppercase; font-size:0.75rem; letter-spacing:1px; margin-bottom:5px;">${p.cat}</span>
                        <h3>${p.title}</h3>
                    </div>
                `;
                grid.appendChild(card);
            });
            triggerObserver(); // Re-attach animation
        }

        function filterProjects(cat) {
            // Update Buttons
            buttons.forEach(b => b.classList.remove('active'));
            event.target.classList.add('active');

            // Filter Data
            if (cat === 'all') {
                renderProjects(projects);
            } else {
                const filtered = projects.filter(p => p.cat === cat);
                renderProjects(filtered);
            }
        }

        // --- 4. COUNTERS ---
        const counters = document.querySelectorAll('.counter');
        const runCounters = () => {
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                const inc = target / 100;
                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(runCounters, 20);
                } else {
                    counter.innerText = target;
                }
            });
        };

        // --- 5. SCROLL EFFECTS ---
        const navbar = document.querySelector('.navbar');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('active');
            });
        }, {
            threshold: 0.1
        });

        function triggerObserver() {
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
        }

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');

            const stats = document.querySelector('.stats-section');
            if (window.scrollY + window.innerHeight > stats.offsetTop) runCounters();
        });

        // --- 6. TOAST FORM ---
        const form = document.getElementById('contactForm');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = form.querySelector('button');
            const original = btn.innerText;
            btn.innerText = "Sending...";

            setTimeout(() => {
                const toast = document.getElementById('toast');
                document.getElementById('toastMsg').innerText = "Message Sent Successfully";
                toast.classList.add('show');
                btn.innerText = "Sent";
                form.reset();
                setTimeout(() => {
                    toast.classList.remove('show');
                    btn.innerText = original;
                }, 3000);
            }, 1500);
        });

        // Init
        renderProjects(projects);
    </script>
</body>

</html>