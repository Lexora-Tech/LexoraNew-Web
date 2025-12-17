<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Lexora Tech - Enterprise-grade digital architecture and interface systems">
    <meta name="theme-color" content="#020203">

    <title>Lexora Tech | DEMOS</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.png" />

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg-body: #020203;
            --bg-card: #0A0A0C;
            --bg-glass: rgba(20, 20, 25, 0.8);
            --border-dim: rgba(255, 255, 255, 0.06);
            --border-highlight: rgba(255, 255, 255, 0.18);
            --text-main: #FFFFFF;
            --text-muted: #9CA3AF;
            --accent-cyan: #00f5ff;
            --accent-purple: #a855f7;
            --accent-blue: #3b82f6;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, sans-serif;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1.6;
        }

        /* ==================== LOADER ==================== */
        .loader-wrapper {
            position: fixed;
            inset: 0;
            background: var(--bg-body);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 40px;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }

        .loader-wrapper.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .loader-logo {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(28px, 5vw, 40px);
            font-weight: 700;
            background: linear-gradient(135deg, #fff 0%, #666 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: pulse 2s ease-in-out infinite;
        }

        .loader-container {
            position: relative;
            width: 120px;
            height: 120px;
        }

        .loader-ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 2px solid transparent;
        }

        .loader-ring:nth-child(1) {
            border-top-color: var(--accent-cyan);
            animation: spin 1.2s linear infinite;
        }

        .loader-ring:nth-child(2) {
            inset: 10px;
            border-right-color: var(--accent-purple);
            animation: spin 1.5s linear infinite reverse;
        }

        .loader-ring:nth-child(3) {
            inset: 20px;
            border-bottom-color: var(--accent-blue);
            animation: spin 1s linear infinite;
        }

        .loader-core {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-purple));
            border-radius: 50%;
            animation: glow 1.5s ease-in-out infinite alternate;
        }

        .loader-progress {
            width: 200px;
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .loader-progress-bar {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--accent-cyan), var(--accent-purple), var(--accent-blue));
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .loader-text {
            font-size: 12px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--text-muted);
            animation: flicker 1.5s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 20px var(--accent-cyan), 0 0 40px rgba(0, 245, 255, 0.3);
            }

            to {
                box-shadow: 0 0 30px var(--accent-purple), 0 0 60px rgba(168, 85, 247, 0.3);
            }
        }

        @keyframes flicker {

            0%,
            100% {
                opacity: 0.6;
            }

            50% {
                opacity: 1;
            }
        }

        /* ==================== AMBIENT EFFECTS ==================== */
        .ambient-light {
            position: fixed;
            top: -20%;
            left: 50%;
            transform: translateX(-50%);
            width: 100vw;
            height: 70vh;
            background: radial-gradient(ellipse at center, rgba(59, 130, 246, 0.08) 0%, rgba(168, 85, 247, 0.04) 30%, transparent 70%);
            filter: blur(80px);
            z-index: -1;
            pointer-events: none;
            animation: ambientShift 10s ease-in-out infinite alternate;
        }

        @keyframes ambientShift {
            0% {
                transform: translateX(-50%) scale(1);
                opacity: 0.8;
            }

            100% {
                transform: translateX(-50%) scale(1.1);
                opacity: 1;
            }
        }

        .grid-overlay {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: -1;
            pointer-events: none;
            mask-image: radial-gradient(ellipse at center, black 20%, transparent 70%);
        }

        /* ==================== LAYOUT ==================== */
        .container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        @media (min-width: 768px) {
            .container {
                padding: 0 40px;
            }
        }

        /* ==================== HERO SECTION ==================== */
        .showcase-header {
            padding: 140px 0 60px;
            text-align: center;
            position: relative;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.3s;
        }

        @media (min-width: 768px) {
            .showcase-header {
                padding: 180px 0 80px;
            }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            border: 1px solid var(--border-dim);
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.02);
            font-family: 'Space Grotesk', sans-serif;
            font-size: 11px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 28px;
            backdrop-filter: blur(10px);
        }

        .hero-badge::before {
            content: '';
            width: 8px;
            height: 8px;
            background: linear-gradient(135deg, var(--accent-cyan), var(--accent-blue));
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        .main-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(36px, 7vw, 85px);
            font-weight: 700;
            line-height: 1.05;
            letter-spacing: -0.03em;
            margin-bottom: 24px;
            background: linear-gradient(180deg, #fff 20%, #555 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-wrap: balance;
        }

        .main-subtitle {
            font-size: clamp(15px, 2.5vw, 18px);
            color: var(--text-muted);
            font-weight: 300;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
        }

        /* ==================== FILTER DOCK ==================== */
        .filter-sticky-wrapper {
            position: sticky;
            top: 16px;
            z-index: 100;
            display: flex;
            justify-content: center;
            margin-bottom: 60px;
            padding: 0 10px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.8s ease forwards;
            animation-delay: 0.5s;
        }

        @media (min-width: 768px) {
            .filter-sticky-wrapper {
                margin-bottom: 80px;
            }
        }

        .filter-glass-dock {
            background: var(--bg-glass);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-dim);
            padding: 8px;
            border-radius: 18px;
            box-shadow:
                0 20px 60px -15px rgba(0, 0, 0, 0.6),
                0 0 0 1px rgba(255, 255, 255, 0.05) inset;
            max-width: 100%;
            overflow-x: auto;
            display: flex;
            gap: 4px;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .filter-glass-dock::-webkit-scrollbar {
            display: none;
        }

        .dock-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding: 10px 18px;
            font-size: 13px;
            font-family: 'Outfit', sans-serif;
            font-weight: 500;
            border-radius: 12px;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .dock-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .dock-btn:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.06);
        }

        .dock-btn:hover::before {
            opacity: 1;
        }

        .dock-btn.active {
            background: #fff;
            color: #000;
            font-weight: 600;
            box-shadow:
                0 8px 25px rgba(255, 255, 255, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.2);
        }

        .dock-btn.active::before {
            display: none;
        }

        /* ==================== GRID ==================== */
        .projects-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
            padding-bottom: 100px;
        }

        @media (min-width: 640px) {
            .projects-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 28px;
            }
        }

        @media (min-width: 1024px) {
            .projects-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 32px;
            }
        }

        .project-item {
            opacity: 0;
            transform: translateY(40px);
            animation: cardReveal 0.7s ease forwards;
        }

        @keyframes cardReveal {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Staggered animation delays */
        .project-item:nth-child(1) {
            animation-delay: 0.6s;
        }

        .project-item:nth-child(2) {
            animation-delay: 0.7s;
        }

        .project-item:nth-child(3) {
            animation-delay: 0.8s;
        }

        .project-item:nth-child(4) {
            animation-delay: 0.9s;
        }

        .project-item:nth-child(5) {
            animation-delay: 1.0s;
        }

        .project-item:nth-child(6) {
            animation-delay: 1.1s;
        }

        .project-item:nth-child(7) {
            animation-delay: 1.2s;
        }

        .project-item:nth-child(8) {
            animation-delay: 1.3s;
        }

        .project-item:nth-child(9) {
            animation-delay: 1.4s;
        }

        .project-item:nth-child(10) {
            animation-delay: 1.5s;
        }

        .project-item:nth-child(11) {
            animation-delay: 1.6s;
        }

        .project-item:nth-child(12) {
            animation-delay: 1.7s;
        }

        .project-item:nth-child(13) {
            animation-delay: 1.8s;
        }

        .project-item:nth-child(14) {
            animation-delay: 1.9s;
        }

        .project-item:nth-child(15) {
            animation-delay: 2.0s;
        }

        .project-item:nth-child(16) {
            animation-delay: 2.1s;
        }

        .project-item:nth-child(17) {
            animation-delay: 2.2s;
        }

        /* ==================== HYPER CARDS ==================== */
        .card-link {
            display: block;
            height: 100%;
            text-decoration: none;
            outline: none;
        }

        .card-link:focus-visible .hyper-card {
            border-color: var(--accent-cyan);
            box-shadow: 0 0 0 2px var(--accent-cyan);
        }

        .hyper-card {
            background: var(--bg-card);
            border: 1px solid var(--border-dim);
            border-radius: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition:
                transform 0.5s cubic-bezier(0.23, 1, 0.32, 1),
                box-shadow 0.5s ease,
                border-color 0.5s ease;
            position: relative;
        }

        .hyper-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 245, 255, 0.03) 0%, rgba(168, 85, 247, 0.03) 100%);
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
            z-index: 1;
        }

        .hyper-card:hover {
            transform: translateY(-12px) scale(1.01);
            box-shadow:
                0 35px 70px -20px rgba(0, 0, 0, 0.7),
                0 0 60px -10px rgba(0, 245, 255, 0.1);
            border-color: var(--border-highlight);
        }

        .hyper-card:hover::before {
            opacity: 1;
        }

        /* Browser Chrome */
        .card-chrome {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-dim);
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255, 255, 255, 0.015);
            position: relative;
            z-index: 2;
        }

        .traffic-lights {
            display: flex;
            gap: 7px;
        }

        .light {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #2a2a2a;
            transition: all 0.4s ease;
        }

        .hyper-card:hover .light:nth-child(1) {
            background: #ff5f56;
            box-shadow: 0 0 8px #ff5f56;
        }

        .hyper-card:hover .light:nth-child(2) {
            background: #ffbd2e;
            box-shadow: 0 0 8px #ffbd2e;
        }

        .hyper-card:hover .light:nth-child(3) {
            background: #27c93f;
            box-shadow: 0 0 8px #27c93f;
        }

        .address-bar {
            height: 7px;
            border-radius: 4px;
            background: #1a1a1a;
            flex-grow: 1;
            max-width: 120px;
            transition: all 0.5s ease;
        }

        .hyper-card:hover .address-bar {
            background: linear-gradient(90deg, #2a2a2a, #3a3a3a);
            max-width: 180px;
        }

        /* Card Viewport */
        .card-viewport {
            height: 220px;
            overflow: hidden;
            position: relative;
            background: #000;
        }

        @media (min-width: 768px) {
            .card-viewport {
                height: 250px;
            }
        }

        .card-viewport img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.23, 1, 0.32, 1);
            filter: brightness(0.85) saturate(0.9);
        }

        .hyper-card:hover .card-viewport img {
            transform: scale(1.08);
            filter: brightness(1.05) saturate(1.1);
        }

        /* Card Info */
        .card-info {
            padding: 22px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            position: relative;
            z-index: 2;
        }

        @media (min-width: 768px) {
            .card-info {
                padding: 26px;
            }
        }

        .card-cat {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
            color: var(--accent-cyan);
            margin-bottom: 12px;
            opacity: 0.8;
        }

        .card-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(18px, 2.5vw, 22px);
            color: #fff;
            margin-bottom: 10px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .hyper-card:hover .card-title {
            background: linear-gradient(135deg, #fff, var(--accent-cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-desc {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.65;
            margin-bottom: 22px;
            flex-grow: 1;
        }

        /* Card Footer */
        .card-footer {
            margin-top: auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            border-top: 1px solid var(--border-dim);
            padding-top: 18px;
        }

        .tech-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .tech-pill {
            font-size: 10px;
            padding: 5px 10px;
            border: 1px solid var(--border-dim);
            border-radius: 6px;
            color: #777;
            background: rgba(255, 255, 255, 0.02);
            transition: all 0.3s ease;
        }

        .hyper-card:hover .tech-pill {
            border-color: rgba(0, 245, 255, 0.3);
            color: #999;
        }

        .view-action {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .view-action i {
            font-size: 10px;
            transform: rotate(-45deg);
            transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1);
            color: #555;
        }

        .hyper-card:hover .view-action {
            color: var(--accent-cyan);
        }

        .hyper-card:hover .view-action i {
            color: var(--accent-cyan);
            transform: rotate(0deg) translateX(4px);
        }

        /* Coming Soon Overlay */
        .cs-overlay {
            position: absolute;
            inset: 0;
            background: rgba(5, 5, 7, 0.9);
            backdrop-filter: blur(6px);
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cs-badge {
            border: 1px dashed #444;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 11px;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: #666;
            background: rgba(0, 0, 0, 0.5);
        }

        .coming-soon-card {
            opacity: 0.6;
            border-style: dashed !important;
        }

        /* ==================== SCROLL TO TOP ==================== */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: var(--bg-glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-dim);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.4s ease;
            z-index: 99;
            color: #fff;
            font-size: 16px;
        }

        .scroll-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-top:hover {
            background: #fff;
            color: #000;
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
        }

        /* ==================== NO RESULTS ==================== */
        .no-results {
            display: none;
            grid-column: 1 / -1;
            text-align: center;
            padding: 80px 20px;
            color: var(--text-muted);
        }

        .no-results.visible {
            display: block;
        }

        .no-results i {
            font-size: 48px;
            margin-bottom: 20px;
            opacity: 0.3;
        }

        .no-results p {
            font-size: 16px;
        }

        /* ==================== UTILITIES ==================== */
        .hidden {
            display: none !important;
        }

        /* Touch device optimizations */
        @media (hover: none) {
            .hyper-card:hover {
                transform: none;
                box-shadow: none;
            }

            .hyper-card:active {
                transform: scale(0.98);
            }
        }

        .back-nav-btn {
            position: fixed;
            top: 30px;
            left: 40px;
            z-index: 1000;
            /* High z-index to sit above content */
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 24px;
            background: rgba(20, 20, 25, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            color: var(--text-muted);
            text-decoration: none;
            font-family: 'Space Grotesk', sans-serif;
            font-size: 14px;
            font-weight: 500;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.3s ease;
        }

        /* Hover Effect - The "Glass" Glow */
        .back-nav-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-cyan);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(0, 245, 255, 0.2);
        }

        .back-nav-btn i {
            transition: transform 0.3s ease;
        }

        .back-nav-btn:hover i {
            transform: translateX(-4px);
        }

        /* Mobile: Hide text, show only arrow to save space */
        @media (max-width: 768px) {
            .back-nav-btn {
                top: 20px;
                left: 20px;
                padding: 12px;
            }

            .back-nav-btn span {
                display: none;
            }
        }
    </style>
</head>

<body>

    <!-- LOADER -->
    <div class="loader-wrapper" id="loader">
        <div class="loader-logo">LEXORA</div>
        <div class="loader-container">
            <div class="loader-ring"></div>
            <div class="loader-ring"></div>
            <div class="loader-ring"></div>
            <div class="loader-core"></div>
        </div>
        <div class="loader-progress">
            <div class="loader-progress-bar" id="progressBar"></div>
        </div>
        <div class="loader-text">Initializing Systems</div>
    </div>

    <!-- AMBIENT EFFECTS -->
    <div class="ambient-light"></div>
    <div class="grid-overlay"></div>

    <!-- MAIN CONTENT -->
    <main>

        <a href="index.php" class="back-nav-btn">
            <i class="fas fa-arrow-left"></i>
            <span>Back To Lexora Web</span>
        </a>


        <header class="showcase-header" id="top">
            <div class="container">
                <div class="hero-badge">Lexora Tech Portfolio</div>
                <h1 class="main-title">Digital Architecture<br>Systems.</h1>
                <p class="main-subtitle">
                    Enterprise-grade interface libraries engineered for scalability.<br>
                    Select a category to explore our high-fidelity prototypes.
                </p>
            </div>
        </header>

        <section class="container">
            <div class="filter-sticky-wrapper">
                <nav class="filter-glass-dock" role="tablist" aria-label="Project categories">
                    <button class="dock-btn active" onclick="filterProjects('all')" role="tab" aria-selected="true">View All</button>
                    <button class="dock-btn" onclick="filterProjects('tourism')" role="tab">Hospitality</button>
                    <button class="dock-btn" onclick="filterProjects('professional')" role="tab">Medical</button>
                    <button class="dock-btn" onclick="filterProjects('trades')" role="tab">Automotive</button>
                    <button class="dock-btn" onclick="filterProjects('lifestyle')" role="tab">Lifestyle</button>
                    <button class="dock-btn" onclick="filterProjects('ecommerce')" role="tab">Retail</button>
                    <button class="dock-btn" onclick="filterProjects('realestate')" role="tab">Real Estate</button>
                    <button class="dock-btn" onclick="filterProjects('education')" role="tab">Education</button>
                    <button class="dock-btn" onclick="filterProjects('corporate')" role="tab">Corporate</button>
                    <button class="dock-btn" onclick="filterProjects('dining')" role="tab">Dining</button>
                    <button class="dock-btn" onclick="filterProjects('fitness')" role="tab">Fitness</button>
                    <button class="dock-btn" onclick="filterProjects('nonprofit')" role="tab">Non-Profit</button>
                    <button class="dock-btn" onclick="filterProjects('creative')" role="tab">Creative</button>
                    <button class="dock-btn" onclick="filterProjects('travel')" role="tab">Travel</button>
                    <button class="dock-btn" onclick="filterProjects('legal')" role="tab">Legal</button>
                    <button class="dock-btn" onclick="filterProjects('saas')" role="tab">SaaS</button>
                </nav>
            </div>

            <div class="projects-grid" id="projectsGrid">
                <!-- Hospitality 1 -->
                <article class="project-item tourism">
                    <a href="./demos/hospitality/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Luxury Villa overlooking ocean" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Hospitality</span>
                                <h3 class="card-title">The Hillside Retreat</h3>
                                <p class="card-desc">Zero-commission booking engine for luxury villas with virtual tour integration.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">Booking</span><span class="tech-pill">Map API</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Hospitality 2 -->
                <article class="project-item tourism">
                    <a href="./demos/hospitality/projectTwo/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Luxury Resort with pool" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Hospitality</span>
                                <h3 class="card-title">ELYSIAN Luxury</h3>
                                <p class="card-desc">Sanctuary for holistic wellness retreats featuring private oceanfront villas.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">SPA</span><span class="tech-pill">Reservations</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Medical 1 -->
                <article class="project-item professional">
                    <a href="./demos/medical/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Modern dental clinic interior" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Medical</span>
                                <h3 class="card-title">Apex Dental Care</h3>
                                <p class="card-desc">Patient management portal with appointment scheduling and automated reminders.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">HIPAA</span><span class="tech-pill">Scheduling</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Medical 2 -->
                <article class="project-item professional">
                    <a href="./demos/medical/projectTwo/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Hospital building exterior" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Medical</span>
                                <h3 class="card-title">Medicare Plus</h3>
                                <p class="card-desc">Comprehensive hospital management system featuring electronic health records.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">EHR</span><span class="tech-pill">Telehealth</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Automotive 1 -->
                <article class="project-item trades">
                    <a href="./demos/automotive/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1486006920555-c77dcf18193c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Auto repair garage" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Automotive</span>
                                <h3 class="card-title">AutoMaster Pro</h3>
                                <p class="card-desc">Service catalog and emergency breakdown assistance system with geolocation.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">GPS</span><span class="tech-pill">Service API</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Automotive 2 -->
                <article class="project-item trades">
                    <a href="./demos/automotive/projectTwo/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1601362840469-51e4d8d58785?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Car showroom display" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Automotive</span>
                                <h3 class="card-title">Slate Motors</h3>
                                <p class="card-desc">Digital showroom featuring 3D vehicle configurator and test drive scheduling.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">3D Config</span><span class="tech-pill">Leasing</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Lifestyle -->
                <article class="project-item lifestyle">
                    <a href="./demos/lifestyle/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1600948836101-f9ffda59d250?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Beauty salon interior" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Lifestyle</span>
                                <h3 class="card-title">Serenité</h3>
                                <p class="card-desc">High-performance visual gallery with Instagram feed integration and pricing tiers.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">Social Feed</span><span class="tech-pill">Gallery</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Retail -->
                <article class="project-item ecommerce">
                    <a href="./demos/retail/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fashion retail store" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Retail</span>
                                <h3 class="card-title">VELOUR.</h3>
                                <p class="card-desc">Digital catalog mode with seamless WhatsApp ordering integration for commerce.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">WhatsApp API</span><span class="tech-pill">Catalog</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Real Estate -->
                <article class="project-item realestate">
                    <a href="./demos/real-state/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Modern house exterior" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Real Estate</span>
                                <h3 class="card-title">Skyline Properties</h3>
                                <p class="card-desc">Property listing portal featuring 360° virtual tours, agent dashboards, and map filtering.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">IDX/MLS</span><span class="tech-pill">VR Tour</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Education -->
                <article class="project-item education">
                    <a href="./demos/education/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1501504905252-473c47e087f8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Educational environment" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Education</span>
                                <h3 class="card-title">Academia LMS</h3>
                                <p class="card-desc">Complete Learning Management System for tuition centers with video hosting and quizzes.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">LMS</span><span class="tech-pill">Video Portal</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Corporate -->
                <article class="project-item corporate">
                    <a href="./demos/corporate/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Corporate skyscraper" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Corporate</span>
                                <h3 class="card-title">Nexus Consulting</h3>
                                <p class="card-desc">High-trust corporate profile with investor relation pages and secure client login areas.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">Secure Portal</span><span class="tech-pill">Data Viz</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Dining -->
                <article class="project-item dining">
                    <a href="./demos/dining/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Fine dining restaurant" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Dining</span>
                                <h3 class="card-title">The Aurum</h3>
                                <p class="card-desc">Interactive digital menu with table reservation system integration and event booking.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">QR Menu</span><span class="tech-pill">Tables</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Fitness -->
                <article class="project-item fitness">
                    <a href="./demos/fitness/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Modern gym equipment" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Fitness</span>
                                <h3 class="card-title">APEX Fitness</h3>
                                <p class="card-desc">Membership portal with recurring payments, class schedule calendar, and BMI calculator.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">Subscription</span><span class="tech-pill">Calendar</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Non-Profit -->
                <article class="project-item nonprofit">
                    <a href="./demos/non-profit/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Charity community work" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Non-Profit</span>
                                <h3 class="card-title">Hope Foundation</h3>
                                <p class="card-desc">Trust-building design with transparent donation gateways, volunteer registration.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">Donations</span><span class="tech-pill">CRM</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Creative -->
                <article class="project-item creative">
                    <a href="./demos/creative/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1452587925148-ce544e77e70d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Photography camera setup" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Creative</span>
                                <h3 class="card-title">The Studio</h3>
                                <p class="card-desc">Minimalist masonry gallery for photographers and agencies. Features client proofing.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">Masonry</span><span class="tech-pill">Proofing</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Travel -->
                <article class="project-item travel">
                    <a href="./demos/travel-agency/projectOne/index.php" target="_blank" class="card-link" rel="noopener">
                        <div class="hyper-card">
                            <div class="card-chrome">
                                <div class="traffic-lights">
                                    <div class="light"></div>
                                    <div class="light"></div>
                                    <div class="light"></div>
                                </div>
                                <div class="address-bar"></div>
                            </div>
                            <div class="card-viewport">
                                <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Scenic travel destination" loading="lazy">
                            </div>
                            <div class="card-info">
                                <span class="card-cat">Travel</span>
                                <h3 class="card-title">Voyageur</h3>
                                <p class="card-desc">Package booking system with itinerary builder, dynamic pricing, and destination guides.</p>
                                <div class="card-footer">
                                    <div class="tech-tags"><span class="tech-pill">Itinerary</span><span class="tech-pill">Booking</span></div>
                                    <div class="view-action">Preview <i class="fas fa-arrow-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>

                <!-- Legal - Coming Soon -->
                <article class="project-item legal">
                    <div class="hyper-card coming-soon-card">
                        <div class="cs-overlay">
                            <span class="cs-badge">Engineering</span>
                        </div>
                        <div class="card-chrome">
                            <div class="traffic-lights">
                                <div class="light"></div>
                                <div class="light"></div>
                                <div class="light"></div>
                            </div>
                            <div class="address-bar"></div>
                        </div>
                        <div class="card-viewport" style="background: linear-gradient(135deg, #0a0a0c 0%, #111 100%);"></div>
                        <div class="card-info">
                            <span class="card-cat">Legal</span>
                            <h3 class="card-title">Lexicon Partners</h3>
                            <p class="card-desc">High-end law firm solution with case studies and attorney profiles.</p>
                        </div>
                    </div>
                </article>

                <!-- SaaS - Coming Soon -->
                <article class="project-item saas">
                    <div class="hyper-card coming-soon-card">
                        <div class="cs-overlay">
                            <span class="cs-badge">Engineering</span>
                        </div>
                        <div class="card-chrome">
                            <div class="traffic-lights">
                                <div class="light"></div>
                                <div class="light"></div>
                                <div class="light"></div>
                            </div>
                            <div class="address-bar"></div>
                        </div>
                        <div class="card-viewport" style="background: linear-gradient(135deg, #0a0a0c 0%, #111 100%);"></div>
                        <div class="card-info">
                            <span class="card-cat">SaaS</span>
                            <h3 class="card-title">CloudFlow</h3>
                            <p class="card-desc">Modern SaaS landing page with pricing toggles and feature grids.</p>
                        </div>
                    </div>
                </article>

                <!-- No Results Message -->
                <div class="no-results" id="noResults">
                    <i class="fas fa-search"></i>
                    <p>No projects found in this category.</p>
                </div>
            </div>
        </section>
    </main>

    <!-- Scroll to Top -->
    <button class="scroll-top" id="scrollTop" aria-label="Scroll to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <script>
        // ==================== LOADER ====================
        const loader = document.getElementById('loader');
        const progressBar = document.getElementById('progressBar');
        let progress = 0;

        const progressInterval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress >= 100) {
                progress = 100;
                clearInterval(progressInterval);
            }
            progressBar.style.width = progress + '%';
        }, 150);

        window.addEventListener('load', () => {
            setTimeout(() => {
                progressBar.style.width = '100%';
                setTimeout(() => {
                    loader.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }, 400);
            }, 800);
        });

        // ==================== FILTER PROJECTS ====================
        function filterProjects(category) {
            // Update button states
            document.querySelectorAll('.dock-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.setAttribute('aria-selected', 'false');
            });
            event.target.classList.add('active');
            event.target.setAttribute('aria-selected', 'true');

            const items = document.querySelectorAll('.project-item');
            const noResults = document.getElementById('noResults');
            let visibleCount = 0;

            items.forEach((item, index) => {
                const shouldShow = category === 'all' || item.classList.contains(category);

                if (shouldShow) {
                    item.style.display = 'block';
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(30px)';

                    // Staggered animation
                    setTimeout(() => {
                        item.style.transition = 'all 0.5s cubic-bezier(0.23, 1, 0.32, 1)';
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, visibleCount * 80);

                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            // Show/hide no results message
            if (visibleCount === 0) {
                noResults.classList.add('visible');
            } else {
                noResults.classList.remove('visible');
            }
        }

        // ==================== SCROLL TO TOP ====================
        const scrollTopBtn = document.getElementById('scrollTop');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 500) {
                scrollTopBtn.classList.add('visible');
            } else {
                scrollTopBtn.classList.remove('visible');
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // ==================== INTERSECTION OBSERVER ====================
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all project items for scroll animations
        document.querySelectorAll('.project-item').forEach(item => {
            observer.observe(item);
        });

        // ==================== KEYBOARD NAVIGATION ====================
        document.querySelectorAll('.dock-btn').forEach((btn, index, buttons) => {
            btn.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    const next = buttons[(index + 1) % buttons.length];
                    next.focus();
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    const prev = buttons[(index - 1 + buttons.length) % buttons.length];
                    prev.focus();
                }
            });
        });
    </script>

</body>

</html>