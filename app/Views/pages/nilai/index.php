<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <div class="mb-5">
            <h3 class="card-title"><?= $title; ?></h3>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form action="" method="get">
                    <div class="form-group col-6">
                        <select class="form-control" id="tp" name="tp">
                            <option value="">-- Pilih Tahun Pelajaran --</option>
                            <?php foreach ($tp as $j): ?>
                                <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <select class="form-control" id="jurusan" name="jurusan" onchange="getAllIdukaByTpAndMajor()">
                            <option value="">-- Pilih Jurusan --</option>
                            <?php foreach ($jurusan as $j): ?>
                                <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <select class="form-control" id="iduka" name="iduka">
                            <option value="">-- Pilih Iduka --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary">SAVE</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h4>Export Nilai</h4>
                <form action="<?= base_url('export-nilai'); ?>">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="tp">Tahun Pelajaran</label>
                            <select class="form-control" name="tp" id="tp">
                                <option value="">-- Pilih Tahun Pelajaran --</option>
                                <?php foreach ($tp as $j): ?>
                                    <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label for="kelas">Kelas</label>
                            <select class="form-control" name="kelas" id="kelas">
                                <option value="">--kelas--</option>
                                <?php foreach ($kelas as $k): ?>
                                    <option value="<?= $k->id; ?>"><?= $k->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-success"><i class="fa fa-file-excel"> Export</i></button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form action="<?= base_url('add-nilai'); ?>" method="POST">
            <table class="table table-bordered table-striped">
                <caption>Data Nilai Siswa</caption>
                <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <?php if ($categoryNilai): ?>
                        <?php foreach ($categoryNilai as $cat): ?>
                            <th><?= $cat->name; ?></th>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <th>Nilai</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data as $d): ?>
                    <tr>
                        <input type="hidden" name="userPublicId[]" id="userPublicId" value="<?= $d->userPublicId; ?>">
                        <input type="hidden" name="id[]" id="id" value="<?= $d->id; ?>">
                        <td><?= $no++ ?></td>
                        <td><?= $d->name; ?></td>
                        <?php if ($categoryNilai): ?>
                            <?php foreach ($categoryNilai as $cat): ?>
                                <td>
                                    <?php
                                    $code = $cat->code; ?>
                                    <input style="width: 50px;" type="text"
                                           id="<?= $cat->code; ?>"
                                           name="<?= $cat->code; ?>[]"
                                           value="<?= $d->$code; ?>">
                                </td>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <td></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <input type="hidden" name="tp" id="tp" value="<?= $tpId; ?>">
            <input type="hidden" name="majorId" id="majorId" value="<?= $majorId; ?>">
            <input type="hidden" name="idukaId" id="idukaId" value="<?= $idukaId; ?>">
            <button type="submit" class="btn btn-primary">SIMPAN</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>; ?>