<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="col">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">My Profile</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="<?= base_url('student/updateProfile'); ?>" method="post" enctype="multipart/form-data">
            <input type="text" class="form-control" id="id" name="id" value="<?= $data->id; ?>" hidden>
            <input type="text" class="form-control" id="ids" name="ids" value="<?= $data->ids; ?>" hidden>
            <input type="text" class="form-control" id="oldImage" name="oldImage" value="<?= $data->image; ?>" hidden>
            <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email"
                           value="<?= $data->email; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Nama Lengkap</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $data->name; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('name'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nis">NIS (Nomor Induk Siswa)</label>
                    <input type="text" class="form-control <?= $validation->hasError('nis') ? 'is-invalid' : ''; ?>"
                           id="nis" name="nis" <?= old('nis'); ?> value="<?= $data->nis; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nis'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="nisn">NISN (Nomor Induk Siswa Nasional)</label>
                    <input type="text" class="form-control  <?= $validation->hasError('nisn') ? 'is-invalid' : ''; ?>"
                           id="nisn" name="nisn" value="<?= $data->nisn; ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('nisn'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <select class="form-control" id="jk" name="jk">
                        <option value="<?= $data->jk; ?>"><?= jk($data->jk); ?></option>
                        <option value="1">Laki-laki</option>
                        <option value="2">Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Tahun Pelajaran</label>
                    <select class="form-control" id="tp" name="tp">
                        <option value="<?= $data->idTp; ?>"><?= $data->tp; ?></option>
                        <?php foreach ($tp as $m): ?>
                            <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kelas</label>
                    <select class="form-control" id="class_id" name="class_id">
                        <option value="<?= $data->classId; ?>"><?= $data->class; ?></option>
                        <?php foreach ($class as $c): ?>
                            <option value="<?= $c->id; ?>"><?= $c->name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Photo Profile</label>
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="<?= base_url('/assets/img/users/' . $data->image); ?>" alt="profile"
                                 class="img-thumbnail img-preview">
                        </div>
                        <div class="custom-file col-sm-10">
                            <input type="file"
                                   class="custom-file-input <?= ($validation->hasError('profile')) ? 'is-invalid' : ''; ?>"
                                   id="profile" name="profile"
                                   onchange="imagePreview()">
                            <div class="invalid-feedback">
                                <?= $validation->getError('profile'); ?>
                            </div>
                            <label class="custom-file-label" for="profile"><?= $data->image; ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>; ?>