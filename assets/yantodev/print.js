async function getAllIdukaByMajor(value) {
    let data = await dataModal(value)
    console.log(data)
    await fetchingData('/Iduka/findAllIdukaByMajorAndTp', data)
        .then(response => {
            console.log(response)
            if (response.responseData.responseCode === 200) {
                mappingDataModal(value, response);
            }
        })
        .catch(error => {
            Swal.fire({
                icon: "error",
                title: "print data is not successfully!!!",
                text: error
            })
        });
}

async function getAllIdukaByTp() {
    await fetchingData('/Iduka/findAllIdukaByMajorAndTp',
        {
            tp: document.getElementById("tp").value,
            major: document.getElementById("major_id").value,
        })
        .then(response => {
            console.log(response)
            if (response.responseData.responseCode === 200) {
                let iduka = document.getElementById("iduka");
                let result;
                for (const element of response.result) {
                    result = "<option value=" + element.id + ">" + element.name + "</option>"
                    iduka.innerHTML += result
                }
            }
        })
        .catch(error => {
            Swal.fire({
                icon: "error",
                title: "print data is not successfully!!!",
                text: error
            })
        });
}

function findTeacherByTp() {
    fetchingData("/Teacher/findTeacherByTp", {
        tp: document.getElementById("tp_tugas").value
    }).then(response => {
        if (response.responseData.responseCode === 200) {
            let teacher = document.getElementById("teacher");
            let result;
            for (const element of response.result) {
                result = "<option value=" + element.user_public_id + ">" + element.name + "</option>"
                teacher.innerHTML += result
            }
        }
    }).catch(error => {
        console.log(error)
    })
}

async function dataModal(data) {
    switch (data) {
        case 'permohonan':
            return {
                major: document.getElementById("major_id").value,
                tp: document.getElementById("tp").value
            };
        case 'tugas':
            return {
                major: document.getElementById("major_id_tugas").value,
                tp: document.getElementById("tp_tugas").value
            };
        case 'pengantar':
            return {
                major: document.getElementById("major_id_pengantar").value,
                tp: document.getElementById("tp_pengantar").value
            };
        case 'kop':
            return {
                major: document.getElementById("major_id_kop").value,
                tp: document.getElementById("tp_kop").value
            };
        case 'surat_jalan':
            return {
                major: document.getElementById("major_id_surat_jalan").value,
                tp: document.getElementById("tp_surat_jalan").value
            };
        default:
            return {};
    }
}

function mappingDataModal(data, response) {
    if (data === 'permohonan') {
        let iduka = document.getElementById("iduka");
        let result;
        for (const element of response.result) {
            result = "<option value=" + element.id + ">" + element.name + "</option>"
            iduka.innerHTML += result
        }
    } else if (data === 'kop') {
        let iduka = document.getElementById("kop-surat-iduka");
        let result;
        for (const element of response.result) {
            result = "<option value=" + element.id + ">" + element.name + "</option>"
            iduka.innerHTML += result
        }
    } else {
        let iduka = document.getElementById("iduka_surat_jalan");
        let result;
        for (const element of response.result) {
            result = "<option value=" + element.id + ">" + element.name + "</option>"
            iduka.innerHTML += result
        }
    }
}