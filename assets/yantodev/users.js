function addUser() {
    alert("masih dalam pengembangan")
}

async function updateUser(id) {
    let student = await getDetailStudent(id)
    console.log(student)
    let kelas = await findAllClassByMajor(student.majorId)
    let tp = await findTp();
    let major = await findMajor()
    Swal.fire({
        title: "Edit Siswa",
        html: `
            <div id="label-swal">
                <div class="form-group">
                <label for="nisn">NISN</label>
                    <input class="form-control" type="text" id="nisn" value="${student.nisn}"/>
                </div>
                <div class="form-group">
                <label for="name" ">Nama Lengkap</label>
                    <input class="form-control" type="text" id="name" value="${student.name}"/>
                </div>
                <div class="form-group">
                <label for="kelas">Kelas</label>
                    <select class="form-control" type="text" id="kelas">
                        <option value="${student.classId}">${student.kelas}</option>
                        ${kelas}
                    </select>
                </div>
                 <div class="form-group">
                 <label for="tp">Tahun Pelajaran</label>
                    <select class="form-control" type="text" id="tp">
                        <option value="${student.tpId}">${student.tp}</option>
                        ${tp}
                    </select>
                </div>
                <div class="form-group">
                 <label for="major">Pilih Jurusan</label>
                    <select class="form-control" type="text" id="major">
                        <option value="${student.majorId}">${student.major}</option>
                        ${major}
                    </select>
                </div>
                <div class="form-group">
                 <label for="jk">Jenis Kelamin</label>
                    <select class="form-control" type="text" id="jk">
                        <option value="${student.jk}">${getJk(student.jk)}</option>
                        <option value="1">Laki-laki</option>
                        <option value="2">Perempuan</option>
                    </select>
                </div>
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Update",
        showLoaderOnConfirm: true,
        preConfirm: async () => {
            let res = await findMajorByClass(Swal.getPopup().querySelector("#kelas").value)
            if (res != null) {
                fetchingData('/RestApi/updateUserDetails/', {
                    id,
                    nisn: Swal.getPopup().querySelector("#nisn").value,
                    name: Swal.getPopup().querySelector("#name").value,
                    major: Swal.getPopup().querySelector("#major").value,
                    classId: Swal.getPopup().querySelector("#kelas").value,
                    tp: Swal.getPopup().querySelector("#tp").value,
                    jk: Swal.getPopup().querySelector("#jk").value,
                }).then(response => {
                    if (response.responseData.responseCode === 200) {
                        Swal.fire({
                            icon: response.responseData.responseMsg,
                            title: "data updated successfully!!!",
                        });
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                    }
                }).catch(error => {
                    Swal.fire(error.name, error.message, 'error');
                })
            } else {
                Swal.fire('Opsss!!', 'Update data gagal', 'error');
            }
        },
    })
}

function deleteUser() {
    alert("masih dalam pengembangan")
}

function editUser(id) {
    Swal.fire({
            title: "Edit Role",
            html: `
            <div id="label-swal">
                 <div class="mb-3">
                 <label class="ml-3">User Role</label>
                    <select class="form-control" type="text" id="role">
                        <option>--Pilih Role--</option>
                        <option value="2">Guru</option>
                        <option value="3">Siswa</option>
                    </select>
                </div>
            </div>
                `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: "Update",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                fetchingData('/User/updateUserRole/', {
                    id,
                    role: Swal.getPopup().querySelector("#role").value
                }).then(response => {
                    if (response.code === 200) {
                        Swal.fire({
                            icon: response.message,
                            title: "data updated successfully!!!",
                        });
                        setTimeout(function () {
                            window.location.reload(1);
                        }, 2000);
                    }
                }).catch(error => {
                    Swal.fire(error.name, error.message, 'error');
                })
            },
        }
    )
}

function resetPasswordUser(id) {
    Swal.fire({
            title: "Edit Role",
            html: `
            <div id="label-swal">
                 <div class="mb-3">
                 <label class="ml-3">New Password</label>
                    <input class="form-control" type="password" id="password"/>
                </div>
                <div class="mb-3">
                 <label class="ml-3">Retry Password</label>
                    <input class="form-control" type="password" id="password2"/>
                </div>
            </div>
                `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: "Update",
            showLoaderOnConfirm: true,
            preConfirm: async () => {
                let pass = Swal.getPopup().querySelector("#password").value;
                let passRetry = Swal.getPopup().querySelector("#password2").value;
                console.log(pass, passRetry)
                if (pass === passRetry) {
                    fetchingData('/User/resetPasswordUser/', {
                        id,
                        password: pass
                    }).then(response => {
                        if (response.code === 200) {
                            Swal.fire({
                                icon: response.message,
                                title: "data updated successfully!!!",
                            });
                            setTimeout(function () {
                                window.location.reload(1);
                            }, 2000);
                        }
                    }).catch(error => {
                        Swal.fire(error.name, error.message, 'error');
                    })
                } else {
                    Swal.fire("Opss!!!", "Password tidak sama", 'error');
                }
            },
        }
    )
}