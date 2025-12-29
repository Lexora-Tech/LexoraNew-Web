<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    $pageTitle = "Lexora Tech | Start a Project";
    $pageDesc = "Ready to build something great? Request a quote for your Web Development, Mobile App, or POS System project today.";
    include "includes/head.php";
    ?>
    <link rel="stylesheet" href="css/quote.css">
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

            <link rel="stylesheet" href="css/quote.css">

                <div id="smooth-content" class="mil-content">

                    <div class="mil-hero-1 mil-sm-hero mil-stl mil-up" id="top">
                        <div class="mil-overlay"></div>
                        <div class="container mil-hero-main mil-relative mil-aic">
                            <div class="mil-hero-text mil-scale-img" data-value-1="1.3" data-value-2="0.95">
                                <div class="mil-text-pad"></div>
                                <ul class="mil-breadcrumbs mil-mb60 mil-c-gone">
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="#.">Start a Project</a></li>
                                </ul>
                                <h1 class="mil-display2 mil-rubber">Let's Build <br><span class="mil-a2">Something Great</span></h1>
                            </div>
                        </div>
                    </div>
                    <div class="mil-p-0-100">
                        <div class="container">
                            
                            <div class="row mil-mb60">
                                <div class="col-lg-8">
                                    <p class="mil-text-lg mil-up">Thank you for your interest in working with Lexora Tech. Please tell us a bit about your project goals, and we will get back to you with a proposal.</p>
                                </div>
                            </div>
                            
                            <form class="mil-stl mil-mb130" method="POST" action="process-quote.php">
                                
                                <h3 class="mil-head3 mil-mb30 mil-up">01. Contact Details</h3>
                                <div class="row mil-aic mil-mb60">
                                    <div class="col-md-6 mil-mb30 mil-up">
                                        <input type="text" class="mil-input-styled" name="name" placeholder="Your Name *" required>
                                    </div>
                                    <div class="col-md-6 mil-mb30 mil-up">
                                        <input type="email" class="mil-input-styled" name="email" placeholder="Your Email *" required>
                                    </div>
                                    <div class="col-md-6 mil-mb30 mil-up">
                                        <input type="text" class="mil-input-styled" name="phone" placeholder="Phone Number">
                                    </div>
                                    <div class="col-md-6 mil-mb30 mil-up">
                                        <input type="text" class="mil-input-styled" name="company" placeholder="Company / Organization">
                                    </div>
                                </div>

                                <h3 class="mil-head3 mil-mb30 mil-up">02. How can we help?</h3>
                                <div class="row mil-mb60">

                                    <div class="col-lg-4 col-md-6 mil-mb30 mil-up">
                                        <div class="mil-service-card">
                                            <h4 class="mil-service-title">Web Development</h4>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Front-End Development">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Front-End Dev</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Back-End Development">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Back-End Dev</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="E-commerce Development">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">E-commerce</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Web Maintenance">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Maintenance</span>
                                            </label>
                                            <input type="text" name="web_other" class="mil-input-styled mil-input-small" placeholder="Other requirements...">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 mil-mb30 mil-up">
                                        <div class="mil-service-card">
                                            <h4 class="mil-service-title">Mobile Development</h4>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="iOS App">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">iOS App</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Android App">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Android App</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Cross-Platform">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Cross-Platform</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="App Maintenance">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">App Maintenance</span>
                                            </label>
                                            <input type="text" name="mobile_other" class="mil-input-styled mil-input-small" placeholder="Other requirements...">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 mil-mb30 mil-up">
                                        <div class="mil-service-card">
                                            <h4 class="mil-service-title">POS Development</h4>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Retail POS">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Retail POS</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Restaurant POS">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Restaurant POS</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Inventory Mgmt">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Inventory & Sales</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="POS Support">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Support</span>
                                            </label>
                                            <input type="text" name="pos_other" class="mil-input-styled mil-input-small" placeholder="Other requirements...">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 mil-mb30 mil-up">
                                        <div class="mil-service-card">
                                            <h4 class="mil-service-title">UI/UX Design</h4>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="User Research">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">User Research</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Wireframing">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Wireframing</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Visual Design">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Visual Design</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Interaction Design">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Interaction Design</span>
                                            </label>
                                            <input type="text" name="ui_other" class="mil-input-styled mil-input-small" placeholder="Other requirements...">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 mil-mb30 mil-up">
                                        <div class="mil-service-card">
                                            <h4 class="mil-service-title">Brand Strategy</h4>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Brand Positioning">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Brand Positioning</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Brand Identity">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Brand Identity</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Brand Experience">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Brand Experience</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Brand Communication">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Brand Communication</span>
                                            </label>
                                            <input type="text" name="brand_other" class="mil-input-styled mil-input-small" placeholder="Other requirements...">
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-6 mil-mb30 mil-up">
                                        <div class="mil-service-card">
                                            <h4 class="mil-service-title">Marketing & SMM</h4>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Social Media Strategy">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Social Media Strategy</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Content Creation">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Content Creation</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Community Management">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Community Management</span>
                                            </label>
                                            <label class="mil-checkbox-row">
                                                <input type="checkbox" name="services[]" value="Paid Advertising">
                                                <span class="mil-custom-check"></span>
                                                <span class="mil-checkbox-text">Paid Advertising</span>
                                            </label>
                                            <input type="text" name="marketing_other" class="mil-input-styled mil-input-small" placeholder="Other requirements...">
                                        </div>
                                    </div>
                                </div>

                                <h3 class="mil-head3 mil-mb30 mil-up">03. Project Details</h3>
                                <div class="row mil-mb60">
                                    <div class="col-12 mil-mb15 mil-up">
                                        <span class="mil-text-sm mil-mb15" style="display:block; color:#a2a2a2;">Estimated Budget</span>
                                    </div>
                                    <div class="col-12 mil-mb30 mil-up">
                                        <div class="mil-budget-group">
                                            <label class="mil-budget-btn">
                                                <input type="radio" name="budget" value="<1k">
                                                <span class="mil-budget-pill">Less than $1k</span>
                                            </label>
                                            <label class="mil-budget-btn">
                                                <input type="radio" name="budget" value="1k-5k">
                                                <span class="mil-budget-pill">$1k - $5k</span>
                                            </label>
                                            <label class="mil-budget-btn">
                                                <input type="radio" name="budget" value="5k-10k">
                                                <span class="mil-budget-pill">$5k - $10k</span>
                                            </label>
                                            <label class="mil-budget-btn">
                                                <input type="radio" name="budget" value="10k-25k">
                                                <span class="mil-budget-pill">$10k - $25k</span>
                                            </label>
                                            <label class="mil-budget-btn">
                                                <input type="radio" name="budget" value="25k+">
                                                <span class="mil-budget-pill">$25k +</span>
                                            </label>
                                            <label class="mil-budget-btn">
                                                <input type="radio" name="budget" value="TBD" checked>
                                                <span class="mil-budget-pill">To Be Discussed</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mil-aic">
                                    <div class="col-md-12 mil-mb30 mil-up">
                                        <textarea name="message" class="mil-input-styled" rows="1" placeholder="Tell us more about your project..." style="height: auto; min-height: 50px;"></textarea>
                                    </div>

                                    <div class="col-md-12 mil-mb30 mil-jce mil-up">
                                        <button type="submit" class="mil-btn mil-a2 mil-c-gone">Submit Proposal</button>
                                    </div>
                                </div>
                            </form>
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