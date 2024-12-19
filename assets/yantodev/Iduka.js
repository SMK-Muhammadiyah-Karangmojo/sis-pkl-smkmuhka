/*
 * Copyright (c) 2023. Yantodev - All Rights Reserved.
 * @Author  :  yantodev
 * mailto : ekocahyanto007@gmail.com
 * link : https://yantodev.github.io/
 */

function getIduka() {
    let idJurusan = document.getElementById("jurusan").value;
    window.location.href = baseUrl + '/admin/iduka?jurusan=' + idJurusan;
}

async function addIduka() {
    let major = await getAllMajor().then(data => {
        return data;
    });
    Swal.fire({
        title: "Add Iduka",
        html: `
            <div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="major" class="swal2-input">
                        <option value="">--Pilih Jurusan--</option>
                        ${major}
                    </select>
                </div>
                <div class="mb-3">
                    <input class="form-control" type="text" id="name" class="swal2-input" placeholder="Nama Lokasi PKL" >
                </div>
                <div>
                    <input class="form-control" type="text" id="address" class="swal2-input" placeholder="Alamat Lokasi PKL" >
                </div>
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Add",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            fetchingData('/api/v1/iduka/add', {
                name: Swal.getPopup().querySelector("#name").value,
                address: Swal.getPopup().querySelector("#address").value,
                major: Swal.getPopup().querySelector("#major").value
            }).then(response => {
                console.log(response)
                if (response.responseData.responseCode === 200) {
                    Swal.fire({
                        icon: "success",
                        title: "Added data successfully!!!",
                        text: response.responseData.responseMsg
                    })
                    setTimeout(function () {
                        window.location.reload(1);
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: response.code,
                        text: response.message
                    })
                }
            })
        },
    });
}

async function updateIduka(idIduka, idMajor) {
    let id, ids, majorName, name, address;
    await detailMajor(idMajor).then(async r => {
        ids = await r.result.id;
        majorName = await r.result.name
    })
    await detailIduka(idIduka).then(async r => {
        id = await r.id
        name = await r.name
        address = await r.address
    }).catch(error => {
        console.log(error)
    })
    await fetchingData('/api/v1/major/find-all').then(response => {
        let major = [];
        for (const element of response.result) {
            let id = element.id;
            let name = element.name;
            major.push("<option value=" + id + ">" + name + "</option>");
        }
        Swal.fire({
            title: "Edit Iduka",
            html: `
            <div>
                <div class="mb-3">
                    <select class="form-control" type="text" id="major" class="swal2-input">
                        <option value="${ids}">${majorName}</option>
                        ${major}
                    </select>
                </div>
                <div>
                    <input type="hidden" id="id" class="swal2-input" placeholder="id" value="${idIduka}">
                </div>
                <div class="mb-3">
                    <input class="form-control" type="text" id="name" placeholder="name" value="${name}">
                </div>
                <div>
                    <textarea class="form-control" type="text" id="address" >${address}</textarea>
                </div>
            </div>
                `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: "Update",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                fetchingData('/api/v1/iduka/update', {
                    id,
                    major: Swal.getPopup().querySelector("#major").value,
                    name: Swal.getPopup().querySelector("#name").value,
                    address: Swal.getPopup().querySelector("#address").value,
                }).then(response => {
                    if (response.responseData.responseCode === 200) {
                        Swal.fire({
                            icon: 'success',
                            title: "data updated successfully!!!",
                        });
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                    }
                })
            },
        })
    }).catch(error => {
        Swal.fire({
            icon: "error",
            title: "update data is not successfully!!!",
            text: error
        })
    })
}

async function detailMajor(id) {
    return fetchingData('/api/v1/major/detail', {id: id})
        .then(response => {
            return response;
        })
}

async function detailIduka(id) {
    return fetchingData('/api/v1/iduka/detail', {id: id})
        .then(response => {
            console.log(response)
            if (response.responseData.responseCode === 200) {
                return response.result;
            }
        })
        .catch(error => {
            console.log(error)
        })
}

function deleteIduka(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetchingData("/api/v1/iduka/delete", {id: id}).then(response => {
                Swal.fire("Deleted!", "Your file has been deleted is.", "success");
            })
            setTimeout(function () {
                window.location.reload(1);
            }, 2000);
        }
    });
}

async function getAllMajor() {
    return await fetchingData('/api/v1/major/find-all').then(response => {
        let major = [];
        for (const element of response.result) {
            let id = element.id;
            let name = element.name;
            major.push("<option value=" + id + ">" + name + "</option>");
        }
        return major;
    }).catch(error => {
        Swal.fire({
            icon: "error",
            title: "Opss!!!",
            text: error
        })
    })
}

async function getAllIduka(major, tp) {
    return await fetchingData('/Iduka/findAllIdukaByMajorAndTp',
        {
            major: major,
            tp: tp
        }).then(response => {
        let major = [];
        for (const element of response.result) {
            let id = element.id;
            let name = element.name;
            major.push("<option value=" + id + ">" + name + "</option>");
        }
        return major;
    }).catch(error => {
        Swal.fire({
            icon: "error",
            title: "Opss!!!",
            text: error
        })
    })
}

function getAllIdukaByTpAndMajor() {
    let tp = document.getElementById("tp").value
    let major = document.getElementById("jurusan").value
    console.log(tp, major)
    fetchingData('/api/v1/iduka/find-all-by-major-and-tp', {
        major,
        tp
    }).then(response => {
        console.log(response)
        let major = [];
        for (const element of response.result) {
            let id = element.id;
            let name = element.name;
            major.push("<option value=" + id + ">" + name + "</option>");
        }
        document.getElementById("iduka").innerHTML = major;
    }).catch(error => {
        console.log(error)
    })
}