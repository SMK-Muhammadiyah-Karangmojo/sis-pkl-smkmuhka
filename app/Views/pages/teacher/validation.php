<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Eko Cahyanto">
    <link rel="icon" href="<?= base_url('assets/img/logo/favicon.ico'); ?>">
    <title>Form Validation</title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href=<?= base_url('assets/template/plugins/fontawesome-free/css/all.min.css') ?>>
    <link rel="stylesheet" href=<?= base_url('assets/template/dist/css/adminlte.min.css') ?>>
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css'); ?>">
    <script>
        $(document).ready(function () {
            $(".preloader").finish();
        })
    </script>
</head>

<body class="hold-transition sidebar-mini">
<div id="validation" class="wrapper">
    <?php if (!$data): ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">STEP 1 | Silahkan Lengkapi Data Diri</h3>
            </div>
            <form action="<?= base_url('/student/addDetail'); ?>" method="post">
                <div class="card-body">
                    <input type="text" class="form-control" id="user_public_id" name="user_public_id"
                           value="<?= $users_id; ?>"
                           hidden>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $users; ?>"
                               readonly>
                    </div>
                    <div class="form-group">
                        <label>NIS</label>
                        <input type="text"
                               class="form-control <?= $validation->hasError('nis') ? 'is-invalid' : ''; ?>"
                               id="nis" name="nis" placeholder="Nomor Induk Siswa" <?= old('nis'); ?>>
                        <div class="invalid-feedback">
                            <?= $validation->getError('nis'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select class="form-control" id="jk" name="jk">
                            <option value="">--Pilih Jenis Kelamin--</option>
                            <option value="1">Laki-laki</option>
                            <option value="2">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tahun Pelajaran</label>
                        <select class="form-control" id="tp" name="tp">
                            <option value="">--Pilih Tahun Pelajaran--</option>
                            <?php foreach ($tp as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Jurusan</label>
                        <select class="form-control" id="major_id" name="major_id">
                            <option value="">--Pilih Jurusan--</option>
                            <?php foreach ($major as $m): ?>
                                <option value="<?= $m['id']; ?>"><?= $m['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <select class="form-control" id="class_id" name="class_id">
                            <option value="">--Pilih kelas--</option>
                            <?php foreach ($class as $c): ?>
                                <option value="<?= $c->id; ?>"><?= $c->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    <?php else : ?>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">STEP 2 | Silahkan Pilih Lokasi PKL</h3>
            </div>
            <form action="<?= base_url('/student/addMasterData'); ?>" method="post">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="email" class="form-control" id="name" name="name"
                               value="<?= $data ? $data->name : ''; ?>"
                               readonly>
                    </div>
                    <div class="form-group">
                        <label>NIS</label>
                        <input type="email" class="form-control" id="nis" name="nis"
                               value="<?= $data ? $data->nis : ''; ?>"
                               readonly>
                    </div>
                    <div class="form-group">
                        <label>Lokasi PKL</label>
                        <select class="form-control" id="iduka_id" name="iduka_id">
                            <option value="">--Pilih Lokasi PKL--</option>
                            <?php if ($iduka): ?>
                                <?php foreach ($iduka as $i): ?>
                                    <option value="<?= $i->id; ?>"><?= $i->name; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <span>*Jika lokasi PKL tidak ada silahkan hubungi admin di nomor ini
                            <a href="https://wa.me/6283840398931?text=Assalamu'alaikum,%20mohon%20bantuan%20tambah%20lokasi%20pkl.%20%20terima%20kasih.">083840398931</a></span>
                    </div>
                </div>
                <input type="text" class="form-control" id="tp_id" name="tp_id" value="<?= $data ? $data->tp : ''; ?>"
                       hidden>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
</body>

</html>