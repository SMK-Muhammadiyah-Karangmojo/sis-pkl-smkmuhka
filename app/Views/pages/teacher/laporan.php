<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3><b>Data Laporan Siswa</b></h3>
        </div>
        <div class="card-body">
            <form action="" method="get">
                <div class="row">
                    <select class="form-control col-sm-3" name="tp" id="tp">
                        <option value="">Pilih Tahun Pelajaran</option>
                        <?php
                        foreach ($tp as $item){
                            ?>
                            <option value="<?= $item['id']; ?>"><?= $item['name'];?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary ml-2">Lihat</button>
                </div>
            </form>
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="10px">No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Lokasi PKL</th>
                    <th>Laporan Kegiatan</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                <?php foreach ($laporan as $lp) : ?>
                    <?php
                    $db = db_connect();
                    $count = $db->query(
                        "select count(user_public_id) as total from data_laporan_siswa where user_public_id = $lp->id;"
                    )->getRow();
                    if ($count->total >= 1) {
                        $total_laporan = "<badge class='badge bg-gradient-green'>$count->total Laporan</badge>";
                    } else {
                        $total_laporan = "<badge class='badge bg-gradient-red'>Belum ada</badge>";
                    }
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $lp->nis; ?></td>
                        <td><?= $lp->name; ?></td>
                        <td><?= $lp->iduka; ?></td>
                        <td>
                            <?= $total_laporan; ?>
                        </td>
                        <td>
                            <a href="<?= base_url('teacher/printReport/' . $lp->id); ?>">
                                <button class="badge bg-gradient-gray-dark"><i class="fas fa-print"> Cetak</i></button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>; ?>