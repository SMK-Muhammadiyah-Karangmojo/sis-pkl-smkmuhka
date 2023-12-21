/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.my.id/
 */

function presenceIn(userId, latitude, longitude) {
    console.log(userId)
    console.log(latitude)
    console.log(longitude)

    Swal.fire({
        title: "Apakah anda yakin akan melakukan presensi?",
        text: `Lokasi kordinat anda saat ini di ${latitude},${longitude}`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Yakin!",
    });
}