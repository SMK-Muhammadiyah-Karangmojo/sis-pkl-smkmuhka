<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="col-md-4">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $title;?></h3>
        </div>
        <form method="post">
            <div class="card-body">
                <label class="ml-3 mb-0" for="ks">Nama Sekolah</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="sekolah" value="<?= $sekolah['name'];?>" placeholder="Nama Sekolah">
                </div>
                <label class="ml-3 mb-0" for="ks">NPSN (Nomor Pokok Sekolah Nasioanl)</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="npsn" value="<?= $sekolah['npsn'];?>" placeholder="NPSN (Nomor Pokok Sekolah Nasional">
                </div>
                <label class="ml-3 mb-0" for="ks">Alamat</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="address" value="<?= $sekolah['address'];?>" placeholder="Alamat Sekolah">
                </div>
                <label class="ml-3 mb-0" for="ks">Phone</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="phone" value="<?= $sekolah['phone'];?>" placeholder="Telp Sekolah">
                </div>
                <label class="ml-3 mb-0" for="ks">Akreditasi</label>
                <div class="form-group">
                    <select class="form-control" name="akreditasi" id="akreditasi">
                        <option value="<?= $sekolah['akreditasi']?>"><?= $sekolah['akreditasi']?></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>
                <label class="ml-3 mb-0" for="ks">Kepala Sekolah</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="ks" value="<?= $sekolah['kepala_sekolah'];?>" placeholder="Kepala Sekolah">
                </div>
                <label class="ml-3 mb-0" for="ks">NIP/NBM</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="nip" value="<?= $sekolah['nip'];?>" placeholder="Kepala Sekolah">
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">SIMPAN</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>; ?>