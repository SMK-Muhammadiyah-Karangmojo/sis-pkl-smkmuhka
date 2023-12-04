<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3>Welcome, <b><?= $data->name; ?></b></h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3" style="text-align: center">
                            <img src="<?= base_url('/assets/img/users/' . $data->image); ?>"
                                 class="img-circle elevation-2"
                                 alt="User Image" width="150px">
                        </div>
                        <div class="col-lg-9">
                            <table>
                                <tr>
                                    <td class="column">Lokasi PKL</td>
                                    <td class="column2">:</td>
                                    <td class="column-name"><?= $dataIduka->iduka; ?></td>
                                </tr>
                                <tr>
                                    <td class="column">Alamat</td>
                                    <td class="column2">:</td>
                                    <td class="column-name"><?= $dataIduka->address; ?></td>
                                </tr>
                                <tr>
                                    <td class="column">Status</td>
                                    <td class="column2">:</td>
                                    <td class="column-name"><?= statusPKL($dataIduka->status); ?></td>
                                </tr>
                                <tr>
                                    <td class="column">Pendamping</td>
                                    <td class="column2">:</td>
                                    <td class="column-name"><?= $dataIduka->teacher; ?></td>
                                </tr>
                                <tr>
                                    <td class="column">Hp. Guru</td>
                                    <td class="column2">:</td>
                                    <td class="column-name">
                                        <a href="https://wa.me/<?= numberWA($dataIduka->hp); ?>?text=Assalamu'alikum">
                                            <em class="fa-brands fa-whatsapp"></em>
                                            <?= numberWA($dataIduka->hp); ?>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <div class="mt-3">
                                <?php if (!$dataIduka->status): ?>
                                    <a href="<?= base_url('student/verifikasi?id=' . $dataIduka->id . '&statusData=student'); ?>">
                                        <button class="btn bg-gradient-green">
                                            <em class="fas fa-check-circle"></em>
                                            VERIFIKASI SEKARANG
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>