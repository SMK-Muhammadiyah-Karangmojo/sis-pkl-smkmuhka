function register() {
    Swal.fire({
        title: 'Registration Form',
        html: `
            <div>
                <select id="role" name="role" class="swal2-select">
                    <option value="">-- Pilih status --</option>
                    <option value="3">Siswa</option>
                    <option value="2">Guru</option>
                </select>
                <input type="text" id="email" name="email" class="swal2-input" placeholder="Email">
                <input type="password" id="password" name="password" class="swal2-input" placeholder="Password minimal 6 karakter">
                <input type="password" id="confpassword" name="confpassword" class="swal2-input" placeholder="Ulangi Password">
            </div>`,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Register',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const role = Swal.getPopup().querySelector('#role').value
            const email = Swal.getPopup().querySelector('#email').value
            const password = Swal.getPopup().querySelector('#password').value
            const confpassword = Swal.getPopup().querySelector('#confpassword').value

            if (!role) {
                Swal.showValidationMessage(`Kolom status masih kosong!`)
            } else if (!email || !password) {
                Swal.showValidationMessage(`Email dan password tidak boleh kosong`)
            } else if (password !== confpassword) {
                Swal.showValidationMessage(`Password tidak sama!!! Silahkan cek kembali`)
            } else {
                let data = {email: email};
                fetchingData("/User/getUserByEmail", data)
                    .then(response => {
                        if (response.code === 200) {
                            Swal.fire({
                                icon: "error",
                                title: 'Email ' + response.result.email + ' sudah terdaftar!!!',
                                text: "Silahkan menggunakan email lainnya"
                            });
                        } else {
                            fetchingData("/User/addUser", {
                                role: role,
                                email: email,
                                password: password,
                                isActive: 1
                            }).then(response => {
                                console.log(response)
                                if (response.code === 200) {
                                    Swal.fire({
                                        icon: "success",
                                        title: "Register successfully!!!",
                                    });
                                    setTimeout(function () {
                                        window.location.reload(1);
                                    }, 3000);
                                }
                            })
                        }
                    })
            }
        },
        allowOutsideClick: () => !Swal.isLoading(),
    })
}

