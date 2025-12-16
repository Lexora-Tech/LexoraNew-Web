<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLATE Motors | Premium Automotive Experience</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #FF5722;
            --primary-light: #FF7043;
            --primary-dark: #E64A19;
            --background: #0D0D0D;
            --background-alt: #151515;
            --background-card: #1A1A1A;
            --foreground: #FFFFFF;
            --foreground-muted: #8A8A8A;
            --border: #2A2A2A;
            --metallic: #C0C0C0;
            --radius: 12px;
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
            font-family: 'Inter', sans-serif;
            background: var(--background);
            color: var(--foreground);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Loader */
        .loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--background);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        .loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-wheel {
            width: 100px;
            height: 100px;
            position: relative;
            margin-bottom: 40px;
        }

        .wheel-outer {
            position: absolute;
            inset: 0;
            border: 4px solid var(--border);
            border-radius: 50%;
        }

        .wheel-inner {
            position: absolute;
            inset: 15px;
            border: 3px solid var(--foreground-muted);
            border-radius: 50%;
            animation: wheelSpin 1.5s linear infinite;
        }

        .wheel-spoke {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 30px;
            height: 3px;
            background: var(--primary);
            transform-origin: left center;
        }

        .wheel-spoke:nth-child(1) { transform: rotate(0deg); }
        .wheel-spoke:nth-child(2) { transform: rotate(72deg); }
        .wheel-spoke:nth-child(3) { transform: rotate(144deg); }
        .wheel-spoke:nth-child(4) { transform: rotate(216deg); }
        .wheel-spoke:nth-child(5) { transform: rotate(288deg); }

        .wheel-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            background: var(--primary);
            border-radius: 50%;
        }

        @keyframes wheelSpin {
            to { transform: rotate(360deg); }
        }

        .loader-progress {
            width: 200px;
            height: 3px;
            background: var(--border);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 30px;
        }

        .loader-progress-bar {
            height: 100%;
            background: var(--primary);
            width: 0%;
            animation: loadProgress 2s ease-out forwards;
        }

        @keyframes loadProgress {
            to { width: 100%; }
        }

        .loader-text {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.5rem;
            letter-spacing: 10px;
            color: var(--foreground);
        }

        .loader-sub {
            font-size: 0.7rem;
            color: var(--primary);
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 25px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: all 0.4s ease;
        }

        nav.scrolled {
            background: rgba(13, 13, 13, 0.95);
            backdrop-filter: blur(20px);
            padding: 18px 5%;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            letter-spacing: 8px;
            color: var(--foreground);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            border: 2px solid var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon svg {
            width: 24px;
            height: 24px;
            fill: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 50px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--foreground-muted);
            font-weight: 500;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--foreground);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .nav-cta {
            background: transparent;
            color: var(--foreground);
            padding: 14px 30px;
            border: 2px solid var(--primary);
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
        }

        .nav-cta:hover {
            background: var(--primary);
            color: var(--background);
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 6px;
            cursor: pointer;
            z-index: 1001;
        }

        .menu-toggle span {
            width: 28px;
            height: 2px;
            background: var(--foreground);
            transition: all 0.3s ease;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 5% 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=1920&q=80') center/cover no-repeat;
            opacity: 0.3;
        }

        .hero-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, var(--background) 30%, transparent 70%),
                        linear-gradient(0deg, var(--background) 0%, transparent 50%);
        }

        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            max-width: 700px;
            opacity: 0;
            transform: translateY(50px);
            animation: fadeUp 1s ease 0.5s forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 30px;
        }

        .hero-tag::before {
            content: '';
            width: 40px;
            height: 2px;
            background: var(--primary);
        }

        .hero h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(4rem, 10vw, 8rem);
            line-height: 0.95;
            margin-bottom: 30px;
            letter-spacing: 3px;
        }

        .hero h1 span {
            color: var(--primary);
        }

        .hero h1 .outline {
            -webkit-text-stroke: 2px var(--foreground);
            color: transparent;
        }

        .hero p {
            font-size: 1.1rem;
            color: var(--foreground-muted);
            margin-bottom: 50px;
            max-width: 500px;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 80px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--primary);
            color: var(--background);
            padding: 18px 40px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(255, 87, 34, 0.3);
        }

        .btn-primary svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: transparent;
            color: var(--foreground);
            padding: 18px 40px;
            border: 2px solid var(--border);
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            border-color: var(--foreground);
            transform: translateY(-3px);
        }

        .btn-outline svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
        }

        .hero-stats {
            display: flex;
            gap: 60px;
        }

        .hero-stat {
            position: relative;
            padding-left: 20px;
        }

        .hero-stat::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary);
        }

        .hero-stat-number {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3rem;
            line-height: 1;
            margin-bottom: 5px;
        }

        .hero-stat-number span {
            color: var(--primary);
        }

        .hero-stat-label {
            font-size: 0.8rem;
            color: var(--foreground-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Announcement Bar */
        .announcement {
            background: var(--background-alt);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            padding: 15px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .announcement-text {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 0 5%;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .announcement-text svg {
            width: 18px;
            height: 18px;
            fill: var(--primary);
        }

        .announcement-close {
            padding: 0 5%;
            background: none;
            border: none;
            color: var(--foreground-muted);
            cursor: pointer;
            font-size: 1.2rem;
        }

        /* Marquee */
        .marquee {
            background: var(--primary);
            padding: 18px 0;
            overflow: hidden;
        }

        .marquee-content {
            display: flex;
            gap: 80px;
            animation: marquee 25s linear infinite;
            white-space: nowrap;
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .marquee-item {
            display: flex;
            align-items: center;
            gap: 20px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.3rem;
            color: var(--background);
            letter-spacing: 3px;
        }

        .marquee-item svg {
            width: 24px;
            height: 24px;
            fill: var(--background);
        }

        /* Featured Vehicle */
        .featured {
            padding: 120px 5%;
            background: var(--background);
        }

        .featured-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            max-width: 1400px;
            margin: 0 auto 60px;
            flex-wrap: wrap;
            gap: 30px;
        }

        .featured-header-text {
            max-width: 600px;
        }

        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 20px;
        }

        .section-tag span {
            color: var(--foreground-muted);
        }

        .featured-header h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            letter-spacing: 2px;
            line-height: 1.1;
        }

        .featured-header h2 span {
            color: var(--primary);
        }

        .featured-nav {
            display: flex;
            gap: 15px;
        }

        .featured-nav button {
            width: 55px;
            height: 55px;
            background: var(--background-card);
            border: 1px solid var(--border);
            border-radius: 50%;
            color: var(--foreground);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .featured-nav button:hover {
            background: var(--primary);
            border-color: var(--primary);
            color: var(--background);
        }

        .featured-nav button svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
        }

        .vehicles-slider {
            display: flex;
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
            overflow-x: auto;
            padding-bottom: 20px;
            scroll-snap-type: x mandatory;
        }

        .vehicles-slider::-webkit-scrollbar {
            height: 6px;
        }

        .vehicles-slider::-webkit-scrollbar-track {
            background: var(--border);
            border-radius: 3px;
        }

        .vehicles-slider::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }

        .vehicle-card {
            min-width: 420px;
            background: var(--background-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            scroll-snap-align: start;
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.4s ease;
        }

        .vehicle-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .vehicle-card:hover {
            border-color: var(--primary);
            transform: translateY(-10px);
        }

        .vehicle-image {
            position: relative;
            height: 260px;
            overflow: hidden;
        }

        .vehicle-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .vehicle-card:hover .vehicle-image img {
            transform: scale(1.05);
        }

        .vehicle-badge {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--primary);
            color: var(--background);
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .vehicle-content {
            padding: 30px;
        }

        .vehicle-type {
            font-size: 0.75rem;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .vehicle-name {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .vehicle-specs {
            display: flex;
            gap: 25px;
            margin-bottom: 25px;
        }

        .vehicle-spec {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--foreground-muted);
        }

        .vehicle-spec svg {
            width: 18px;
            height: 18px;
            stroke: var(--primary);
            fill: none;
        }

        .vehicle-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .vehicle-price {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
        }

        .vehicle-price span {
            font-size: 1rem;
            color: var(--foreground-muted);
        }

        .vehicle-btn {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .vehicle-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 30px rgba(255, 87, 34, 0.4);
        }

        .vehicle-btn svg {
            width: 20px;
            height: 20px;
            stroke: var(--background);
            fill: none;
        }

        /* About Section */
        .about {
            padding: 120px 5%;
            background: var(--background-alt);
        }

        .about-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .about-images {
            position: relative;
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease;
        }

        .about-images.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .about-image-main {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 16px;
        }

        .about-image-badge {
            position: absolute;
            bottom: -30px;
            right: -30px;
            background: var(--primary);
            color: var(--background);
            padding: 30px;
            border-radius: 16px;
            text-align: center;
        }

        .about-image-badge-number {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.5rem;
            line-height: 1;
        }

        .about-image-badge-text {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .about-content {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s ease;
        }

        .about-content.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .about-content h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            letter-spacing: 2px;
            line-height: 1.1;
            margin-bottom: 30px;
        }

        .about-content h2 span {
            color: var(--primary);
        }

        .about-content p {
            color: var(--foreground-muted);
            line-height: 1.9;
            margin-bottom: 40px;
            font-size: 1.05rem;
        }

        .about-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }

        .about-feature {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .about-feature-icon {
            width: 50px;
            height: 50px;
            background: var(--background-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .about-feature-icon svg {
            width: 24px;
            height: 24px;
            stroke: var(--primary);
            fill: none;
        }

        .about-feature h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .about-feature p {
            font-size: 0.85rem;
            color: var(--foreground-muted);
            margin: 0;
            line-height: 1.5;
        }

        /* Services Section */
        .services {
            padding: 120px 5%;
            background: var(--background);
        }

        .services-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 70px;
        }

        .services-header h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        .services-header h2 span {
            color: var(--primary);
        }

        .services-header p {
            color: var(--foreground-muted);
            line-height: 1.8;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .service-card {
            background: var(--background-card);
            border: 1px solid var(--border);
            padding: 40px 30px;
            border-radius: 16px;
            text-align: center;
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.4s ease;
        }

        .service-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .service-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--primary);
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-card:hover {
            border-color: var(--primary);
            transform: translateY(-10px);
        }

        .service-icon {
            width: 80px;
            height: 80px;
            background: var(--background);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            background: var(--primary);
            border-color: var(--primary);
        }

        .service-icon svg {
            width: 36px;
            height: 36px;
            stroke: var(--primary);
            fill: none;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon svg {
            stroke: var(--background);
        }

        .service-card h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            letter-spacing: 2px;
            margin-bottom: 15px;
        }

        .service-card p {
            font-size: 0.9rem;
            color: var(--foreground-muted);
            line-height: 1.7;
        }

        /* Test Drive Section */
        .test-drive {
            padding: 120px 5%;
            background: var(--background-alt);
            position: relative;
            overflow: hidden;
        }

        .test-drive-bg {
            position: absolute;
            right: 0;
            top: 0;
            width: 50%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=1200&q=80') center/cover no-repeat;
            opacity: 0.2;
        }

        .test-drive-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .test-drive-content h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            letter-spacing: 2px;
            line-height: 1.1;
            margin-bottom: 25px;
        }

        .test-drive-content h2 span {
            color: var(--primary);
        }

        .test-drive-content p {
            color: var(--foreground-muted);
            line-height: 1.8;
            margin-bottom: 40px;
            font-size: 1.05rem;
        }

        .test-drive-steps {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .test-drive-step {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .test-drive-step-number {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.3rem;
            color: var(--background);
            flex-shrink: 0;
        }

        .test-drive-step-text h4 {
            font-size: 1rem;
            margin-bottom: 5px;
        }

        .test-drive-step-text p {
            font-size: 0.85rem;
            color: var(--foreground-muted);
            margin: 0;
        }

        .test-drive-form {
            background: var(--background-card);
            border: 1px solid var(--border);
            padding: 50px;
            border-radius: 20px;
        }

        .test-drive-form h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            letter-spacing: 2px;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            color: var(--foreground-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 16px 20px;
            background: var(--background);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--foreground);
            font-size: 0.95rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-group input::placeholder {
            color: var(--foreground-muted);
        }

        .form-submit {
            width: 100%;
            padding: 18px;
            background: var(--primary);
            border: none;
            border-radius: 8px;
            color: var(--background);
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-submit:hover {
            background: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 87, 34, 0.3);
        }

        /* Testimonials */
        .testimonials {
            padding: 120px 5%;
            background: var(--background);
        }

        .testimonials-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 70px;
        }

        .testimonials-header h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        .testimonials-header h2 span {
            color: var(--primary);
        }

        .testimonials-slider {
            max-width: 900px;
            margin: 0 auto;
            position: relative;
        }

        .testimonial-card {
            background: var(--background-card);
            border: 1px solid var(--border);
            padding: 50px;
            border-radius: 20px;
            text-align: center;
            display: none;
        }

        .testimonial-card.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .testimonial-quote {
            font-size: 4rem;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 20px;
        }

        .testimonial-text {
            font-size: 1.2rem;
            line-height: 1.8;
            color: var(--foreground-muted);
            margin-bottom: 40px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .testimonial-author img {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
        }

        .testimonial-author-info {
            text-align: left;
        }

        .testimonial-author-info h4 {
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .testimonial-author-info p {
            font-size: 0.85rem;
            color: var(--primary);
        }

        .testimonial-dots {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 40px;
        }

        .testimonial-dot {
            width: 12px;
            height: 12px;
            background: var(--border);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .testimonial-dot.active {
            background: var(--primary);
            transform: scale(1.2);
        }

        /* CTA Section */
        .cta {
            padding: 120px 5%;
            background: var(--primary);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-pattern {
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23000000' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .cta h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            letter-spacing: 3px;
            color: var(--background);
            margin-bottom: 25px;
        }

        .cta p {
            font-size: 1.1rem;
            color: rgba(0, 0, 0, 0.7);
            margin-bottom: 40px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .cta .btn-dark {
            background: var(--background);
            color: var(--foreground);
            padding: 18px 40px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
        }

        .cta .btn-dark:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .cta .btn-ghost {
            background: transparent;
            color: var(--background);
            padding: 18px 40px;
            border: 2px solid var(--background);
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.3s ease;
        }

        .cta .btn-ghost:hover {
            background: var(--background);
            color: var(--primary);
        }

        /* Footer */
        footer {
            background: var(--background-alt);
            padding: 80px 5% 40px;
            border-top: 1px solid var(--border);
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-brand .logo {
            margin-bottom: 25px;
        }

        .footer-brand p {
            color: var(--foreground-muted);
            line-height: 1.8;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        .footer-social {
            display: flex;
            gap: 15px;
        }

        .footer-social a {
            width: 45px;
            height: 45px;
            background: var(--background-card);
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .footer-social a:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        .footer-social a svg {
            width: 20px;
            height: 20px;
            fill: var(--foreground);
            transition: fill 0.3s ease;
        }

        .footer-social a:hover svg {
            fill: var(--background);
        }

        .footer-column h4 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.3rem;
            letter-spacing: 2px;
            margin-bottom: 25px;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 15px;
        }

        .footer-column ul a {
            color: var(--foreground-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-column ul a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 40px;
            border-top: 1px solid var(--border);
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-bottom p {
            color: var(--foreground-muted);
            font-size: 0.85rem;
        }

        .footer-bottom-links {
            display: flex;
            gap: 30px;
        }

        .footer-bottom-links a {
            color: var(--foreground-muted);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: var(--primary);
        }

        /* Mobile Responsive */
        @media (max-width: 1200px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-top {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            .hero-container {
                grid-template-columns: 1fr;
            }

            .about-container,
            .test-drive-container {
                grid-template-columns: 1fr;
            }

            .about-images {
                order: 2;
            }

            .vehicle-card {
                min-width: 350px;
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 3.5rem;
            }

            .hero-stats {
                flex-direction: column;
                gap: 30px;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .about-features {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .test-drive-form {
                padding: 30px;
            }

            .footer-top {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .nav-right .nav-cta {
                display: none;
            }

            .vehicle-card {
                min-width: 300px;
            }

            .featured-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Reveal Animations */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div class="loader" id="loader">
        <div class="loader-wheel">
            <div class="wheel-outer"></div>
            <div class="wheel-inner">
                <div class="wheel-spoke"></div>
                <div class="wheel-spoke"></div>
                <div class="wheel-spoke"></div>
                <div class="wheel-spoke"></div>
                <div class="wheel-spoke"></div>
            </div>
            <div class="wheel-center"></div>
        </div>
        <div class="loader-progress">
            <div class="loader-progress-bar"></div>
        </div>
        <div class="loader-text">SLATE</div>
        <div class="loader-sub">Premium Automotive</div>
    </div>

    <!-- Navigation -->
    <nav id="navbar">
        <a href="#" class="logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/></svg>
            </div>
            SLATE
        </a>
        <ul class="nav-links">
            <li><a href="#vehicles">Vehicles</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#test-drive">Test Drive</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="nav-right">
            <a href="#test-drive" class="nav-cta">Reserve Now</a>
            <div class="menu-toggle" id="menuToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-gradient"></div>
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-tag">New 2025 Collection</div>
                <h1>
                    THIS TRUCK<br>
                    CAN BE <span>ANYTHING.</span><br>
                    <span class="outline">EVEN AN SUV.</span>
                </h1>
                <p>A radically simple electric pickup that can change into whatever you need it to be. Made in the USA at a price that's actually affordable.</p>
                <div class="hero-buttons">
                    <a href="#test-drive" class="btn-primary">
                        Design Yours
                        <svg viewBox="0 0 24 24"><path d="M5 12h14m-7-7l7 7-7 7"/></svg>
                    </a>
                    <a href="#vehicles" class="btn-outline">
                        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8"/></svg>
                        Watch Film
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-number">320<span>+</span></div>
                        <div class="hero-stat-label">Mile Range</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">4.2<span>s</span></div>
                        <div class="hero-stat-label">0-60 MPH</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">32<span>+</span></div>
                        <div class="hero-stat-label">Configurations</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Marquee -->
    <div class="marquee">
        <div class="marquee-content">
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                ELECTRIC POWER
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                FAST CHARGING
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                SAFETY FIRST
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                MODULAR DESIGN
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                ELECTRIC POWER
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                FAST CHARGING
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                SAFETY FIRST
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                MODULAR DESIGN
            </div>
        </div>
    </div>

    <!-- Featured Vehicles -->
    <section class="featured" id="vehicles">
        <div class="featured-header">
            <div class="featured-header-text">
                <div class="section-tag">01 <span>/ 06</span></div>
                <h2>REFRESHINGLY <span>UNCLUTTERED.</span></h2>
            </div>
            <div class="featured-nav">
                <button onclick="scrollVehicles(-1)">
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M19 12H5m7-7l-7 7 7 7"/></svg>
                </button>
                <button onclick="scrollVehicles(1)">
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14m-7-7l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <div class="vehicles-slider" id="vehiclesSlider">
            <div class="vehicle-card">
                <div class="vehicle-image">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=800&q=80" alt="Slate Pickup">
                    <span class="vehicle-badge">New Arrival</span>
                </div>
                <div class="vehicle-content">
                    <div class="vehicle-type">Electric Pickup</div>
                    <h3 class="vehicle-name">SLATE PICKUP</h3>
                    <div class="vehicle-specs">
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                            320 mi
                        </div>
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            4.2s
                        </div>
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            5 Seats
                        </div>
                    </div>
                    <div class="vehicle-footer">
                        <div class="vehicle-price">$39,900 <span>/starting</span></div>
                        <a href="#" class="vehicle-btn">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14m-7-7l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="vehicle-card">
                <div class="vehicle-image">
                    <img src="https://images.unsplash.com/photo-1619767886558-efdc259cde1a?w=800&q=80" alt="Slate SUV">
                    <span class="vehicle-badge">Best Seller</span>
                </div>
                <div class="vehicle-content">
                    <div class="vehicle-type">Electric SUV</div>
                    <h3 class="vehicle-name">SLATE EXPLORER</h3>
                    <div class="vehicle-specs">
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                            380 mi
                        </div>
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            3.8s
                        </div>
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            7 Seats
                        </div>
                    </div>
                    <div class="vehicle-footer">
                        <div class="vehicle-price">$54,900 <span>/starting</span></div>
                        <a href="#" class="vehicle-btn">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14m-7-7l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="vehicle-card">
                <div class="vehicle-image">
                    <img src="https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=800&q=80" alt="Slate Sport">
                    <span class="vehicle-badge">Limited</span>
                </div>
                <div class="vehicle-content">
                    <div class="vehicle-type">Electric Sport</div>
                    <h3 class="vehicle-name">SLATE SPORT GT</h3>
                    <div class="vehicle-specs">
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                            290 mi
                        </div>
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            2.9s
                        </div>
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            2 Seats
                        </div>
                    </div>
                    <div class="vehicle-footer">
                        <div class="vehicle-price">$89,900 <span>/starting</span></div>
                        <a href="#" class="vehicle-btn">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14m-7-7l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="vehicle-card">
                <div class="vehicle-image">
                    <img src="https://images.unsplash.com/photo-1605559424843-9e4c228bf1c2?w=800&q=80" alt="Slate Sedan">
                </div>
                <div class="vehicle-content">
                    <div class="vehicle-type">Electric Sedan</div>
                    <h3 class="vehicle-name">SLATE EXECUTIVE</h3>
                    <div class="vehicle-specs">
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                            420 mi
                        </div>
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            3.5s
                        </div>
                        <div class="vehicle-spec">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            5 Seats
                        </div>
                    </div>
                    <div class="vehicle-footer">
                        <div class="vehicle-price">$64,900 <span>/starting</span></div>
                        <a href="#" class="vehicle-btn">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14m-7-7l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="about-container">
            <div class="about-images">
                <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=900&q=80" alt="About Slate Motors" class="about-image-main">
                <div class="about-image-badge">
                    <div class="about-image-badge-number">25+</div>
                    <div class="about-image-badge-text">Years Experience</div>
                </div>
            </div>
            <div class="about-content">
                <div class="section-tag">About Us</div>
                <h2>SPACE, COMFORT, <span>SIMPLICITY.</span></h2>
                <p>The interior celebrates personal space and comfort with an intuitive feel that's elegantly simple yet memorable, and above all else, useful. Every detail is designed with purpose.</p>
                <div class="about-features">
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div>
                            <h4>5-Star Safety</h4>
                            <p>Top safety ratings across all categories</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        </div>
                        <div>
                            <h4>Fast Charging</h4>
                            <p>0-80% in just 25 minutes</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                        </div>
                        <div>
                            <h4>Modular Build</h4>
                            <p>Customize to fit your lifestyle</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>
                        </div>
                        <div>
                            <h4>Made in USA</h4>
                            <p>Built with American pride</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn-primary">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="services-header">
            <div class="section-tag">Our Services</div>
            <h2>COMPLETE <span>AUTOMOTIVE</span> CARE</h2>
            <p>From purchase to maintenance, we provide comprehensive services to keep your vehicle running at peak performance.</p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                </div>
                <h3>MAINTENANCE</h3>
                <p>Regular service and maintenance to keep your vehicle in optimal condition with certified technicians.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                </div>
                <h3>CHARGING</h3>
                <p>Access to our nationwide supercharger network with fast charging capabilities.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                </div>
                <h3>FINANCING</h3>
                <p>Flexible financing options with competitive rates and personalized payment plans.</p>
            </div>

            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>WARRANTY</h3>
                <p>Comprehensive warranty coverage for peace of mind on every mile of your journey.</p>
            </div>
        </div>
    </section>

    <!-- Test Drive Section -->
    <section class="test-drive" id="test-drive">
        <div class="test-drive-bg"></div>
        <div class="test-drive-container">
            <div class="test-drive-content reveal">
                <div class="section-tag">Experience</div>
                <h2>BOOK YOUR <span>TEST DRIVE</span> TODAY</h2>
                <p>Feel the power of electric performance firsthand. Schedule your personalized test drive experience at any of our locations.</p>
                <div class="test-drive-steps">
                    <div class="test-drive-step">
                        <div class="test-drive-step-number">1</div>
                        <div class="test-drive-step-text">
                            <h4>Choose Your Model</h4>
                            <p>Select from our lineup of electric vehicles</p>
                        </div>
                    </div>
                    <div class="test-drive-step">
                        <div class="test-drive-step-number">2</div>
                        <div class="test-drive-step-text">
                            <h4>Pick Your Time</h4>
                            <p>Choose a convenient date and time slot</p>
                        </div>
                    </div>
                    <div class="test-drive-step">
                        <div class="test-drive-step-number">3</div>
                        <div class="test-drive-step-text">
                            <h4>Experience the Drive</h4>
                            <p>Feel the power and innovation firsthand</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="test-drive-form reveal">
                <h3>RESERVE YOUR SPOT</h3>
                <form>
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" placeholder="John">
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" placeholder="Doe">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" placeholder="john@example.com">
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" placeholder="+1 (555) 000-0000">
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Select Model</label>
                            <select>
                                <option>Slate Pickup</option>
                                <option>Slate Explorer</option>
                                <option>Slate Sport GT</option>
                                <option>Slate Executive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Preferred Date</label>
                            <input type="date">
                        </div>
                    </div>
                    <button type="submit" class="form-submit">Schedule Test Drive</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="testimonials-header">
            <div class="section-tag">Testimonials</div>
            <h2>WHAT OUR <span>DRIVERS</span> SAY</h2>
        </div>

        <div class="testimonials-slider">
            <div class="testimonial-card active">
                <div class="testimonial-quote">"</div>
                <p class="testimonial-text">The Slate Pickup completely changed my perspective on electric vehicles. The range anxiety I had is completely gone, and the performance is absolutely incredible. Best purchase I've ever made.</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&q=80" alt="Michael Chen">
                    <div class="testimonial-author-info">
                        <h4>Michael Chen</h4>
                        <p>Slate Pickup Owner</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-quote">"</div>
                <p class="testimonial-text">From the moment I walked into the showroom to driving off the lot, the experience was seamless. The team truly cares about finding the right vehicle for your needs. Exceptional service!</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200&q=80" alt="Sarah Johnson">
                    <div class="testimonial-author-info">
                        <h4>Sarah Johnson</h4>
                        <p>Slate Explorer Owner</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-quote">"</div>
                <p class="testimonial-text">The Sport GT is a dream to drive. The acceleration, the handling, the technology - everything about it exceeds expectations. This is what the future of driving feels like.</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&q=80" alt="David Park">
                    <div class="testimonial-author-info">
                        <h4>David Park</h4>
                        <p>Slate Sport GT Owner</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="testimonial-dots">
            <span class="testimonial-dot active" onclick="showTestimonial(0)"></span>
            <span class="testimonial-dot" onclick="showTestimonial(1)"></span>
            <span class="testimonial-dot" onclick="showTestimonial(2)"></span>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="contact">
        <div class="cta-pattern"></div>
        <div class="cta-container">
            <h2>READY TO MAKE THE SWITCH?</h2>
            <p>Join thousands of satisfied drivers who have made the move to electric. Your future starts here.</p>
            <div class="cta-buttons">
                <a href="#test-drive" class="btn-dark">Reserve Now</a>
                <a href="#" class="btn-ghost">Contact Sales</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-brand">
                    <a href="#" class="logo">
                        <div class="logo-icon">
                            <svg viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/></svg>
                        </div>
                        SLATE
                    </a>
                    <p>Redefining the automotive experience with innovative electric vehicles designed for the modern driver.</p>
                    <div class="footer-social">
                        <a href="#">
                            <svg viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#">
                            <svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#">
                            <svg viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                        <a href="#">
                            <svg viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="footer-column">
                    <h4>VEHICLES</h4>
                    <ul>
                        <li><a href="#">Slate Pickup</a></li>
                        <li><a href="#">Slate Explorer</a></li>
                        <li><a href="#">Slate Sport GT</a></li>
                        <li><a href="#">Slate Executive</a></li>
                        <li><a href="#">Compare Models</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>SERVICES</h4>
                    <ul>
                        <li><a href="#">Maintenance</a></li>
                        <li><a href="#">Charging Network</a></li>
                        <li><a href="#">Financing</a></li>
                        <li><a href="#">Warranty</a></li>
                        <li><a href="#">Trade-In</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>COMPANY</h4>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Investors</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 Slate Motors. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">Cookie Settings</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Loader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('loader').classList.add('hidden');
            }, 2200);
        });

        // Navbar scroll effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Vehicle slider navigation
        function scrollVehicles(direction) {
            const slider = document.getElementById('vehiclesSlider');
            const cardWidth = slider.querySelector('.vehicle-card').offsetWidth + 30;
            slider.scrollBy({ left: cardWidth * direction, behavior: 'smooth' });
        }

        // Testimonials slider
        let currentTestimonial = 0;
        const testimonialCards = document.querySelectorAll('.testimonial-card');
        const testimonialDots = document.querySelectorAll('.testimonial-dot');

        function showTestimonial(index) {
            testimonialCards.forEach(card => card.classList.remove('active'));
            testimonialDots.forEach(dot => dot.classList.remove('active'));
            testimonialCards[index].classList.add('active');
            testimonialDots[index].classList.add('active');
            currentTestimonial = index;
        }

        // Auto-rotate testimonials
        setInterval(() => {
            currentTestimonial = (currentTestimonial + 1) % testimonialCards.length;
            showTestimonial(currentTestimonial);
        }, 5000);

        // Reveal animations on scroll
        const revealElements = document.querySelectorAll('.reveal, .vehicle-card, .service-card, .about-images, .about-content');

        const revealOnScroll = () => {
            revealElements.forEach((el, index) => {
                const elementTop = el.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;
                
                if (elementTop < windowHeight - 100) {
                    setTimeout(() => {
                        el.classList.add('visible');
                    }, index * 100);
                }
            });
        };

        window.addEventListener('scroll', revealOnScroll);
        revealOnScroll();

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
        });
    </script>
</body>
</html>
