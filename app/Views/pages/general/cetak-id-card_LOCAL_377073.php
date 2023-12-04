<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ID CARD</title>
</head>
<body>
<style>
    @page {
        margin-top: 0.3cm;
        margin-bottom: 0.0cm;
        margin-left: 3.175cm;
        margin-right: 3.175cm;
    }

    .container {
        margin: 15px;
    }

    .id-card {
        position: relative;
        display: inline;
        width: 492px;
    }

    .id-card .konten {
        border: 2px solid #000;
        width: 242px;
        height: 340px;
        float: left;
    }

    .konten-left .header {
        text-align: center;
        font-weight: bold;
        margin-bottom: 5px
    }

    .konten-left .foto {
        text-align: center;
        margin-bottom: 5px;
    }

    .konten-left .jurusan {
        text-align: center;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .konten-left .name {
        text-align: center;
        font-weight: bolder;
        font-size: 18px;
        background-color: greenyellow;
    }

    .konten-left .kelas {
        text-align: center;
        font-weight: bolder;
        font-size: large;
        background-color: cadetblue;
    }

    .konten-left .tanggal {
        margin: 3px;
        text-align: center;
        font-weight: bolder;
        border: 2px solid #000;
    }

    .konten-left .link {
        border-top: 5px;
        text-align: center;
        font-size: small;
    }

    .konten-right .header {
        text-align: center;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .konten-right .lokasi {
        text-align: center;
        font-weight: bold;
    }

    .konten-right .alamat {
        text-align: center;
        font-weight: bold;
        font-size: small;
        margin-bottom: 5px;
    }

    .konten-right .guru {
        text-align: center;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .konten-right .scan {
        text-align: center;
        font-weight: bold;
    }
</style>

<?php foreach ($data as $siswa) : ?>
    <div class="container">
        <div class="id-card">
            <div class="konten">
                <div class="konten-left">
                    <div class="header">
                        PRAKTEK KERJA LAPANGAN<br/>
                        <?= $siswa->tpName; ?><br/>
                        SMK MUH KARANGMOJO
                    </div>
                    <div class="foto">
                        <img src="<?= base_url('assets/img/users/default.png'); ?>" width="90px" height="100px"
                             alt="image profile">
                    </div>
                    <div class="jurusan">
                        <?= $siswa->majorName; ?>
                    </div>
                    <div class="name">
                        <?= ucwords(strtolower($siswa->name)); ?>
                    </div>
                    <div class="kelas">
                        <?= $siswa->kelas; ?>
                    </div>
                    <div class="tanggal">
                        <?= $siswa->detail_tgl; ?>
                    </div>
                    <div class="link">
<<<<<<< HEAD
                        <a href="https://data.smkmuhkarangmojo.sch.id" target="_blank">https://data.smkmuhkarangmojo.sch.id</a>
=======
                        <a href="https://pkl.smkmuhkarangmojo.sch.id" target="_blank">https://pkl.smkmuhkarangmojo.sch.id</a>
>>>>>>> 23daa9033de941e68df975a12ca3b1edb2a0fb57
                    </div>
                </div>
            </div>
            <div class="konten">
                <div class="konten-right">
                    <div class="header">
                        <u>INFORMASI</u>
                    </div>
                    <div class="lokasi">
                        Lokasi PKL<br/>
                        <?= $siswa->idukaName; ?>
                    </div>
                    <div class="alamat">
                        <?= $siswa->address; ?>
                    </div>
                    <div class="guru">
                        <u>
                            GURU PEMBIMBING<br>
                            <?= $siswa->teacherName; ?>
                        </u> <br>
                        Telp/Hp. <?= $siswa->hp; ?>
                    </div>
                    <div class="scan">
                        <strong>SCAN ME</strong><br/>
                        <barcode code="<?= base_url('home/detailsiswa/') . $siswa->id; ?>" size="1.2" type="QR"
                                 error="M" class="barcode"></barcode>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</body>
</html>