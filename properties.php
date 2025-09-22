<?php
require_once 'includes_landing_page/init.php';

$page->setTitle('AARC - Properties');
$page->setCurrentPage('properties');

loadCoreAssets($assets, 'landing_page');

include 'includes_landing_page/header.php';
?>

<body class="properties-page">

    <?php include 'includes_landing_page/navbar.php'; ?>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title light-background">
            <div class="container d-lg-flex justify-content-between align-items-center">
                <h1 class="mb-2 mb-lg-0">Properties</h1>
                <nav class="breadcrumbs">
                    <ol>
                        <li><a href="index">Home</a></li>
                        <li class="current">Properties</li>
                    </ol>
                </nav>
            </div>
        </div><!-- End Page Title -->

        <!-- Properties Section -->
        <section id="properties" class="properties section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="search-bar mb-5" data-aos="fade-up" data-aos-delay="150">
                    <div class="row justify-content-center">
                        <div class="col-lg-10">
                            <div class="search-wrapper">
                                <div class="row g-3">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="search-field">
                                            <label>Location</label>
                                            <input type="text" class="form-control" placeholder="Enter city or zip">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6">
                                        <div class="search-field">
                                            <label>Type</label>
                                            <select class="form-select">
                                                <option>Any Type</option>
                                                <option>House</option>
                                                <option>Apartment</option>
                                                <option>Condo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6">
                                        <div class="search-field">
                                            <label>Price</label>
                                            <select class="form-select">
                                                <option>Any Price</option>
                                                <option>100</option>
                                                <option>200</option>
                                                <option>300</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-12">
                                        <div class="search-field">
                                            <label>&nbsp;</label>
                                            <button class="btn btn-primary w-100 search-btn">
                                                <i class="bi bi-search"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="results-header mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="results-info">
                                <h5>124 Properties Found</h5>
                                <p class="text-muted">Showing properties in General Santos City, Ph</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="results-controls">
                                <div class="d-flex gap-3 align-items-center justify-content-lg-end">
                                    <div class="sort-dropdown">
                                        <select class="form-select form-select-sm">
                                            <option>Price: Low to High</option>
                                            <option>Price: High to Low</option>
                                            <option>Newest First</option>
                                            <option>Largest Size</option>
                                        </select>
                                    </div>
                                    <div class="view-toggle">
                                        <button class="view-btn active" data-view="masonry">
                                            <i class="bi bi-grid"></i>
                                        </button>
                                        <button class="view-btn" data-view="rows">
                                            <i class="bi bi-view-stacked"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="properties-container">

                    <div class="properties-masonry view-masonry active" data-aos="fade-up" data-aos-delay="250">
                        <div class="row g-4">

                            <div class="col-lg-4 col-md-6">
                                <div class="property-item">
                                    <a href="property-details.html" class="property-link">
                                        <div class="property-image-wrapper">
                                            <img src="assets/img/real-estate/property-exterior-2.webp" alt="Luxury Villa" class="img-fluid">
                                            <div class="property-status">
                                                <span class="status-badge sale">For Sale</span>
                                            </div>
                                            <div class="property-actions">
                                                <button class="action-btn gallery-btn" data-toggle="tooltip" title="View Gallery">
                                                    <i class="bi bi-images"></i>
                                                    <span class="gallery-count">14</span>
                                                </button>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="property-details"><a href="property-details.html" class="property-link">
                                            <div class="property-header">
                                                <div class="property-price">₱1,850,000</div>
                                                <div class="property-type">House</div>
                                            </div>
                                            <h4 class="property-title">Luxury Modern Villa with Pool</h4>
                                            <p class="property-address">
                                                <i class="bi bi-geo-alt"></i>
                                                3458 Sunset Boulevard, Beverly Hills, CA 90210
                                            </p>
                                            <div class="property-specs">
                                                <div class="spec-item">
                                                    <i class="bi bi-house-door"></i>
                                                    <span>5 Bedrooms</span>
                                                </div>
                                                <div class="spec-item">
                                                    <i class="bi bi-droplet"></i>
                                                    <span>4 Bathrooms</span>
                                                </div>
                                                <div class="spec-item">
                                                    <i class="bi bi-arrows-angle-expand"></i>
                                                    <span>3,400 sq ft</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div><!-- End Property Item -->

                            <div class="col-lg-4 col-md-6">
                                <div class="property-item">
                                    <a href="property-details.html" class="property-link">
                                        <div class="property-image-wrapper">
                                            <img src="assets/img/real-estate/property-interior-1.webp" alt="Modern Apartment" class="img-fluid">
                                            <div class="property-status">
                                                <span class="status-badge sale">For Sale</span>
                                            </div>
                                            <div class="property-actions">
                                                <button class="action-btn gallery-btn" data-toggle="tooltip" title="View Gallery">
                                                    <i class="bi bi-images"></i>
                                                    <span class="gallery-count">9</span>
                                                </button>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="property-details"><a href="property-details.html" class="property-link">
                                            <div class="property-header">
                                                <div class="property-price">₱5,200</div>
                                                <div class="property-type">Apartment</div>
                                            </div>
                                            <h4 class="property-title">Downtown Modern Penthouse</h4>
                                            <p class="property-address">
                                                <i class="bi bi-geo-alt"></i>
                                                1247 Broadway Street, Manhattan, NY 10001
                                            </p>
                                            <div class="property-specs">
                                                <div class="spec-item">
                                                    <i class="bi bi-house-door"></i>
                                                    <span>3 Bedrooms</span>
                                                </div>
                                                <div class="spec-item">
                                                    <i class="bi bi-droplet"></i>
                                                    <span>2 Bathrooms</span>
                                                </div>
                                                <div class="spec-item">
                                                    <i class="bi bi-arrows-angle-expand"></i>
                                                    <span>2,100 sq ft</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div><!-- End Property Item -->

                            <div class="col-lg-4 col-md-6">
                                <div class="property-item">
                                    <a href="property-details.html" class="property-link">
                                        <div class="property-image-wrapper">
                                            <img src="assets/img/real-estate/property-exterior-5.webp" alt="Family Home" class="img-fluid">
                                            <div class="property-status">
                                                <span class="status-badge sale">For Sale</span>
                                            </div>
                                            <div class="property-actions">
                                                <button class="action-btn gallery-btn" data-toggle="tooltip" title="View Gallery">
                                                    <i class="bi bi-images"></i>
                                                    <span class="gallery-count">11</span>
                                                </button>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="property-details"><a href="property-details.html" class="property-link">
                                            <div class="property-header">
                                                <div class="property-price">₱975,000</div>
                                                <div class="property-type">House</div>
                                            </div>
                                            <h4 class="property-title">Charming Family Home with Garden</h4>
                                            <p class="property-address">
                                                <i class="bi bi-geo-alt"></i>
                                                892 Maple Grove Avenue, Austin, TX 73301
                                            </p>
                                            <div class="property-specs">
                                                <div class="spec-item">
                                                    <i class="bi bi-house-door"></i>
                                                    <span>4 Bedrooms</span>
                                                </div>
                                                <div class="spec-item">
                                                    <i class="bi bi-droplet"></i>
                                                    <span>3 Bathrooms</span>
                                                </div>
                                                <div class="spec-item">
                                                    <i class="bi bi-arrows-angle-expand"></i>
                                                    <span>2,650 sq ft</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div><!-- End Property Item -->

                        </div>
                    </div>

                </div>

                <nav class="pagination-wrapper mt-5" data-aos="fade-up" data-aos-delay="350">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-lg-6">
                            <div class="pagination-info">
                                <p>Showing <strong>1-6</strong> of <strong>124</strong> properties</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <ul class="pagination justify-content-lg-end">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">...</a></li>
                                <li class="page-item"><a class="page-link" href="#">21</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

            </div>

        </section><!-- /Properties Section -->

    </main>

    <?php include 'includes_landing_page/footer.php'; ?>