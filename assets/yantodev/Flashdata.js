const flashError = $('.flash-data').data('flasherror');
const flashInfo = $('.flash-data').data('flashinfo');
const flashWarning = $('.flash-data').data('flashwarning');
const flashSuccess = $('.flash-data').data('flashsuccess');
const flashSuccessLogin = $('.flash-data').data('flashlogin');
const flashLogin = $('#flash-data').data('warning-login');

if (flashError) {
    Swal.fire({
        icon: "error",
        title: flashError,
        text: ""
    })
}
if (flashInfo) {
    Swal.fire({
        icon: "info",
        title: flashInfo,
        text: ""
    })
}
if (flashWarning) {
    Swal.fire({
        icon: "warning",
        title: flashWarning,
        text: ""
    })
}
if (flashSuccess) {
    Swal.fire({
        icon: "success",
        title: flashSuccess,
        text: ""
    })
}
if (flashSuccessLogin) {
    Swal.fire({
        icon: "success",
        title: 'Login berhasil!!!',
        text: "Welcome " + flashSuccessLogin
    })
}

