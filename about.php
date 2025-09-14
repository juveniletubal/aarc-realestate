<?php
require_once 'classes/AssetManager.php';
require_once 'classes/PageManager.php';
require_once 'config/config.php';

$page->setTitle('AARC - About');
$page->setCurrentPage('about');

loadCoreAssets($assets, 'landing_page');

include 'includes_landing_page/header.php';
?>

<body class="about-page">

    <?php include 'includes_landing_page/navbar.php'; ?>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">About</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index">Home</a></li>
                        <li class="current">About</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- About Section -->
        <section id="about" class="about section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row justify-content-center">
                    <div class="col-lg-10">

                        <div class="hero-content text-center" data-aos="zoom-in" data-aos-delay="200">
                            <h2>Turning Land Into Opportunities Since 2008</h2>
                            <p class="hero-description"> We specialize in premium residential and commercial lots located in prime areas.
                                Our mission is to guide individuals and businesses in finding the right property for investment or building their dream home.
                                With trusted expertise and a commitment to excellence, we make land ownership simple, secure, and rewarding.</p>
                        </div>

                        <div class="dual-image-layout" data-aos="fade-up" data-aos-delay="300">
                            <div class="row g-4 align-items-center">
                                <div class="col-lg-6">
                                    <div class="primary-image-wrap">
                                        <img src="assets/img/real-estate/property-exterior-4.webp" alt="Luxury Property" class="img-fluid">
                                        <!-- <div class="floating-badge" data-aos="zoom-in" data-aos-delay="400">
                                            <div class="badge-content">
                                                <i class="bi bi-award"></i>
                                                <span>Top Rated Agency</span>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="secondary-image-wrap">
                                        <img src="assets/img/real-estate/agent-3.webp" alt="Professional Agent" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="features-showcase" data-aos="fade-up" data-aos-delay="350">
                    <div class="row gy-4">
                        <div class="col-lg-3 col-md-6">
                            <div class="feature-box" data-aos="flip-up" data-aos-delay="400">
                                <div class="feature-icon">
                                    <i class="bi bi-house-door"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Residential Sales</h4>
                                    <p>Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="feature-box" data-aos="flip-up" data-aos-delay="450">
                                <div class="feature-icon">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Commercial Properties</h4>
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="feature-box" data-aos="flip-up" data-aos-delay="500">
                                <div class="feature-icon">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Investment Guidance</h4>
                                    <p>Totam rem aperiam eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="feature-box" data-aos="flip-up" data-aos-delay="550">
                                <div class="feature-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <div class="feature-content">
                                    <h4>Legal Support</h4>
                                    <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Features Showcase -->

                <div class="metrics-section" data-aos="fade-up" data-aos-delay="400">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="metrics-wrapper">
                                <div class="row text-center">
                                    <div class="col-lg-3 col-6">
                                        <div class="metric-item" data-aos="zoom-in" data-aos-delay="450">
                                            <div class="metric-icon">
                                                <i class="bi bi-trophy"></i>
                                            </div>
                                            <div class="metric-value">
                                                <span data-purecounter-start="0" data-purecounter-end="1250" data-purecounter-duration="2" class="purecounter"></span>+
                                            </div>
                                            <div class="metric-label">Successful Sales</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <div class="metric-item" data-aos="zoom-in" data-aos-delay="500">
                                            <div class="metric-icon">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="metric-value">
                                                <span data-purecounter-start="0" data-purecounter-end="950" data-purecounter-duration="2" class="purecounter"></span>+
                                            </div>
                                            <div class="metric-label">Happy Clients</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <div class="metric-item" data-aos="zoom-in" data-aos-delay="550">
                                            <div class="metric-icon">
                                                <i class="bi bi-calendar-check"></i>
                                            </div>
                                            <div class="metric-value">
                                                <span data-purecounter-start="0" data-purecounter-end="16" data-purecounter-duration="2" class="purecounter"></span>
                                            </div>
                                            <div class="metric-label">Years in Business</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <div class="metric-item" data-aos="zoom-in" data-aos-delay="600">
                                            <div class="metric-icon">
                                                <i class="bi bi-star-fill"></i>
                                            </div>
                                            <div class="metric-value">4.9</div>
                                            <div class="metric-label">Average Rating</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Metrics Section -->

                <div class="testimonial-highlight" data-aos="fade-up" data-aos-delay="450">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="testimonial-card">
                                <div class="quote-icon">
                                    <i class="bi bi-chat-quote"></i>
                                </div>
                                <blockquote>
                                    "Neque porro quisquam est qui dolorem ipsum quia dolor sit amet consectetur adipisci velit sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem."
                                </blockquote>
                                <div class="testimonial-author">
                                    <div class="author-image">
                                        <img src="assets/img/person/person-f-8.webp" alt="Client" class="img-fluid">
                                    </div>
                                    <div class="author-info">
                                        <h5>Jennifer Rodriguez</h5>
                                        <span>Property Investor</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Testimonial Highlight -->

                <div class="cta-section" data-aos="fade-up" data-aos-delay="500">
                    <div class="row justify-content-center text-center">
                        <div class="col-lg-8">
                            <h3>Start Building Your Future Today</h3>
                            <p>Explore premium lots and find the perfect space to build your dream home or investment property.</p>
                            <div class="action-buttons">
                                <a href="contact.html" class="btn btn-primary">Get Started Today</a>
                                <a href="properties.html" class="btn btn-secondary">Browse Properties</a>
                            </div>
                        </div>
                    </div>
                </div><!-- End CTA Section -->

            </div>

        </section><!-- /About Section -->

    </main>

    <?php include 'includes_landing_page/footer.php'; ?>