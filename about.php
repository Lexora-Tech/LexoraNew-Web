<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $pageTitle = "Lexora Tech | About Us";
    $pageDesc = "Meet the team behind the magic. Lexora Tech is a group of passionate developers and strategists innovating the future.";
    include "includes/head.php";
    ?>
    <style>
        /* --- Modern Team Section Styles (No Images) --- */
        
        .mil-team-card-modern {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 40px 20px;
            border-radius: 15px;
            text-align: center;
            transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            position: relative;
            overflow: hidden;
            height: 100%; /* Ensures equal height cards */
        }

        .mil-team-card-modern:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-10px);
            border-color: rgba(255, 180, 0, 0.3);
        }

        /* The Initials Circle */
        .mil-team-avatar-text {
            width: 100px;
            height: 100px;
            margin: 0 auto 25px;
            border-radius: 50%;
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            letter-spacing: 2px;
            transition: 0.4s ease;
            position: relative;
            z-index: 2;
        }

        /* Hover Effect on Avatar */
        .mil-team-card-modern:hover .mil-team-avatar-text {
            background: #ffb400;
            border-color: #ffb400;
            color: #000;
            box-shadow: 0 0 25px rgba(255, 180, 0, 0.4);
        }

        .mil-team-role {
            color: #ffb400; /* Accent color */
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 15px;
            display: block;
        }

        /* Social Icons Row */
        .mil-team-social {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            opacity: 0; /* Hidden by default */
            transform: translateY(10px);
            transition: 0.4s ease;
        }

        .mil-team-card-modern:hover .mil-team-social {
            opacity: 1;
            transform: translateY(0);
        }

        .mil-team-social a {
            color: #a2a2a2;
            font-size: 14px;
            transition: 0.3s;
        }

        .mil-team-social a:hover {
            color: #fff;
        }

    </style>

</head>

<body>

    <div id="smooth-wrapper" class="mil-page-wrapper">

        <div class="mil-cursor-follower"></div>
        <div class="mil-progress-track">
            <div class="mil-progress"></div>
        </div>
        <?php
        include "header.php";
        ?>
        <div class="mil-transition-fade" id="swup">
            <div class="mil-transition-frame">

                <div id="smooth-content" class="mil-content">

                    <div class="mil-hero-1 mil-sm-hero mil-stl mil-up" id="top">
                        <div class="mil-overlay"></div>
                        <div class="container mil-hero-main mil-relative mil-aic">
                            <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
                                <div class="mil-text-pad"></div>
                                <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                                    <li>
                                        <a href="index.php">Home</a>
                                    </li>
                                    <li>
                                        <a href="#.">About</a>
                                    </li>
                                </ul>
                                <h1 class="mil-display2 mil-rubber">Our <span class="mil-a2">Story</span></h1>
                            </div>
                        </div>
                    </div>

                    <div class="mil-p-0-100">
                        <div class="container">
                            <div class="row mil-aic mil-jcb">
                                <div class="col-lg-6 mil-mb60">
                                    <div class="mil-image-frame mil-up" style="border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80" alt="Lexora Tech Office" style="width: 100%; height: auto; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="col-lg-5 mil-mb60">
                                    <h2 class="mil-display3 mil-mb30 mil-up">Innovating the <br><span class="mil-a2">Future.</span></h2>
                                    <p class="mil-stylized mil-m1 mil-mb30 mil-up">
                                        Lexora Tech was founded with a singular mission: to bridge the gap between complex technology and human-centric design.
                                    </p>
                                    <p class="mil-text-sm mil-mb30 mil-up">
                                        We are a team of passionate developers, designers, and strategists based in Sri Lanka. We don't just build websites; we craft digital experiences that resonate with audiences and drive growth for our partners.
                                    </p>
                                    <div class="mil-up">
                                        <a href="contact.php" class="mil-btn mil-a2 mil-c-gone">Work With Us</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mil-p-0-100 mil-soft-bg">
                        <div class="container">
                            <h3 class="mil-display3 mil-tac mil-mb90 mil-up">Core <span class="mil-a2">Values</span></h3>
                            <div class="row mil-jcc">
                                <div class="col-sm-8 col-lg-4">
                                    <div class="mil-iconbox mil-tac mil-mb60">
                                        <i class="fal fa-layer-group mil-mb30 mil-up"></i>
                                        <h4 class="mil-head4 mil-mb30 mil-up">Innovation</h4>
                                        <p class="mil-text-sm mil-up">We constantly push boundaries to discover new solutions and technologies.</p>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-lg-4">
                                    <div class="mil-iconbox mil-tac mil-mb60">
                                        <i class="fal fa-gem mil-mb30 mil-up"></i>
                                        <h4 class="mil-head4 mil-mb30 mil-up">Quality</h4>
                                        <p class="mil-text-sm mil-up">Excellence is not an act, but a habit. We deliver pixel-perfect code.</p>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-lg-4">
                                    <div class="mil-iconbox mil-tac mil-mb60">
                                        <i class="fal fa-users mil-mb30 mil-up"></i>
                                        <h4 class="mil-head4 mil-mb30 mil-up">Transparency</h4>
                                        <p class="mil-text-sm mil-up">We build trust through open communication and honest collaboration.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

               <!--      <div class="mil-p-100-100">
                        <div class="container">
                            <div class="row mil-aic mil-mb90">
                                <div class="col-lg-6">
                                    <h2 class="mil-display3 mil-rubber mil-up">Meet the <span class="mil-a2">Team</span></h2>
                                </div>
                                <div class="col-lg-6 mil-jce mil-aic">
                                    <p class="mil-stylized mil-m1 mil-tar mil-up">The minds behind the magic.</p>
                                </div>
                            </div>

                            <div class="row mil-jcc">
                                
                                <div class="col-lg-3 col-md-4 col-sm-6 mil-mb30">
                                    <div class="mil-team-card-modern mil-up">
                                        <div class="mil-team-avatar-text">TS</div>
                                        <h5 class="mil-head5 mil-mb5">Theekshana Sudeepa</h5>
                                        <span class="mil-team-role">CEO / Lead Developer</span>
                                        <div class="mil-team-social">
                                            <a href="#."><i class="fab fa-linkedin-in"></i></a>
                                            <a href="#."><i class="fab fa-github"></i></a>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 mil-mb30">
                                    <div class="mil-team-card-modern mil-up">
                                        <div class="mil-team-avatar-text">PL</div>
                                        <h5 class="mil-head5 mil-mb5">Praveen Lakshan</h5>
                                        <span class="mil-team-role">CTO / Lead Developer</span>
                                        <div class="mil-team-social">
                                            <a href="#."><i class="fab fa-linkedin-in"></i></a>
                                            <a href="#."><i class="fab fa-github"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 mil-mb30">
                                    <div class="mil-team-card-modern mil-up">
                                        <div class="mil-team-avatar-text">IT</div>
                                        <h5 class="mil-head5 mil-mb5">Ivantha Thilakarathne</h5>
                                        <span class="mil-team-role">Marketing Manager</span>
                                        <div class="mil-team-social">
                                            <a href="#."><i class="fab fa-linkedin-in"></i></a>
                                            <a href="#."><i class="fab fa-github"></i></a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div> -->

                    <div class="mil-p-0-100">
                        <div class="container mil-tac">
                            <h2 class="mil-display3 mil-rubber mil-mb60 mil-up">Ready to start?</h2>
                            <div class="mil-up">
                                <a href="quote.php" class="mil-btn mil-a2 mil-c-gone">Get a Quote</a>
                            </div>
                        </div>
                    </div>
                    <?php
                    include "footer.php";
                    ?>
                    </div>
                </div>
        </div>
        </div>
    <script src="js/plugins/swup.min.js"></script>
    <script src="js/plugins/gsap.min.js"></script>
    <script src="js/plugins/ScrollSmoother.min.js"></script>
    <script src="js/plugins/ScrollTrigger.min.js"></script>
    <script src="js/plugins/ScrollTo.min.js"></script>
    <script src="js/plugins/swiper.min.js"></script>
    <script src="js/plugins/parallax.js"></script>

    <script src="js/main.js"></script>
</body>

</html>