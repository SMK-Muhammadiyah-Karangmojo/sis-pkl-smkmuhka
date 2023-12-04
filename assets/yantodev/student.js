function getStudentByMajor() {
    let majorId = document.getElementById("major").value;
    window.location.href = baseUrl + '/admin/data?major=' + majorId;
}

async function editStudent(id, masterDataId) {
    let student = await getDetailStudent(id)
    let iduka = await findIdukaByMajor(student.majorId);
    Swal.fire({
        title: "Edit Siswa",
        html: `
            <div>
                <div class="mb-3">
                    <input class="form-control" type="text" id="name" value="${student.name}" readonly/>
                </div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="kelas" readonly>
                        <option value="${student.classId}">${student.kelas}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="major" readonly>
                        <option value="${student.majorId}">${student.major}</option>
                    </select>
                </div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="iduka" >
                        <option value="${student.idukaId}">${student.iduka}</option>
                        ${iduka}
                    </select>
                </div>
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Update",
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            console.log(student)
            fetchingData('/RestApi/updateMasterDataStudent/', {
                id: masterDataId,
                nis: student.nis,
                tp: student.tpId,
                iduka: Swal.getPopup().querySelector("#iduka").value
            })
                .then(response => {
                    if (response.responseData.responseCode === 200) {
                        Swal.fire({
                            icon: response.responseData.responseMsg,
                            title: "data updated successfully!!!",
                        });
                        console.log(response)
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                    }
                })
        },
    })
}

async function getDetailStudent(id) {
    return fetchingData('/RestApi/findStudentById', {id})
        .then(response => {
            if (response.responseData.responseCode === 200) {
                return response.result
            }
            console.log(response)
        })
        .catch(error => {
            console.log(error)
        })
}

function imagePreview() {
    const imageProfile = document.querySelector('#profile');
    const imageLabel = document.querySelector('.custom-file-label');
    const imagePreview = document.querySelector('.img-preview');

    imageLabel.textContent = imageProfile.files[0].name;

    const fileImage = new FileReader();
    fileImage.readAsDataURL(imageProfile.files[0]);

    fileImage.onload = function (e) {
        imagePreview.src = e.target.result;
    }
}

function imageVerifikasiPreview() {
    const imageProfile = document.querySelector('#image');
    const imageLabel = document.querySelector('.custom-file-label');
    const imagePreview = document.querySelector('.img-preview');

    imageLabel.textContent = imageProfile.files[0].name;

    const fileImage = new FileReader();
    fileImage.readAsDataURL(imageProfile.files[0]);

    fileImage.onload = function (e) {
        imagePreview.src = e.target.result;
    }
}

async function updateIdukaStudent(nis, id) {
    let iduka = await findIdukaById(id).then(x => {
            return x.name
        }
    );
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: "PKL di " + iduka,
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetchingData('/RestApi/updateIdukaStudent', {
                nis, id
            }).then(response => {
                if (response.code === 200) {
                    Swal.fire({
                        icon: response.message,
                        title: "Pengajuan lokasi PKL Berhasil!!!",
                    });
                    console.log(response)
                    setTimeout(function () {
                        window.location.reload(1);
                    }, 2000);
                }
            }).catch(error => {
                console.log(error)
            })
        }
    });
}

async function showMasterSubLaporan() {
    let id = document.getElementById("master_laporan").value;
    let result = await findMasterSubLaporan(id)
    if (result) {
        document.getElementById("master_sub_laporan").innerHTML =
            '<label for="sub_laporan">Uraian Kegiatan</label>' +
            '<select class="form-control" id="sub_laporan" name="sub_laporan"' +
            'onchange="showMasterSubLaporan1()" required>' +
            '<option value="">Pilih Uraian</option>' +
            result +
            '</select>'
    } else {
        document.getElementById("other_input").innerHTML =
            `<label for="other">Uraian Kegiatan</label><input class="form-control" type="text"id="other" name="other"placeholder="masukan uraian kegiatan" required>`
    }
}

async function showMasterSubLaporan1() {
    let id = document.getElementById("sub_laporan").value;
    let result = await findSubLaporan(id)
    if (result) {
        document.getElementById("master_sub_laporan_1").innerHTML =
            '<label for="sub_laporan_1">Uraian Kegiatan</label>' +
            '<select class="form-control" id="sub_laporan_1" name="sub_laporan_1" required>' +
            '<option value="">Pilih uraian</option>' +
            result +
            '</select>'
    } else {
        document.getElementById("master_sub_laporan_1").style.display = 'none';
    }

}

async function findMasterSubLaporan(id) {
    let result = [];
    await fetchingData('/Student/findSubLaporan',
        {id}
    ).then(response => {
        if (response.result.length !== 0) {
            for (const element of response.result) {
                let id = element.id;
                let name = element.text;
                result.push("<option value=" + id + ">" + name + "</option>");
            }
        } else {
            result = false;
        }
    }).catch(error => {
        console.log(error)
    })
    return result;
}

async function findSubLaporan(id) {
    let result = [];
    await fetchingData('/Student/findSubLaporan1',
        {id}
    ).then(response => {
        console.log(response.result.length)
        if (response.result.length !== 0) {
            for (const element of response.result) {
                let id = element.id;
                let name = element.text;
                result.push("<option value=" + id + ">" + name + "</option>");
            }
        } else {
            result = false;
        }
    }).catch(error => {
        console.log(error)
    })
    return result;
}

function deleteReport(id) {
    console.log(id)
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: "Data setelah di hapus tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Yakin!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetchingData("/Student/deleteReport", {id})
                .then(response => {
                    if (response.responseData.responseCode === 200) {
                        Swal.fire("Deleted!", "Your file has been deleted is.", "success");
                    }
                })
            setTimeout(function () {
                window.location.reload(1);
            }, 2000);
        }
    });
}