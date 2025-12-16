<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apex Medical | The Future of Care</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- 1. DESIGN TOKENS --- */
        :root {
            /* Light Theme */
            --bg-body: #ffffff;
            --bg-surface: #f8fafc;
            --bg-glass: rgba(255, 255, 255, 0.7);
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --primary: #0284c7;
            /* Professional Blue */
            --primary-light: #e0f2fe;
            --accent: #38bdf8;

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, #0284c7 0%, #0ea5e9 100%);
            --gradient-glow: radial-gradient(circle at 50% 50%, rgba(14, 165, 233, 0.15), transparent 70%);

            /* Spacing & Layout */
            --radius-sm: 8px;
            --radius-md: 16px;
            --radius-lg: 24px;
            --container-width: 1240px;
            --nav-height: 80px;

            /* Effects */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --ease: cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        [data-theme="dark"] {
            --bg-body: #020617;
            /* Deep Navy */
            --bg-surface: #0f172a;
            --bg-glass: rgba(15, 23, 42, 0.7);
            --border-color: #1e293b;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --primary: #38bdf8;
            /* Lighter blue for dark mode */
            --primary-light: rgba(56, 189, 248, 0.1);
            --gradient-glow: radial-gradient(circle at 50% 50%, rgba(56, 189, 248, 0.1), transparent 70%);
        }

        /* --- 2. BASE STYLES --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
            transition: background-color 0.4s var(--ease), color 0.4s var(--ease);
        }

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            line-height: 1.1;
            letter-spacing: -0.02em;
        }

        h1 {
            font-size: clamp(3rem, 6vw, 5rem);
        }

        h2 {
            font-size: clamp(2.2rem, 4vw, 3.5rem);
            margin-bottom: 20px;
        }

        p {
            color: var(--text-muted);
            font-size: 1.1rem;
            margin-bottom: 24px;
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

        .container {
            max-width: var(--container-width);
            margin: 0 auto;
            padding: 0 24px;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
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

        /* Floating Nav */
        .navbar {
            position: fixed;
            top: 20px;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            justify-content: center;
        }

        .nav-container {
            background: var(--bg-glass);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            padding: 12px 30px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            gap: 40px;
            box-shadow: var(--shadow-lg);
            width: 90%;
            max-width: 1000px;
            justify-content: space-between;
        }

        .brand {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand i {
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.95rem;
            color: var(--text-muted);
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        /* Buttons */
        .btn {
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s var(--ease);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.4);
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .btn-glass:hover {
            background: var(--bg-surface);
            border-color: var(--primary);
        }

        /* Theme Toggle */
        .theme-toggle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .theme-toggle:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* --- 4. HERO SECTION --- */
        .hero {
            padding-top: 180px;
            padding-bottom: 100px;
            background: var(--bg-body);
            position: relative;
            overflow: hidden;
        }

        /* Dynamic Background Glow */
        .glow-bg {
            position: absolute;
            width: 600px;
            height: 600px;
            background: var(--primary);
            filter: blur(150px);
            opacity: 0.1;
            border-radius: 50%;
            z-index: 0;
            top: -10%;
            right: -10%;
            animation: pulse 10s infinite alternate;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.1;
            }

            100% {
                transform: scale(1.2);
                opacity: 0.15;
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .tag {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 30px;
            background: var(--primary-light);
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 24px;
            border: 1px solid rgba(2, 132, 199, 0.1);
        }

        .hero-image {
            position: relative;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            height: 600px;
        }

        .hero-image img {
            transition: transform 1.5s var(--ease);
        }

        .hero-image:hover img {
            transform: scale(1.05);
        }

        /* --- 5. BENTO GRID SERVICES --- */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 320px);
            gap: 24px;
        }

        .bento-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 40px;
            position: relative;
            overflow: hidden;
            transition: 0.4s var(--ease);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .bento-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
        }

        .bento-large {
            grid-column: span 2;
        }

        .bento-tall {
            grid-row: span 2;
        }

        .bento-icon {
            width: 56px;
            height: 56px;
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .bento-img-bg {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 60%;
            mask-image: linear-gradient(to top, black, transparent);
            -webkit-mask-image: linear-gradient(to top, black, transparent);
            opacity: 0.8;
            transition: 0.5s;
        }

        .bento-card:hover .bento-img-bg {
            transform: scale(1.05);
        }

        /* --- 6. STICKY TECHNOLOGY SECTION --- */
        .sticky-wrapper {
            display: flex;
            gap: 60px;
            position: relative;
            align-items: flex-start;
        }

        .sticky-text {
            flex: 1;
            padding: 40px 0;
        }

        .sticky-visual {
            flex: 1;
            position: sticky;
            top: 140px;
            height: 500px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
        }

        .feature-block {
            padding: 40px;
            margin-bottom: 20px;
            border-radius: var(--radius-md);
            border: 1px solid transparent;
            transition: 0.3s;
            cursor: pointer;
        }

        .feature-block.active {
            background: var(--bg-surface);
            border-color: var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        .feature-block h3 {
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        /* --- 7. FAQ SECTION --- */
        .faq-accordion {
            max-width: 800px;
            margin: 0 auto;
        }

        .faq-item {
            border-bottom: 1px solid var(--border-color);
            padding: 24px 0;
        }

        .faq-question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s var(--ease);
            color: var(--text-muted);
            margin-top: 0;
        }

        .faq-item.active .faq-answer {
            max-height: 200px;
            margin-top: 16px;
        }

        .faq-icon {
            transition: transform 0.3s;
        }

        .faq-item.active .faq-icon {
            transform: rotate(180deg);
            color: var(--primary);
        }

        /* --- 8. BOOKING FORM --- */
        .booking-section {
            position: relative;
            margin-top: 100px;
        }

        .booking-card {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 60px;
            box-shadow: var(--shadow-lg);
            max-width: 900px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 16px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--bg-surface);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* --- 9. FOOTER --- */
        .footer {
            border-top: 1px solid var(--border-color);
            padding: 80px 0 40px;
            margin-top: 120px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 40px;
        }

        .footer-links a {
            display: block;
            color: var(--text-muted);
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .navbar {
                bottom: 20px;
                top: auto;
                padding: 0;
            }

            /* Bottom nav on mobile */
            .nav-container {
                width: 95%;
                padding: 15px 25px;
            }

            .nav-links {
                display: none;
            }

            .hero {
                padding-top: 60px;
            }

            .grid-2,
            .sticky-wrapper {
                grid-template-columns: 1fr;
                display: block;
            }

            .hero-image {
                height: 400px;
                margin-top: 40px;
            }

            .bento-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
            }

            .bento-large,
            .bento-tall {
                grid-column: span 1;
                grid-row: span 1;
            }

            .sticky-visual {
                display: none;
            }

            .feature-block {
                border: 1px solid var(--border-color);
                margin-bottom: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="brand"><i class="fas fa-plus-circle"></i> ApexMedical</a>

            <div class="nav-links">
                <a href="#services" class="nav-link">Expertise</a>
                <a href="#tech" class="nav-link">Technology</a>
                <a href="#faq" class="nav-link">FAQ</a>
                <a href="#book" class="nav-link">Patients</a>
            </div>

            <div class="nav-right">
                <button class="theme-toggle" id="themeBtn" aria-label="Toggle Theme">
                    <i class="fas fa-moon"></i>
                </button>
                <a href="#book" class="btn btn-primary">Book Visit</a>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="glow-bg"></div>
        <div class="container grid-2">

            <div class="hero-content">
                <span class="tag">Accepting New Patients</span>
                <h1>Precision Care.<br><span style="color: var(--primary);">Human Touch.</span></h1>
                <p>We combine top-tier robotic surgery, AI diagnostics, and a luxury environment to redefine your healthcare experience.</p>

                <div style="display: flex; gap: 15px; margin-bottom: 40px;">
                    <a href="#book" class="btn btn-primary">Book Appointment</a>
                    <a href="#services" class="btn btn-glass">Explore Services</a>
                </div>

                <div style="display: flex; gap: 40px; border-top: 1px solid var(--border-color); padding-top: 30px;">
                    <div>
                        <h3 style="font-size: 2rem; margin-bottom: 0;">4.9</h3>
                        <p style="font-size: 0.9rem; margin: 0;">Google Rating</p>
                    </div>
                    <div>
                        <h3 style="font-size: 2rem; margin-bottom: 0;">15k+</h3>
                        <p style="font-size: 0.9rem; margin: 0;">Patients Treated</p>
                    </div>
                </div>
            </div>

            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
                    alt="Modern Clinic"
                    onerror="this.src='https://placehold.co/800x600/e2e8f0/64748b?text=Medical+Facility'">
            </div>

        </div>
    </header>

    <section id="services" class="section-padding">
        <div class="container">
            <div class="text-center" style="margin-bottom: 80px;">
                <span class="tag">Our Expertise</span>
                <h2>Comprehensive Solutions</h2>
            </div>

            <div class="bento-grid">
                <div class="bento-card bento-large">
                    <div>
                        <div class="bento-icon"><i class="fas fa-robot"></i></div>
                        <h3>Robotic Surgery</h3>
                        <p>Minimally invasive procedures with micron-level precision using the Da Vinci X system.</p>
                    </div>
                    <div class="bento-img-bg">
                        <img src="https://images.unsplash.com/photo-1530497610245-94d3c16cda28?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Robotic Surgery" onerror="this.style.display='none'">
                    </div>
                </div>

                <div class="bento-card bento-tall">
                    <div>
                        <div class="bento-icon"><i class="fas fa-heartbeat"></i></div>
                        <h3>Cardiology</h3>
                        <p>Complete heart health monitoring, stress testing, and vascular care in one facility.</p>
                    </div>
                    <div class="bento-img-bg" style="height: 40%;">
                        <img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Cardio" onerror="this.style.display='none'">
                    </div>
                </div>

                <div class="bento-card">
                    <div class="bento-icon"><i class="fas fa-brain"></i></div>
                    <h3>Neurology</h3>
                    <p>Advanced MRI diagnostics.</p>
                </div>

                <div class="bento-card">
                    <div class="bento-icon"><i class="fas fa-dna"></i></div>
                    <h3>Genetics</h3>
                    <p>Preventative DNA screening.</p>
                </div>

                <div class="bento-card">
                    <div class="bento-icon"><i class="fas fa-tooth"></i></div>
                    <h3>Dental</h3>
                    <p>Cosmetic and surgical dentistry.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tech" class="section-padding" style="background: var(--bg-surface);">
        <div class="container">
            <div class="text-center" style="margin-bottom: 80px;">
                <span class="tag">Technology</span>
                <h2>Digital Precision</h2>
            </div>

            <div class="sticky-wrapper">
                <div class="sticky-text">

                    <div class="feature-block active" data-img="https://images.unsplash.com/photo-1551076882-68b47d190600?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80">
                        <span style="color: var(--primary); font-weight:700; font-size: 0.9rem;">01. IMAGING</span>
                        <h3>3D CBCT Scanning</h3>
                        <p>We create a full 3D model of your anatomy for zero-error planning. Low radiation, high definition results in seconds.</p>
                    </div>

                    <div class="feature-block" data-img="https://images.unsplash.com/photo-1581093450021-4a7360e9a6b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80">
                        <span style="color: var(--primary); font-weight:700; font-size: 0.9rem;">02. AI DIAGNOSTICS</span>
                        <h3>Machine Learning Analysis</h3>
                        <p>Our AI systems analyze scans to detect issues years before they become visible to the human eye.</p>
                    </div>

                    <div class="feature-block" data-img="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80">
                        <span style="color: var(--primary); font-weight:700; font-size: 0.9rem;">03. LAB</span>
                        <h3>In-House Bio Lab</h3>
                        <p>Get blood work and biopsy results in hours, not days. Our on-site lab ensures rapid treatment paths.</p>
                    </div>

                </div>

                <div class="sticky-visual">
                    <img id="techImg" src="https://images.unsplash.com/photo-1551076882-68b47d190600?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Tech Visual"
                        onerror="this.src='https://placehold.co/600x600/e2e8f0/64748b?text=Medical+Tech'">
                </div>
            </div>
        </div>
    </section>

    <section id="faq" class="section-padding">
        <div class="container">
            <div class="text-center" style="margin-bottom: 60px;">
                <span class="tag">FAQ</span>
                <h2>Patient Resources</h2>
            </div>

            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do you accept major insurance plans?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we partner with most major providers including BlueCross, Aetna, Cigna, and UnitedHealthcare. Our billing team handles all pre-authorizations for you.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>What should I bring to my first visit?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Please bring a valid photo ID, your insurance card, and any relevant medical records or prior imaging. We recommend arriving 15 minutes early.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>Is robotic surgery safe?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Robotic surgery is FDA-approved and widely used. It allows for smaller incisions, less pain, and faster recovery times compared to traditional surgery.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do you offer emergency appointments?</span>
                        <i class="fas fa-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we reserve daily slots for urgent care. Please call our dedicated emergency line or book online selecting "Urgent Care".</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="book" class="booking-section">
        <div class="container">
            <div class="booking-card">
                <div class="text-center" style="margin-bottom: 40px;">
                    <h2>Begin Your Journey</h2>
                    <p>Secure your consultation time slot below.</p>
                </div>

                <form id="bookingForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" class="form-input" placeholder="Jane Doe" required>
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" class="form-input" placeholder="(555) 000-0000" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Department</label>
                            <select class="form-input">
                                <option>General Checkup</option>
                                <option>Dental</option>
                                <option>Cardiology</option>
                                <option>Surgery Consult</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Preferred Date</label>
                            <input type="date" class="form-input" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Confirm Request</button>
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px;">
                <div>
                    <a href="#" class="brand" style="margin-bottom: 20px; display:block;">
                        <i class="fas fa-plus-circle"></i> ApexMedical
                    </a>
                    <p style="font-size: 0.9rem;">Redefining the standard of care through compassion and innovation.</p>
                </div>
                <div class="footer-links">
                    <h4 style="margin-bottom: 20px; font-size: 1.1rem;">Departments</h4>
                    <a href="#">Cardiology</a>
                    <a href="#">Neurology</a>
                    <a href="#">Pediatrics</a>
                    <a href="#">Dental</a>
                </div>
                <div class="footer-links">
                    <h4 style="margin-bottom: 20px; font-size: 1.1rem;">Patients</h4>
                    <a href="#">Portal Login</a>
                    <a href="#">Insurance</a>
                    <a href="#">Bill Pay</a>
                    <a href="#">FAQ</a>
                </div>
                <div class="footer-links">
                    <h4 style="margin-bottom: 20px; font-size: 1.1rem;">Contact</h4>
                    <a href="#">1200 Medical Plaza, NY</a>
                    <a href="#">+1 (800) 123-4567</a>
                    <a href="#">hello@apexmed.com</a>
                </div>
            </div>
            <div class="text-center" style="margin-top: 80px; padding-top: 30px; border-top: 1px solid var(--border-color); color: var(--text-muted); font-size: 0.85rem;">
                &copy; <?php echo date("Y"); ?> Apex Medical Center. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // 1. THEME TOGGLER
            const themeBtn = document.getElementById('themeBtn');
            const html = document.documentElement;
            const icon = themeBtn.querySelector('i');

            // Load saved theme
            const savedTheme = localStorage.getItem('theme') || 'light';
            html.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'dark') icon.classList.replace('fa-moon', 'fa-sun');

            themeBtn.addEventListener('click', () => {
                const current = html.getAttribute('data-theme');
                const next = current === 'light' ? 'dark' : 'light';
                html.setAttribute('data-theme', next);
                localStorage.setItem('theme', next);

                if (next === 'dark') {
                    icon.classList.replace('fa-moon', 'fa-sun');
                } else {
                    icon.classList.replace('fa-sun', 'fa-moon');
                }
            });

            // 2. STICKY SCROLL IMAGE SWAP
            const featureBlocks = document.querySelectorAll('.feature-block');
            const techImg = document.getElementById('techImg');

            const observerOptions = {
                root: null,
                threshold: 0.6
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Update active class
                        featureBlocks.forEach(b => b.classList.remove('active'));
                        entry.target.classList.add('active');

                        // Swap image with fade effect
                        const newSrc = entry.target.getAttribute('data-img');
                        techImg.style.opacity = 0;
                        setTimeout(() => {
                            techImg.src = newSrc;
                            techImg.onload = () => {
                                techImg.style.opacity = 1;
                            };
                        }, 200);
                    }
                });
            }, observerOptions);

            featureBlocks.forEach(block => observer.observe(block));

            // 3. FORM ANIMATION
            const form = document.getElementById('bookingForm');
            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const btn = form.querySelector('button');
                    const originalText = btn.innerText;

                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                    btn.style.opacity = '0.8';

                    setTimeout(() => {
                        btn.innerHTML = '<i class="fas fa-check"></i> Confirmed';
                        btn.style.background = '#10b981'; // Green
                        btn.style.boxShadow = 'none';
                        form.reset();

                        setTimeout(() => {
                            btn.innerText = originalText;
                            btn.style.background = ''; // Revert to CSS var
                            btn.style.opacity = '1';
                        }, 3000);
                    }, 1500);
                });
            }

            // 4. FAQ ACCORDION
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                question.addEventListener('click', () => {
                    // Close others
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) otherItem.classList.remove('active');
                    });
                    item.classList.toggle('active');
                });
            });
        });
    </script>
</body>

</html>