<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $pageTitle = "Lexora Tech | Request Received";
    $pageDesc = "Thank you for contacting Lexora Tech. We have received your request and will get back to you shortly.";
    include "includes/head.php";
    ?>

    <style>
        /* --- Success Animation Styles --- */
        .mil-success-container {
            min-height: 60vh; /* Ensures it takes up enough space */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 100px 0;
        }

        .mil-success-icon-box {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255, 180, 0, 0.1); /* Low opacity gold */
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
            border: 1px solid #ffb400;
        }

        .mil-success-icon-box i {
            font-size: 40px;
            color: #ffb400;
        }

        /* Pulse Animation */
        .mil-success-icon-box::before,
        .mil-success-icon-box::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border-radius: 50%;
            border: 1px solid #ffb400;
            width: 100%;
            height: 100%;
            animation: mil-pulse 2s infinite;
        }

        .mil-success-icon-box::after {
            animation-delay: 0.5s;
        }

        @keyframes mil-pulse {
            0% {
                width: 100%;
                height: 100%;
                opacity: 1;
            }
            100% {
                width: 180%;
                height: 180%;
                opacity: 0;
            }
        }
    </style>

</head>

<body>

    <div id="smooth-wrapper" class="mil-page-wrapper">

        <div class="mil-cursor-follower"></div>

        <div class="mil-progress-track">
            <div class="mil-progress"></div>
        </div>

        <?php include "header.php"; ?>
        <div class="mil-transition-fade" id="swup">
            <div class="mil-transition-frame">

                <div id="smooth-content" class="mil-content">

                    <div class="mil-p-0-100" style="padding-top: 160px;"> <div class="container">
                            <div class="mil-success-container">
                                
                                <div class="mil-success-icon-box mil-up">
                                    <i class="fas fa-check"></i>
                                </div>

                                <h1 class="mil-display2 mil-rubber mil-mb30 mil-up">Request <span class="mil-a2">Received</span></h1>
                                
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <p class="mil-text-lg mil-mb30 mil-up">
                                            Thank You For Choosing Lexora Tech. Your Project Details Have Been Securely Transmitted To Our Team.
                                        </p>
                                        <p class="mil-text-sm mil-mb60 mil-up" style="opacity: 0.6;">
                                            We Are Currently Reviewing Your Requirements And Will Respond With A Preliminary Proposal Or Follow-Up Questions <strong>Within 24 Hours</strong>.
                                        </p>
                                    </div>
                                </div>

                                <div class="mil-up">
                                    <a href="index.php" class="mil-btn mil-a2 mil-mr15">Back to Home</a>
                                    <a href="portfolio.php" class="mil-btn mil-btn-border">View Our Work</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <?php include "footer.php"; ?>
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