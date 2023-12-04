<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cetak Surat Permohonan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('/admin/printApplicationLetter'); ?>" method="post">
                    <div class="form-group">
                        <select class="form-control" type="text" id="tp" name="tp" required>
                            <option value="">--Pilih Tahun Pelajaran--</option>
                            <?php foreach ($tp as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" type="text" id="major_id" name="major_id"
                                onchange="getAllIdukaByMajor('permohonan')" required>
                            <option value="">--Pilih Jurusan--</option>
                            <?php foreach ($major as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" type="text" id="iduka" name="iduka" required>
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