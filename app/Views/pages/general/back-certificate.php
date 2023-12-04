<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data->name; ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/back-certificate.css'); ?>">
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Daftar Nilai Praktek Kerja Lapangan</h2>
    </div>
    <div class="title">
        <div class="title-row">
            <div class="title-column">
                <div class="title-info">
                    <div>Nama</div>
                    <div>NIS</div>
                    <div>Kompetensi Keahlian</div>
                    <div>Nama Sekolah</div>
                </div>
            </div>
            <div class="title-column-2">
                <div class="title-data">
                    <div>: <?= ucwords(strtolower($data->name)); ?></div>
                    <div>: <?= $data->nis; ?></div>
                    <div>: <?= ucwords(strtolower($data->major)); ?></div>
                    <div>: <?= $school['name']; ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <table border="1" align="center" cellspacing="0" width="80%">
            <thead>
            <tr>
                <th>NO</th>
                <th>KOMPONEN YANG DI NILAI</th>
                <th>NILAI</th>
                <th>KETERANGAN</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!$nilai): ?>
                <tr>
                    <td colspan="4" align="center">Data Nilai Belum Diisi</td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="3">
                        <h4>I. Aspek Non Teknis</h4>
                    </td>
                    <td rowspan="13" rules="none">
                        <img src="<?= base_url('assets/img/keterengan.png'); ?>" width="400px" height="250" alt="">
                    </td>
                </tr>
                <?php $i = 1; ?>
                <?php foreach ($tableNonTeknis as $t) : ?>
                    <?php foreach ($nilai as $n) : ?>
                        <tr>
                            <td align="center">
                                <h4><?= $i; ?></h4>
                            </td>
                            <td>
                                <h4><?= $t->name; ?></h4>
                            </td>
                            <td style="text-align: center">
                                <?php
                                $code = $t->code;
                                echo $n->$code; ?>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3">
                        <h4>II. Aspek Teknis (Kemampuan Utama)</h4>
                    </td>
                </tr>
                <?php $i = 1; ?>
                <?php foreach ($tableTeknis as $t) : ?>
                    <tr>
                        <td align="center">
                            <h4><?= $i; ?></h4>
                        </td>
                        <td>
                            <h4><?= $t->name; ?></h4>
                        </td>
                        <td style="text-align: center">
                            <?php
                            $code = $t->code;
                            echo $n->$code; ?>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="content-bottom">
        <div class="content-bottom-row">
            <div class="content-bottom-column">
                <h3 class="content-margin-bottom">
                    <?= $mentor->position; ?>
                </h3>
                <h3><?= $mentor->name; ?> <br> NIP/NRP. <?= $mentor->identity_number; ?></h3>
            </div>
        </div>
    </div>
</div>
</body>
</html>