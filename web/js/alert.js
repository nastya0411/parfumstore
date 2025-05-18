function showAlert(message) {
    $('.alert-count').remove();

    $('body').append(
        `<div class="alert alert-danger alert-count" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999;">` +
        message +
        `</div>`
    );

    setTimeout(() => {
        $('.alert-count').fadeIn(1500)
    }, 100);

    setTimeout(() => {
        $('.alert-count').fadeOut(1000, () => {
            $('.alert-count').remove();
        });
    }, 3000);
}