document.addEventListener("DOMContentLoaded", () => {
    
    // 1. Remove Preloader
    const preloader = document.querySelector('.preloader');
    setTimeout(() => {
        preloader.classList.add('hidden');
        document.body.classList.remove('loading');
    }, 1200);

    // 2. Navbar Scroll Effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // 3. Scroll Reveal Animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, { threshold: 0.15 });

    const revealElements = document.querySelectorAll('.reveal');
    revealElements.forEach(el => observer.observe(el));

    // 4. Parallax Hero Effect
    const heroBg = document.querySelector('.hero-bg img');
    if(heroBg) {
        window.addEventListener('scroll', () => {
            const scroll = window.scrollY;
            heroBg.style.transform = `translateY(${scroll * 0.4}px)`;
        });
    }
});