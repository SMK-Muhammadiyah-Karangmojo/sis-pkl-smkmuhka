<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <select class="form-control col-lg-3" id="tp1" name="tp1">
                <option value="">-- Pilih Tahun Pelajaran --</option>
                <?php foreach ($tp as $j): ?>
                    <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control col-lg-3" id="major" name="major" onchange="pendamping()">
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($major as $j): ?>
                    <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>NIP/NBM</th>
                <th>Nama</th>
                <th>Iduka</th>
                <th>Tahun Pelajaran</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($tutor as $s) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td id="name"><?= $s->nbm; ?></td>
                    <td id="name"><?= $s->name; ?></td>
                    <td id="name"><?= $s->iduka; ?></td>
                    <td id="name"><?= $s->tp; ?></td>
                    <td>
                        <button class="btn btn-primary btn-xs" onclick="
                                editTutor(<?= $s->id; ?>)" data-toggle="modal" data-target="#modal-edit"> Edit
                        </button>
                        <button class="btn btn-danger btn-xs" onclick="
                                deleteTutor(<?= $s->id; ?>)" data-toggle="modal" data-target="#modal-edit"> Hapus
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#modal-default">
            <i class="fa fa-plus"></i> Tambah Pendamping
        </button>
    </div>
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cetak Surat Permohonan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select class="form-control" type="text" id="tp" name="tp" required>
                        <option value="">--Pilih Tahun Pelajaran--</option>
                        <?php foreach ($tp as $m): ?>
                            <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" type="text" id="major_id" name="major_id"
                            onchange="getAllIdukaByTp()" required>
                        <option value="">--Pilih Jurusan--</option>
                        <?php foreach ($major as $m): ?>
                            <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" type="text" id="iduka" name="iduka" required>
                        <option value="">--Pilih Iduka--</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" type="text" id="teacher" name="teacher" required>
                        <option value="">--Pilih Guru--</option>
                        <?php foreach ($teacher as $t): ?>
                            <option value="<?= $t->id; ?>"><?= $t->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" onclick="addPendamping()">Save</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>; ?>