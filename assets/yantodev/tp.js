async function getAllTp() {
    return await fetchingData('/Tp/findAllTp').then(response => {
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

async function findById(id) {
    return fetchingData('/Tp/findById', {id: id})
        .then(response => {
            return response;
        })
}

function addTp() {
    Swal.fire({
        title: "Tambah Tahun Pelajaran",
        html: `
            <div>
                <div class="mb-3">
                    <input class="form-control" type="text" id="name" class="swal2-input" placeholder="Tahun Pelajaran" >
                </div>
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Add",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            fetchingData('/Tp/addTp', {
                name: Swal.getPopup().querySelector("#name").value,
            }).then(response => {
                if (response.code === 200) {
                    Swal.fire({
                        icon: "success",
                        title: "Add data successfully!!!"
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

async function updateTp(id) {
    let name = '';
    await findById(id).then(async r => {
        name = await r.result.name
    })
    Swal.fire({
        title: "Edit Iduka",
        html: `
            <div>
                <div class="mb-3">
                    <input class="form-control" type="text" id="name" class="swal2-input" placeholder="Tahun Pelajaran" value="${name}">
                </div>
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Add",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            fetchingData('/Tp/updateTp', {
                id,
                name: Swal.getPopup().querySelector("#name").value,
            }).then(response => {
                if (response.code === 200) {
                    Swal.fire({
                        icon: "success",
                        title: "Update data successfully!!!"
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

function deleteTp(id) {
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
            fetchingData("/Tp/deleteTp", {id: id}).then(response => {
                console.log(response)
                Swal.fire("Deleted!", "Your file has been deleted is.", "success");
            })
            setTimeout(function () {
                window.location.reload(1);
            }, 2000);
        }
    });
}