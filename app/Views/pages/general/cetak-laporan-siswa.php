<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ID CARD</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css'); ?>">
</head>
<body>
<style>
    @page {
        margin-top: 0.5cm;
        margin-bottom: 0.5cm;
        margin-left: 1.5cm;
        margin-right: 1.5cm;
    }
</style>
<img src="<?= base_url('assets/img/kop.png'); ?>" alt="">
<div>
    <h3 align="center">
        DETAIL LAPORAN KEGIATAN PKL SISWA<br/>
        Tahun Pelajaran <?= $userDetail->tp ?>
    </h3>
</div>
<div class="form-group">
    <table class="table-responsive">
        <tbody>
        <tr>
            <td>
                <h4>Nama Siswa</h4>
            </td>
            <td>
                <h4>: <?= $userDetail->nis ?> | <?= $userDetail->name ?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Kelas</h4>
            </td>
            <td>
                <h4>: <?= $userDetail->kelas ?></h4>
            </td>
        </tr>
        <tr>
            <td>
                <h4>Kompetensi Keahlian</h4>
            </td>
            <td>
                <h4>: <?= $userDetail->major ?></h4>
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div>
    <h3>Daftar Kegiatan Siswa</h3>
    <div class="form-group">
        <table border="1" cellspacing="0" width="100%" class="table table-striped table-inverse table-responsive mt-3">
            <thead class="thead-inverse">
            <tr>
                <th width="15px">No</th>
                <th width="150px">Tanggal</th>
                <th>Bidang Pekerjaan</th>
                <th>Uraian Kegiatan</th>
                <th>Paraf</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($laporan as $l): ?>
                <?php
                if ($l->uraian_1 && $l->uraian_2) {
                    $uraian = "<p>$l->uraian_1</p>
                               <p>$l->uraian_2</p>
                                ";
                } elseif ($l->uraian_1) {
                    $uraian = "<p>$l->uraian_1</p>";
                } elseif ($l->other) {
                    $uraian = "<p>$l->other</p>";
                } ?>
                <tr>
                    <td class="top-center"><?= $no++; ?></td>
                    <td class="top"><?= tanggal($l->date); ?></td>
                    <td class="top"><?= $l->bidang_pekerjaan; ?></td>
                    <td><?= $uraian; ?></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>