$(() => {

        const cartCountReload = () => {
        $.ajax({
            url: '/cart/count',
            method: "POST",
            success(data) {
                if (data.status) {
                    $('#cart-item-count').html(data.value)
                }
            }
        })
    }

    $('#catalog-pjax').on('click', '.btn-add-cart', function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            success(data) {
                if (data) {
                    cartCountReload();
                }
            }
        })
    })

    cartCountReload();
})
