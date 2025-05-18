function showAlert(message) {
    $('.alert-count').remove();

    $('body').append(
        `<div class="alert alert-danger alert-count" style="display: none; position: fixed; top: 20px; right: 20px; z-index: 9999;">` +
        message +
        `</div>`
    );

    setTimeout(() => {
        $('.alert-count').fadeIn(1500);
    }, 100);

    setTimeout(() => {
        $('.alert-count').fadeOut(1000, () => {
            $('.alert-count').remove();
        });
    }, 3000);
}

$(() => {
  const cartCountReload = () => {
    $.ajax({
      url: "/shop/cart/count",
      method: "POST",
      success(data) {
        if (data.status) {
          $("#cart-item-count").html(data.value);
        }
      },
    });
  };


  const cartReload = () => {
    $.pjax.reload('#cart-pjax', {
      push: false,
      timeout: 5000,
    });
  }

  //   $("#catalog-pjax").on("click", ".btn-add-cart", function (e) {
  //     e.preventDefault();

  //   });


  // const productAdd = (el) => 
  //   $.ajax({
  //     url: el.attr("href"),
  //     success(data) {
  //       if (data) {
  //         cartCountReload();
  //       }
  //     },
  //   });


  const productAdd = (el) =>
    $.ajax({
      url: el.attr("href"),
      success(data) {
        if (data.success) {
          cartCountReload();
        } else {
          showAlert('Максимальное количество товара уже в корзине!');
        }
      },
      error(xhr, status, error) {
        console.error("Ошибка запроса:", status, error);
      },
    });

  $(document).on('click', '#catalog-pjax .btn-add-cart', function (e) {
    e.preventDefault();
    productAdd($(this));
    return false;
  });

  $("#catalog-pjax").on('click', ".product-card", function (e) {

    if ($(e.target).hasClass('btn-add-cart')) {
      e.preventDefault();
      productAdd($(e.target));
      return false;
    }

    location.assign($(this).data('url'))
  })



  $("#cart-pjax").on('click', ".btn-item-remove, .btn-item-add, .btn-item-del, .btn-item-clear, .btn-cart-clear", function (e) {
    e.preventDefault();
    $.ajax({
      url: $(this).attr('href'),
      success(data) {
        if (data) {
          cartReload();
        }
      }
    })
  })


  $("#cart-pjax").on('pjax:end', () => {
    cartCountReload();
    if ($(".alert-cart-empty").length) {
      $(".btn-order-create").addClass("d-none");
    }
  })

  cartCountReload();
});

