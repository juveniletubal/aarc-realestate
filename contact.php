<?php
require_once 'includes_landing_page/init.php';

$page->setTitle('AARC - Contact');
$page->setCurrentPage('contact');

loadCoreAssets($assets, 'landing_page');

include 'includes_landing_page/header.php';
?>

<body class="contact-page">

    <?php include 'includes_landing_page/navbar.php'; ?>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Contact</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index">Home</a></li>
                        <li class="current">Contact</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Contact 2 Section -->
        <section id="contact-2" class="contact-2 section">

            <!-- Map Section -->
            <div class="map-container mb-5">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6671.90358643614!2d125.17018204136495!3d6.112169175371437!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32f79fa093e1f16d%3A0x20387b3a230e50d1!2sPlaza%20Heneral%20Santos!5e0!3m2!1sen!2sph!4v1757783594289!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <!-- Contact Info -->
                <div class="row g-4 mb-5" data-aos="fade-up" data-aos-delay="300">
                    <div class="col-md-6">
                        <div class="contact-info-card">
                            <div class="icon-box">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="info-content">
                                <h4>Location</h4>
                                <p>482 Pine Street, Seattle, Washington 98101</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="contact-info-card">
                            <div class="icon-box">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="info-content">
                                <h4>Phone &amp; Email</h4>
                                <p>+1 (206) 555-0192</p>
                                <p>connect@example.com</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="row justify-content-center mb-5" data-aos="fade-up" data-aos-delay="200">
                    <div class="col-lg-10">
                        <div class="contact-form-wrapper">
                            <h2 class="text-center mb-4">Send a Message</h2>

                            <form action="forms/contact.php" method="post" class="php-email-form">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="name" placeholder="Your Name" required="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="email" class="form-control" name="email" placeholder="Email Address" required="">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea class="form-control" name="message" placeholder="Your Message" rows="6" required=""></textarea>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="loading">Loading</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">Your message has been sent. Thank you!</div>
                                    </div>

                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn-submit">SEND MESSAGE</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </section><!-- /Contact 2 Section -->

    </main>

    <?php include 'includes_landing_page/footer.php'; ?>