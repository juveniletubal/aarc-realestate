<div class="left-side-bar">

    <div class="brand-logo d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <img src="../assets/img/aarc.webp"
                alt="Amazzeng Angels Realty Logo"
                width="26"
                class="me-2 mr-2 mt-1">

            <div class="d-flex flex-column lh-1">
                <span style="font-size: 14px; line-height: 2;">AMMAZENG ANGELS</span>
                <span style="font-size: 12px; line-height: 1;">REALTY CORPORATION</span>
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
                    <a href="agents" class="<?= $page->isActive('agents') ?> dropdown-toggle no-arrow">
                        <span class="micon fa fa-user-secret"></span><span class="mtext">Agents</span>
                    </a>
                </li>



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