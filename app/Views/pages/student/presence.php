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
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Pulang</th>
                                <th>Lokasi</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>12 Desember 2023</td>
                                <td>07:00</td>
                                <td>16:00</td>
                                <td id="lihat-di-maps">
                                </td>
                                <td>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="map" style="height: 400px;width: 100%"></div>
    </div>
<?php
//// Koordinat yang ingin Anda ubah menjadi alamat
//$latitude = '-6.2327497';
//$longitude = '106.780565';
//
//// API Key dari Google Maps (pastikan ini adalah kunci API yang valid dari Google Cloud Console)
//$apiKey = 'AIzaSyCIe0c2C6vRVTo9PulXODspLMS2fV7fGWQ';
//
//// Buat URL untuk permintaan Geocoding
//$apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";
//
//// Lakukan permintaan ke API Geocoding
//$response = file_get_contents($apiUrl);
//
//// Ubah respons JSON menjadi array
//$data = json_decode($response, true);
//
//// Ambil alamat jika ada hasil
//if ($data['status'] === 'OK') {
//    $address = $data['results'][0]['formatted_address'];
//    echo 'Alamat dari koordinat ini adalah: ' . $address;
//} else {
//    echo 'Tidak dapat menemukan alamat untuk koordinat ini.';
//}
//?>

    <script>
        function initMap() {
            // Ganti dengan koordinat yang telah Anda dapatkan
            var latitude = -6.2327497//;
            var longitude = 106.780565//;

            var location = {lat: latitude, lng: longitude};

            // Buat peta
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 20, // Ganti dengan level zoom yang diinginkan
                center: location
            });

            // Tambahkan penanda pada lokasi
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });
        }

        if ("geolocation" in navigator) {
            function addPresence(userId) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let latitude = position.coords.latitude;
                    let longitude = position.coords.longitude;

                    document.getElementById("lihat-di-maps").innerHTML =
                        `<div><p>${latitude},${longitude}</p>
                        <button class="btn btn-sm btn-outline-primary" id="lihat-di-maps">Open G-Maps</button></div>`

                    document.getElementById('lihat-di-maps').addEventListener('click', function () {
                        // Buat URL Google Maps dengan koordinat yang diperoleh
                        let mapsUrl = 'https://www.google.com/maps?q=' + latitude + ',' + longitude;

                        // Buka URL Google Maps pada tab atau jendela baru
                        window.open(mapsUrl, '_blank');
                    });
                    presenceIn(userId, latitude, longitude)
                });
            }

        } else {
            alert("Geolocation tidak didukung di browser Anda.");
        }

    </script>
<?= $this->endSection() ?>