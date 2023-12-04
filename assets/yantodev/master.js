function changeStatus(data) {
    console.log(data)
    return 'readonly'
}

function pendamping() {
    let major = document.getElementById("major").value;
    let tp = document.getElementById("tp1").value;
    window.location.href = baseUrl + '/admin/pendamping?major=' + major + '&tp=' + tp;
}

function rekapDataPKL() {
    let major = document.getElementById("major").value;
    let tp = document.getElementById("tp1").value;
    window.location.href = baseUrl + '/admin/rekap?major=' + major + '&tp=' + tp;
}

async function addPendamping() {
    fetchingData('/RestApi/addPendamping', {
        tp: document.getElementById("tp").value,
        major: document.getElementById("major_id").value,
        iduka: document.getElementById("iduka").value,
        teacher: document.getElementById("teacher").value
    }).then(response => {
        if (response.code === 200) {
            Swal.fire({
                icon: "success", title: "Added data successfully!!!"
            })
            setTimeout(function () {
                window.location.reload(1);
            }, 2000);
        } else {
            Swal.fire({
                icon: "error", title: response.code, text: response.message
            })
        }
    })
}

async function editTutor(id) {
    let result = await findTutorById(id);
    let iduka = await findIdukaByTp(result.tpId);
    Swal.fire({
        title: "Edit Guru Pendamping",
        html: `
            <div>
            <input type="hidden" id="id" value="${result.id}"/>
            <input type="hidden" id="userId" value="${result.userId}"/>
                <div class="mb-3">
                    <select class="form-control" type="text" id="iduka" class="swal2-input">
                        <option value="${result.idIduka}">${result.iduka}</option>
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
            let majorId = await findIdukaById(Swal.getPopup().querySelector("#iduka").value)
                .then(r => {
                    return r.major
                })
            let data = {
                id: Swal.getPopup().querySelector("#id").value,
                userId: Swal.getPopup().querySelector("#userId").value,
                iduka: Swal.getPopup().querySelector("#iduka").value,
                major: majorId,
                tp: result.tpId
            }
            fetchingData('/RestApi/updateTutor/', data)
                .then(response => {
                    if (response.code === 200) {
                        Swal.fire({
                            icon: response.message, title: "data updated successfully!!!",
                        });
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                    }
                })
        },
    })
}

function deleteTutor(id) {
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
            fetchingData("/RestApi/deleteTutor", {id})
                .then(response => {
                    Swal.fire("Deleted!", "Your file has been deleted is.", "success");
                })
            setTimeout(function () {
                window.location.reload(1);
            }, 2000);
        }
    });
}

async function findTutorById(id) {
    return fetchingData('/RestApi/findTutorById', {id})
        .then(response => {
            if (response.code === 200) {
                return response.result
            }
            console.log(response)
        })
        .catch(error => {
            console.log(error)
        })
}

async function findMajor() {
    let major = [];
    await fetchingData('/Major/findAllMajor').then(response => {
        for (const element of response.result) {
            let id = element.id;
            let name = element.name;
            major.push("<option value=" + id + ">" + name + "</option>");
        }
    }).catch(error => {
        console.log(error)
    })
    return major;
}

async function findIdukaById(id) {
    return fetchingData('/Iduka/detail', {id})
        .then(response => {
            if (response.responseData.responseCode == 200) {
                return response.result
            }
            console.log(response)
        })
        .catch(error => {
            console.log(error)
        })
}

async function findIdukaByTp(tp) {
    let iduka = [];
    await fetchingData('/Iduka/findAllIdukaByTp/' + tp)
        .then(response => {
            for (const element of response.result) {
                let id = element.id;
                let name = element.name;
                iduka.push("<option value=" + id + ">" + name + "</option>");
            }
        }).catch(error => {
            console.log(error)
        })
    return iduka;
}

async function findIdukaByMajor(major) {
    let iduka = [];
    await fetchingData('/Iduka/findAllIdukaByMajor/' + major)
        .then(response => {
            if (response.responseData.responseCode == 200) {
                for (const element of response.result) {
                    let id = element.id;
                    let name = element.name;
                    iduka.push("<option value=" + id + ">" + name + "</option>");
                }
            } else {
                console.log(response)
            }
        }).catch(error => {
            console.log(error)
        })
    return iduka;
}

async function findTp() {
    let tp = [];
    await fetchingData('/Tp/findAllTp')
        .then(response => {
            for (const element of response.result) {
                let id = element.id;
                let name = element.name;
                tp.push("<option value=" + id + ">" + name + "</option>");
            }
        }).catch(error => {
            console.log(error)
        })
    return tp;
}

async function findAllTeacher() {
    let teacher = [];
    await fetchingData('/User/teacher').then(response => {
        if (response.code == 200) {
            for (const element of response.result) {
                let id = element.id;
                let name = element.name;
                teacher.push("<option value=" + id + ">" + name + "</option>");
            }
        } else {
            console.log(response)
        }
    }).catch(error => {
        console.log(error)
    })
    return teacher;
}

async function findAllClassByMajor(major) {
    let result = [];
    await fetchingData('/RestApi/findAllClassByMajor', {major})
        .then(response => {
            if (response.code == 200) {
                for (const element of response.result) {
                    let id = element.id;
                    let name = element.name;
                    result.push("<option value=" + id + ">" + name + "</option>");
                }
            } else {
                console.log(response)
            }
        })
        .catch(error => {
            console.log(error)
        })
    return result;
}

async function findMajorByClass(id) {
    return fetchingData('/RestApi/findMajorByClass', {id})
        .then(response => {
            if (response.code == 200) {
                return response.result
            }
            console.log(response)
        })
        .catch(error => {
            console.log(error)
        })
}

function syncData() {
    let results = [];
    Swal.fire({
        title: "Apakah kamu yakin?",
        text: "Data yang sudah di sinkronisasi tidak bisa dikembalikan lagi!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Saya yakin!",
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading()
    }).then(result => {
        Swal.fire({
            icon: "info",
            title: 'Please Wait!',
            html: 'Data on processing synchronization...',
            allowOutsideClick: Swal.showLoading()
        });
        Swal.showLoading()
        fetchingData("/RestApi/syncData")
            .then(async response => {
                let result = response.result
                let code = response.responseData.responseCode
                if (code === 200) {
                    for (const element of result) {
                        await fetchingData("/RestApi/cekMasterData", {
                            nis: element.nis
                        }).then(response => {
                            let result = response.result
                            if (result) {
                                updateMasterDataByNis(element)
                                results.push("<tr>" +
                                    "<td>" + element.nis + "</td>" +
                                    "<td>" + element.name + "</td>" +
                                    "<td>Success</td>" +
                                    "</tr>")
                            } else {
                                results.push("<tr>" +
                                    "<td>" + element.nis + "</td>" +
                                    "<td>" + element.name + "</td>" +
                                    "<td>Gagal</td>" +
                                    "</td>" +
                                    "</tr>")
                            }
                        })
                    }
                    await Swal.fire({
                        icon: 'success',
                        title: 'Done!!!',
                        html: `<h2>Data synchronization is success...</h2>`,
                        allowOutsideClick: !Swal.showLoading()
                    });
                } else {
                    Swal.fire("Opss!", "Data gagal di sinkronisasi.", "error");
                }
            })
    });
}

function updateMasterDataByNis(data) {
    fetchingData("/RestApi/updateMasterDataByNis",
        {
            nis: data.nis,
            tpId: data.tpId,
            id: data.id
        }
    ).then(response => {
        return response.result
    }).catch(error => {
        console.log(error)
    })
}

function modal() {
    console.log("test modal")
}

async function findAllCategory() {
    let category = [];
    await fetchingData('/RestApi/findCategory').then(response => {
        if (response.responseData.responseCode == 200) {
            for (const element of response.result) {
                let id = element.id;
                let name = element.name;
                category.push("<option value=" + id + ">" + name + "</option>");
            }
        } else {
            console.log(response)
        }
    }).catch(error => {
        console.log(error)
    })
    return category;
}