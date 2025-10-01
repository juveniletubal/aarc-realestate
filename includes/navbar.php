<div class="header">
    <div class="header-left">
        <div class="menu-icon fa fa-bars" style="font-size: 21px;"></div>
    </div>
    <div class="header-right">
        <div class="user-notification">
            <div class="dropdown">
                <a
                    class="dropdown-toggle no-arrow"
                    href="#"
                    role="button"
                    data-toggle="dropdown">
                    <i class="icon-copy fa fa-bell-o"></i>
                    <span class="badge notification-active"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="notification-list mx-h-350 customscroll">
                        <ul>
                            <li>
                                <a href="#">
                                    <img src="../assets/img/person/person-m-5.webp" alt="" />
                                    <h3>John Doe</h3>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit, sed...
                                    </p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <img src="../assets/img/person/person-m-6.webp" alt="" />
                                    <h3>Lea R. Frith</h3>
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing
                                        elit, sed...
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a
                    class="dropdown-toggle"
                    href="#"
                    role="button"
                    data-toggle="dropdown">
                    <span class="user-icon">
                        <img src="<?php echo htmlspecialchars($_SESSION['image']); ?>" alt="User" />
                    </span>
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                </a>
                <div
                    class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="profile.html"><i class="fa fa-user-o"></i> Profile</a>
                    <a class="dropdown-item" href="profile.html"><i class="fa fa-gear"></i> Setting</a>
                    <a class="dropdown-item" href="faq.html"><i class="fa fa-question-circle-o"></i> Help</a>
                    <a class="dropdown-item" href="../auth/logout"><i class="fa fa-sign-out"></i> Log Out</a>
                </div>
            </div>
        </div>
    </div>
</div>