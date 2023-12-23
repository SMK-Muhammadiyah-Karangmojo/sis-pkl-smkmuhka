<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */
echo $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="card">
    <div class="card-header">
        <h3>Pengaturan</h3>
    </div>
    <div class="card-body">
        <form action="" method="get" class="row">
            <select class="form-control col-sm-3 m-3" name="tp" id="tp">
                <option>---Pilih Tahun Pelajaran--</option>
                <?php foreach ($tp as $item) {
                    ?>
                    <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                    <?php
                }
                ?>
            </select>
            <select class="form-control col-sm-3 m-3" name="kategori_surat" id="kategori_surat">
                <option>---Pilih Kategori--</option>
                <?php foreach ($kategori as $item) {
                    ?>
                    <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                    <?php
                }
                ?>
            </select>
            <button type="submit" class="btn btn-outline-primary m-3">VIEW</button>
        </form>
        <?php
        switch ($template) {
            case 1:
                echo $this->include("pages/setting/component/surat-permohonan");
                break;
            case 2:
                echo $this->include("pages/setting/component/surat-tugas");
                break;
            case 3:
                echo $this->include("pages/setting/component/surat-jalan");
                break;
            case 4:
                echo $this->include("pages/setting/component/surat-pengantar");
                break;
            default:
                echo $this->include("pages/setting/component/404");
        }
        ?>
    </div>
</div>


<?= $this->endSection() ?>; ?>