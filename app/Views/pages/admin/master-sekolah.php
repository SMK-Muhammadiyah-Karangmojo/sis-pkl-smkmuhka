<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="col-auto">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $title; ?></h3>
        </div>
        <form method="POST">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="ml-3 mb-0" for="sekolah">Nama Sekolah</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= $sekolah['name']; ?>"
                                   placeholder="Nama Sekolah">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="ml-3 mb-0" for="npsn">NPSN (Nomor Pokok Sekolah Nasioanl)</label>
                            <input type="text" class="form-control" id="npsn" name="npsn" value="<?= $sekolah['npsn']; ?>"
                                   placeholder="NPSN (Nomor Pokok Sekolah Nasional">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="ml-3 mb-0" for="address">Alamat</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= $sekolah['address']; ?>"
                                   placeholder="Alamat Sekolah">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="ml-3 mb-0" for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="<?= $sekolah['phone']; ?>"
                                   placeholder="Telp Sekolah">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="ml-3 mb-0" for="akreditasi">Akreditasi</label>
                            <select class="form-control" name="akreditasi" id="akreditasi">
                                <option value="<?= $sekolah['akreditasi'] ?>"><?= $sekolah['akreditasi'] ?></option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="ml-3 mb-0" for="kepala_sekolah">Kepala Sekolah</label>
                            <input type="text" class="form-control" id="kepala_sekolah" name="kepala_sekolah" value="<?= $sekolah['kepala_sekolah']; ?>"
                                   placeholder="Kepala Sekolah">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="ml-3 mb-0" for="nip">NIP/NBM</label>
                            <input type="text" class="form-control" id="nip" name="nip" value="<?= $sekolah['nip']; ?>"
                                   placeholder="Kepala Sekolah">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="ml-3 mb-0" for="ttd">Tanda Tangan</label>
                            <textarea class="form-control"
                                      name="ttd"
                                      id="ttd">
                    <?= $sekolah['ttd']; ?>
                        </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="id" name="id" value="<?= $sekolah['id']; ?>">
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>; ?>