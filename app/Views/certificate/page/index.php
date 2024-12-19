<?= $this->extend('certificate/template'); ?>
<?= $this->section('content'); ?>
    <!-- content -->
    <div class="container mt-3">
        <h4 style="text-align: center;">Daftar Cetak Sertifikat Siswa</h4>
        <div>
            <table id="dataTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>NISN</th>
                    <th>Nama</th>
                    <th>Kelas</th>
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
                        <td><?= $d->nis; ?></td>
                        <td><?= $d->nisn; ?></td>
                        <td><?= $d->name; ?></td>
                        <td><?= $d->kelas; ?></td>
                        <td>
                            <a href="<?= base_url('sertifikat/sertifikat-depan?kelas=') . $d->kelas . "&nisn=" . $d->nisn; ?>">
                                <badge style="cursor:pointer" class="badge bg-primary">DEPAN</badge>
                            </a>
                            <a href="<?= base_url('sertifikat/sertifikat-belakang?kelas=') . $d->kelas . "&nisn=" . $d->nisn; ?>">
                                <badge style="cursor:pointer" class="badge bg-info">BELAKANG</badge>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- end content -->
<?= $this->endSection() ?>