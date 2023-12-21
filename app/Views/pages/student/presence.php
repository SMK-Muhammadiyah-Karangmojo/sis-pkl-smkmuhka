<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3>Hallo, <b><?= $data->name; ?></b></h3>
                    </div>
                    <div class="card-body">
                        <div class="card-footer">
                            <button class="btn btn-primary" onclick="addPresence(<?= $users_id; ?>)">Presensi Masuk
                            </button>
                            <button class="btn btn-danger">Presensi Pulang</button>
                        </div>
                        <table id="dataTable" class="table table-sm table-bordered table-striped">
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Pulang</th>
                                <th>Lokasi</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $number = 1;
                            foreach ($data_presence as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $number++; ?></td>
                                    <td><?= format_indo($item->date); ?></td>
                                    <td class="text-center"><?= $item->time_in; ?></td>
                                    <td class="text-center"><?= $item->time_out; ?></td>
                                    <td>
                                        <?= $item->latitude; ?>,<?= $item->longitude; ?>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="map" style="height: 400px;width: 100%"></div>
    </div>

    <script>

        if ("geolocation" in navigator) {
            function addPresence(userId) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    // document.getElementById('lihat-di-maps').addEventListener('click', function () {
                    //     let mapsUrl = 'https://www.google.com/maps?q=' + latitude + ',' + longitude;
                    //     window.open(mapsUrl, '_blank');
                    // });
                    presenceIn(userId, latitude, longitude)
                });
            }

        } else {
            alert("Geolocation tidak didukung di browser Anda.");
        }

    </script>
<?= $this->endSection() ?>