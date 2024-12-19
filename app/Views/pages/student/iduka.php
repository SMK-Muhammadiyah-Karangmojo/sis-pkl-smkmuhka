<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3><b><?= $data->nis . '|' . $data->name; ?></b></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-9">
                            <h4>
                                Saat ini anda terdaftar PKL di <b><?= $dataIduka->name; ?></b>
                                yang beralamat di <b><?= $dataIduka->address; ?></b>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th width="10px">No</th>
                <th>Iduka</th>
                <th>Alamat</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 1; ?>
            <?php foreach ($iduka as $d) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td id="name"><?= $d->name; ?></td>
                    <td id="address"><?= $d->address; ?></td>
                    <td>
                        <button class="btn btn-primary btn-xs"
                                onclick="updateIdukaStudent(<?= $data->nis;?>,<?= $d->id; ?>)">
                            Ajukan
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>; ?>