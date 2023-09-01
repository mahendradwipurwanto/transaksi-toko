<header class="main-header">
    <a href="<?= BASE_URL; ?>home" class="logo">
        <img src="<?= BASE_URL; ?>/assets/img/logo_small_1.png">
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <!--        <div class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="glyphicon glyphicon-triangle-left"> </span>
            </body>
        </div>-->
        <?php foreach ($header_menu as $row) : ?>
            <a href="<?= $row["main_url"] ?>" class="sidebar-toggle">
                <span class="<?= $row["class"] ?>"></span> <?= $row["desc"] ?>
            </a>
        <?php endforeach; ?>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= ASSETS_URL ?>img/user2-160x160.jpg" class="user-image" alt="User Image" />
                        <span class="hidden-xs"><?= $fullname ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="height: initial;">
                            <img src="<?= ASSETS_URL ?>img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                            <p><?= $fullname ?></p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?= $link_edit_profil ?>" class="btn btn-default btn-flat">Edit Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?= $link_logout ?>" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>