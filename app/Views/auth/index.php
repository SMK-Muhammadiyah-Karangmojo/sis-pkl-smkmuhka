<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Eko Cahyanto">
    <link rel="icon" href="<?= base_url('assets/img/logo/favicon.ico'); ?>">
    <title><?= $title ?></title>
    <link
            href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
</head>
<body onload="config('<?= base_url(); ?>')">
<script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
<div class="container">
    <div class="form-login">
        <div class="user">
            <div class="header">
                <img src="<?= base_url('assets/img/logo/logo-login.png'); ?>" alt="logo">
            </div>
            <div class="title">
                <h2>Login Page || SIS-PKL</h2>
                <h3>SMK Muhammadiyah Karangmojo</h3>
            </div>
            <?= $this->include('./flash/flash'); ?>
            <form method="POST" action="<?= base_url('auth/login'); ?>">
                <div class="form-group">
                    <label class="label" for="username">Username</label>
                    <input type="text" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label class="label" for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password">
                </div>
                <div class="button-login">
                    <button class="btn-login">
                        LOGIN
                    </button>
                </div>
<!--                <div class="register">-->
<!--                    <div>-->
<!--                        Don't have account?-->
<!--                        <div class="btn-register" onclick="register()">-->
<!--                            REGISTER NOW-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </form>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/sweetalert2/dist/sweetalert2.all.min.js'); ?>"></script>
<script src=<?= base_url('assets/template/plugins/jquery/jquery.min.js') ?>></script>
<script src="<?= base_url(); ?>/assets/config/config.js"></script>
<script src="<?= base_url(); ?>/assets/yantodev/auth/login.js"></script>
<script src="<?= base_url(); ?>/assets/yantodev/Flashdata.js"></script>
<script src="<?= base_url(); ?>/assets/yantodev/auth/register.js"></script>
</body>
</html>