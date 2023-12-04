<div class="modal fade" id="modal-nomor-surat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Nomor Surat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="tp">Tahun Pelajaran</label>
                        <select class="form-control" type="text" id="tp" name="tp" required>
                            <option value="">--Pilih Tahun Pelajaran--</option>
                            <?php foreach ($tp as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category">Kategori Surat</label>
                        <select class="form-control" type="text" id="category" name="category" required>
                            <option value="">--Pilih Kategori--</option>
                            <?php foreach ($category as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor">Nomor Surat</label>
                        <input class="form-control" type="text" id="nomor" name="nomor" placeholder="Nomor surat"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="tgl">Tanggal Surat</label>
                        <input class="form-control" type="date" id="tgl" name="tgl" placeholder="Tanggal surat"
                               required>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>