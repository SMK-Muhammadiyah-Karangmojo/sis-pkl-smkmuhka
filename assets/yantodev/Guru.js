function addGuru() {
    Swal.fire({
        title: "Tambah Guru",
        html: `
            <div>
                <input type="text" id="nbm" class="swal2-input" placeholder="NBM" >
                <input type="text" id="name" class="swal2-input" placeholder="Nama Lengkap dan gelar" >
                <input type="text" id="jabatan" class="swal2-input" placeholder="Jabatan" >
                <input type="text" id="hp" class="swal2-input" placeholder="NO HP" >
                <input type="text" id="email" class="swal2-input" placeholder="email" >
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Add",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            $.ajax({
                type: "POST",
                url: baseUrl + "/admin/addGuru",
                data: {
                    nbm: Swal.getPopup().querySelector("#nbm").value,
                    name: Swal.getPopup().querySelector("#name").value,
                    jabatan: Swal.getPopup().querySelector("#jabatan").value,
                    hp: Swal.getPopup().querySelector("#hp").value,
                    email: Swal.getPopup().querySelector("#email").value,
                },
                cache: false,
                dataType: "json",
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function () {
                },
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: "success",
                title: "data added successfully!!!",
            });
            setTimeout(function () {
                window.location.reload(1);
            }, 1000);
        }
    });
}

function updateGuru(id) {
    let nbm = document.getElementById("nbm").outerText;
    let name = document.getElementById("name").outerText;
    let jabatan = document.getElementById("jabatan").outerText;
    let hp = document.getElementById("hp").outerText;
    let email = document.getElementById("email").outerText;
    Swal.fire({
        title: "Edit Category",
        html: `
            <div>
                    <input type="hidden" id="id" class="swal2-input" placeholder="id" value="${id}">
                <div>
                    <input type="text" id="nbm" class="swal2-input" placeholder="nbm" value="${nbm}">
                </div>
                <div>
                    <input type="text" id="name" class="swal2-input" placeholder="name" value="${name}">
                </div>
                <div>
                    <input type="text" id="jabatan" class="swal2-input" placeholder="Jabatan" value="${jabatan}">
                </div>
                <div>
                    <input type="text" id="hp" class="swal2-input" placeholder="hp" value="${hp}">
                </div>
                <div>
                    <input type="text" id="email" class="swal2-input" placeholder="email" value="${email}">
                </div>
            </div>
                `,
        customClass: 'swal-wide',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Update",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const id = Swal.getPopup().querySelector("#id").value;
            $.ajax({
                type: "POST",
                url: baseUrl + "/admin/updateGuru/" + id,
                data: {
                    nbm: Swal.getPopup().querySelector("#nbm").value,
                    name: Swal.getPopup().querySelector("#name").value,
                    jabatan: Swal.getPopup().querySelector("#jabatan").value,
                    hp: Swal.getPopup().querySelector("#hp").value,
                    email: Swal.getPopup().querySelector("#email").value
                },
                cache: false,
                dataType: "json",
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function () {
                },
            });
        },
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: "success",
                title: "data updated successfully!!!",
            });
            setTimeout(function () {
                window.location.reload(1);
            }, 1000);
        }
    });
}

function deleteGuru(url, id) {
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
            fetchingData("/admin/deleteGuru/", {id: id}).then(response => {
                console.log(response)
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
            })
            setTimeout(function () {
                window.location.reload(1);
            }, 1000);
        }
    });
}