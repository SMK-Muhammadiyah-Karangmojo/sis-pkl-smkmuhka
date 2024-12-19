function logout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You will exit this page and have to login again",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logged out it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetchingData('/auth/logout').then(response => {
                console.log(response)
            })
            Swal.fire({
                icon: 'success',
                title: 'Logout berhasil',
            })
            setTimeout(function () {
                window.location.reload(1);
            }, 3000);
        }
    })
}