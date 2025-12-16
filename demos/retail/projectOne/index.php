<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VELOUR | Modern Retail</title>

    <link href="https://api.fontshare.com/v2/css?f[]=clash-display@400,500,600,700&f[]=general-sans@300,400,500,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- 1. DESIGN SYSTEM --- */
        :root {
            --bg: #ffffff;
            --text: #000000;
            --accent: #2a2a2a;
            --gray: #f4f4f4;
            --border: #e5e5e5;

            --font-head: 'Clash Display', sans-serif;
            --font-body: 'General Sans', sans-serif;

            --ease: cubic-bezier(0.22, 1, 0.36, 1);
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
            background-color: var(--bg);
            color: var(--text);
            font-family: var(--font-body);
            font-size: 16px;
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* Typography */
        h1,
        h2,
        h3,
        h4 {
            font-family: var(--font-head);
            font-weight: 600;
            line-height: 1;
            text-transform: uppercase;
        }

        h1 {
            font-size: clamp(3rem, 10vw, 8rem);
        }

        h2 {
            font-size: clamp(2rem, 5vw, 4rem);
        }

        a {
            text-decoration: none;
            color: inherit;
            transition: 0.3s;
        }

        ul {
            list-style: none;
        }

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .section-padding {
            padding: 100px 0;
        }

        .flex-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* --- 2. BUTTONS --- */
        .btn {
            display: inline-block;
            padding: 16px 32px;
            background: #000;
            color: #fff;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            border: 1px solid #000;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #fff;
            color: #000;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #fff;
            color: #fff;
        }

        .btn-outline:hover {
            background: #fff;
            color: #000;
        }

        /* --- 3. NAVIGATION --- */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            padding: 20px 40px;
            background: #fff;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }

        .logo {
            font-family: var(--font-head);
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            gap: 40px;
        }

        .nav-link {
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .nav-link:hover {
            text-decoration: underline;
            text-underline-offset: 5px;
        }

        .nav-icons {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .icon-btn {
            font-size: 1.2rem;
            cursor: pointer;
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -8px;
            background: #000;
            color: #fff;
            width: 16px;
            height: 16px;
            font-size: 0.6rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-body);
        }

        /* --- 4. HERO SECTION --- */
        .hero {
            height: 90vh;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin-top: 80px;
            /* Offset for fixed header */
        }

        .hero-video {
            position: absolute;
            inset: 0;
            z-index: -1;
            filter: brightness(0.8);
        }

        .hero-video img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-content {
            text-align: center;
            color: #fff;
            z-index: 2;
            mix-blend-mode: difference;
        }

        .hero-content h1 {
            margin-bottom: 20px;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* --- 5. MARQUEE --- */
        .marquee {
            background: #000;
            color: #fff;
            padding: 15px 0;
            overflow: hidden;
            white-space: nowrap;
        }

        .marquee-content {
            display: inline-block;
            animation: scroll 20s linear infinite;
        }

        .marquee span {
            margin-right: 50px;
            font-family: var(--font-head);
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        @keyframes scroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* --- 6. CATEGORIES (Mosaic) --- */
        .cat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2px;
            background: #fff;
            border-bottom: 1px solid #000;
        }

        .cat-item {
            position: relative;
            height: 600px;
            overflow: hidden;
            group: cat;
            cursor: pointer;
        }

        .cat-item img {
            transition: 0.6s var(--ease);
        }

        .cat-item:hover img {
            transform: scale(1.05);
        }

        .cat-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: flex-end;
            padding: 40px;
            transition: 0.3s;
        }

        .cat-item:hover .cat-overlay {
            background: rgba(0, 0, 0, 0.3);
        }

        .cat-title {
            color: #fff;
            font-size: 2.5rem;
        }

        /* --- 7. PRODUCT SLIDER/GRID --- */
        .products-header {
            margin-bottom: 60px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px 20px;
        }

        .product-card {
            cursor: pointer;
        }

        .p-img-box {
            position: relative;
            height: 450px;
            overflow: hidden;
            margin-bottom: 20px;
            background: var(--gray);
        }

        .p-img-front {
            position: absolute;
            inset: 0;
            z-index: 1;
            transition: opacity 0.3s;
        }

        .p-img-back {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .product-card:hover .p-img-front {
            opacity: 0;
        }

        /* Show back image on hover */

        .p-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #fff;
            padding: 4px 10px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            z-index: 2;
        }

        .add-btn {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #000;
            color: #fff;
            padding: 15px;
            text-align: center;
            text-transform: uppercase;
            font-size: 0.8rem;
            font-weight: 600;
            transform: translateY(100%);
            transition: 0.3s var(--ease);
            z-index: 2;
            border: none;
            cursor: pointer;
        }

        .product-card:hover .add-btn {
            transform: translateY(0);
        }

        .p-info h3 {
            font-size: 1rem;
            margin-bottom: 5px;
            font-family: var(--font-body);
        }

        .p-price {
            font-weight: 600;
            font-size: 0.95rem;
        }

        /* --- 8. LOOKBOOK --- */
        .lookbook {
            background: var(--gray);
            padding: 100px 0;
        }

        .lookbook-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .look-content h2 {
            margin-bottom: 30px;
            font-size: 3.5rem;
        }

        .look-content p {
            max-width: 500px;
            margin-bottom: 40px;
            color: #555;
        }

        /* --- 9. CART SIDEBAR (Functional UI) --- */
        .cart-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 998;
            opacity: 0;
            pointer-events: none;
            transition: 0.3s;
        }

        .cart-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 450px;
            height: 100%;
            background: #fff;
            z-index: 999;
            transform: translateX(100%);
            transition: 0.4s var(--ease);
            display: flex;
            flex-direction: column;
        }

        .cart-open .cart-overlay {
            opacity: 1;
            pointer-events: auto;
        }

        .cart-open .cart-sidebar {
            transform: translateX(0);
        }

        .cart-header {
            padding: 30px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-body {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
        }

        .cart-footer {
            padding: 30px;
            border-top: 1px solid var(--border);
            background: var(--gray);
        }

        .cart-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .cart-img {
            width: 80px;
            height: 100px;
            background: #ddd;
        }

        .cart-details {
            flex: 1;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            font-family: var(--font-head);
            margin-bottom: 20px;
        }

        /* --- 10. FOOTER --- */
        .footer {
            background: #000;
            color: #fff;
            padding: 80px 40px 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        .f-col h4 {
            font-size: 0.9rem;
            margin-bottom: 20px;
            color: #888;
        }

        .f-col a {
            display: block;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .f-col a:hover {
            color: #888;
        }

        .newsletter-form {
            display: flex;
            border-bottom: 1px solid #fff;
            padding-bottom: 10px;
            margin-top: 20px;
        }

        .newsletter-form input {
            background: transparent;
            border: none;
            color: #fff;
            width: 100%;
            outline: none;
        }

        .newsletter-form button {
            background: transparent;
            border: none;
            color: #fff;
            text-transform: uppercase;
            cursor: pointer;
            font-size: 0.8rem;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 1024px) {
            .navbar {
                padding: 20px;
            }

            .nav-links {
                display: none;
            }

            .cat-grid {
                grid-template-columns: 1fr;
            }

            .product-grid {
                grid-template-columns: 1fr 1fr;
            }

            .lookbook-grid {
                grid-template-columns: 1fr;
            }

            .cart-sidebar {
                width: 100%;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="#" class="logo">VELOUR.</a>

        <ul class="nav-links">
            <li><a href="#new" class="nav-link">New Arrivals</a></li>
            <li><a href="#men" class="nav-link">Men</a></li>
            <li><a href="#women" class="nav-link">Women</a></li>
            <li><a href="#journal" class="nav-link">Editorial</a></li>
        </ul>

        <div class="nav-icons">
            <div class="icon-btn"><i class="fas fa-search"></i></div>
            <div class="icon-btn"><i class="far fa-user"></i></div>
            <div class="icon-btn" onclick="toggleCart()">
                <i class="fas fa-shopping-bag"></i>
                <span class="cart-count" id="cartCount">0</span>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="hero-video">
            <img src="https://images.unsplash.com/photo-1496747611176-843222e1e57c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80" alt="Fashion Campaign">
        </div>
        <div class="hero-content">
            <h1>The Autumn <br>Collection</h1>
            <p>Elevated Essentials for the Modern Era</p>
            <a href="#shop" class="btn btn-outline">Explore Campaign</a>
        </div>
    </header>

    <div class="marquee">
        <div class="marquee-content">
            <span>Free Worldwide Shipping on Orders Over $200</span>
            <span> • </span>
            <span>New Arrivals Dropping Every Friday</span>
            <span> • </span>
            <span>Velour x Designer Collaboration Coming Soon</span>
            <span> • </span>
            <span>Free Worldwide Shipping on Orders Over $200</span>
            <span> • </span>
            <span>New Arrivals Dropping Every Friday</span>
            <span> • </span>
        </div>
    </div>

    <section class="cat-grid">
        <div class="cat-item">
            <img src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Women">
            <div class="cat-overlay">
                <h2 class="cat-title">Womenswear</h2>
            </div>
        </div>
        <div class="cat-item">
            <img src="https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Men">
            <div class="cat-overlay">
                <h2 class="cat-title">Menswear</h2>
            </div>
        </div>
    </section>

    <section id="shop" class="section-padding">
        <div class="container">
            <div class="products-header">
                <h2>New Arrivals</h2>
                <a href="#" style="text-transform: uppercase; border-bottom: 1px solid #000; font-size: 0.8rem;">View All Products</a>
            </div>

            <div class="product-grid" id="productContainer">
            </div>
        </div>
    </section>

    <section class="lookbook">
        <div class="container lookbook-grid">
            <div class="look-img">
                <img src="https://images.unsplash.com/photo-1509631179647-0177331693ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Lookbook" style="height: 700px;">
            </div>
            <div class="look-content">
                <span>The Journal</span>
                <h2>Minimalism <br>Redefined.</h2>
                <p>Discover the philosophy behind our latest collection. Focused on clean lines, sustainable fabrics, and timeless silhouettes that transcend seasons.</p>
                <a href="#" class="btn">Read the Story</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="footer-grid">
            <div class="f-col">
                <a href="#" class="logo" style="color: #fff; margin-bottom: 20px; display: block;">VELOUR.</a>
                <p style="color: #888; margin-bottom: 20px;">Redefining luxury retail through digital innovation.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Subscribe to our newsletter">
                    <button>Join</button>
                </form>
            </div>
            <div class="f-col">
                <h4>Shop</h4>
                <a href="#">New Arrivals</a>
                <a href="#">Men</a>
                <a href="#">Women</a>
                <a href="#">Accessories</a>
            </div>
            <div class="f-col">
                <h4>Customer</h4>
                <a href="#">Shipping & Returns</a>
                <a href="#">FAQ</a>
                <a href="#">Size Guide</a>
                <a href="#">Track Order</a>
            </div>
            <div class="f-col">
                <h4>Social</h4>
                <a href="#">Instagram</a>
                <a href="#">TikTok</a>
                <a href="#">Pinterest</a>
            </div>
        </div>
        <div style="border-top: 1px solid #333; padding-top: 20px; display: flex; justify-content: space-between; color: #555; font-size: 0.8rem;">
            <span>&copy; 2025 VELOUR Retail.</span>
            <span>Privacy Policy &nbsp; Terms</span>
        </div>
    </footer>

    <div class="cart-overlay" onclick="toggleCart()"></div>
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3>Your Cart (<span id="cartHeaderCount">0</span>)</h3>
            <span style="cursor: pointer; font-size: 1.5rem;" onclick="toggleCart()">&times;</span>
        </div>
        <div class="cart-body" id="cartItems">
            <p style="text-align: center; color: #888; margin-top: 50px;">Your cart is empty.</p>
        </div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total</span>
                <span id="cartTotal">$0.00</span>
            </div>
            <button class="btn" style="width: 100%; text-align: center;">Checkout</button>
        </div>
    </div>

    <script>
        // --- 1. DATA ---
        const products = [{
                id: 1,
                name: "Oversized Wool Coat",
                price: 280,
                img1: "https://images.unsplash.com/photo-1539008835657-9e8e9680c956?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                img2: "https://images.unsplash.com/photo-1539109136881-3be0616acf4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                badge: "New"
            },
            {
                id: 2,
                name: "Structured Blazer",
                price: 195,
                img1: "https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                img2: "https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                badge: "Best Seller"
            },
            {
                id: 3,
                name: "Cashmere Sweater",
                price: 150,
                img1: "https://images.unsplash.com/photo-1576566588028-4147f3842f27?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                img2: "https://images.unsplash.com/photo-1576871337622-98d48d1cf531?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                badge: ""
            },
            {
                id: 4,
                name: "Pleated Trousers",
                price: 120,
                img1: "https://images.unsplash.com/photo-1509551388413-e18d0ac5d495?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                img2: "https://images.unsplash.com/photo-1483985988355-763728e1935b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                badge: "Sale"
            },
            {
                id: 5,
                name: "Leather Tote",
                price: 350,
                img1: "https://images.unsplash.com/photo-1584917865442-de89df76afd3?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                img2: "https://images.unsplash.com/photo-1590874103328-987348d731db?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                badge: ""
            },
            {
                id: 6,
                name: "Chelsea Boots",
                price: 210,
                img1: "https://images.unsplash.com/photo-1638247025967-b4e38f787b76?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                img2: "https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                badge: ""
            },
            {
                id: 7,
                name: "Silk Scarf",
                price: 85,
                img1: "https://images.unsplash.com/photo-1586363104862-3a5e2ab60d99?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                img2: "https://images.unsplash.com/photo-1601924994987-69e26d50dc26?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                badge: ""
            },
            {
                id: 8,
                name: "Denim Jacket",
                price: 140,
                img1: "https://images.unsplash.com/photo-1544642899-f0d6e5f6ed6f?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                img2: "https://images.unsplash.com/photo-1516257984-b1b4d8c9430b?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80",
                badge: ""
            }
        ];

        let cart = [];

        // --- 2. RENDER PRODUCTS ---
        const productContainer = document.getElementById('productContainer');

        function renderProducts() {
            productContainer.innerHTML = '';
            products.forEach(p => {
                const card = document.createElement('div');
                card.className = 'product-card';
                card.innerHTML = `
                    <div class="p-img-box">
                        ${p.badge ? `<span class="p-badge">${p.badge}</span>` : ''}
                        <img src="${p.img1}" class="p-img-front" alt="${p.name}">
                        <img src="${p.img2}" class="p-img-back" alt="${p.name}">
                        <button class="add-btn" onclick="addToCart(${p.id})">Add to Cart - $${p.price}</button>
                    </div>
                    <div class="p-info">
                        <h3>${p.name}</h3>
                        <span class="p-price">$${p.price}.00</span>
                    </div>
                `;
                productContainer.appendChild(card);
            });
        }

        // --- 3. CART LOGIC ---
        function addToCart(id) {
            const product = products.find(p => p.id === id);
            cart.push(product);
            updateCart();
            toggleCart(); // Open cart automatically
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCart();
        }

        function updateCart() {
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const cartHeaderCount = document.getElementById('cartHeaderCount');
            const cartTotal = document.getElementById('cartTotal');

            // Update Counts
            cartCount.innerText = cart.length;
            cartHeaderCount.innerText = cart.length;

            // Calc Total
            let total = cart.reduce((sum, item) => sum + item.price, 0);
            cartTotal.innerText = `$${total.toFixed(2)}`;

            // Render Items
            cartItems.innerHTML = '';
            if (cart.length === 0) {
                cartItems.innerHTML = '<p style="text-align: center; color: #888; margin-top: 50px;">Your cart is empty.</p>';
            } else {
                cart.forEach((item, index) => {
                    const el = document.createElement('div');
                    el.className = 'cart-item';
                    el.innerHTML = `
                        <div class="cart-img" style="background-image: url('${item.img1}'); background-size: cover;"></div>
                        <div class="cart-details">
                            <div style="display:flex; justify-content:space-between;">
                                <h4 style="font-size:0.9rem;">${item.name}</h4>
                                <span style="cursor:pointer;" onclick="removeFromCart(${index})">&times;</span>
                            </div>
                            <p style="color:#888; font-size:0.8rem;">$${item.price}.00</p>
                            <p style="color:#888; font-size:0.8rem; margin-top:5px;">Size: M</p>
                        </div>
                    `;
                    cartItems.appendChild(el);
                });
            }
        }

        function toggleCart() {
            document.body.classList.toggle('cart-open');
        }

        // --- 4. INIT ---
        renderProducts();

        // Navbar Scroll
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.style.padding = '15px 40px';
            } else {
                navbar.style.padding = '20px 40px';
            }
        });
    </script>
</body>

</html> 
