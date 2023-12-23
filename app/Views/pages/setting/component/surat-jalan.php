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
        <strong>Surat Jalan</strong>
    </div>
    <div class="card-body">
        <?php
        if (isset($data_template)) {
            ?>
            <div class="text-center">
                <?= $kop_surat->content; ?>
            </div>
            <form action="" method="post">
                <div class="text-center">
                    <h4 class="text-bold"><u>Surat Jalan</u></h4>
                    <h5>Nomor :
                        <?= $surat ? $surat->nomor : ''; ?></h5>
                </div>
                <div class="form-group">
                <textarea class="form-control"
                          name="content"
                          id="content">
                    <?= $data_template->content; ?>
                        </textarea>
                </div>
                <?= $this->include("pages/setting/component/table"); ?>
                <div class="form-group">
                <textarea class="form-control"
                          name="content_2"
                          id="content_2">
                    <?= $data_template->content_2; ?>
                        </textarea>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="lokasi_pkl">Tempat Praktik</label>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <input class="form-control" type="text" id="lokasi_pkl" value="{Lokasi PKL}" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="lokasi_pkl">Lama Praktek</label>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <input class="form-control" type="text" id="lokasi_pkl"
                                   value="3 (tiga) Bulan" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            <label for="detail_tanggal">Waktu</label>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <input class="form-control" type="text" id="detail_tanggal" name="detail_tanggal"
                                   value="<?= $data_template->detail_tanggal ?? 'isi_detail_tanggal'; ?>">
                        </div>
                    </div>
                </div>
                <div>
                    <div class="row">
                        <div class="col-sm-8"></div>
                        <div class="col-sm-4">
                            <p>Karangmojo, <?= $surat ? tanggal($surat->tanggal) : ''; ?></p>
                            <?= $sekolah['ttd']; ?>
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