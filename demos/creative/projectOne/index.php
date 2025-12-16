<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creative Studio | Where Ideas Come Alive</title>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Instrument+Serif:ital@0;1&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0a0a0a;
            --secondary: #f5f5f0;
            --accent: #c8ff00;
            --muted: #6b6b6b;
            --card-bg: #1a1a1a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: var(--primary);
            color: var(--secondary);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Custom Cursor */
        .cursor {
            width: 20px;
            height: 20px;
            border: 2px solid var(--accent);
            border-radius: 50%;
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            transition: transform 0.15s ease, opacity 0.15s ease;
            transform: translate(-50%, -50%);
        }

        .cursor.hover {
            transform: translate(-50%, -50%) scale(2);
            background: var(--accent);
            opacity: 0.3;
        }

        /* Loader */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        .loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-text {
            font-size: clamp(2rem, 8vw, 6rem);
            font-family: 'Instrument Serif', serif;
            font-style: italic;
            color: var(--accent);
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.3; transform: scale(0.98); }
            50% { opacity: 1; transform: scale(1); }
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            mix-blend-mode: difference;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--secondary);
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            list-style: none;
        }

        .nav-links a {
            color: var(--secondary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .menu-btn {
            display: none;
            flex-direction: column;
            gap: 6px;
            cursor: pointer;
            z-index: 1001;
        }

        .menu-btn span {
            width: 30px;
            height: 2px;
            background: var(--secondary);
            transition: all 0.3s ease;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse at 30% 20%, rgba(200, 255, 0, 0.08) 0%, transparent 50%),
                        radial-gradient(ellipse at 70% 80%, rgba(200, 255, 0, 0.05) 0%, transparent 50%);
        }

        .hero-title {
            font-size: clamp(3rem, 12vw, 10rem);
            font-family: 'Instrument Serif', serif;
            font-weight: 400;
            line-height: 0.95;
            margin-bottom: 2rem;
            opacity: 0;
            transform: translateY(100px);
            animation: slideUp 1s ease forwards 0.5s;
        }

        .hero-title span {
            display: block;
            font-style: italic;
            color: var(--accent);
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.25rem);
            color: var(--muted);
            max-width: 500px;
            opacity: 0;
            animation: fadeIn 1s ease forwards 1s;
        }

        .scroll-indicator {
            position: absolute;
            bottom: 3rem;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            opacity: 0;
            animation: fadeIn 1s ease forwards 1.5s;
        }

        .scroll-indicator span {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            color: var(--muted);
        }

        .scroll-line {
            width: 1px;
            height: 60px;
            background: linear-gradient(to bottom, var(--accent), transparent);
            animation: scrollLine 2s ease-in-out infinite;
        }

        @keyframes scrollLine {
            0%, 100% { transform: scaleY(0); transform-origin: top; }
            50% { transform: scaleY(1); transform-origin: top; }
            51% { transform-origin: bottom; }
            100% { transform: scaleY(0); transform-origin: bottom; }
        }

        /* Categories Section */
        .categories {
            padding: 8rem 3rem;
            position: relative;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 4rem;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .section-title {
            font-size: clamp(2rem, 5vw, 4rem);
            font-family: 'Instrument Serif', serif;
            font-weight: 400;
        }

        .section-title span {
            font-style: italic;
            color: var(--accent);
        }

        .section-count {
            font-size: 0.875rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .category-card {
            position: relative;
            aspect-ratio: 4/5;
            overflow: hidden;
            border-radius: 1rem;
            cursor: pointer;
            background: var(--card-bg);
        }

        .category-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .category-card:hover img {
            transform: scale(1.1);
        }

        .category-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 2rem;
            transition: background 0.5s ease;
        }

        .category-card:hover .category-overlay {
            background: linear-gradient(to top, rgba(0,0,0,0.95) 0%, rgba(0,0,0,0.5) 100%);
        }

        .category-number {
            font-size: 0.75rem;
            color: var(--accent);
            margin-bottom: 0.5rem;
            font-weight: 600;
            letter-spacing: 0.2em;
        }

        .category-name {
            font-size: clamp(1.5rem, 3vw, 2.5rem);
            font-family: 'Instrument Serif', serif;
            margin-bottom: 0.75rem;
            transform: translateY(20px);
            opacity: 0.9;
            transition: all 0.5s ease;
        }

        .category-card:hover .category-name {
            transform: translateY(0);
            opacity: 1;
        }

        .category-desc {
            font-size: 0.875rem;
            color: var(--muted);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease, opacity 0.5s ease;
            opacity: 0;
        }

        .category-card:hover .category-desc {
            max-height: 100px;
            opacity: 1;
        }

        .category-arrow {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            width: 40px;
            height: 40px;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(-45deg);
            transition: all 0.5s ease;
        }

        .category-card:hover .category-arrow {
            background: var(--accent);
            border-color: var(--accent);
            transform: rotate(0deg);
        }

        .category-arrow svg {
            width: 16px;
            height: 16px;
            stroke: var(--secondary);
            transition: stroke 0.3s ease;
        }

        .category-card:hover .category-arrow svg {
            stroke: var(--primary);
        }

        /* Featured Category - Large */
        .category-card.featured {
            grid-column: span 2;
            grid-row: span 2;
        }

        /* Marquee */
        .marquee {
            padding: 4rem 0;
            overflow: hidden;
            border-top: 1px solid rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .marquee-content {
            display: flex;
            gap: 4rem;
            animation: marquee 20s linear infinite;
            width: max-content;
        }

        .marquee-item {
            font-size: clamp(2rem, 6vw, 5rem);
            font-family: 'Instrument Serif', serif;
            font-style: italic;
            white-space: nowrap;
            color: transparent;
            -webkit-text-stroke: 1px var(--secondary);
            transition: all 0.3s ease;
        }

        .marquee-item:hover {
            color: var(--accent);
            -webkit-text-stroke: 1px var(--accent);
        }

        .marquee-dot {
            color: var(--accent);
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Stats Section */
        .stats {
            padding: 8rem 3rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
        }

        .stat-item {
            text-align: center;
            opacity: 0;
            transform: translateY(50px);
        }

        .stat-item.visible {
            animation: slideUp 0.8s ease forwards;
        }

        .stat-number {
            font-size: clamp(3rem, 8vw, 6rem);
            font-family: 'Instrument Serif', serif;
            color: var(--accent);
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.15em;
        }

        /* Process Section */
        .process {
            padding: 8rem 3rem;
            background: var(--card-bg);
        }

        .process-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 4rem;
        }

        .process-step {
            padding: 3rem 2rem;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 1rem;
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .process-step::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--accent) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .process-step:hover::before {
            opacity: 0.05;
        }

        .process-step:hover {
            border-color: var(--accent);
            transform: translateY(-10px);
        }

        .step-number {
            font-size: 4rem;
            font-family: 'Instrument Serif', serif;
            color: var(--accent);
            opacity: 0.3;
            line-height: 1;
            margin-bottom: 1.5rem;
        }

        .step-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .step-desc {
            color: var(--muted);
            font-size: 0.9375rem;
            line-height: 1.7;
        }

        /* CTA Section */
        .cta {
            padding: 10rem 3rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(200, 255, 0, 0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .cta-title {
            font-size: clamp(2.5rem, 8vw, 7rem);
            font-family: 'Instrument Serif', serif;
            line-height: 1.1;
            margin-bottom: 2rem;
            position: relative;
        }

        .cta-title span {
            font-style: italic;
            display: block;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem 3rem;
            background: var(--accent);
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 100px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .cta-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: var(--secondary);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .cta-btn:hover::before {
            width: 300%;
            height: 300%;
        }

        .cta-btn span {
            position: relative;
            z-index: 1;
        }

        .cta-btn svg {
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .cta-btn:hover svg {
            transform: translateX(5px);
        }

        /* Footer */
        footer {
            padding: 4rem 3rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .footer-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .footer-links a {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--accent);
        }

        .footer-social {
            display: flex;
            gap: 1rem;
        }

        .footer-social a {
            width: 40px;
            height: 40px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .footer-social a:hover {
            background: var(--accent);
            border-color: var(--accent);
        }

        .footer-social svg {
            width: 18px;
            height: 18px;
            fill: var(--secondary);
            transition: fill 0.3s ease;
        }

        .footer-social a:hover svg {
            fill: var(--primary);
        }

        /* Animations */
        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .category-card.featured {
                grid-column: span 2;
                grid-row: span 1;
                aspect-ratio: 16/9;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .process-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 1rem 1.5rem;
            }

            .nav-links {
                display: none;
            }

            .menu-btn {
                display: flex;
            }

            .categories,
            .stats,
            .process,
            .cta {
                padding: 4rem 1.5rem;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }

            .category-card.featured {
                grid-column: span 1;
                aspect-ratio: 4/5;
            }

            .stats {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }
        }

        /* Reveal Animation Classes */
        .reveal {
            opacity: 0;
            transform: translateY(60px);
            transition: all 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Stagger children */
        .stagger-children > * {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .stagger-children.visible > *:nth-child(1) { transition-delay: 0.1s; }
        .stagger-children.visible > *:nth-child(2) { transition-delay: 0.2s; }
        .stagger-children.visible > *:nth-child(3) { transition-delay: 0.3s; }
        .stagger-children.visible > *:nth-child(4) { transition-delay: 0.4s; }
        .stagger-children.visible > *:nth-child(5) { transition-delay: 0.5s; }
        .stagger-children.visible > *:nth-child(6) { transition-delay: 0.6s; }

        .stagger-children.visible > * {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Custom Cursor -->
    <div class="cursor"></div>

    <!-- Loader -->
    <div class="loader">
        <div class="loader-text">Creative</div>
    </div>

    <!-- Navigation -->
    <nav>
        <div class="logo">STUDIO</div>
        <ul class="nav-links">
            <li><a href="#work">Work</a></li>
            <li><a href="#process">Process</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="menu-btn">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <h1 class="hero-title">
            Creative
            <span>Categories</span>
        </h1>
        <p class="hero-subtitle">
            Where imagination meets innovation. Explore our curated collection of creative disciplines that push boundaries.
        </p>
        <div class="scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories" id="work">
        <div class="section-header reveal">
            <h2 class="section-title">Our <span>Expertise</span></h2>
            <span class="section-count">06 Categories</span>
        </div>

        <div class="categories-grid stagger-children">
            <!-- Featured Category -->
            <div class="category-card featured">
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=1200&q=80" alt="Design">
                <div class="category-overlay">
                    <span class="category-number">01</span>
                    <h3 class="category-name">Design</h3>
                    <p class="category-desc">Brand identity, UI/UX, motion graphics, and visual storytelling that captivates audiences.</p>
                </div>
                <div class="category-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 17L17 7M17 7H7M17 7V17"/>
                    </svg>
                </div>
            </div>

            <!-- Photography -->
            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1452587925148-ce544e77e70d?w=800&q=80" alt="Photography">
                <div class="category-overlay">
                    <span class="category-number">02</span>
                    <h3 class="category-name">Photography</h3>
                    <p class="category-desc">Capturing moments that tell powerful stories through lens artistry.</p>
                </div>
                <div class="category-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 17L17 7M17 7H7M17 7V17"/>
                    </svg>
                </div>
            </div>

            <!-- Art Direction -->
            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1547826039-bfc35e0f1ea8?w=800&q=80" alt="Art Direction">
                <div class="category-overlay">
                    <span class="category-number">03</span>
                    <h3 class="category-name">Art Direction</h3>
                    <p class="category-desc">Guiding visual narratives with bold creative vision.</p>
                </div>
                <div class="category-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 17L17 7M17 7H7M17 7V17"/>
                    </svg>
                </div>
            </div>

            <!-- Film & Video -->
            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1485846234645-a62644f84728?w=800&q=80" alt="Film">
                <div class="category-overlay">
                    <span class="category-number">04</span>
                    <h3 class="category-name">Film & Video</h3>
                    <p class="category-desc">Cinematic experiences that move hearts and minds.</p>
                </div>
                <div class="category-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 17L17 7M17 7H7M17 7V17"/>
                    </svg>
                </div>
            </div>

            <!-- Music -->
            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=800&q=80" alt="Music">
                <div class="category-overlay">
                    <span class="category-number">05</span>
                    <h3 class="category-name">Music</h3>
                    <p class="category-desc">Sound design and composition that resonates deeply.</p>
                </div>
                <div class="category-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 17L17 7M17 7H7M17 7V17"/>
                    </svg>
                </div>
            </div>

            <!-- Fashion -->
            <div class="category-card">
                <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?w=800&q=80" alt="Fashion">
                <div class="category-overlay">
                    <span class="category-number">06</span>
                    <h3 class="category-name">Fashion</h3>
                    <p class="category-desc">Style narratives that define culture and identity.</p>
                </div>
                <div class="category-arrow">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M7 17L17 7M17 7H7M17 7V17"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- Marquee -->
    <div class="marquee">
        <div class="marquee-content">
            <span class="marquee-item">Design <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Photography <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Art Direction <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Film <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Music <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Fashion <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Design <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Photography <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Art Direction <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Film <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Music <span class="marquee-dot">•</span></span>
            <span class="marquee-item">Fashion <span class="marquee-dot">•</span></span>
        </div>
    </div>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stat-item">
            <div class="stat-number">250+</div>
            <div class="stat-label">Projects Completed</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">15</div>
            <div class="stat-label">Years Experience</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">98%</div>
            <div class="stat-label">Client Satisfaction</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">40+</div>
            <div class="stat-label">Awards Won</div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="process" id="process">
        <div class="section-header reveal">
            <h2 class="section-title">Our <span>Process</span></h2>
        </div>

        <div class="process-grid stagger-children">
            <div class="process-step">
                <div class="step-number">1</div>
                <h3 class="step-title">Immerse</h3>
                <p class="step-desc">We dive deep into culture, your business goals, and audience needs to uncover authentic insights.</p>
            </div>
            <div class="process-step">
                <div class="step-number">2</div>
                <h3 class="step-title">Create</h3>
                <p class="step-desc">We bring brands to life visually and verbally through strategic design and compelling storytelling.</p>
            </div>
            <div class="process-step">
                <div class="step-number">3</div>
                <h3 class="step-title">Impact</h3>
                <p class="step-desc">We set you up for lasting success with measurable results and continuous growth strategies.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="contact">
        <div class="cta-bg"></div>
        <h2 class="cta-title reveal">
            Ready to Move
            <span>Culture?</span>
        </h2>
        <a href="#" class="cta-btn">
            <span>Get in Touch</span>
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M5 12h14M12 5l7 7-7 7"/>
            </svg>
        </a>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-logo">STUDIO</div>
            <ul class="footer-links">
                <li><a href="#">Privacy</a></li>
                <li><a href="#">Terms</a></li>
                <li><a href="#">Careers</a></li>
            </ul>
            <div class="footer-social">
                <a href="#" aria-label="Instagram">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                <a href="#" aria-label="Twitter">
                    <svg viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>
                <a href="#" aria-label="LinkedIn">
                    <svg viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <script>
        // Loader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.querySelector('.loader').classList.add('hidden');
            }, 1500);
        });

        // Custom Cursor
        const cursor = document.querySelector('.cursor');
        let mouseX = 0, mouseY = 0;
        let cursorX = 0, cursorY = 0;

        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        function animateCursor() {
            cursorX += (mouseX - cursorX) * 0.1;
            cursorY += (mouseY - cursorY) * 0.1;
            cursor.style.left = cursorX + 'px';
            cursor.style.top = cursorY + 'px';
            requestAnimationFrame(animateCursor);
        }
        animateCursor();

        // Cursor hover effect
        const hoverElements = document.querySelectorAll('a, button, .category-card, .process-step');
        hoverElements.forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('hover'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('hover'));
        });

        // Hide cursor on mobile
        if ('ontouchstart' in window) {
            cursor.style.display = 'none';
        }

        // Scroll Reveal
        const revealElements = document.querySelectorAll('.reveal, .stagger-children, .stat-item');
        
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        revealElements.forEach(el => revealObserver.observe(el));

        // Counter Animation for Stats
        const statNumbers = document.querySelectorAll('.stat-number');
        
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const text = target.innerText;
                    const hasPlus = text.includes('+');
                    const hasPercent = text.includes('%');
                    const number = parseInt(text);
                    
                    let current = 0;
                    const increment = number / 50;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= number) {
                            current = number;
                            clearInterval(timer);
                        }
                        target.innerText = Math.floor(current) + (hasPlus ? '+' : '') + (hasPercent ? '%' : '');
                    }, 30);
                    
                    counterObserver.unobserve(target);
                }
            });
        }, { threshold: 0.5 });

        statNumbers.forEach(el => counterObserver.observe(el));

        // Parallax effect on hero
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('.hero-title');
            if (hero) {
                hero.style.transform = `translateY(${scrolled * 0.3}px)`;
            }
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>