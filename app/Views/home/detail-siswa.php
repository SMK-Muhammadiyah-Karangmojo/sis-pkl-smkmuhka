<?php
/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */
$no_image = "https://cdn2.iconfinder.com/data/icons/delivery-and-logistic/64/Not_found_the_recipient-no_found-person-user-search-searching-4-512.png";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Detail Siswa</title>
</head>
<body>
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary">
            <h3>
                Detail Siswa
            </h3>
        </div>
        <div class="text-center m-3">
            <img src="<?= $no_image; ?>" alt="image-profile" height="300px" width="300px">
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="nama">
                            Nama Lengkap Siswa
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" id="nama" type="text" value="<?= $data->name; ?>" readonly>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="nama">
                            NIS Siswa
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" id="nama" type="text" value="<?= $data->nis; ?>" readonly>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="nama">
                            Guru Pendamping
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" id="nama" type="text" value="<?= $data->teacher; ?>" readonly>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="nama">
                            HP Guru Pendamping
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" id="nama" type="text" value="<?= $data->hp; ?>" readonly>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="nama">
                            Tempat PKL (Iduka)
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" id="nama" type="text" value="<?= $data->iduka; ?>" readonly>
                    </div>
                </div>
            </li>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-sm-3">
                        <label for="nama">
                            Alamat PKL
                        </label>
                    </div>
                    <div class="col-sm-9">
                        <input class="form-control" id="nama" type="text" value="<?= $data->address; ?>" readonly>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>
