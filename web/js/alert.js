$(() => {
  const showAlert = () => {
    setTimeout(() => {
      $(".alert-count").fadeIn(1500);
    }, 100);

    setTimeout(() => {
      $(".alert-count").fadeOut(2000);
    }, 3000);
  };

//   const cartCountReload = () => {
//     $.ajax({
//       url: "/shop/product/stars",
//       method: "POST",
//       success(data) {
//         if (data.status) {
//           $("#product-view-stars").html(data.value);
//         }
//       },
//     });
//   };

//   const cartReload = () => {
//     $.pjax.reload("#cart-pjax", {
//       push: false,
//       timeout: 5000,
//     });
//   };


  const startsAdd = (el) =>
    $.ajax({
      url: el.attr("href"),
      success(data) {
        if (data.success) {
          showAlert();
        } else {
            ''
        }
      }
    });

//   $(document).on(
//     "click",
//     "#catalog-pjax .btn-add-cart, #cart-pjax .btn-item-add, .btn-add-cart",
//     function (e) {
//       e.preventDefault();
//       productAdd($(this));
//       return false;
//     }
//   );

//   $("#catalog-pjax").on("click", ".product-card", function (e) {
//     if ($(e.target).hasClass("btn-add-cart")) {
//       e.preventDefault();
//       productAdd($(e.target));
//       return false;
//     }

//     location.assign($(this).data("url"));
//   });

//   $("#cart-pjax").on(
//     "click",
//     ".btn-item-remove, .btn-item-del, .btn-item-clear, .btn-cart-clear",
//     function (e) {
//       e.preventDefault();
//       $.ajax({
//         url: $(this).attr("href"),
//         success(data) {
//           if (data) {
//             cartReload();
//           }
//         },
//       });
//     }
//   );

  $("#cart-pjax").on("pjax:end", () => {
    cartCountReload();
    if ($(".alert-stars-empty").length) {
      $(".btn-stars-create").addClass("d-none");
    }
  });

  cartCountReload();
});
