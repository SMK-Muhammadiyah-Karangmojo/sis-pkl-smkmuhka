<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="<?= base_url(); ?>/assets/img/logo/logo-login.png" alt="Logo" class="brand-image
        img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">SIS PKL</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url('/assets/img/users/' . $data->image); ?>" class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $users; ?></a>
            </div>
        </div>
        <?php if ($role == '3') : ?>
            <nav class="mt-2" aria-label="">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="<?= base_url('student'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('student/profile'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-user-alt"></i>
                            <p>
                                Change Profile
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Data PKL
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('student/iduka'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Lokasi PKL</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('student/idCard'); ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>ID CARD</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="<?= base_url('student/laporan'); ?>" class="nav-link">
                            <i class="nav-icon fas fa-sticky-note"></i>
                            <p>
                                Laporan
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <hr style="border-color: white;">
            <nav class="mt-2" aria-label="">
                <ul class="nav nav-pills nav-sidebar flex-column">
                    <li class="nav-item" onclick="logout()">
                        <div class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                Logout
                            </p>
                        </div>
                    </li>
                </ul>
            </nav>
        <?php elseif (!$role): ?>
            <?php header('Location: ' . $_ENV['app.baseURL']); ?>
        <?php endif; ?>
    </div>
</aside>