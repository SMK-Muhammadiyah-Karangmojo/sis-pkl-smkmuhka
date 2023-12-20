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
<?php
foreach ($results as $result): ?>
    <div id="body">
        <?= $kop_surat->content; ?>
        <h3 class="center">
            <u>SURAT TUGAS</u>
            <br/>Nomor : <?= $surat->nomor; ?></h3>
        <p>Kepala SMK Muhammadiyah Karangmojo Gunungkidul, memberi tugas kepada :
        </p>
        <div class="container">
            <table>
                <tr>
                    <td>Nama</td>
                    <td class="column-name">: <?= $result->name; ?></td>
                </tr>
                <tr>
                    <td>NBM</td>
                    <td class="column-name">: <?= $result->nbm; ?></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td class="column-name">: <?= $result->position; ?></td>
                </tr>
            </table>
        </div>

        <p>Sebagai guru pembimbing dalam praktik kerja lapangan, pada :</p>

        <table class="table" border="1" cellspacing="0">
            <thead>
            <tr>
                <th>No.</th>
                <th>Nama Siswa</th>
                <th>Kompetensi Keahlian</th>
                <th>Tempat PKL</th>
                <th>Alamat</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //            dd($result->idukaid);
            $i = 1;
            $db = db_connect();
            $data = $db->query('
                 select ud.name    as name,
                       ud.user_id as nis,
                       i.name     as iduka,
                       ud.jk,
                       m.name     as jurusan,
                       c.name     as kelas,
                       di.address as alamat
                from master_data md
                        inner join user_details as ud on md.nis = ud.user_id
                        inner join iduka i on md.iduka_id = i.id
                        inner join major m on i.major_id = m.id
                        inner join class c on ud.class_id = c.id
                        left join detail_iduka di on di.id_iduka = i.id
                where md.deleted_at is null 
                    and md.user_public_id is not null
                    and md.iduka_id = ' . $result->idukaid . ' 
                    and md.tp_id = ' . $tp
            )->getResult();
            ?>
            <?php foreach ($data as $d) : ?>
                <tr>
                    <td class="center"><?= $i; ?></td>
                    <td class="top"><?= ucwords(strtolower($d->name)); ?></td>
                    <td class="top">
                        <?= ucwords(strtolower($d->jurusan)) ?>
                    </td>
                    <td class="top">
                        <?= ucwords(strtolower($d->iduka)) ?>
                    </td>
                    <td class="top">
                        <?= ucwords(strtolower($d->alamat)); ?>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p>Demikian surat tugas ini kami buat, agar dapat dilaksanakan dengan penuh tanggungjawab.
        </p>
        <table class="table">
            <tbody>
            <tr>
                <td width="400px" rowspan="4"></td>
                <td>Karangmojo, <?= tanggal($surat->tanggal); ?></td>
            </tr>
            <tr>
                <td height="80px">
                </td>
            </tr>
            <tr>
                <td>
                    <?= $school['kepala_sekolah']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    NBM. <?= $school['nip']; ?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php endforeach; ?>
</body>
</html>