let tpId = 0;
let iduka = [];

function getMentorDetail() {
    let idJurusan = document.getElementById("jurusan").value;
    window.location.href = baseUrl + '/mentor/mentor?jurusan=' + idJurusan;
}

function addMentor(idukaId, tpId) {
    Swal.fire({
        title: "Add Mentor Detail",
        html: `
            <div>
                <div class="form-group">
                    <input class="form-control" type="text" id="name" placeholder="Nama Pembimbing PKL">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" id="position" placeholder="Jabatan">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" id="identityNumber" placeholder="NIP/NRP">
                </div>
                <div class="form-group">
                    <input class="form-control" type="text" id="hp" placeholder="No. Telp">
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" id="email"  placeholder="E-Mail">
                </div>
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Add",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            let data = {
                idukaId,
                tpId,
                name: Swal.getPopup().querySelector("#name").value,
                position: Swal.getPopup().querySelector("#position").value,
                identityNumber: Swal.getPopup().querySelector("#identityNumber").value ? Swal.getPopup().querySelector("#identityNumber").value : "-",
                hp: Swal.getPopup().querySelector("#hp").value ? Swal.getPopup().querySelector("#hp").value : 0,
                email: Swal.getPopup().querySelector("#email").value ? Swal.getPopup().querySelector("#email").value : "-"
            };
            console.log(data)
            fetchingData('/mentor/mentor/addMentor', data)
                .then(response => {
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
                            title: response.responseData.responseCode,
                            text: response.responseData.responseMsg
                        })
                    }
                })
        },
    });
}

function editMentor(id) {
    fetchingData("/mentor/mentor/editMentor/" + id)
        .then(response => {
            let responseData = response.responseData;
            if (responseData.responseCode == 200) {
                let result = response.result;
                console.log(result)
                editMentorDetail(result)
            }
        })
        .catch(error => {
            console.log(error)
        })
}

function editMentorDetail(data) {
    Swal.fire({
        title: "Edit Mentor Detail",
        html: `
            <div>
                <div class="form-group">
                    <label for="name">Nama</label>
                    <input class="form-control" type="text" id="name" value="${data.name}" >
                </div>
                <div class="form-group">
                    <label for="position">Jabatan</label>
                    <input class="form-control" type="text" id="position" value="${data.position}" >
                </div>
                <div class="form-group">
                    <label for="identityNumber">NIP/NRK</label>
                    <input class="form-control" type="text" id="identityNumber" value="${data.identity_number}" >
                </div>
                <div class="form-group">
                    <label for="hp">No. Telp</label>
                    <input class="form-control" type="text" id="hp" value="${data.hp}">
                </div>
                <div class="form-group">
                    <label for="email">E-Mail</label>
                    <input class="form-control" type="email" id="email"  value="${data.email}" >
                </div>
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Add",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            fetchingData('/mentor/mentor/editMentor/0', {
                id: data.id,
                name: Swal.getPopup().querySelector("#name").value,
                position: Swal.getPopup().querySelector("#position").value,
                identityNumber: Swal.getPopup().querySelector("#identityNumber").value,
                hp: Swal.getPopup().querySelector("#hp").value,
                email: Swal.getPopup().querySelector("#email").value
            })
                .then(response => {
                    if (response.responseData.responseCode === 200) {
                        Swal.fire({
                            icon: "success", title: "Edit data successfully!!!", text: response.responseData.responseMsg
                        })
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 3000);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: response.responseData.responseCode,
                            text: response.responseData.responseMsg
                        })
                    }
                })
        },
    });
}