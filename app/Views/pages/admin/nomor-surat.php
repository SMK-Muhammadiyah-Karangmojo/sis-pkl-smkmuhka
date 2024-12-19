<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card col">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <button class="btn btn-outline-primary" data-toggle="modal"
                data-target="#modal-nomor-surat">
            <em class="fa fa-plus"></em> Tambah Nomor Surat
        </button>
        <table id="dataTable" class="table table-bordered table-striped">
            <caption>Daftar Nomor surat</caption>
            <thead>
            <tr>
                <th id="nomor-table ">No</th>
                <th>Tahun Pelajaran</th>
                <th>Kategori Surat</th>
                <th>Nomor</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
                <tr>
                    <td id="nomor-table "><?= $no++; ?></td>
                    <td id="name"><?= $d->tpName; ?></td>
                    <td id="name"><?= $d->kategori; ?></td>
                    <td id="name"><?= $d->nomor; ?></td>
                    <td id="name"><?= tgl2($d->tanggal); ?></td>
                    <td>
                        <button class="btn btn-primary btn-xs" onclick="updateNomorSurat(<?= $d->id; ?>)">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-xs" onclick="deleteNomorSurat(<?= $d->id; ?>)">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->include('pages/admin/modal/modal-tambah-nomor-surat'); ?>
<?= $this->endSection() ?>; ?>