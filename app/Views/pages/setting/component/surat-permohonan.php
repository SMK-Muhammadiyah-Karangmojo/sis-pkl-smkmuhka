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
            <hr>
            <p class="text-center">--- Page 1 --</p>
            <hr>
            <img src="<?= $kop_surat->content; ?>" alt="kop-surat" width="100%">
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
                <div class="text-center">
                    <input class="form-control mb-3 text-center text-bold"
                           type="text" id="detail_tanggal" name="detail_tanggal"
                           placeholder="Contoh: 02 Januari 2023 s/d 31 Maret 2023"
                           value="<?= $data_template->detail_tanggal; ?>">
                </div>
                <p>Adapun peserta PKL adalah sebagai berikut:</p>
                <?= $this->include("pages/setting/component/table"); ?>
                <div class="form-group">
                <textarea class="form-control"
                          name="content_2"
                          id="content_2">
                    <?= $data_template->content_2; ?>
                        </textarea>
                </div>
                <div>
                    <div class="row">
                        <div class="col-sm-6">
                            <p class="mb-5">Mengetahui, <br>
                                Kepala Sekolah</p>
                            <p>
                                <?= $sekolah['kepala_sekolah']; ?><br>
                                NBM. <?= $sekolah['nip']; ?>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-5">Karangmojo, <?= $surat ? tanggal($surat->tanggal) : ''; ?>
                                <br>
                                Ketua Kompetensi Keahlian
                            </p>
                            <p><strong>{Nama K3}</strong><br>
                                {NBM. K3}</p>
                        </div>
                    </div>
                </div>
                <hr>
                <p class="text-center">--- Page 2 --</p>
                <hr>
                <div>
                    <textarea name="content_3"
                              id="content_3">
                        <?= $data_template->content_3; ?>
                    </textarea>
                </div>
                <div class="text-center text-bold row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <p style="border: #0a0e14 solid 2px">*TIDAK KEBERATAN / KEBERATAN</p>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
                <div>
                    <textarea name="content_4"
                              id="content_4">
                        <?= $data_template->content_4; ?>
                    </textarea>
                </div>
                <?= $this->include("pages/setting/component/table"); ?>
                <div>
                    <textarea name="content_5"
                              id="content_5">
                        <?= $data_template->content_5; ?>
                    </textarea>
                </div>
                <hr>
                <p>
                    1 lembar dikirim ke SMK Muh. Karangmojo <br>
                    1 lembar untuk arsip Kepala Kompetensi Keahlian<br>
                    1 lembar untuk arsip IDUKA (Instansi)<br>
                    *) Coret salah satu
                </p>
                <hr>
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