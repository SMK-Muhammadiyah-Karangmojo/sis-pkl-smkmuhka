<?= $this->extend('certificate/template'); ?>
<?= $this->section('content'); ?>
    <!-- content -->
    <div class="container mt-3">
        <h4 style="text-align: center;">Setting Tabel Sertifikat</h4>
        <div>
            <table class="table table-bordered">
                <button class="btn btn-outline-warning mb-3" data-bs-toggle="modal"
                        data-bs-target="#modal-tambah-data">Tambah Data
                </button>
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tahun Pelajaran</th>
                    <th>Kelas</th>
                    <th>Nama Row</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;
                //                dd($data);
                ?>
                <?php foreach ($data as $d) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $d->tp; ?></td>
                        <td><?= $d->code; ?></td>
                        <td><?= $d->name; ?></td>
                        <td>
                            <!--                            <a href="-->
                            <?php //= base_url('sertifikat/sertifikat-depan?kelas=') . $d->kelas . "&nisn=" . $d->nisn; ?><!--">-->
                            <!--                                <badge style="cursor:pointer" class="badge bg-primary">DEPAN</badge>-->
                            <!--                            </a>-->
                            <!--                            <a href="-->
                            <?php //= base_url('sertifikat/sertifikat-belakang?kelas=') . $d->kelas . "&nisn=" . $d->nisn; ?><!--">-->
                            <!--                                <badge style="cursor:pointer" class="badge bg-info">BELAKANG</badge>-->
                            <!--                            </a>-->
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-tambah-data">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cetak Surat Permohonan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('/sertifikat/setting'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tp">Tahun Pelajaran</label>
                            <select class="form-control" type="text" id="tp" name="tp" required>
                                <option value="">--Pilih Tahun Pelajaran--</option>
                                <?php foreach ($tp as $m): ?>
                                    <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Nama Row</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                    </div>
                    <input type="hidden" name="code" id="code" value="<?= $kelas; ?>">
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end content -->
<?= $this->endSection() ?>