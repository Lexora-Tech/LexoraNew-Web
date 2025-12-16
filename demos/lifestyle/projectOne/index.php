<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serenité | Wellness & Spa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- 1. DESIGN SYSTEM --- */
        :root {
            /* Palette: Earthy, Organic, Calm */
            --bg-body: #fdfcf8;
            /* Warm Off-White */
            --bg-surface: #f5f2eb;
            /* Beige/Sand */
            --bg-card: #ffffff;

            --text-main: #2c2a26;
            /* Charcoal */
            --text-muted: #6b665f;
            /* Taupe */

            --primary: #57534e;
            /* Warm Stone */
            --accent: #d4af37;
            /* Muted Gold */
            --green: #4a5d4e;
            /* Sage Green */

            --font-display: 'Cormorant Garamond', serif;
            --font-body: 'Lato', sans-serif;

            --ease: cubic-bezier(0.22, 1, 0.36, 1);
            --border: 1px solid rgba(44, 42, 38, 0.08);
        }

        /* --- 2. RESET --- */
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
            line-height: 1.7;
            overflow-x: hidden;
        }

        /* Typography */
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
            font-style: italic;
        }

        h2 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            margin-bottom: 30px;
        }

        h3 {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        p {
            color: var(--text-muted);
            margin-bottom: 24px;
            font-weight: 300;
            font-size: 1.05rem;
        }

        .italic {
            font-style: italic;
        }

        .gold {
            color: var(--accent);
        }

        .center-text {
            text-align: center;
        }

        /* Links & Images */
        a {
            text-decoration: none;
            color: inherit;
            transition: 0.4s var(--ease);
        }

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .section-padding {
            padding: 140px 0;
        }

        /* --- 3. COMPONENTS --- */

        /* Buttons */
        .btn {
            display: inline-block;
            padding: 16px 40px;
            font-family: var(--font-body);
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            border: 1px solid var(--text-main);
            background: transparent;
            color: var(--text-main);
            cursor: pointer;
            transition: 0.4s var(--ease);
        }

        .btn:hover {
            background: var(--text-main);
            color: white;
        }

        .btn-fill {
            background: var(--text-main);
            color: white;
        }

        .btn-fill:hover {
            background: var(--accent);
            border-color: var(--accent);
        }

        /* --- 4. NAVIGATION --- */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            padding: 30px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.4s;
        }

        .navbar.scrolled {
            background: rgba(253, 252, 248, 0.95);
            padding: 15px 50px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
        }

        .logo {
            font-family: var(--font-display);
            font-size: 2rem;
            letter-spacing: -1px;
        }

        .nav-links {
            display: flex;
            gap: 40px;
        }

        .nav-link {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .nav-link:hover {
            color: var(--accent);
        }

        .hamburger {
            display: none;
            cursor: pointer;
            font-size: 1.5rem;
        }

        /* --- 5. HERO SECTION --- */
        .hero {
            height: 100vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            text-align: center;
        }

        .hero-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            animation: zoomSlow 20s infinite alternate;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: #fff;
            max-width: 800px;
        }

        .hero-content h1 {
            color: #fff;
            margin-bottom: 20px;
        }

        .hero-content p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.2rem;
        }

        .hero-content .btn {
            border-color: #fff;
            color: #fff;
        }

        .hero-content .btn:hover {
            background: #fff;
            color: #000;
        }

        @keyframes zoomSlow {
            from {
                transform: scale(1);
            }

            to {
                transform: scale(1.1);
            }
        }

        /* --- 6. INTRO / PHILOSOPHY --- */
        .intro-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .intro-img-wrapper {
            position: relative;
            height: 600px;
            overflow: hidden;
        }

        .intro-text-wrapper {
            padding-right: 40px;
        }

        .signature {
            font-family: 'Great Vibes', cursive;
            font-size: 2rem;
            color: var(--accent);
            margin-top: 30px;
        }

        /* --- 7. SERVICES MENU --- */
        .menu-section {
            background-color: var(--bg-surface);
        }

        .menu-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
        }

        .menu-category {
            margin-bottom: 50px;
        }

        .menu-category h3 {
            font-family: var(--font-body);
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .menu-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            align-items: baseline;
        }

        .menu-item-name {
            font-family: var(--font-display);
            font-size: 1.6rem;
            font-style: italic;
        }

        .menu-item-price {
            font-family: var(--font-body);
            font-weight: 700;
            color: var(--text-main);
        }

        .menu-item-desc {
            display: block;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-top: 5px;
        }

        /* --- 8. GALLERY (Masonry) --- */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: repeat(2, 300px);
            gap: 20px;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
        }

        .gallery-item img {
            transition: 0.6s var(--ease);
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        .g-wide {
            grid-column: span 2;
        }

        .g-tall {
            grid-row: span 2;
        }

        /* --- 9. TESTIMONIALS --- */
        .testimonial-slider {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .quote-icon {
            font-size: 3rem;
            color: var(--accent);
            margin-bottom: 30px;
            opacity: 0.5;
        }

        .review-text {
            font-family: var(--font-display);
            font-size: 2.2rem;
            line-height: 1.4;
            color: var(--text-main);
            margin-bottom: 40px;
        }

        .reviewer {
            font-size: 0.9rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        /* --- 10. BOOKING FORM --- */
        .booking-wrapper {
            background: #fff;
            padding: 80px;
            border: var(--border);
            max-width: 900px;
            margin: -100px auto 0;
            position: relative;
            z-index: 10;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: var(--text-muted);
        }

        .form-input {
            width: 100%;
            border: none;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            font-family: var(--font-display);
            font-size: 1.5rem;
            color: var(--text-main);
            outline: none;
            background: transparent;
        }

        .form-input:focus {
            border-bottom-color: var(--text-main);
        }

        select.form-input {
            border-radius: 0;
            -webkit-appearance: none;
        }

        /* --- 11. FOOTER --- */
        .footer {
            background: var(--text-main);
            color: #fff;
            padding: 100px 0 40px;
            margin-top: 100px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 80px;
        }

        .footer h4 {
            font-family: var(--font-body);
            font-size: 0.85rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 25px;
            color: rgba(255, 255, 255, 0.5);
        }

        .footer p,
        .footer a {
            color: rgba(255, 255, 255, 0.8);
            display: block;
            margin-bottom: 15px;
            font-weight: 300;
        }

        .footer a:hover {
            color: var(--accent);
            margin-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 20px;
        }

        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            text-align: center;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.4);
        }

        /* --- ANIMATIONS --- */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: 1s var(--ease);
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 900px) {
            .navbar {
                padding: 20px;
            }

            .nav-links {
                display: none;
            }

            .hamburger {
                display: block;
            }

            .hero-content h1 {
                font-size: 3rem;
            }

            .intro-grid,
            .menu-grid,
            .form-row,
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
            }

            .g-wide,
            .g-tall {
                grid-column: span 1;
                grid-row: span 1;
            }

            .booking-wrapper {
                padding: 40px 20px;
                width: 90%;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="logo">Serenité.</div>

        <div class="nav-links">
            <a href="#about" class="nav-link">Philosophy</a>
            <a href="#services" class="nav-link">Menu</a>
            <a href="#gallery" class="nav-link">Spaces</a>
            <a href="#reviews" class="nav-link">Stories</a>
        </div>

        <a href="#book" class="btn">Reserve</a>
        <div class="hamburger"><i class="fas fa-bars"></i></div>
    </nav>

    <header class="hero">
        <div class="hero-img">
            <img src="https://images.unsplash.com/photo-1540555700478-4be289fbecef?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80"
                alt="Spa Atmosphere"
                onerror="this.src='https://placehold.co/1920x1080/efece6/2c2a26?text=Serenite+Spa'">
        </div>
        <div class="hero-overlay"></div>

        <div class="hero-content reveal">
            <h1>Beauty in <span class="italic">Balance</span></h1>
            <p>A sanctuary for the senses. Where time slows down and wellness begins.</p>
            <a href="#services" class="btn">View Treatments</a>
        </div>
    </header>

    <section id="about" class="section-padding">
        <div class="container intro-grid">
            <div class="intro-img-wrapper reveal">
                <img src="https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Skincare Ritual">
            </div>
            <div class="intro-text-wrapper reveal">
                <h2 style="line-height: 1.2;">The Art of <br><span class="italic gold">Slowing Down.</span></h2>
                <p>In a world of constant movement, Serenité offers a pause. Our philosophy is rooted in the belief that true beauty comes from deep rest and organic care.</p>
                <p>We use only ethically sourced, botanical ingredients combined with ancient techniques to restore your natural glow.</p>
                <div style="margin-top: 40px;">
                    <span style="font-family: 'Cormorant Garamond'; font-size: 1.2rem; font-style: italic;">Founder,</span><br>
                    <span style="font-family: 'Cormorant Garamond'; font-size: 2rem;">Elara Vane</span>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="section-padding menu-section">
        <div class="container">
            <div class="center-text reveal" style="margin-bottom: 80px;">
                <p style="text-transform: uppercase; letter-spacing: 2px; font-size: 0.8rem;">Our Offerings</p>
                <h2>Curated <span class="italic">Rituals</span></h2>
            </div>

            <div class="menu-grid">
                <div class="reveal">
                    <div class="menu-category">
                        <h3>Facial Therapies</h3>

                        <div class="menu-item">
                            <div>
                                <span class="menu-item-name">The Radiance Glow</span>
                                <span class="menu-item-desc">60 min • Vitamin C & Hyaluronic Infusion</span>
                            </div>
                            <span class="menu-item-price">$145</span>
                        </div>

                        <div class="menu-item">
                            <div>
                                <span class="menu-item-name">Deep Earth Clay</span>
                                <span class="menu-item-desc">75 min • Detoxifying Mineral Mask</span>
                            </div>
                            <span class="menu-item-price">$165</span>
                        </div>

                        <div class="menu-item">
                            <div>
                                <span class="menu-item-name">Sculpting Gua Sha</span>
                                <span class="menu-item-desc">90 min • Lymphatic Drainage Massage</span>
                            </div>
                            <span class="menu-item-price">$195</span>
                        </div>
                    </div>

                    <div class="menu-category">
                        <h3>Body Work</h3>

                        <div class="menu-item">
                            <div>
                                <span class="menu-item-name">Aromatherapy Drift</span>
                                <span class="menu-item-desc">60 min • Essential Oil Blend</span>
                            </div>
                            <span class="menu-item-price">$130</span>
                        </div>

                        <div class="menu-item">
                            <div>
                                <span class="menu-item-name">Hot Stone Grounding</span>
                                <span class="menu-item-desc">90 min • Basalt Stones & Heat</span>
                            </div>
                            <span class="menu-item-price">$180</span>
                        </div>
                    </div>
                </div>

                <div class="reveal">
                    <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Spa Product" style="height: 300px; margin-bottom: 50px;">

                    <div class="menu-category">
                        <h3>Hair Studio</h3>

                        <div class="menu-item">
                            <div>
                                <span class="menu-item-name">Botanical Cut & Style</span>
                                <span class="menu-item-desc">Includes Scalp Massage</span>
                            </div>
                            <span class="menu-item-price">$95+</span>
                        </div>

                        <div class="menu-item">
                            <div>
                                <span class="menu-item-name">Organic Color Gloss</span>
                                <span class="menu-item-desc">Ammonia-Free Shine Treatment</span>
                            </div>
                            <span class="menu-item-price">$120+</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="gallery" class="section-padding">
        <div class="container">
            <div class="gallery-grid">
                <div class="gallery-item g-wide reveal">
                    <img src="https://images.unsplash.com/photo-1519823551278-64ac927ac4fb?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Pool">
                </div>
                <div class="gallery-item reveal">
                    <img src="https://images.unsplash.com/photo-1596178065248-208f3507b967?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Massage Oil">
                </div>
                <div class="gallery-item reveal">
                    <img src="https://images.unsplash.com/photo-1591343395082-e21b1e977ef8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Towel">
                </div>
                <div class="gallery-item reveal">
                    <img src="https://images.unsplash.com/photo-1552693673-1bf958298935?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Interior">
                </div>
                <div class="gallery-item g-wide reveal">
                    <img src="https://images.unsplash.com/photo-1600334089648-b0d9d3028eb2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Relaxation Room">
                </div>
                <div class="gallery-item reveal">
                    <img src="https://images.unsplash.com/photo-1515377905703-c4788e51af15?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Detail">
                </div>
            </div>
        </div>
    </section>

    <section id="reviews" class="section-padding" style="background: var(--bg-surface);">
        <div class="container testimonial-slider reveal">
            <div class="quote-icon"><i class="fas fa-quote-left"></i></div>
            <p class="review-text">"I walked in feeling the weight of the world, and walked out floating. The attention to detail, from the scent of the towels to the tea served after, is simply unmatched."</p>
            <div class="reviewer">— Sophia M.</div>
        </div>
    </section>

    <div style="background-image: url('https://images.unsplash.com/photo-1515377905703-c4788e51af15?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80'); height: 400px; background-attachment: fixed; background-size: cover;"></div>

    <section id="book" style="background: var(--bg-body); padding-bottom: 100px;">
        <div class="container">
            <div class="booking-wrapper reveal">
                <div class="center-text" style="margin-bottom: 50px;">
                    <h2>Reserve Your <span class="italic">Moment</span></h2>
                    <p>Select your preferred time and treatment below.</p>
                </div>

                <form id="bookingForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-input" placeholder="Your Name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-input" placeholder="email@address.com" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Treatment</label>
                            <select class="form-input">
                                <option>Facial Therapy</option>
                                <option>Massage</option>
                                <option>Hair Styling</option>
                                <option>Full Day Package</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-input" required>
                        </div>
                    </div>

                    <div style="text-align: center; margin-top: 40px;">
                        <button type="submit" class="btn btn-fill">Confirm Request</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="logo" style="color: #fff; margin-bottom: 20px;">Serenité.</div>
                    <p style="color: rgba(255,255,255,0.6);">An urban sanctuary dedicated to the restoration of body, mind, and spirit.</p>
                </div>

                <div>
                    <h4>Visit</h4>
                    <p>1240 Highland Ave,<br>Los Angeles, CA 90028</p>
                    <p>Mon-Sat: 9am - 7pm<br>Sun: 10am - 5pm</p>
                </div>

                <div>
                    <h4>Contact</h4>
                    <p>+1 (555) 234-5678<br>hello@serenitespa.com</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-pinterest"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>

                <div>
                    <h4>Newsletter</h4>
                    <form style="margin-top: 15px;">
                        <input type="email" placeholder="Email Address" style="background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.3); padding: 10px 0; color: #fff; width: 100%; outline: none; font-family: var(--font-body);">
                        <button type="button" style="background: transparent; border: none; color: #fff; text-transform: uppercase; letter-spacing: 1px; font-size: 0.7rem; margin-top: 10px; cursor: pointer;">Subscribe</button>
                    </form>
                </div>
            </div>

            <div class="copyright">
                &copy; <?php echo date("Y"); ?> Serenité Wellness. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // 1. Navbar Scroll Effect
            const navbar = document.querySelector('.navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });

            // 2. Reveal Animation
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            // 3. Form Handling
            const form = document.getElementById('bookingForm');
            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const btn = form.querySelector('button');
                    const originalText = btn.innerText;

                    btn.innerText = 'Processing...';
                    btn.style.opacity = '0.7';

                    setTimeout(() => {
                        btn.innerText = 'Request Sent';
                        btn.style.backgroundColor = '#4a5d4e'; // Green
                        btn.style.color = '#fff';
                        btn.style.borderColor = '#4a5d4e';
                        form.reset();

                        setTimeout(() => {
                            btn.innerText = originalText;
                            btn.style.backgroundColor = '';
                            btn.style.color = '';
                            btn.style.borderColor = '';
                            btn.style.opacity = '1';
                        }, 3000);
                    }, 1500);
                });
            }
        });
    </script>
</body>

</html>
