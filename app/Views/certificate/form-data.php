<div class="container mt-3">
    <h3 style="text-align: center;">Cetak Sertifikat <?= $kelas; ?></h3>
    <hr class="divider">
    <div class="row">
        <div class="col">
            <h4>Data Sekolah</h4>
            <div class="row mb-3">
                <label for="ks" class="col-sm-4 col-form-label">Kepala Sekolah</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="ks" name="ks" placeholder="Kepala Sekolah"
                           value="<?= $sekolah->kepala_sekolah; ?>">
                    <input type="hidden" id='id' name='id' value="<?= $sekolah->id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="ks" class="col-sm-4 col-form-label">NBM</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="nbm" name="nbm" placeholder="Kepala Sekolah"
                           value="<?= $sekolah->nip; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label for="tgl" class="col-sm-4 col-form-label">Tempat, Tanggal Cetak</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="tgl" name="tgl"
                           placeholder="Tempat, tanggal cetak" value="<?= $sekolah->print_date; ?>">
                </div>
            </div>
            <button class="btn btn-primary" onclick="masterSekolah()">SAVE</button>
        </div>
        <div class="col">
            <h4>Data Lainya</h4>
            <div class="row mb-3">
                <label for="asesor" class="col-sm-4 col-form-label">Nama Asesor</label>
                <div class="col-sm-8">
                    <?php if (!$asesor) { ?>
                        <input type="text" class="form-control" id="asesor" name="asesor" placeholder="Nama Asesor"
                               value="">
                    <?php } else { ?>
                        <input type="text" class="form-control" id="asesor" name="asesor" placeholder="Nama Asesor"
                               value="<?= $asesor->name_assessor; ?>">
                    <?php } ?>
                </div>
            </div>
            <div class="row mb-3">
                <label for="nopeg" class="col-sm-4 col-form-label">Nomor Pegawai</label>
                <div class="col-sm-8">
                    <?php if (!$asesor) { ?>
                        <input type="text" class="form-control" id="nopeg" name="nopeg" placeholder="Nomor Pegawai"
                               value="">
                    <?php } else { ?>
                        <input type="text" class="form-control" id="nopeg" name="nopeg" placeholder="Nomor Pegawai"
                               value="<?= $asesor->nopeg; ?>">
                    <?php } ?>
                </div>
            </div>
            <?php if ($asesor) { ?>
                <input type="hidden" id="idAsesor" value="<?= $asesor->id; ?>">
            <?php } else { ?>
                <input type="hidden" id="idAsesor" value="">
            <?php } ?>
            <button class="btn btn-primary" onclick="masterAsesor()">SAVE</button>
        </div>
        <div class="col">
            <h3>Import Data</h3>
            <form action="<?= base_url('sertifikat/import-excel'); ?>" class="excel-upl" id="excel-upl"
                  enctype="multipart/form-data" method="post" accept-charset="utf-8">
                <div class="form-group">
                    <label>Pilih File Excel</label>
                    <input type="file" id="validatedCustomFile" name="fileURL">
                </div>
                <div class="form-group mt-3">
                    <button class='btn btn-success' type="submit" name="import">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        Import
                    </button>
                </div>
            </form>
            <?php if ($kelas): ?>
                <div class="col mt-3">
                    <h3>Setting Tabel Sertifikat</h3>
                    <a class="nav-link" aria-current="page"
                       href="<?= base_url('sertifikat/setting?kelas=' . $kelas); ?>">
                        <button class="btn btn-warning">Setting Tabel <?= $kelas; ?></button>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>