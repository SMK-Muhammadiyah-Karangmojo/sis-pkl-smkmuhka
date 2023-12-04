<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <select class="form-control-info" id="jurusan" name="jurusan" onchange="getIduka()">
            <option value="">-- Pilih Jurusan --</option>
            <?php foreach ($jurusan as $j): ?>
                <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn-outline-primary" onclick="addIduka()">
            <i class="fa fa-plus"></i> Tambah Iduka
        </button>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Jurusan</th>
                <th>Iduka</th>
                <th>Alamat</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($iduka as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td id="name"><?= $d->major; ?></td>
                    <td id="name"><?= $d->name; ?></td>
                    <td id="address"><?= $d->address; ?></td>
                    <td>
                        <button class="btn btn-primary btn-xs"
                                onclick="updateIduka(<?= $d->id; ?>, <?= $d->majorId; ?>)">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-xs" onclick="deleteIduka(<?= $d->id; ?>)">
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