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
                            <?php
                            if (!$cek_presence) {
                                ?>
                                <button class="btn btn-primary m-1" onclick="addPresenceIn(<?= $users_id; ?>)">Presensi
                                    Masuk
                                </button>
                                <?php
                            } elseif (!$cek_presence->time_out) {
                                ?>
                                <button class="btn btn-danger m-1"
                                        onclick="addPresenceOut(<?= $users_id; ?>, <?= $cek_presence->id; ?>)">
                                    Presensi Pulang
                                </button>
                                <?php
                            } else {
                                ?>
                                <h5>Terima kasih <strong><?= $data->name; ?></strong> untuk hari ini sudah melakukan
                                    presensi
                                    masuk dan pulang</h5>
                                <?php
                            }
                            ?>
                        </div>
                        <table id="dataTable" class="table table-sm table-bordered table-striped">
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Pulang</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $number = 1;
                            foreach ($data_presence as $item) {
                                ?>
                                <tr>
                                    <td class="text-center"><?= $number++; ?></td>
                                    <td><?= tanggal($item->date); ?></td>
                                    <td class="text-center"><?= $item->time_in; ?></td>
                                    <td class="text-center"><?= $item->time_out; ?></td>
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
            function addPresenceIn(userId) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;
                    presenceIn(userId, latitude, longitude)
                });
            }

            function addPresenceOut(userId, id) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;
                    presenceOut(userId, id, latitude, longitude)
                });
            }

        } else {
            alert("Geolocation tidak didukung di browser Anda.");
        }

    </script>
<?= $this->endSection() ?>