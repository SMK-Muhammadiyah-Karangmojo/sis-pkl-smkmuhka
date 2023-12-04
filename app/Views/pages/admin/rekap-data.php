<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?= $subtitle; ?></h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <select class="form-control col-lg-3" id="tp1" name="tp1">
                <option value="">-- Pilih Tahun Pelajaran --</option>
                <?php foreach ($tp as $j): ?>
                    <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <select class="form-control col-lg-3" id="major" name="major" onchange="rekapDataPKL()">
                <option value="">-- Pilih Jurusan --</option>
                <?php foreach ($major as $j): ?>
                    <option value="<?= $j['id']; ?>"><?= $j['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Tahun Pelajaran</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Iduka</th>
                <th>Alamat</th>
                <th>Guru Pendamping</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($data as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td id="name"><?= $d->tpName; ?></td>
                    <td id="name"><?= $d->nis; ?></td>
                    <td id="name"><?= $d->name; ?></td>
                    <td id="kelas"><?= $d->kelas; ?></td>
                    <td id="name"><?= $d->idukaName; ?></td>
                    <td id="name"><?= $d->address; ?></td>
                    <td id="name"><?= $d->teacherName; ?></td>
                    <td id="name"><?= statusPKL($d->status); ?></td>
                    <td>
                        <a href="<?= base_url('admin/verifikasi?id=' . $d->id); ?>">
                            <button class="btn bg-green">Verifikasi</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div>
            <a href="<?= base_url('admin/rekapExcel?major=' . $dataMajor . '&tp=' . $dataTp); ?>">
                <button class="btn bg-gradient-green">
                    <em class="fa fa-file-excel"></em> Export Excel
                </button>
            </a>
            <a href="<?= base_url('admin/rekapPDF?major=' . $dataMajor . '&tp=' . $dataTp); ?>">
                <button class="btn bg-gradient-red">
                    <em class="fa fa-file-pdf"></em> Export PDF
                </button>
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>; ?>