<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACADEMIA | Excellence in Education</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- 1. DESIGN VARIABLES --- */
        :root {
            /* Light Theme (Default) */
            --bg-body: #ffffff;
            --bg-light: #f4f6f8;
            --bg-card: #ffffff;
            --bg-dark-section: #0f172a;

            --text-main: #1e293b;
            --text-light: #64748b;
            --text-inverse: #ffffff;

            --primary: #003366;
            /* Oxford Blue */
            --primary-hover: #002244;
            --accent: #d4af37;
            /* Gold */

            --border: #e2e8f0;
            --shadow: 0 10px 30px -5px rgba(0, 51, 102, 0.1);

            --font-head: 'Playfair Display', serif;
            --font-body: 'Inter', sans-serif;

            --ease: cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* Dark Theme Overrides */
        [data-theme="dark"] {
            --bg-body: #0f172a;
            /* Slate 900 */
            --bg-light: #1e293b;
            /* Slate 800 */
            --bg-card: #1e293b;
            --bg-dark-section: #020617;

            --text-main: #f8fafc;
            --text-light: #94a3b8;
            --text-inverse: #f8fafc;

            --primary: #3b82f6;
            /* Brighter Blue for Dark Mode */
            --primary-hover: #2563eb;
            --accent: #facc15;
            /* Brighter Gold */

            --border: #334155;
            --shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.5);
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
            color: var(--text-main);
            line-height: 1.6;
            background: var(--bg-body);
            overflow-x: hidden;
            transition: background-color 0.3s, color 0.3s;
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: var(--font-head);
            color: var(--text-main);
            line-height: 1.2;
            font-weight: 700;
        }

        [data-theme="light"] h1,
        [data-theme="light"] h2 {
            color: var(--primary);
        }

        h1 {
            font-size: clamp(3rem, 6vw, 5rem);
        }

        h2 {
            font-size: clamp(2rem, 4vw, 3.5rem);
            margin-bottom: 20px;
        }

        p {
            color: var(--text-light);
            margin-bottom: 24px;
            font-weight: 400;
            font-size: 1.05rem;
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
            background: var(--bg-light);
        }

        ul {
            list-style: none;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 30px;
        }

        .section-padding {
            padding: 100px 0;
        }

        .text-center {
            text-align: center;
        }

        /* --- 3. COMPONENTS --- */

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px 32px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s var(--ease);
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--primary);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-outline {
            border-color: var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: #fff;
        }

        .btn-accent {
            background: var(--accent);
            color: #fff;
        }

        [data-theme="light"] .btn-accent {
            color: #fff;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        [data-theme="dark"] .btn-accent {
            color: #000;
        }

        .btn-accent:hover {
            filter: brightness(1.1);
        }

        /* Theme Toggle Button */
        .theme-toggle {
            background: var(--bg-light);
            border: 1px solid var(--border);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-main);
            transition: 0.3s;
        }

        .theme-toggle:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 6px 12px;
            background: rgba(212, 175, 55, 0.15);
            color: var(--accent);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 50px;
            margin-bottom: 20px;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }

        /* --- 4. NAVBAR --- */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 15px 0;
            transition: 0.4s;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        [data-theme="dark"] .navbar {
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 1px solid var(--border);
        }

        .nav-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: var(--font-head);
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            color: var(--accent);
            font-size: 1.5rem;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-main);
            font-size: 0.95rem;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        /* --- 5. HERO --- */
        .hero {
            padding-top: 140px;
            padding-bottom: 100px;
            background: var(--bg-light);
            position: relative;
            overflow: hidden;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 60px;
        }

        .hero-img-box {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            height: 500px;
        }

        .hero-img-box img {
            transition: transform 2s ease;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-img-box:hover img {
            transform: scale(1.05);
        }

        .float-card {
            position: absolute;
            bottom: 30px;
            left: -30px;
            background: var(--bg-card);
            padding: 20px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            gap: 15px;
            animation: float 6s ease-in-out infinite;
            z-index: 2;
            border: 1px solid var(--border);
        }

        .float-icon {
            width: 50px;
            height: 50px;
            background: rgba(0, 51, 102, 0.1);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
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

        /* --- 6. STATS BAR --- */
        .stats {
            background: var(--primary);
            color: #fff;
            padding: 60px 0;
        }

        [data-theme="dark"] .stats {
            background: var(--bg-dark-section);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            text-align: center;
        }

        .stat-num {
            font-size: 3rem;
            font-weight: 700;
            font-family: var(--font-head);
            color: var(--accent);
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.8;
            color: var(--text-inverse);
        }

        /* --- 7. PROGRAMS (Cards) --- */
        .search-bar {
            max-width: 600px;
            margin: 0 auto 60px;
            display: flex;
            gap: 10px;
            background: var(--bg-card);
            padding: 10px;
            border-radius: 50px;
            border: 1px solid var(--border);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .search-input {
            flex: 1;
            border: none;
            padding: 10px 20px;
            outline: none;
            font-size: 1rem;
            background: transparent;
            color: var(--text-main);
        }

        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

        .course-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            transition: 0.3s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }

        .course-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow);
            border-color: var(--primary);
        }

        .course-thumb {
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .course-cat {
            position: absolute;
            top: 15px;
            left: 15px;
            background: var(--bg-card);
            color: var(--primary);
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .course-body {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .course-meta {
            display: flex;
            gap: 15px;
            font-size: 0.85rem;
            color: var(--text-light);
            margin-bottom: 15px;
        }

        .course-meta i {
            color: var(--accent);
            margin-right: 5px;
        }

        .course-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .instructor {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid var(--border);
        }

        /* --- 8. ABOUT --- */
        .about-section {
            background: var(--bg-light);
        }

        .about-content h2 {
            margin-bottom: 30px;
        }

        .check-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            color: var(--text-main);
        }

        .check-list i {
            color: var(--primary);
            background: var(--bg-card);
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* --- 9. NEWSLETTER / LEAD GEN --- */
        .newsletter {
            background: var(--primary);
            color: #fff;
            border-radius: 20px;
            padding: 80px;
            position: relative;
            overflow: hidden;
            margin-top: 100px;
        }

        [data-theme="dark"] .newsletter {
            background: var(--bg-dark-section);
            border: 1px solid var(--border);
        }

        .news-bg {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            opacity: 0.1;
            background: url('https://www.transparenttextures.com/patterns/cubes.png');
        }

        .news-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .news-content h2 {
            color: #fff;
        }

        .news-content p {
            color: rgba(255, 255, 255, 0.8);
        }

        .news-form {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .news-input {
            flex: 1;
            padding: 15px 20px;
            border-radius: 4px;
            border: none;
            outline: none;
            font-family: var(--font-body);
        }

        /* --- 10. FOOTER --- */
        .footer {
            background: var(--bg-dark-section);
            color: #fff;
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
            color: var(--text-inverse);
            margin-bottom: 20px;
            font-family: var(--font-body);
            font-size: 1rem;
        }

        .footer a {
            color: #94a3b8;
            display: block;
            margin-bottom: 12px;
            font-size: 0.9rem;
        }

        .footer a:hover {
            color: var(--accent);
            padding-left: 5px;
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            text-align: center;
            color: #64748b;
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

            .hero-img-box {
                order: -1;
                height: 300px;
            }

            .nav-menu {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .news-form {
                flex-direction: column;
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
            <a href="#" class="logo"><i class="fas fa-graduation-cap"></i> ACADEMIA</a>
            <div class="nav-menu">
                <a href="#home" class="nav-link">Home</a>
                <a href="#courses" class="nav-link">Programs</a>
                <a href="#about" class="nav-link">About</a>
                <a href="#campus" class="nav-link">Campus Life</a>
            </div>
            <div style="display:flex; align-items:center; gap:15px;">
                <button class="theme-toggle" id="themeBtn" aria-label="Toggle Theme"><i class="fas fa-moon"></i></button>
                <a href="#apply" class="btn btn-primary">Apply Now</a>
            </div>
        </div>
    </nav>

    <header id="home" class="hero">
        <div class="container hero-grid">
            <div class="hero-content reveal">
                <span class="badge">Admissions Open 2025</span>
                <h1>Empowering the <br>Next Generation.</h1>
                <p>World-class education designed for the leaders of tomorrow. Join a community of innovators, thinkers, and creators.</p>
                <div style="display: flex; gap: 15px;">
                    <a href="#courses" class="btn btn-primary">Explore Programs</a>
                    <a href="#about" class="btn btn-outline">Virtual Tour</a>
                </div>
            </div>

            <div class="hero-img-box reveal">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80"
                    alt="University Students Group"
                    onerror="this.src='https://placehold.co/800x600/003366/ffffff?text=Academia+Students'">

                <div class="float-card">
                    <div class="float-icon"><i class="fas fa-user-graduate"></i></div>
                    <div>
                        <div style="font-weight: 700; color: var(--primary);">98%</div>
                        <div style="font-size: 0.8rem; color: var(--text-light);">Employment Rate</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="stats">
        <div class="container stats-grid">
            <div>
                <div class="stat-num counter" data-target="15000">0</div>
                <div class="stat-label">Students Enrolled</div>
            </div>
            <div>
                <div class="stat-num counter" data-target="120">0</div>
                <div class="stat-label">Degree Programs</div>
            </div>
            <div>
                <div class="stat-num counter" data-target="500">0</div>
                <div class="stat-label">Expert Faculty</div>
            </div>
            <div>
                <div class="stat-num counter" data-target="50">0</div>
                <div class="stat-label">Research Centers</div>
            </div>
        </div>
    </section>

    <section id="courses" class="section-padding">
        <div class="container">
            <div class="text-center reveal" style="margin-bottom: 50px;">
                <span style="color: var(--accent); font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">Academics</span>
                <h2>Explore Our Programs</h2>
            </div>

            <div class="search-bar reveal">
                <input type="text" id="courseSearch" class="search-input" placeholder="Search for a degree or course...">
                <button class="btn btn-primary" onclick="filterCourses()">Search</button>
            </div>

            <div id="courseGrid" class="programs-grid">
            </div>
        </div>
    </section>

    <section id="about" class="section-padding about-section">
        <div class="container hero-grid">
            <div class="hero-img-box reveal">
                <img src="https://images.unsplash.com/photo-1541829070764-84a7d30dd3f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="University Library"
                    onerror="this.src='https://placehold.co/800x1000/003366/ffffff?text=Library'">
            </div>
            <div class="about-content reveal">
                <h2>A Legacy of <br>Excellence.</h2>
                <p>Founded on the principles of integrity and innovation, Academia has been shaping minds for over 50 years. Our campus is a hub of creativity, research, and cultural diversity.</p>

                <ul class="check-list">
                    <li><i class="fas fa-check"></i> State-of-the-art Research Facilities</li>
                    <li><i class="fas fa-check"></i> Global Exchange Programs</li>
                    <li><i class="fas fa-check"></i> Personalized Mentorship</li>
                    <li><i class="fas fa-check"></i> Industry Partnerships</li>
                </ul>

                <a href="#" class="btn btn-primary" style="margin-top: 30px;">Read Our History</a>
            </div>
        </div>
    </section>

    <section id="apply" class="container">
        <div class="newsletter reveal">
            <div class="news-bg"></div>
            <div class="news-content">
                <h2>Ready to Start Your Journey?</h2>
                <p>Subscribe to our admissions newsletter to get updates on deadlines, scholarships, and campus events.</p>

                <form id="subscribeForm" class="news-form">
                    <input type="email" class="news-input" placeholder="Enter your email address" required>
                    <button type="submit" class="btn btn-accent">Subscribe</button>
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="#" class="logo" style="margin-bottom: 20px; color: var(--text-inverse);"><i class="fas fa-graduation-cap" style="color: var(--accent);"></i> ACADEMIA</a>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Educating the leaders of tomorrow with a commitment to excellence and integrity.</p>
                </div>
                <div>
                    <h4>Academics</h4>
                    <a href="#">Undergraduate</a>
                    <a href="#">Graduate</a>
                    <a href="#">Online Learning</a>
                    <a href="#">Summer School</a>
                </div>
                <div>
                    <h4>Admissions</h4>
                    <a href="#">How to Apply</a>
                    <a href="#">Tuition & Fees</a>
                    <a href="#">Scholarships</a>
                    <a href="#">Visit Us</a>
                </div>
                <div>
                    <h4>Contact</h4>
                    <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 10px;">123 University Ave,<br>Cambridge, MA 02138</p>
                    <p style="color: #94a3b8; font-size: 0.9rem;">+1 (800) 555-0199</p>
                </div>
            </div>
            <div class="copyright">
                &copy; <?php echo date("Y"); ?> Academia University. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        // --- 1. THEME TOGGLER ---
        const themeBtn = document.getElementById('themeBtn');
        const html = document.documentElement;

        // Load saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-theme', savedTheme);
        updateIcon(savedTheme);

        themeBtn.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateIcon(newTheme);
        });

        function updateIcon(theme) {
            const icon = themeBtn.querySelector('i');
            if (theme === 'dark') {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }

        // --- 2. DATA ---
        const courses = [{
                title: "Computer Science",
                cat: "Technology",
                duration: "4 Years",
                students: 1200,
                img: "https://images.unsplash.com/photo-1571260899304-425eee4c7efc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                instructor: "Dr. A. Smith"
            },
            {
                title: "Business Administration",
                cat: "Business",
                duration: "3 Years",
                students: 900,
                img: "https://images.unsplash.com/photo-1507679799987-c73779587ccf?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                instructor: "Prof. J. Doe"
            },
            {
                title: "Digital Marketing",
                cat: "Marketing",
                duration: "2 Years",
                students: 600,
                img: "https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                instructor: "Sarah Lee"
            },
            {
                title: "Graphic Design",
                cat: "Arts",
                duration: "3 Years",
                students: 450,
                img: "https://images.unsplash.com/photo-1626785774573-4b7993143a2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                instructor: "M. Geller"
            },
            {
                title: "Data Science",
                cat: "Technology",
                duration: "2 Years",
                students: 800,
                img: "https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                instructor: "Dr. K. West"
            },
            {
                title: "Psychology",
                cat: "Science",
                duration: "4 Years",
                students: 700,
                img: "https://images.unsplash.com/photo-1532012197267-da84d127e765?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                instructor: "Prof. R. Green"
            }
        ];

        // --- 3. RENDER COURSES ---
        const grid = document.getElementById('courseGrid');

        function renderCourses(data) {
            grid.innerHTML = '';
            data.forEach(c => {
                const card = document.createElement('div');
                card.className = 'course-card reveal';
                card.innerHTML = `
                    <div class="course-thumb">
                        <span class="course-cat">${c.cat}</span>
                        <img src="${c.img}" alt="${c.title}" onerror="this.src='https://placehold.co/600x400/e2e8f0/1e293b?text=Course'">
                    </div>
                    <div class="course-body">
                        <h3 style="font-size: 1.2rem; color: var(--primary); margin-bottom: 10px;">${c.title}</h3>
                        <div class="course-meta">
                            <span><i class="far fa-clock"></i> ${c.duration}</span>
                            <span><i class="fas fa-user-friends"></i> ${c.students} Students</span>
                        </div>
                        <div class="course-footer">
                            <div class="instructor">
                                <div class="avatar" style="background:#ccc; background-image: url('https://i.pravatar.cc/100?u=${c.instructor}'); background-size: cover;"></div>
                                <span>${c.instructor}</span>
                            </div>
                            <i class="fas fa-arrow-right" style="color: var(--primary);"></i>
                        </div>
                    </div>
                `;
                grid.appendChild(card);
            });
            // Re-trigger observer for new elements
            triggerObserver();
        }

        // --- 4. FILTER LOGIC ---
        function filterCourses() {
            const query = document.getElementById('courseSearch').value.toLowerCase();
            const filtered = courses.filter(c => c.title.toLowerCase().includes(query) || c.cat.toLowerCase().includes(query));
            renderCourses(filtered);
        }

        // --- 5. COUNTER ANIMATION ---
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
                    counter.innerText = target + "+";
                }
            });
        };

        // --- 6. SCROLL EFFECTS ---
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
            if (window.scrollY > 50) navbar.style.boxShadow = "0 5px 20px rgba(0,0,0,0.1)";
            else navbar.style.boxShadow = "none";

            // Trigger stats when visible
            const statsSection = document.querySelector('.stats');
            if (window.scrollY + window.innerHeight > statsSection.offsetTop) {
                runCounters();
            }
        });

        // --- 7. INIT ---
        document.addEventListener('DOMContentLoaded', () => {
            renderCourses(courses);

            // Form Handler
            const form = document.getElementById('subscribeForm');
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const btn = form.querySelector('button');
                btn.innerText = "Subscribed!";
                btn.style.background = "#10b981";
                form.reset();
                setTimeout(() => {
                    btn.innerText = "Subscribe";
                    btn.style.background = "";
                }, 3000);
            });
        });
    </script>
</body>

</html>