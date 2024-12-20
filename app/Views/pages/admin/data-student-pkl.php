<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?>
            <button class="badge btn-danger" onclick="syncData()">Sync Data</button>
        </h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group m-1">
                <select class="form-control" id="tp1" name="tp1">
                    <option value="">-- Pilih Tahun Pelajaran --</option>
                    <?php foreach ($tp as $j): ?>
                        <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group m-1">
                <select class="form-control" id="major" name="major" onchange="getStudentByMajor()">
                    <option value="">-- Pilih Jurusan --</option>
                    <?php foreach ($major as $j): ?>
                        <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Action</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Tahun Pelajaran</th>
                <th>Lokasi PKL</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php
//            dd($siswa);
            if (!empty($siswa)) {
                foreach ($siswa as $s) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="text-center">
                            <button class="btn btn-primary btn-xs" onclick="
                                    editStudent(<?= $s->id; ?>,<?= $s->masterDataId != null ? $s->masterDataId : "false"; ?>)
                                    " name="Edit"><i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                        <td id="name"><?= $s->nis; ?></td>
                        <td id="name"><?= $s->name; ?></td>
                        <td id="class"><?= $s->kelas; ?></td>
                        <td id="major"><?= $s->jurusan; ?></td>
                        <td id="major"><?= $s->tp; ?></td>
                        <td id="major"><?= $s->iduka; ?></td>
                    </tr>
                <?php endforeach;
            } ?>
            </tbody>
        </table>
    </div>
</div>
<!-- /.card-body -->

<?= $this->endSection() ?>; ?>