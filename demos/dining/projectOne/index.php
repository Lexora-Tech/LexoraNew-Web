<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AURUM | Fine Dining Experience</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #C9A962;
            --primary-dark: #A68B4B;
            --accent: #8B0000;
            --background: #0D0D0D;
            --background-alt: #141414;
            --foreground: #FAFAFA;
            --foreground-muted: #9A9A9A;
            --card: #1A1A1A;
            --border: #2A2A2A;
            --radius: 4px;
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
            font-family: 'Montserrat', sans-serif;
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
            width: 100px;
            height: 100px;
            position: relative;
            margin: 0 auto 30px;
        }

        .loader-circle {
            position: absolute;
            inset: 0;
            border: 2px solid var(--border);
            border-radius: 50%;
        }

        .loader-circle::before {
            content: '';
            position: absolute;
            inset: -2px;
            border: 2px solid transparent;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin 1.2s linear infinite;
        }

        .loader-logo {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary);
            letter-spacing: 4px;
        }

        .loader-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1rem;
            letter-spacing: 6px;
            color: var(--foreground-muted);
            text-transform: uppercase;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
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
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--foreground);
            text-decoration: none;
            letter-spacing: 6px;
        }

        .logo span {
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 50px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--foreground-muted);
            font-weight: 400;
            font-size: 0.8rem;
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
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .reserve-btn {
            background: transparent;
            color: var(--primary);
            padding: 14px 32px;
            border: 1px solid var(--primary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: all 0.4s ease;
        }

        .reserve-btn:hover {
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
            height: 1px;
            background: var(--foreground);
            transition: all 0.3s ease;
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
            background: url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=1600') center/cover;
        }

        .hero-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(13, 13, 13, 0.6) 0%, rgba(13, 13, 13, 0.8) 100%);
        }

        .hero-content {
            text-align: center;
            position: relative;
            z-index: 2;
            max-width: 900px;
            padding: 0 20px;
        }

        .hero-tag {
            display: inline-flex;
            align-items: center;
            gap: 15px;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 30px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 1s ease 0.3s forwards;
        }

        .hero-tag::before,
        .hero-tag::after {
            content: '';
            width: 40px;
            height: 1px;
            background: var(--primary);
        }

        .hero h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(3.5rem, 10vw, 7rem);
            font-weight: 400;
            line-height: 1.1;
            margin-bottom: 30px;
            color: var(--foreground);
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s ease 0.5s forwards;
        }

        .hero h1 em {
            font-style: italic;
            color: var(--primary);
        }

        .hero p {
            font-size: 1rem;
            color: var(--foreground-muted);
            margin-bottom: 50px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.8;
            letter-spacing: 0.5px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s ease 0.7s forwards;
        }

        .hero-buttons {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1s ease 0.9s forwards;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--background);
            padding: 18px 45px;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.75rem;
            transition: all 0.4s ease;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(201, 169, 98, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--foreground);
            padding: 18px 45px;
            text-decoration: none;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.75rem;
            border: 1px solid var(--foreground-muted);
            transition: all 0.4s ease;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            opacity: 0;
            animation: fadeUp 1s ease 1.2s forwards;
        }

        .scroll-indicator span {
            font-size: 0.7rem;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--foreground-muted);
        }

        .scroll-line {
            width: 1px;
            height: 60px;
            background: var(--border);
            position: relative;
            overflow: hidden;
        }

        .scroll-line::before {
            content: '';
            position: absolute;
            top: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--primary);
            animation: scrollDown 1.5s ease-in-out infinite;
        }

        @keyframes scrollDown {
            0% { top: -100%; }
            100% { top: 100%; }
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* About Section */
        .about {
            padding: 150px 5%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 100px;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
        }

        .about-image {
            position: relative;
        }

        .about-image img {
            width: 100%;
            height: 600px;
            object-fit: cover;
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease;
        }

        .about-image.visible img {
            opacity: 1;
            transform: translateX(0);
        }

        .about-image::before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            width: 100%;
            height: 100%;
            border: 1px solid var(--primary);
            z-index: -1;
            opacity: 0;
            transition: all 0.8s ease 0.2s;
        }

        .about-image.visible::before {
            opacity: 1;
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
            color: var(--primary);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-bottom: 25px;
        }

        .section-tag::before {
            content: '';
            width: 40px;
            height: 1px;
            background: var(--primary);
        }

        .about-content h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 400;
            margin-bottom: 30px;
            line-height: 1.2;
        }

        .about-content h2 em {
            font-style: italic;
            color: var(--primary);
        }

        .about-content p {
            color: var(--foreground-muted);
            margin-bottom: 20px;
            line-height: 1.9;
        }

        .about-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 40px;
        }

        .about-feature {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .about-feature-icon {
            width: 50px;
            height: 50px;
            border: 1px solid var(--primary);
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
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            margin-bottom: 5px;
        }

        .about-feature p {
            font-size: 0.85rem;
            margin: 0;
        }

        /* Marquee */
        .marquee-section {
            padding: 30px 0;
            background: var(--background-alt);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            overflow: hidden;
        }

        .marquee-track {
            display: flex;
            animation: marquee 30s linear infinite;
        }

        .marquee-content {
            display: flex;
            align-items: center;
            gap: 80px;
            padding: 0 40px;
            flex-shrink: 0;
        }

        .marquee-item {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.5rem;
            font-style: italic;
            color: var(--foreground-muted);
            letter-spacing: 2px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .marquee-item::after {
            content: '◆';
            color: var(--primary);
            font-size: 0.6rem;
        }

        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* Menu Section */
        .menu {
            padding: 150px 5%;
            background: var(--background);
        }

        .menu-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 80px;
        }

        .menu-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 400;
            margin-bottom: 20px;
        }

        .menu-header h2 em {
            font-style: italic;
            color: var(--primary);
        }

        .menu-header p {
            color: var(--foreground-muted);
            line-height: 1.8;
        }

        .menu-tabs {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-bottom: 60px;
        }

        .menu-tab {
            background: none;
            border: none;
            color: var(--foreground-muted);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            padding: 10px 0;
            position: relative;
            transition: color 0.3s ease;
        }

        .menu-tab::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .menu-tab:hover,
        .menu-tab.active {
            color: var(--primary);
        }

        .menu-tab.active::after {
            width: 100%;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px 80px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .menu-item {
            display: flex;
            gap: 25px;
            padding: 30px 0;
            border-bottom: 1px solid var(--border);
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.5s ease;
        }

        .menu-item.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .menu-item-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .menu-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .menu-item:hover .menu-item-image img {
            transform: scale(1.1);
        }

        .menu-item-content {
            flex: 1;
        }

        .menu-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .menu-item-header h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.4rem;
            font-weight: 500;
        }

        .menu-item-price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            color: var(--primary);
        }

        .menu-item-content p {
            color: var(--foreground-muted);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .menu-item-tags {
            display: flex;
            gap: 10px;
            margin-top: 12px;
        }

        .menu-item-tag {
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 4px 10px;
            border: 1px solid var(--border);
            color: var(--foreground-muted);
        }

        /* Chef Section */
        .chef {
            padding: 150px 5%;
            background: var(--background-alt);
        }

        .chef-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 100px;
            align-items: center;
        }

        .chef-content {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s ease;
        }

        .chef-content.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .chef-content h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 400;
            margin-bottom: 30px;
            line-height: 1.2;
        }

        .chef-content h2 em {
            font-style: italic;
            color: var(--primary);
        }

        .chef-content p {
            color: var(--foreground-muted);
            margin-bottom: 20px;
            line-height: 1.9;
        }

        .chef-signature {
            margin-top: 40px;
        }

        .chef-signature img {
            height: 60px;
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .chef-signature span {
            display: block;
            margin-top: 10px;
            color: var(--foreground-muted);
            font-size: 0.85rem;
        }

        .chef-image {
            position: relative;
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s ease 0.3s;
        }

        .chef-image.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .chef-image img {
            width: 100%;
            height: 650px;
            object-fit: cover;
        }

        .chef-image::before {
            content: '';
            position: absolute;
            bottom: -20px;
            right: -20px;
            width: 100%;
            height: 100%;
            border: 1px solid var(--primary);
            z-index: -1;
        }

        .chef-awards {
            position: absolute;
            bottom: 40px;
            left: -60px;
            background: var(--background);
            padding: 30px;
            border: 1px solid var(--border);
        }

        .chef-awards h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3rem;
            color: var(--primary);
            line-height: 1;
        }

        .chef-awards span {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--foreground-muted);
        }

        /* Gallery Section */
        .gallery {
            padding: 150px 5%;
            background: var(--background);
        }

        .gallery-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 80px;
        }

        .gallery-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 400;
            margin-bottom: 20px;
        }

        .gallery-header h2 em {
            font-style: italic;
            color: var(--primary);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(2, 300px);
            gap: 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.5s ease;
        }

        .gallery-item.visible {
            opacity: 1;
            transform: scale(1);
        }

        .gallery-item:first-child {
            grid-column: span 2;
            grid-row: span 2;
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

        .gallery-item::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.8) 100%);
            z-index: 1;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .gallery-item:hover::before {
            opacity: 1;
        }

        .gallery-item-content {
            position: absolute;
            bottom: 20px;
            left: 20px;
            z-index: 2;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
        }

        .gallery-item:hover .gallery-item-content {
            opacity: 1;
            transform: translateY(0);
        }

        .gallery-item-content h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
        }

        .gallery-item-content span {
            font-size: 0.75rem;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Reservation Section */
        .reservation {
            padding: 150px 5%;
            background: var(--background-alt);
            position: relative;
            overflow: hidden;
        }

        .reservation::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1559339352-11d035aa65de?w=1200') center/cover;
            opacity: 0.2;
        }

        .reservation-container {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .reservation-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .reservation-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 400;
            margin-bottom: 20px;
        }

        .reservation-header h2 em {
            font-style: italic;
            color: var(--primary);
        }

        .reservation-header p {
            color: var(--foreground-muted);
            line-height: 1.8;
        }

        .reservation-form {
            background: var(--card);
            padding: 60px;
            border: 1px solid var(--border);
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease;
        }

        .reservation-form.visible {
            opacity: 1;
            transform: translateY(0);
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
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--foreground-muted);
            margin-bottom: 10px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 15px;
            background: var(--background);
            border: 1px solid var(--border);
            color: var(--foreground);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.9rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-group select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239A9A9A' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
        }

        .submit-btn {
            width: 100%;
            background: var(--primary);
            color: var(--background);
            padding: 18px;
            border: none;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.4s ease;
        }

        .submit-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(201, 169, 98, 0.3);
        }

        /* Testimonials */
        .testimonials {
            padding: 150px 5%;
            background: var(--background);
        }

        .testimonials-header {
            text-align: center;
            max-width: 700px;
            margin: 0 auto 80px;
        }

        .testimonials-header h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 400;
            margin-bottom: 20px;
        }

        .testimonials-header h2 em {
            font-style: italic;
            color: var(--primary);
        }

        .testimonials-slider {
            max-width: 900px;
            margin: 0 auto;
            overflow: hidden;
            position: relative;
        }

        .testimonials-track {
            display: flex;
            transition: transform 0.6s ease;
        }

        .testimonial {
            min-width: 100%;
            padding: 0 20px;
            text-align: center;
        }

        .testimonial-quote {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 20px;
        }

        .testimonial p {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-style: italic;
            line-height: 1.8;
            color: var(--foreground);
            margin-bottom: 40px;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .testimonial-author img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .testimonial-author-info h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.2rem;
        }

        .testimonial-author-info span {
            font-size: 0.8rem;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .testimonials-nav {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 50px;
        }

        .testimonial-dot {
            width: 10px;
            height: 10px;
            border: 1px solid var(--primary);
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .testimonial-dot.active {
            background: var(--primary);
        }

        /* Footer */
        footer {
            background: var(--background-alt);
            border-top: 1px solid var(--border);
        }

        .footer-main {
            padding: 100px 5%;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-brand .logo {
            font-size: 2rem;
            margin-bottom: 25px;
            display: inline-block;
        }

        .footer-brand p {
            color: var(--foreground-muted);
            margin-bottom: 30px;
            line-height: 1.8;
            max-width: 350px;
        }

        .footer-socials {
            display: flex;
            gap: 15px;
        }

        .footer-socials a {
            width: 45px;
            height: 45px;
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .footer-socials a:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        .footer-socials svg {
            width: 18px;
            height: 18px;
            fill: var(--foreground);
        }

        .footer-column h4 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.3rem;
            margin-bottom: 25px;
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
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-column a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            padding: 30px 5%;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
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

        /* Responsive */
        @media (max-width: 1200px) {
            .programs-grid,
            .trainers-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .gallery-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: repeat(3, 250px);
            }
            
            .gallery-item:first-child {
                grid-column: span 2;
                grid-row: span 1;
            }
        }

        @media (max-width: 992px) {
            .nav-links {
                display: none;
            }

            .menu-toggle {
                display: flex;
            }

            .reserve-btn {
                display: none;
            }

            .about,
            .chef-container {
                grid-template-columns: 1fr;
                gap: 60px;
            }

            .about-image {
                order: -1;
            }

            .chef-awards {
                position: relative;
                left: 0;
                margin-top: 20px;
                display: inline-block;
            }

            .pricing-grid {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .pricing-card.featured {
                transform: none;
            }

            .menu-grid {
                grid-template-columns: 1fr;
            }

            .footer-main {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 3.5rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .about-features {
                grid-template-columns: 1fr;
            }

            .menu-tabs {
                flex-wrap: wrap;
                gap: 20px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
            }

            .gallery-item,
            .gallery-item:first-child {
                grid-column: span 1;
                grid-row: span 1;
                height: 250px;
            }

            .reservation-form {
                padding: 40px 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .footer-main {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-brand p {
                max-width: 100%;
            }

            .footer-socials {
                justify-content: center;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
        }

        /* Reveal animations */
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
                <div class="loader-circle"></div>
                <span class="loader-logo">A</span>
            </div>
            <p class="loader-text">Fine Dining</p>
        </div>
    </div>

    <!-- Navigation -->
    <nav>
        <a href="#" class="logo">AU<span>R</span>UM</a>
        <ul class="nav-links">
            <li><a href="#about">About</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="#chef">Chef</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <a href="#reservation" class="reserve-btn">Reserve Table</a>
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
            <span class="hero-tag">Est. 2015</span>
            <h1>Where Every Dish Tells a <em>Story</em></h1>
            <p>Experience culinary artistry at its finest. Our award-winning chef crafts each dish with passion, precision, and the freshest seasonal ingredients.</p>
            <div class="hero-buttons">
                <a href="#reservation" class="btn-primary">Reserve Your Table</a>
                <a href="#menu" class="btn-outline">Explore Menu</a>
            </div>
        </div>
        <div class="scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-line"></div>
        </div>
    </section>

    <!-- Marquee -->
    <div class="marquee-section">
        <div class="marquee-track">
            <div class="marquee-content">
                <span class="marquee-item">Michelin Starred</span>
                <span class="marquee-item">Farm to Table</span>
                <span class="marquee-item">Wine Pairing</span>
                <span class="marquee-item">Private Dining</span>
                <span class="marquee-item">Tasting Menu</span>
                <span class="marquee-item">Seasonal Cuisine</span>
            </div>
            <div class="marquee-content">
                <span class="marquee-item">Michelin Starred</span>
                <span class="marquee-item">Farm to Table</span>
                <span class="marquee-item">Wine Pairing</span>
                <span class="marquee-item">Private Dining</span>
                <span class="marquee-item">Tasting Menu</span>
                <span class="marquee-item">Seasonal Cuisine</span>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="about-image">
            <img src="https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?w=800" alt="Restaurant Interior">
        </div>
        <div class="about-content">
            <span class="section-tag">Our Story</span>
            <h2>A Decade of <em>Culinary Excellence</em></h2>
            <p>Nestled in the heart of the city, Aurum has been a beacon of fine dining since 2015. Our philosophy is simple: source the finest ingredients, honor traditional techniques, and create unforgettable moments.</p>
            <p>Every element of Aurum has been carefully curated to provide an immersive dining experience that engages all senses.</p>
            <div class="about-features">
                <div class="about-feature">
                    <div class="about-feature-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <div>
                        <h4>Local Sourcing</h4>
                        <p>Fresh ingredients from local farms</p>
                    </div>
                </div>
                <div class="about-feature">
                    <div class="about-feature-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
                    </div>
                    <div>
                        <h4>Award Winning</h4>
                        <p>Recognized culinary excellence</p>
                    </div>
                </div>
                <div class="about-feature">
                    <div class="about-feature-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/></svg>
                    </div>
                    <div>
                        <h4>Tasting Menus</h4>
                        <p>Curated culinary journeys</p>
                    </div>
                </div>
                <div class="about-feature">
                    <div class="about-feature-icon">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/></svg>
                    </div>
                    <div>
                        <h4>Private Events</h4>
                        <p>Exclusive dining experiences</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="menu">
        <div class="menu-header reveal">
            <span class="section-tag">Our Menu</span>
            <h2>Seasonal <em>Creations</em></h2>
            <p>Each dish is a celebration of flavor, texture, and artful presentation. Our menu evolves with the seasons to bring you the freshest experience.</p>
        </div>
        <div class="menu-tabs">
            <button class="menu-tab active">Starters</button>
            <button class="menu-tab">Mains</button>
            <button class="menu-tab">Desserts</button>
            <button class="menu-tab">Drinks</button>
        </div>
        <div class="menu-grid">
            <div class="menu-item">
                <div class="menu-item-image">
                    <img src="https://images.unsplash.com/photo-1546039907-7fa05f864c02?w=200" alt="Tuna Tartare">
                </div>
                <div class="menu-item-content">
                    <div class="menu-item-header">
                        <h3>Tuna Tartare</h3>
                        <span class="menu-item-price">$28</span>
                    </div>
                    <p>Fresh yellowfin tuna, avocado mousse, sesame crisp, wasabi aioli</p>
                    <div class="menu-item-tags">
                        <span class="menu-item-tag">Gluten Free</span>
                        <span class="menu-item-tag">Chef's Pick</span>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <div class="menu-item-image">
                    <img src="https://images.unsplash.com/photo-1608897013039-887f21d8c804?w=200" alt="Foie Gras">
                </div>
                <div class="menu-item-content">
                    <div class="menu-item-header">
                        <h3>Seared Foie Gras</h3>
                        <span class="menu-item-price">$42</span>
                    </div>
                    <p>Caramelized pear, brioche toast, port wine reduction</p>
                    <div class="menu-item-tags">
                        <span class="menu-item-tag">Signature</span>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <div class="menu-item-image">
                    <img src="https://images.unsplash.com/photo-1604909052743-94e838986d24?w=200" alt="Burrata">
                </div>
                <div class="menu-item-content">
                    <div class="menu-item-header">
                        <h3>Burrata Caprese</h3>
                        <span class="menu-item-price">$24</span>
                    </div>
                    <p>Creamy burrata, heirloom tomatoes, aged balsamic, fresh basil</p>
                    <div class="menu-item-tags">
                        <span class="menu-item-tag">Vegetarian</span>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <div class="menu-item-image">
                    <img src="https://images.unsplash.com/photo-1559847844-5315695dadae?w=200" alt="Oysters">
                </div>
                <div class="menu-item-content">
                    <div class="menu-item-header">
                        <h3>Oysters Rockefeller</h3>
                        <span class="menu-item-price">$36</span>
                    </div>
                    <p>Half dozen premium oysters, spinach gratin, parmesan crust</p>
                    <div class="menu-item-tags">
                        <span class="menu-item-tag">Classic</span>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <div class="menu-item-image">
                    <img src="https://images.unsplash.com/photo-1563379926898-05f4575a45d8?w=200" alt="Lobster Bisque">
                </div>
                <div class="menu-item-content">
                    <div class="menu-item-header">
                        <h3>Lobster Bisque</h3>
                        <span class="menu-item-price">$22</span>
                    </div>
                    <p>Rich creamy bisque, lobster medallion, cognac cream, chives</p>
                    <div class="menu-item-tags">
                        <span class="menu-item-tag">Gluten Free</span>
                    </div>
                </div>
            </div>
            <div class="menu-item">
                <div class="menu-item-image">
                    <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=200" alt="Salad">
                </div>
                <div class="menu-item-content">
                    <div class="menu-item-header">
                        <h3>Garden Medley</h3>
                        <span class="menu-item-price">$18</span>
                    </div>
                    <p>Mixed greens, candied walnuts, goat cheese, honey vinaigrette</p>
                    <div class="menu-item-tags">
                        <span class="menu-item-tag">Vegetarian</span>
                        <span class="menu-item-tag">Vegan Option</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chef Section -->
    <section id="chef" class="chef">
        <div class="chef-container">
            <div class="chef-content">
                <span class="section-tag">Master Chef</span>
                <h2>Meet Our <em>Culinary Artist</em></h2>
                <p>Chef Marcus Laurent brings over 20 years of experience from the finest kitchens in Paris, New York, and Tokyo. His innovative approach to classic cuisine has earned Aurum two Michelin stars and countless accolades.</p>
                <p>Every dish that leaves our kitchen carries Marcus's signature touch - a perfect balance of tradition and innovation, simplicity and complexity.</p>
                <div class="chef-signature">
                    <span>Executive Chef & Founder</span>
                </div>
            </div>
            <div class="chef-image">
                <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?w=800" alt="Chef Marcus Laurent">
                <div class="chef-awards">
                    <h4>2★</h4>
                    <span>Michelin Stars</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="gallery">
        <div class="gallery-header reveal">
            <span class="section-tag">Gallery</span>
            <h2>Visual <em>Journey</em></h2>
        </div>
        <div class="gallery-grid">
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1000" alt="Restaurant Interior">
                <div class="gallery-item-content">
                    <span>Interior</span>
                    <h4>Main Dining Hall</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1466978913421-dad2ebd01d17?w=600" alt="Dish">
                <div class="gallery-item-content">
                    <span>Cuisine</span>
                    <h4>Signature Dishes</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=600" alt="Wine">
                <div class="gallery-item-content">
                    <span>Cellar</span>
                    <h4>Wine Collection</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=600" alt="Bar">
                <div class="gallery-item-content">
                    <span>Lounge</span>
                    <h4>Cocktail Bar</h4>
                </div>
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1600891964092-4316c288032e?w=600" alt="Steak">
                <div class="gallery-item-content">
                    <span>Specialty</span>
                    <h4>Wagyu Selection</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- Reservation Section -->
    <section id="reservation" class="reservation">
        <div class="reservation-container">
            <div class="reservation-header reveal">
                <span class="section-tag">Book Now</span>
                <h2>Make a <em>Reservation</em></h2>
                <p>Secure your table for an unforgettable dining experience. For parties larger than 8, please contact us directly.</p>
            </div>
            <form class="reservation-form">
                <div class="form-row">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="text" placeholder="John Smith" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" placeholder="+1 (555) 000-0000" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" required>
                    </div>
                    <div class="form-group">
                        <label>Time</label>
                        <select required>
                            <option value="">Select Time</option>
                            <option value="18:00">6:00 PM</option>
                            <option value="18:30">6:30 PM</option>
                            <option value="19:00">7:00 PM</option>
                            <option value="19:30">7:30 PM</option>
                            <option value="20:00">8:00 PM</option>
                            <option value="20:30">8:30 PM</option>
                            <option value="21:00">9:00 PM</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Party Size</label>
                    <select required>
                        <option value="">Select Guests</option>
                        <option value="1">1 Guest</option>
                        <option value="2">2 Guests</option>
                        <option value="3">3 Guests</option>
                        <option value="4">4 Guests</option>
                        <option value="5">5 Guests</option>
                        <option value="6">6 Guests</option>
                        <option value="7">7 Guests</option>
                        <option value="8">8 Guests</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Special Requests</label>
                    <textarea placeholder="Dietary restrictions, special occasions, seating preferences..."></textarea>
                </div>
                <button type="submit" class="submit-btn">Confirm Reservation</button>
            </form>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="testimonials-header reveal">
            <span class="section-tag">Testimonials</span>
            <h2>Guest <em>Experiences</em></h2>
        </div>
        <div class="testimonials-slider">
            <div class="testimonials-track">
                <div class="testimonial">
                    <div class="testimonial-quote">"</div>
                    <p>An extraordinary culinary journey from start to finish. Every course was a masterpiece, and the service was impeccable. Aurum has set a new standard for fine dining.</p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" alt="Sarah Mitchell">
                        <div class="testimonial-author-info">
                            <h4>Sarah Mitchell</h4>
                            <span>Food Critic</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <div class="testimonial-quote">"</div>
                    <p>The tasting menu was nothing short of spectacular. Chef Marcus has created something truly special here. We've already booked our next visit.</p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="James Chen">
                        <div class="testimonial-author-info">
                            <h4>James Chen</h4>
                            <span>Regular Guest</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial">
                    <div class="testimonial-quote">"</div>
                    <p>We celebrated our anniversary at Aurum and it exceeded every expectation. The ambiance, the food, the attention to detail - absolutely perfect in every way.</p>
                    <div class="testimonial-author">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100" alt="Emily Watson">
                        <div class="testimonial-author-info">
                            <h4>Emily Watson</h4>
                            <span>Anniversary Dinner</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="testimonials-nav">
            <button class="testimonial-dot active" data-index="0"></button>
            <button class="testimonial-dot" data-index="1"></button>
            <button class="testimonial-dot" data-index="2"></button>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-main">
            <div class="footer-brand">
                <a href="#" class="logo">AU<span>R</span>UM</a>
                <p>Where culinary artistry meets timeless elegance. Join us for an unforgettable dining experience that celebrates the finest in seasonal cuisine.</p>
                <div class="footer-socials">
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    <a href="#"><svg viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg></a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#menu">Our Menu</a></li>
                    <li><a href="#chef">The Chef</a></li>
                    <li><a href="#gallery">Gallery</a></li>
                    <li><a href="#reservation">Reservations</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Hours</h4>
                <ul>
                    <li><a href="#">Tue - Thu: 6PM - 10PM</a></li>
                    <li><a href="#">Fri - Sat: 6PM - 11PM</a></li>
                    <li><a href="#">Sunday: 5PM - 9PM</a></li>
                    <li><a href="#">Monday: Closed</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Contact</h4>
                <ul>
                    <li><a href="#">142 Gold Street</a></li>
                    <li><a href="#">New York, NY 10038</a></li>
                    <li><a href="tel:+12125551234">+1 (212) 555-1234</a></li>
                    <li><a href="mailto:hello@aurum.com">hello@aurum.com</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Aurum. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>

    <script>
        // Loader
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.querySelector('.loader').classList.add('hidden');
            }, 2000);
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

        // Reveal animations on scroll
        const revealElements = document.querySelectorAll('.reveal, .about-image, .about-content, .menu-item, .chef-content, .chef-image, .gallery-item, .reservation-form');

        const revealOnScroll = () => {
            revealElements.forEach((el, index) => {
                const rect = el.getBoundingClientRect();
                const windowHeight = window.innerHeight;
                
                if (rect.top < windowHeight * 0.85) {
                    setTimeout(() => {
                        el.classList.add('visible');
                    }, index * 50);
                }
            });
        };

        window.addEventListener('scroll', revealOnScroll);
        window.addEventListener('load', revealOnScroll);

        // Menu tabs
        const menuTabs = document.querySelectorAll('.menu-tab');
        menuTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                menuTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
            });
        });

        // Testimonials slider
        const track = document.querySelector('.testimonials-track');
        const dots = document.querySelectorAll('.testimonial-dot');
        let currentSlide = 0;

        function goToSlide(index) {
            currentSlide = index;
            track.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
        }

        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });

        // Auto-slide testimonials
        setInterval(() => {
            currentSlide = (currentSlide + 1) % 3;
            goToSlide(currentSlide);
        }, 6000);

        // Form submission
        document.querySelector('.reservation-form').addEventListener('submit', (e) => {
            e.preventDefault();
            alert('Thank you for your reservation request! We will confirm shortly.');
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
