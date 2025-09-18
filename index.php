<?php
require_once 'includes/init.php';

$page->setTitle('AARC - Home');
$page->setCurrentPage('home');

loadCoreAssets($assets, 'landing_page');

include 'includes_landing_page/header.php';
?>

<style>
  #hero {
    background: url("assets/img/bg1.webp") center center/cover no-repeat;
    position: relative;
    transition: background-image 1s ease-in-out;
  }

  #hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 1;
  }
</style>

<body class="index-page">

  <?php include 'includes_landing_page/navbar.php'; ?>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section d-flex align-items-center min-vh-100">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="hero-wrapper">
          <div class="row g-4">

            <!-- End Hero Content -->
            <div class="col-lg-7 text-center text-lg-start">
              <div
                class="hero-content"
                data-aos="zoom-in"
                data-aos-delay="200">
                <div class="content-header ">
                  <h1 style="color: white;">Find the Perfect Lot for Your Future Investment</h1>
                  <p style="color: white;">
                    Examine premium commercial and residential lots in desirable areas.
                    Get advice from reputable real estate professionals to begin your next project or build your ideal home.
                  </p>
                </div>

                <div
                  class="search-container"
                  data-aos="fade-up"
                  data-aos-delay="300">

                  <form action="" class="property-search-form">
                    <div class="search-grid">
                      <div class="search-field">
                        <label for="search-location" class="field-label">Location</label>
                        <input
                          type="text"
                          id="search-location"
                          name="location"
                          placeholder="Enter city or neighborhood"
                          required="" />
                        <i class="bi bi-geo-alt field-icon"></i>
                      </div>

                      <div class="search-field">
                        <label for="search-type" class="field-label">Property Type</label>
                        <select
                          id="search-type"
                          name="property_type"
                          required="">
                          <option value="">All Types</option>
                          <!-- <option value="house">Single House</option>
                          <option value="apartment">Apartment</option>
                          <option value="condo">Condominium</option>
                          <option value="villa">Villa</option>
                          <option value="commercial">Commercial</option> -->
                        </select>
                        <i class="bi bi-building field-icon"></i>
                      </div>

                    </div>

                    <button type="submit" class="search-btn">
                      <i class="bi bi-search"></i>
                      <span>Find Properties</span>
                    </button>
                  </form>
                </div>

              </div>
            </div>
            <!-- End Hero Content -->

            <!-- Hero Visual -->
            <div class="col-lg-5">
              <div
                class="hero-visual"
                data-aos="fade-left"
                data-aos-delay="400">
                <div class="visual-container">
                  <div class="featured-property border border-4">
                    <img
                      src="assets/img/real-estate/property-exterior-8.webp"
                      alt="Featured Property"
                      class="img-fluid" />
                    <div class="property-info">
                      <div class="property-price text-start">₱925,000</div>
                      <div class="property-details">
                        <span><i class="bi bi-geo-alt"></i> Downtown
                          District</span>
                        <span><i class="bi bi-house"></i> 4 Bed, 3 Bath</span>
                      </div>
                    </div>
                  </div>

                  <div class="overlay-images">
                    <div class="overlay-img overlay-1">
                      <img
                        src="assets/img/real-estate/property-interior-4.webp"
                        alt="Interior View"
                        class="img-fluid" />
                    </div>
                    <div class="overlay-img overlay-2">
                      <img
                        src="assets/img/real-estate/property-exterior-2.webp"
                        alt="Exterior View"
                        class="img-fluid" />
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- End Hero Visual -->

          </div>
        </div>
      </div>
    </section>
    <!-- /Hero Section -->

    <!-- Home About Section -->
    <section id="home-about" class="home-about section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-5">
          <div class="col-lg-5" data-aos="zoom-in" data-aos-delay="200">
            <div class="image-gallery">
              <div class="primary-image">
                <img
                  src="assets/img/real-estate/property-exterior-1.webp"
                  alt="Modern Property"
                  class="img-fluid" />
                <div class="experience-badge">
                  <div class="badge-content">
                    <div class="number">
                      <span
                        data-purecounter-start="0"
                        data-purecounter-end="10"
                        data-purecounter-duration="2"
                        class="purecounter"></span>+
                    </div>
                    <div class="text">Years<br />Experience</div>
                  </div>
                </div>
              </div>
              <div class="secondary-image">
                <img
                  src="assets/img/real-estate/property-interior-4.webp"
                  alt="Luxury Interior"
                  class="img-fluid" />
              </div>
            </div>
          </div>

          <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
            <div class="content">
              <div class="section-header">
                <span class="section-label">About Our Company</span>
                <h2>Turning Land Into Opportunities Since 2008</h2>
              </div>

              <p>
                We specialize in premium residential and commercial lots located in prime areas.
                Our mission is to guide individuals and businesses in finding the right property for investment or building their dream home.
                With trusted expertise and a commitment to excellence, we make land ownership simple, secure, and rewarding.
              </p>

              <div class="achievements-list">
                <div class="achievement-item">
                  <div class="achievement-icon">
                    <i class="bi bi-house-door"></i>
                  </div>
                  <div class="achievement-content">
                    <h4>
                      <span
                        data-purecounter-start="0"
                        data-purecounter-end="100"
                        data-purecounter-duration="2"
                        class="purecounter"></span>+ Properties Sold
                    </h4>
                    <p>Successfully completed transactions</p>
                  </div>
                </div>
                <div class="achievement-item">
                  <div class="achievement-icon">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="achievement-content">
                    <h4>
                      <span
                        data-purecounter-start="0"
                        data-purecounter-end="100"
                        data-purecounter-duration="2"
                        class="purecounter"></span>% Client Satisfaction
                    </h4>
                    <p>Happy customers recommend us</p>
                  </div>
                </div>
              </div>

              <div class="action-section">
                <a href="about" class="btn-cta">
                  <span>Discover Our Story</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
                <div class="contact-info">
                  <div class="contact-icon">
                    <i class="bi bi-telephone"></i>
                  </div>
                  <div class="contact-details">
                    <span>Call us today</span>
                    <strong>+1 (555) 123-4567</strong>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /Home About Section -->


    <!-- Featured Properties Section -->
    <section id="featured-properties" class="featured-properties section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Featured Properties</h2>
        <p>
          Discover prime lots and properties perfect for your home or investment.
        </p>
      </div>
      <!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="250">

        <div class="row gy-2">

          <div class="col-lg-4 col-md-6">
            <div class="properties-sidebar">
              <div class="sidebar-property-card">
                <div class="sidebar-property-image">
                  <img src="assets/img/real-estate/property-exterior-1.webp" alt="Modern Condo" class="img-fluid">
                  <div class="sidebar-property-badge new">For Sale</div>
                </div>
                <div class="sidebar-property-content">
                  <h4><a href="property-details.html">Contemporary Downtown Condo</a></h4>
                  <div class="sidebar-location">
                    <i class="bi bi-pin-map"></i>
                    <span>Seattle, WA 98101</span>
                  </div>
                  <div class="sidebar-specs">
                    <span><i class="bi bi-house"></i> 3 BR</span>
                    <span><i class="bi bi-droplet"></i> 2 BA</span>
                    <span><i class="bi bi-rulers"></i> 2,100 sq ft</span>
                  </div>
                  <div class="sidebar-price-row">
                    <div class="sidebar-price">₱1,595,000</div>
                    <a href="property-details.html" class="sidebar-btn">View</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="properties-sidebar">
              <div class="sidebar-property-card">
                <div class="sidebar-property-image">
                  <img src="assets/img/real-estate/property-exterior-2.webp" alt="Modern Condo" class="img-fluid">
                  <div class="sidebar-property-badge new">For Sale</div>
                </div>
                <div class="sidebar-property-content">
                  <h4><a href="property-details.html">Contemporary Downtown Condo</a></h4>
                  <div class="sidebar-location">
                    <i class="bi bi-pin-map"></i>
                    <span>Seattle, WA 98101</span>
                  </div>
                  <div class="sidebar-specs">
                    <span><i class="bi bi-house"></i> 3 BR</span>
                    <span><i class="bi bi-droplet"></i> 2 BA</span>
                    <span><i class="bi bi-rulers"></i> 2,100 sq ft</span>
                  </div>
                  <div class="sidebar-price-row">
                    <div class="sidebar-price">₱1,595,000</div>
                    <a href="property-details.html" class="sidebar-btn">View</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6">
            <div class="properties-sidebar">
              <div class="sidebar-property-card">
                <div class="sidebar-property-image">
                  <img src="assets/img/real-estate/property-exterior-3.webp" alt="Modern Condo" class="img-fluid">
                  <div class="sidebar-property-badge new">For Sale</div>
                </div>
                <div class="sidebar-property-content">
                  <h4><a href="property-details.html">Contemporary Downtown Condo</a></h4>
                  <div class="sidebar-location">
                    <i class="bi bi-pin-map"></i>
                    <span>Seattle, WA 98101</span>
                  </div>
                  <div class="sidebar-specs">
                    <span><i class="bi bi-house"></i> 3 BR</span>
                    <span><i class="bi bi-droplet"></i> 2 BA</span>
                    <span><i class="bi bi-rulers"></i> 2,100 sq ft</span>
                  </div>
                  <div class="sidebar-price-row">
                    <div class="sidebar-price">₱1,595,000</div>
                    <a href="property-details.html" class="sidebar-btn">View</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
    </section>
    <!-- /Featured Properties Section -->


    <!-- Call To Action Section -->
    <section
      class="call-to-action-1 call-to-action section"
      id="call-to-action">
      <div
        class="cta-bg"
        style="
            background-image: url('assets/img/real-estate/showcase-3.webp');
          "></div>
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row justify-content-center">
          <div class="col-xl-6 col-lg-8">
            <div class="cta-content text-center">
              <h2>Looking for the Perfect Lot?</h2>
              <p>
                Explore premium residential and commercial lots. Let our expert agents guide you to your ideal investment.
              </p>

              <div class="cta-buttons">
                <a href="contact" class="btn btn-primary">Contact Us Today</a>
              </div>

              <div class="cta-features">
                <div
                  class="feature-item"
                  data-aos="fade-up"
                  data-aos-delay="200">
                  <i class="bi bi-telephone-fill"></i>
                  <span>Free Consultation</span>
                </div>
                <div
                  class="feature-item"
                  data-aos="fade-up"
                  data-aos-delay="250">
                  <i class="bi bi-clock-fill"></i>
                  <span>24/7 Support</span>
                </div>
                <div
                  class="feature-item"
                  data-aos="fade-up"
                  data-aos-delay="300">
                  <i class="bi bi-shield-check-fill"></i>
                  <span>Trusted Experts</span>
                </div>
              </div>
            </div>
            <!-- End CTA Content -->
          </div>
        </div>
      </div>
    </section>
    <!-- /Call To Action Section -->


    <!-- Featured Services Section -->

    <!-- End Featured Services Section -->



    <!-- Featured Agents Section -->
    <section id="featured-agents" class="featured-agents section">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Meet Our Top Agents</h2>
        <p>
          Connect with our trusted real estate professionals ready to help you find the perfect lot or property.
        </p>
      </div>
      <!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 justify-content-center">
          <div
            class="col-lg-3 col-md-6"
            data-aos="zoom-in"
            data-aos-delay="100">
            <div class="featured-agent">
              <div class="agent-wrapper">
                <div class="agent-photo">
                  <img
                    src="assets/img/real-estate/agent-3.webp"
                    alt="Featured Agent"
                    class="img-fluid" />
                  <div class="overlay-info">
                    <div class="contact-actions">
                      <a
                        href="tel:+14155678901"
                        class="contact-btn phone"
                        title="Call Now">
                        <i class="bi bi-telephone-fill"></i>
                      </a>
                      <a
                        href="mailto:jennifer.adams@example.com"
                        class="contact-btn email"
                        title="Send Email">
                        <i class="bi bi-envelope-fill"></i>
                      </a>
                    </div>
                  </div>
                  <span class="achievement-badge">Star Agent</span>
                </div>
                <div class="agent-details">
                  <h4>Jennifer Adams</h4>
                  <span class="position">Premium Property Consultant</span>
                  <div class="location-info">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Beverly Hills</span>
                  </div>
                  <a href="agent-profile.html" class="view-profile">View Profile</a>
                </div>
              </div>
            </div>
          </div>
          <!-- End Featured Agent -->

          <div
            class="col-lg-3 col-md-6"
            data-aos="zoom-in"
            data-aos-delay="200">
            <div class="featured-agent">
              <div class="agent-wrapper">
                <div class="agent-photo">
                  <img
                    src="assets/img/real-estate/agent-7.webp"
                    alt="Featured Agent"
                    class="img-fluid" />
                  <div class="overlay-info">
                    <div class="contact-actions">
                      <a
                        href="tel:+14155678902"
                        class="contact-btn phone"
                        title="Call Now">
                        <i class="bi bi-telephone-fill"></i>
                      </a>
                      <a
                        href="mailto:marcus.hayes@example.com"
                        class="contact-btn email"
                        title="Send Email">
                        <i class="bi bi-envelope-fill"></i>
                      </a>
                    </div>
                  </div>
                  <span class="achievement-badge expert">Expert</span>
                </div>
                <div class="agent-details">
                  <h4>Marcus Hayes</h4>
                  <span class="position">Commercial Real Estate Lead</span>
                  <div class="location-info">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Manhattan</span>
                  </div>
                  <a href="agent-profile.html" class="view-profile">View Profile</a>
                </div>
              </div>
            </div>
          </div>
          <!-- End Featured Agent -->

          <div
            class="col-lg-3 col-md-6"
            data-aos="zoom-in"
            data-aos-delay="300">
            <div class="featured-agent">
              <div class="agent-wrapper">
                <div class="agent-photo">
                  <img
                    src="assets/img/real-estate/agent-5.webp"
                    alt="Featured Agent"
                    class="img-fluid" />
                  <div class="overlay-info">
                    <div class="contact-actions">
                      <a
                        href="tel:+14155678903"
                        class="contact-btn phone"
                        title="Call Now">
                        <i class="bi bi-telephone-fill"></i>
                      </a>
                      <a
                        href="mailto:sophia.rivera@example.com"
                        class="contact-btn email"
                        title="Send Email">
                        <i class="bi bi-envelope-fill"></i>
                      </a>
                    </div>
                  </div>
                  <span class="achievement-badge rising">Rising Star</span>
                </div>
                <div class="agent-details">
                  <h4>Sophia Rivera</h4>
                  <span class="position">First-Time Buyer Specialist</span>
                  <div class="location-info">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>San Francisco</span>
                  </div>
                  <a href="agent-profile.html" class="view-profile">View Profile</a>
                </div>
              </div>
            </div>
          </div>
          <!-- End Featured Agent -->

          <div
            class="col-lg-3 col-md-6"
            data-aos="zoom-in"
            data-aos-delay="400">
            <div class="featured-agent">
              <div class="agent-wrapper">
                <div class="agent-photo">
                  <img
                    src="assets/img/real-estate/agent-9.webp"
                    alt="Featured Agent"
                    class="img-fluid" />
                  <div class="overlay-info">
                    <div class="contact-actions">
                      <a
                        href="tel:+14155678904"
                        class="contact-btn phone"
                        title="Call Now">
                        <i class="bi bi-telephone-fill"></i>
                      </a>
                      <a
                        href="mailto:daniel.morrison@example.com"
                        class="contact-btn email"
                        title="Send Email">
                        <i class="bi bi-envelope-fill"></i>
                      </a>
                    </div>
                  </div>
                  <span class="achievement-badge veteran">Veteran</span>
                </div>
                <div class="agent-details">
                  <h4>Daniel Morrison</h4>
                  <span class="position">Investment Property Advisor</span>
                  <div class="location-info">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>Austin</span>
                  </div>
                  <a href="agent-profile.html" class="view-profile">View Profile</a>
                </div>
              </div>
            </div>
          </div>
          <!-- End Featured Agent -->
        </div>

        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="500">
          <a href="agents.html" class="discover-all-agents">
            <span>Discover All Agents</span>
            <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
    </section>
    <!-- /Featured Agents Section -->



    <!-- Testimonials Section -->

    <!-- End Testimonials Section -->



    <!-- Why Us Section -->

    <!-- End Why Us Section -->



    <!-- Recent Blog Posts Section -->

    <!-- End Recent Blog Posts Section -->

  </main>

  <?php include 'includes_landing_page/footer.php'; ?>