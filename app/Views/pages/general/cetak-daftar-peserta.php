<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Tugas</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css'); ?>">
    <style>
        @page {
            margin-top: 20px;
            height: 100%;
        }

        #body {
            height: 100%;
        }
    </style>
</head>
<body>
<?php foreach ($iduka as $idk): ?>
    <?php
    $db = db_connect();
    $data = $db->table('master_data md')
        ->select(
            'md.id, md.status, ud.name, i.id as idukaId, i.name as idukaName,
                ud.user_id as nis,ud.jk, class.name as kelas, m.name as majorName,
               tp.name as tpName')
        ->join('tp', 'tp.id = md.tp_id')
        ->join('iduka i', 'i.id = md.iduka_id')
        ->join('major m', 'm.id = i.major')
        ->join('user_details ud', 'ud.user_public_id = md.user_public_id')
        ->join('class', 'class.id = ud.class_id', 'left')
        ->where('md.tp_id', $tp)
        ->where('md.iduka_id', $idk->id)
//        ->where('m.id', $idk->major)
        ->where('md.deleted_at', null)
        ->orderBy('ud.user_id', 'ASC')
        ->orderBy('i.name', 'ASC')
        ->get()->getResult();
//    echo dd($data);
    ?>
    <div id="body">
        <img src="<?= base_url('assets/img/kop.png'); ?>" alt="">
        <h3 class="center">
            <u>DAFTAR PESERTA PRAKTIK KERJA LAPANGAN</u>
            <br/>Tahun Pelajaran <?= $dataTp['name']; ?></h3>
        <div class="form-group keterangan">
            <table>
                <tr>
                    <td>Tempat Praktik</td>
                    <td>
                        : <strong><?= $idk->name; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>Alamat Praktik</td>
                    <td>
                        : <strong><?= $idk->address; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>
                        : <strong><?= $nomor->detail_tanggal; ?></strong>
                    </td>
                </tr>
            </table>
        </div>
        <div class="mt-3">
            <table border="1" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>L/P</th>
                    <th>Kelas</th>
                    <th>Kompetensi Keahlian</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php foreach ($data as $d) : ?>
                    <tr>
                        <td style="text-align:center"><?= $i; ?></td>
                        <td><?= $d->nis; ?></td>
                        <td><?= ucwords(strtolower($d->name)); ?></td>
                        <td><?= jk($d->jk); ?></td>
                        <td><?= $d->kelas; ?></td>
                        <td><?= $d->majorName; ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br/>
        <table class="table">
            <tbody>
            <tr>
                <td width="400px" rowspan="5"></td>
                <td>Karangmojo, <?= tanggal($nomor->tanggal); ?></td>
            </tr>
            <tr>
                <td>Kepala Sekolah,</td>
            </tr>
            <tr>
                <td>
                    <img src=" <?= base_url('assets/img/ttd-ks.png'); ?>" width="170px" height="100px">
                </td>
            </tr>
            <tr>
                <td>
                    MUNAWAR, S.Pd.I
                </td>
            </tr>
            <tr>
                <td>
                    NBM. 1076230
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>
</body>
</html>
