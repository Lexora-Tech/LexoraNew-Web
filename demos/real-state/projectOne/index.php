<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THE ESTATE | Private Brokerage</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- 1. CORPORATE LUXURY VARIABLES --- */
        :root {
            --bg-body: #F9F8F6;
            /* Bone White */
            --bg-card: #FFFFFF;
            --bg-dark: #1C1C1C;
            /* Soft Black */

            --text-main: #1C1C1C;
            --text-muted: #6e6e6e;
            --text-white: #FFFFFF;

            --accent: #A89F91;
            /* Taupe/Bronze */
            --border: #E5E5E5;

            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'DM Sans', sans-serif;

            --ease: cubic-bezier(0.22, 1, 0.36, 1);
            --shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.05);
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
            background-color: var(--bg-body);
            color: var(--text-main);
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* --- TYPOGRAPHY --- */
        h1,
        h2,
        h3,
        h4 {
            font-family: var(--font-display);
            font-weight: 400;
            line-height: 1.1;
            color: var(--text-main);
        }

        h1 {
            font-size: clamp(3.5rem, 8vw, 6rem);
            letter-spacing: -0.02em;
        }

        h2 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            margin-bottom: 20px;
        }

        .label {
            font-family: var(--font-body);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            font-weight: 600;
            display: block;
            margin-bottom: 10px;
        }

        /* --- BUTTONS --- */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 16px 32px;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            border: 1px solid var(--text-main);
            cursor: pointer;
            transition: all 0.4s var(--ease);
            background: transparent;
            color: var(--text-main);
            min-width: 160px;
        }

        .btn:hover {
            background: var(--text-main);
            color: var(--text-white);
        }

        .btn-dark {
            background: var(--bg-dark);
            color: var(--text-white);
            border-color: var(--bg-dark);
        }

        .btn-dark:hover {
            background: transparent;
            color: var(--text-main);
        }

        /* --- UTILS --- */
        .container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .section-padding {
            padding: 140px 0;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            background: #e0e0e0;
        }

        /* --- 2. NAVIGATION --- */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 25px 0;
            transition: 0.4s;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            border-bottom: 1px solid var(--border);
        }

        .navbar.scrolled .logo,
        .navbar.scrolled .nav-link,
        .navbar.scrolled .nav-icon {
            color: var(--text-main);
        }

        .logo {
            font-family: var(--font-display);
            font-size: 1.8rem;
            letter-spacing: 1px;
            color: var(--text-white);
            text-decoration: none;
            font-weight: 600;
        }

        .nav-center {
            display: flex;
            gap: 40px;
        }

        .nav-link {
            color: var(--text-white);
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .nav-link:hover {
            opacity: 0.7;
        }

        .nav-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-icon {
            color: var(--text-white);
            font-size: 1.1rem;
            cursor: pointer;
            position: relative;
        }

        .fav-count {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 8px;
            height: 8px;
            background: #C85A17;
            border-radius: 50%;
            display: none;
        }

        /* --- 3. HERO SECTION --- */
        .hero {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            overflow: hidden;
            padding-bottom: 120px;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: -1;
        }

        .hero-bg img {
            animation: zoomSlow 20s infinite alternate;
        }

        @keyframes zoomSlow {
            to {
                transform: scale(1.05);
            }
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent 40%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--text-white);
            width: 100%;
            max-width: 1200px;
        }

        /* Floating Search Dock */
        .search-dock {
            background: #fff;
            padding: 15px 30px;
            border-radius: 4px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr auto;
            gap: 30px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
            margin-top: 60px;
            align-items: center;
        }

        .search-item {
            border-right: 1px solid #eee;
            padding-right: 20px;
        }

        .search-item:last-of-type {
            border: none;
        }

        .search-label {
            display: block;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            font-weight: 700;
            margin-bottom: 5px;
            text-align: left;
        }

        .search-input {
            width: 100%;
            border: none;
            font-family: var(--font-display);
            font-size: 1.3rem;
            color: var(--text-main);
            outline: none;
            background: transparent;
            cursor: pointer;
        }

        /* --- 4. LISTINGS --- */
        .grid-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 60px;
        }

        .listing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 40px;
        }

        .card {
            background: var(--bg-card);
            transition: 0.5s var(--ease);
            cursor: pointer;
            border: 1px solid transparent;
            position: relative;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card:hover .card-img img {
            transform: scale(1.05);
        }

        .card-img {
            height: 450px;
            overflow: hidden;
            position: relative;
            margin-bottom: 20px;
        }

        .card-img img {
            transition: 0.7s var(--ease);
        }

        .card-tags {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            gap: 10px;
        }

        .tag {
            background: #fff;
            padding: 6px 12px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .fav-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            opacity: 0;
            transform: translateY(10px);
        }

        .card:hover .fav-btn {
            opacity: 1;
            transform: translateY(0);
        }

        .fav-btn.active {
            color: #C85A17;
        }

        .card-meta {
            display: flex;
            gap: 20px;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .card-title {
            font-size: 1.6rem;
            margin-bottom: 5px;
            font-weight: 400;
        }

        .card-price {
            font-family: var(--font-body);
            font-weight: 500;
            font-size: 1.1rem;
            color: var(--text-main);
        }

        /* --- 5. MARKET DATA / CALCULATOR --- */
        .finance-section {
            background: #fff;
        }

        .finance-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .calc-box {
            padding: 40px;
            background: var(--bg-body);
            border: 1px solid #eee;
        }

        .calc-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .input-wrapper label {
            display: block;
            font-size: 0.8rem;
            margin-bottom: 8px;
            color: var(--text-muted);
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            background: #fff;
            font-family: var(--font-body);
            outline: none;
            transition: 0.3s;
        }

        .input-wrapper input:focus {
            border-color: var(--text-main);
        }

        .calc-result {
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 30px;
        }

        .bar-container {
            height: 10px;
            background: #ddd;
            width: 100%;
            margin-top: 10px;
            border-radius: 5px;
            overflow: hidden;
            display: flex;
        }

        .bar-principal {
            background: var(--text-main);
            height: 100%;
            width: 70%;
            transition: 1s;
        }

        .bar-interest {
            background: var(--accent);
            height: 100%;
            width: 30%;
            transition: 1s;
        }

        /* --- 6. CONTACT --- */
        .contact-section {
            background: var(--bg-dark);
            color: #fff;
        }

        .contact-content {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
        }

        .contact-content h2 {
            color: #fff;
        }

        .contact-content p {
            color: #888;
            margin-bottom: 40px;
        }

        .minimal-input {
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1px solid #333;
            padding: 15px 0;
            color: #fff;
            font-size: 1.2rem;
            outline: none;
            margin-bottom: 30px;
            font-family: var(--font-display);
        }

        .minimal-input:focus {
            border-color: #fff;
        }

        /* --- 7. FOOTER --- */
        .footer {
            padding: 80px 0 40px;
            background: #fff;
        }

        .footer-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 80px;
        }

        .footer-nav {
            display: flex;
            gap: 60px;
        }

        .footer-col h5 {
            font-size: 0.75rem;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: var(--text-muted);
        }

        .footer-col a {
            display: block;
            margin-bottom: 10px;
            color: var(--text-main);
            font-size: 0.95rem;
            text-decoration: none;
        }

        .copyright {
            border-top: 1px solid #eee;
            padding-top: 30px;
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        /* --- 8. TOAST NOTIFICATION --- */
        .toast-box {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            background: var(--bg-dark);
            color: #fff;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            opacity: 0;
            transform: translateY(20px);
            transition: 0.4s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .toast-box.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .nav-center {
                display: none;
            }

            .search-dock {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 25px;
                margin-top: 40px;
            }

            .search-item {
                border: none;
                border-bottom: 1px solid #eee;
                padding-bottom: 15px;
                padding-right: 0;
            }

            .finance-grid {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 3rem;
            }
        }

        /* --- ANIMATIONS --- */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: 1s var(--ease);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body>

    <div id="toast" class="toast-box">
        <i class="fas fa-check-circle" style="color: #4ade80;"></i>
        <span id="toastMsg">Action Successful</span>
    </div>

    <nav class="navbar">
        <div class="container flex-between">
            <a href="#" class="logo">THE ESTATE</a>

            <div class="nav-center">
                <a href="#featured" class="nav-link">Residence</a>
                <a href="#finance" class="nav-link">Finance</a>
                <a href="#contact" class="nav-link">Private Office</a>
            </div>

            <div class="nav-right">
                <div class="nav-icon" onclick="scrollToContact()">
                    <i class="far fa-envelope"></i>
                </div>
                <div class="nav-icon">
                    <i class="far fa-heart"></i>
                    <div class="fav-count" id="favCount"></div>
                </div>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-bg">
            <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                alt="Luxury Architecture" onerror="this.src='https://placehold.co/1920x1080/1c1c1c/fff?text=The+Estate'">
        </div>
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <h1 class="reveal-text">Curating the <br>Exceptional.</h1>
            <p style="opacity: 0.9; margin-top: 20px; font-size: 1.1rem;">A global portfolio of architecturally significant homes.</p>

            <div class="search-dock reveal-text">
                <div class="search-item">
                    <label class="search-label">Location</label>
                    <input type="text" id="searchLoc" class="search-input" placeholder="e.g. Monaco">
                </div>
                <div class="search-item">
                    <label class="search-label">Property Type</label>
                    <select id="searchType" class="search-input">
                        <option value="all">All Types</option>
                        <option value="Estate">Estate</option>
                        <option value="Penthouse">Penthouse</option>
                        <option value="Villa">Villa</option>
                    </select>
                </div>
                <div class="search-item">
                    <label class="search-label">Price Range</label>
                    <select id="searchPrice" class="search-input">
                        <option value="999999999">No Limit</option>
                        <option value="5000000">Up to $5M</option>
                        <option value="15000000">Up to $15M</option>
                    </select>
                </div>
                <button onclick="filterProperties()" class="btn btn-dark" style="height: 100%; width: 100%;">Search</button>
            </div>
        </div>
    </header>

    <section id="featured" class="section-padding">
        <div class="container">
            <div class="grid-header">
                <div>
                    <span class="label">Current Portfolio</span>
                    <h2>Selected Works</h2>
                </div>
                <button onclick="resetFilters()" class="btn">View All Listings</button>
            </div>

            <div id="propertyGrid" class="listing-grid">
            </div>

            <div id="noResults" style="text-align: center; display: none; padding: 50px;">
                <h3>No residences match your criteria.</h3>
                <p>Please adjust your filters.</p>
            </div>
        </div>
    </section>

    <section id="finance" class="section-padding finance-section">
        <div class="container finance-grid">
            <div>
                <span class="label">Financial</span>
                <h2>Mortgage Estimation</h2>
                <p style="margin-bottom: 30px;">Calculate monthly commitments for your potential acquisition. Includes principal and estimated interest.</p>

                <div class="calc-box">
                    <div class="calc-row">
                        <div class="input-wrapper">
                            <label>Purchase Price ($)</label>
                            <input type="number" id="cPrice" value="8500000">
                        </div>
                        <div class="input-wrapper">
                            <label>Down Payment ($)</label>
                            <input type="number" id="cDown" value="2000000">
                        </div>
                    </div>
                    <div class="calc-row">
                        <div class="input-wrapper">
                            <label>Interest Rate (%)</label>
                            <input type="number" id="cRate" value="6.2" step="0.1">
                        </div>
                        <div class="input-wrapper">
                            <label>Term (Years)</label>
                            <input type="number" id="cTerm" value="30">
                        </div>
                    </div>

                    <button onclick="calculateMortgage()" class="btn btn-dark" style="width: 100%;">Update Estimate</button>

                    <div class="calc-result">
                        <div class="flex-between">
                            <span>Monthly Payment</span>
                            <span id="monthlyResult" style="font-family: var(--font-display); font-size: 1.5rem; font-weight: 600;">$39,812</span>
                        </div>
                        <div class="bar-container">
                            <div class="bar-principal" id="barP"></div>
                            <div class="bar-interest" id="barI"></div>
                        </div>
                        <div class="flex-between" style="font-size: 0.75rem; margin-top: 5px; color: var(--text-muted);">
                            <span>Principal</span>
                            <span>Interest</span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="height: 600px;">
                <img src="https://images.unsplash.com/photo-1600607687644-c7171b42498f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Interior Detail"
                    onerror="this.src='https://placehold.co/800x1000/ccc/333?text=Interior'"
                    style="border-radius: 4px;">
            </div>
        </div>
    </section>

    <section id="contact" class="section-padding contact-section">
        <div class="container contact-content">
            <span class="label" style="color: rgba(255,255,255,0.6);">Private Office</span>
            <h2>Inquire</h2>
            <p>For off-market listings or to arrange a private viewing, please leave your details.</p>

            <form id="contactForm">
                <input type="text" class="minimal-input" placeholder="Name" required>
                <input type="email" class="minimal-input" placeholder="Email Address" required>
                <button type="submit" class="btn" style="background: #fff; color: #000; border-color: #fff; width: 100%;">Submit Inquiry</button>
            </form>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <a href="#" class="logo" style="color: var(--text-main);">THE ESTATE.</a>

                <div class="footer-nav">
                    <div class="footer-col">
                        <h5>Real Estate</h5>
                        <a href="#">Buy</a>
                        <a href="#">Sell</a>
                        <a href="#">New Developments</a>
                    </div>
                    <div class="footer-col">
                        <h5>Company</h5>
                        <a href="#">About Us</a>
                        <a href="#">Journal</a>
                        <a href="#">Careers</a>
                    </div>
                    <div class="footer-col">
                        <h5>Social</h5>
                        <a href="#">Instagram</a>
                        <a href="#">LinkedIn</a>
                    </div>
                </div>
            </div>

            <div class="copyright">
                <span>&copy; 2025 The Estate Brokerage.</span>
                <span>Privacy Policy</span>
            </div>
        </div>
    </footer>

    <script>
        // --- 1. DATA (Simulating a Database) ---
        const properties = [{
                id: 1,
                title: "The Glass House",
                location: "Beverly Hills, CA",
                price: 12500000,
                type: "Estate",
                beds: 6,
                baths: 7,
                sqft: 8500,
                image: "https://images.unsplash.com/photo-1613490493576-7fde63acd811?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                badge: "Exclusive"
            },
            {
                id: 2,
                title: "Oceanfront Modern",
                location: "Malibu, CA",
                price: 18900000,
                type: "Villa",
                beds: 5,
                baths: 6,
                sqft: 6200,
                image: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                badge: "New"
            },
            {
                id: 3,
                title: "Skyline Penthouse",
                location: "New York, NY",
                price: 8500000,
                type: "Penthouse",
                beds: 3,
                baths: 3.5,
                sqft: 3400,
                image: "https://images.unsplash.com/photo-1600607687644-c7171b42498f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                badge: "Pending"
            },
            {
                id: 4,
                title: "Desert Sanctuary",
                location: "Palm Springs, CA",
                price: 4200000,
                type: "Estate",
                beds: 4,
                baths: 4,
                sqft: 4100,
                image: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                badge: "For Sale"
            },
            {
                id: 5,
                title: "Lake Tahoe Retreat",
                location: "Incline Village, NV",
                price: 14500000,
                type: "Villa",
                beds: 7,
                baths: 8,
                sqft: 9500,
                // Updated Image
                image: "https://images.unsplash.com/photo-1510798831971-661eb04b3739?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                badge: "Rare Find"
            },
            {
                id: 6,
                title: "Tribeca Loft",
                location: "New York, NY",
                price: 3800000,
                type: "Penthouse",
                beds: 2,
                baths: 2,
                sqft: 2100,
                image: "https://images.unsplash.com/photo-1560185893-a55cbc8c57e8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80",
                badge: "Sold"
            }
        ];

        let favorites = [];

        // --- 2. INITIALIZATION ---
        document.addEventListener('DOMContentLoaded', () => {
            renderProperties(properties);
            calculateMortgage(); // Initial calc

            // Navbar Scroll Effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) navbar.classList.add('scrolled');
                else navbar.classList.remove('scrolled');
            });
        });

        // --- 3. RENDER LOGIC ---
        function renderProperties(data) {
            const grid = document.getElementById('propertyGrid');
            const noResults = document.getElementById('noResults');
            grid.innerHTML = '';

            if (data.length === 0) {
                noResults.style.display = 'block';
                return;
            } else {
                noResults.style.display = 'none';
            }

            data.forEach(prop => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <div class="card-img">
                        <img src="${prop.image}" alt="${prop.title}" onerror="this.src='https://placehold.co/600x800/222/fff?text=Image+Unavailable'">
                        <div class="card-tags">
                            <span class="tag">${prop.badge}</span>
                            <span class="tag">${prop.type}</span>
                        </div>
                        <div class="fav-btn" onclick="toggleFav(this, ${prop.id})"><i class="far fa-heart"></i></div>
                    </div>
                    <div style="padding: 0 20px 20px 20px;">
                        <div class="card-meta">
                            <span>${prop.beds} Beds</span>
                            <span>${prop.baths} Baths</span>
                            <span>${prop.sqft.toLocaleString()} Sq Ft</span>
                        </div>
                        <h3 class="card-title">${prop.title}</h3>
                        <p style="margin: 0 0 10px; color: var(--text-muted); font-size: 0.9rem;">${prop.location}</p>
                        <div class="card-price">$${(prop.price/1000000).toFixed(2)}M</div>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        // --- 4. FILTERING ---
        function filterProperties() {
            const loc = document.getElementById('searchLoc').value.toLowerCase();
            const type = document.getElementById('searchType').value;
            const price = parseInt(document.getElementById('searchPrice').value);

            const filtered = properties.filter(p => {
                const matchLoc = p.location.toLowerCase().includes(loc) || p.title.toLowerCase().includes(loc);
                const matchType = type === 'all' || p.type === type;
                const matchPrice = p.price <= price;
                return matchLoc && matchType && matchPrice;
            });

            renderProperties(filtered);
            showToast(`Found ${filtered.length} listings`);
        }

        function resetFilters() {
            document.getElementById('searchLoc').value = '';
            document.getElementById('searchType').value = 'all';
            document.getElementById('searchPrice').value = '999999999';
            renderProperties(properties);
        }

        // --- 5. MORTGAGE CALCULATOR & VISUALIZER ---
        function calculateMortgage() {
            const P = parseFloat(document.getElementById('cPrice').value);
            const D = parseFloat(document.getElementById('cDown').value);
            const r = parseFloat(document.getElementById('cRate').value) / 100 / 12;
            const n = parseFloat(document.getElementById('cTerm').value) * 12;

            const loanAmount = P - D;
            const monthly = (loanAmount * r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1);

            if (!isNaN(monthly)) {
                document.getElementById('monthlyResult').innerText = "$" + Math.round(monthly).toLocaleString();

                // Visual Bar Logic
                const totalInterest = (monthly * n) - loanAmount;
                const totalCost = loanAmount + totalInterest;
                const principalPct = (loanAmount / totalCost) * 100;
                const interestPct = 100 - principalPct;

                document.getElementById('barP').style.width = principalPct + "%";
                document.getElementById('barI').style.width = interestPct + "%";
            }
        }

        // --- 6. UTILITIES ---
        function toggleFav(btn, id) {
            btn.classList.toggle('active');
            const icon = btn.querySelector('i');

            if (btn.classList.contains('active')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                icon.style.color = '#C85A17';
                favorites.push(id);
                showToast("Added to Favorites");
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                icon.style.color = 'inherit';
                favorites = favorites.filter(fav => fav !== id);
                showToast("Removed from Favorites");
            }

            // Update nav dot
            const badge = document.getElementById('favCount');
            if (favorites.length > 0) badge.style.display = 'block';
            else badge.style.display = 'none';
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            const msg = document.getElementById('toastMsg');
            msg.innerText = message;
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        function scrollToContact() {
            document.getElementById('contact').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // --- 7. FORM HANDLER ---
        const form = document.getElementById('contactForm');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = form.querySelector('button');
            const original = btn.innerText;
            btn.innerText = 'Sending...';
            setTimeout(() => {
                showToast("Inquiry Sent Successfully");
                form.reset();
                btn.innerText = original;
            }, 1500);
        });
    </script>
</body>

</html>
