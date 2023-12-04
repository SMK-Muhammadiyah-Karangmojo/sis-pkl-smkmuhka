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
    </style>
</head>
<body>
<img src="<?= base_url('assets/img/kop.png'); ?>" alt="">
<h3 class="center">
    <u>Rekap Siswa <?= ($major != null ? $data[0]->majorName : ''); ?></u>
    <br/>Tahun Pelajaran <?= ($tp != null ? $data[0]->tpName : 'Semua'); ?></h3>
<div class="card">
    <div class="card-body">
        <table border="1" width="100%" cellspacing="0">
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Iduka</th>
                <th>Alamat</th>
                <th>Guru Pendamping</th>
                <th>Status</th>
            </tr>

            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
                <tr>
                    <td id="nomor-table"><?= $no++; ?></td>
                    <td id="name"><?= $d->nis; ?></td>
                    <td id="name"><?= $d->name; ?></td>
                    <td id="kelas"><?= $d->kelas; ?></td>
                    <td><?= $d->idukaName; ?></td>
                    <td><?= $d->address; ?></td>
                    <td><?= $d->teacherName; ?></td>
                    <td><?= statusPKL($d->status); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
</body>
</html>