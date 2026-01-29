<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                Menu
            </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="<?= base_url('user/profile'); ?>" class="dropdown-item">
                <i class="fas fa-user mr-2"></i> Profile
            </a>
            
            <div class="dropdown-divider"></div>
            <a href="<?= base_url('auth/logout'); ?>" class="dropdown-item">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
        </div>
        </li>
    </ul>
</nav>
