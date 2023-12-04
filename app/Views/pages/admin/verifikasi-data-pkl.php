<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="col">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"><?= $title; ?></h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="<?= base_url('admin/verificationData'); ?>" method="post" enctype="multipart/form-data">
            <input type="text" class="form-control" id="id" name="id" value="<?= $master->id; ?>" hidden>
            <input type="text" class="form-control" id="oldImage" name="oldImage" value="<?= $master->image; ?>" hidden>
            <input type="text" class="form-control" id="statusData" name="statusData" value="<?= $statusData; ?>"
                   hidden>
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputPassword1">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $master->name; ?>"
                           readonly>
                    <div class="invalid-feedback">
                        <?= $validation->getError('name'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nis">NIS (Nomor Induk Siswa)</label>
                    <input type="text" class="form-control <?= $validation->hasError('nis') ? 'is-invalid' : ''; ?>"
                           id="nis" name="nis" <?= old('nis'); ?> value="<?= $master->nis; ?>" readonly>
                    <div class="invalid-feedback">
                        <?= $validation->getError('nis'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="iduka">Iduka</label>
                    <input type="text" class="form-control <?= $validation->hasError('iduka') ? 'is-invalid' : ''; ?>"
                           id="iduka" name="iduka" <?= old('iduka'); ?> value="<?= $master->iduka; ?>" readonly>
                    <div class="invalid-feedback">
                        <?= $validation->getError('iduka'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address">Alamat Iduka</label>
                    <input type="text" class="form-control <?= $validation->hasError('address') ? 'is-invalid' : ''; ?>"
                           id="address" name="address" <?= old('address'); ?> value="<?= $master->address; ?>" readonly>
                    <div class="invalid-feedback">
                        <?= $validation->getError('address'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select type="text" class="form-control <?= $validation->hasError('status') ? 'is-invalid' : ''; ?>"
                            id="status" name="status">
                        <option value="">--Pilih Status Surat Balasan--</option>
                        <option value="1">Diterima</option>
                        <option value="2">Ditolak</option>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('status'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Photo Surat Balasan</label>
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="<?= base_url('/assets/img/verifikasi/' . $master->image); ?>" alt="profile"
                                 class="img-thumbnail img-preview">
                        </div>
                        <div class="custom-file col-sm-10">
                            <input type="file"
                                   class="custom-file-input <?= ($validation->hasError('image')) ? 'is-invalid' : ''; ?>"
                                   id="image" name="image"
                                   onchange="imageVerifikasiPreview()">
                            <div class="invalid-feedback">
                                <?= $validation->getError('image'); ?>
                            </div>
                            <label class="custom-file-label" for="profile"><?= $master->image; ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Verifikasi</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>; ?>