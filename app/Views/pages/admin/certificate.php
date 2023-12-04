<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= $subtitle; ?></h3>
        </div>
        <div class="card-body">
            <form action="" method="get">
                <div class="form-select">
                    <div class="form-group">
                        <select class="form-control" id="tp" name="tp" onchange="getIduka()">
                            <option value="">-- Pilih Tahun Palajaran --</option>
                            <?php foreach ($tp as $j): ?>
                                <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="major" name="major" onchange="getIduka()">
                            <option value="">-- Pilih Jurusan --</option>
                            <?php foreach ($jurusan as $j): ?>
                                <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-sm btn-outline-primary mb-3">SAVE</button>
                </div>
            </form>
            <table id="example1" class="table table-bordered table-striped" aria-describedby="mydesc">
                <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Tahun Pelajaran</th>
                    <th>Jurusan</th>
                    <th>IDUKA</th>
                    <th>Pembimbing</th>
                    <th>Cetak</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data as $d) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $d->nis; ?></td>
                        <td><?= $d->name; ?></td>
                        <td><?= $d->tp; ?></td>
                        <td><?= $d->major; ?></td>
                        <td><?= $d->iduka; ?></td>
                        <?php if ($d->mentor) : ?>
                            <td>
                                <?= $d->mentor; ?>
                                <div onclick="editMentor(<?= $d->ids; ?>)">
                                    <a class="badge badge-info" href="#">Edit</a>
                                </div>
                            </td>
                            <td>
                                <a href="<?= base_url("front-certificate?id=") . $d->id . "&majorId=" . $d->majorId; ?>">
                                    <button class="btn-sm btn-primary col-sm-12 mb-2">Depan</button>
                                </a>
                                <a href="<?= base_url("back-certificate?id=") . $d->id . "&majorId=" . $d->majorId; ?>">
                                    <button class="btn-sm btn-secondary col-sm-12">Belakang</button>
                                </a>
                            </td>
                        <?php else : ?>
                            <td>
                                <badge class="badge badge-danger">Belum Diisi</badge>
                                <div onclick="addMentor(<?= $d->idukaId; ?>, <?= $d->tpId; ?>)">
                                    <a href="#">Klik untuk melengkapi</a>
                                </div>
                            </td>
                            <td></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?= $this->endSection() ?>