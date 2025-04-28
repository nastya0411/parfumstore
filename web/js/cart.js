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





//     const cartReload = () => {
//         $.pjax.reload('#cart-pjax', {
//             push: false,
//             timeout: 5000,
//         });
//     }


//     $('#catalog-pjax').on('click', '.btn-add-cart', function(e) {
//         e.preventDefault();
//         $.ajax({
//             url: $(this).attr('href'),
//             success(data) {
//                 if (data) {
//                     cartCountReload();
//                 }
//             }
//         })
//     })

//     $('#cart-pjax').on('click', '.btn-item-remove', function(e) {
//         e.preventDefault();
//         $.ajax({
//             url: $(this).attr('href'),
//             success(data) {
//                 if (data) {
//                     cartReload();
//                 }
//             }
//         })
//     })


//     $('#cart-pjax').on('click', '.btn-item-remove, .btn-item-add, .btn-item-del, .btn-cart-clear', function(e) {
//         e.preventDefault();
//         $.ajax({
//             url: $(this).attr('href'),
//             success(data) {
//                 if (data) {
//                     cartReload();
//                 }
//             }
//         })
//     })

    






//     $('#cart-pjax').on('pjax:end', () => cartCountReload())


//     cartCountReload();
// })