<div class="left-side-bar">

    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <img src="../assets/img/aarc.webp"
                alt="Amazzeng Angels Realty Logo"
                width="25"
                class="me-2 mr-2 mt-1">

            <div class="d-flex flex-column lh-1">
                <span style="font-size: 14px; line-height: 2; color: #ffd700;">AMMAZENG ANGELS</span>
                <span style="font-size: 11px; line-height: 1;">REALTY CORPORATION</span>
            </div>
        </a>

        <div class="close-sidebar mt-2 mr-2" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>

    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">

                <!-- ADMIN -->
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li>
                        <a href="index" class="<?= $page->isActive('dashboard') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-tachometer"></span><span class="mtext">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="properties" class="<?= $page->isActive('properties') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-home"></span><span class="mtext">Properties</span>
                        </a>
                    </li>

                    <li>
                        <a href="users" class="<?= $page->isActive('users') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-user-secret"></span><span class="mtext">Users</span>
                        </a>
                    </li>

                    <li>
                        <a href="commissions" class="<?= $page->isActive('commissions') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-percent"></span><span class="mtext">Commissions</span>
                        </a>
                    </li>

                    <li>
                        <a href="reports" class="<?= $page->isActive('reports') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-file-text"></span><span class="mtext">Reports</span>
                        </a>
                    </li>


                    <!-- STAFF MENUS -->
                <?php elseif ($_SESSION['role'] === 'staff'): ?>

                    <li>
                        <a href="index" class="<?= $page->isActive('dashboard') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-tachometer"></span><span class="mtext">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="clients" class="<?= $page->isActive('clients') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-users"></span><span class="mtext">Clients</span>
                        </a>
                    </li>

                    <li>
                        <a href="payments" class="<?= $page->isActive('payments') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-credit-card"></span><span class="mtext">Payments</span>
                        </a>
                    </li>

                    <li>
                        <a href="commissions" class="<?= $page->isActive('commissions') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-percent"></span><span class="mtext">Commissions</span>
                        </a>
                    </li>

                    <li>
                        <a href="del_test" class="<?= $page->isActive('overdue') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-exclamation-circle"></span><span class="mtext">Overdue</span>
                        </a>
                    </li>

                    <!-- AGENT MENUS -->
                <?php elseif ($_SESSION['role'] === 'agent'): ?>

                    <li>
                        <a href="index" class="<?= $page->isActive('dashboard') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-tachometer"></span><span class="mtext">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="leads" class="<?= $page->isActive('leads') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-bullhorn"></span><span class="mtext">Leads</span>
                        </a>
                    </li>

                    <li>
                        <a href="commissions" class="<?= $page->isActive('commissions') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-percent"></span><span class="mtext">Commissions</span>
                        </a>
                    </li>


                    <!-- CLIENT MENUS -->
                <?php elseif ($_SESSION['role'] === 'client'): ?>

                    <li>
                        <a href="index" class="<?= $page->isActive('dashboard') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-tachometer"></span><span class="mtext">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="payments" class="<?= $page->isActive('payments') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-bullhorn"></span><span class="mtext">My Payments</span>
                        </a>
                    </li>

                    <li>
                        <a href="balance" class="<?= $page->isActive('balance') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-balance-scale"></span><span class="mtext">My Balance</span>
                        </a>
                    </li>

                    <li>
                        <a href="penalties" class="<?= $page->isActive('penalties') ?> dropdown-toggle no-arrow">
                            <span class="micon fa fa-exclamation-circle"></span><span class="mtext">Penalties</span>
                        </a>
                    </li>


                <?php endif; ?>

                <!-- <li>
                    <a href="agents" class="<?= $page->isActive('agents') ?> dropdown-toggle no-arrow">
                        <span class="micon fa fa-user-secret"></span><span class="mtext">Agents</span>
                    </a>
                </li>

                <li>
                    <a href="Payments" class="<?= $page->isActive('payments') ?> dropdown-toggle no-arrow">
                        <span class="micon fa fa-money"></span><span class="mtext">Payments</span>
                    </a>
                </li>

                <li>
                    <a href="Sales" class="<?= $page->isActive('sales') ?> dropdown-toggle no-arrow">
                        <span class="micon fa fa-shopping-cart"></span><span class="mtext">Sales</span>
                    </a>
                </li> -->



                <!-- <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon bi bi-house"></span><span class="mtext">Home</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="index.html">Dashboard style 1</a></li>
                        <li><a href="index2.html">Dashboard style 2</a></li>
                        <li><a href="index3.html">Dashboard style 3</a></li>
                    </ul>
                </li> -->

            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>