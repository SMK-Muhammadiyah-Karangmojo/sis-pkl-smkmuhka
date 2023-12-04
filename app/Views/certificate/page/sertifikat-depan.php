<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <style>
        @page {
            background-image: url('assets/img/sertifikat/sertifikat.png') no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            margin-top: 0.5cm;
            margin-bottom: 0.0cm;
            margin-left: 0.0cm;
            margin-right: 0.0cm;
        }

        .logo {
            text-align: center;
        }
    </style>
</head>

<body>
<div class="logo">
    <?php if ($data->nisn == '0042239848'): ?>
        <img src="<?= base_url('assets/img/logo/moeka-mart.jpg'); ?>" height="80px" alt="logo">
    <?php else: ?>
        <?= cekImage($kelas); ?>
    <?php endif; ?>
    <img src="<?= base_url('assets/img/logo/logo-login.png'); ?>" height="80px" alt="logo">
</div>
<div style="text-align: center;">
    <h1 style="font-size:50px;margin: 0px;">Certificate</h1>
    <h2 style="font-size:30px;margin-top: 0px;">of Competency</h2>
    <h1 style="margin:0px;"><?= $jurusan; ?></h1>
</div>
<div class="content">
    <div style="text-align: center;margin:0px 100px;">
        <h3><?= $sekolah->content; ?></h3>
        <h3>Menyatakan Bahwa:</h3>
        <h1 style="text-decoration: underline;margin-bottom:0px"><?= ucwords(strtolower($data->name)); ?></h1>
        <h3 style="margin-top: 0px;">Nomor Induk Siswa Nasional : <?= $data->nisn; ?></h3>
        <div style="margin:0px 100px">
            <h3 style="margin:0px">
                Sekolah Asal : SMK Muhammadiyah Karangmojo
            </h3>
            <h3 style="margin:0px">
                Dinyatakan Lulus Ujian Kompetensi Keahlian <?= $jurusan; ?> dengan rincian kompetensi
                dibalik sertifikat ini
            </h3>
        </div>
    </div>
</div>
<div class="footer">
    <table align="center" style="margin-top:40px;">
        <thead>
        <tr>
            <td align="center"><?= $sekolah->print_date; ?></td>
            <td width="200px"></td>
            <td></td>
        </tr>
        <tr>
            <td align="center">Kepala Sekolah</td>
            <td></td>
            <td align="center">Penguji/Asesor</td>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th height="80px" valign="bottom" align="center">
                <?= $sekolah->kepala_sekolah; ?>
            </th>
            <td></td>
            <th valign="bottom" align="center">
                <?php if ($data->nisn == '0042239848'): ?>
                    Ferida Eka Pratiwi MH, S.E
                <?php else: ?>
                    <?= $asesor->name_assessor; ?>
                <?php endif; ?>
            </th>
        </tr>
        <tr>
            <th>NBM. <?= $sekolah->nip; ?></th>
            <?php if ($data->nisn == '0042239848'): ?>
                <th></th>
                <th align="center">NBM. 1191215</th>
            <?php else: ?>
                <th></th>
                <th align="center">NIP/NRP. <?= $asesor->nopeg; ?></th>
            <?php endif; ?>
        </tr>
        </tbody>
    </table>
</div>
</body>

</html>