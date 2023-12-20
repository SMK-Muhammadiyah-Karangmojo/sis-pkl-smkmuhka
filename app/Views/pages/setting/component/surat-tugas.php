<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */
?>

<div class="card">
    <div class="card-header">
        <strong>Surat Pengantar</strong>
    </div>
    <div class="card-body">
        <?php
        if (isset($data_template)) {
            ?>
            <?= $kop_surat->content; ?>
            <form action="" method="post">
                <div class="row form-group">
                    <div class="col-sm-1">
                        <label for="nomor">Nomor</label>
                    </div>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" id="nomor" name="nomor"
                               value="<?= $surat ? $surat->nomor : ''; ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-1">
                        <label for="lampiran">Lampiran</label>
                    </div>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" id="lampiran" name="lampiran"
                               value="<?= $data_template->lampiran; ?>">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-1">
                        <label for="hal">Hal</label>
                    </div>
                    <div class="col-sm-4">
                        <input class="form-control" type="text" id="hal" name="hal"
                               value="<?= $data_template->hal; ?>">
                    </div>
                </div>

                <div>
                    <p>Kepada</p>
                    <p>
                        Yth. <strong>{Nama Iduka}</strong><br>
                        di <strong>{Alamat Iduka}</strong>
                    </p>
                </div>
                <div class="form-group">
                <textarea class="form-control"
                          name="content"
                          id="content">
                    <?= $data_template->content; ?>
                        </textarea>
                </div>
                <div>
                    <div class="row">
                        <div class="col-sm-8"></div>
                        <div class="col-sm-4">
                            <p class="mb-5">Karangmojo, <?= $surat ? tanggal($surat->tanggal) : ''; ?></p>
                            <p><?= $sekolah['kepala_sekolah']; ?><br>
                                NBM. <?= $sekolah['nip']; ?></p>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="id" name="id" value="<?= $data_template->id; ?>">
                <input type="hidden" id="tp" name="tp" value="<?= $tpId; ?>">
                <input type="hidden" id="kategori_surat" name="kategori_surat" value="<?= $template; ?>">
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </form>
            <?php
        } else {
            ?>
            <?= $this->include("pages/setting/component/template-404") ?>
            <?php
        }
        ?>

    </div>
</div>