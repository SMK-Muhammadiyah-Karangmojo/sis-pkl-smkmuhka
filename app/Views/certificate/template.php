<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="<?= base_url('assets/img/logo/favicon.ico'); ?>">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title><?= $title; ?></title>
</head>

<body>
<div class="container">
    <?= $this->include('certificate/navbar'); ?>
    <?= $this->include('flash/flash'); ?>
    <?= $this->include('certificate/form-data'); ?>
    <!-- form -->
    <hr>
    <!-- end form -->
    <?= $this->renderSection('content'); ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src=<?= base_url('assets/template/plugins/jquery/jquery.min.js') ?>></script>
<script src=<?= base_url('assets/js/datatables-demo.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables/jquery.dataTables.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>>
</script>
<script src=<?= base_url('assets/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>>
</script>

<script src=<?= base_url('assets/yantodev/Flashdata.js') ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>></script>
<script src=<?= base_url('assets/template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>></script>
<script>
    function masterSekolah() {
        let id = document.getElementById("id").value;
        let ks = document.getElementById("ks").value;
        let nbm = document.getElementById("nbm").value;
        let tgl = document.getElementById("tgl").value;
        $.ajax({
            url: '<?= base_url('sertifikat/master-sekolah/'); ?>',
            type: 'POST',
            data: {
                id: id,
                ks: ks,
                nbm: nbm,
                tgl: tgl
            },
            success: function (response) {
                console.log(response);
                alert('Data berhasil disimpan')
                setTimeout(function () {
                    window.location.reload(2);
                }, 1000);
            }
        });
    };

    function masterAsesor() {
        let id = document.getElementById("idAsesor").value;
        let accessor = document.getElementById("asesor").value;
        let nopeg = document.getElementById("nopeg").value;
        $.ajax({
            url: '<?= base_url('sertifikat/master-accessor'); ?>',
            type: 'POST',
            data: {
                id,
                accessor,
                nopeg,
            },
            success: function (response) {
                console.log(response);
                alert('Data berhasil disimpan')
                setTimeout(function () {
                    window.location.reload(2);
                }, 1000);
            }
        });
    }
</script>
</body>

</html>