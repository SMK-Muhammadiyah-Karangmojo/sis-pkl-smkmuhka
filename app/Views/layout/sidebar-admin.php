<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="<?= base_url(); ?>/assets/img/logo/logo-login.png" alt="Logo" class="brand-image
        img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">SIS PKL</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= base_url(); ?>/assets/img/users/default.png" class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $users; ?></a>
            </div>
        </div>
        <nav aria-label="Site menu" class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= base_url('admin'); ?>" class="nav-link">
                        <em class="nav-icon fas fa-tachometer-alt"></em>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <em class="nav-icon fas fa-bookmark"></em>
                        <p>
                            Data PKL
                            <em class="right fas fa-angle-left"></em>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/data'); ?>" class="nav-link">
                                <em class="far fa-circle nav-icon"></em>
                                <p>Data Siswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('nilai'); ?>" class="nav-link">
                                <em class="far fa-circle nav-icon"></em>
                                <p>Nilai Siswa</p>
                            </a>
                        </li>
                        <!--                        <li class="nav-item">-->
                        <!--                            <a href="-->
                        <?php //= base_url('admin/laporan'); ?><!--" class="nav-link">-->
                        <!--                                <em class="far fa-circle nav-icon"></em>-->
                        <!--                                <p>Laporan Siswa</p>-->
                        <!--                            </a>-->
                        <!--                        </li>-->
                        <li class="nav-item">
                            <a href="<?= base_url('admin/pendamping'); ?>" class="nav-link">
                                <em class="far fa-circle nav-icon"></em>
                                <p>Guru Pendamping</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/rekap'); ?>" class="nav-link">
                                <em class="far fa-circle nav-icon"></em>
                                <p>Rekap Data</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <em class="nav-icon fas fa-database"></em>
                        <p>
                            Master Data
                            <em class="right fas fa-angle-left"></em>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/iduka'); ?>" class="nav-link">
                                <em class="far fa-circle nav-icon"></em>
                                <p>Iduka</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('Mentor/mentor'); ?>" class="nav-link">
                                <em class="far fa-circle nav-icon"></em>
                                <p>Mentor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/nomor'); ?>" class="nav-link">
                                <em class="fa fa-sort-numeric-down nav-icon"></em>
                                <p>Nomor Surat</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/tp'); ?>" class="nav-link">
                                <em class="far fa-circle nav-icon"></em>
                                <p>Tahun Pelajaran</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <em class="nav-icon fas fa-user-friends"></em>
                        <p>
                            Master Users
                            <em class="right fas fa-angle-left"></em>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('admin/teacher'); ?>" class="nav-link">
                                <em class="far fa-circle nav-icon"></em>
                                <p>Guru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/student'); ?>" class="nav-link">
                                <em class="far fa-circle nav-icon"></em>
                                <p>Siswa</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url('admin/users'); ?>" class="nav-link">
                                <em class="far fa-circle nav-icon"></em>
                                <p>Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/master_sekolah'); ?>" class="nav-link">
                        <em class="nav-icon fa fa-school"></em>
                        <p>
                            Master Sekolah
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/print'); ?>" class="nav-link">
                        <em class="nav-icon fa fa-print"></em>
                        <p>Cetak</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('certificate'); ?>" class="nav-link">
                        <em class="nav-icon fa fa-certificate"></em>
                        <p>Cetak Sertifikat</p>
                    </a>
                </li>
            </ul>
        </nav>
        <hr style="border-color: white;">
        <nav class="mt-2" aria-label="Site menu">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item" onclick="logout()">
                    <div class="nav-link">
                        <em class="nav-icon fas fa-sign-out-alt"></em>
                        <p>
                            Logout
                        </p>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</aside>
