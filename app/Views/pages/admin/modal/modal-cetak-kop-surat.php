<div class="modal fade" id="modal-kop-surat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cetak KOP Surat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('/admin/printLetterHead'); ?>" method="post">
                    <div class="form-group">
                        <select class="form-control" name="hal" id="hal">
                            <option>--Pilih Jenis Surat--</option>
                            <option value="Pengiriman peserta PKL">Pengiriman peserta PKL</option>
                            <option value="Penarikan Peserta PKL">Penarikan Peserta PKL</option>
                            <option value="Permohonan Nilai PKL">Permohonan Nilai PKL</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" type="text" id="tp_kop" name="tp_kop" required>
                            <option value="">--Pilih Tahun Pelajaran--</option>
                            <?php foreach ($tp as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" type="text" id="major_id_kop" name="major_id_kop"
                                onchange="getAllIdukaByMajor('kop')" required>
                            <option value="">--Pilih Jurusan--</option>
                            <?php foreach ($major as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" type="text" id="kop-surat-iduka" name="kop-surat-iduka" required>
                            <option value="">--Pilih Iduka--</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="instansi" id="instansi" required>
                            <option value="">--Pilih Jenis instansi--</option>
                            <option value="Kepala">Pemerintah</option>
                            <option value="Pimpinan">Non Pemerintah</option>
                        </select>
                        <div>
                            <small>
                                <b>*Contoh Instansi :<br/>
                                    Pemerintah => Kalurahan, Kapanewon, KUA, dll <br/>
                                    Non Pemerintah => Bengkel, Bank, Toko, Dll</b>
                            </small>
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Cetak</button>
            </div>
            </form>
        </div>
    </div>
</div>