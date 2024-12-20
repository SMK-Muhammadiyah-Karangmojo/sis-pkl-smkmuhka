function addTeacher() {
    Swal.fire({
        title: "Tambah Guru",
        html: `
            <div id="label-swal">
                <h3>Informasi Akun</h3>
                <div class="form-group">
                    <label for="email">Email</label>                  
                    <input class="form-control" type="text" id="email" name="email"/>
                </div>
                <h3>Informas Pribadi</h3>
                <div class="form-group">
                    <label for="nip">NIP/NBM</label>                  
                    <input class="form-control" type="text" id="nbm" name="nbm"/>
                </div>
                <div class="form-group">
                    <label for="nip">Nama Lengkap</label>                  
                    <input class="form-control" type="text" id="name" name="name"/>
                </div>
                <div class="form-group">
                    <label for="nip">Jabatan</label>                  
                    <input class="form-control" type="text" id="position" name="position"/>
                </div>
                <div class="form-group">
                    <label for="nip">HP</label>                  
                    <input class="form-control" type="text" id="hp" name="hp" >
                </div>
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Save",
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            fetchingData('/api/v1/teacher',
                {
                    email: Swal.getPopup().querySelector("#email").value,
                    nbm: Swal.getPopup().querySelector("#nbm").value,
                    name: Swal.getPopup().querySelector("#name").value,
                    position: Swal.getPopup().querySelector("#position").value,
                    hp: Swal.getPopup().querySelector("#hp").value,
                }, 'POST'
            ).then(response => {
                if (response.responseData.responseCode === 200) {
                    Swal.fire({
                        icon: response.responseData.responseMsg,
                        title: "Tambah Guru sukses!!!",
                    });
                    // setTimeout(function () {
                    //     window.location.reload(1);
                    // }, 2000);
                }
            }).catch(error => {
                console.log(error)
            })
        },
    })
}

async function updateTeacher(id) {
    await fetchingData(`/api/v1/teacher/${id}`, {}, 'GET')
        .then(response => {
            let result = response.result;
            Swal.fire({
                title: "Edit Guru",
                html: `
                     <div id="label-swal">
                        <div class="form-group">
                            <label for="nip">NIP/NBM</label>                  
                            <input class="form-control" type="text" id="nbm" name="nbm" value="${result.nbm}"/>
                        </div>
                        <div class="form-group">
                            <label for="nip">Nama Lengkap</label>                  
                            <input class="form-control" type="text" id="name" name="name" value="${result.name}"/>
                        </div>
                        <div class="form-group">
                            <label for="nip">Jabatan</label>                  
                            <input class="form-control" type="text" id="position" name="position" value="${result.position}"/>
                        </div>
                        <div class="form-group">
                            <label for="nip">HP</label>                  
                            <input class="form-control" type="text" id="hp" name="hp" value="${result.hp}"/>
                        </div>
                    </div>
               `,
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: "Update",
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    let data = {
                        id: result.id,
                        nbm: Swal.getPopup().querySelector("#nbm").value,
                        name: Swal.getPopup().querySelector("#name").value,
                        position: Swal.getPopup().querySelector("#position").value,
                        hp: Swal.getPopup().querySelector("#hp").value
                    };
                    fetchingData(`/api/v1/teacher/${result.id}`, data, 'PATCH')
                        .then(response => {
                            if (response.responseData.responseCode === 200) {
                                Swal.fire({
                                    icon: response.responseData.responseMsg,
                                    title: "data updated successfully!!!",
                                });
                                setTimeout(function () {
                                    window.location.reload(1);
                                }, 2000);
                            }
                        })
                        .catch(error => {
                            console.log(error)
                        })
                }
            })
        })
        .catch(error => {
            console.log(error)
        })
}