let baseUrl = window.location.origin;

async function fetchingData(url = '', data = {}) {
    return fetch(baseUrl + url, {
        method: 'POST',
        mode: 'cors',
        cache: 'no-cache',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        redirect: 'follow',
        referrerPolicy: 'no-referrer',
        body: data ? JSON.stringify(data) : ''
    }).then(response => {
        return response.json()
    }).catch(error => {
        return error
    })
}

function printTestAPI() {
    console.log("test")
}

function getJk(data) {
    if (data === "1") {
        return "Laki-laki";
    } else if (data === "2") {
        return "Perempuan";
    } else {
        return ""
    }
}

async function compressImage(file, maxWidth, maxHeight, quality) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = function (event) {
            const image = new Image();
            image.src = event.target.result;

            image.onload = function () {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');

                let width = image.width;
                let height = image.height;

                // Menghitung rasio aspek gambar
                if (width > height) {
                    if (width > maxWidth) {
                        height *= maxWidth / width;
                        width = maxWidth;
                    }
                } else {
                    if (height > maxHeight) {
                        width *= maxHeight / height;
                        height = maxHeight;
                    }
                }

                canvas.width = width;
                canvas.height = height;

                // Menggambar gambar ke dalam canvas dengan kompresi
                context.drawImage(image, 0, 0, width, height);

                // Mengubah ke format base64
                const compressedBase64 = canvas.toDataURL('image/jpeg', quality / 100);

                resolve(compressedBase64); // Mengembalikan gambar terkompresi dalam format base64
            };

            image.onerror = function (error) {
                reject(error); // Jika terjadi kesalahan dalam memuat gambar
            };
        };

        reader.onerror = function (error) {
            reject(error); // Jika terjadi kesalahan saat membaca file
        };

        reader.readAsDataURL(file); // Membaca file sebagai data URL
    });
}

function base64ToBlob(base64String, contentType = 'image/jpeg') {
    const byteCharacters = atob(base64String.split(',')[1]);
    const byteNumbers = new Array(byteCharacters.length);

    for (let i = 0; i < byteCharacters.length; i++) {
        byteNumbers[i] = byteCharacters.charCodeAt(i);
    }

    const byteArray = new Uint8Array(byteNumbers);
    return new Blob([byteArray], { type: contentType });
}