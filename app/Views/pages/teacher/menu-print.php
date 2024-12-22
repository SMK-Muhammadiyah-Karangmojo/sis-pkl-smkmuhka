<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>NAMA</th>
                        <th>ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Lembar Monitoring</td>
                        <td>
                            <a href="<?= base_url('teacher/monitoring/' . $data->id); ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-print"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Surat Tugas</td>
                        <td>
                            <a href="<?= base_url('teacher/surat-tugas/' . $data->id); ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa-solid fa-print"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?= $this->include('pages/admin/modal/modal-cetak-surat-tugas'); ?>
<?= $this->endSection(); ?>