<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */
echo $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

    <div class="card card-outline-tabs card-info">
        <div class="card-header">Informasi Semua Presensi</div>
        <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                <tr class="text-center table-primary">
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Siswa</th>
                    <th rowspan="2">Kelas</th>
                    <th colspan="3">Presensi</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr class="text-center table-primary">
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $number = 1;
                foreach ($data as $item) {
                    ?>
                    <tr>
                        <td><?= $number++; ?></td>
                        <td><?= $item->name; ?></td>
                        <td><?= $item->class; ?></td>
                        <td><?= tanggal($item->date); ?></td>
                        <td class="text-center"><?= $item->time_in; ?></td>
                        <td class="text-center"><?= $item->time_out; ?></td>
                        <td class="text-center">
                            <a href="<?= base_url() . '/presence/detail/' . $item->id; ?>">
                                <button class="btn btn-sm btn-primary">Detail</button>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>