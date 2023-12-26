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
<?php foreach ($result as $res): ?>
    <div id="body">
        <img src="<?= $kop_surat->content; ?>" alt="kop-surat">
        <table>
            <tr>
                <td>Nomor</td>
                <td class="column-name">: <?= $surat->nomor; ?></td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td class="column-name">: <?= $master_template->lampiran; ?></td>
            </tr>
            <tr>
                <td>Hal</td>
                <td class="column-name">: <?= $master_template->hal; ?></td>
            </tr>
        </table>

        <p>Kepada<br/>
            Yth.<b> <?= $instansi; ?> <?= $res->idukaname; ?></b><br/>
            di <b><?= $res->address ?></b>
        </p>
        <?= $master_template->content;?>
        <table class="table">
            <tbody>
            <tr>
                <td width="400px" rowspan="4"></td>
                <td>Karangmojo, <?= tgl2($surat->tanggal); ?></td>
            </tr>
            <tr>
                <td>
                    <img src="<?= $school['ttd']; ?>" alt="ttd-ks" width="200px">
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
