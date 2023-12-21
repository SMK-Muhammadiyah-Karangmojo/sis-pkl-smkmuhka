/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

function presenceIn(userId, latitude, longitude) {
    Swal.fire({
        title: "Apakah anda yakin akan melakukan presensi masuk?",
        html: `
            <form id="imageUploadForm" enctype="multipart/form-data">
                <div class="form-group text-left">
                    <label for="imageInput" class="form-label">Silahkan upload foto selfie terlebih dahulu</label>
                    <input class="form-control" type="file" name="imageInput" id="imageInput" accept="image/*">
                </div>
            </form>
        `,
        focusConfirm: false,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Yakin!",
        preConfirm: () => {
            const fileInput = Swal.getPopup().querySelector('#imageInput');
            let file = fileInput.files[0];
            if (file == null) {
                Swal.showValidationMessage('foto selfie wajib diisi!!');
            } else {
                let form = new FormData();
                form.append("user_id", userId);
                form.append("latitude", latitude);
                form.append("longitude", longitude);
                form.append("image", file);
                Swal.showLoading();
                return $.ajax({
                    method: "POST",
                    url: baseUrl + "/student/presence",
                    data: form,
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                }).done(function (response) {
                    return response;
                });
            }
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then(result => {
            let jsonObject = JSON.parse(result.value);
            console.log(jsonObject)
            if (result.isConfirmed && jsonObject.result) {
                Swal.hideLoading();
                Swal.fire({
                    icon: "success",
                    title: "Anda berhasil melakukan presensi masuk!!!",
                });
                setTimeout(function () {
                    window.location.reload(1);
                }, 3000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: jsonObject.value.responseData.responseMsg
                });
            }
        }
    )
}

function presenceOut(userId, id, latitude, longitude) {
    Swal.fire({
        title: "Apakah anda yakin akan melakukan presensi pulang?",
        html: `
            <form id="imageUploadForm" enctype="multipart/form-data">
                <div class="form-group text-left">
                    <label for="imageInput" class="form-label">Silahkan upload foto selfie terlebih dahulu</label>
                    <input class="form-control" type="file" name="imageInput" id="imageInput">
                </div>
            </form>
        `,
        focusConfirm: false,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Yakin!",
        preConfirm: () => {
            const fileInput = Swal.getPopup().querySelector('#imageInput');
            let file = fileInput.files[0];
            if (file == null) {
                Swal.showValidationMessage('foto selfie wajib diisi!!');
            } else {
                let form = new FormData();
                form.append("user_id", userId);
                form.append("latitude", latitude);
                form.append("longitude", longitude);
                form.append("image", file);
                form.append("id", id);
                Swal.showLoading();
                return $.ajax({
                    method: "POST",
                    url: baseUrl + "/student/presence",
                    data: form,
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                }).done(function (response) {
                    return response;
                });
            }
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then(result => {
            let jsonObject = JSON.parse(result.value);
            console.log(jsonObject)
            if (result.isConfirmed && jsonObject.result) {
                Swal.hideLoading();
                Swal.fire({
                    icon: "success",
                    title: "Anda berhasil melakukan presensi pulang!!!",
                });
                setTimeout(function () {
                    window.location.reload(1);
                }, 3000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: jsonObject.value.responseData.responseMsg
                });
            }
        }
    )
}