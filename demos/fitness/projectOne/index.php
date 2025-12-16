<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APEX FITNESS | Transform Your Body, Transform Your Life</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #FF3E3E;
            --primary-dark: #D62828;
            --accent: #FFD60A;
            --background: #0A0A0A;
            --background-alt: #141414;
            --foreground: #FFFFFF;
            --foreground-muted: #A0A0A0;
            --card: #1A1A1A;
            --border: #2A2A2A;
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
        }

        .loader-icon {
            width: 80px;
            height: 80px;
            position: relative;
            animation: pulse 1.2s ease-in-out infinite;
        }

        .loader-icon svg {
            width: 100%;
            height: 100%;
            fill: var(--primary);
        }

        .loader-bar {
            width: 200px;
            height: 4px;
            background: var(--border);
            border-radius: 50px;
            margin-top: 30px;
            overflow: hidden;
        }

        .loader-progress {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 50px;
            animation: loading 1.5s ease-in-out infinite;
        }

        .loader-text {
            margin-top: 20px;
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            letter-spacing: 4px;
            color: var(--foreground);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        @keyframes loading {
            0% { width: 0; margin-left: 0; }
            50% { width: 100%; margin-left: 0; }
            100% { width: 0; margin-left: 100%; }
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
            transition: all 0.3s ease;
        }

        nav.scrolled {
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(20px);
            padding: 15px 5%;
        }

        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            color: var(--foreground);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            letter-spacing: 2px;
        }

        .logo span {
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--foreground-muted);
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
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

        .nav-links a:hover {
            color: var(--foreground);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .join-btn {
            background: var(--primary);
            color: var(--foreground);
            padding: 14px 32px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }

        .join-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 62, 62, 0.4);
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
            padding: 100px 5%;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            right: 0;
            width: 60%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1200') center/cover;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, var(--background) 0%, rgba(10, 10, 10, 0.7) 50%, rgba(10, 10, 10, 0.3) 100%);
        }

        .hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 70%, var(--background) 100%);
        }

        .hero-content {
            max-width: 700px;
            position: relative;
            z-index: 2;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 62, 62, 0.1);
            border: 1px solid var(--primary);
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 30px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.8s ease 0.3s forwards;
        }

        .hero h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(4rem, 10vw, 8rem);
            line-height: 0.95;
            margin-bottom: 30px;
            color: var(--foreground);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 0.5s forwards;
        }

        .hero h1 span {
            color: var(--primary);
            display: block;
        }

        .hero p {
            font-size: 1.2rem;
            color: var(--foreground-muted);
            margin-bottom: 40px;
            max-width: 500px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 0.7s forwards;
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 0.9s forwards;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--foreground);
            padding: 18px 40px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 62, 62, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--foreground);
            padding: 18px 40px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            border: 2px solid var(--border);
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .hero-stats {
            display: flex;
            gap: 50px;
            margin-top: 60px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 0.8s ease 1.1s forwards;
        }

        .hero-stat {
            text-align: left;
        }

        .hero-stat strong {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3rem;
            color: var(--primary);
            display: block;
            line-height: 1;
        }

        .hero-stat span {
            color: var(--foreground-muted);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Marquee */
        .marquee-section {
            background: var(--primary);
            padding: 20px 0;
            overflow: hidden;
        }

        .marquee-track {
            display: flex;
            animation: marquee 25s linear infinite;
        }

        .marquee-content {
            display: flex;
            align-items: center;
            gap: 50px;
            padding: 0 25px;
            flex-shrink: 0;
        }

        .marquee-item {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.5rem;
            color: var(--background);
            letter-spacing: 3px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .marquee-item::after {
            content: '★';
            color: var(--accent);
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Programs Section */
        .programs {
            padding: 120px 5%;
            background: var(--background);
        }

        .section-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 70px;
        }

        .section-tag {
            display: inline-block;
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 16px;
        }

        .section-header h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3rem, 6vw, 4.5rem);
            margin-bottom: 20px;
            color: var(--foreground);
            letter-spacing: 2px;
        }

        .section-header p {
            color: var(--foreground-muted);
            font-size: 1.1rem;
        }

        .programs-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .program-card {
            background: var(--card);
            border-radius: var(--radius);
            overflow: hidden;
            position: relative;
            min-height: 400px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            cursor: pointer;
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.4s ease;
        }

        .program-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .program-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform 0.5s ease;
        }

        .program-card:hover::before {
            transform: scale(1.1);
        }

        .program-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 30%, rgba(10, 10, 10, 0.95) 100%);
        }

        .program-card:nth-child(1)::before { background-image: url('https://images.unsplash.com/photo-1581009146145-b5ef050c149a?w=600'); }
        .program-card:nth-child(2)::before { background-image: url('https://images.unsplash.com/photo-1518611012118-696072aa579a?w=600'); }
        .program-card:nth-child(3)::before { background-image: url('https://images.unsplash.com/photo-1599058917765-a780eda07a3e?w=600'); }
        .program-card:nth-child(4)::before { background-image: url('https://images.unsplash.com/photo-1574680096145-d05b474e2155?w=600'); }

        .program-content {
            position: relative;
            z-index: 2;
            padding: 30px;
        }

        .program-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .program-card:hover .program-icon {
            transform: scale(1.1);
        }

        .program-icon svg {
            width: 24px;
            height: 24px;
            fill: var(--foreground);
        }

        .program-content h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        .program-content p {
            color: var(--foreground-muted);
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

        .program-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: gap 0.3s ease;
        }

        .program-link:hover {
            gap: 14px;
        }

        /* Trainers Section */
        .trainers {
            padding: 120px 5%;
            background: var(--background-alt);
        }

        .trainers-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .trainer-card {
            position: relative;
            overflow: hidden;
            border-radius: var(--radius);
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.4s ease;
        }

        .trainer-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .trainer-image {
            height: 450px;
            background-size: cover;
            background-position: center top;
            transition: transform 0.5s ease;
        }

        .trainer-card:hover .trainer-image {
            transform: scale(1.05);
        }

        .trainer-card:nth-child(1) .trainer-image { background-image: url('https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=500'); }
        .trainer-card:nth-child(2) .trainer-image { background-image: url('https://images.unsplash.com/photo-1594381898411-846e7d193883?w=500'); }
        .trainer-card:nth-child(3) .trainer-image { background-image: url('https://images.unsplash.com/photo-1567013127542-490d757e51fc?w=500'); }
        .trainer-card:nth-child(4) .trainer-image { background-image: url('https://images.unsplash.com/photo-1597347316205-36f6c451902a?w=500'); }

        .trainer-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px;
            background: linear-gradient(180deg, transparent, rgba(10, 10, 10, 0.95));
            transform: translateY(60px);
            transition: transform 0.4s ease;
        }

        .trainer-card:hover .trainer-overlay {
            transform: translateY(0);
        }

        .trainer-overlay h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.6rem;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .trainer-overlay .role {
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .trainer-socials {
            display: flex;
            gap: 12px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease 0.1s;
        }

        .trainer-card:hover .trainer-socials {
            opacity: 1;
            transform: translateY(0);
        }

        .trainer-socials a {
            width: 36px;
            height: 36px;
            background: var(--card);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .trainer-socials a:hover {
            background: var(--primary);
        }

        .trainer-socials svg {
            width: 16px;
            height: 16px;
            fill: var(--foreground);
        }

        /* Pricing Section */
        .pricing {
            padding: 120px 5%;
            background: var(--background);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .pricing-card {
            background: var(--card);
            border-radius: var(--radius);
            padding: 50px 40px;
            text-align: center;
            position: relative;
            border: 2px solid var(--border);
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.4s ease;
        }

        .pricing-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .pricing-card.featured {
            border-color: var(--primary);
            transform: scale(1.05);
        }

        .pricing-card.featured.visible {
            transform: scale(1.05);
        }

        .pricing-card:hover {
            border-color: var(--primary);
        }

        .pricing-badge {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary);
            color: var(--foreground);
            padding: 8px 24px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .pricing-card h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .pricing-card .price {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 4rem;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 5px;
        }

        .pricing-card .price span {
            font-size: 1.2rem;
            color: var(--foreground-muted);
        }

        .pricing-card .period {
            color: var(--foreground-muted);
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .pricing-features {
            list-style: none;
            margin-bottom: 40px;
        }

        .pricing-features li {
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
            color: var(--foreground-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .pricing-features li:last-child {
            border-bottom: none;
        }

        .pricing-features svg {
            width: 18px;
            height: 18px;
            fill: var(--primary);
        }

        .pricing-btn {
            width: 100%;
            padding: 16px;
            border-radius: 4px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }

        .pricing-btn.primary {
            background: var(--primary);
            color: var(--foreground);
            border: 2px solid var(--primary);
        }

        .pricing-btn.primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .pricing-btn.secondary {
            background: transparent;
            color: var(--foreground);
            border: 2px solid var(--border);
        }

        .pricing-btn.secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        /* Testimonials */
        .testimonials {
            padding: 120px 5%;
            background: var(--background-alt);
        }

        .testimonials-container {
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
        }

        .testimonial-slider {
            overflow: hidden;
        }

        .testimonial-track {
            display: flex;
            transition: transform 0.5s ease;
        }

        .testimonial-item {
            min-width: 100%;
            padding: 0 20px;
            text-align: center;
        }

        .testimonial-quote {
            font-size: clamp(1.3rem, 3vw, 1.8rem);
            line-height: 1.6;
            color: var(--foreground);
            margin-bottom: 40px;
            font-style: italic;
        }

        .testimonial-quote::before {
            content: '"';
            font-family: 'Bebas Neue', sans-serif;
            font-size: 5rem;
            color: var(--primary);
            display: block;
            line-height: 0.5;
            margin-bottom: 20px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 16px;
        }

        .testimonial-author img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
        }

        .testimonial-author-info h4 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.3rem;
            letter-spacing: 1px;
        }

        .testimonial-author-info span {
            color: var(--foreground-muted);
            font-size: 0.9rem;
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
            border-radius: 50%;
            background: var(--border);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .testimonial-dot.active {
            background: var(--primary);
            transform: scale(1.2);
        }

        /* CTA Section */
        .cta {
            padding: 150px 5%;
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta::before {
            content: 'APEX';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(15rem, 30vw, 30rem);
            color: rgba(255, 255, 255, 0.05);
            white-space: nowrap;
            pointer-events: none;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(3rem, 8vw, 5rem);
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .cta p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 40px;
        }

        .cta-btn {
            background: var(--foreground);
            color: var(--primary);
            padding: 20px 50px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
        }

        /* Footer */
        footer {
            background: var(--background);
            padding: 80px 5% 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            max-width: 1400px;
            margin: 0 auto 60px;
        }

        .footer-brand .logo {
            margin-bottom: 20px;
        }

        .footer-brand p {
            color: var(--foreground-muted);
            font-size: 0.95rem;
            margin-bottom: 24px;
        }

        .footer-socials {
            display: flex;
            gap: 12px;
        }

        .footer-socials a {
            width: 44px;
            height: 44px;
            background: var(--card);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .footer-socials a:hover {
            background: var(--primary);
            transform: translateY(-3px);
        }

        .footer-socials svg {
            width: 18px;
            height: 18px;
            fill: var(--foreground);
        }

        .footer-column h4 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.3rem;
            letter-spacing: 2px;
            margin-bottom: 24px;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 12px;
        }

        .footer-column a {
            color: var(--foreground-muted);
            text-decoration: none;
            font-size: 0.95rem;
            transition: color 0.3s ease;
        }

        .footer-column a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            border-top: 1px solid var(--border);
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-bottom p {
            color: var(--foreground-muted);
            font-size: 0.9rem;
        }

        .footer-links {
            display: flex;
            gap: 30px;
        }

        .footer-links a {
            color: var(--foreground-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .programs-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .trainers-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            .hero-bg {
                width: 100%;
            }

            .hero-bg::before {
                background: linear-gradient(90deg, var(--background) 0%, rgba(10, 10, 10, 0.8) 100%);
            }

            .hero-stats {
                gap: 30px;
            }

            .pricing-grid {
                grid-template-columns: 1fr;
                max-width: 450px;
            }

            .pricing-card.featured {
                transform: none;
            }

            .pricing-card.featured.visible {
                transform: none;
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 3.5rem;
            }

            .hero-stats {
                flex-direction: column;
                gap: 20px;
            }

            .programs-grid,
            .trainers-grid {
                grid-template-columns: 1fr;
            }

            .trainer-image {
                height: 350px;
            }

            .trainer-overlay {
                transform: translateY(0);
            }

            .trainer-socials {
                opacity: 1;
                transform: translateY(0);
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero-buttons {
                flex-direction: column;
            }

            .btn-primary,
            .btn-outline {
                width: 100%;
                justify-content: center;
            }
        }

        /* Scroll Animations */
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
    <div class="loader">
        <div class="loader-content">
            <div class="loader-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29z"/>
                </svg>
            </div>
            <div class="loader-bar">
                <div class="loader-progress"></div>
            </div>
            <div class="loader-text">Loading Power</div>
        </div>
    </div>

    <!-- Navigation -->
    <nav>
        <a href="#" class="logo">APEX<span>FITNESS</span></a>
        <ul class="nav-links">
            <li><a href="#programs">Programs</a></li>
            <li><a href="#trainers">Trainers</a></li>
            <li><a href="#pricing">Pricing</a></li>
            <li><a href="#testimonials">Results</a></li>
        </ul>
        <a href="#pricing" class="join-btn">Join Now</a>
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <div class="hero-tag">No Limits. No Excuses.</div>
            <h1>PUSH YOUR<span>LIMITS</span></h1>
            <p>Transform your body and mind with world-class training, cutting-edge equipment, and a community that pushes you to be your best every single day.</p>
            <div class="hero-buttons">
                <a href="#pricing" class="btn-primary">
                    Start Free Trial
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M13.025 1l-2.847 2.828 6.176 6.176h-16.354v3.992h16.354l-6.176 6.176 2.847 2.828 10.975-11z"/></svg>
                </a>
                <a href="#programs" class="btn-outline">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2c5.514 0 10 4.486 10 10s-4.486 10-10 10-10-4.486-10-10 4.486-10 10-10zm0-2c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-3 17v-10l9 5.146-9 4.854z"/></svg>
                    View Programs
                </a>
            </div>
            <div class="hero-stats">
                <div class="hero-stat">
                    <strong>15K+</strong>
                    <span>Active Members</span>
                </div>
                <div class="hero-stat">
                    <strong>50+</strong>
                    <span>Expert Trainers</span>
                </div>
                <div class="hero-stat">
                    <strong>98%</strong>
                    <span>Success Rate</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Marquee -->
    <div class="marquee-section">
        <div class="marquee-track">
            <div class="marquee-content">
                <span class="marquee-item">Strength Training</span>
                <span class="marquee-item">HIIT Classes</span>
                <span class="marquee-item">Personal Coaching</span>
                <span class="marquee-item">Nutrition Plans</span>
                <span class="marquee-item">Recovery Zone</span>
                <span class="marquee-item">Group Fitness</span>
            </div>
            <div class="marquee-content">
                <span class="marquee-item">Strength Training</span>
                <span class="marquee-item">HIIT Classes</span>
                <span class="marquee-item">Personal Coaching</span>
                <span class="marquee-item">Nutrition Plans</span>
                <span class="marquee-item">Recovery Zone</span>
                <span class="marquee-item">Group Fitness</span>
            </div>
        </div>
    </div>

    <!-- Programs Section -->
    <section class="programs" id="programs">
        <div class="section-header reveal">
            <span class="section-tag">What We Offer</span>
            <h2>Training Programs</h2>
            <p>From high-intensity workouts to mindful recovery, we have everything you need to achieve your fitness goals.</p>
        </div>
        <div class="programs-grid">
            <div class="program-card">
                <div class="program-content">
                    <div class="program-icon">
                        <svg viewBox="0 0 24 24"><path d="M20.57 14.86L22 13.43 20.57 12 17 15.57 8.43 7 12 3.43 10.57 2 9.14 3.43 7.71 2 5.57 4.14 4.14 2.71 2.71 4.14l1.43 1.43L2 7.71l1.43 1.43L2 10.57 3.43 12 7 8.43 15.57 17 12 20.57 13.43 22l1.43-1.43L16.29 22l2.14-2.14 1.43 1.43 1.43-1.43-1.43-1.43L22 16.29z"/></svg>
                    </div>
                    <h3>Strength & Power</h3>
                    <p>Build muscle and increase strength with our comprehensive weight training programs.</p>
                    <a href="#" class="program-link">Learn More →</a>
                </div>
            </div>
            <div class="program-card">
                <div class="program-content">
                    <div class="program-icon">
                        <svg viewBox="0 0 24 24"><path d="M13.5.67s.74 2.65.74 4.8c0 2.06-1.35 3.73-3.41 3.73-2.07 0-3.63-1.67-3.63-3.73l.03-.36C5.21 7.51 4 10.62 4 14c0 4.42 3.58 8 8 8s8-3.58 8-8C20 8.61 17.41 3.8 13.5.67zM11.71 19c-1.78 0-3.22-1.4-3.22-3.14 0-1.62 1.05-2.76 2.81-3.12 1.77-.36 3.6-1.21 4.62-2.58.39 1.29.59 2.65.59 4.04 0 2.65-2.15 4.8-4.8 4.8z"/></svg>
                    </div>
                    <h3>HIIT Cardio</h3>
                    <p>Burn calories and boost endurance with high-intensity interval training sessions.</p>
                    <a href="#" class="program-link">Learn More →</a>
                </div>
            </div>
            <div class="program-card">
                <div class="program-content">
                    <div class="program-icon">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
                    </div>
                    <h3>Yoga & Mobility</h3>
                    <p>Improve flexibility and mental clarity with guided yoga and stretching classes.</p>
                    <a href="#" class="program-link">Learn More →</a>
                </div>
            </div>
            <div class="program-card">
                <div class="program-content">
                    <div class="program-icon">
                        <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
                    </div>
                    <h3>Nutrition Coaching</h3>
                    <p>Get personalized meal plans and nutrition guidance for optimal results.</p>
                    <a href="#" class="program-link">Learn More →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Trainers Section -->
    <section class="trainers" id="trainers">
        <div class="section-header reveal">
            <span class="section-tag">Meet The Team</span>
            <h2>Expert Trainers</h2>
            <p>Our certified professionals are here to guide you every step of the way.</p>
        </div>
        <div class="trainers-grid">
            <div class="trainer-card">
                <div class="trainer-image"></div>
                <div class="trainer-overlay">
                    <h3>Marcus Johnson</h3>
                    <p class="role">Strength Coach</p>
                    <div class="trainer-socials">
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    </div>
                </div>
            </div>
            <div class="trainer-card">
                <div class="trainer-image"></div>
                <div class="trainer-overlay">
                    <h3>Sarah Williams</h3>
                    <p class="role">HIIT Specialist</p>
                    <div class="trainer-socials">
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    </div>
                </div>
            </div>
            <div class="trainer-card">
                <div class="trainer-image"></div>
                <div class="trainer-overlay">
                    <h3>David Chen</h3>
                    <p class="role">Yoga Instructor</p>
                    <div class="trainer-socials">
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    </div>
                </div>
            </div>
            <div class="trainer-card">
                <div class="trainer-image"></div>
                <div class="trainer-overlay">
                    <h3>Emma Rodriguez</h3>
                    <p class="role">Nutrition Expert</p>
                    <div class="trainer-socials">
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="pricing" id="pricing">
        <div class="section-header reveal">
            <span class="section-tag">Membership Plans</span>
            <h2>Choose Your Plan</h2>
            <p>Flexible options to fit your lifestyle and fitness goals.</p>
        </div>
        <div class="pricing-grid">
            <div class="pricing-card">
                <h3>Starter</h3>
                <div class="price">$29<span>/mo</span></div>
                <p class="period">Billed monthly</p>
                <ul class="pricing-features">
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Gym Access</li>
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Basic Equipment</li>
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Locker Room</li>
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Fitness App</li>
                </ul>
                <a href="#" class="pricing-btn secondary">Get Started</a>
            </div>
            <div class="pricing-card featured">
                <span class="pricing-badge">Most Popular</span>
                <h3>Pro</h3>
                <div class="price">$59<span>/mo</span></div>
                <p class="period">Billed monthly</p>
                <ul class="pricing-features">
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> All Starter Features</li>
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Group Classes</li>
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Nutrition Guide</li>
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Sauna & Steam</li>
                </ul>
                <a href="#" class="pricing-btn primary">Get Started</a>
            </div>
            <div class="pricing-card">
                <h3>Elite</h3>
                <div class="price">$99<span>/mo</span></div>
                <p class="period">Billed monthly</p>
                <ul class="pricing-features">
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> All Pro Features</li>
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Personal Trainer</li>
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> Custom Meal Plans</li>
                    <li><svg viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg> 24/7 Access</li>
                </ul>
                <a href="#" class="pricing-btn secondary">Get Started</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="section-header reveal">
            <span class="section-tag">Success Stories</span>
            <h2>Real Results</h2>
            <p>Hear from our members who transformed their lives.</p>
        </div>
        <div class="testimonials-container">
            <div class="testimonial-slider">
                <div class="testimonial-track">
                    <div class="testimonial-item">
                        <p class="testimonial-quote">APEX completely changed my life. I lost 40 pounds in 6 months and gained confidence I never knew I had. The trainers are incredible and the community keeps you motivated every single day.</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150" alt="Michael T.">
                            <div class="testimonial-author-info">
                                <h4>Michael Thompson</h4>
                                <span>Lost 40 lbs in 6 months</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <p class="testimonial-quote">The personalized training programs and nutrition coaching helped me achieve goals I thought were impossible. Best investment I've ever made in myself.</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150" alt="Jessica M.">
                            <div class="testimonial-author-info">
                                <h4>Jessica Martinez</h4>
                                <span>Gained 15 lbs muscle</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <p class="testimonial-quote">From struggling to do a single push-up to completing my first marathon. APEX gave me the tools, support, and belief to become my best self.</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=150" alt="Robert K.">
                            <div class="testimonial-author-info">
                                <h4>Robert Kim</h4>
                                <span>Completed first marathon</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-dots">
                <span class="testimonial-dot active" data-index="0"></span>
                <span class="testimonial-dot" data-index="1"></span>
                <span class="testimonial-dot" data-index="2"></span>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-content reveal">
            <h2>Ready to Transform?</h2>
            <p>Join thousands who've already started their journey. Your first week is on us.</p>
            <a href="#pricing" class="cta-btn">
                Start Free Trial
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M13.025 1l-2.847 2.828 6.176 6.176h-16.354v3.992h16.354l-6.176 6.176 2.847 2.828 10.975-11z"/></svg>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="#" class="logo">APEX<span>FITNESS</span></a>
                <p>Transform your body, transform your life. Join the movement and become the best version of yourself.</p>
                <div class="footer-socials">
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg></a>
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg></a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Programs</h4>
                <ul>
                    <li><a href="#">Strength Training</a></li>
                    <li><a href="#">HIIT Classes</a></li>
                    <li><a href="#">Yoga & Mobility</a></li>
                    <li><a href="#">Nutrition Coaching</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Company</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Membership</a></li>
                    <li><a href="#">Locations</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 APEX Fitness. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Use</a>
                <a href="#">Cookie Policy</a>
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

        // Navigation scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Scroll reveal animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe reveal elements
        document.querySelectorAll('.reveal, .program-card, .trainer-card, .pricing-card').forEach(el => {
            observer.observe(el);
        });

        // Testimonial slider
        const testimonialTrack = document.querySelector('.testimonial-track');
        const testimonialDots = document.querySelectorAll('.testimonial-dot');
        let currentSlide = 0;

        function goToSlide(index) {
            currentSlide = index;
            testimonialTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
            testimonialDots.forEach((dot, i) => {
                dot.classList.toggle('active', i === currentSlide);
            });
        }

        testimonialDots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });

        // Auto-slide testimonials
        setInterval(() => {
            currentSlide = (currentSlide + 1) % 3;
            goToSlide(currentSlide);
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
    </script>
</body>
</html>
