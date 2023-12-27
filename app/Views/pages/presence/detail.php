<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */
if (!empty($data_presence)) {
    $image_in = $data_presence->image_in;
    $image_out = $data_presence->image_out;

    if (!$image_out) {
        $image_out = "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/832px-No-Image-Placeholder.svg.png";
    }
    if (!$image_in) {
        $image_in = "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/832px-No-Image-Placeholder.svg.png";
    }
}
echo $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

    <div class="card card-outline-tabs card-info">
        <div class="card-header">Informasi Detail Presensi</div>
        <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="name">Nama Siswa</label>
                        <input class="form-control" type="text" id="name" name="name" value="<?= $data_presence->name; ?>"
                               readonly>
                    </div>
                    <div class="col-sm-4">
                        <label for="name">Kelas</label>
                        <input class="form-control" type="text" id="name" name="name" value="<?= $data_presence->class; ?>"
                               readonly>
                    </div>
                    <div class="col-sm-4">
                        <label for="name">Tanggal</label>
                        <input class="form-control" type="text" id="name" name="name"
                               value="<?= tanggal($data_presence->date); ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="name">Foto Masuk</label>
                                <div>
                                    <img src="<?= $image_in; ?>" alt="image-in" width="280px" height="300px">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                    <label for="name">Masuk</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                           value="<?= $data_presence->time_in; ?>"
                                           readonly>
                                </div>
                                <div class="col-sm-12">
                                    <label for="name">Lokasi Masuk</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                           value="<?= $data_presence->location_in; ?>"
                                           readonly>
                                </div>
                                <div class="col-sm-12 m-3">
                                    <a href="https://www.google.com/maps?q=<?= $data_presence->location_in; ?>" target="_blank">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-map-location-dot m-1"></i>
                                            Buka G-Maps
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="name">Foto Pulang</label>
                                <div>
                                    <img src="<?= $image_out; ?>"
                                         alt="image-in" width="280px" height="300px">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-12">
                                    <label for="name">Pulang</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                           value="<?= $data_presence->time_out; ?>"
                                           readonly>
                                </div>
                                <div class="col-sm-12">
                                    <label for="name">Lokasi Pulang</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                           value="<?= $data_presence->location_out; ?>"
                                           readonly>
                                </div>
                                <div class="col-sm-12 m-3">
                                    <a href="https://www.google.com/maps?q=<?= $data_presence->location_out; ?>" target="_blank">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-map-location-dot m-1"></i>
                                            Buka G-Maps
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>