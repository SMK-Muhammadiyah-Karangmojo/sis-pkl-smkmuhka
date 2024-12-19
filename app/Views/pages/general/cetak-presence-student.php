<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css'); ?>">
    <title><?= $title; ?></title>
    <style>
        @page {
            margin-top: 20px;
            height: 100%;
        }

        .row {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -7.5px;
            margin-left: -7.5px
        }

        .text-center {
            text-align: center;
        }
        .mb-3{
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
<img src="<?= $kop_surat->content; ?>" alt="kop-surat" width="100%">
<div>
    <h3 class="text-center">Daftar Hadir Siswa</h3>
    <table style="margin-bottom: 5px">
        <thead>
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td><?= $user_detail->name; ?></td>
        </tr>
        <tr>
            <td>Jurusan</td>
            <td>:</td>
            <td><?= $user_detail->major; ?></td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>:</td>
            <td><?= $user_detail->kelas; ?></td>
        </tr>
        <tr>
            <td>Iduka</td>
            <td>:</td>
            <td><?= $user_detail->iduka; ?></td>
        </tr>
        <tr>
            <td>Alamat Iduka</td>
            <td>:</td>
            <td><?= $user_detail->address; ?></td>
        </tr>
        </thead>
    </table>
</div>
<table border="1" width="100%" cellspacing="0">
    <thead>
    <tr class="text-center table-primary">
        <th rowspan="2">No</th>
        <th rowspan="2">Tanggal</th>
        <th colspan="2">Presensi</th>
        <th rowspan="2">Paraf</th>
    </tr>
    <tr class="text-center table-primary">

        <th>Masuk</th>
        <th>Pulang</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $number = 1;
    foreach ($data_presence as $item) {
        ?>
        <tr>
            <td class="text-center"><?= $number++; ?></td>
            <td><?= tanggal($item->date); ?></td>
            <td class="text-center"><?= $item->time_in; ?></td>
            <td class="text-center"><?= $item->time_out; ?></td>
            <td></td>
        </tr>
        <?php
    }
    ?>

    </tbody>
</table>
</body>
</html>
