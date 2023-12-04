<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data->name; ?></title>
    <style rel="stylesheet">
        @page {
            margin: 0.5cm 0.0cm 0.0cm;
            background: url("https://media.discordapp.net/attachments/1178712419833491567/1178712707583713390/pkl-04.png?ex=657724c0&is=6564afc0&hm=4e3398805265f84a111d63cbd609b9c9b7d519d8ea4cf15e112dd7c3fe5ddaaf&=&format=webp") no-repeat;
            width: 1250px;
            height: 814px;
            size: auto;
        }

        @font-face {
            font-family: AspireDemiBold;
            src: url("/assets/font/RoosterPersonalUse-3z8d8.ttf");
        }

        .header {
            text-align: center;
        }

        .header h3 {
            margin: 0;
            font-weight: bold;
            font-size: 35px;
        }

        .header h4 {
            margin: 0;
            font-size: 20px;
        }

        .header hr {
            display: block;
            margin: 0.5em auto;
            border-style: inset;
            border-width: 1px;
            color: red;
        }

        .title {
            text-align: center;
            font-family: snell, serif;;
        }

        .title h3 {
            margin: 15px 0 0 0;
            font-size: 35px;
        }

        .title h4 {
            margin: 0 0 15px 0;
            font-size: 20px;
        }

        .content {
            margin: 20px auto;
            text-align: center;
            font-size: 18px;
        }

        .content-name {
            margin: 10px auto;
            font-size: 35px;
            font-weight: bold;
            text-decoration: underline;
            font-family: AspireDemiBold, fangsong;
        }

        .content-detail {
            margin: 10px 15% 10px 15%;
            font-size: 20px;
        }

        .isi {
            margin-left: 25px;
        }

        .content-bottom {
            margin: 10px 15% 10px 15%;
            text-align: center;
        }

        .content-bottom-column {
            float: left;
            width: 50%;
        }

        .content-bottom-row:after {
            content: "";
            display: table;
            clear: both;
        }

        .content-margin-bottom {
            height: 120px;
        }

        .nomor-certificate {
            margin: 0px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h3>
            <?= $data->iduka; ?>
        </h3>
        <h4><?= $data->address; ?></h4>
        <hr style="display: block;
            margin: 0.5em auto;
            border-style: inset;
            height: 3px;
            color: #020000">
    </div>
    <div class="title">
        <h3>
            <u>SERTIFIKAT</u>
        </h3>
        <?php $year = explode("/", $data->tp); ?>
        <div class="nomor-certificate">Nomor : SMKMUHKA/<?= $year[1] . "/" . $data->code . "/" . $data->nis; ?> </div>
    </div>
    <div class="content">
        <div>Diberikan Kepada :</div>
        <div class="content-name">
            <?= ucwords(strtolower($data->name)); ?>
        </div>
        <div>
            Sekolah Asal : <b><?= $school['name']; ?></b>
        </div>
        <div class="content-detail">
            Telah melaksanakan Praktek Kerja Lapangan (PKL) Selama 3 (tiga) Bulan
            terhitung mulai tanggal <?= $mentor->pkl; ?>
            di <b><?= $data->iduka; ?></b> dengan hasil terlampir dibelakang sertifikat ini.
        </div>
    </div>
    <div class="content-bottom">
        <div class="content-bottom-row">
            <div class="content-bottom-column">
                <h3 class="content-margin-bottom">
                    Mengetahui,<br>
                    Kepala Sekolah
                </h3>
                <h3><?= $school['kepala_sekolah']; ?> <br> NIP/NBM. <?= $school['nip']; ?></h3>
            </div>
            <div class="content-bottom-column">
                <h3 class="content-margin-bottom">
                    Karangmojo, 01 April 2023<br>
                    <?= $mentor->position; ?>
                </h3>
                <h3><?= $mentor->name; ?> <br> NIP/NRP. <?= $mentor->identity_number; ?></h3>
            </div>
        </div>
    </div>
</div>
</body>
</html>