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
        <h3>Pengaturan Kop Surat</h3>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <label for="content">Silahkan isi upload file di teks area untuk pengaturan kop surat</label>
            <textarea class="form-control"
                      name="content"
                      id="content">
                    <?= $data_template->content; ?>
                        </textarea>
            <input type="hidden" id="id" name="id" value="<?= $data_template->id; ?>">
            <button class="btn btn-primary">SIMPAN</button>
        </form>
    </div>
</div>


<?= $this->endSection() ?>; ?>