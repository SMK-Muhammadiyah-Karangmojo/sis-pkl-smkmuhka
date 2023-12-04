<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card col-lg-6">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <button class="btn btn-outline-primary" onclick="addTp()">
            <i class="fa fa-plus"></i> Tambah Tahun Pelajaran
        </button>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Tahun Pelajaran</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($tp as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td id="name"><?= $d['name']; ?></td>
                    <td>
                        <button class="btn btn-primary btn-xs" onclick="updateTp(<?= $d['id'];?>)">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-xs" onclick="deleteTp(<?= $d['id'];?>)">
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.card-body -->

<?= $this->endSection() ?>; ?>