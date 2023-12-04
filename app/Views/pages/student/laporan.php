<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="container-sm">
                        <h3>Input Laporan</h3>
                        <form action="<?= base_url('student/laporan'); ?>" method="POST">
                            <div class="form-group">
                                <div>
                                    <div>
                                        <label for="date">Tanggal</label>
                                        <input type="date" class="form-control"
                                               id="date" name="date" required>
                                    </div>
                                    <label for="master_laporan">Bidang Pekerjaan</label>
                                    <select class="form-control"
                                            name="master_laporan"
                                            id="master_laporan"
                                            onchange="showMasterSubLaporan()"
                                            required>
                                        <option value="">Pilih Bidang Pekerjaan</option>
                                        <?php foreach ($master_data as $md): ?>
                                            <option value="<?= $md->id; ?>"><?= $md->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id="other_input"></div>
                                <div id="master_sub_laporan"></div>
                                <div id="master_sub_laporan_1"></div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">SIMPAN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3>Daftar laporan</h3>
                </div>
                <div class="card-body">
                    <table id="dataTable" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th width="10px">No</th>
                            <th>Tanggal</th>
                            <th>Bidang Pekerjaan</th>
                            <th>Uraian Pekerjaan</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($laporan as $l): ?>
                            <?php
                            if ($l->uraian_1 && $l->uraian_2) {
                                $uraian = "
                                        <ol>
                                            <li>$l->uraian_1</li>
                                            <li>$l->uraian_2</li>
                                        </ol>";
                            } elseif ($l->uraian_1) {
                                $uraian = "
                                        <ol>
                                            <li>$l->uraian_1</li>
                                        </ol>";
                            } elseif ($l->other) {
                                $uraian = "
                                        <ol>
                                            <li>$l->other</li>
                                        </ol>";
                            } ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= tanggal($l->date); ?></td>
                                <td><?= $l->bidang_pekerjaan; ?></td>
                                <td><?= $uraian; ?></td>
                                <td>
                                    <button class="badge bg-gradient-red" onclick="deleteReport(<?= $l->id; ?>)">
                                        <i class="fa fa-trash-o"> Hapus</i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>; ?>