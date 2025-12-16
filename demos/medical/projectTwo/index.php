<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediCare Plus | Modern Healthcare Excellence</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0C6B8A;
            --primary-light: #0E8EB0;
            --primary-dark: #094E66;
            --accent: #00D4AA;
            --accent-dark: #00B894;
            --background: #FFFFFF;
            --background-alt: #F4F9FB;
            --foreground: #1A2B3C;
            --foreground-muted: #5A6B7C;
            --card: #FFFFFF;
            --border: #E1EEF2;
            --danger: #FF6B6B;
            --radius: 16px;
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
            font-family: 'Plus Jakarta Sans', sans-serif;
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        .loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-content {
            text-align: center;
        }

        .loader-icon {
            width: 120px;
            height: 120px;
            position: relative;
            margin: 0 auto 40px;
        }

        .heartbeat-circle {
            position: absolute;
            inset: 0;
            border: 2px solid rgba(0, 212, 170, 0.3);
            border-radius: 50%;
            animation: heartPulse 1.5s ease-out infinite;
        }

        .heartbeat-circle:nth-child(2) {
            animation-delay: 0.3s;
        }

        .heartbeat-circle:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes heartPulse {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }
            100% {
                transform: scale(1.4);
                opacity: 0;
            }
        }

        .loader-heart {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: heartBeat 1s ease-in-out infinite;
        }

        @keyframes heartBeat {
            0%, 100% { transform: translate(-50%, -50%) scale(1); }
            50% { transform: translate(-50%, -50%) scale(1.1); }
        }

        .loader-heart svg {
            width: 30px;
            height: 30px;
            fill: var(--primary-dark);
        }

        .loader-ecg {
            width: 200px;
            height: 50px;
            margin: 0 auto 30px;
            overflow: hidden;
        }

        .ecg-line {
            stroke: var(--accent);
            stroke-width: 2;
            fill: none;
            stroke-dasharray: 500;
            stroke-dashoffset: 500;
            animation: ecgDraw 2s linear infinite;
        }

        @keyframes ecgDraw {
            to {
                stroke-dashoffset: 0;
            }
        }

        .loader-text {
            font-family: 'DM Serif Display', serif;
            font-size: 1.8rem;
            color: var(--background);
            letter-spacing: 3px;
            margin-bottom: 10px;
        }

        .loader-sub {
            font-size: 0.75rem;
            color: var(--accent);
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: 600;
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
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            padding: 18px 5%;
            box-shadow: 0 4px 30px rgba(12, 107, 138, 0.08);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: var(--accent);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon svg {
            width: 24px;
            height: 24px;
            fill: var(--primary-dark);
        }

        .logo-text {
            font-family: 'DM Serif Display', serif;
            font-size: 1.5rem;
            color: var(--primary);
        }

        .logo-text span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 45px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--foreground);
            font-weight: 600;
            font-size: 0.85rem;
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
            background: var(--accent);
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .emergency-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--danger);
            color: white;
            padding: 12px 22px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .emergency-btn:hover {
            background: #FF5252;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 107, 107, 0.4);
        }

        .emergency-btn svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
            animation: pulse 1s ease infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .book-btn {
            background: var(--primary);
            color: white;
            padding: 14px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .book-btn:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(12, 107, 138, 0.3);
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            z-index: 1001;
        }

        .menu-toggle span {
            width: 26px;
            height: 3px;
            background: var(--primary);
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 140px 5% 100px;
            position: relative;
            overflow: hidden;
            background: var(--background-alt);
        }

        .hero-bg-pattern {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 2px 2px, rgba(12, 107, 138, 0.05) 1px, transparent 0);
            background-size: 40px 40px;
        }

        .hero-shape {
            position: absolute;
            right: -200px;
            top: 50%;
            transform: translateY(-50%);
            width: 800px;
            height: 800px;
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.1) 0%, rgba(12, 107, 138, 0.05) 100%);
            border-radius: 50%;
        }

        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            opacity: 0;
            transform: translateX(-50px);
            animation: fadeRight 1s ease 0.3s forwards;
        }

        @keyframes fadeRight {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(0, 212, 170, 0.1);
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 50px;
            margin-bottom: 30px;
        }

        .hero-badge-dot {
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
            animation: blink 1.5s ease infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        .hero h1 {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2.8rem, 5vw, 4.2rem);
            font-weight: 400;
            line-height: 1.15;
            margin-bottom: 25px;
            color: var(--foreground);
        }

        .hero h1 span {
            color: var(--primary);
        }

        .hero h1 em {
            font-style: italic;
            color: var(--accent);
        }

        .hero p {
            font-size: 1.1rem;
            color: var(--foreground-muted);
            margin-bottom: 40px;
            line-height: 1.8;
            max-width: 520px;
        }

        .hero-buttons {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            margin-bottom: 50px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--primary);
            color: white;
            padding: 18px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(12, 107, 138, 0.35);
        }

        .btn-primary svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: var(--primary);
            padding: 18px 35px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            border: 2px solid var(--border);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
        }

        .btn-secondary svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            fill: none;
        }

        .hero-stats {
            display: flex;
            gap: 50px;
        }

        .hero-stat {
            text-align: left;
        }

        .hero-stat-number {
            font-family: 'DM Serif Display', serif;
            font-size: 2.8rem;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 5px;
        }

        .hero-stat-number span {
            color: var(--accent);
        }

        .hero-stat-label {
            font-size: 0.85rem;
            color: var(--foreground-muted);
            font-weight: 500;
        }

        .hero-visual {
            position: relative;
            opacity: 0;
            transform: translateX(50px);
            animation: fadeLeft 1s ease 0.5s forwards;
        }

        @keyframes fadeLeft {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .hero-image-main {
            width: 100%;
            height: 550px;
            object-fit: cover;
            border-radius: 30px;
        }

        .hero-card {
            position: absolute;
            background: white;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(12, 107, 138, 0.15);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .hero-card-doctor {
            bottom: 40px;
            left: -40px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .hero-card-doctor img {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            object-fit: cover;
        }

        .hero-card-doctor-info h4 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 3px;
        }

        .hero-card-doctor-info p {
            font-size: 0.75rem;
            color: var(--foreground-muted);
            margin: 0;
        }

        .hero-card-doctor-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 5px;
        }

        .hero-card-doctor-rating svg {
            width: 14px;
            height: 14px;
            fill: #FFD700;
        }

        .hero-card-doctor-rating span {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--foreground);
        }

        .hero-card-appointment {
            top: 60px;
            right: -30px;
            text-align: center;
            animation-delay: 0.5s;
        }

        .hero-card-appointment-icon {
            width: 50px;
            height: 50px;
            background: rgba(0, 212, 170, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }

        .hero-card-appointment-icon svg {
            width: 24px;
            height: 24px;
            stroke: var(--accent);
            fill: none;
        }

        .hero-card-appointment h4 {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 3px;
        }

        .hero-card-appointment p {
            font-size: 0.75rem;
            color: var(--accent);
            font-weight: 600;
            margin: 0;
        }

        /* Marquee */
        .marquee {
            background: var(--primary);
            padding: 20px 0;
            overflow: hidden;
        }

        .marquee-content {
            display: flex;
            gap: 60px;
            animation: marquee 30s linear infinite;
            white-space: nowrap;
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .marquee-item {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .marquee-item svg {
            width: 20px;
            height: 20px;
            fill: var(--accent);
        }

        /* Services Section */
        .services {
            padding: 120px 5%;
            background: var(--background);
        }

        .services-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 70px;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(0, 212, 170, 0.1);
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 50px;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .services-header h2 {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2.2rem, 4vw, 3rem);
            font-weight: 400;
            margin-bottom: 20px;
            color: var(--foreground);
        }

        .services-header h2 em {
            font-style: italic;
            color: var(--primary);
        }

        .services-header p {
            color: var(--foreground-muted);
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .service-card {
            background: var(--background-alt);
            padding: 40px 30px;
            border-radius: 24px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.4s ease;
        }

        .service-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--accent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-card:hover {
            background: white;
            box-shadow: 0 25px 50px rgba(12, 107, 138, 0.12);
            transform: translateY(-8px);
        }

        .service-icon {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .service-card:hover .service-icon {
            background: var(--primary);
        }

        .service-icon svg {
            width: 32px;
            height: 32px;
            stroke: var(--primary);
            fill: none;
            transition: stroke 0.3s ease;
        }

        .service-card:hover .service-icon svg {
            stroke: white;
        }

        .service-card h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: var(--foreground);
        }

        .service-card p {
            font-size: 0.9rem;
            color: var(--foreground-muted);
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .service-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            transition: gap 0.3s ease;
        }

        .service-link:hover {
            gap: 12px;
        }

        .service-link svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
        }

        /* Doctors Section */
        .doctors {
            padding: 120px 5%;
            background: var(--background-alt);
        }

        .doctors-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            max-width: 1400px;
            margin: 0 auto 70px;
            flex-wrap: wrap;
            gap: 30px;
        }

        .doctors-header-text h2 {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2.2rem, 4vw, 3rem);
            font-weight: 400;
            margin-bottom: 15px;
            color: var(--foreground);
        }

        .doctors-header-text h2 em {
            font-style: italic;
            color: var(--primary);
        }

        .doctors-header-text p {
            color: var(--foreground-muted);
            font-size: 1.05rem;
            max-width: 500px;
        }

        .doctors-nav {
            display: flex;
            gap: 15px;
        }

        .doctors-nav button {
            width: 55px;
            height: 55px;
            border: 2px solid var(--border);
            background: white;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .doctors-nav button:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        .doctors-nav button svg {
            width: 22px;
            height: 22px;
            stroke: var(--foreground);
            fill: none;
            transition: stroke 0.3s ease;
        }

        .doctors-nav button:hover svg {
            stroke: white;
        }

        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .doctor-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.5s ease;
        }

        .doctor-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .doctor-card:hover {
            box-shadow: 0 25px 50px rgba(12, 107, 138, 0.12);
            transform: translateY(-8px);
        }

        .doctor-image {
            height: 280px;
            position: relative;
            overflow: hidden;
        }

        .doctor-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .doctor-card:hover .doctor-image img {
            transform: scale(1.05);
        }

        .doctor-socials {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
            display: flex;
            justify-content: center;
            gap: 12px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }

        .doctor-card:hover .doctor-socials {
            opacity: 1;
            transform: translateY(0);
        }

        .doctor-socials a {
            width: 42px;
            height: 42px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .doctor-socials a:hover {
            background: var(--primary);
        }

        .doctor-socials a svg {
            width: 18px;
            height: 18px;
            fill: var(--primary);
            transition: fill 0.3s ease;
        }

        .doctor-socials a:hover svg {
            fill: white;
        }

        .doctor-content {
            padding: 30px;
            text-align: center;
        }

        .doctor-content h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--foreground);
        }

        .doctor-content p {
            font-size: 0.9rem;
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 15px;
        }

        .doctor-rating {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .doctor-rating svg {
            width: 16px;
            height: 16px;
            fill: #FFD700;
        }

        .doctor-rating span {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--foreground);
            margin-left: 5px;
        }

        /* Appointment Section */
        .appointment {
            padding: 120px 5%;
            background: var(--background);
        }

        .appointment-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .appointment-content {
            opacity: 0;
            transform: translateX(-40px);
            transition: all 0.8s ease;
        }

        .appointment-content.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .appointment-content h2 {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2.2rem, 4vw, 3rem);
            font-weight: 400;
            margin-bottom: 20px;
            color: var(--foreground);
        }

        .appointment-content h2 em {
            font-style: italic;
            color: var(--primary);
        }

        .appointment-content > p {
            color: var(--foreground-muted);
            line-height: 1.8;
            font-size: 1.05rem;
            margin-bottom: 40px;
        }

        .appointment-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .appointment-feature {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .appointment-feature-icon {
            width: 50px;
            height: 50px;
            background: rgba(0, 212, 170, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .appointment-feature-icon svg {
            width: 24px;
            height: 24px;
            stroke: var(--accent);
            fill: none;
        }

        .appointment-feature h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--foreground);
        }

        .appointment-feature p {
            font-size: 0.85rem;
            color: var(--foreground-muted);
            line-height: 1.6;
        }

        .appointment-form-wrapper {
            background: var(--background-alt);
            padding: 50px;
            border-radius: 30px;
            opacity: 0;
            transform: translateX(40px);
            transition: all 0.8s ease 0.2s;
        }

        .appointment-form-wrapper.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .appointment-form h3 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.8rem;
            margin-bottom: 30px;
            color: var(--foreground);
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
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--foreground);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-family: inherit;
            font-size: 0.95rem;
            color: var(--foreground);
            background: white;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-group textarea {
            resize: none;
            height: 100px;
        }

        .form-submit {
            width: 100%;
            padding: 18px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-submit:hover {
            background: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(12, 107, 138, 0.3);
        }

        /* Testimonials Section */
        .testimonials {
            padding: 120px 5%;
            background: var(--primary);
            position: relative;
            overflow: hidden;
        }

        .testimonials-bg {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.03) 1px, transparent 0);
            background-size: 40px 40px;
        }

        .testimonials-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 70px;
            position: relative;
            z-index: 2;
        }

        .testimonials-header .section-badge {
            background: rgba(0, 212, 170, 0.2);
            color: var(--accent);
        }

        .testimonials-header h2 {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2.2rem, 4vw, 3rem);
            font-weight: 400;
            margin-bottom: 20px;
            color: white;
        }

        .testimonials-header h2 em {
            font-style: italic;
            color: var(--accent);
        }

        .testimonials-header p {
            color: rgba(255, 255, 255, 0.7);
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .testimonials-slider {
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .testimonial-card {
            background: white;
            padding: 50px;
            border-radius: 30px;
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
            width: 60px;
            height: 60px;
            background: rgba(0, 212, 170, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }

        .testimonial-quote svg {
            width: 28px;
            height: 28px;
            fill: var(--accent);
        }

        .testimonial-card p {
            font-size: 1.25rem;
            color: var(--foreground);
            line-height: 1.9;
            margin-bottom: 35px;
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
        }

        .testimonial-author-info {
            text-align: left;
        }

        .testimonial-author-info h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 5px;
        }

        .testimonial-author-info span {
            font-size: 0.9rem;
            color: var(--foreground-muted);
        }

        .testimonials-dots {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 40px;
        }

        .testimonials-dots button {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: none;
            background: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .testimonials-dots button.active {
            background: var(--accent);
            width: 35px;
            border-radius: 6px;
        }

        /* CTA Section */
        .cta {
            padding: 120px 5%;
            background: var(--background-alt);
        }

        .cta-container {
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 80px 60px;
            border-radius: 40px;
            position: relative;
            overflow: hidden;
        }

        .cta-shape {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(0, 212, 170, 0.1);
        }

        .cta-shape-1 {
            top: -200px;
            right: -100px;
        }

        .cta-shape-2 {
            bottom: -200px;
            left: -100px;
        }

        .cta-content {
            position: relative;
            z-index: 2;
        }

        .cta h2 {
            font-family: 'DM Serif Display', serif;
            font-size: clamp(2rem, 4vw, 2.8rem);
            font-weight: 400;
            color: white;
            margin-bottom: 20px;
        }

        .cta h2 em {
            font-style: italic;
            color: var(--accent);
        }

        .cta p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.8;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .cta .btn-primary {
            background: var(--accent);
            color: var(--primary-dark);
        }

        .cta .btn-primary:hover {
            background: var(--accent-dark);
            box-shadow: 0 15px 40px rgba(0, 212, 170, 0.4);
        }

        .cta .btn-secondary {
            background: transparent;
            color: white;
            border-color: rgba(255, 255, 255, 0.4);
        }

        .cta .btn-secondary:hover {
            background: white;
            color: var(--primary);
        }

        /* Footer */
        footer {
            background: var(--foreground);
            padding: 80px 5% 30px;
            color: white;
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

        .footer-about .logo {
            margin-bottom: 25px;
        }

        .footer-about .logo-icon {
            background: var(--accent);
        }

        .footer-about .logo-text {
            color: white;
        }

        .footer-about p {
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.8;
            margin-bottom: 25px;
            font-size: 0.95rem;
        }

        .footer-socials {
            display: flex;
            gap: 15px;
        }

        .footer-socials a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .footer-socials a:hover {
            background: var(--accent);
        }

        .footer-socials a svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .footer-links h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 25px;
            color: white;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links ul li {
            margin-bottom: 15px;
        }

        .footer-links ul a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-links ul a:hover {
            color: var(--accent);
        }

        .footer-contact p {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .footer-contact p svg {
            width: 18px;
            height: 18px;
            stroke: var(--accent);
            fill: none;
            flex-shrink: 0;
        }

        .footer-bottom {
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-bottom p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
        }

        .footer-bottom-links {
            display: flex;
            gap: 30px;
        }

        .footer-bottom-links a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: var(--accent);
        }

        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 80%;
            max-width: 400px;
            height: 100vh;
            background: white;
            z-index: 1000;
            padding: 100px 40px 40px;
            transition: right 0.4s ease;
            box-shadow: -10px 0 50px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu ul {
            list-style: none;
        }

        .mobile-menu ul li {
            margin-bottom: 25px;
        }

        .mobile-menu ul a {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--foreground);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .mobile-menu ul a:hover {
            color: var(--primary);
        }

        .mobile-menu-close {
            position: absolute;
            top: 30px;
            right: 30px;
            width: 40px;
            height: 40px;
            background: none;
            border: none;
            cursor: pointer;
        }

        .mobile-menu-close span {
            display: block;
            width: 100%;
            height: 3px;
            background: var(--foreground);
            position: absolute;
            top: 50%;
            left: 0;
        }

        .mobile-menu-close span:first-child {
            transform: rotate(45deg);
        }

        .mobile-menu-close span:last-child {
            transform: rotate(-45deg);
        }

        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
        }

        .mobile-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .doctors-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-top {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .nav-links,
            .nav-right {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            .hero-container {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .hero-content {
                order: 1;
            }

            .hero p {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-stats {
                justify-content: center;
            }

            .hero-visual {
                order: 2;
            }

            .hero-card-doctor {
                left: 20px;
            }

            .hero-card-appointment {
                right: 20px;
            }

            .appointment-container {
                grid-template-columns: 1fr;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .services-grid,
            .doctors-grid {
                grid-template-columns: 1fr;
            }

            .footer-top {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .hero-stats {
                flex-direction: column;
                gap: 25px;
            }

            .appointment-features {
                grid-template-columns: 1fr;
            }

            .appointment-form-wrapper {
                padding: 30px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .hero-card {
                display: none;
            }

            .cta-container {
                padding: 50px 30px;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2.2rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                justify-content: center;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .doctors-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div class="loader">
        <div class="loader-content">
            <div class="loader-icon">
                <div class="heartbeat-circle"></div>
                <div class="heartbeat-circle"></div>
                <div class="heartbeat-circle"></div>
                <div class="loader-heart">
                    <svg viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
            </div>
            <svg class="loader-ecg" viewBox="0 0 200 50">
                <polyline class="ecg-line" points="0,25 40,25 50,25 60,10 70,40 80,25 90,25 110,25 120,5 130,45 140,25 150,25 200,25"/>
            </svg>
            <div class="loader-text">MediCare Plus</div>
            <div class="loader-sub">Your Health, Our Priority</div>
        </div>
    </div>

    <!-- Navigation -->
    <nav>
        <a href="#" class="logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
            </div>
            <span class="logo-text">MediCare<span>Plus</span></span>
        </a>
        <ul class="nav-links">
            <li><a href="#services">Services</a></li>
            <li><a href="#doctors">Doctors</a></li>
            <li><a href="#appointment">Appointment</a></li>
            <li><a href="#testimonials">Reviews</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="nav-right">
            <a href="tel:911" class="emergency-btn">
                <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                Emergency
            </a>
            <a href="#appointment" class="book-btn">Book Now</a>
        </div>
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-overlay"></div>
    <div class="mobile-menu">
        <button class="mobile-menu-close">
            <span></span>
            <span></span>
        </button>
        <ul>
            <li><a href="#services">Services</a></li>
            <li><a href="#doctors">Doctors</a></li>
            <li><a href="#appointment">Appointment</a></li>
            <li><a href="#testimonials">Reviews</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg-pattern"></div>
        <div class="hero-shape"></div>
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    Trusted Healthcare Since 1995
                </div>
                <h1>Your Path to <span>Better Health</span> Starts <em>Here</em></h1>
                <p>Experience world-class medical care with our team of expert physicians. We combine cutting-edge technology with compassionate care to ensure your well-being.</p>
                <div class="hero-buttons">
                    <a href="#appointment" class="btn-primary">
                        Book Appointment
                        <svg viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#services" class="btn-secondary">
                        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8" fill="currentColor"/></svg>
                        Our Services
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-number">25<span>+</span></div>
                        <div class="hero-stat-label">Years Experience</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">150<span>+</span></div>
                        <div class="hero-stat-label">Expert Doctors</div>
                    </div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">50K<span>+</span></div>
                        <div class="hero-stat-label">Happy Patients</div>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <img src="https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=800" alt="Doctor with patient" class="hero-image-main">
                <div class="hero-card hero-card-doctor">
                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=200" alt="Dr. Sarah Mitchell">
                    <div class="hero-card-doctor-info">
                        <h4>Dr. Sarah Mitchell</h4>
                        <p>Cardiologist</p>
                        <div class="hero-card-doctor-rating">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <span>4.9</span>
                        </div>
                    </div>
                </div>
                <div class="hero-card hero-card-appointment">
                    <div class="hero-card-appointment-icon">
                        <svg viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h4>Quick Booking</h4>
                    <p>Available 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Marquee -->
    <div class="marquee">
        <div class="marquee-content">
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                24/7 Emergency Care
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                Expert Specialists
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                Advanced Technology
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                Compassionate Care
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                Patient-Centered
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                24/7 Emergency Care
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                Expert Specialists
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                Advanced Technology
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                Compassionate Care
            </div>
            <div class="marquee-item">
                <svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                Patient-Centered
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="services-header">
            <span class="section-badge">Our Services</span>
            <h2>Comprehensive <em>Medical Care</em> for Your Family</h2>
            <p>We offer a wide range of medical services to meet all your healthcare needs under one roof.</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                </div>
                <h3>Cardiology</h3>
                <p>Expert heart care with advanced diagnostics and treatment options for all cardiac conditions.</p>
                <a href="#" class="service-link">
                    Learn More
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l2 2"/></svg>
                </div>
                <h3>Neurology</h3>
                <p>Specialized care for brain and nervous system disorders with state-of-the-art treatments.</p>
                <a href="#" class="service-link">
                    Learn More
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M4.5 9.5V4a.5.5 0 01.5-.5h14a.5.5 0 01.5.5v5.5M4.5 14.5V20a.5.5 0 00.5.5h14a.5.5 0 00.5-.5v-5.5M2 9.5h20M2 14.5h20"/></svg>
                </div>
                <h3>Orthopedics</h3>
                <p>Complete bone and joint care from diagnosis to rehabilitation and recovery.</p>
                <a href="#" class="service-link">
                    Learn More
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M12 2a10 10 0 110 20 10 10 0 010-20z"/><path d="M12 8v8M8 12h8"/></svg>
                </div>
                <h3>Emergency Care</h3>
                <p>Round-the-clock emergency services with rapid response and expert trauma care.</p>
                <a href="#" class="service-link">
                    Learn More
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M3 21v-2a7 7 0 0114 0v2"/></svg>
                </div>
                <h3>Pediatrics</h3>
                <p>Gentle and comprehensive healthcare for infants, children, and adolescents.</p>
                <a href="#" class="service-link">
                    Learn More
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/><path d="M9 12l2 2 4-4"/></svg>
                </div>
                <h3>Diagnostics</h3>
                <p>Advanced imaging and laboratory services for accurate and timely diagnosis.</p>
                <a href="#" class="service-link">
                    Learn More
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0016.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 002 8.5c0 2.3 1.5 4.05 3 5.5l7 7z"/></svg>
                </div>
                <h3>Women's Health</h3>
                <p>Comprehensive gynecological and obstetric care for women at every stage of life.</p>
                <a href="#" class="service-link">
                    Learn More
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Mental Health</h3>
                <p>Compassionate psychiatric and psychological services for emotional well-being.</p>
                <a href="#" class="service-link">
                    Learn More
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Doctors Section -->
    <section class="doctors" id="doctors">
        <div class="doctors-header">
            <div class="doctors-header-text">
                <span class="section-badge">Our Team</span>
                <h2>Meet Our <em>Expert</em> Physicians</h2>
                <p>Our team of board-certified specialists brings decades of combined experience to deliver exceptional patient care.</p>
            </div>
            <div class="doctors-nav">
                <button class="prev-doctor">
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
                </button>
                <button class="next-doctor">
                    <svg viewBox="0 0 24 24" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>
        </div>
        <div class="doctors-grid">
            <div class="doctor-card">
                <div class="doctor-image">
                    <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?w=400" alt="Dr. Michael Chen">
                    <div class="doctor-socials">
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 6a2 2 0 100-4 2 2 0 000 4z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
                    </div>
                </div>
                <div class="doctor-content">
                    <h3>Dr. Michael Chen</h3>
                    <p>Chief Cardiologist</p>
                    <div class="doctor-rating">
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <span>4.9</span>
                    </div>
                </div>
            </div>
            <div class="doctor-card">
                <div class="doctor-image">
                    <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=400" alt="Dr. Sarah Mitchell">
                    <div class="doctor-socials">
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 6a2 2 0 100-4 2 2 0 000 4z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
                    </div>
                </div>
                <div class="doctor-content">
                    <h3>Dr. Sarah Mitchell</h3>
                    <p>Neurologist</p>
                    <div class="doctor-rating">
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <span>4.8</span>
                    </div>
                </div>
            </div>
            <div class="doctor-card">
                <div class="doctor-image">
                    <img src="https://images.unsplash.com/photo-1537368910025-700350fe46c7?w=400" alt="Dr. James Wilson">
                    <div class="doctor-socials">
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 6a2 2 0 100-4 2 2 0 000 4z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
                    </div>
                </div>
                <div class="doctor-content">
                    <h3>Dr. James Wilson</h3>
                    <p>Orthopedic Surgeon</p>
                    <div class="doctor-rating">
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <span>4.9</span>
                    </div>
                </div>
            </div>
            <div class="doctor-card">
                <div class="doctor-image">
                    <img src="https://images.unsplash.com/photo-1594824476967-48c8b964273f?w=400" alt="Dr. Emily Rodriguez">
                    <div class="doctor-socials">
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 6a2 2 0 100-4 2 2 0 000 4z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
                    </div>
                </div>
                <div class="doctor-content">
                    <h3>Dr. Emily Rodriguez</h3>
                    <p>Pediatrician</p>
                    <div class="doctor-rating">
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        <span>5.0</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Appointment Section -->
    <section class="appointment" id="appointment">
        <div class="appointment-container">
            <div class="appointment-content">
                <span class="section-badge">Book Now</span>
                <h2>Schedule Your <em>Appointment</em> Today</h2>
                <p>Take the first step towards better health. Our easy online booking system lets you schedule appointments with our specialists at your convenience.</p>
                <div class="appointment-features">
                    <div class="appointment-feature">
                        <div class="appointment-feature-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        </div>
                        <div>
                            <h4>Quick Response</h4>
                            <p>Get confirmation within 30 minutes</p>
                        </div>
                    </div>
                    <div class="appointment-feature">
                        <div class="appointment-feature-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div>
                            <h4>Safe & Secure</h4>
                            <p>Your data is protected</p>
                        </div>
                    </div>
                    <div class="appointment-feature">
                        <div class="appointment-feature-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </div>
                        <div>
                            <h4>Flexible Timing</h4>
                            <p>Morning to evening slots</p>
                        </div>
                    </div>
                    <div class="appointment-feature">
                        <div class="appointment-feature-icon">
                            <svg viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                        </div>
                        <div>
                            <h4>24/7 Support</h4>
                            <p>Always here to help</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="appointment-form-wrapper">
                <form class="appointment-form">
                    <h3>Request Appointment</h3>
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
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" placeholder="john@example.com">
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" placeholder="+1 (555) 000-0000">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Department</label>
                            <select>
                                <option>Select Department</option>
                                <option>Cardiology</option>
                                <option>Neurology</option>
                                <option>Orthopedics</option>
                                <option>Pediatrics</option>
                                <option>Emergency</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Preferred Date</label>
                            <input type="date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Additional Notes</label>
                        <textarea placeholder="Describe your symptoms or concerns..."></textarea>
                    </div>
                    <button type="submit" class="form-submit">Book Appointment</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="testimonials-bg"></div>
        <div class="testimonials-header">
            <span class="section-badge">Testimonials</span>
            <h2>What Our <em>Patients</em> Say</h2>
            <p>Real stories from real patients who have experienced our care and commitment to their health.</p>
        </div>
        <div class="testimonials-slider">
            <div class="testimonial-card active">
                <div class="testimonial-quote">
                    <svg viewBox="0 0 24 24"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V21c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                </div>
                <p>"The care I received at MediCare Plus was exceptional. Dr. Chen and his team took the time to explain everything and made me feel comfortable throughout my heart procedure. I'm forever grateful."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200" alt="Robert Thompson">
                    <div class="testimonial-author-info">
                        <h4>Robert Thompson</h4>
                        <span>Heart Surgery Patient</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-quote">
                    <svg viewBox="0 0 24 24"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V21c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                </div>
                <p>"As a mother of three, finding a pediatrician who genuinely cares was my priority. Dr. Rodriguez is amazing with my kids, and the staff always makes our visits pleasant and stress-free."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200" alt="Jennifer Martinez">
                    <div class="testimonial-author-info">
                        <h4>Jennifer Martinez</h4>
                        <span>Pediatric Care Parent</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-quote">
                    <svg viewBox="0 0 24 24"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V21c0 1 0 1 1 1zm12 0c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                </div>
                <p>"After my sports injury, Dr. Wilson performed my knee surgery and guided me through rehabilitation. Six months later, I'm back on the field thanks to his expertise and dedication."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200" alt="David Kim">
                    <div class="testimonial-author-info">
                        <h4>David Kim</h4>
                        <span>Orthopedic Patient</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="testimonials-dots">
            <button class="active" data-index="0"></button>
            <button data-index="1"></button>
            <button data-index="2"></button>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-container">
            <div class="cta-shape cta-shape-1"></div>
            <div class="cta-shape cta-shape-2"></div>
            <div class="cta-content">
                <h2>Ready to Start Your <em>Health Journey?</em></h2>
                <p>Join thousands of patients who trust MediCare Plus for their healthcare needs. Book your appointment today and experience the difference.</p>
                <div class="cta-buttons">
                    <a href="#appointment" class="btn-primary">
                        Book Appointment
                        <svg viewBox="0 0 24 24" width="20" height="20"><path d="M9 5l7 7-7 7" fill="currentColor"/></svg>
                    </a>
                    <a href="tel:+15550000000" class="btn-secondary">
                        <svg viewBox="0 0 24 24" stroke-width="2" width="20" height="20"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                        Call Us Now
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-about">
                    <a href="#" class="logo">
                        <div class="logo-icon">
                            <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10h-4v4h-2v-4H7v-2h4V7h2v4h4v2z"/></svg>
                        </div>
                        <span class="logo-text">MediCare<span>Plus</span></span>
                    </a>
                    <p>Providing exceptional healthcare services with compassion and expertise for over 25 years. Your health is our priority.</p>
                    <div class="footer-socials">
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 6a2 2 0 100-4 2 2 0 000 4z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
                    </div>
                </div>
                <div class="footer-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#services">Our Services</a></li>
                        <li><a href="#doctors">Our Doctors</a></li>
                        <li><a href="#appointment">Book Appointment</a></li>
                        <li><a href="#">Patient Portal</a></li>
                        <li><a href="#">Insurance</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Departments</h4>
                    <ul>
                        <li><a href="#">Cardiology</a></li>
                        <li><a href="#">Neurology</a></li>
                        <li><a href="#">Orthopedics</a></li>
                        <li><a href="#">Pediatrics</a></li>
                        <li><a href="#">Emergency</a></li>
                    </ul>
                </div>
                <div class="footer-links footer-contact">
                    <h4>Contact Us</h4>
                    <p>
                        <svg viewBox="0 0 24 24" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        123 Medical Center Drive, Healthcare City, HC 12345
                    </p>
                    <p>
                        <svg viewBox="0 0 24 24" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                        +1 (555) 000-0000
                    </p>
                    <p>
                        <svg viewBox="0 0 24 24" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        contact@medicareplus.com
                    </p>
                    <p>
                        <svg viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Mon - Sun: 24/7 Emergency
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 MediCare Plus. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms of Service</a>
                    <a href="#">HIPAA Compliance</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Loader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.querySelector('.loader').classList.add('hidden');
            }, 2500);
        });

        // Navigation scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 100) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Mobile menu
        const menuToggle = document.querySelector('.menu-toggle');
        const mobileMenu = document.querySelector('.mobile-menu');
        const mobileOverlay = document.querySelector('.mobile-overlay');
        const mobileMenuClose = document.querySelector('.mobile-menu-close');
        const mobileLinks = document.querySelectorAll('.mobile-menu a');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.add('active');
            mobileOverlay.classList.add('active');
        });

        const closeMobileMenu = () => {
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
        };

        mobileMenuClose.addEventListener('click', closeMobileMenu);
        mobileOverlay.addEventListener('click', closeMobileMenu);
        mobileLinks.forEach(link => link.addEventListener('click', closeMobileMenu));

        // Scroll reveal animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.service-card, .doctor-card, .appointment-content, .appointment-form-wrapper').forEach(el => {
            observer.observe(el);
        });

        // Testimonials slider
        const testimonials = document.querySelectorAll('.testimonial-card');
        const dots = document.querySelectorAll('.testimonials-dots button');
        let currentTestimonial = 0;

        function showTestimonial(index) {
            testimonials.forEach(t => t.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            testimonials[index].classList.add('active');
            dots[index].classList.add('active');
            currentTestimonial = index;
        }

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => showTestimonial(index));
        });

        // Auto slide testimonials
        setInterval(() => {
            currentTestimonial = (currentTestimonial + 1) % testimonials.length;
            showTestimonial(currentTestimonial);
        }, 5000);

        // Smooth scroll for anchor links
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

        // Form submission
        document.querySelector('.appointment-form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Thank you for booking! We will contact you shortly to confirm your appointment.');
        });
    </script>
</body>
</html>
