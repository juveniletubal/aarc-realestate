<div class="sidebar sidebar-style-2" data-background-color="dark">

    <div class="sidebar-logo">
        <div class="logo-header d-flex align-items-center justify-content-between px-4 py-2 flex-wrap w-100" data-background-color="dark">
            <a href="index.php" class="logo d-flex align-items-center text-white text-decoration-none w-100 justify-content-center justify-content-md-start">
                <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" height="40" />

                <span class="fw-bold ms-3 d-none d-md-inline navbar-brand" alt="navbar brand" style="font-size: 20px;">Y P M S</span>
                <span class="fw-bold ms-2 d-inline d-md-none text-center small-text">Youth Profiling Management System</span>
            </a>
            <div class="nav-toggle d-flex align-items-center ms-md-auto mt-2 mt-md-0">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more mt-2 mt-md-0"><i class="gg-more-vertical-alt"></i></button>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item <?php echo $page->isActive('dashboard'); ?>">
                    <a href="index">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>

                <li class="nav-item <?php echo $page->isActive('users'); ?>">
                    <a href="users.php">
                        <i class="fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>

                <li class="nav-item <?php echo $page->isActive('tables'); ?>">
                    <a href="tables.php">
                        <i class="fas fa-table"></i>
                        <p>Tables</p>
                    </a>
                </li>

                <li class="nav-item <?php echo $page->isActive('forms'); ?>">
                    <a href="forms.php">
                        <i class="fas fa-pen-square"></i>
                        <p>Forms</p>
                    </a>
                </li>

                <li class="nav-item <?php echo $page->isActive('charts'); ?>">
                    <a data-bs-toggle="collapse" href="#charts" class="collapsed">
                        <i class="fas fa-chart-bar"></i>
                        <p>Charts</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="charts">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="charts-basic.php">
                                    <span class="sub-item">Basic Charts</span>
                                </a>
                            </li>
                            <li>
                                <a href="charts-advanced.php">
                                    <span class="sub-item">Advanced Charts</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item <?php echo $page->isActive('settings'); ?>">
                    <a href="settings.php">
                        <i class="fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>