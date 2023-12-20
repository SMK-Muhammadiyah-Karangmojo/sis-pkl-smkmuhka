<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lembar Monitoring</title>
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
        ->join('major m', 'm.id = i.major_id')
        ->join('user_details ud', 'ud.user_public_id = md.user_public_id')
        ->join('class', 'class.id = ud.class_id', 'left')
        ->where('md.tp_id', $tp)
        ->where('md.iduka_id', $idk->id)
        ->where('md.deleted_at', null)
        ->orderBy('ud.user_id', 'ASC')
        ->orderBy('i.name', 'ASC')
        ->get()->getResult();

    $pendamping = $db->query('
                SELECT t.name, t.nbm FROM tutor
                 inner join teacher t on tutor.teacher_id = t.user_public_id
                WHERE tutor.iduka_id =' . $idk->id
    )->getRow();
    ?>
    <div id="body">
        <img src="<?= base_url('assets/img/kop.png'); ?>" alt="">
        <h3 class="center">
            Lembar Monitoring Siswa Praktik Kerja Lapangan<br>
            SMK Muhammadiyah Karangmojo
            <br/>Tahun Pelajaran <?= $dataTp['name']; ?></h3>
        <div class="form-group keterangan">
            <table>
                <tr>
                    <td>Nama Iduka</td>
                    <td>
                        : <strong><?= $idk->name; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>Alamat Iduka</td>
                    <td>
                        : <strong><?= $idk->address; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>Hari, tanggal</td>
                    <td>
                        : ..............................................
                    </td>
                </tr>
            </table>
        </div>
        <div class="mt-3">
            <table border="1" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th id="monitoring-number">No.</th>
                    <th id="monitoring-name">Nama</th>
                    <th>Bidang pekerjaan yang sedang dilakukan</th>
                    <th id="monitoring-paraf">Paraf Ketua Kelompok</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php foreach ($data as $d) : ?>
                    <tr>
                        <td id="data-monitoring-number"><?= $i; ?></td>
                        <td id="data-monitoring-name"><?= ucwords(strtolower($d->name)); ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <h4>Catatan hasil monitoring</h4>
            <div id="monitoring-note"></div>
        </div>
        <div id="monitoring-ttd">
            <table id="monitoring-ttd-table">
                <tr>
                    <td id="monitoring-ttd-iduka">Pembimbing Iduka</td>
                    <td id="monitoring-ttd-iduka">Guru Pendamping</td>
                </tr>
                <tr>
                    <td id="monitoring-ttd-data">...........................................</td>
                    <td id="monitoring-ttd-data"><?= $pendamping ? $pendamping->name : ""; ?></td>
                </tr>
                <tr>
                    <td id="monitoring-ttd-data">NIP. ......................</td>
                    <td id="monitoring-ttd-data">NBM. <?= $pendamping ? $pendamping->nbm : ""; ?></td>
                </tr>
            </table>
        </div>
    </div>
<?php endforeach; ?>
</body>
</html>
