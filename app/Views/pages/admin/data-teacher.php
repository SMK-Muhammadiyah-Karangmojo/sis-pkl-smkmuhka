<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card col-lg">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <button class="btn btn-outline-primary" onclick="addTeacher()">
            <i class="fa fa-plus"></i> Tambah Guru
        </button>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Action</th>
                <th>NIP/NBM</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>HP</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php if (isset($data)) {
                foreach ($data as $d) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <button class="btn btn-primary btn-xs" onclick="updateTeacher(<?= $d->id; ?>)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                        <td><?= $d->nbm; ?></td>
                        <td><?= $d->name; ?></td>
                        <td><?= $d->position; ?></td>
                        <td><?= $d->hp; ?></td>
                    </tr>
                <?php endforeach;
            } ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>; ?>