
function g_recaptcha_callback(response) {
    $('input[type="submit"]').prop('disabled', false);
}