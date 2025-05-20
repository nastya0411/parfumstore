// $(() => {
//   $("#product-user_stars").on("rating:change", function (event, value) {
//     const parent = $(this).parents(".field-product-user_stars");

//     $.ajax({
//       url: parent.data("url"),
//       method: "POST",
//       data: { stars: value },
//       dataType: "json",
//       success(data) {
//         if (data) {
//             $('.alert-stars').removeClass('d-none')
//             $("#product-user_stars").set_ReadOnly(true);
//             parent.children(".rating-container").addClass("rating-disabled");
//         }
//       },
//     });
//   });
// });

$(() => {
  $("#product-user_stars").on("rating:change", function (event, value) {
    const parent = $(this).parents(".field-product-user_stars");

    $.ajax({
      url: parent.data("url"),
      method: "POST",
      data: { stars: value },
      dataType: "json",
      success(data) {
        if (data) {
          $(".alert-stars").removeClass("d-none");
          $("#product-user_stars").rating("update", value).rating("refresh", {
            readonly: true,
            showClear: false,
            hoverEnabled: false,
          });
          parent.children(".rating-container").addClass("rating-disabled");
        }
      },
    });
  });

  $("#productTop8").on("click", ".product-card", function (e) {
    e.preventDefault();
    location.assign($(this).data("url"));
  });
});
