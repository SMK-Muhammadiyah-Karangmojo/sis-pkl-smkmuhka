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