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
        ->join('major m', 'm.id = i.major')
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
        <h3 class="center">
            DAFTAR HADIR PESERTA PRAKTIK KERJA LAPANGAN (PKL)<br>
            SMK MUHAMMADIYAH KARANGMOJO
            <br/>TAHUN PELAJARAN <?= $dataTp['name']; ?></h3>
        <div class="form-group keterangan">
            <div id="dh">
                <div id="dh-iduka-left">Nama Iduka : <strong><?= $idk->name; ?></strong></div>
                <div id="dh-iduka-right">Bulan - Tahun : ..............................................</div>
            </div>
        </div>
        <div class="mt-3">
            <table border="1" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th id="dh-number" rowspan="2">No.</th>
                    <th rowspan="2">Nama Peserta</th>
                    <th colspan="31">TANGGAL</th>
                    <th id="dh-jumlah" colspan="5">Jumlah</th>
                </tr>
                <tr>
                    <?php for ($n = 1; $n <= 31; $n++) {
                        echo '<th id="tgl" >' . $n . '</th>';
                    } ?>
                    <th id="tgl">S</th>
                    <th id="tgl">I</th>
                    <th id="tgl">A</th>
                    <th id="tgl">T</th>
                    <th id="tgl">Total</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                <?php foreach ($data as $d) : ?>
                    <tr>
                        <td id="data-monitoring-number"><?= $i; ?></td>
                        <td><?= ucwords(strtolower($d->name)); ?></td>
                        <?php for ($n = 1; $n <= 31; $n++) {
                            echo '<td></td>';
                        } ?>
                        <td id="dh-jumlah"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="form-group">
            <p>
                Keterangan:
                S = Sakit,
                I = Izin,
                A = Alpha,
                T = Telat<br/>
                Hadir diberi tanda titik (.)
            </p>
        </div>
        <div id="dh">
            <div id="dh-ttd-iduka-left">_</div>
            <div id="dh-ttd-iduka-right">
                <div>
                    Tanggal, ..............................................
                </div>
                <div id="dh-pembimbing">
                    Pembimbing Industri
                </div>
                <div>
                    __________________________________
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</body>
</html>
