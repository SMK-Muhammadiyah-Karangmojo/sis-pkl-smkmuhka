async function updateNomorSurat(id) {
    let tp = await findTp()
    let category = await findAllCategory()
    let data = await findNomorSuratById(id)
    Swal.fire({
        title: "Edit Nomor Surat",
        html: `
            <div id="label-swal">
                <div class="form-group">
                    <label for="tp">Tahun Pelajaran</label>
                    <select class="form-control" name="tp" id="tp">
                        <option value="${data.tpId}">${data.tpName}</option>
                        ${tp}
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Kategory Surat</label>
                    <select class="form-control" name="category" id="category">
                        <option value="${data.categoryId}">${data.kategori}</option>
                        ${category}
                    </select>
                </div>
                <div class="form-group">
                    <label for="nomor">Nomor Surat</label>
                    <input class="form-control" type="text" id="nomor" placeholder="Nomor Surat" value="${data.nomor}">
                </div>   
                <div class="form-group">
                    <label for="tgl">Tanggal Surat</label>
                    <input class="form-control" type="date" id="tgl" placeholder="Tanggal Surat" value="${data.tanggal}">
                </div>              
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Update",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            fetchingData('/Admin/nomor', {
                id,
                tp: Swal.getPopup().querySelector("#tp").value,
                category: Swal.getPopup().querySelector("#category").value,
                nomor: Swal.getPopup().querySelector("#nomor").value,
                tgl: Swal.getPopup().querySelector("#tgl").value
            }).then(response => {
                console.log(response)
                if (response.responseData.responseCode === 200) {
                    Swal.fire({
                        icon: "success",
                        title: "Update data successfully!!!"
                    })
                    setTimeout(function () {
                        window.location.reload(1);
                    }, 2000);
                }
            }).catch(error => {
                console.log(error)
            })
        }
    })
}

function deleteNomorSurat(id) {
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
            fetchingData("/Admin/deleteNomor", {id})
                .then(response => {
                    Swal.fire("Deleted!", "Your file has been deleted is.", "success");
                })
            setTimeout(function () {
                window.location.reload(1);
            }, 2000);
        }
    });
}

async function findNomorSuratById(id) {
    let result;
    await fetchingData('/Admin/nomor', {id})
        .then(async response => {
            result = await response.result;
        })
        .then(error => {
            console.log(error)
        })
    return result;
}