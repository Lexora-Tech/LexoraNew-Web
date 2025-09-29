<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- grid css -->
    <link rel="stylesheet" href="css/plugins/bootstrap-grid.css">
    <!-- font awesome css -->
    <link rel="stylesheet" href="css/plugins/fontawesome.min.css">
    <!-- swiper css -->
    <link rel="stylesheet" href="css/plugins/swiper.min.css">
    <!-- okai css -->
    <link rel="stylesheet" href="css/style-stylish.css">
    <!-- page title -->
    <title>LexoraTech</title>
    <!-- logo css -->
    <link rel="shortcut icon" type="image/x-icon" href="img/logo/logo.png" />

</head>

<body>

    <!-- wrapper -->
    <div id="smooth-wrapper" class="mil-page-wrapper">

        <!-- cursor -->
        <div class="mil-cursor-follower"></div>
        <!-- cursor end -->

        <!-- preloader -->
        <!--         <div class="mil-preloader">
            <div class="mil-preloader-animation">
                <div class="mil-pos-abs mil-animation-1">
                    <p class="mil-head1 mil-m1">Pioneering</p>
                    <p class="mil-head1 mil-a2">Creative</p>
                    <p class="mil-head1 mil-m1">Excellence</p>
                </div>
                <div class="mil-pos-abs mil-animation-2">
                    <div class="mil-reveal-frame">
                        <p class="mil-reveal-box"></p>
                        <p class="mil-head1 mil-m1">LexoraTech.com</p>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- preloader end -->

        <!-- scroll progress -->
        <div class="mil-progress-track">
            <div class="mil-progress"></div>
        </div>
        <!-- scroll progress end -->

        <!-- fixed elements -->
        <?php
        include "header.php";
        ?>
        <!-- fixed elements end -->

        <!-- page transition -->
        <div class="mil-transition-fade" id="swup">
            <div class="mil-transition-frame">

                <!-- content -->
                <div id="smooth-content" class="mil-content">

                    <!-- hero -->
                    <div class="mil-hero-4 mil-up" id="top">
                        <div id="scene" class="mil-hero-scene">
                            <div class="mil-anim-frame" data-depth="0.25">
                                <img src="img/shapes/6.png" alt="shapes" class="mil-hero-animation" data-depth="0.25">
                            </div>
                            <div class="mil-pad-frame" data-depth="0.35">
                                <div class="mil-shape-pad"></div>
                            </div>
                        </div>
                        <div class="mil-overlay"></div>
                        <div class="container mil-hero-main mil-relative">
                            <div class="mil-hero-text">
                                <i class="fal fa-award mil-mb15"></i>
                                <p class="mil-stylized mil-m2 mil-mb60">Building With Bits</p>
                                <h1 class="mil-display2 mil-rubber">Creative <br>design <br>Tech</h1>
                                <div class="mil-circle-text-frame">
                                    <a href="#scroll" class="mil-circle-text mil-scroll-to mil-c-gone" data-no-swup>
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 300 300" enable-background="new 0 0 300 300" xml:space="preserve" data-value="360" class="mil-rotate">
                                            <defs>
                                                <path id="circlePath" d="M 150, 150 m -60, 0 a 60,60 0 0,1 120,0 a 60,60 0 0,1 -120,0 " />
                                            </defs>
                                            <circle cx="150" cy="100" r="75" fill="none" />
                                            <g>
                                                <use xlink:href="#circlePath" fill="none" />
                                                <text style="letter-spacing: 2px">
                                                    <!-- circle text -->
                                                    <textPath xlink:href="#circlePath">scroll down - scroll down - scroll down - </textPath>
                                                </text>
                                            </g>
                                        </svg>
                                        <span class="mil-arrow">
                                            <i class="fal fa-arrow-down"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- hero end -->

                    <!-- iconboxes -->
                    <div class="mil-p-0-100" id="scroll">
                        <div class="container">
                            <div class="row mil-jcc">
                                <div class="col-sm-8 col-lg-4">
                                    <div class="mil-iconbox mil-tac mil-mb60">
                                        <img src="img/logo/1.png" alt="icon" class="mil-mb30 mil-up">
                                        <h4 class="mil-head4 mil-mb30 mil-up">Expert Team</h4>
                                        <p class="mil-text-md mil-shortened mil-up">Our Team Is Made Up Of Seasoned Professionals Driven By Passion, Dedicated To Delivering Outstanding, High-Quality Projects.</p>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-lg-4">
                                    <div class="mil-iconbox mil-mb60">
                                        <img src="img/logo/2.png" alt="icon" class="mil-mb30 mil-up">
                                        <h4 class="mil-head4 mil-mb30 mil-up">Innovative Solutions</h4>
                                        <p class="mil-text-md mil-shortened mil-up">We Provide Innovative And Creative Solutions That Empower Your Business To Stand Out In The Market And Achieve Lasting Success.</p>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-lg-4">
                                    <div class="mil-iconbox mil-tac mil-mb60">
                                        <img src="img/logo/3.png" alt="icon" class="mil-mb30 mil-up">
                                        <h4 class="mil-head4 mil-mb30 mil-up">Client Focus</h4>
                                        <p class="mil-text-md mil-shortened mil-up">We Prioritize Client Needs, Deeply Understanding Them To Create Tailored Solutions For Maximum Results.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- iconboxes end -->

                    <!-- services -->
                    <div id="services">
                        <div class="container">
                            <div class="row mil-jcb">
                                <div class="col-12">
                                    <p class="mil-stylized mil-m2 mil-mb60 mil-up">Our Services</p>
                                    <h2 class="mil-head1 mil-mb90 mil-up">We generate <span class="mil-a1">unique</span> ideas</h2>
                                    <ul class="mil-services-list mil-mb160">
                                        <li class="mil-service-item mil-768-mb60 mil-up">
                                            <div class="mil-item-text mil-mb30">
                                                <h3 class="mil-head3 mil-mb30 mil-up">UI/UX Design</h3>
                                                <p class="mil-text-md mil-shortened mil-deco-text mil-max-3row-text mil-up">Design of intuitive and visually appealing user interfaces for web and mobile applications, focusing on enhancing the user experience and usability.</p>
                                            </div>
                                            <div class="mil-mb30 mil-up">
                                                <a href="services.php" class="mil-stylized-btn mil-c-gone">
                                                    <i class="fal fa-arrow-up"></i>
                                                    <span>Read more</span>
                                                </a>
                                            </div>
                                        </li>

                                        <li class="mil-service-item mil-768-mb60 mil-up">
                                            <div class="mil-item-text mil-mb30">
                                                <h3 class="mil-head3 mil-mb30 mil-up">Brand Strategy</h3>
                                                <p class="mil-text-md mil-shortened mil-deco-text mil-max-3row-text mil-up">Comprehensive brand development, including logo creation, color scheme selection, and visual style design to ensure a cohesive and memorable brand identity.</p>
                                            </div>
                                            <div class="mil-mb30 mil-up">
                                                <a href="services.php" class="mil-stylized-btn mil-c-gone">
                                                    <i class="fal fa-arrow-up"></i>
                                                    <span>Read more</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="mil-service-item mil-up">
                                            <div class="mil-item-text mil-mb30">
                                                <h3 class="mil-head3 mil-mb30 mil-up">Marketing and SMM</h3>
                                                <p class="mil-text-md mil-shortened mil-deco-text mil-max-3row-text mil-up">Creation of impactful advertising campaigns and marketing materials designed to increase brand visibility, engage target audiences, and drive customer acquisition.</p>
                                            </div>
                                            <div class="mil-mb30 mil-up">
                                                <a href="services.php" class="mil-stylized-btn mil-c-gone">
                                                    <i class="fal fa-arrow-up"></i>
                                                    <span>Read more</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="mil-service-item mil-768-mb60 mil-up">
                                            <div class="mil-item-text mil-mb30">
                                                <h3 class="mil-head3 mil-mb30 mil-up">WEB Development</h3>
                                                <p class="mil-text-md mil-shortened mil-deco-text mil-max-3row-text mil-up">Development of responsive and high-performance websites and web applications, focusing on clean code, scalability, and seamless functionality to deliver an optimal user experience across devices.</p>
                                            </div>
                                            <div class="mil-mb30 mil-up">
                                                <a href="services.php" class="mil-stylized-btn mil-c-gone">
                                                    <i class="fal fa-arrow-up"></i>
                                                    <span>Read more</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="mil-service-item mil-768-mb60 mil-up">
                                            <div class="mil-item-text mil-mb30">
                                                <h3 class="mil-head3 mil-mb30 mil-up">Mobile Application Development</h3>
                                                <p class="mil-text-md mil-shortened mil-deco-text mil-max-3row-text mil-up">Design and development of responsive and feature-rich mobile applications for iOS and Android, focusing on seamless performance, intuitive navigation, and an engaging user experience.</p>
                                            </div>
                                            <div class="mil-mb30 mil-up">
                                                <a href="services.php" class="mil-stylized-btn mil-c-gone">
                                                    <i class="fal fa-arrow-up"></i>
                                                    <span>Read more</span>
                                                </a>
                                            </div>
                                        </li>
                                        <li class="mil-service-item mil-768-mb60 mil-up">
                                            <div class="mil-item-text mil-mb30">
                                                <h3 class="mil-head3 mil-mb30 mil-up">Software Application Development (POS)</h3>
                                                <p class="mil-text-md mil-shortened mil-deco-text mil-max-3row-text mil-up">Design and development of reliable and efficient POS software applications, focusing on streamlined transaction processing, user-friendly interfaces, and robust functionality to enhance business operations.</p>
                                            </div>
                                            <div class="mil-mb30 mil-up">
                                                <a href="services.php" class="mil-stylized-btn mil-c-gone">
                                                    <i class="fal fa-arrow-up"></i>
                                                    <span>Read more</span>
                                                </a>
                                            </div>
                                        </li>



                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- services end -->

                    <!-- counters -->
                    <div class="mil-p-0-160">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mil-counter-item mil-stl mil-mb30 mil-768-mb60 mil-up">
                                        <h4 class="mil-up">4<span class="mil-a2">+</span></h4>
                                        <div class="mil-counter-text">
                                            <h5 class="mil-head4 mil-m1 mil-up">Years experience</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mil-counter-item mil-stl mil-mb30 mil-768-mb60 mil-up">
                                        <h4 class="mil-up">25<span class="mil-a2">+</span></h4>
                                        <div class="mil-counter-text">
                                            <h5 class="mil-head4 mil-m1 mil-up">Unique customers</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mil-counter-item mil-stl mil-mb30 mil-up">
                                        <h4 class="mil-up">100<span class="mil-a2">+</span></h4>
                                        <div class="mil-counter-text">
                                            <h5 class="mil-head4 mil-m1 mil-up">Completed projects</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- counters end -->

                    <!-- call to action -->
                    <div class="container">
                        <div class="mil-half-container mil-stl mil-up">
                            <div class="mil-text-box mil-g-m4 mil-p-160-160">
                                <p class="mil-stylized mil-m2 mil-mb60 mil-up">Contact</p>
                                <h2 class="mil-display3 mil-mb60 mil-m1 mil-up">Let’s <span class="mil-a1">make </span> <br>an <span class="mil-a1">impact </span><br>together.</h2>
                                <p class="mil-text-md mil-deco-text mil-shortened mil-up">Welcome to <span class="mil-a2">LexoraTech</span> where your ideas come to life. We specialize in crafting unique brands, captivating advertising campaigns, and effective digital strategies.</p>
                            </div>
                            <div class="mil-image-box">
                                <div class="mil-image-frame">
                                    <img src="img/home-4/1.jpg" alt="img" class="mil-scale-img" data-value-1="1.20" data-value-2="1">
                                    <div class="mil-overlay"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mil-aic mil-jcb mil-no-g">
                            <div class="col-lg-4 mil-992-gone">
                                <p class="mil-text-sm mil-up">We accept your requests 24/7. Feel free to <a href="contact.php" class="mil-text-link mil-a2 mil-c-gone">write to us</a> whenever it is convenient for you</p>
                            </div>
                            <div class="col-lg-6">
                                <div class="mil-button-pad mil-a2">
                                    <span class="mil-up"><a href="contact.php" class="mil-btn mil-btn-border mil-m1 mil-c-gone">Get in touch</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- call to action end -->

                    <!-- about -->
                    <div class="mil-p-160-100" id="about">
                        <div class="container">
                            <div class="row mil-jcb">
                                <div class="col-12">
                                    <p class="mil-stylized mil-m2 mil-mb60 mil-up">About us</p>
                                </div>
                                <div class="col-lg-4">
                                    <h2 class="mil-head1 mil-mb60 mil-up">Discover <br>Our <span class="mil-a2">company</span></h2>
                                    <p class="mil-text-sm mil-deco-text mil-mb60 mil-up">Welcome to <span class="mil-a2">LexoraTech</span> where your ideas come to life. We specialize in crafting unique brands, captivating advertising campaigns, and effective digital strategies.</p>
                                </div>
                                <div class="col-lg-6">
                                    <p class="mil-text-md mil-mb30 mil-up">Our team of talented designers, copywriters, and marketers works with passion and dedication to make your business stand out. We take the time to understand your vision and tailor our approach to ensure your message resonates with your target audience.</p>
                                    <p class="mil-text-md mil-mb60 mil-up">Our goal is to help you build an emotional connection with your audience using cutting-edge tools and approaches. We combine our expertise with your unique insights, creating compelling narratives that not only engage but also inspire. Trust us with your idea, and we'll transform it into a successful project that will impress both you and your clients, driving growth and lasting impact.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- about end -->

                    <!-- team -->
                    <!--      <div class="mil-p-0-130 mil-768-p-160-145" id="team">
                        <div class="container">
                            <div class="row mil-aie mil-mb30">
                                <div class="col-lg-6">
                                    <h2 class="mil-head1 mil-mb60 mil-up">Meet Our <span class="mil-a1">Team</span></h2>
                                </div>
                                <div class="col-lg-6">
                                    <p class="mil-stylized mil-m1 mil-tar mil-768-tal mil-mb60 mil-up"><a href="team-stl.php" class="mil-arrow-link mil-c-gone">View all members</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 col-lg-3">
                                    <div class="mil-team-card mil-stl mil-mb30 mil-768-mb-15 mil-up">
                                        <div class="mil-hover-frame">
                                            <img src="img/team/9.jpg" alt="team member" class="mil-scale-img" data-value-1="1.20" data-value-2="1">
                                        </div>
                                        <div class="mil-hover-overlay">
                                            <div class="mil-descr">
                                                <h4 class="mil-head4 mil-m1 mil-mb20">James</h4>
                                                <ul class="mil-social mil-m1 mil-mb20 mil-c-gone">
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                </ul>
                                                <p class="mil-stylized mil-a1">UI/UX Designer</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="mil-team-card mil-stl mil-mb30 mil-768-mb-15 mil-up">
                                        <div class="mil-hover-frame">
                                            <img src="img/team/10.jpg" alt="team member" class="mil-scale-img" data-value-1="1.20" data-value-2="1">
                                        </div>
                                        <div class="mil-hover-overlay">
                                            <div class="mil-descr">
                                                <h4 class="mil-head4 mil-m1 mil-mb20">Edward</h4>
                                                <ul class="mil-social mil-m1 mil-mb20 mil-c-gone">
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                </ul>
                                                <p class="mil-stylized mil-a1">QA engineer</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="mil-team-card mil-stl mil-mb30 mil-768-mb-15 mil-up">
                                        <div class="mil-hover-frame">
                                            <img src="img/team/11.jpg" alt="team member" class="mil-scale-img" data-value-1="1.20" data-value-2="1">
                                        </div>
                                        <div class="mil-hover-overlay">
                                            <div class="mil-descr">
                                                <h4 class="mil-head4 mil-m1 mil-mb20">Monica</h4>
                                                <ul class="mil-social mil-m1 mil-mb20 mil-c-gone">
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                </ul>
                                                <p class="mil-stylized mil-a1">Web Developer</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="mil-team-card mil-stl mil-mb30 mil-768-mb-15 mil-up">
                                        <div class="mil-hover-frame">
                                            <img src="img/team/12.jpg" alt="team member" class="mil-scale-img" data-value-1="1.20" data-value-2="1">
                                        </div>
                                        <div class="mil-hover-overlay">
                                            <div class="mil-descr">
                                                <h4 class="mil-head4 mil-m1 mil-mb20">Paul</h4>
                                                <ul class="mil-social mil-m1 mil-mb20 mil-c-gone">
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                    <li><a href="#." target="_blank" data-no-swup><i class="far fa-circle"></i></a></li>
                                                </ul>
                                                <p class="mil-stylized mil-a1">Art Director</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- team end -->

                    <!-- reviews -->
                    <div id="reviews">
                        <div class="container">
                            <div class="row mil-jcc">
                                <div class="col-lg-12 mil-tac">
                                    <p class="mil-stylized mil-m2 mil-mb60 mil-up">reviews</p>
                                    <h2 class="mil-head1 mil-mb90 mil-up">Customer Voices: <br>Hear What <span class="mil-a2">They Say</span>!</h2>
                                </div>
                                <div class="col-lg-6 mil-relative">
                                    <div class="swiper-container mil-reviews-slider mil-c-swipe mil-c-dark">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="mil-review" data-swiper-parallax-scale="0.8">
                                                    <div class="mil-portrait mil-mb30 mil-up">
                                                        <img src="img/reviews/cl1.png" alt="Client">
                                                    </div>
                                                    <h4 class="mil-head4 mil-max-1row-text mil-mb15 mil-up mil-c-gone">Missed Lesson Project</h4>
                                                    <a class="mil-stylized mil-m2 mil-mb30 mil-up" href="https://www.magaharunupaadama.com">magaharunupaadama</a>
                                                    <p class="mil-text-lg mil-m1 mil-up">I had the pleasure of working with this creative agency, and I must say, they truly impressed me. They consistently think outside the box, resulting in impressive and impactful work. I highly recommend this agency for their consistent delivery of exceptional creative solutions.</p>
                                                </div>
                                            </div>
                                            <!-- <div class="swiper-slide">
                                                <div class="mil-review" data-swiper-parallax-scale="0.8">
                                                    <div class="mil-portrait mil-mb30 mil-up">
                                                        <img src="img/reviews/1.jpg" alt="Client">
                                                    </div>
                                                    <h4 class="mil-head4 mil-max-1row-text mil-mb15 mil-up mil-c-gone">Emma Newman</h4>
                                                    <p class="mil-stylized mil-m2 mil-mb30 mil-up">Envato market</p>
                                                    <p class="mil-text-lg mil-m1 mil-up">This creative agency stands out with their exceptional talent and expertise. Their ability to think outside the box and bring unique ideas to life is truly impressive. With meticulous attention to detail, they consistently deliver visually stunning and impactful work.</p>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="mil-review" data-swiper-parallax-scale="0.8">
                                                    <div class="mil-portrait mil-mb30 mil-up">
                                                        <img src="img/reviews/3.jpg" alt="Client">
                                                    </div>
                                                    <h4 class="mil-head4 mil-max-1row-text mil-mb15 mil-up mil-c-gone">Viktoria Freeman</h4>
                                                    <p class="mil-stylized mil-m2 mil-mb30 mil-up">Envato market</p>
                                                    <p class="mil-text-lg mil-m1 mil-up">This creative agency stands out with their exceptional talent and expertise. Their ability to think outside the box and bring unique ideas to life is truly impressive. With meticulous attention to detail, they consistently deliver visually stunning and impactful work.</p>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="mil-review" data-swiper-parallax-scale="0.8">
                                                    <div class="mil-portrait mil-mb30 mil-up">
                                                        <img src="img/reviews/4.jpg" alt="Client">
                                                    </div>
                                                    <h4 class="mil-head4 mil-max-1row-text mil-mb15 mil-up mil-c-gone">Oscar Oldman</h4>
                                                    <p class="mil-stylized mil-m2 mil-mb30 mil-up">Envato market</p>
                                                    <p class="mil-text-lg mil-m1 mil-up">I had the pleasure of working with this creative agency, and I must say, they truly impressed me. They consistently think outside the box, resulting in impressive and impactful work. I highly recommend this agency for their consistent delivery of exceptional creative solutions.</p>
                                                </div>
                                            </div> -->

                                        </div>
                                    </div>
                                    <div class="mil-sr-pagination mil-up"></div>
                                    <div class="mil-rs-nav mil-up">
                                        <div class="mil-slider-btn mil-sr-prev mil-c-gone"></div>
                                        <div class="mil-slider-btn mil-sr-next mil-c-gone"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- reviews end -->

                    <!-- partners -->
                    <!--          <div class="mil-p-160-130">
                        <div class="container">
                            <div class="row mil-jcb mil-aic">
                                <div class="col-6 col-md-3 mil-up">
                                    <a href="#." class="mil-partner mil-type-2 mil-stl mil-mb30" target="_blank" data-no-swup>
                                        <img src="img/brands/1.png" alt="partner logo">
                                    </a>
                                </div>
                                <div class="col-6 col-md-3 mil-up">
                                    <a href="#." class="mil-partner mil-type-2 mil-stl mil-mb30" target="_blank" data-no-swup>
                                        <img src="img/brands/2.png" alt="partner logo">
                                    </a>
                                </div>
                                <div class="col-6 col-md-3 mil-up">
                                    <a href="#." class="mil-partner mil-type-2 mil-stl mil-mb30" target="_blank" data-no-swup>
                                        <img src="img/brands/3.png" alt="partner logo">
                                    </a>
                                </div>
                                <div class="col-6 col-md-3 mil-up">
                                    <a href="#." class="mil-partner mil-type-2 mil-stl mil-mb30" target="_blank" data-no-swup>
                                        <img src="img/brands/5.png" alt="partner logo">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- partners end -->

                    <!-- call to action -->
                    <div class="mil-p-0-100">
                        <div class="container mil-relative">
                            <div class="mil-objects">
                                <div class="mil-obj-1"></div>
                                <div class="mil-obj-2"></div>
                            </div>
                            <p class="mil-stylized mil-m2 mil-mb60 mil-tac mil-up">Explore our company</p>
                            <h2 class="mil-head1 mil-rubber mil-tac mil-mb60 mil-up">LexoraTech is a <span class="mil-a1">creative</span> company that transforms <span class="mil-a1">ideas</span> into masterpieces. We craft <span class="mil-a1">design</span> magic, breathe new life into brands, and make the impossible <span class="mil-a1">possible</span>. Choose <span class="mil-a1">LexoraTech</span> because we are worth it!</h2>
                            <div class="mil-text-with-button mil-mb60">
                                <p class="mil-text-sm mil-tar mil-768-tac mil-up">We've been working for several years to build a portfolio <br>that truly reflects our diversity.</p>
                                <span class="mil-up"><a href="portfolio.php" class="mil-btn mil-btn-border mil-m1 mil-c-gone">View portfolio</a></span>
                            </div>
                        </div>
                    </div>
                    <!-- call to action end -->

                    <!-- blog -->
                    <!-- <div class="mil-p-0-160" id="blog">
                        <div class="container">
                            <div class="row mil-aie mil-mb30">
                                <div class="col-md-6">
                                    <p class="mil-stylized mil-m2 mil-mb60 mil-up">Newsletter</p>
                                    <h2 class="mil-head1 mil-mb60 mil-up">Latest from <span class="mil-a2">Blog</span></h2>
                                </div>
                                <div class="col-md-6">
                                    <p class="mil-stylized mil-m1 mil-tar mil-768-tal mil-mb60 mil-up"><a href="blog.php" class="mil-arrow-link mil-c-gone">View all publications</a></p>
                                </div>
                            </div>
                            <div class="swiper-container mil-blog-slider">
                                <div class="swiper-wrapper mil-c-swipe mil-c-dark">
                                    <div class="swiper-slide">
                                        <div class="mil-blog-card">
                                            <div class="mil-cover mil-up">
                                                <div class="mil-hover-frame">
                                                    <img src="img/blog/9.jpg" alt="cover" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                                </div>
                                                <div class="mil-badges">
                                                    <div class="mil-category">design</div>
                                                    <div class="mil-date">29.08.24</div>
                                                </div>
                                            </div>
                                            <a href="publication.php" class="mil-descr mil-c-gone">
                                                <div class="mil-text-frame">
                                                    <h4 class="mil-head4 mil-max-2row-text mil-mb20 mil-up">How to Become a Graphic Designer in 10 Simple Steps</h4>
                                                    <p class="mil-text-md mil-max-2row-text mil-up">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius sequi commodi dignissimos optio, beatae, eos necessitatibus nisi. Nam cupiditate consectetur nostrum qui! Repellat natus nulla, nisi aliquid, asperiores impedit tempora sequi est reprehenderit cumque explicabo, dicta. Rem nihil ullam totam ea voluptas quibusdam repudiandae.</p>
                                                </div>
                                                <div class="mil-up mil-768-gone">
                                                    <div class="mil-stylized-btn">
                                                        <i class="fal fa-arrow-up"></i>
                                                        <span>Read more</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-blog-card">
                                            <div class="mil-cover mil-up">
                                                <div class="mil-hover-frame">
                                                    <img src="img/blog/10.jpg" alt="cover" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                                </div>
                                                <div class="mil-badges">
                                                    <div class="mil-category">Branding</div>
                                                    <div class="mil-date">29.08.24</div>
                                                </div>
                                            </div>
                                            <a href="publication.php" class="mil-descr mil-c-gone">
                                                <div class="mil-text-frame">
                                                    <h4 class="mil-head4 mil-max-2row-text mil-mb20 mil-up">10 Essential Tools Every Graphic Designer Should Master</h4>
                                                    <p class="mil-text-md mil-max-2row-text mil-up">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius sequi commodi dignissimos optio, beatae, eos necessitatibus nisi. Nam cupiditate consectetur nostrum qui! Repellat natus nulla, nisi aliquid, asperiores impedit tempora sequi est reprehenderit cumque explicabo, dicta. Rem nihil ullam totam ea voluptas quibusdam repudiandae.</p>
                                                </div>
                                                <div class="mil-up mil-768-gone">
                                                    <div class="mil-stylized-btn">
                                                        <i class="fal fa-arrow-up"></i>
                                                        <span>Read more</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-blog-card">
                                            <div class="mil-cover mil-up">
                                                <div class="mil-hover-frame">
                                                    <img src="img/blog/11.jpg" alt="cover" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                                </div>
                                                <div class="mil-badges">
                                                    <div class="mil-category">Art</div>
                                                    <div class="mil-date">29.08.24</div>
                                                </div>
                                            </div>
                                            <a href="publication.php" class="mil-descr mil-c-gone">
                                                <div class="mil-text-frame">
                                                    <h4 class="mil-head4 mil-max-2row-text mil-mb20 mil-up">From Concept to Creation: The Design Process Explained</h4>
                                                    <p class="mil-text-md mil-max-2row-text mil-up">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius sequi commodi dignissimos optio, beatae, eos necessitatibus nisi. Nam cupiditate consectetur nostrum qui! Repellat natus nulla, nisi aliquid, asperiores impedit tempora sequi est reprehenderit cumque explicabo, dicta. Rem nihil ullam totam ea voluptas quibusdam repudiandae.</p>
                                                </div>
                                                <div class="mil-up mil-768-gone">
                                                    <div class="mil-stylized-btn">
                                                        <i class="fal fa-arrow-up"></i>
                                                        <span>Read more</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="mil-blog-card">
                                            <div class="mil-cover mil-up">
                                                <div class="mil-hover-frame">
                                                    <img src="img/blog/12.jpg" alt="cover" class="mil-scale-img" data-value-1="1.15" data-value-2="1">
                                                </div>
                                                <div class="mil-badges">
                                                    <div class="mil-category">Interior</div>
                                                    <div class="mil-date">29.08.24</div>
                                                </div>
                                            </div>
                                            <a href="publication.php" class="mil-descr mil-c-gone">
                                                <div class="mil-text-frame">
                                                    <h4 class="mil-head4 mil-max-2row-text mil-mb20 mil-up">The Ultimate Guide to UI/UX Design for Beginners</h4>
                                                    <p class="mil-text-md mil-max-2row-text mil-up">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eius sequi commodi dignissimos optio, beatae, eos necessitatibus nisi. Nam cupiditate consectetur nostrum qui! Repellat natus nulla, nisi aliquid, asperiores impedit tempora sequi est reprehenderit cumque explicabo, dicta. Rem nihil ullam totam ea voluptas quibusdam repudiandae.</p>
                                                </div>
                                                <div class="mil-up mil-768-gone">
                                                    <div class="mil-stylized-btn">
                                                        <i class="fal fa-arrow-up"></i>
                                                        <span>Read more</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <!-- blog end -->

                    <!-- subscribe -->
                    <div class="container">
                        <div class="mil-half-container mil-stl mil-reverse mil-up">
                            <div class="mil-text-box mil-g-m4 mil-p-160-160">
                                <p class="mil-stylized mil-m2 mil-mb60 mil-up">Newsletter</p>
                                <h2 class="mil-display3 mil-rubber mil-mb60 mil-up">Subscribe <span class="mil-a2">our</span> <br>newsletter</h2>
                                <form class="mil-subscribe-form mil-up mil-c-gone">
                                    <input type="text" placeholder="Enter your email">
                                    <button type="submit"><i class="fal fa-arrow-right"></i></button>
                                </form>
                                <br>
                                <p class="mil-text-sm mil-up">By clicking the submit button, you agree to the <br><a href="contact.php" class="mil-text-link mil-a2 mil-c-gone">
                                        rules for processing personal data</a>.</p>
                            </div>
                            <div class="mil-image-box">
                                <div class="mil-image-frame">
                                    <!-- image background<img src="img/home-4/2.jpg" alt="img" class="mil-scale-img" data-value-1="1.20" data-value-2="1">-->
                                    <video class="mil-scale-img" data-value-1="1" data-value-2="1.1" autoplay="autoplay" loop="loop" muted="" playsinline="" oncontextmenu="return false;" preload="auto">
                                        <source src="img/home-4/video.mp4">
                                    </video>
                                    <div class="mil-overlay"></div>
                                </div>
                            </div>
                        </div>
                        <!--   <div class="row mil-aic mil-jcb mil-no-g">
                            <div class="col-lg-6">
                                <div class="mil-button-pad mil-a1 mil-jst" style="display: block"></div>
                            </div>
                            <div class="col-lg-6 mil-992-gone">
                                <div class="mil-text-pad">
                                    <p class="mil-text-sm mil-up">By clicking the submit button, you agree to the <br><a href="contact.php" class="mil-text-link mil-a2 mil-c-gone">
                                        rules for processing personal data</a>.</p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <!-- subscribe end -->

                    <!-- footer -->
                    <?php
                    include "footer.php";
                    ?>
                    <!-- footer end -->

                </div>
                <!-- content -->

            </div>
        </div>
        <!-- page transition -->

    </div>
    <!-- wrapper end -->

    <!-- swup js -->
    <script src="js/plugins/swup.min.js"></script>
    <!-- gsap js -->
    <script src="js/plugins/gsap.min.js"></script>
    <!-- scroll smoother -->
    <script src="js/plugins/ScrollSmoother.min.js"></script>
    <!-- scroll trigger js -->
    <script src="js/plugins/ScrollTrigger.min.js"></script>
    <!-- scroll to js -->
    <script src="js/plugins/ScrollTo.min.js"></script>
    <!-- swiper js -->
    <script src="js/plugins/swiper.min.js"></script>
    <!-- parallax js -->
    <script src="js/plugins/parallax.js"></script>
    <!-- FontAwesome for Icons -->
    <script src="https://kit.fontawesome.com/yourkit.js" crossorigin="anonymous"></script>

    <!-- LexoraTech js -->
    <script src="js/main.js"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3130344952697641"
    crossorigin="anonymous"></script>
</body>

</html>