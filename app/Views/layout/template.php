<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Eko Cahyanto">
    <link rel="icon" href="<?= base_url('assets/img/logo/favicon.ico'); ?>">
    <title><?= $title ?></title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href=<?= base_url('assets/template/plugins/fontawesome-free/css/all.min.css') ?>>
    <link rel="stylesheet" href=<?= base_url('assets/template/dist/css/adminlte.min.css') ?>>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css'); ?>">
    <link href="<?= base_url(); ?>/assets/template/plugins/summernote/summernote-bs4.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/41781f79df.js" crossorigin="anonymous"></script>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php
    switch ($role) {
        case 1:
            echo $this->include('layout/navbar');
            echo $this->include('layout/sidebar-admin.php');
            echo $this->include('layout/header');
            break;
        case 2:
            echo $this->include('layout/navbar-siswa');
            echo $this->include('layout/sidebar-teacher.php');
            echo $this->include('layout/header-siswa');
            break;
        case 3:
            echo $this->include('layout/navbar-siswa');
            echo $this->include('layout/sidebar-siswa.php');
            echo $this->include('layout/header-siswa');
            break;
        default:
            echo "";
    }
    ?>
    <?= $this->include('./flash/flash'); ?>
    <div class="preloader">
        <div class="loading">
            <img src="<?= base_url('/assets/img/gif-muhka.gif'); ?>" width="300" alt="loading">
        </div>
    </div>
    <?= $this->renderSection('content'); ?>
    <?= $this->include('layout/control-sidebar'); ?>
    <?= $this->include('layout/footer'); ?>
</div>
<?= $this->include('layout/script'); ?>
<?php if ($role == 1): ?>
    <script>
        $(document).ready(async function () {
            let users, completed, uncompleted, iduka;
            // await fetchingData('/RestApi/countData')
            //     .then(async response => {
            //         users = await response.result.users;
            //         completed = await response.result.users_completed[0].total;
            //         iduka = await response.result.iduka;
            //         uncompleted = users - completed;
            //         document.getElementById('count-users').innerHTML = users;
            //         document.getElementById('count-profile-completed').innerHTML = completed;
            //         document.getElementById('count-profile-uncompleted').innerHTML = uncompleted;
            //         document.getElementById('count-iduka').innerHTML = iduka;
            //     })
            //     .catch(error => {
            //         console.log(error)
            //     })
        });
    </script>
<?php endif; ?>
</body>

</html>