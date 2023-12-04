<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card col-lg">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <button class="btn btn-outline-primary" onclick="addUser()">
            <i class="fa fa-plus"></i> Tambah Siswa
        </button>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>NIS</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Tahun Pelajaran</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $d->nis; ?></td>
                    <td><?= $d->nisn; ?></td>
                    <td><?= $d->name; ?></td>
                    <td><?= jk($d->jk); ?></td>
                    <td><?= $d->kelas; ?></td>
                    <td><?= $d->jurusan; ?></td>
                    <td><?= $d->tp; ?></td>
                    <td>
                        <button class="btn btn-primary btn-xs" onclick="updateUser(<?= $d->userDetailId; ?>)">
                            Edit
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>; ?>