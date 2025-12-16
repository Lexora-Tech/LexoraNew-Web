<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AURA | Avant-Garde Dining</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;400;600&family=Playfair+Display:ital,wght@0,400;1,400&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- 1. CORE VARIABLES --- */
        :root {
            --bg: #050505;
            --surface: #121212;
            --surface-hover: #1a1a1a;
            
            --text-main: #ffffff;
            --text-muted: #888888;
            
            --accent: #d1bfa7; /* Champagne Gold */
            --accent-glow: rgba(209, 191, 167, 0.15);
            
            --border: rgba(255, 255, 255, 0.08);
            
            --font-sans: 'Manrope', sans-serif;
            --font-serif: 'Playfair Display', serif;
            
            --ease: cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* --- 2. RESET & CURSOR --- */
        * { margin: 0; padding: 0; box-sizing: border-box; cursor: none; } /* Hide default cursor */
        
        html { scroll-behavior: smooth; }
        
        body {
            background-color: var(--bg);
            color: var(--text-main);
            font-family: var(--font-sans);
            font-weight: 300;
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Custom Cursor */
        .cursor-dot, .cursor-outline {
            position: fixed; top: 0; left: 0; transform: translate(-50%, -50%);
            border-radius: 50%; z-index: 9999; pointer-events: none;
        }
        .cursor-dot { width: 8px; height: 8px; background: white; }
        .cursor-outline {
            width: 40px; height: 40px; border: 1px solid rgba(255,255,255,0.5);
            transition: width 0.2s, height 0.2s, background-color 0.2s;
        }
        body:hover .cursor-outline { opacity: 1; }
        
        /* Hover State for Cursor */
        body.hovering .cursor-outline {
            width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-color: transparent;
            backdrop-filter: blur(2px);
        }

        /* Typography */
        h1, h2, h3 { font-family: var(--font-serif); font-weight: 400; color: #fff; line-height: 1.1; }
        h1 { font-size: clamp(4rem, 10vw, 8rem); letter-spacing: -0.02em; }
        h2 { font-size: clamp(2.5rem, 6vw, 4.5rem); margin-bottom: 20px; }
        h3 { font-family: var(--font-sans); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 3px; color: var(--accent); margin-bottom: 15px; }
        
        p { color: var(--text-muted); margin-bottom: 30px; font-size: 1.1rem; max-width: 600px; }
        .text-center { text-align: center; display: flex; flex-direction: column; align-items: center; }

        a { text-decoration: none; color: inherit; transition: 0.3s; }
        img { width: 100%; height: 100%; object-fit: cover; display: block; }
        ul { list-style: none; }

        .container { max-width: 1400px; margin: 0 auto; padding: 0 40px; }
        .section-padding { padding: 160px 0; }

        /* --- 3. UI ELEMENTS --- */
        
        /* Magnetic Button */
        .btn {
            display: inline-flex; align-items: center; justify-content: center;
            padding: 20px 40px; border: 1px solid rgba(255,255,255,0.2); border-radius: 100px;
            font-size: 0.85rem; text-transform: uppercase; letter-spacing: 2px; color: #fff;
            transition: all 0.4s var(--ease); background: transparent; position: relative; overflow: hidden;
        }
        .btn::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: #fff; transform: translateY(100%); transition: transform 0.4s var(--ease); z-index: -1;
        }
        .btn:hover { color: #000; border-color: #fff; }
        .btn:hover::before { transform: translateY(0); }

        /* Smooth Reveal Class */
        .reveal-text { opacity: 0; transform: translateY(40px); transition: 1.2s var(--ease); }
        .reveal-text.active { opacity: 1; transform: translateY(0); }

        /* --- 4. NAVIGATION (Minimal) --- */
        .navbar {
            position: fixed; top: 0; width: 100%; z-index: 100;
            padding: 40px; display: flex; justify-content: space-between; align-items: center;
            mix-blend-mode: difference; color: #fff;
        }
        .logo { font-family: var(--font-sans); font-weight: 600; font-size: 1.5rem; letter-spacing: 4px; }
        
        .nav-toggle {
            font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px; cursor: pointer;
            display: flex; align-items: center; gap: 10px;
        }
        .hamburger { width: 30px; height: 1px; background: #fff; position: relative; transition: 0.3s; }
        .hamburger::after { content: ''; position: absolute; top: 8px; right: 0; width: 20px; height: 1px; background: #fff; transition: 0.3s; }
        
        .nav-toggle:hover .hamburger { width: 25px; }
        .nav-toggle:hover .hamburger::after { width: 30px; }

        /* --- 5. HERO SECTION --- */
        .hero {
            height: 100vh; position: relative; display: flex; align-items: center; justify-content: center;
            overflow: hidden; text-align: center;
        }
        .hero-bg { position: absolute; inset: 0; z-index: -1; opacity: 0.4; }
        .hero-bg img { transform: scale(1.1); transition: transform 2s ease-out; }
        .hero:hover .hero-bg img { transform: scale(1); }
        
        .hero-content { position: relative; z-index: 2; mix-blend-mode: normal; }
        .hero-subtitle { display: block; font-size: 0.9rem; letter-spacing: 6px; text-transform: uppercase; margin-bottom: 20px; opacity: 0.8; }

        /* --- 6. ABOUT (Bento Grid) --- */
        .bento-section { background: var(--bg); }
        .bento-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); grid-template-rows: 400px 300px;
            gap: 20px;
        }
        .bento-card {
            background: var(--surface); border: 1px solid var(--border); border-radius: 4px;
            padding: 40px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between;
            transition: 0.5s var(--ease);
        }
        .bento-card:hover { border-color: rgba(255,255,255,0.2); background: var(--surface-hover); }
        
        /* Layout modifications */
        .card-lg { grid-column: span 2; }
        .card-img { padding: 0; }
        .card-img img { transition: 0.7s var(--ease); opacity: 0.7; }
        .card-img:hover img { transform: scale(1.05); opacity: 1; }
        
        .bento-text h4 { font-family: var(--font-serif); font-size: 2rem; margin-bottom: 10px; }
        .bento-text span { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: var(--accent); }

        /* --- 7. MENU (Horizontal Scroll) --- */
        .menu-section { overflow: hidden; border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
        .menu-scroll-container {
            display: flex; gap: 80px; padding: 0 40px; overflow-x: auto;
            scrollbar-width: none; cursor: grab;
        }
        .menu-scroll-container::-webkit-scrollbar { display: none; }
        
        .menu-group { min-width: 400px; padding: 100px 0; border-right: 1px solid var(--border); padding-right: 80px; }
        .menu-group:last-child { border: none; }
        
        .menu-title { font-size: 3rem; font-family: var(--font-serif); margin-bottom: 40px; color: var(--accent); opacity: 0.5; }
        
        .dish { display: flex; justify-content: space-between; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 15px; transition: 0.3s; }
        .dish:hover { padding-left: 10px; border-bottom-color: var(--accent); }
        .dish-name { font-size: 1.2rem; }
        .dish-price { font-family: var(--font-serif); color: var(--text-muted); }
        .dish-desc { display: block; font-size: 0.9rem; color: var(--text-muted); margin-top: 5px; }

        /* --- 8. RESERVATION (Floating) --- */
        .res-section { position: relative; height: 90vh; display: flex; align-items: center; justify-content: center; }
        .res-bg { position: absolute; inset: 0; z-index: -1; }
        .res-bg img { opacity: 0.2; }
        
        .res-modal {
            background: rgba(18, 18, 18, 0.8); backdrop-filter: blur(20px);
            padding: 80px; border: 1px solid var(--border); text-align: center;
            max-width: 600px; width: 100%;
        }
        
        .input-group { position: relative; margin-bottom: 40px; }
        .input-field {
            width: 100%; background: transparent; border: none; border-bottom: 1px solid rgba(255,255,255,0.3);
            padding: 15px 0; color: #fff; font-size: 1.2rem; outline: none; font-family: var(--font-serif); text-align: center;
            transition: 0.3s;
        }
        .input-field:focus { border-color: var(--accent); }
        .input-field::placeholder { color: rgba(255,255,255,0.2); }

        /* --- 9. FOOTER --- */
        .footer { padding: 80px 40px; border-top: 1px solid var(--border); display: flex; justify-content: space-between; align-items: flex-end; }
        .footer-brand { font-size: 8rem; font-family: var(--font-serif); line-height: 0.8; opacity: 0.1; }
        .footer-links { text-align: right; }
        .footer-links a { display: block; margin-bottom: 10px; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); }
        .footer-links a:hover { color: #fff; }

        /* --- RESPONSIVE --- */
        @media (max-width: 900px) {
            .navbar { padding: 20px; }
            h1 { font-size: 3.5rem; }
            .bento-grid { grid-template-columns: 1fr; grid-template-rows: auto; }
            .card-lg { grid-column: span 1; }
            .bento-card { min-height: 300px; }
            .menu-scroll-container { flex-direction: column; gap: 0; }
            .menu-group { min-width: 100%; border: none; padding: 40px 0; border-bottom: 1px solid var(--border); }
            .res-modal { padding: 40px 20px; width: 90%; }
            .footer { flex-direction: column; align-items: center; text-align: center; gap: 40px; }
            .footer-links { text-align: center; }
            .footer-brand { font-size: 4rem; }
        }
    </style>
</head>
<body>

    <div class="cursor-dot" id="cursor-dot"></div>
    <div class="cursor-outline" id="cursor-outline"></div>

    <nav class="navbar">
        <a href="#" class="logo hover-trigger">AURA</a>
        <div class="nav-toggle hover-trigger">
            <span>Menu</span>
            <div class="hamburger"></div>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-bg">
            <img src="https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
                 alt="Fine Dining Atmosphere"
                 onerror="this.src='https://placehold.co/1920x1080/050505/333?text=Aura'">
        </div>
        
        <div class="hero-content">
            <span class="hero-subtitle reveal-text">Culinary Architecture</span>
            <h1 class="reveal-text">Sensory<br>Elegance</h1>
            <div style="margin-top: 50px;" class="reveal-text">
                <a href="#reserve" class="btn hover-trigger">Reserve Table</a>
            </div>
        </div>
    </header>

    <section class="section-padding bento-section">
        <div class="container">
            <div class="text-center" style="margin-bottom: 80px;">
                <h3>The Experience</h3>
                <h2>Art on a Plate</h2>
            </div>

            <div class="bento-grid">
                <div class="bento-card bento-text reveal-text">
                    <span>Philosophy</span>
                    <p style="margin-top: 20px;">We deconstruct traditional cuisine to create something entirely new. A symphony of texture, temperature, and taste.</p>
                    <a href="#" style="margin-top: auto; border-bottom: 1px solid var(--accent); width: max-content; padding-bottom: 5px;">Read Manifesto</a>
                </div>

                <div class="bento-card card-lg card-img reveal-text">
                    <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" 
                         alt="Plating" onerror="this.src='https://placehold.co/800x600/1a1a1a/444?text=Plating'">
                </div>

                <div class="bento-card card-img reveal-text">
                    <img src="https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Wine" onerror="this.src='https://placehold.co/600x600/1a1a1a/444?text=Wine'">
                </div>

                <div class="bento-card card-lg bento-text reveal-text">
                    <span>Sourcing</span>
                    <h4>Local Roots,<br>Global Inspiration.</h4>
                    <p style="margin: 0;">Our ingredients are sourced within 50 miles, yet our techniques traverse the globe.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="menu-section">
        <div class="menu-scroll-container hover-trigger" id="menuContainer">
            
            <div class="menu-group">
                <div class="menu-title">First</div>
                <div class="dish">
                    <div>
                        <div class="dish-name">Oyster Pearl</div>
                        <span class="dish-desc">Champagne foam, cucumber caviar.</span>
                    </div>
                    <div class="dish-price">24</div>
                </div>
                <div class="dish">
                    <div>
                        <div class="dish-name">Wagyu Carpaccio</div>
                        <span class="dish-desc">Truffle emulsion, parmesan crisp.</span>
                    </div>
                    <div class="dish-price">32</div>
                </div>
                <div class="dish">
                    <div>
                        <div class="dish-name">Forest Mushroom</div>
                        <span class="dish-desc">Pine needle smoke, soil.</span>
                    </div>
                    <div class="dish-price">28</div>
                </div>
            </div>

            <div class="menu-group">
                <div class="menu-title">Main</div>
                <div class="dish">
                    <div>
                        <div class="dish-name">Black Cod</div>
                        <span class="dish-desc">Miso glaze, charred leek.</span>
                    </div>
                    <div class="dish-price">48</div>
                </div>
                <div class="dish">
                    <div>
                        <div class="dish-name">Duck Breast</div>
                        <span class="dish-desc">Cherry reduction, parsnip puree.</span>
                    </div>
                    <div class="dish-price">52</div>
                </div>
                <div class="dish">
                    <div>
                        <div class="dish-name">Venison Loin</div>
                        <span class="dish-desc">Juniper berry, chocolate jus.</span>
                    </div>
                    <div class="dish-price">58</div>
                </div>
            </div>

            <div class="menu-group">
                <div class="menu-title">Sweet</div>
                <div class="dish">
                    <div>
                        <div class="dish-name">Gold Sphere</div>
                        <span class="dish-desc">Dark chocolate, gold leaf, raspberry.</span>
                    </div>
                    <div class="dish-price">22</div>
                </div>
                <div class="dish">
                    <div>
                        <div class="dish-name">Texture of Lemon</div>
                        <span class="dish-desc">Curd, foam, sorbet, dehydrated.</span>
                    </div>
                    <div class="dish-price">20</div>
                </div>
            </div>

        </div>
    </section>

    <section id="reserve" class="res-section">
        <div class="res-bg">
            <img src="https://images.unsplash.com/photo-1550966871-3ed3c47e2ce2?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" 
                 alt="Atmosphere" onerror="this.src='https://placehold.co/1920x1080/000/fff?text=Dark'">
        </div>
        
        <div class="res-modal reveal-text">
            <h3>Reservations</h3>
            <h2>Secure Your Seat</h2>
            
            <form id="resForm" style="margin-top: 50px;">
                <div class="input-group">
                    <input type="text" class="input-field hover-trigger" placeholder="Name" required>
                </div>
                <div class="input-group">
                    <input type="date" class="input-field hover-trigger" required>
                </div>
                <div class="input-group">
                    <select class="input-field hover-trigger" style="color: #888;">
                        <option>2 Guests</option>
                        <option>4 Guests</option>
                        <option>6 Guests</option>
                    </select>
                </div>
                <button type="submit" class="btn hover-trigger" style="width: 100%;">Confirm Booking</button>
            </form>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-brand">AURA</div>
        <div class="footer-links">
            <a href="#" class="hover-trigger">Instagram</a>
            <a href="#" class="hover-trigger">Opentable</a>
            <a href="#" class="hover-trigger">Contact</a>
            <p style="margin-top: 20px; font-size: 0.8rem; color: #444;">&copy; 2025 AURA Dining Group.</p>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            
            // 1. Custom Cursor Logic
            const cursorDot = document.getElementById("cursor-dot");
            const cursorOutline = document.getElementById("cursor-outline");

            window.addEventListener("mousemove", (e) => {
                const posX = e.clientX;
                const posY = e.clientY;

                // Dot follows instantly
                cursorDot.style.left = `${posX}px`;
                cursorDot.style.top = `${posY}px`;

                // Outline follows with delay (animation)
                cursorOutline.animate({
                    left: `${posX}px`,
                    top: `${posY}px`
                }, { duration: 500, fill: "forwards" });
            });

            // Hover interactions
            const hoverTargets = document.querySelectorAll(".hover-trigger, a, button");
            hoverTargets.forEach(el => {
                el.addEventListener("mouseenter", () => document.body.classList.add("hovering"));
                el.addEventListener("mouseleave", () => document.body.classList.remove("hovering"));
            });

            // 2. Horizontal Scroll for Menu (Drag to scroll)
            const slider = document.getElementById('menuContainer');
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                slider.style.cursor = 'grabbing';
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });
            slider.addEventListener('mouseleave', () => { isDown = false; slider.style.cursor = 'grab'; });
            slider.addEventListener('mouseup', () => { isDown = false; slider.style.cursor = 'grab'; });
            slider.addEventListener('mousemove', (e) => {
                if(!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2; // Scroll-fast
                slider.scrollLeft = scrollLeft - walk;
            });

            // 3. Reveal Animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.reveal-text').forEach(el => observer.observe(el));

            // 4. Form Submit
            const form = document.getElementById('resForm');
            if(form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const btn = form.querySelector('button');
                    const original = btn.innerText;
                    btn.innerText = "Requesting...";
                    btn.style.borderColor = "var(--accent)";
                    btn.style.color = "var(--accent)";
                    
                    setTimeout(() => {
                        btn.innerText = "Confirmed";
                        btn.style.background = "#fff";
                        btn.style.color = "#000";
                        form.reset();
                        setTimeout(() => {
                            btn.innerText = original;
                            btn.style.background = "transparent";
                            btn.style.color = "#fff";
                            btn.style.borderColor = "rgba(255,255,255,0.2)";
                        }, 3000);
                    }, 1500);
                });
            }
        });
    </script>
</body>
</html>