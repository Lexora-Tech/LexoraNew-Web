<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HopeRise Foundation | Making a Difference Together</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2D5A3D;
            --primary-light: #4A7C5C;
            --accent: #E8B84A;
            --background: #FDF8F3;
            --background-alt: #F5EDE4;
            --foreground: #1A1A1A;
            --foreground-muted: #6B6B6B;
            --card: #FFFFFF;
            --border: #E5DED4;
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
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.6s ease, visibility 0.6s ease;
        }

        .loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .loader-content {
            text-align: center;
            color: var(--background);
        }

        .loader-heart {
            width: 60px;
            height: 60px;
            animation: heartbeat 1s ease-in-out infinite;
        }

        .loader-heart svg {
            fill: var(--accent);
        }

        .loader-text {
            margin-top: 20px;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            letter-spacing: 2px;
        }

        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.1); }
            50% { transform: scale(1); }
            75% { transform: scale(1.15); }
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: background 0.3s ease, backdrop-filter 0.3s ease;
        }

        nav.scrolled {
            background: rgba(253, 248, 243, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo svg {
            width: 32px;
            height: 32px;
            fill: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--foreground);
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .donate-btn {
            background: var(--primary);
            color: var(--background);
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            border: 2px solid var(--primary);
        }

        .donate-btn:hover {
            background: transparent;
            color: var(--primary);
        }

        .menu-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            z-index: 1001;
        }

        .menu-toggle span {
            width: 25px;
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
            top: 0;
            right: 0;
            width: 55%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1200') center/cover;
            clip-path: polygon(15% 0, 100% 0, 100% 100%, 0% 100%);
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, var(--background) 0%, transparent 30%);
        }

        .hero-content {
            max-width: 600px;
            position: relative;
            z-index: 2;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--background-alt);
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--primary);
            margin-bottom: 24px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.8s ease 0.3s forwards;
        }

        .hero-tag::before {
            content: '';
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 24px;
            color: var(--foreground);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 0.5s forwards;
        }

        .hero h1 span {
            color: var(--primary);
        }

        .hero p {
            font-size: 1.15rem;
            color: var(--foreground-muted);
            margin-bottom: 36px;
            max-width: 500px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 0.7s forwards;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 0.9s forwards;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--background);
            padding: 16px 36px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: 2px solid var(--primary);
        }

        .btn-primary:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(45, 90, 61, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: var(--foreground);
            padding: 16px 36px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: 2px solid var(--border);
        }

        .btn-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stats Marquee */
        .stats-marquee {
            background: var(--primary);
            padding: 20px 0;
            overflow: hidden;
        }

        .marquee-track {
            display: flex;
            animation: marquee 30s linear infinite;
        }

        .marquee-content {
            display: flex;
            align-items: center;
            gap: 60px;
            padding: 0 30px;
            flex-shrink: 0;
        }

        .marquee-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--background);
            white-space: nowrap;
        }

        .marquee-item strong {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--accent);
        }

        .marquee-item span {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .marquee-divider {
            width: 6px;
            height: 6px;
            background: var(--accent);
            border-radius: 50%;
            opacity: 0.5;
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Causes Section */
        .causes {
            padding: 100px 5%;
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 60px;
        }

        .section-tag {
            display: inline-block;
            background: var(--primary);
            color: var(--background);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
        }

        .section-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 3rem);
            margin-bottom: 16px;
            color: var(--foreground);
        }

        .section-header p {
            color: var(--foreground-muted);
            font-size: 1.1rem;
        }

        .causes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .cause-card {
            background: var(--card);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.4s ease;
            opacity: 0;
            transform: translateY(40px);
        }

        .cause-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .cause-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .cause-image {
            height: 220px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .cause-image::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(0, 0, 0, 0.4) 100%);
        }

        .cause-category {
            position: absolute;
            top: 16px;
            left: 16px;
            background: var(--accent);
            color: var(--foreground);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            z-index: 2;
        }

        .cause-content {
            padding: 28px;
        }

        .cause-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            margin-bottom: 12px;
            color: var(--foreground);
        }

        .cause-content p {
            color: var(--foreground-muted);
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        .cause-progress {
            margin-bottom: 16px;
        }

        .progress-bar {
            height: 8px;
            background: var(--background-alt);
            border-radius: 50px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            border-radius: 50px;
            transition: width 1.5s ease;
            width: 0;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 0.85rem;
        }

        .progress-info strong {
            color: var(--primary);
        }

        .cause-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: gap 0.3s ease;
        }

        .cause-link:hover {
            gap: 12px;
        }

        /* Impact Section */
        .impact {
            background: var(--background-alt);
            padding: 100px 5%;
        }

        .impact-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .impact-image {
            position: relative;
        }

        .impact-image img {
            width: 100%;
            border-radius: var(--radius);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .impact-badge {
            position: absolute;
            bottom: -30px;
            right: -30px;
            background: var(--accent);
            color: var(--foreground);
            padding: 24px 32px;
            border-radius: var(--radius);
            text-align: center;
            box-shadow: 0 10px 30px rgba(232, 184, 74, 0.4);
        }

        .impact-badge strong {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
        }

        .impact-badge span {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .impact-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 2.8rem);
            margin-bottom: 24px;
            color: var(--foreground);
        }

        .impact-content > p {
            color: var(--foreground-muted);
            font-size: 1.1rem;
            margin-bottom: 40px;
        }

        .impact-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }

        .stat-item {
            text-align: center;
            padding: 24px;
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .stat-item .number {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            display: block;
        }

        .stat-item span {
            color: var(--foreground-muted);
            font-size: 0.9rem;
        }

        /* Volunteer Section */
        .volunteer {
            padding: 100px 5%;
            background: var(--primary);
            position: relative;
            overflow: hidden;
        }

        .volunteer::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: var(--primary-light);
            border-radius: 50%;
            opacity: 0.3;
        }

        .volunteer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .volunteer-content {
            color: var(--background);
        }

        .volunteer-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 4vw, 2.8rem);
            margin-bottom: 20px;
        }

        .volunteer-content p {
            opacity: 0.9;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .volunteer-perks {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .perk {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .perk-icon {
            width: 40px;
            height: 40px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .perk-icon svg {
            width: 20px;
            height: 20px;
            fill: var(--foreground);
        }

        .perk span {
            font-size: 1rem;
        }

        .volunteer-form {
            background: var(--card);
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .volunteer-form h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            margin-bottom: 24px;
            color: var(--foreground);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--foreground);
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--border);
            border-radius: 8px;
            font-size: 1rem;
            font-family: inherit;
            background: var(--background);
            color: var(--foreground);
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-submit {
            width: 100%;
            background: var(--primary);
            color: var(--background);
            padding: 16px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-submit:hover {
            background: var(--primary-light);
        }

        /* Testimonials */
        .testimonials {
            padding: 100px 5%;
            background: var(--background);
        }

        .testimonials-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .testimonial-card {
            background: var(--card);
            padding: 36px;
            border-radius: var(--radius);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            position: relative;
            transition: transform 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
        }

        .quote-icon {
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .quote-icon svg {
            width: 24px;
            height: 24px;
            fill: var(--background);
        }

        .testimonial-card p {
            font-size: 1.05rem;
            color: var(--foreground-muted);
            line-height: 1.7;
            margin-bottom: 24px;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .author-info strong {
            display: block;
            color: var(--foreground);
            font-size: 1rem;
        }

        .author-info span {
            color: var(--foreground-muted);
            font-size: 0.85rem;
        }

        /* CTA Section */
        .cta {
            padding: 120px 5%;
            background: linear-gradient(135deg, var(--background-alt) 0%, var(--background) 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--primary) 0%, transparent 70%);
            opacity: 0.05;
            top: -200px;
            left: 50%;
            transform: translateX(-50%);
        }

        .cta-content {
            max-width: 700px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .cta h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            margin-bottom: 20px;
            color: var(--foreground);
        }

        .cta p {
            font-size: 1.15rem;
            color: var(--foreground-muted);
            margin-bottom: 40px;
        }

        .cta-buttons {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Footer */
        footer {
            background: var(--foreground);
            color: var(--background);
            padding: 80px 5% 30px;
        }

        .footer-grid {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-brand .logo {
            color: var(--background);
            margin-bottom: 20px;
        }

        .footer-brand p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            margin-bottom: 24px;
            max-width: 300px;
        }

        .social-links {
            display: flex;
            gap: 12px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .social-links a:hover {
            background: var(--accent);
        }

        .social-links svg {
            width: 18px;
            height: 18px;
            fill: var(--background);
        }

        .footer-column h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 24px;
            color: var(--background);
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 12px;
        }

        .footer-column a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .footer-column a:hover {
            color: var(--accent);
        }

        .footer-bottom {
            max-width: 1400px;
            margin: 0 auto;
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
            font-size: 0.9rem;
        }

        .footer-legal {
            display: flex;
            gap: 24px;
        }

        .footer-legal a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-legal a:hover {
            color: var(--accent);
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .impact-container,
            .volunteer-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .impact-badge {
                right: 20px;
                bottom: -20px;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 40px;
            }
        }

        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: var(--background);
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 30px;
            }

            .nav-links.active {
                display: flex;
            }

            .nav-links a {
                font-size: 1.5rem;
            }

            .menu-toggle {
                display: flex;
            }

            .donate-btn {
                display: none;
            }

            .hero-bg {
                width: 100%;
                height: 40%;
                top: auto;
                bottom: 0;
                clip-path: polygon(0 30%, 100% 0, 100% 100%, 0 100%);
            }

            .hero {
                padding-bottom: 300px;
            }

            .hero-content {
                max-width: 100%;
            }

            .impact-stats {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .volunteer-form {
                padding: 28px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Scroll Animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
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
        <div class="loader-content">
            <div class="loader-heart">
                <svg viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </div>
            <p class="loader-text">HopeRise</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav id="navbar">
        <a href="#" class="logo">
            <svg viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            HopeRise
        </a>
        <ul class="nav-links" id="navLinks">
            <li><a href="#causes">Our Causes</a></li>
            <li><a href="#impact">Impact</a></li>
            <li><a href="#volunteer">Volunteer</a></li>
            <li><a href="#testimonials">Stories</a></li>
        </ul>
        <a href="#donate" class="donate-btn">Donate Now</a>
        <div class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <span class="hero-tag">Making a Difference Since 2010</span>
            <h1>Together We Can <span>Change Lives</span> Forever</h1>
            <p>Join our mission to provide education, clean water, healthcare, and hope to communities in need around the world.</p>
            <div class="hero-buttons">
                <a href="#donate" class="btn-primary">
                    Donate Now
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </a>
                <a href="#causes" class="btn-secondary">
                    Our Causes
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Stats Marquee -->
    <div class="stats-marquee">
        <div class="marquee-track">
            <div class="marquee-content">
                <div class="marquee-item"><strong>20M+</strong><span>People Helped</span></div>
                <div class="marquee-divider"></div>
                <div class="marquee-item"><strong>186K</strong><span>Projects Completed</span></div>
                <div class="marquee-divider"></div>
                <div class="marquee-item"><strong>45</strong><span>Countries Reached</span></div>
                <div class="marquee-divider"></div>
                <div class="marquee-item"><strong>$50M</strong><span>Funds Raised</span></div>
                <div class="marquee-divider"></div>
                <div class="marquee-item"><strong>12K</strong><span>Active Volunteers</span></div>
                <div class="marquee-divider"></div>
            </div>
            <div class="marquee-content">
                <div class="marquee-item"><strong>20M+</strong><span>People Helped</span></div>
                <div class="marquee-divider"></div>
                <div class="marquee-item"><strong>186K</strong><span>Projects Completed</span></div>
                <div class="marquee-divider"></div>
                <div class="marquee-item"><strong>45</strong><span>Countries Reached</span></div>
                <div class="marquee-divider"></div>
                <div class="marquee-item"><strong>$50M</strong><span>Funds Raised</span></div>
                <div class="marquee-divider"></div>
                <div class="marquee-item"><strong>12K</strong><span>Active Volunteers</span></div>
                <div class="marquee-divider"></div>
            </div>
        </div>
    </div>

    <!-- Causes Section -->
    <section class="causes" id="causes">
        <div class="section-header reveal">
            <span class="section-tag">What We Do</span>
            <h2>Our Causes That Matter</h2>
            <p>We focus on critical areas where your support can create lasting change for communities worldwide.</p>
        </div>
        <div class="causes-grid">
            <div class="cause-card">
                <div class="cause-image" style="background-image: url('https://images.unsplash.com/photo-1497486751825-1233686d5d80?w=600')">
                    <span class="cause-category">Education</span>
                </div>
                <div class="cause-content">
                    <h3>Education for All</h3>
                    <p>Providing quality education and school supplies to children in underserved communities.</p>
                    <div class="cause-progress">
                        <div class="progress-bar"><div class="progress-fill" data-width="78"></div></div>
                        <div class="progress-info"><span>Raised: <strong>$78,500</strong></span><span>Goal: $100,000</span></div>
                    </div>
                    <a href="#" class="cause-link">Learn More <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                </div>
            </div>
            <div class="cause-card">
                <div class="cause-image" style="background-image: url('https://images.unsplash.com/photo-1541544537156-7627a7a4aa1c?w=600')">
                    <span class="cause-category">Clean Water</span>
                </div>
                <div class="cause-content">
                    <h3>Clean Water Initiative</h3>
                    <p>Building wells and water systems to provide safe drinking water to remote villages.</p>
                    <div class="cause-progress">
                        <div class="progress-bar"><div class="progress-fill" data-width="92"></div></div>
                        <div class="progress-info"><span>Raised: <strong>$92,000</strong></span><span>Goal: $100,000</span></div>
                    </div>
                    <a href="#" class="cause-link">Learn More <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                </div>
            </div>
            <div class="cause-card">
                <div class="cause-image" style="background-image: url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?w=600')">
                    <span class="cause-category">Healthcare</span>
                </div>
                <div class="cause-content">
                    <h3>Medical Aid Program</h3>
                    <p>Delivering essential medical supplies and healthcare services to communities in crisis.</p>
                    <div class="cause-progress">
                        <div class="progress-bar"><div class="progress-fill" data-width="65"></div></div>
                        <div class="progress-info"><span>Raised: <strong>$65,000</strong></span><span>Goal: $100,000</span></div>
                    </div>
                    <a href="#" class="cause-link">Learn More <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                </div>
            </div>
            <div class="cause-card">
                <div class="cause-image" style="background-image: url('https://images.unsplash.com/photo-1593113598332-cd288d649433?w=600')">
                    <span class="cause-category">Hunger Relief</span>
                </div>
                <div class="cause-content">
                    <h3>Food Security Program</h3>
                    <p>Providing nutritious meals and sustainable farming solutions to fight hunger.</p>
                    <div class="cause-progress">
                        <div class="progress-bar"><div class="progress-fill" data-width="84"></div></div>
                        <div class="progress-info"><span>Raised: <strong>$84,000</strong></span><span>Goal: $100,000</span></div>
                    </div>
                    <a href="#" class="cause-link">Learn More <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                </div>
            </div>
            <div class="cause-card">
                <div class="cause-image" style="background-image: url('https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?w=600')">
                    <span class="cause-category">Environment</span>
                </div>
                <div class="cause-content">
                    <h3>Green Earth Initiative</h3>
                    <p>Planting trees and promoting sustainable practices to protect our planet.</p>
                    <div class="cause-progress">
                        <div class="progress-bar"><div class="progress-fill" data-width="56"></div></div>
                        <div class="progress-info"><span>Raised: <strong>$56,000</strong></span><span>Goal: $100,000</span></div>
                    </div>
                    <a href="#" class="cause-link">Learn More <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                </div>
            </div>
            <div class="cause-card">
                <div class="cause-image" style="background-image: url('https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=600')">
                    <span class="cause-category">Housing</span>
                </div>
                <div class="cause-content">
                    <h3>Shelter for Families</h3>
                    <p>Building safe, affordable homes for families affected by disasters and poverty.</p>
                    <div class="cause-progress">
                        <div class="progress-bar"><div class="progress-fill" data-width="71"></div></div>
                        <div class="progress-info"><span>Raised: <strong>$71,000</strong></span><span>Goal: $100,000</span></div>
                    </div>
                    <a href="#" class="cause-link">Learn More <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Section -->
    <section class="impact" id="impact">
        <div class="impact-container">
            <div class="impact-image reveal">
                <img src="https://images.unsplash.com/photo-1509099836639-18ba1795216d?w=800" alt="Children smiling">
                <div class="impact-badge">
                    <strong>15+</strong>
                    <span>Years of Impact</span>
                </div>
            </div>
            <div class="impact-content reveal">
                <span class="section-tag">Our Impact</span>
                <h2>Know That Your Donation is Making a Difference</h2>
                <p>Every dollar you donate goes directly to funding projects that change lives. We maintain complete transparency and accountability in all our operations.</p>
                <div class="impact-stats">
                    <div class="stat-item">
                        <span class="number" data-target="20">0</span>
                        <span>Million Lives</span>
                    </div>
                    <div class="stat-item">
                        <span class="number" data-target="186">0</span>
                        <span>K Projects</span>
                    </div>
                    <div class="stat-item">
                        <span class="number" data-target="45">0</span>
                        <span>Countries</span>
                    </div>
                </div>
                <a href="#" class="btn-primary">View Our Reports <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
            </div>
        </div>
    </section>

    <!-- Volunteer Section -->
    <section class="volunteer" id="volunteer">
        <div class="volunteer-container">
            <div class="volunteer-content reveal">
                <span class="section-tag" style="background: var(--accent); color: var(--foreground);">Join Us</span>
                <h2>Become a Volunteer Today</h2>
                <p>Make a direct impact by giving your time and skills. Whether locally or abroad, there's a place for you in our community of changemakers.</p>
                <div class="volunteer-perks">
                    <div class="perk">
                        <div class="perk-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></div>
                        <span>Flexible scheduling that fits your lifestyle</span>
                    </div>
                    <div class="perk">
                        <div class="perk-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></div>
                        <span>Training and support from our expert team</span>
                    </div>
                    <div class="perk">
                        <div class="perk-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></div>
                        <span>Connect with a global community of givers</span>
                    </div>
                    <div class="perk">
                        <div class="perk-icon"><svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg></div>
                        <span>Make real, measurable impact in lives</span>
                    </div>
                </div>
            </div>
            <div class="volunteer-form reveal">
                <h3>Sign Up to Volunteer</h3>
                <form>
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="interest">Area of Interest</label>
                        <select id="interest">
                            <option value="">Select an area</option>
                            <option value="education">Education</option>
                            <option value="healthcare">Healthcare</option>
                            <option value="environment">Environment</option>
                            <option value="community">Community Outreach</option>
                            <option value="fundraising">Fundraising</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Why do you want to volunteer?</label>
                        <textarea id="message" placeholder="Tell us about yourself..."></textarea>
                    </div>
                    <button type="submit" class="form-submit">Submit Application</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="section-header reveal">
            <span class="section-tag">Stories</span>
            <h2>Voices of Change</h2>
            <p>Hear from the people whose lives have been transformed through our programs.</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card reveal">
                <div class="quote-icon">
                    <svg viewBox="0 0 24 24"><path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/></svg>
                </div>
                <p>"Thanks to HopeRise, my children can now attend school. The education program has given them hope for a brighter future that I never thought possible."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=100" alt="Maria" class="author-avatar">
                    <div class="author-info">
                        <strong>Maria Santos</strong>
                        <span>Program Beneficiary, Philippines</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card reveal">
                <div class="quote-icon">
                    <svg viewBox="0 0 24 24"><path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/></svg>
                </div>
                <p>"Volunteering with HopeRise has been the most rewarding experience of my life. Seeing the direct impact of our work keeps me motivated every day."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="James" class="author-avatar">
                    <div class="author-info">
                        <strong>James Mitchell</strong>
                        <span>Volunteer Coordinator, USA</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card reveal">
                <div class="quote-icon">
                    <svg viewBox="0 0 24 24"><path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/></svg>
                </div>
                <p>"The clean water well built in our village has transformed our community. Women and children no longer walk miles for water—they can focus on their dreams."</p>
                <div class="testimonial-author">
                    <img src="https://images.unsplash.com/photo-1489424731084-a5d8b219a5bb?w=100" alt="Amara" class="author-avatar">
                    <div class="author-info">
                        <strong>Amara Okonkwo</strong>
                        <span>Village Elder, Nigeria</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="donate">
        <div class="cta-content reveal">
            <h2>Every Gift Makes a Difference</h2>
            <p>Your donation, no matter the size, helps us continue our mission to create lasting change in communities around the world.</p>
            <div class="cta-buttons">
                <a href="#" class="btn-primary">
                    Donate $25
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </a>
                <a href="#" class="btn-primary" style="background: var(--accent); border-color: var(--accent); color: var(--foreground);">
                    Donate $50
                </a>
                <a href="#" class="btn-primary" style="background: var(--primary-light); border-color: var(--primary-light);">
                    Donate $100
                </a>
                <a href="#" class="btn-secondary">
                    Custom Amount
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="#" class="logo">
                    <svg viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    HopeRise
                </a>
                <p>Empowering communities and transforming lives through sustainable development programs worldwide.</p>
                <div class="social-links">
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg></a>
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Our Mission</a></li>
                    <li><a href="#">Programs</a></li>
                    <li><a href="#">Success Stories</a></li>
                    <li><a href="#">News & Events</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Get Involved</h4>
                <ul>
                    <li><a href="#">Donate Now</a></li>
                    <li><a href="#">Volunteer</a></li>
                    <li><a href="#">Fundraise</a></li>
                    <li><a href="#">Partner With Us</a></li>
                    <li><a href="#">Corporate Giving</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Contact</h4>
                <ul>
                    <li><a href="#">info@hoperise.org</a></li>
                    <li><a href="#">+1 (555) 123-4567</a></li>
                    <li><a href="#">123 Hope Street</a></li>
                    <li><a href="#">New York, NY 10001</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> HopeRise Foundation. All rights reserved.</p>
            <div class="footer-legal">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Cookie Policy</a>
            </div>
        </div>
    </footer>

    <script>
        // Loader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('loader').classList.add('hidden');
            }, 1500);
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

        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const navLinks = document.getElementById('navLinks');
        menuToggle.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Scroll reveal animations
        const revealElements = document.querySelectorAll('.reveal, .cause-card');
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 100);
                }
            });
        }, { threshold: 0.1 });

        revealElements.forEach(el => revealObserver.observe(el));

        // Progress bar animation
        const progressBars = document.querySelectorAll('.progress-fill');
        const progressObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const width = entry.target.getAttribute('data-width');
                    entry.target.style.width = width + '%';
                }
            });
        }, { threshold: 0.5 });

        progressBars.forEach(bar => progressObserver.observe(bar));

        // Counter animation
        const counters = document.querySelectorAll('.stat-item .number');
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.getAttribute('data-target'));
                    let count = 0;
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    
                    const updateCounter = () => {
                        count += increment;
                        if (count < target) {
                            entry.target.textContent = Math.floor(count);
                            requestAnimationFrame(updateCounter);
                        } else {
                            entry.target.textContent = target;
                        }
                    };
                    updateCounter();
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        counters.forEach(counter => counterObserver.observe(counter));

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    navLinks.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
