<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ELYSIAN | Luxury Resort & Spa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Raleway:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1B3A4B;
            --primary-light: #2D5A6B;
            --accent: #C9A962;
            --accent-dark: #A68B4B;
            --background: #FAF8F5;
            --background-alt: #F0EDE8;
            --foreground: #1A1A1A;
            --foreground-muted: #6B6B6B;
            --card: #FFFFFF;
            --border: #E5E0D8;
            --radius: 0px;
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
            font-family: 'Raleway', sans-serif;
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

        .loader-wave {
            position: absolute;
            inset: 0;
            border: 1px solid rgba(201, 169, 98, 0.3);
            border-radius: 50%;
            animation: wave 2s ease-out infinite;
        }

        .loader-wave:nth-child(2) {
            animation-delay: 0.4s;
        }

        .loader-wave:nth-child(3) {
            animation-delay: 0.8s;
        }

        @keyframes wave {
            0% {
                transform: scale(0.5);
                opacity: 1;
            }
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .loader-center {
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
        }

        .loader-center svg {
            width: 30px;
            height: 30px;
            fill: var(--primary);
        }

        .loader-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--background);
            letter-spacing: 8px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .loader-sub {
            font-size: 0.75rem;
            color: var(--accent);
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        /* Navigation */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 30px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            transition: all 0.4s ease;
        }

        nav.scrolled {
            background: rgba(250, 248, 245, 0.98);
            backdrop-filter: blur(20px);
            padding: 20px 5%;
            box-shadow: 0 2px 30px rgba(0, 0, 0, 0.05);
        }

        nav.scrolled .logo,
        nav.scrolled .nav-links a {
            color: var(--foreground);
        }

        nav.scrolled .book-btn {
            background: var(--primary);
            color: var(--background);
            border-color: var(--primary);
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 500;
            color: var(--background);
            text-decoration: none;
            letter-spacing: 4px;
        }

        .logo span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 50px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 0.75rem;
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
            height: 1px;
            background: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .book-btn {
            background: transparent;
            color: var(--background);
            padding: 14px 35px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.4s ease;
        }

        .book-btn:hover {
            background: var(--accent);
            color: var(--primary);
            border-color: var(--accent);
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
            background: var(--background);
            transition: all 0.3s ease;
        }

        nav.scrolled .menu-toggle span {
            background: var(--foreground);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1600') center/cover;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(27, 58, 75, 0.5) 0%, rgba(27, 58, 75, 0.7) 100%);
        }

        .hero-content {
            text-align: center;
            position: relative;
            z-index: 2;
            max-width: 1000px;
            padding: 0 20px;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 6px;
            margin-bottom: 30px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 1s ease 0.3s forwards;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 9vw, 6.5rem);
            font-weight: 400;
            line-height: 1.1;
            margin-bottom: 30px;
            color: var(--background);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s ease 0.5s forwards;
        }

        .hero h1 em {
            font-style: italic;
        }

        .hero p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 50px;
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.9;
            letter-spacing: 0.5px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s ease 0.7s forwards;
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s ease 0.9s forwards;
        }

        .btn-primary {
            background: var(--accent);
            color: var(--primary);
            padding: 18px 50px;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.75rem;
            transition: all 0.4s ease;
        }

        .btn-primary:hover {
            background: var(--accent-dark);
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(201, 169, 98, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--background);
            padding: 18px 50px;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.75rem;
            border: 1px solid rgba(255, 255, 255, 0.5);
            transition: all 0.4s ease;
        }

        .btn-outline:hover {
            background: var(--background);
            color: var(--primary);
        }

        .scroll-indicator {
            position: absolute;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            opacity: 0;
            animation: fadeUp 1s ease 1.2s forwards;
        }

        .scroll-indicator span {
            font-size: 0.7rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.7);
        }

        .scroll-mouse {
            width: 26px;
            height: 42px;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 15px;
            position: relative;
        }

        .scroll-mouse::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 4px;
            height: 8px;
            background: var(--accent);
            border-radius: 2px;
            animation: scrollMouse 1.5s ease-in-out infinite;
        }

        @keyframes scrollMouse {
            0%, 100% { opacity: 1; top: 8px; }
            50% { opacity: 0.3; top: 20px; }
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stats Bar */
        .stats-bar {
            background: var(--primary);
            padding: 60px 5%;
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
            text-align: center;
        }

        .stat-item {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }

        .stat-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 400;
            color: var(--accent);
            line-height: 1;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: rgba(255, 255, 255, 0.7);
        }

        /* About Section */
        .about {
            padding: 150px 5%;
            background: var(--background);
        }

        .about-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 100px;
            align-items: center;
        }

        .about-images {
            position: relative;
            height: 650px;
        }

        .about-img-main {
            width: 75%;
            height: 500px;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease;
        }

        .about-img-secondary {
            width: 55%;
            height: 350px;
            object-fit: cover;
            position: absolute;
            bottom: 0;
            right: 0;
            border: 8px solid var(--background);
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s ease 0.2s;
        }

        .about-images.visible .about-img-main,
        .about-images.visible .about-img-secondary {
            opacity: 1;
            transform: translateX(0);
        }

        .about-badge {
            position: absolute;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 120px;
            background: var(--accent);
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .about-badge span:first-child {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--primary);
            line-height: 1;
        }

        .about-badge span:last-child {
            font-size: 0.6rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary);
        }

        .about-content {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s ease 0.3s;
        }

        .about-content.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            color: var(--accent);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 25px;
        }

        .section-tag::before {
            content: '';
            width: 50px;
            height: 2px;
            background: var(--accent);
        }

        .about-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            font-weight: 400;
            margin-bottom: 30px;
            line-height: 1.25;
            color: var(--primary);
        }

        .about-content h2 em {
            font-style: italic;
        }

        .about-content p {
            color: var(--foreground-muted);
            margin-bottom: 25px;
            line-height: 1.9;
            font-size: 1.05rem;
        }

        .about-features {
            display: flex;
            gap: 50px;
            margin-top: 40px;
        }

        .about-feature {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .about-feature-icon {
            width: 55px;
            height: 55px;
            background: var(--background-alt);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .about-feature-icon svg {
            width: 26px;
            height: 26px;
            stroke: var(--primary);
            fill: none;
        }

        .about-feature span {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary);
        }

        /* Rooms Section */
        .rooms {
            padding: 150px 5%;
            background: var(--background-alt);
        }

        .rooms-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 80px;
        }

        .rooms-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            font-weight: 400;
            margin-bottom: 20px;
            color: var(--primary);
        }

        .rooms-header h2 em {
            font-style: italic;
        }

        .rooms-header p {
            color: var(--foreground-muted);
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .rooms-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .room-card {
            background: var(--card);
            overflow: hidden;
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.6s ease;
        }

        .room-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .room-card:hover {
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
        }

        .room-image {
            height: 300px;
            overflow: hidden;
            position: relative;
        }

        .room-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .room-card:hover .room-image img {
            transform: scale(1.08);
        }

        .room-tag {
            position: absolute;
            top: 20px;
            left: 20px;
            background: var(--accent);
            color: var(--primary);
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 8px 15px;
        }

        .room-content {
            padding: 35px;
        }

        .room-content h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 500;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .room-content p {
            color: var(--foreground-muted);
            font-size: 0.95rem;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .room-amenities {
            display: flex;
            gap: 25px;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid var(--border);
        }

        .room-amenity {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--foreground-muted);
        }

        .room-amenity svg {
            width: 18px;
            height: 18px;
            stroke: var(--primary);
            fill: none;
        }

        .room-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .room-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            color: var(--primary);
        }

        .room-price span {
            font-family: 'Raleway', sans-serif;
            font-size: 0.8rem;
            color: var(--foreground-muted);
        }

        .room-btn {
            background: var(--primary);
            color: var(--background);
            padding: 12px 25px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .room-btn:hover {
            background: var(--accent);
            color: var(--primary);
        }

        /* Amenities Section */
        .amenities {
            padding: 150px 5%;
            background: var(--background);
        }

        .amenities-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .amenities-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 80px;
        }

        .amenities-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            font-weight: 400;
            margin-bottom: 20px;
            color: var(--primary);
        }

        .amenities-header h2 em {
            font-style: italic;
        }

        .amenities-header p {
            color: var(--foreground-muted);
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .amenities-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
        }

        .amenity-card {
            text-align: center;
            padding: 50px 30px;
            background: var(--background-alt);
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.5s ease;
        }

        .amenity-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .amenity-card:hover {
            background: var(--primary);
        }

        .amenity-card:hover .amenity-icon {
            background: var(--accent);
        }

        .amenity-card:hover .amenity-icon svg {
            stroke: var(--primary);
        }

        .amenity-card:hover h4,
        .amenity-card:hover p {
            color: var(--background);
        }

        .amenity-icon {
            width: 80px;
            height: 80px;
            background: var(--card);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            transition: all 0.4s ease;
        }

        .amenity-icon svg {
            width: 35px;
            height: 35px;
            stroke: var(--primary);
            fill: none;
            transition: stroke 0.4s ease;
        }

        .amenity-card h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            margin-bottom: 12px;
            color: var(--primary);
            transition: color 0.4s ease;
        }

        .amenity-card p {
            font-size: 0.9rem;
            color: var(--foreground-muted);
            line-height: 1.6;
            transition: color 0.4s ease;
        }

        /* Gallery Section */
        .gallery {
            padding: 100px 0;
            background: var(--primary);
            overflow: hidden;
        }

        .gallery-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 60px;
            padding: 0 5%;
        }

        .gallery-header .section-tag {
            color: var(--accent);
        }

        .gallery-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            font-weight: 400;
            color: var(--background);
        }

        .gallery-header h2 em {
            font-style: italic;
        }

        .gallery-track {
            display: flex;
            gap: 20px;
            animation: galleryScroll 40s linear infinite;
        }

        .gallery-track:hover {
            animation-play-state: paused;
        }

        @keyframes galleryScroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .gallery-item {
            flex-shrink: 0;
            width: 400px;
            height: 300px;
            overflow: hidden;
            position: relative;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(27, 58, 75, 0.9) 100%);
            display: flex;
            align-items: flex-end;
            padding: 25px;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        .gallery-overlay span {
            color: var(--background);
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-style: italic;
        }

        /* Testimonials */
        .testimonials {
            padding: 150px 5%;
            background: var(--background-alt);
        }

        .testimonials-container {
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }

        .testimonials-header {
            margin-bottom: 60px;
        }

        .testimonials-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            font-weight: 400;
            color: var(--primary);
        }

        .testimonials-header h2 em {
            font-style: italic;
        }

        .testimonial-slider {
            position: relative;
            overflow: hidden;
        }

        .testimonial-track {
            display: flex;
            transition: transform 0.6s ease;
        }

        .testimonial-item {
            flex-shrink: 0;
            width: 100%;
            padding: 0 20px;
        }

        .testimonial-stars {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 30px;
        }

        .testimonial-stars svg {
            width: 22px;
            height: 22px;
            fill: var(--accent);
        }

        .testimonial-quote {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.4rem, 3vw, 2rem);
            font-style: italic;
            color: var(--primary);
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .testimonial-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
        }

        .testimonial-info h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .testimonial-info span {
            font-size: 0.8rem;
            color: var(--foreground-muted);
            letter-spacing: 1px;
        }

        .testimonial-dots {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 50px;
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
            background: var(--accent);
            transform: scale(1.2);
        }

        /* Booking Section */
        .booking {
            padding: 150px 5%;
            background: var(--background);
            position: relative;
        }

        .booking::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 45%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1582719508461-905c673771fd?w=1200') center/cover;
        }

        .booking-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 100px;
            align-items: center;
        }

        .booking-content {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease;
        }

        .booking-content.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .booking-content h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 4vw, 3.5rem);
            font-weight: 400;
            margin-bottom: 25px;
            color: var(--primary);
            line-height: 1.2;
        }

        .booking-content h2 em {
            font-style: italic;
        }

        .booking-content > p {
            color: var(--foreground-muted);
            margin-bottom: 40px;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        .booking-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--primary);
        }

        .form-group input,
        .form-group select {
            padding: 16px 20px;
            border: 1px solid var(--border);
            background: var(--background);
            font-family: 'Raleway', sans-serif;
            font-size: 0.95rem;
            color: var(--foreground);
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--accent);
        }

        .form-group input::placeholder {
            color: var(--foreground-muted);
        }

        .booking-submit {
            grid-column: span 2;
            background: var(--primary);
            color: var(--background);
            padding: 18px 45px;
            border: none;
            font-family: 'Raleway', sans-serif;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.4s ease;
            margin-top: 10px;
        }

        .booking-submit:hover {
            background: var(--accent);
            color: var(--primary);
        }

        /* Footer */
        footer {
            background: var(--primary);
            padding: 100px 5% 40px;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 80px;
        }

        .footer-brand .logo {
            color: var(--background);
            margin-bottom: 25px;
            display: inline-block;
        }

        .footer-brand p {
            color: rgba(255, 255, 255, 0.7);
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
            border: 1px solid rgba(255, 255, 255, 0.2);
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
            fill: var(--background);
        }

        .footer-column h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            color: var(--background);
            margin-bottom: 30px;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column li {
            margin-bottom: 15px;
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

        .footer-contact li {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .footer-contact svg {
            width: 20px;
            height: 20px;
            stroke: var(--accent);
            fill: none;
            flex-shrink: 0;
            margin-top: 3px;
        }

        .footer-contact span {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .footer-bottom {
            padding-top: 40px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-bottom p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.85rem;
        }

        .footer-links {
            display: flex;
            gap: 30px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.5);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--accent);
        }

        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100%;
            background: var(--primary);
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: right 0.5s ease;
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu-links {
            list-style: none;
            text-align: center;
        }

        .mobile-menu-links li {
            margin: 25px 0;
        }

        .mobile-menu-links a {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: var(--background);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .mobile-menu-links a:hover {
            color: var(--accent);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .rooms-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .amenities-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-top {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }

            .book-btn {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            .about-container {
                grid-template-columns: 1fr;
                gap: 60px;
            }

            .about-images {
                height: 500px;
            }

            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .booking::before {
                display: none;
            }

            .booking-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .rooms-grid {
                grid-template-columns: 1fr;
            }

            .amenities-grid {
                grid-template-columns: 1fr;
            }

            .about-features {
                flex-direction: column;
                gap: 25px;
            }

            .booking-form {
                grid-template-columns: 1fr;
            }

            .form-group.full-width {
                grid-column: span 1;
            }

            .booking-submit {
                grid-column: span 1;
            }

            .footer-top {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .gallery-item {
                width: 300px;
                height: 220px;
            }
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .about-images {
                height: 400px;
            }

            .about-img-main {
                width: 90%;
                height: 350px;
            }

            .about-img-secondary {
                width: 60%;
                height: 200px;
            }

            .about-badge {
                width: 90px;
                height: 90px;
            }

            .about-badge span:first-child {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div class="loader" id="loader">
        <div class="loader-content">
            <div class="loader-icon">
                <div class="loader-wave"></div>
                <div class="loader-wave"></div>
                <div class="loader-wave"></div>
                <div class="loader-center">
                    <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>
            </div>
            <div class="loader-text">Elysian</div>
            <div class="loader-sub">Luxury Resort & Spa</div>
        </div>
    </div>

    <!-- Navigation -->
    <nav id="navbar">
        <a href="#" class="logo">ELYSIAN</a>
        <ul class="nav-links">
            <li><a href="#about">About</a></li>
            <li><a href="#rooms">Rooms</a></li>
            <li><a href="#amenities">Amenities</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#testimonials">Reviews</a></li>
        </ul>
        <a href="#booking" class="book-btn">Book Now</a>
        <div class="menu-toggle" id="menuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul class="mobile-menu-links">
            <li><a href="#about">About</a></li>
            <li><a href="#rooms">Rooms</a></li>
            <li><a href="#amenities">Amenities</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#testimonials">Reviews</a></li>
            <li><a href="#booking">Book Now</a></li>
        </ul>
    </div>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <div class="hero-tag">Welcome to Paradise</div>
            <h1>Where Luxury Meets <em>Serenity</em></h1>
            <p>Escape to an oasis of refined elegance, where every moment is crafted to perfection and every detail speaks of timeless sophistication.</p>
            <div class="hero-buttons">
                <a href="#booking" class="btn-primary">Reserve Your Stay</a>
                <a href="#rooms" class="btn-outline">Explore Rooms</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-mouse"></div>
        </div>
    </section>

    <!-- Stats Bar -->
    <section class="stats-bar">
        <div class="stats-container">
            <div class="stat-item">
                <div class="stat-number" data-target="25">0</div>
                <div class="stat-label">Years of Excellence</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="150">0</div>
                <div class="stat-label">Luxury Suites</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="50">0</div>
                <div class="stat-label">World Awards</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-target="98">0</div>
                <div class="stat-label">Guest Satisfaction %</div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="about-container">
            <div class="about-images">
                <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800" alt="Hotel Lobby" class="about-img-main">
                <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?w=800" alt="Pool View" class="about-img-secondary">
                <div class="about-badge">
                    <span>5</span>
                    <span>Star Hotel</span>
                </div>
            </div>
            <div class="about-content">
                <div class="section-tag">Our Story</div>
                <h2>A Legacy of <em>Unparalleled</em> Hospitality</h2>
                <p>Nestled along pristine shores, Elysian Resort & Spa offers an extraordinary retreat where world-class amenities blend seamlessly with natural beauty.</p>
                <p>For over two decades, we have been crafting unforgettable experiences for discerning travelers seeking the perfect balance of luxury, comfort, and authentic hospitality.</p>
                <div class="about-features">
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <span>Best Price Guarantee</span>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <span>Safe & Secure</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rooms Section -->
    <section class="rooms" id="rooms">
        <div class="rooms-header">
            <div class="section-tag">Accommodations</div>
            <h2>Exquisite <em>Rooms & Suites</em></h2>
            <p>Each of our elegantly appointed rooms and suites offers a sanctuary of comfort with breathtaking views and world-class amenities.</p>
        </div>
        <div class="rooms-grid">
            <div class="room-card">
                <div class="room-image">
                    <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=800" alt="Deluxe Room">
                    <span class="room-tag">Popular</span>
                </div>
                <div class="room-content">
                    <h3>Deluxe Ocean View</h3>
                    <p>Spacious rooms featuring panoramic ocean views, king-size beds, and private balconies.</p>
                    <div class="room-amenities">
                        <div class="room-amenity">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            45 m²
                        </div>
                        <div class="room-amenity">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            2 Guests
                        </div>
                        <div class="room-amenity">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M2 12h20M2 12a10 10 0 0 1 20 0M2 12a10 10 0 0 0 20 0"/></svg>
                            Ocean View
                        </div>
                    </div>
                    <div class="room-footer">
                        <div class="room-price">$450 <span>/ night</span></div>
                        <a href="#booking" class="room-btn">Book Now</a>
                    </div>
                </div>
            </div>
            <div class="room-card">
                <div class="room-image">
                    <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800" alt="Premium Suite">
                    <span class="room-tag">Exclusive</span>
                </div>
                <div class="room-content">
                    <h3>Premium Garden Suite</h3>
                    <p>Elegant suites surrounded by lush tropical gardens with private terrace and plunge pool.</p>
                    <div class="room-amenities">
                        <div class="room-amenity">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            65 m²
                        </div>
                        <div class="room-amenity">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            3 Guests
                        </div>
                        <div class="room-amenity">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/></svg>
                            Pool Access
                        </div>
                    </div>
                    <div class="room-footer">
                        <div class="room-price">$680 <span>/ night</span></div>
                        <a href="#booking" class="room-btn">Book Now</a>
                    </div>
                </div>
            </div>
            <div class="room-card">
                <div class="room-image">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800" alt="Royal Villa">
                    <span class="room-tag">Signature</span>
                </div>
                <div class="room-content">
                    <h3>Royal Presidential Villa</h3>
                    <p>Ultimate luxury with private infinity pool, butler service, and breathtaking sunset views.</p>
                    <div class="room-amenities">
                        <div class="room-amenity">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            150 m²
                        </div>
                        <div class="room-amenity">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                            4 Guests
                        </div>
                        <div class="room-amenity">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            Butler
                        </div>
                    </div>
                    <div class="room-footer">
                        <div class="room-price">$1,200 <span>/ night</span></div>
                        <a href="#booking" class="room-btn">Book Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Amenities Section -->
    <section class="amenities" id="amenities">
        <div class="amenities-container">
            <div class="amenities-header">
                <div class="section-tag">Resort Features</div>
                <h2>World-Class <em>Amenities</em></h2>
                <p>Indulge in an array of exceptional facilities designed to enhance every moment of your stay.</p>
            </div>
            <div class="amenities-grid">
                <div class="amenity-card">
                    <div class="amenity-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    </div>
                    <h4>Wellness Spa</h4>
                    <p>Rejuvenate with holistic treatments and therapies in our award-winning spa sanctuary.</p>
                </div>
                <div class="amenity-card">
                    <div class="amenity-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="M8 14s1.5 2 4 2 4-2 4-2M2 12h2m16 0h2"/></svg>
                    </div>
                    <h4>Infinity Pools</h4>
                    <p>Three stunning pools with ocean views and dedicated poolside service.</p>
                </div>
                <div class="amenity-card">
                    <div class="amenity-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M18 8h1a4 4 0 0 1 0 8h-1M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                    </div>
                    <h4>Fine Dining</h4>
                    <p>Five exceptional restaurants offering cuisines from around the world.</p>
                </div>
                <div class="amenity-card">
                    <div class="amenity-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                    </div>
                    <h4>Private Beach</h4>
                    <p>Exclusive beachfront access with luxury cabanas and water sports.</p>
                </div>
                <div class="amenity-card">
                    <div class="amenity-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"/><line x1="16" y1="8" x2="2" y2="22"/><line x1="17.5" y1="15" x2="9" y2="15"/></svg>
                    </div>
                    <h4>Kids Club</h4>
                    <p>Supervised activities and entertainment for our younger guests.</p>
                </div>
                <div class="amenity-card">
                    <div class="amenity-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/><line x1="4" y1="22" x2="4" y2="15"/></svg>
                    </div>
                    <h4>Golf Course</h4>
                    <p>Championship 18-hole course with stunning coastal landscapes.</p>
                </div>
                <div class="amenity-card">
                    <div class="amenity-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                    </div>
                    <h4>Fitness Center</h4>
                    <p>State-of-the-art gym with personal trainers and yoga classes.</p>
                </div>
                <div class="amenity-card">
                    <div class="amenity-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                    </div>
                    <h4>Concierge</h4>
                    <p>24/7 dedicated service to fulfill your every request and desire.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery" id="gallery">
        <div class="gallery-header">
            <div class="section-tag">Visual Journey</div>
            <h2>Discover <em>Elysian</em></h2>
        </div>
        <div class="gallery-track">
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800" alt="Resort Exterior">
                <div class="gallery-overlay"><span>Resort Exterior</span></div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?w=800" alt="Infinity Pool">
                <div class="gallery-overlay"><span>Infinity Pool</span></div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=800" alt="Spa Treatment">
                <div class="gallery-overlay"><span>Spa Sanctuary</span></div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800" alt="Beach View">
                <div class="gallery-overlay"><span>Private Beach</span></div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800" alt="Restaurant">
                <div class="gallery-overlay"><span>Fine Dining</span></div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1584132967334-10e028bd69f7?w=800" alt="Suite Interior">
                <div class="gallery-overlay"><span>Luxury Suite</span></div>
            </div>
            <!-- Duplicate for infinite scroll -->
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800" alt="Resort Exterior">
                <div class="gallery-overlay"><span>Resort Exterior</span></div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1540541338287-41700207dee6?w=800" alt="Infinity Pool">
                <div class="gallery-overlay"><span>Infinity Pool</span></div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=800" alt="Spa Treatment">
                <div class="gallery-overlay"><span>Spa Sanctuary</span></div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=800" alt="Beach View">
                <div class="gallery-overlay"><span>Private Beach</span></div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800" alt="Restaurant">
                <div class="gallery-overlay"><span>Fine Dining</span></div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1584132967334-10e028bd69f7?w=800" alt="Suite Interior">
                <div class="gallery-overlay"><span>Luxury Suite</span></div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials" id="testimonials">
        <div class="testimonials-container">
            <div class="testimonials-header">
                <div class="section-tag">Guest Experiences</div>
                <h2>What Our <em>Guests Say</em></h2>
            </div>
            <div class="testimonial-slider">
                <div class="testimonial-track" id="testimonialTrack">
                    <div class="testimonial-item">
                        <div class="testimonial-stars">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <p class="testimonial-quote">"An absolutely magical experience. From the moment we arrived, every detail was perfect. The staff anticipated our every need, and the views were simply breathtaking."</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=200" alt="Sarah Mitchell" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Sarah Mitchell</h4>
                                <span>New York, USA</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-stars">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <p class="testimonial-quote">"We celebrated our anniversary here and it exceeded all expectations. The presidential villa with private pool was paradise. Already planning our return visit."</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200" alt="James & Emily" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>James & Emily Chen</h4>
                                <span>London, UK</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item">
                        <div class="testimonial-stars">
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            <svg viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                        </div>
                        <p class="testimonial-quote">"The spa treatments were transformative, and the oceanfront dining was unforgettable. This is what true luxury hospitality looks like. A five-star experience in every way."</p>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=200" alt="Maria Santos" class="testimonial-avatar">
                            <div class="testimonial-info">
                                <h4>Maria Santos</h4>
                                <span>Dubai, UAE</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-dots">
                <div class="testimonial-dot active" data-index="0"></div>
                <div class="testimonial-dot" data-index="1"></div>
                <div class="testimonial-dot" data-index="2"></div>
            </div>
        </div>
    </section>

    <!-- Booking Section -->
    <section class="booking" id="booking">
        <div class="booking-container">
            <div class="booking-content">
                <div class="section-tag">Reservations</div>
                <h2>Begin Your <em>Elysian</em> Experience</h2>
                <p>Let us craft the perfect getaway for you. Fill in your details below and our concierge team will assist you in creating an unforgettable stay.</p>
                <form class="booking-form" onsubmit="event.preventDefault(); alert('Thank you for your reservation request! Our team will contact you shortly.');">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" placeholder="Your name" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" placeholder="your@email.com" required>
                    </div>
                    <div class="form-group">
                        <label>Check-in Date</label>
                        <input type="date" required>
                    </div>
                    <div class="form-group">
                        <label>Check-out Date</label>
                        <input type="date" required>
                    </div>
                    <div class="form-group">
                        <label>Room Type</label>
                        <select required>
                            <option value="">Select room type</option>
                            <option value="deluxe">Deluxe Ocean View - $450/night</option>
                            <option value="premium">Premium Garden Suite - $680/night</option>
                            <option value="royal">Royal Presidential Villa - $1,200/night</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Guests</label>
                        <select required>
                            <option value="">Number of guests</option>
                            <option value="1">1 Guest</option>
                            <option value="2">2 Guests</option>
                            <option value="3">3 Guests</option>
                            <option value="4">4 Guests</option>
                        </select>
                    </div>
                    <button type="submit" class="booking-submit">Request Reservation</button>
                </form>
            </div>
            <div></div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-brand">
                    <a href="#" class="logo">ELYSIAN</a>
                    <p>An extraordinary retreat where world-class amenities blend seamlessly with natural beauty. Experience the pinnacle of luxury hospitality.</p>
                    <div class="footer-social">
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg></a>
                        <a href="#"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
                    </div>
                </div>
                <div class="footer-column">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#rooms">Accommodations</a></li>
                        <li><a href="#amenities">Amenities</a></li>
                        <li><a href="#gallery">Gallery</a></li>
                        <li><a href="#testimonials">Reviews</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Experiences</h4>
                    <ul>
                        <li><a href="#">Wellness & Spa</a></li>
                        <li><a href="#">Fine Dining</a></li>
                        <li><a href="#">Golf Course</a></li>
                        <li><a href="#">Water Sports</a></li>
                        <li><a href="#">Special Events</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h4>Contact</h4>
                    <ul class="footer-contact">
                        <li>
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>123 Paradise Bay Road,<br>Maldives Islands</span>
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            <span>+960 400 1234</span>
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span>reservations@elysian.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Elysian Resort & Spa. All rights reserved.</p>
                <div class="footer-links">
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
            }, 2000);
        });

        // Navbar scroll
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile menu
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });

        document.querySelectorAll('.mobile-menu-links a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });

        // Scroll reveal
        const observerOptions = {
            threshold: 0.15,
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

        document.querySelectorAll('.stat-item, .about-images, .about-content, .room-card, .amenity-card, .booking-content').forEach(el => {
            observer.observe(el);
        });

        // Counter animation
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target'));
                    const duration = 2000;
                    const step = target / (duration / 16);
                    let current = 0;

                    const updateCounter = () => {
                        current += step;
                        if (current < target) {
                            counter.textContent = Math.floor(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target;
                        }
                    };

                    updateCounter();
                    counterObserver.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.stat-number').forEach(counter => {
            counterObserver.observe(counter);
        });

        // Testimonial slider
        let currentTestimonial = 0;
        const testimonialTrack = document.getElementById('testimonialTrack');
        const testimonialDots = document.querySelectorAll('.testimonial-dot');
        const totalTestimonials = 3;

        function updateTestimonial(index) {
            currentTestimonial = index;
            testimonialTrack.style.transform = `translateX(-${index * 100}%)`;
            testimonialDots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
        }

        testimonialDots.forEach((dot, index) => {
            dot.addEventListener('click', () => updateTestimonial(index));
        });

        // Auto slide testimonials
        setInterval(() => {
            currentTestimonial = (currentTestimonial + 1) % totalTestimonials;
            updateTestimonial(currentTestimonial);
        }, 6000);

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
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
