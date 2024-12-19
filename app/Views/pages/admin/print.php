<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card col">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="print">
                <button class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                        data-target="#modal-default">
                    <em class="fa fa-print"></em>
                    <span class="print-name">Permohonan PKL</span>
                </button>
            </div>
            <div class="print">
                <button class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                        data-target="#modal-surat-tugas">
                    <em class="fa fa-print"></em>
                    <span class="print-name">Surat Tugas</span>
                </button>
            </div>
            <div class="print">
                <button class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                        data-target="#modal-surat-pengantar">
                    <em class="fa fa-print"></em>
                    <span class="print-name">Surat Pengantar</span>
                </button>
            </div>
            <div class="print">
                <button class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                        data-target="#modal-id-card">
                    <em class="fa fa-money-check-alt"></em>
                    <span class="print-name">ID Card</span>
                </button>
            </div>
            <div class="print">
                <button class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                        data-target="#modal-kop-surat">
                    <em class="fa fa-envelope"></em>
                    <span class="print-name">Kop Surat</span>
                </button>
            </div>
            <div class="print">
                <button class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                        data-target="#modal-surat-jalan">
                    <em class="fa fa-envelope"></em>
                    <span class="print-name">Surat Jalan</span>
                </button>
            </div>
            <div class="print">
                <button class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                        data-target="#modal-daftar-siswa">
                    <em class="fa fa-users"></em>
                    <span class="print-name">Daftar Peserta</span>
                </button>
            </div>
            <div class="print">
                <button class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                        data-target="#modal-lembar-monitoring">
                    <em class="fa fa-sticky-note"></em>
                    <span class="print-name">Lembar Monitoring</span>
                </button>
            </div>
            <div class="print">
                <button class="btn bg-gradient-primary btn-sm" data-toggle="modal"
                        data-target="#modal-daftar-hadir">
                    <em class="fa fa-users"></em>
                    <span class="print-name">Daftar Hadir Siswa</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->include('pages/admin/modal/modal-cetak-surat-permohonan'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-surat-tugas'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-surat-pengantar'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-id-card'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-kop-surat'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-surat-jalan'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-daftar-peserta'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-lembar-monitoring'); ?>
<?= $this->include('pages/admin/modal/modal-cetak-daftar-hadir'); ?>
<?= $this->endSection() ?>; ?>