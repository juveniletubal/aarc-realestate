<header id="header" class="header d-flex align-items-center sticky-top">
    <div
        class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="" class="logo d-flex align-items-center">
            <img src="assets/img/aarc.webp" alt="" width="27">
            <div class="d-flex flex-column lh-1">
                <h1 class="sitename mb-0" style="font-size: 18px; color: #ffd700;">AMMAZENG ANGELS</h1>
                <span class="small text-white">REALTY CORPORATION</span>
            </div>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="index" class="<?= $page->isActive('home') ?>">Home</a></li>
                <li><a href="about" class="<?= $page->isActive('about') ?>">About</a></li>
                <li><a href="properties" class="<?= $page->isActive('properties') ?>">Properties</a></li>
                <li><a href="agents" class="<?= $page->isActive('agents') ?>">Agents</a></li>
                <li><a href="contact" class="<?= $page->isActive('contact') ?> me-3">Contact</a></li>
                <li><button class="btn btn-outline-warning me-2" onclick="location.href='login'">Login</button></li>
                <li><button class="btn btn-warning" onclick="location.href='register'">Signup</button></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
    </div>
</header>