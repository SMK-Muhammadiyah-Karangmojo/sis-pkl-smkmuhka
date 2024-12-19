<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <button class="btn btn-sm btn-outline-primary" onclick="addIduka()">
            <i class="fa fa-plus"></i> Tambah Iduka
        </button>
    </div>
    <div class="card-body">
        <div class="row">
            <select class="form-control col-sm-4 mr-3" id="jurusan" name="jurusan" onchange="getIduka()">
                <option value="">-- Pilih Jurusan --</option>
                <?php if (isset($jurusan)) {
                    foreach ($jurusan as $j): ?>
                        <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                    <?php endforeach;
                } ?>
            </select>
        </div>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Action</th>
                <th>Jurusan</th>
                <th>Iduka</th>
                <th>Alamat</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php if (isset($iduka)) {
                foreach ($iduka as $d) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td>
                            <button class="btn btn-primary btn-xs"
                                    onclick="updateIduka(<?= $d->id; ?>, <?= $d->majorId; ?>)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button class="btn btn-danger btn-xs" onclick="deleteIduka(<?= $d->id; ?>)">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                        <td id="name"><?= $d->major; ?></td>
                        <td id="name"><?= $d->name; ?></td>
                        <td id="address"><?= $d->address; ?></td>
                    </tr>
                <?php endforeach;
            } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.card-body -->

<?= $this->endSection() ?>; ?>