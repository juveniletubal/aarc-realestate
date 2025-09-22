<?php
require_once 'includes_landing_page/init.php';

$page->setTitle('AARC - About');
$page->setCurrentPage('agents');

loadCoreAssets($assets, 'landing_page');

include 'includes_landing_page/header.php';
?>

<body class="agents-page">

    <?php include 'includes_landing_page/navbar.php'; ?>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Agents</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index">Home</a></li>
                        <li class="current">Agents</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Agents Section -->
        <section id="agents" class="agents section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="agent-card">
                            <div class="agent-image">
                                <img src="assets/img/real-estate/agent-1.webp" alt="Agent" class="img-fluid">
                                <div class="badge-overlay">
                                    <span class="top-seller-badge">Top Seller</span>
                                </div>
                            </div>
                            <div class="agent-info">
                                <h4>Sarah Martinez</h4>
                                <span class="role">Senior Property Advisor</span>
                                <p class="location"><i class="bi bi-geo-alt"></i>vDowntown Miami</p>
                                <div class="contact-links">
                                    <a href="tel:+15551234567"><i class="bi bi-telephone"></i></a>
                                    <a href="mailto:sarah@example.com"><i class="bi bi-envelope"></i></a>
                                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                                    <a href="#"><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Agent Card -->

                    <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="agent-card">
                            <div class="agent-image">
                                <img src="assets/img/real-estate/agent-2.webp" alt="Agent" class="img-fluid">
                                <div class="badge-overlay">
                                    <span class="verified-badge">Verified</span>
                                </div>
                            </div>
                            <div class="agent-info">
                                <h4>Michael Thompson</h4>
                                <span class="role">Commercial Specialist</span>
                                <p class="location"><i class="bi bi-geo-alt"></i>vBrickell Avenue</p>
                                <div class="contact-links">
                                    <a href="tel:+15551234568"><i class="bi bi-telephone"></i></a>
                                    <a href="mailto:michael@example.com"><i class="bi bi-envelope"></i></a>
                                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                                    <a href="#"><i class="bi bi-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Agent Card -->

                    <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="agent-card">
                            <div class="agent-image">
                                <img src="assets/img/real-estate/agent-3.webp" alt="Agent" class="img-fluid">
                                <div class="badge-overlay">
                                    <span class="new-agent-badge">New Agent</span>
                                </div>
                            </div>
                            <div class="agent-info">
                                <h4>Emma Rodriguez</h4>
                                <span class="role">Residential Expert</span>
                                <p class="location"><i class="bi bi-geo-alt"></i>vCoral Gables</p>
                                <div class="contact-links">
                                    <a href="tel:+15551234569"><i class="bi bi-telephone"></i></a>
                                    <a href="mailto:emma@example.com"><i class="bi bi-envelope"></i></a>
                                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                                    <a href="#"><i class="bi bi-facebook"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Agent Card -->

                    <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="agent-card">
                            <div class="agent-image">
                                <img src="assets/img/real-estate/agent-4.webp" alt="Agent" class="img-fluid">
                                <div class="badge-overlay">
                                    <span class="awarded-badge">Award Winner</span>
                                </div>
                            </div>
                            <div class="agent-info">
                                <h4>James Wilson</h4>
                                <span class="role">Luxury Property Consultant</span>
                                <p class="location"><i class="bi bi-geo-alt"></i>vSouth Beach</p>
                                <div class="contact-links">
                                    <a href="tel:+15551234570"><i class="bi bi-telephone"></i></a>
                                    <a href="mailto:james@example.com"><i class="bi bi-envelope"></i></a>
                                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                                    <a href="#"><i class="bi bi-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Agent Card -->

                </div>

                <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="500">
                    <a href="#" class="btn-view-all-agents">View All Agents</a>
                </div>

            </div>

        </section><!-- /Agents Section -->

    </main>

    <?php include 'includes_landing_page/footer.php'; ?>