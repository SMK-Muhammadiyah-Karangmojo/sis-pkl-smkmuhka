<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-3">
                <select class="form-control" id="jurusan" name="jurusan" onchange="getMentorDetail()">
                    <option value="">-- Pilih Jurusan --</option>
                    <?php foreach ($jurusan as $j): ?>
                        <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <table id="dataTable" class="table table-bordered table-striped">
            <caption>Data mentor/pembimbing PKL</caption>
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Tahun Pelajaran</th>
                <th>Iduka</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>No. Telp</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($iduka as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $d->tp; ?></td>
                    <td id="name"><?= $d->iduka; ?></td>
                    <td id="name"><?= $d->name; ?></td>
                    <td id="name"><?= $d->position; ?></td>
                    <td id="name"><?= $d->hp; ?></td>
                    <td id="name"><?= $d->email; ?></td>
                    <td>
                        <button class="btn btn-primary btn-xs" onclick="editMentor(<?= $d->id; ?>)">
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

<?= $this->endSection() ?>; ?>