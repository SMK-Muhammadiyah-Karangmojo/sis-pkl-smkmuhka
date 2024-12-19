function updateTeacher(id) {
    console.log(id)
    fetchingData('/RestApi/findTeacherById', {id})
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
                    fetchingData("/Teacher/updateTeacher", data)
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