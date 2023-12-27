<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */
echo $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3><b>Data Presensi Siswa</b></h3>
        </div>
        <div class="card-body">
            <form action="" method="get">
                <div class="row">
                    <select class="form-control col-sm-3" name="tp" id="tp">
                        <option value="">Pilih Tahun Pelajaran</option>
                        <?php
                        foreach ($tp as $item) {
                            ?>
                            <option value="<?= $item['id']; ?>"><?= $item['name']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary ml-2">Lihat</button>
                </div>
            </form>
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="10px">No</th>
                    <th>Tahun Pelajaran</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                <?php foreach ($laporan as $lp) : ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $lp->tp_name; ?></td>
                        <td><?= $lp->nis; ?></td>
                        <td><?= $lp->name; ?></td>
                        <td>
                            <a href="<?= base_url('presence/siswa/' . $lp->id); ?>">
                                <button class="badge bg-primary"><i class="fas fa-eye"> Detail</i></button>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>; ?>